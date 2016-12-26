<?php
require '_common.php';

$step_idx		=	$_POST['step_idx'];
$step_seq		=	$_POST['step_seq'];
$step_name		=	$_POST['step_name'];
$start_date		=	$_POST['start_date'];
$end_date		=	$_POST['end_date'];
$step_explain	=	$_POST['step_explain'];
$bm_link		=	$_POST['bm_link'];
$bm_link = ($bm_link=="on")?'1':'0';
$check_arr = ['step_seq', 'step_name', 'start_date', 'end_date', 'step_explain'];

for($i = 0; $i < sizeof($check_arr); $i++){

	if(strlen($_POST[$check_arr[$i]]) == 0){
		msg($check_arr[$i]."을 입력하세요");
		back();	
		exit();
	}
}

$result = mysql_query("UPDATE  `curriculum_step` set step_seq = '$step_seq', step_name = '$step_name', start_date = '$start_date', end_date = '$end_date', step_explain = '$step_explain',bm_link = '$bm_link' where idx = $step_idx");

//echo $result;

req_redirect_js("manage_step");