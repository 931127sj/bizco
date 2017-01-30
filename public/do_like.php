<?php
require '_common.php';
$idx = $_GET['idx'];
$user_idx = $_SESSION['idx'];
$count = mysql_query("SELECT *
						FROM  `like`
						WHERE  `user_idx` =$user_idx
						AND  `article_idx` =$idx");
if(mysql_fetch_array($count) >= 1) {

	// 좋아요삭제
	$rq = mysql_query("DELETE FROM `like` WHERE `article_idx` = '$idx' AND `user_idx` = '$user_idx'");

} else {
	// 좋아요삽입
	$rq = mysql_query("INSERT INTO  `like` (
						`idx` ,
						`user_idx` ,
						`article_idx`
						)
						VALUES (
						NULL ,  '$user_idx',  '$idx'
						);
						");
}

back();
