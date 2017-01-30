<?php
require '_common.php';

$user_idx = $_SESSION['idx'];
$user_name = $_SESSION['name'];
$content  = $_POST['content'];

$company_id = $_SESSION['company'];

if($_SESSION['lang'] == 'en'){
  $lang_msg1 = "Complete!";
  $lang_msg2 = "Complete!";
}else{
	$lang_msg1 = "등록되었습니다.";
  $lang_msg2 = "수정되었습니다.";
}

// 나중에 company_id를 동적으로 받아서 처리하게 해야함. 지금은 단국대로 고정되어 있음.
$query = mysql_query("SELECT * from article where company_id = '{$company_id}' and board_id = 'faq'");

// echo $content;
// exit();

$rs = mysql_fetch_array($query);

// 없는건 Insert
if ($rs === 0) {
    $datetime = date("Y-m-d H:i:s",time());
    $result = mysql_query("INSERT INTO  `article`
      (`idx`, `company_id`, `board_id`, `user_idx`, `title`, `content`, `write_datetime`, `youtube_link`, `user_name`)
    VALUES (NULL, '$company_id', 'faq', '$user_idx', 'FAQ', '$content', '$datetime', '', '$user_name');");
   	msg($lang_msg1);
    req_move("faq_view");
}
// 있는건 Update
else {
    $article_idx = $rs['idx']; // idx
    $result = mysql_query("UPDATE `article` SET content='$content' WHERE `idx`=$article_idx");
    msg($lang_msg2);
    req_move("faq_view");
}
// exit();
