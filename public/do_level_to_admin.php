<?php
require '_common.php';
if($_GET['user_idx']){
  $user_idx = mysql_escape_string($_GET['user_idx']);
  $level = $_GET['level'];

  $msg = "가입 승인이 완료되었습니다.";
  $subject = "SBE CENTER 가입이 승인되었습니다.";
  $body = "환영합니다!";

  $user_id = $_GET['user_idx'];
    $qs = mysql_query("SELECT `user`.`email`
               FROM `user`
               WHERE `user`.`idx` = $user_id
               ORDER BY `user`.`idx`");

    date_default_timezone_set('Etc/UTC');
    require '../librarys/PHPMailerAutoload.php';
    //Create a new PHPMailer instance

    $mail = new PHPMailer;

    $mail->CharSet = "EUC-KR";
    $mail->Encoding = "base64";
    
    $mail->isSMTP();

    $mail->SMTPDebug = 0;

    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;

    $mail->SMTPSecure = 'tls';

    $mail->SMTPAuth = true;

    $mail->Username = "sbecenterformail@gmail.com";

    $mail->Password = "frog0704";

    $mail->setFrom('from@example.com', 'SBE CENTER');

    $mail->addReplyTo('replyto@example.com', 'SBE CENTER');

    while($row = mysql_fetch_array($qs))
    {
        $mail->addAddress($row['email']);
    }
    
    $mail->Subject = iconv("UTF-8" , "EUC-KR" , $subject);

    //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

    $mail->Body = iconv("UTF-8" , "EUC-KR" , $body);

    $mail->send();
    
  $url = "manage_user_tools?company=".$_SESSION['company'];
}else{
  $user_idx = mysql_escape_string($_POST['user_idx']);
  $level = $_POST['level'];

  $mquery = mysql_query("SELECT `description` FROM `level` WHERE `level` = '{$level}'");
  $res = mysql_fetch_array($mquery);

  $msg = $res['description']."(으)로 지정되었습니다.";
  $url = "userpage?id={$user_idx}";
}

mysql_query("UPDATE `user` SET `level` = '{$level}' where `user`.`idx` = $user_idx;");

msg($msg);
req_move($url);
?>
