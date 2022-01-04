<?php

error_reporting(E_STRICT | E_ALL);

date_default_timezone_set('Etc/UTC');

require '../PHPMailerAutoload.php';

$this->mail = new PHPMailer;

$body = file_get_contents('contents.html');

$this->mail->isSMTP();
$this->mail->Host = 'smtp.example.com';
$this->mail->SMTPAuth = true;
$this->mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
$this->mail->Port = 25;
$this->mail->Username = 'yourname@example.com';
$this->mail->Password = 'yourpassword';
$this->mail->setFrom('list@example.com', 'List manager');
$this->mail->addReplyTo('list@example.com', 'List manager');

$this->mail->Subject = "PHPMailer Simple database mailing list test";

//Same body for all messages, so set this before the sending loop
//If you generate a different body for each recipient (e.g. you're using a templating system),
//set it inside the loop
$this->mail->msgHTML($body);
//msgHTML also sets AltBody, but if you want a custom one, set it afterwards
$this->mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

//Connect to the database and select the recipients from your mailing list that have not yet been sent to
//You'll need to alter this to match your database
$mysql = mysqli_connect('localhost', 'username', 'password');
mysqli_select_db($mysql, 'mydb');
$result = mysqli_query($mysql, 'SELECT full_name, email, photo FROM mailinglist WHERE sent = false');

foreach ($result as $row) { //This iterator syntax only works in PHP 5.4+
    $this->mail->addAddress($row['email'], $row['full_name']);
    if (!empty($row['photo'])) {
        $this->mail->addStringAttachment($row['photo'], 'YourPhoto.jpg'); //Assumes the image data is stored in the DB
    }

    if (!$this->mail->send()) {
        echo "Mailer Error (" . str_replace("@", "&#64;", $row["email"]) . ') ' . $this->mail->ErrorInfo . '<br />';
        break; //Abandon sending
    } else {
        echo "Message sent to :" . $row['full_name'] . ' (' . str_replace("@", "&#64;", $row['email']) . ')<br />';
        //Mark it as sent in the DB
        mysqli_query(
            $mysql,
            "UPDATE mailinglist SET sent = true WHERE email = '" .
            mysqli_real_escape_string($mysql, $row['email']) . "'"
        );
    }
    // Clear all addresses and attachments for next loop
    $this->mail->clearAddresses();
    $this->mail->clearAttachments();
}
