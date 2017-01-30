<?php
require '_common.php';

$step = mysql_query("SELECT *
					FROM  `user_step_relation`
					WHERE  `user_idx` =".$_SESSION['idx']);
$step_count = mysql_num_rows($step);
$step_data = mysql_fetch_array($step);
$is_avaliable_step = true;

if($_SESSION['lang'] == 'en'){
	$lang_msg = "Successfully proceeded to the next stage.";
	$lang_fail1 = "The next step failed. Make sure you've completed all the assignments.";
	$lang_fail2 = "The next step failed! Please contact the management team.";
}else{
	$lang_msg = "다음단계로 진입에 성공하였습니다.";
	$lang_fail1 = "다음단계 진입에 실패했습니다. 모든 과제를 완료하였나 확인하세요.";
	$lang_fail2 = "다음단계 진입에 실패했습니다! 운영진에게 문의하세요.";
}


if($step_count >= 1) {
	$current_step = $step_data['current_step_idx'];

	$step_info = mysql_query("SELECT *
							FROM  `curriculum_step`
							WHERE  `step_seq` =$current_step
                            AND `company_id`".=$_SESSION['company']);

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
		msg($lang_msg);
		$rq = mysql_query("UPDATE  `user_step_relation` SET  `current_step_idx` =  '".($current_step+1)."' WHERE  `user_step_relation`.`user_idx` =".$_SESSION['idx'].";");
		req_redirect_js("cur_step");
	} else {
		msg($lang_fail1);
		back();
	}
} else {
	msg($lang_fail2);
	back();
}
