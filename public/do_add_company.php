<?php
require '_common.php';

$company_name	=	$_POST['name'];
$company_id		=	$_POST['company_id'];
$curriculum 	= $_POST['curriculum'];

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

	if($curriculum != 0){
		$cur_query = mysql_query("SELECT * FROM `curriculum_step` WHERE `company_id` = '{$curriculum}'");
		while($cur = mysql_fetch_array($cur_query)){
			mysql_query("INSERT INTO `curriculum_step`(
									`company_id`, `step_seq`, `step_name`, `start_date`, `end_date`, `step_explain`, `bm_link`
								)VALUES(
									'{$company_id}', '".$cur['step_seq']."', '".$cur['step_name']."', '".$cur['start_date']."'
									, '".$cur['end_date']."', '".$cur['step_explain']."', '".$cur['bm_link']."'
								);");
		}

		$step_board_id = $curriculum . "_cur";

		$step_query = mysql_query("SELECT * FROM `article` WHERE `company_id` = '{$curriculum}' AND `board_id` = '{$step_board_id}'");
		while($step = mysql_fetch_array){
			mysql_query("INSERT INTO `article`(
			`company_id`, `board_id`, `step_id`, `user_idx`, `title`, `content`, `write_datetime`,
			`youtube_link`, `youtube_duration_sec`, `priority`, `user_name`
			) VALUES(
				'{$company_id}', '{$step_board_id}', '".$step['step_id']."', '".$step['user_idx']."', '".$step['title']."'
				, '".$step['content']."', '".$step['write_datetime']."', '".$step['youtube_link']."', '".$step['youtube_duration_sec']."'
				, '".$step['priority']."', '".$step['user_name']."'
			);");
		}
	}

	msg("{$company_name} 프로그램이 개설되었습니다.");
	req_move("manage_company");
}else{
	msg("이미 사용되고 있는 프로그램 아이디 입니다.");
	back();
	exit();
}
?>
