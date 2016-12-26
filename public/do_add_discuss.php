<?php
require '_common.php';
$article_id = $_POST['article_id'];
$content = $_POST['content'];
$user_idx = $_SESSION['idx'];
$parent_idx = $_POST['parent_idx'];
$datetime = date("Y-m-d H:i:s",time());
if($content == '') {
	msg("댓글을 입력하세요");
	back();
	exit();
}

if(isset($_POST['parent_idx'])){
	$parent_idx = $_POST['parent_idx'];
}

$result = mysql_query("INSERT INTO  `comment` (
						`idx` ,
						`company_id` ,
						`article_idx` ,
						`user_idx` ,
						`parent_idx` ,
						`type` ,
						`datetime` ,
						`content`
						)
						VALUES (
						NULL ,  'dankook',  '$article_id',  '$user_idx', '$parent_idx', 'discuss',  '$datetime',  '$content'
						);
						");

back();