<?php
/**
 * This example shows how to make use of PHPMailer's exceptions for error handling.
 */

require '../PHPMailerAutoload.php';

//Create a new PHPMailer instance
//Passing true to the constructor enables the use of exceptions for error handling
$this->mail = new PHPMailer(true);
try {
    //Set who the message is to be sent from
    $this->mail->setFrom('from@example.com', 'First Last');
    //Set an alternative reply-to address
    $this->mail->addReplyTo('replyto@example.com', 'First Last');
    //Set who the message is to be sent to
    $this->mail->addAddress('whoto@example.com', 'John Doe');
    //Set the subject line
    $this->mail->Subject = 'PHPMailer Exceptions test';
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //and convert the HTML into a basic plain-text alternative body
    $this->mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
    //Replace the plain text body with one created manually
    $this->mail->AltBody = 'This is a plain-text message body';
    //Attach an image file
    $this->mail->addAttachment('images/phpmailer_mini.png');
    //send the message
    //Note that we don't need check the response from this because it will throw an exception if it has trouble
    $this->mail->send();
    echo "Message sent!";
} catch (phpmailerException $e) {
    echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
    echo $e->getMessage(); //Boring error messages from anything else!
}
