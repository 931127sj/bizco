<?php
require '_common.php';

$idx = $_POST['company_idx'];

$cdata = mysql_fetch_array(mysql_query("SELECT `company_id` FROM `company`
										WHERE `idx` = '{$idx}'"));
$company_id = $cdata['company_id'];

if($company_id == 'dankook'){
	msg("해당 프로그램은 삭제할 수 없습니다.");
	req_move("manage_company");
	exit();
}else{
	
	mysql_query("DELETE FROM `company` WHERE `idx` = '{$idx}'");
	mysql_query("DELETE FROM `board` WHERE `company_id` = '{$company_id}'");
	
	msg("프로그램이 삭제되었습니다.");
	
	req_move("manage_company");
}
?>