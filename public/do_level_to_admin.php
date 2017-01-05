<?php
require '_common.php';
if($_GET['user_idx']){
  $user_idx = mysql_escape_string($_GET['user_idx']);
  $level = $_GET['level'];

  $msg = "가입 승인이 완료되었습니다.";
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
