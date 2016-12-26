<?php
require '_common.php';
$user_idx = mysql_escape_string($_GET['user_idx']);

mysql_query("INSERT INTO `user` select `user_out`.* from `user_out` where `user_out`.`idx` = $user_idx;");
mysql_query("DELETE from `user_out` where `user_out`.`idx` = $user_idx;");

back();