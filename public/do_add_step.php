<?php
require '_common.php';

$step_seq		=	$_POST['step_seq'];
$step_name		=	$_POST['step_name'];
$start_date		=	$_POST['start_date'];
$end_date		=	$_POST['end_date'];
$step_explain	=	$_POST['step_explain'];
$bm_link		=	$_POST['bm_link'];
$company_id = $_SESSION['company'];
$check_arr = ['step_seq', 'step_name', 'start_date', 'end_date', 'step_explain'];

for($i = 0; $i < sizeof($check_arr); $i++){

	if(strlen($_POST[$check_arr[$i]]) == 0){
		msg($check_arr[$i]."�� �Է��ϼ���");
		back();
		exit();
	}
}
$bm_link = ($bm_link=="on")?'1':'0';
$result = mysql_query("INSERT INTO  `curriculum_step`(
						`step_seq` ,
						`step_name` ,
						`start_date` ,
						`end_date` ,
						`step_explain` ,
						`bm_link`,
						`company_id`
						)
						VALUES (
						'$step_seq',  '$step_name',  '$start_date',  '$end_date', '$step_explain', '$bm_link', '$company_id'
						);
						");

req_redirect_js("manage_step");
