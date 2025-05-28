<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

function send_verification($fullname, $email, $otp) {
    $mail = new PHPMailer(true); // Passing true enables exceptions
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'angelalequigan@gmail.com'; // Your hotel's email
        $mail->Password = 'cajl ljkk vpet emnm'; // App password (not regular password)
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        // Recipients
        $mail->setFrom('yourhotelemail@gmail.com', 'The Bloom & Belle Hotel');
        $mail->addAddress($email, $fullname);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Account - The Bloom & Belle Hotel';
        $mail->Body = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <h2 style="color: #4a929e;">Welcome to The Bloom & Belle Hotel!</h2>
                <p>Dear ' . htmlspecialchars($fullname) . ',</p>
                <p>Thank you for creating an account with us. Please use the following OTP to verify your email address:</p>
                
                <div style="background: #f5f5f5; padding: 20px; text-align: center; margin: 20px 0;">
                    <h3 style="margin: 0; color: #202e53; font-size: 24px;">' . $otp . '</h3>
                </div>
                
                <p>This code will expire in 15 minutes. If you didn\'t request this, please ignore this email.</p>
                <p>Best regards,<br>The Bloom & Belle Hotel Team</p>
                
                <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; font-size: 12px; color: #777;">
                    <p>© ' . date('Y') . ' The Bloom & Belle Hotel. All rights reserved.</p>
                </div>
            </div>
        ';

        $mail->AltBody = "Welcome to The Bloom & Belle Hotel!\n\nDear $fullname,\n\nYour verification code is: $otp\n\nThis code will expire in 15 minutes.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
?>
