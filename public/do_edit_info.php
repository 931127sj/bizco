<?php
require '_common.php';

$team_id = $_POST['team_id'];
$join_type = $_POST['join_type'];
$part = $_POST['part'];
$history = $_POST['history'];
$skills = $_POST['skills'];
$progress = $_POST['progress'];
$business_resource = $_POST['business_resource'];




$result = mysql_query("UPDATE  `user` set team_id = '$team_id', join_type = '$join_type', part = '$part', progress = '$progress', business_resource = '$business_resource', history = '$history', skills = '$skills' where idx = '".$_SESSION['idx']."'");

echo "success";

