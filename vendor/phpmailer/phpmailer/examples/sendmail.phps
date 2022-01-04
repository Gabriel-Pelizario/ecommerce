<?php
/**
 * This example shows sending a message using a local sendmail binary.
 */

require '../PHPMailerAutoload.php';

//Create a new PHPMailer instance
$this->mail = new PHPMailer;
// Set PHPMailer to use the sendmail transport
$this->mail->isSendmail();
//Set who the message is to be sent from
$this->mail->setFrom('from@example.com', 'First Last');
//Set an alternative reply-to address
$this->mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$this->mail->addAddress('whoto@example.com', 'John Doe');
//Set the subject line
$this->mail->Subject = 'PHPMailer sendmail test';
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
