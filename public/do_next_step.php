<?php
require '_common.php';

$step = mysql_query("SELECT *
					FROM  `user_step_relation`
					WHERE  `user_idx` =".$_SESSION['idx']);
$step_count = mysql_num_rows($step);
$step_data = mysql_fetch_array($step);
$is_avaliable_step = true;


if($step_count >= 1) {
	$current_step = $step_data['current_step_idx'];

	$step_info = mysql_query("SELECT *
							FROM  `curriculum_step`
							WHERE  `step_seq` =$current_step");

	$step_info_data = mysql_fetch_array($step_info);
	//var_dump($step_info_data);
	//과제완료 여부 확인
	$step_article = mysql_query("SELECT *
								FROM  `article`
								WHERE  `step_id` =".$step_info_data['idx']);
	while($step_article_data = mysql_fetch_array($step_article)) {
		//echo "as";
		$homework = mysql_query("SELECT *
								FROM  `homework`
								WHERE  `article_idx` =".$step_article_data['idx']."
								AND  `user_idx` =".$_SESSION['idx']."
								AND  `state` =1");

		$homework_count = mysql_num_rows($homework);
		//echo $homework_count;
		if(!($homework_count >= 1)) {
			$is_avaliable_step = false;
		}

	}

	if($is_avaliable_step) {
		msg("다음단계로 진입에 성공하였습니다.");
		$rq = mysql_query("UPDATE  `user_step_relation` SET  `current_step_idx` =  '".($current_step+1)."' WHERE  `user_step_relation`.`user_idx` =".$_SESSION['idx'].";");
		req_redirect_js("cur_step");
	} else {
		msg( "다음단계 진입에 실패했습니다. 모든 과제를 완료하였나 확인하세요.");
		back();
	}
} else {
	msg("다음단계 진입에 실패했습니다! 운영진에게 문의하세요.");
	back();
}


