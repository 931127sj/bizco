<?
require '_common.php';
$idx = $_GET['id'];


$rq = mysql_query("SELECT *
FROM  `homework_progress`
WHERE  `user_idx` =".$_SESSION['idx']."
AND  `article_idx` =$idx");
if(mysql_num_rows($rq) >= 1) {
	$rq_data = mysql_fetch_array($rq);
	echo date('Y-m-d H:i:s')."<br>";
	echo $rq_data['last_request_time']."<br>";

	$result = (strtotime(date('Y-m-d H:i:s')) - strtotime($rq_data['last_request_time']));

	$result = (int) $result;


	if($result >= 30) {
		mysql_query("UPDATE  `homework_progress` SET  `last_request_time` =  '".date('Y-m-d H:i:s')."' WHERE  `homework_progress`.`idx` =".$rq_data['idx'].";");
	} else {
		mysql_query("UPDATE  `homework_progress` SET  `last_request_time` =  '".date('Y-m-d H:i:s')."' , `complete_sec`='".($rq_data['complete_sec'] + $result)."'  WHERE `homework_progress`.`idx` =".$rq_data['idx'].";");
	}
} else {
	echo "ERROR";
}


?>