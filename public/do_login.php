<?php
require '_common.php';
$id = $_POST['email'];
$password = $_POST['password'];

if($_SESSION['lang'] == 'en'){
	$err_required_email = "E-mail is a required field.";
	$err_required_pw = "Password is a required field.";
	$err_exist = "It does not exist.";
}else{
	$err_required_email = "이메일은 필수입력 사항입니다.";
	$err_required_pw = "비밀번호는 필수입력 사항입니다.";
	$err_exist = "존재하지 않는 아이디 혹은 비밀번호 입니다.";
}

//  유효성 check
if($id == '') {
	msg($err_required_email);
	back();
	exit();
}
if($password == '') {
	msg($err_required_pw);
	back();
	exit();
}

$user_info= mysql_query("SELECT * FROM  `user` WHERE  `email` =  '$id'");
$user_info_rows = mysql_num_rows($user_info);
$user_info_data = mysql_fetch_array($user_info);

$company_info = mysql_query("SELECT * FROM `company` WHERE `company_id` = '{$user_info_data['company_id']}'");
$company_info_rows = mysql_num_rows($company_info);
$company_info_data = mysql_fetch_array($company_info);


if($user_info_rows <= 0){
	msg($err_exist);
	back();
	exit();
} else if(hash("sha256",$user_info_data["salt"].$password) != $user_info_data["password"]) {
	msg($err_exist);
	back();
	exit();
} else if($user_info_data["level"] == 1) {
    msg("아직 참가승인이 되지 않았습니다.");
    back();
    exit();
} else if($company_info_rows <= 0){
	msg("프로그램이 삭제되었습니다.");
	back();
	exit();
} else {



		$_SESSION["login"] = true;
		$_SESSION["u_id"] = $user_info_data['email'];
		$_SESSION["idx"] = $user_info_data['idx'];
		$_SESSION["name"] = $user_info_data['name'];
		$_SESSION['level'] = $user_info_data['level'];
		$_SESSION['company'] = $user_info_data['company_id'];

		if(!$_SESSION['lang']) $_SESSION['lang'] = $company_info_data['lang'];


		$token = substr(sha1(rand().$id.date("Y-m-d H:i:s")), 0, 20);
		$_SESSION["token"] = $token;
		$update = mysql_query("UPDATE  `user` SET  `token` =  '$token',
	`last_login_date` =  '$date',
	`last_login_ip` =  '$ip' WHERE  `user`.`idx` =".$user_info_data['idx'].";");
		page_redirect("./index.php");


	}


	page_redirect("/public/");
	exit();
