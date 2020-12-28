<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'mailServer/vendor/autoload.php';

$mailSenderMessage = null;

function sendEmail($emailTo, $token, $type) // type = 0 recovery email, type = 1 confirmation email for registration
{
    $emailToSend = "";
    switch ($type) {
        case 0:
            $emailToSend = " 
                <html>
                    <head>
                    </head>

                    <body>
                        <h3> PASSWORD RECOVERY </h3>
                        <p> Click on the link to reset your password! </p>
                        <a href='http://localhost/passwordReset.php?token=$token'> reset password </a>
                        <p> Link valid for 10 minutes </p>
                    </body>

                </html>
                ";
            break;
        case 1:
            $emailToSend = " 
                <html>
                    <head>
                    </head>

                    <body>
                        <h3> COMPLETE YOUR REGISTRATION </h3>
                        <p> Click on the link to set your password! </p>
                        <a href='http://localhost/passwordReset.php?token=$token'> reset password </a>
                        <p> Link valid for 10 minutes </p>
                    </body>

                </html>
                ";
            break;
        default:
            die('Access denied for this type!');
    }


    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP(); // Send using SMTP
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = true;
        $mail->Username = 'pisazon.inc@gmail.com';
        $mail->Password = 'pisazonn';
        $mail->setFrom('pisazon.inc@gmail.com', 'Pisazon support');
        $mail->addAddress($emailTo, 'me');
        $mail->Subject = 'Pisazon password reset';
        $mail->msgHTML($emailToSend, __DIR__);
        $mail->AltBody = 'This is a plain-text message body';
        $mail->addAttachment('assets/images/logo.png');

        //send the message
        $mail->send();
    } catch (Exception $e) {
        global $mailSenderMessage;
        $mailSenderMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }

    return true;
}
