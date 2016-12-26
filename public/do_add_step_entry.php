<?php
require '_common.php';

$step_idx			=	$_GET['step_idx'];
$condition_article	=	$_GET['condition_article'];
$error_message		=	$_GET['error_message'];

$query = mysql_query("SELECT count(*) from curriculum_step where idx = $step_idx");

$step_count = mysql_fetch_array($query);

$query = mysql_query("SELECT count(*) from article where idx = $condition_article");

$article_count = mysql_fetch_array($query);

if($step_count[0] == 0){
	msg("존재하지 않는 스텝입니다.");
	back();	
	exit();
}

if($article_count[0] == 0){
	msg("존재하지 않는 과제입니다.");
	back();	
	exit();
}

$result = mysql_query("INSERT INTO  `step_entry`(
						`step_idx` ,
						`condition_article` ,
						`error_message`
						)
						VALUES (
						'$step_idx',  '$condition_article',  '$error_message'
						);
						");		
req_redirect_js("manage_step");