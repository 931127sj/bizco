<?php
require '_common.php';
$title 		= $_POST['title'];
$content 	= $_POST['content'];
$board_id 	= $_POST['board_id'];
$step_id 	= $_POST['step_id'];
$board_type = $_POST['board_type'];
$youtube 	= $_POST['youtube'];
$article_id = $_POST['article_id'];
$company_id = $_POST['company_id'];

$user_idx = $_SESSION['idx'];
$user_name = $_SESSION['name'];

$datetime = date("Y-m-d H:i:s",time());

if(! $title) {
	msg('제목을 입력해주세요');
	back();
	exit();
}
if(! trim(strip_tags(str_replace("&nbsp;"," ",$content)))) {
	msg('내용을 입력해주세요.');
	back();
	exit();
}
// $content = trim(strip_tags(str_replace("&nbsp;"," ",$content)));
if(! $board_id) {

}
//비즈니스모델 등록일경우
if($board_type	 == "bm") {

	$ex[0]['id'] = "message";
	$ex[1]['id'] = "domain";
	$ex[2]['id'] = "bus_type";
	$ex[3]['id'] = "summary_who";
	$ex[4]['id'] = "summary_what";
	$ex[5]['id'] = "summary_why";
	$ex[6]['id'] = "slide_1";
	$ex[7]['id'] = "slide_2";
	$ex[8]['id'] = "slide_3";
	$ex[9]['id'] = "slide_4";
	$ex[10]['id'] = "slide_5";
	$ex[11]['id'] = "slide_6";
	$ex[12]['id'] = "not_recruit";
	$ex[13]['id'] = "recruit_developer";
	$ex[14]['id'] = "recruit_designer";
	$ex[15]['id'] = "recruit_planner";
	$ex[16]['id'] = "message";
	for($i = 0; $i < sizeof($ex); $i++) {
		$id = "ex_".$ex[$i]['id'];
		$ex[$i]['value'] = $_POST[$id];

	}

}
parse_str( parse_url( $youtube, PHP_URL_QUERY ), $my_array_of_vars );
$youtube_data = $my_array_of_vars['v'];

if($youtube_data != '') {

	$url = "https://www.googleapis.com/youtube/v3/videos?id=".$youtube_data."&key=AIzaSyAt3rU_Qq4nYx6D16hUKrUVtqhh155zf9s&part=contentDetails";

	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL,$url); //접속할 URL 주소
	curl_setopt ($ch, CURLOPT_HEADER, 0); // 헤더 출력 여부
	curl_setopt ($ch, CURLOPT_TIMEOUT, 30); // TimeOut 값
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); // 결과값을 받을것인지
	$result = curl_exec ($ch);
	curl_close ($ch);

	$result = json_decode($result, true);

	$duration = covtime($result['items'][0]['contentDetails']['duration']);

}


// 과제등록일 경우 우선순위(priority)지정
$priority = 0;
$board = mysql_query("SELECT * FROM  `board` WHERE  `board_id` =  '$board_id'");
$board_data = mysql_fetch_array($board);
if($board_data['type'] == "curriculum") {

	$max_pri_query = mysql_query("SELECT *
								FROM  `article`
								WHERE  `board_id` =  '$board_id'
								AND  `step_id` =$step_id
								ORDER BY  `article`.`priority` DESC
								LIMIT 0 , 1");

	$max_pri_data = mysql_fetch_array($max_pri_query);

	$priority = $max_pri_data['priority'] + 1;
}

//수정일 경우 update
if($_POST['type'] =="edit") {
	$result = mysql_query("UPDATE  `article` SET  `title` =  '$title', `content` =  '$content', `youtube_link` =  '$youtube', `youtube_duration_sec` = '$duration' WHERE  `article`.`idx` =".$article_id.";");
} else {
	$result = mysql_query("INSERT INTO  `article` (
						`idx` ,
						`company_id` ,
						`board_id` ,
						`step_id`	,
						`user_idx` ,
						`title` ,
						`content` ,
						`write_datetime` ,
						`youtube_link`,
						`youtube_duration_sec`,
						`priority`,
						`user_name`
						)
						VALUES (
						NULL ,  '{$company_id}',  '$board_id', '$step_id',  '$user_idx',  '$title',  '$content',  '{$datetime}',  '$youtube',  '$duration', '$priority', '$user_name'
						);
						");

	if($board_type == 'team'){
		 $article_idx = mysql_insert_id();
		 $alarm_query = mysql_query("SELECT `idx`, `name` FROM `user` WHERE `team_idx` = '{$board_id}' and `idx` != ".$_SESSION['idx']);
		 while($alarm_data = mysql_fetch_array($alarm_query)){
			 mysql_query("INSERT INTO `user_alarm`(
				 						`to_user_idx`,
										`to_user_name`,
										`from_user_idx`,
										`from_user_name`,
										`type`,
										`article_idx`,
										`datetime`,
										`read_chk`
			 							)
			 							VALUES(
										'".$alarm_data['idx']."', '".$alarm_data['name']."', '{$user_idx}', '{$user_name}', 'team', '{$article_idx}', '{$datetime}', '1'
										);");
		}
	}
}



/////////////비즈니스모델
$article_no = mysql_insert_id();
if($board_type	 == "bm") {
	//수정일경우 기존비즈모델 삭제
	if($_POST['type'] == "edit") {
		$dq = mysql_query("DELETE FROM `board_extend_data` WHERE `article_idx` = ".$article_id);
		$article_no = $_POST['article_id'];
	}

	for($i = 0; $i < sizeof($ex); $i++) {
		$rq = mysql_query("INSERT INTO  `board_extend_data` (
							`idx` ,
							`article_idx` ,
							`board_id` ,
							`extend_idx` ,
							`content`
							)
							VALUES (
							NULL ,  '$article_no',  '$board_id',  '".$ex[$i]['id']."',  '".$ex[$i]['value']."'
							);");
	}

}

/////////////////////////  파일업로드
$write_time = date("Ymdhis");
$rand_num = rand();
$file[0] = upload_file("attach1", $article_no, $write_time, $rand_num, 0);
$file[1] = upload_file("attach2", $article_no, $write_time, $rand_num, 1);
$file[2] = upload_file("attach3", $article_no, $write_time, $rand_num, 2);

for($i = 0; $i <= 2; $i++) {
	if($file[$i] != false) {
		$ex_name = array_pop(explode('.', strtolower($file[$i])));
		$file_name = $article_no."_".$write_time."_".$rand_num."_".$i.".".$ex_name;

		$query = mysql_query("INSERT INTO  `startup`.`attach` (
								`idx` ,
								`article_idx` ,
								`url` ,
								`name`
								)
								VALUES (
								NULL ,  '$article_no',  '{$file_name}',  '".$file[$i]."'
								);");

	}

}


msg("게시물을 저장했습니다.");

if ($_POST['redirect'] != '') {
	req_move($_POST['redirect']);
} else if ($board_id == 'business_model') {
	req_move("bm_list?id={$board_id}");
} else if ($board_type == 'team') {
	req_move("board_list?board_type=team&board_id={$board_id}");
} else {
	req_move("board_list?board_id={$board_id}");
}




function covtime($youtube_time) {
    preg_match_all('/(\d+)/',$youtube_time,$parts);

    // Put in zeros if we have less than 3 numbers.
    if (count($parts[0]) == 1) {
        array_unshift($parts[0], "0", "0");
    } elseif (count($parts[0]) == 2) {
        array_unshift($parts[0], "0");
    }

    $sec_init = $parts[0][2];
    $seconds = $sec_init%60;
    $seconds_overflow = floor($sec_init/60);

    $min_init = $parts[0][1] + $seconds_overflow;
    $minutes = ($min_init)%60;
    $minutes_overflow = floor(($min_init)/60);

    $hours = $parts[0][0] + $minutes_overflow;

    return ($hours * 3600) + ($minutes * 60) + $seconds;


}

function upload_file($form_id, $article_idx, $write_time, $rand_num, $file_num) {
	// uploads디렉토리에 파일을 업로드합니다.

	//msg(var_dump($_FILES[$form_id]));
	//msg($_FILES[$form_id]['name']);

	 if($_FILES[$form_id]['name'] == "") {
	 	return false;
	 }

	 $ex_name = array_pop(explode('.', strtolower($_FILES[$form_id]['name'])));
	 $file_name = $article_idx."_".$write_time."_".$rand_num."_".$file_num.".".$ex_name;

	 $uploaddir = '../data/attach/';
	 $uploadfile = $uploaddir.$file_name;

	 if("500000000" < $_FILES[$form_id]['size']){
	      //msg( "업로드 파일이 지정된 파일크기보다 큽니다.\n");
	      return false;
	 } else {
	     if(($_FILES[$form_id]['error'] > 0) || ($_FILES[$form_id]['size'] <= 0)){
	     	//msg("ERROR : ".$_FILES[$form_id]['error']."\nSIZE : ".$_FILES[$form_id]['size']."\n NAME : ".$_FILES[$form_id]['name']."\n");
	          //msg( "파일 업로드에 실패하였습니다.");
	          return false;
	     } else {
	          // HTTP post로 전송된 것인지 체크합니다.
	          if(!is_uploaded_file($_FILES[$form_id]['tmp_name'])) {
	                //msg( "HTTP로 전송된 파일이 아닙니다.");
	                return false;
	          } else {
	                // move_uploaded_file은 임시 저장되어 있는 파일을 ./uploads 디렉토리로 이동합니다.
	                if (move_uploaded_file($_FILES[$form_id]['tmp_name'], $uploadfile)) {
	                     ///msg( "성공적으로 업로드 되었습니다.\n");
	                } else {
	                     //msg( "파일 업로드 실패입니다.\n");
	                     return false;
	                }
	          }
	     }
	 }
	 return $_FILES[$form_id]['name'];
}
