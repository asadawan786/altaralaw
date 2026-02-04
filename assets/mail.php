<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configuration
    $to = "info@altaralaw.com, asad.aslam@altrasocial.com, asadali52pk@gmail.com";
    $subject = "New Lead/Inquiry from Altara Law Website";
    
    // Get form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $company = htmlspecialchars(trim($_POST['company']));
    $employee_count = htmlspecialchars(trim($_POST['employee_count']));
    $service_type = htmlspecialchars(trim($_POST['service_type']));
    $message = htmlspecialchars(trim($_POST['message']));
    $source = "Altara Law Website Contact Form";
    $date = date("F j, Y, g:i a");
    
    // Validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (!empty($errors)) {
        echo json_encode(["status" => "error", "message" => implode("<br>", $errors)]);
        exit;
    }
    
    // HTML Email Template
    $html_message = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>New Lead from Altara Law</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #1F3130; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
            .content { background-color: #f9f9f9; padding: 30px; border: 1px solid #ddd; border-top: none; border-radius: 0 0 5px 5px; }
            .lead-info { background-color: white; padding: 20px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #D4AF37; }
            .info-item { margin-bottom: 10px; }
            .label { font-weight: bold; color: #1F3130; }
            .highlight { background-color: #e8f4fc; padding: 15px; border-radius: 5px; margin: 15px 0; }
            .footer { text-align: center; color: #666; font-size: 12px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; }
            .urgency { background-color: #fff3cd; padding: 10px; border-radius: 3px; border-left: 4px solid #ffc107; }
            .logo { max-width: 200px; margin-bottom: 20px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2 style='margin: 0;'>🚀 New Lead Generated</h2>
                <p style='margin: 5px 0 0 0; opacity: 0.9;'>Altara Law Services</p>
            </div>
            
            <div class='content'>
                <div class='lead-info'>
                    <h3 style='color: #1F3130; margin-top: 0; border-bottom: 2px solid #D4AF37; padding-bottom: 10px;'>Lead Information</h3>
                    
                    <div class='info-item'>
                        <span class='label'>📅 Date & Time:</span> $date
                    </div>
                    
                    <div class='info-item'>
                        <span class='label'>👤 Contact Person:</span> $name
                    </div>
                    
                    <div class='info-item'>
                        <span class='label'>📧 Email Address:</span> <a href='mailto:$email'>$email</a>
                    </div>";
    
    if (!empty($phone)) {
        $html_message .= "
                    <div class='info-item'>
                        <span class='label'>📞 Phone Number:</span> <a href='tel:$phone'>$phone</a>
                    </div>";
    }
    
    if (!empty($company)) {
        $html_message .= "
                    <div class='info-item'>
                        <span class='label'>🏢 Company:</span> $company
                    </div>";
    }
    
    if (!empty($employee_count)) {
        $html_message .= "
                    <div class='info-item'>
                        <span class='label'>👥 Employee Count:</span> $employee_count
                    </div>";
    }
    
    if (!empty($service_type)) {
        $html_message .= "
                    <div class='info-item'>
                        <span class='label'>🎯 Service Interest:</span> <strong style='color: #D4AF37;'>$service_type</strong>
                    </div>";
    }
    
    $html_message .= "
                </div>
                
                <div class='highlight'>
                    <h4 style='color: #1F3130; margin-top: 0;'>📝 Inquiry Message:</h4>
                    <p style='background-color: white; padding: 15px; border-radius: 5px;'>" . nl2br($message) . "</p>
                </div>
                
                <div class='info-item'>
                    <span class='label'>🌐 Source:</span> $source
                </div>
                
                <div style='margin-top: 25px; padding: 15px; background-color: #e8f5e9; border-radius: 5px; border-left: 4px solid #4CAF50;'>
                    <h4 style='margin: 0 0 10px 0; color: #2E7D32;'>💡 Quick Actions:</h4>
                    <ul style='margin: 0;'>
                        <li>Reply to: <a href='mailto:$email'>$email</a></li>
                        <li>Add to CRM as a hot lead</li>
                        <li>Follow up within 24 hours</li>
                    </ul>
                </div>
            </div>
            
            <div class='footer'>
                <p>This email was generated automatically from the Altara Law contact form.</p>
                <p>📍 Cloud Spaces Fountain Views, Dubai Mall, Dubai, UAE | 📞 +971 56 189 2379</p>
            </div>
        </div>
    </body>
    </html>";
    
    // Plain text version for non-HTML email clients
    $plain_message = "NEW LEAD FROM Altara Law WEBSITE\n";
    $plain_message .= "========================================\n\n";
    $plain_message .= "Date & Time: $date\n";
    $plain_message .= "Contact Person: $name\n";
    $plain_message .= "Email: $email\n";
    if (!empty($phone)) $plain_message .= "Phone: $phone\n";
    if (!empty($company)) $plain_message .= "Company: $company\n";
    if (!empty($employee_count)) $plain_message .= "Employee Count: $employee_count\n";
    if (!empty($service_type)) $plain_message .= "Service Interest: $service_type\n\n";
    $plain_message .= "Message:\n$message\n\n";
    $plain_message .= "Source: $source\n";
    $plain_message .= "========================================\n";
    $plain_message .= "Altara Law Services\n";
    $plain_message .= "Cloud Spaces Fountain Views, Dubai Mall, Dubai, UAE\n";
    $plain_message .= "Tel: +971 56 189 2379\n";
    
    // Email headers
    $headers = "From: Altara Law Website <noreply@altaralaw.com>\r\n";
    $headers .= "Reply-To: $name <$email>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Additional headers for tracking
    $headers .= "\r\nX-Priority: 1 (Highest)";
    $headers .= "\r\nX-MSMail-Priority: High";
    $headers .= "\r\nImportance: High";
    
    // Send email
    if (mail($to, $subject, $html_message, $headers)) {
        // Send auto-reply to the user
        $user_subject = "Thank you for contacting Altara Law Services";
        $user_message = "
        Dear $name,
        
        Thank you for reaching out to Altara Law Services!
        
        We have received your inquiry and one of our Law Specialists will contact you within 24-48 hours to discuss how we can assist you with your Legal needs in the UAE.
        
        Here's a summary of your inquiry:
        - Name: $name
        - Email: $email
        " . (!empty($phone) ? "- Phone: $phone\n" : "") . 
        (!empty($company) ? "- Company: $company\n" : "") .
        (!empty($service_type) ? "- Service Interest: $service_type\n" : "") . "
        
        Best regards,
        Altara Law Team
        
        📍 Cloud Spaces Fountain Views, Dubai Mall, Dubai, UAE
        📞 +971 56 189 2379
        🌐 www.altaralaw.com";
        
        $user_headers = "From: Altara Law <info@altaralaw.com>\r\n";
        mail($email, $user_subject, $user_message, $user_headers);
        
        echo json_encode(["status" => "success", "message" => "Thank you! Your inquiry has been submitted successfully. We will contact you within 24-48 hours."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Sorry, there was an error sending your message. Please try again later or contact us directly at info@altaralaw.com"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>