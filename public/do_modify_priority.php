<?php
require '_common.php';
$type		= $_GET['type'];
$article_id	= $_GET['id'];

// Step Data 가져오기
$article = mysql_query("SELECT * FROM  `article` WHERE  `idx` =$article_id");
$article_data = mysql_fetch_array($article);

if($_SESSION['lang'] == 'en'){
	$err_top = "The current assignment is at the top.";
	$err_bottom = "The current assignment is at the bottom.";
	$lang_msg = "We've processed your request.";
}else{
	$err_top = "현재 과제가 제일 위에 있습니다.";
	$err_bottom = "현재 과제가 제일 아래에 있습니다.";
	$lang_msg = "요청하신 내용을 처리하였습니다.";
}


if($type == 0) {
	$pri = mysql_query("SELECT *
						FROM  `article`
						WHERE  `board_id` LIKE  '".$article_data['board_id']."'
						AND  `step_id` =".$article_data['step_id']."
						AND  `priority` <".$article_data['priority']."
						ORDER BY  `article`.`priority` DESC
						LIMIT 0 , 1");




	if(!(mysql_num_rows($pri) > 0)) {
		msg($err_top);
		req_redirect_js("manage_step");
		exit();
	}
	$pri_data = mysql_fetch_array($pri);


	// 둘이 change
	$article_query = mysql_query("UPDATE `article` SET  `priority` =  '".$pri_data['priority']."' WHERE  `article`.`idx` =".$article_data['idx'].";");
	$pri_query = mysql_query("UPDATE `article` SET  `priority` =  '".$article_data['priority']."' WHERE  `article`.`idx` =".$pri_data['idx'].";");




} else if($type == 1) {
	$pri = mysql_query("SELECT *
						FROM  `article`
						WHERE  `board_id` LIKE  '".$article_data['board_id']."'
						AND  `step_id` =".$article_data['step_id']."
						AND  `priority` >".$article_data['priority']."
						ORDER BY  `article`.`priority` ASC
						LIMIT 0 , 1");





	if(!(mysql_num_rows($pri) > 0)) {
		msg($err_bottom);
		req_redirect_js("manage_step");
		exit();
	}
	$pri_data = mysql_fetch_array($pri);



	// 둘이 change
	$article_query = mysql_query("UPDATE `article` SET  `priority` =  '".$pri_data['priority']."' WHERE  `article`.`idx` =".$article_data['idx'].";");
	$pri_query = mysql_query("UPDATE `article` SET  `priority` =  '".$article_data['priority']."' WHERE  `article`.`idx` =".$pri_data['idx'].";");

}

msg($lang_msg);
req_redirect_js("manage_step");
