<?php
require '_common.php';
$id = $_POST['email'];
$password = $_POST['password'];


//  유효성 check
if($id == '') {
	msg("아이디는 필수입력 사항입니다.");
		back();
	exit();
}
if($password == '') {
	msg("비밀번호는 필수입력 사항입니다.");
		back();
	exit();
}

$user_info= mysql_query("SELECT * FROM  `user` WHERE  `email` =  '$id'");
$user_info_rows = mysql_num_rows($user_info);
$user_info_data = mysql_fetch_array($user_info);
if($user_info_rows <= 0){
	msg("존재하지 않는 아이디 혹은 비밀번호 입니다.");
	back();
	exit();
} else if(hash("sha256",$user_info_data["salt"].$password) != $user_info_data["password"]) {
	msg("존재하지 않는 아이디 혹은 비밀번호 입니다.");
	back();
	exit();
} else if($user_info_data["level"] == 0) {
    msg("아직 참가승인이 되지 않았습니다.");
    back();
    exit();
} else {



		$_SESSION["login"] = true;
		$_SESSION["u_id"] = $user_info_data['email'];
		$_SESSION["idx"] = $user_info_data['idx'];
		$_SESSION["name"] = $user_info_data['name'];
		$_SESSION['level'] = $user_info_data['level'];
		$_SESSION['company'] = $user_info_data['company_id'];


		$token = substr(sha1(rand().$id.date("Y-m-d H:i:s")), 0, 20);
		$_SESSION["token"] = $token;
		$update = mysql_query("UPDATE  `user` SET  `token` =  '$token',
	`last_login_date` =  '$date',
	`last_login_ip` =  '$ip' WHERE  `user`.`idx` =".$user_info_data['idx'].";");
		page_redirect("./index.php");


	}


	page_redirect("/public/");
	exit();
