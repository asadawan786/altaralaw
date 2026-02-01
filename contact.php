<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php'; // If using Composer
// OR use these lines if manually including PHPMailer:
// require 'path/to/PHPMailer/src/Exception.php';
// require 'path/to/PHPMailer/src/PHPMailer.php';
// require 'path/to/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $service = htmlspecialchars(trim($_POST['service']));
    $message = htmlspecialchars(trim($_POST['message']));
    
    // Your email settings
    $to_email = "asadali52pk@gmail.com";
    $subject = "New Contact Form Submission - Altara Law Dubai";
    
    // Create email body
    $email_body = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #1a365d; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; background-color: #f9f9f9; }
            .field { margin-bottom: 15px; }
            .field-label { font-weight: bold; color: #1a365d; }
            .footer { background-color: #f1f1f1; padding: 15px; text-align: center; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>New Contact Form Submission</h2>
                <p>Altara Law Dubai Website</p>
            </div>
            <div class='content'>
                <div class='field'>
                    <span class='field-label'>Name:</span><br>
                    $name
                </div>
                <div class='field'>
                    <span class='field-label'>Email:</span><br>
                    <a href='mailto:$email'>$email</a>
                </div>
                <div class='field'>
                    <span class='field-label'>Phone:</span><br>
                    $phone
                </div>
                <div class='field'>
                    <span class='field-label'>Service Interested In:</span><br>
                    $service
                </div>
                <div class='field'>
                    <span class='field-label'>Message:</span><br>
                    $message
                </div>
            </div>
            <div class='footer'>
                <p>This email was sent from the contact form on Altara Law Dubai website.</p>
                <p>Received on: " . date('Y-m-d H:i:s') . "</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Create plain text version
    $plain_body = "New Contact Form Submission\n\n";
    $plain_body .= "Name: $name\n";
    $plain_body .= "Email: $email\n";
    $plain_body .= "Phone: $phone\n";
    $plain_body .= "Service Interested In: $service\n";
    $plain_body .= "Message: $message\n\n";
    $plain_body .= "Received on: " . date('Y-m-d H:i:s');
    
    try {
        $mail = new PHPMailer(true);
        
        // Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'asadali52pk@gmail.com';                // SMTP username (your Gmail)
        $mail->Password   = 'your-app-password-here';               // SMTP password (App Password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
        $mail->Port       = 587;                                    // TCP port to connect to
        
        // Recipients
        $mail->setFrom('noreply@altaralaw.com', 'Altara Law Website');
        $mail->addAddress('asadali52pk@gmail.com', 'Asad Ali');
        $mail->addReplyTo($email, $name);
        
        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $email_body;
        $mail->AltBody = $plain_body;
        
        $mail->send();
        
        // Success response
        $response = array(
            'success' => true,
            'message' => 'Thank you! Your message has been sent successfully. We will contact you soon.'
        );
        
    } catch (Exception $e) {
        // Error response
        $response = array(
            'success' => false,
            'message' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo
        );
    }
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>