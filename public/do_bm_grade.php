<?php
require '_common.php';
$article_id = $_POST['article_id'];
$score = $_POST['score'];
$summary = $_POST['summary'];
$opinion = $_POST['opinion'];
$user_idx = $_SESSION['idx'];
$user_name = $_SESSION['name'];
$datetime = date("Y-m-d H:i:s",time());

if($score == '' || $summary == '' || $opinion == '') {
	msg("모든 항목을 입력하세요");
	back();
	exit();
}
$result = mysql_query("INSERT INTO  `bm_grade` (
`idx` ,
`article_idx` ,
`user_idx` ,
`score` ,
`summary` ,
`opinion` ,
`grade_datetime`,
`user_name`
)
VALUES (
NULL ,  '$article_id',   '$user_idx',  '$score',  '$summary', '$opinion', '$datetime', '$user_name'
);");


$bm_query = mysql_query("SELECT * FROM `article` WHERE `idx` = '{$article_id}'");
$bm_data = mysql_fetch_array($bm_query);

$to_user_idx = $bm_data['user_idx'];
$to_user_name = $bm_data['user_name'];

if($bm_data['user_idx'] != $_SESSION['idx']){
	mysql_query("INSERT INTO `user_alarm`
						(`to_user_idx`, `to_user_name`, `from_user_idx`, `from_user_name`,
						`type`, `article_idx`, `datetime`, `read_chk`)
						VALUES ('{$to_user_idx}', '{$to_user_name}', '{$user_idx}', '{$user_name}',
									'bm_grade', '{$article_id}', '{$datetime}', '1')");
}



if($_GET['board_id']){
	msg("첫인상평가 등록이 완료되었습니다.");
	req_move('bm_grade?board_id=business_model&article_id='.$article_id);
}else{
	msg("첫인상평가 등록이 완료되었습니다.");
	req_move("cur_step?step=2#bm_grade");
}
?>
