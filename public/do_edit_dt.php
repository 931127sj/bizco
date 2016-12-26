 <?php
require '_common.php';
$dt_idx = $_POST['idx'];
$problem_cause = $_POST['problem_cause'];
$youtube_link = $_POST['youtube_link'];
$link = $_POST['link'];
$idea = $_POST['idea'];
$test = $_POST['test'];

// 디자인씽킹 데이터 모두 삭제
mysql_query("DELETE FROM `design_thinking_article` WHERE `dt_idx` = '$dt_idx'");

// 데이터 수정
$result = mysql_query("UPDATE`design_thinking` SET
					`problem_cause` = '$problem_cause',
					`youtube_link` = '$youtube_link',
					`datetime` = now()
					WHERE idx = '$dt_idx'
					");

// 데이터 재 삽입
for($i = 0; $i < count($link); $i++){

	if($link[$i] == ''){
		continue;
	}

	$result = mysql_query("INSERT INTO  `design_thinking_article`(
						`dt_idx`,
						`content` ,
						`type`
						)
						VALUES (
						'$dt_idx', '".$link[$i]."',  'link'
						);
						");
}

for($i = 0; $i < count($idea); $i++){

	if($idea[$i] == ''){
		continue;
	}

	$result = mysql_query("INSERT INTO  `design_thinking_article`(
						`dt_idx`,
						`content` ,
						`type`
						)
						VALUES (
						'$dt_idx', '".$idea[$i]."',  'idea'
						);
						");
}

for($i = 0; $i < count($test); $i++){

	if($test[$i] == ''){
		continue;
	}

	$result = mysql_query("INSERT INTO  `design_thinking_article`(
						`dt_idx`,
						`content` ,
						`type`
						)
						VALUES (
						'$dt_idx', '".$test[$i]."',  'test'
						);
						");
}	

back();