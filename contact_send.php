<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$_SESSION['contact_data'] = [
    "name" => htmlspecialchars($_POST['name']),
    "email" => htmlspecialchars($_POST['email']),
    "message" => htmlspecialchars($_POST['message']),
];

/*
Save message locally (development mode)
*/
$logMessage = "==============================\n";
$logMessage .= "Date: " . date("Y-m-d H:i:s") . "\n";
$logMessage .= "Name: " . $_SESSION['contact_data']['name'] . "\n";
$logMessage .= "Email: " . $_SESSION['contact_data']['email'] . "\n";
$logMessage .= "Message:\n" . $_SESSION['contact_data']['message'] . "\n";
$logMessage .= "==============================\n\n";

file_put_contents("contact_messages.log", $logMessage, FILE_APPEND);

/*
Redirect to view page
*/
header("Location: contact_view.php");
exit;
?>