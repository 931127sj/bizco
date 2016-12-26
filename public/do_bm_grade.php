<?php
require '_common.php';
$article_id = $_POST['article_id'];
$score = $_POST['score'];
$summary = $_POST['summary'];
$opinion = $_POST['opinion'];
$user_idx = $_SESSION['idx'];
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
`grade_datetime`
)
VALUES (
NULL ,  '$article_id',   '$user_idx',  '$score',  '$summary', '$opinion', '$datetime'
);");

msg("첫인상평가 등록이 완료되었습니다.");

if($_GET['board_id']){
	req_redirect('bm_list?id=business_model');
}else{
	req_move("cur_step?step=2#bm_grade");
}
