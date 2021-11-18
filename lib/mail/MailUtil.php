<?php

require_once __DIR__ . '/PHPMailer.php';
require_once __DIR__ . '/SMTP.php';
require_once __DIR__ . '/Exception.php';

MailUtil::send('aa', 'body');

class MailUtil
{
    public static function send($subject, $body, $attachement = '')
    {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        // $mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'ssl://smtp.exmail.qq.com';                     //Set the SMTP server to send through
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->CharSet = "UTF-8";                                   //字符集
        $mail->Encoding = "base64";                                 //编码方式
        $mail->Username   = 'data-notify@';                     //SMTP username
        $mail->Password   = '111';                               //SMTP password
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    
        //Recipients
        $mail->setFrom('data-notify@', 'data-notify');
        $mail->addAddress('tianchida@', 'data-notify');     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');
    
        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject; //'Here is the subject';
        $mail->Body    = $body; //'This is the HTML message body <b>in bold!</b>';
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
    }
}