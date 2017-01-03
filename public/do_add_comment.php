<?php
require '_common.php';
$article_id = $_POST['article_id'];
$content = $_POST['content'];
$user_idx = $_SESSION['idx'];
$user_name = $_SESSION['name'];
$parent_idx = $_POST['comment_id'];
$datetime = date("Y-m-d H:i:s",time());
$company_id = $_SESSION['company'];

$to_user_idx = $_POST['to_user_idx'];
$to_user_query = mysql_query("SELECT `name` FROM `user` WHERE idx = {$to_user_idx}");
$to_user_data = mysql_fetch_array($to_user_query);
$to_user_name = $to_user_data['name'];

if($content == '') {
	msg("댓글을 입력하세요");
	back();
	exit();
}

$result = mysql_query("INSERT INTO  `comment` (
						`idx` ,
						`company_id` ,
						`article_idx` ,
						`user_idx` ,
						`parent_idx` ,
						`datetime` ,
						`content`,
						`user_name`
						)
						VALUES (
						NULL ,  '$company_id',  '$article_id',  '$user_idx', '$parent_idx',   '$datetime',  '$content', '$user_name'
						);
						");

$comment_idx = mysql_insert_id();

if($to_user_idx != $user_idx){
	mysql_query("INSERT INTO `user_alarm`(
		`to_user_idx`,
		`to_user_name`,
		`from_user_idx`,
		`from_user_name`,
		`type`,
		`article_idx`,
		`datetime`,
		`read_chk`
		)
		VALUES
		(
			'$to_user_idx', '$to_user_name', '$user_idx', '$user_name', 'comment', '$article_id', '$datetime', '1'
		);
		");
}

back();
?>
