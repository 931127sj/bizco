<?php

require '_common.php';
$article_id = $_GET['article_id'];
$board_id = $_GET['board_id'];
$board_type = $_GET['board_type'];

mysql_query("DELETE FROM `article` WHERE `idx` = $article_id");

msg("게시물이 삭제되었습니다.");

if($board_id == 'business_model'){
	req_move("bm_list?id={$board_id}");
}else if($board_type == 'team'){
	req_move("board_list?board_type={$board_type}&board_id={$board_id}");
} else {
	back();
}

?>