<?php
require '_common.php';

$company_idx 	=	$_POST['company_idx'];
$company_name	=	$_POST['name'];

if(!$company_name){
	msg("프로그램 이름을 입력해 주세요.");
	back();
	exit();
}


mysql_query("UPDATE `company` SET `name` = '{$company_name}' WHERE `idx` = '{$company_idx}'");

msg("프로그램 정보가 수정되었습니다.");
req_move("manage_company");

?>