<?php
require '_common.php';
$article_id = $_POST['article_id'];
$content = $_POST['content'];
$user_idx = $_SESSION['idx'];
$user_name = $_SESSION['name'];
$parent_idx = $_POST['parent_idx'];
$datetime = date("Y-m-d H:i:s",time());
$company_id = $_SESSION['company'];

if($_SESSION['lang'] == 'en'){
	$lang_msg = "Enter your comment";
}else{
	$lang_msg = "댓글을 입력하세요";
}

if($content == '') {
	msg("{$lang_msg}");
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
						`content`,
						`user_name`
						)
						VALUES (
						NULL ,  '$company_id',  '$article_id',  '$user_idx', '$parent_idx', 'discuss',  '$datetime',  '$content', '$user_name'
						);
						");

back();
