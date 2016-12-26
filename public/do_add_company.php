<?php
require '_common.php';

$company_name	=	$_POST['name'];
$company_id		=	$_POST['company_id'];

if(!$company_name){
	msg("프로그램 이름을 입력해 주세요.");
	back();
	exit();
}else if(!$company_id){
	msg("프로그램 아이디를 입력해 주세요.");
	back();
	exit();
}

$check = mysql_num_rows(mysql_query("SELECT `idx`
									FROM `company`
									WHERE `company_id` = '{$company_id}'"));

if($check == 0){
	$result = mysql_query("INSERT INTO  `company`(
							`company_id` ,
							`name`
							)
							VALUES (
							'$company_id',  '$company_name'
							);
							");
	
	// default board
	mysql_query("INSERT INTO `board`(
					`board_id`,
					`company_id`,
					`name`,
					`type`,
					`read_level`,
					`write_level`
					)
					VALUES(
					'program_notice', '{$company_id}','{$company_name} 공지사항', 'default', '0', '3'
					);
				");
	
	mysql_query("INSERT INTO `board`(
					`board_id`,
					`company_id`,
					`name`,
					`type`,
					`read_level`,
					`write_level`
					)
					VALUES(
					'business_model', '{$company_id}','비즈니스 모델 리스트', 'business_model', '0', '0'
					);
			");
	
	mysql_query("INSERT INTO `board`(
					`board_id`,
					`company_id`,
					`name`,
					`type`,
					`read_level`,
					`write_level`
					)
					VALUES(
					'filebox', '{$company_id}','자료실', 'default', '0', '0'
					);
			");
	
	mysql_query("INSERT INTO `board`(
					`board_id`,
					`company_id`,
					`name`,
					`type`,
					`read_level`,
					`write_level`
					)
					VALUES(
					'together', '{$company_id}','함께해요', 'default', '0', '0'
					);
			");
	
	msg("{$company_name} 프로그램이 개설되었습니다.");
	req_move("manage_company");
}else{
	msg("이미 사용되고 있는 프로그램 아이디 입니다.");
	back();
	exit();
}
?>