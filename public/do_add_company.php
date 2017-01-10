<?php
require '_common.php';

$company_name	=	$_POST['name'];
$company_id		=	$_POST['company_id'];
$curriculum 	= $_POST['curriculum'];
$lang 	= $_POST['lang'];

if($lang == 'en'){
	$notice = "Notice";
	$bml = "Business Model List";
	$board = "Downloads";
	$together = "Together";
	$curriculum = "Curriculum";
}else{
	$notice = "공지사항";
	$bml = "비지니스 모델 리스트";
	$board = "자료실";
	$together = "함께해요";
	$curriculum = "커리큘럼";
}


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
	$_SESSION['company'] = $company_id;

	$result = mysql_query("INSERT INTO  `company`(
							`company_id` ,
							`name`,
							`lang`
							)
							VALUES (
							'$company_id',  '$company_name', '$lang'
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
					'program_notice', '{$company_id}','{$company_name} {$notice}', 'default', '0', '3'
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
					'business_model', '{$company_id}','{$bml}', 'business_model', '0', '0'
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
					'filebox', '{$company_id}','{$board}', 'default', '0', '0'
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
					'together', '{$company_id}','{$together}', 'default', '0', '0'
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
							'{$company_id}_cur', '{$company_id}','{$curriculum}', 'curriculum', '0', '0'
							);
					");

		mysql_query("INSERT INTO `startup`.`curriculum_step`(
								`company_id`, `step_seq`, `step_name`, `start_date`, `end_date`, `step_explain`, `bm_link`
							) SELECT '{$company_id}', `step_seq`, `step_name`, `start_date`, `end_date`, `step_explain`, `bm_link`
									FROM `startup`.`curriculum_step` WHERE `company_id` = '{$curriculum}'");

		$step_board_id = $curriculum . "_cur";

		mysql_query("INSERT INTO `startup`.`article`(
		`company_id`, `board_id`, `step_id`, `user_idx`, `title`, `content`, `write_datetime`,
		`youtube_link`, `youtube_duration_sec`, `priority`, `user_name`
		)SELECT '{$company_id}', '{$company_id}_cur', `step_id`, `user_idx`, `title`, `content`,
				`write_datetime`, `youtube_link`, `youtube_duration_sec`, `priority`, `user_name`
		FROM `startup`.`article` WHERE `company_id` = '{$curriculum}' AND `board_id` = '{$step_board_id}'");

	msg("{$company_name} 프로그램이 개설되었습니다.");
	req_move("manage_company");
}else{
	msg("이미 사용되고 있는 프로그램 아이디 입니다.");
	back();
	exit();
}
?>
