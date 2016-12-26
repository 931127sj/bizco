<?php
require '_common.php';

$step_idx = $_POST['step_idx'];

if(strlen($step_idx) == 0){
	msg("step_idx�� �Է��ϼ���");
	back();	
	exit();
}

$result = mysql_query("DELETE from curriculum_step where idx = $step_idx")or die(fail());
						
function fail(){
	msg("�������� �ʴ� �����Դϴ�.");
	echo "err";
	back();	
	exit();
}

back();
?>