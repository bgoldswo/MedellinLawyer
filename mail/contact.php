<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if required fields are filled and email is valid
if(empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    // Send HTTP response code 500 and exit
    http_response_code(500);
    echo 'Invalid form data.';
    exit();
}

// Sanitize form input to prevent XSS and other potential security issues
$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$m_subject = strip_tags(htmlspecialchars($_POST['subject']));
$message = strip_tags(htmlspecialchars($_POST['message']));

// Email configuration
$to = "brad.tovar.co@gmail.com"; // Change this to your email
$subject = "$m_subject: $name";
$body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email\n\nSubject: $m_subject\n\nMessage: $message";
$header = "From: $email\r\n";
$header .= "Reply-To: $email\r\n";

// Try sending the email and check for errors
if(!mail($to, $subject, $body, $header)) {
    // If mail sending fails, send HTTP 500 and provide an error message
    http_response_code(500);
    echo 'Failed to send message. Please try again later.';
} else {
    // If mail is sent successfully, send an HTTP 200 success code
    http_response_code(200);
    echo 'Your message has been sent successfully!';
}
?>
