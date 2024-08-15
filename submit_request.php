<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define the bot token and chat ID
$botToken = "6873890387:AAHaalSMGpLC59bMTWevqNRmccEfr0tdvfE";
$chatId = "5429071679";

// Collect form data
$movieName = $_POST['movie_name'];
$year = !empty($_POST['year']) ? $_POST['year'] : 'N/A';
$type = $_POST['type'];
$language = $_POST['language'];
$quality = $_POST['quality'];

// Format the message
$message = "Movie request\n";
$message .= "Name: $movieName\n";
$message .= "Year: $year\n";
$message .= "Type: $type\n";
$message .= "Language: $language\n";
$message .= "Quality: $quality";

// Construct the URL for sending the message
$sendMessageUrl = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($message);

// Initialize cURL session
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $sendMessageUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute the request and capture the response
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
    curl_close($ch);
    exit; // Stop the script if there is an error
}

// Close the cURL session
curl_close($ch);

// Decode the JSON response to check if the message was sent successfully
$responseData = json_decode($response, true);

if ($responseData['ok']) {
    // Redirect to the success page if the message was sent successfully
    header("Location: success.html");
} else {
    // Display an error message if something went wrong
    echo 'Error: ' . $responseData['description'];
    exit;
}
?>
