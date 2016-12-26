<?php
require '_common.php';

$comment_idx = $_POST['comment_idx'];
$content = $_POST['content'];

$result = mysql_query("UPDATE  `comment` set content = '$content' where idx = '$comment_idx'");

echo "success";

