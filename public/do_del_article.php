<?php
require '_common.php';
$article_id = $_GET['article_id'];
$board_id = $_GET['board_id'];
$board_type = $_GET['board_type'];

if($board_id == 'business_model'){
	$team_num = mysql_num_rows(mysql_query("SELECT `idx` FROM `team` WHERE `leader_idx` = ".$_SESSION['idx']));
	if($team_num > 0){
		msg("해당 비즈니스 모델을 사용하는 팀이 개설되어 있습니다.");
		back();
		exit();
	}
}

if($_SESSION['lang'] == 'en'){
	$lang_msg = "Your post has been deleted.";
}else{
	$lang_msg = "게시물이 삭제되었습니다.";
}

mysql_query("DELETE FROM `article` WHERE `idx` = $article_id");

msg($lang_msg);

if($board_id == 'business_model'){
	req_move("bm_list?id={$board_id}");
}else if($board_type == 'team'){
	req_move("board_list?board_type={$board_type}&board_id={$board_id}");
} else {
	back();
}

?>
