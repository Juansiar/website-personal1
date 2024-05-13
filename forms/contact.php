<?php
/**
 * Requires the "PHP Email Form" library
 * The "PHP Email Form" library is available only in the pro version of the template
 * The library should be uploaded to: vendor/php-email-form/php-email-form.php
 * For more info and help: https://bootstrapmade.com/php-email-form/
 */

// Configuration
$receiving_email_address = 'www.christiansiar14@gmail.com';
$php_email_form_path = '../assets/vendor/php-email-form/php-email-form.php';

// Load the PHP Email Form library
if (!file_exists($php_email_form_path)) {
    throw new Exception('Unable to load the "PHP Email Form" Library!');
}
require_once $php_email_form_path;

// Create a new PHP Email Form instance
$contact = new PHP_Email_Form;
$contact->ajax = true;

// Set the recipient email address
$contact->to = $receiving_email_address;

// Validate and set the sender information
$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);

if (!$name ||!$email ||!$subject) {
    throw new Exception('Invalid input data');
}

$contact->from_name = $name;
$contact->from_email = $email;
$contact->subject = $subject;

// Add message fields
$contact->add_message($name, 'From');
$contact->add_message($email, 'Email');
$contact->add_message($_POST['message'], 'Message', 10);

// Send the email
try {
    $result = $contact->send();
    echo $result;
} catch (Exception $e) {
    // Log the error or display a user-friendly error message
    error_log($e->getMessage());
    echo 'Error sending email. Please try again later.';
}
?>
