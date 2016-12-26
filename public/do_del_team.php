<?php
require '_common.php';
$idx = $_GET['idx'];

mysql_query("DELETE FROM `team` WHERE `idx` = $idx");

msg("팀이 삭제되었습니다.");
req_redirect_js("team_list");
?>