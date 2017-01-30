<?php
require '_common.php';
$article_idx = mysql_escape_string($_GET['article_idx']);

if($_SESSION['lang'] == 'en'){
  $lang_msg = "Your design thinking has been deleted.";
}else{
  $lang_msg = "디자인 씽킹이 삭제되었습니다.";
}

mysql_query("DELETE from `design_thinking` where `design_thinking`.idx = $article_idx;");

msg($lang_msg);
req_redirect('dt_list');
?>
