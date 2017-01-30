<?php
require '_common.php';

$pw_old	=	$_POST['password_old'];
$pw		=	$_POST['password'];

if($_SESSION['lang'] == 'en'){
	$err_required = "Please enter all required.";
	$err_not_match = "Your current passwords do not match.";
}else{
	$err_required = "비밀번호를 입력 해 주세요.";
	$err_not_match = "해당 프로그램은 삭제할 수 없습니다.";
}

if(strlen($pw) == 0 || strlen($pw_check)){
	echo($err_required);
	exit();
}

// 현재 비밀번호 체크
$user_info= mysql_query("SELECT * FROM  `user` WHERE  `idx` =  '".$_SESSION['idx']."'");
$user_info_rows = mysql_num_rows($user_info);
$user_info_data = mysql_fetch_array($user_info);
if($user_info_rows <= 0){
	echo($err_not_match);
} else if(hash("sha256",$user_info_data["salt"].$pw_old) != $user_info_data["password"]) {
	echo($err_not_match);
} else {

// salt생성
$salt = substr(sha1(rand().$email.date("Y-m-d H:i:s")), 0, 20);
 //SALT 알고리즘에 따라,  아이디와 요청시간의 값을 랜덤으로 20자리 생성한다

$password = hash("sha256",$salt.$pw);

$result = mysql_query("UPDATE  `user` set password = '$password', salt = '".$salt."' where idx = '".$_SESSION['idx']."'");

echo "success";

}
