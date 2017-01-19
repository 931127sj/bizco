<?php
<<<<<<< HEAD
    $title = $_POST['title'];
    $content = $_POST['content'];
    require '_common.php';

    $qs = mysql_query("SELECT `user`.`email`
                   FROM `user`
                   WHERE `user`.`level` < 7
                   ORDER BY `user`.`idx`");


    date_default_timezone_set('Etc/UTC');
    require '../librarys/PHPMailerAutoload.php';
    //Create a new PHPMailer instance

    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP

    $mail->isSMTP();

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    //$mail->SMTPDebug = 2;

    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';
    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6
    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;

    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';

    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = "sbecenterformail@gmail.com";

    //Password to use for SMTP authentication
    $mail->Password = "frog0704";

    //Set who the message is to be sent from
    $mail->setFrom('from@example.com', 'SBE CENTER');

    //Set an alternative reply-to address
    $mail->addReplyTo('replyto@example.com', 'SBE CENTER');

    //Set who the message is to be sent to
    while($row = mysql_fetch_array($qs))
    {
        $mail->addAddress($row['email']);
    }

    //Set the subject line
    $mail->Subject = $title;
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body

    $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

    //Replace the plain text body with one created manually
    $mail->Body = $content;

    //Attach an image file
    //$mail->addAttachment('images/phpmailer_mini.png');

    //send the message, check for errors

    if (!$mail->send()) {
        msg("메일을 보내는데 실패하였습니다." .$mail->ErrorInfo);
        back();
        exit();
    } else {
        msg("메일을 성공적으로 보냈습니다.");
        back();
        exit();
    }
=======
require '_common.php';
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");
ini_set("mail.log", "/var/log/mail.log");

$title = $_POST['title'];
$content = $_POST['content'];

$mailto="dragonsuperf@naver.com";
$subject="mail test";
//$content="test";
$headers = array("From: from@shalomtalk.kr",
    "Reply-To: no-reply@shalomtalk.kr",
    "X-Mailer: PHP/" . PHP_VERSION
);
$headers = implode("\r\n", $headers);
$result = mail($mailto, $title, $content, $headers);

if ($result) {
    echo "mail success";
} else {
    echo "mail fail";
}

// return sendMail('test', ['sh.kang@ecubelabs.com'], 'sadasd', 'dasdasdasdasdas');
>>>>>>> origin/master
