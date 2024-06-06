<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

if(isset($_POST['send'])){
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = getenv('EMAIL_USERNAME');
    $mail->Password = getenv('EMAIL_PASSWORD');
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->isHTML(true);
    $mail->setFrom($email,$name);
    $mail->addAddress('email@gmail.com');

    $mail->Subject = "New Message from Contact Form";
    $mail->Body = $message;

    try {
        $mail->send();
        echo
            "
            <script>alert('Message sent successfully!');
document.location.href='contact.php';
</script>
            ";
    } catch (Exception $e) {
        echo 'Unable to send the message. Please try again later. Error: ' . $mail->ErrorInfo;
    }
}


?>
