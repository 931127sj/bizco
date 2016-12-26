<?php

////////////// SESSION START
session_start();

////////////// HEADER UTF-8 SETTING
header("Content-Type: text/html; charset=UTF-8");

////////////// DB CONNECT
$link = mysql_connect("localhost","startup","mystart2016!1");
mysql_select_db("startup", $link);
mysql_query("set names utf8");

///////////////FUNCTION
function page_redirect($url) {
	header("Location: ".$url);
}

function req_redirect($req) {
	header("Location: /public/$req");	
} 

function req_redirect_js($req){
	?>
		<script>
			location.href = "<? echo "/public/$req"; ?>";
		</script>
	<?
}

function req_move($req){
		echo '<script type="text/javascript">';
			echo $req ? "document.location.replace('/public/{$req}');" : 'history.back();';
		echo '</script>';
		exit();
}

function msg($msg){
	echo '<script type="text/javascript">';
			echo "alert('{$msg}');";
	echo '</script>';
}

function back(){
	echo '<script type="text/javascript">';
			echo "history.back();";
	echo '</script>';
}

function access($bool, $msg = '접근권한이 없는 페이지 입니다.', $url = false){
	if(!$bool){
		msg($msg);
		req_move($url);
	}
}

function lv_chk($lv){	
	$cur_lv = $_SESSION['level'] ? $_SESSION['level'] : 0;
	
	switch($lv){
		case 8 :
			$msg = "최고 관리자 이상 접근할 수 있는 페이지 입니다.";
		break;
		case 7 :
			$msg = "사이트 관리자 이상 접근할 수 있는 페이지 입니다.";
		break;
		case 6 :
			$msg = "프로그램 최고 관리자 이상 접근할 수 있는 페이지 입니다.";
		break;
		case 5 :
			$msg = "프로그램 관리자 이상 접근할 수 있는 페이지 입니다.";
		break;
		case 4 :
			$msg = "멘토 이상 접근할 수 있는 페이지 입니다.";
		break;
		case 3 : 
			$msg = "팀 리더 이상 접근할 수 있는 페이지 입니다.";
		break;
		case 2 :
			$msg = "승인된 참가자 이상 접근할 수 있는 페이지 입니다.";
		break;
		case 1 :
			$mag = "로그인을 해주세요.";
			$url = "auth.php";
		break;		
	}
	
	access($lv <= $cur_lv, $msg, $url);
}

function check_login() {	
	$check_login = mysql_query("SELECT * FROM  `user` WHERE  `idx` =".$_SESSION["idx"]);	
	
	$check_login_data = mysql_fetch_array($check_login);
	
	if($check_login_data['email'] != $_SESSION["u_id"]) {
		msg( "잘못된 접근입니다.");
		req_redirect_js("do_logout.php");
		exit();
	} else if($check_login_data['token'] != $_SESSION["token"]) {
		msg( "다른 기기에서 접근하여 로그아웃합니다.");
		req_redirect_js("do_logout.php");
		exit();
	} else {
	}
}

function dateDiff($date1, $date2){ 
	 $_date1 = explode("-",$date1); 
	 $_date2 = explode("-",$date2); 
	
	 $tm1 = mktime(0,0,0,$_date1[1],$_date1[2],$_date1[0]); 
	 $tm2 = mktime(0,0,0,$_date2[1],$_date2[2],$_date2[0]);
	
	 return ($tm1 - $tm2) / 86400;
}

function filter($text1)	{ // SQL injection 방지
	$text1=trim($text1); 
	$text1=htmlspecialchars($text1, ENT_QUOTES); 
	$text1=eregi_replace ("%", "&#37;", $text1); 
	$text1=eregi_replace ("<", "&lt;", $text1); 
	$text1=eregi_replace (">", "&gt;", $text1); 
	$text1=eregi_replace ("&amp;", "&", $text1); 
	$text1=nl2br($text1); 
	$text1=StripSlashes($text1); 

	$text1=strip_tags($text1);
	$text1=mysql_real_escape_string($text1);
	
	return $text1;
}

function stripslashes_deep($var){
	$var = is_array($var)?
				  array_map('stripslashes_deep', $var) :
				  stripslashes($var);
 
	return $var;
}

function mysql_real_escape_string_deep($var){
	$var = is_array($var)?
				  array_map('mysql_real_escape_string_deep', $var) :
				  mysql_real_escape_string($var);
 
	return $var;
}

function get_profile_url($idx) {
	$rq = mysql_query("SELECT * 
						FROM  `user` 
						WHERE  `idx` =$idx");	
	$rq_data = mysql_fetch_array($rq);
	if($rq_data['profile'] != '') {
		return "/data/profile_thumb/".$rq_data['profile'];
	} else {
		return "/data/profile_thumb/sample.png";
	}
}


function cut_str($str, $len){
	$str = html_entity_decode($str);
	$strlen = strlen($str);
	if($strlen > $len)$str = substr($str, 0, $len).'..';
	return htmlspecialchars($str);
}

function hit($str, $keyword){
	$str = str_replace($keyword, "<span class=\"search_txt\">{$keyword}</span>", $str);
	return $str;
}

///////////////////// SQL INJECTION DEFENCE
/*
if( get_magic_quotes_gpc() ){
	if( is_array($_POST) )
		$_POST = array_map( 'stripslashes_deep', $_POST );
	if( is_array($_GET) )
		$_GET = array_map( 'stripslashes_deep', $_GET );
}
 
if( is_array($_POST) )
	$_POST = array_map( 'mysql_real_escape_string_deep', $_POST);
if( is_array($_GET) )
	$_GET = array_map( 'mysql_real_escape_string_deep', $_GET);

*/

if( get_magic_quotes_gpc() ){
    if( is_array($_POST) )
        $_POST = array_map( 'stripslashes_deep', $_POST );
    if( is_array($_GET) )
        $_GET = array_map( 'stripslashes_deep', $_GET );
}
 
if( is_array($_POST) )
    $_POST = array_map( 'mysql_real_escape_string_deep', $_POST );
if( is_array($_GET) )
    $_GET = array_map( 'mysql_real_escape_string_deep', $_GET);
