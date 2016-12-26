<?php
require '_common.php';

$team_name	= $_POST['team_name'];
$team_member= $_POST['team_member'];
$bm			= $_POST['bm'];
$award		= $_POST['contest'];
$history	= $_POST['career'];
$ability	= $_POST['skills'];
$progress	= $_POST['process'];

if($team_name == NULL || $team_member == NULL || $bm == NULL) {
	msg("필수정보를 모두 입력하세요.");
	back();
	exit();
}		 
					 
$datetime = date("Y-m-d H:i:s",time());

/*
if($_POST['type'] == "edit")
	$eidx = $_POST['idx'];
else
	$eidx = 'idx';

if($_POST['type'] == "edit") {
	mysql_query("DELETE FROM `team` WHERE `team`.`idx` = ".$_POST['idx']);
}
*/	

if($_POST['type'] == "edit")
{
	$result = mysql_query("UPDATE `team` 
	SET name = '{$team_name}' ,
	members = '{$team_member}' , 
	bm_idx = '{$bm}' , 
	award = '{$award}' , 
	history = '{$history}' , 
	ability = '{$ability}' ,
	progress = '{$progress}' 
	where idx = {$_POST['idx']}" );
}
else
{
	$result = mysql_query("INSERT INTO  `team` (
			`idx` ,
			`company_id` ,
			`name` ,
			`leader_idx` ,
			`members` ,
			`bm_idx` ,
			`award` ,
			`history` ,
			`ability` ,
			`progress` ,
			`add_datetime`
			)
			VALUES (
			NULL ,  'dankook',  '$team_name',  '".$_SESSION['idx']."','$team_member' ,  '$bm',  '$award',  '$history',  '$ability',  '$progress',  '$datetime'
			);
			");
}
	
if($result) {
	msg("팀 등록에 성공하였습니다.");
	req_redirect_js("team_list");
} else {
	msg("팀 등록에 실패하였습니다.(한 계정당 여러 팀 생성 또는 팀 이름 중복)");
	req_redirect_js("team_list");
}
back();