<?php
require '_common.php';
$idx = $_GET['idx'];

if($_SESSION['lang'] == 'en'){
  $lang_msg = "Your comment has been deleted.";
}else{
	$lang_msg = "댓글이 삭제되었습니다.";
}

$reply_query = mysql_query("SELECT `idx` FROM `comment` WHERE `parent_idx` = $idx");
while($reply_data = mysql_fetch_array($reply_query)){
  mysql_query("DELETE FROM `user_alarm` WHERE `article_idx` = '{$reply_data['idx']}' AND `read_chk` = '1'");
}

mysql_query("DELETE FROM `user_alarm` WHERE `article_idx` = '$idx' AND `read_chk` = '1'");

mysql_query("DELETE FROM `comment` WHERE `idx` = $idx");
mysql_query("DELETE FROM `comment` WHERE `parent_idx` = $idx");

msg($lang_msg);

back();
?>
