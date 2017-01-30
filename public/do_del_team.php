<?php
require '_common.php';
$idx = $_GET['idx'];

if($_SESSION['lang'] == 'en'){
  $lang_msg = "Your team has been deleted.";
}else{
  $lang_msg = "팀이 삭제되었습니다.";
}

mysql_query("DELETE FROM `team` WHERE `idx` = $idx");

msg($lang_msg);
req_redirect_js("team_list");
?>
