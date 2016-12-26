<?php
require '_common.php';

$pw_old	=	$_POST['password_old'];
$pw		=	$_POST['password'];

if(strlen($pw) == 0 || strlen($pw_check)){
	echo("비밀번호를 입력 해 주세요.");
	exit();
}

// 현재 비밀번호 체크
$user_info= mysql_query("SELECT * FROM  `user` WHERE  `idx` =  '".$_SESSION['idx']."'");
$user_info_rows = mysql_num_rows($user_info);
$user_info_data = mysql_fetch_array($user_info);
if($user_info_rows <= 0){
	echo("현재 비밀번호가 일치하지 않습니다.");
} else if(hash("sha256",$user_info_data["salt"].$pw_old) != $user_info_data["password"]) {
	echo("현재 비밀번호가 일치하지 않습니다.");
} else {

// salt생성
$salt = substr(sha1(rand().$email.date("Y-m-d H:i:s")), 0, 20);
 //SALT 알고리즘에 따라,  아이디와 요청시간의 값을 랜덤으로 20자리 생성한다

$password = hash("sha256",$salt.$pw);

$result = mysql_query("UPDATE  `user` set password = '$password', salt = '".$salt."' where idx = '".$_SESSION['idx']."'");

echo "success";

}