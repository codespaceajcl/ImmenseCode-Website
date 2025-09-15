<?php
header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Helper function to sanitize and trim
function clean($value) {
    return trim(strip_tags($value));
}

// Collect and sanitize input
$name    = isset($_POST['name'])    ? clean($_POST['name'])    : '';
$email   = isset($_POST['email'])   ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
$number  = isset($_POST['number'])  ? clean($_POST['number'])  : '';
$subject = isset($_POST['subject']) ? clean($_POST['subject']) : '';
$message = isset($_POST['message']) ? clean($_POST['message']) : '';

// Check for empty or whitespace-only fields
if (
    $name === '' ||
    $email === '' ||
    $number === '' ||
    $subject === '' ||
    $message === ''
) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}

// Email settings
$to = 'ali.syed@immensecode.ai'; // Change to your desired recipient
$email_subject = "Contact Form: $subject";
$email_body = "Name: $name\nEmail: $email\nPhone: $number\nSubject: $subject\nMessage:\n$message";
$headers = "From: $name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";

// Send email
if (mail($to, $email_subject, $email_body, $headers)) {
    echo json_encode(['success' => true, 'message' => 'Thank you! Your message has been sent.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Sorry, your message could not be sent.']);
}
?>
