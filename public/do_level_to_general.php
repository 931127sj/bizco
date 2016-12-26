<?php
require '_common.php';
$user_idx = mysql_escape_string($_GET['user_idx']);

mysql_query("UPDATE `user` SET `level` = '2' where `user`.`idx` = $user_idx;");

back();