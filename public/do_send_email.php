<?php
require '_common.php';
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");
ini_set("mail.log", "/var/log/mail.log");

$mailto="ksh@mondaychicken.com";
$subject="mail test";
$content="test";
$headers = array("From: from@shalomtalk.kr",
    "Reply-To: no-reply@shalomtalk.kr",
    "X-Mailer: PHP/" . PHP_VERSION
);
$headers = implode("\r\n", $headers);
$result = mail($mailto, $subject, $content, $headers);

if ($result) {
    echo "mail success";
} else {
    echo "mail fail";
}

// return sendMail('test', ['sh.kang@ecubelabs.com'], 'sadasd', 'dasdasdasdasdas');