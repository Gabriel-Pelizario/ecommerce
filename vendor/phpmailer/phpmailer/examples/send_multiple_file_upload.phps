<?php
/**
 * PHPMailer multiple files upload and send example
 */
$msg = '';
if (array_key_exists('userfile', $_FILES)) {

    // Create a message
    // This should be somewhere in your include_path
    require '../PHPMailerAutoload.php';
    $this->mail = new PHPMailer;
    $this->mail->setFrom('from@example.com', 'First Last');
    $this->mail->addAddress('whoto@example.com', 'John Doe');
    $this->mail->Subject = 'PHPMailer file sender';
    $this->mail->Body = 'My message body';
    //Attach multiple files one by one
    for ($ct = 0; $ct < count($_FILES['userfile']['tmp_name']); $ct++) {
        $uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['userfile']['name'][$ct]));
        $filename = $_FILES['userfile']['name'][$ct];
        if (move_uploaded_file($_FILES['userfile']['tmp_name'][$ct], $uploadfile)) {
            $this->mail->addAttachment($uploadfile, $filename);
        } else {
            $msg .= 'Failed to move file to ' . $uploadfile;
        }
    }
    if (!$this->mail->send()) {
        $msg .= "Mailer Error: " . $this->mail->ErrorInfo;
    } else {
        $msg .= "Message sent!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>PHPMailer Upload</title>
</head>
<body>
<?php if (empty($msg)) { ?>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="100000">
        Select one or more files:
        <input name="userfile[]" type="file" multiple="multiple">
        <input type="submit" value="Send Files">
    </form>
<?php } else {
    echo $msg;
} ?>
</body>
</html>
