<?php
require '_common.php';
$user_idx = mysql_escape_string($_POST['user_idx']);
$level = $_POST['level'];

mysql_query("UPDATE `user` SET `level` = '{$level}' where `user`.`idx` = $user_idx;");

$msg_query = mysql_query("SELECT `description` FROM `level` WHERE `level` = '{$level}'");
$msg = mysql_fetch_array($msg_query);

msg("{$msg['description']}(으)로 지정되었습니다.");

req_move("userpage?id={$user_idx}");
?>
