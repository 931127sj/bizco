<?php
require '_common.php';
$email = $_POST['email'];
$name = $_POST['name'];
$password = $_POST['password'];
$password_re = $_POST['password_retype'];
$company = $_POST['company'];
$team_id = $_POST['team_id'];
//$position = $_POST['position'];
$part = $_POST['part'];
$join_type = $_POST['join_type'];
$history = $_POST['history'];
$skills = $_POST['skills'];
$progress = $_POST['progress'];
$business_resource = $_POST['business_resource'];
$phone = $_POST['phone'];
//var_dump($_POST);
//  유효성 check
if($email == '') {
	msg("이메일은 필수입력 사항입니다.");
	back();
	exit();
}
if($name == '') {
	msg("이름은 필수입력 사항입니다.");
		back();
	exit();
}
if($password == '') {
	msg("비밀번호는 필수입력 사항입니다.");
		back();
	exit();
}
if($password_re == '') {
	msg("비밀번호재확인은 필수입력 사항입니다.");
		back();
	exit();
}
if($phone == '') {
	msg("연락처는 필수입력 사항입니다.");
		back();
	exit();
}
/*
if($company == '') {

}
*/
/*
if($position == '') {
	msg("스킬은 필수입력 사항입니다.");
		back();
	exit();
}
*/
if($join_type == '') {
	msg("창여 동기는 필수입력 사항입니다.");
		back();
	exit();
}

if($progress == '') {
	msg("진행사항은 필수입력 사항입니다.");
		back();
	exit();
}
if($password != $password_re) {
	msg("비밀번호와 비밀번호 확인이 다릅니다.");
		back();
	exit();
}

switch($part){
	case 1:
		$part = "개발자";
	break;
	case 2:
		$part = "디자이너";
	break;
	case 3:
		$part = "기획자";
	break;
}

switch($progress){
	case 1:
		$progress = "아이디어 단계";
	break;
	case 2:
		$progress = "시제품 제작 단계";
	break;
	case 3:
		$progress = "제품 런칭 단계";
	break;
	case 4:
		$progress = "투자 단계";
	break;
}

// salt생성
$salt = substr(sha1(rand().$email.date("Y-m-d H:i:s")), 0, 20);
 //SALT 알고리즘에 따라,  아이디와 요청시간의 값을 랜덤으로 20자리 생성한다

$password = hash("sha256",$salt.$password);
//SALT 알고리즘에을 통해, SALT값 + 비밀번호 순서로 해쉬한다(순서가 매우중요하다)



//DB중복 체크(이메일로)



// 사용자등록
$result = mysql_query("INSERT INTO  `user` (
						`idx` ,
						`email` ,
						`name` ,
						`password` ,
						`company_id` ,
						`team_name`	,
						`join_type`	,
						`part`	,
						`history`	,
						`skills`	,
						`progress`	,
						`business_resource`	,
						`salt` ,
						`token` ,
						`last_login_date` ,
						`last_login_ip` ,
						`join_date` ,
						`join_ip` ,
						`state`,
						`level`,
						`team_id`,
						`phone`
						)
						VALUES (
						NULL ,  '$email',  '$name',  '$password',  '$company', '$team_id',  '$join_type', '$part', '$history', '$skills',
						'$progress', '$business_resource',  '$salt',  '',  '',  '',  '',  '',  '1', '1', '$team_id', '$phone'
						);
						") or die(mysql_error());

msg("사용자 등록을 완료했습니다.");
req_redirect_js("");
