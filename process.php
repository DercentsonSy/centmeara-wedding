<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include Composer's autoloader
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Enable error logging but hide errors from being displayed
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', 'C:\xampp\htdocs\wedding-master\php_errors.log'); // Update the path as needed

    // Sanitize user input
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);

    // Gmail SMTP configuration
    $smtpHost = 'smtp.gmail.com';
    $smtpPort = 587; // TLS port
    $username = 'dercentsonsy@gmail.com'; // Your Gmail address
    $password = 'cvkh fyyk mbkw buhs';   // Your Gmail App Password

    // Email subject and body
    $subject = 'New RSVP Notification';
    $messageBody = "You have a new RSVP:\n\nName: $name\nEmail: $email";

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = $smtpHost;
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $smtpPort;

        // Enable Debugging
        $mail->SMTPDebug = 2; // Debug level 2 for detailed information
        $mail->Debugoutput = 'html'; // Output in HTML format

        // Email headers
        $mail->setFrom($username, 'Wedding RSVP'); // From email and name
        $mail->addReplyTo($email, $name);         // Reply-to address
        
        // Add multiple recipients
        $recipients = ['dercentsonsy@gmail.com', 'mearaabiog@gmail.com'];
        foreach ($recipients as $recipient) {
            $mail->addAddress($recipient);
        }

        // Email content
        $mail->Subject = $subject;
        $mail->Body = $messageBody;

        // Send email
        $mail->send();
        echo "<script>alert('Thank you for your response! We are expecting you to attend the wedding.'); window.location.href = 'index.php';</script>";
    } catch (Exception $e) {
        error_log("Email Sending Error: {$mail->ErrorInfo}");
        echo "<script>alert('Failed to send email. Please try again later.'); window.location.href = 'index.php';</script>";
    }
}
?>
