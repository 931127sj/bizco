<?php
require '_common.php';
$article_idx = mysql_escape_string($_GET['article_idx']);

mysql_query("DELETE from `design_thinking` where `design_thinking`.idx = $article_idx;");

msg("디자인 씽킹이 삭제되었습니다.");
req_redirect('dt_list');
?>