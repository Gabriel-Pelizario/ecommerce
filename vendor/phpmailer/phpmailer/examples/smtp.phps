<?php
/**
 * This example shows making an SMTP connection with authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require '../PHPMailerAutoload.php';

//Create a new PHPMailer instance
$this->mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$this->mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$this->mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$this->mail->Debugoutput = 'html';
//Set the hostname of the mail server
$this->mail->Host = "mail.example.com";
//Set the SMTP port number - likely to be 25, 465 or 587
$this->mail->Port = 25;
//Whether to use SMTP authentication
$this->mail->SMTPAuth = true;
//Username to use for SMTP authentication
$this->mail->Username = "yourname@example.com";
//Password to use for SMTP authentication
$this->mail->Password = "yourpassword";
//Set who the message is to be sent from
$this->mail->setFrom('from@example.com', 'First Last');
//Set an alternative reply-to address
$this->mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$this->mail->addAddress('whoto@example.com', 'John Doe');
//Set the subject line
$this->mail->Subject = 'PHPMailer SMTP test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$this->mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$this->mail->AltBody = 'This is a plain-text message body';
//Attach an image file
$this->mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$this->mail->send()) {
    echo "Mailer Error: " . $this->mail->ErrorInfo;
} else {
    echo "Message sent!";
}
