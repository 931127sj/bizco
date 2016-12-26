<?php
require '_common.php';
$user_idx = mysql_escape_string($_GET['user_idx']);

$duser = mysql_fetch_array(mysql_query("select `name` from `user` where `user`.idx = {$user_idx}"));

mysql_query("INSERT INTO `user_out` select `user`.* from `user` where `user`.idx = $user_idx;");
mysql_query("DELETE from `user` where `user`.idx = $user_idx;");

msg("{$duser['name']} 님이 삭제되었습니다.");

back();

?>