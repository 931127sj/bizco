<?php
require '_common.php';

$team_name	 = $_POST['team_name'];
$team_member = $_POST['team_member'];
$bm					 = $_POST['bm'];
$award			 = $_POST['contest'];
$history		 = $_POST['career'];
$ability		 = $_POST['skills'];
$progress		 = $_POST['process'];
$company_id = $_SESSION['company'];

$user_idx		= $_SESSION['idx'];
$user_name	= $_SESSION['name'];

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
	$chk = mysql_num_rows(mysql_query("SELECT `idx` FROM `team` WHERE `name` = {$team_name} AND `company_id` = {$company_id}"));
	if($chk){
		msg("팀 이름이 중복됩니다.");
		back();
	}else{
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
				`add_datetime`,
				`leader_name`
				)
				VALUES (
				NULL ,  '$company_id',  '$team_name',  '$user_idx','$team_member' ,  '$bm',  '$award',  '$history',  '$ability',  '$progress',  '$datetime', '$user_name'
				);
				");

		$team_idx = mysql_insert_id();
		mysql_query("UPDATE `user` SET `team_idx` = '{$team_idx}', `level`=3 WHERE idx = ".$_SESSION['idx']);

		if($result){
			msg("팀 등록에 성공하였습니다.");
			req_move("team_list");
		}else{
			msg("이전에 생성한 팀이 있습니다.");
			req_move("team_list");
		}
	}
}
