<?php
require '_common.php';

$idx = $_POST['company_idx'];

$cdata = mysql_fetch_array(mysql_query("SELECT `company_id` FROM `company`
										WHERE `idx` = '{$idx}'"));
$company_id = $cdata['company_id'];

if($_SESSION['lang'] == 'en'){
	$err_msg = "This program can not be deleted.";
	$lang_msg = "The program has been deleted.";
}else{
	$err_msg = "해당 프로그램은 삭제할 수 없습니다.";
	$lang_msg = "프로그램이 삭제되었습니다.";
}

if($_SESSION['company'] == $company_id){
		$_SESSION['company'] = 'dankook';
		$_SESSIOn['lang'] = 'ko';
}


if($company_id == 'dankook'){
	msg($err_msg);
	req_move("manage_company");
	exit();
}else{

	mysql_query("DELETE FROM `company` WHERE `idx` = '{$idx}'");
	mysql_query("DELETE FROM `board` WHERE `company_id` = '{$company_id}'");
	mysql_query("DELETE FROM `article` WHERE `company_id` = '{$company_id}'");
	mysql_query("DELETE FROM `curriculum_step` WHERE `company_id` = '{$company_id}'");

	msg($lang_msg);

	req_move("manage_company");
}
?>
