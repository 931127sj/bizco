<?php
require '_common.php';
$idx = $_GET['idx'];
$company_id = $_SESSION['company'];

if($_SESSION['lang'] == 'en'){
	$err_videos = "Please watch all videos.";
	$err_discuss = "You must complete at least one comment to complete the assignment.";
	$lang_msg = "Completed the assignment!";
}else{
	$err_videos = "동영상을 모두 시청해주세요.";
	$err_discuss = "의견을 1개 이상 작성해야 과제를 완료할 수 있습니다.";
	$lang_msg = "과제를 완료했습니다!";
}

// 동영상 시청확인
$article = mysql_query("SELECT *
FROM  `article`
WHERE  `idx` =$idx");
$article_data = mysql_fetch_array($article);

$youtube_time = $article_data['youtube_duration_sec'];

$homework = mysql_query("SELECT *
FROM  `homework_progress`
WHERE  `user_idx` =".$_SESSION['idx']."
AND  `article_idx` =$idx");
//var_dump($youtube_time);

$homework_data = mysql_fetch_array($homework);
$honework_time = $homework_data['complete_sec'];
//var_dump($honework_time);

//과제완료시
if(($honework_time + 5) < $youtube_time) {
	msg($err_videos);
	back();
	exit();
}

// 댓글작성 확인
$comment = mysql_query("SELECT *
FROM  `comment`
WHERE  `company_id` =  '{$company_id}'
AND  `article_idx` ='{$idx}'
AND  `user_idx` =".$_SESSION['idx']);
$comment_count = mysql_num_rows($comment);

if($comment_count > 0) {

	mysql_query("INSERT INTO  `homework` (
	`idx` ,
	`user_idx` ,
	`article_idx` ,
	`state` ,
	`detail_state`
	)
	VALUES (
	NULL ,  '".$_SESSION['idx']."',  '$idx',  '1',  ''
	);");
	msg($lang_msg);
	req_redirect_js("cur_step");
} else {
	msg($err_discuss);
	back();
}
