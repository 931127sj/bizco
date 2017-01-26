<?php
require '_common.php';

$team_idx = $_GET['team_idx'];
$user_idx = $_SESSION['idx'];
$user_name = $_SESSION['name'];
$acc_user_idx = $_GET['user_idx'];

if($team_idx){
  if($acc_user_idx){
    if($_GET['join']){
      $acc_user_data = mysql_fetch_array(mysql_query("SELECT `name` FROM `user` WHERE `idx` = '{$acc_user_idx}'"));
      $acc_user_name = $acc_user_data['name'];

      mysql_query("UPDATE `user_alarm` SET `read_chk` = 0 WHERE `idx`=".$_GET['alarm_idx']);
      mysql_query("UPDATE `user` SET `team_idx` = '{$team_idx}' WHERE `idx`='{$acc_user_idx}'");

      mysql_query("INSERT INTO `user_alarm`
    						(`to_user_idx`, `to_user_name`, `from_user_idx`, `from_user_name`,
    						`type`, `article_idx`, `datetime`, `read_chk`)
    						VALUES ('{$acc_user_idx}', '{$acc_user_name}', '{$user_idx}', '{$user_name}',
    									'team_ok', '{$team_idx}', '{$datetime}', '1')");

      msg("팀 승인이 완료되었습니다.");
      req_move("team_info?idx={$team_idx}");
    }else{
      mysql_query("UPDATE `user_alarm` SET `read_chk` = 0 WHERE `idx`=".$_GET['alarm_idx']);

      msg("팀 승인이 거절되었습니다.");
      req_move("team_info?idx={$team_idx}");
    }
  }else{
    if($_GET['join']){
      $team_data = mysql_fetch_array(mysql_query("SELECT `leader_idx`, `leader_name` FROM `team` WHERE `idx`='{$team_idx}'"));
      $leader_idx = $team_data['leader_idx'];
      $leader_name = $team_data['leader_name'];

      mysql_query("INSERT INTO `user_alarm`
    						(`to_user_idx`, `to_user_name`, `from_user_idx`, `from_user_name`,
    						`type`, `article_idx`, `datetime`, `read_chk`)
    						VALUES ('{$leader_idx}', '{$leader_name}', '{$user_idx}', '{$user_name}',
    									'team_join', '{$team_idx}', '{$datetime}', '1')");

      mysql_query("INSERT INTO `user_alarm`
    						(`to_user_idx`, `to_user_name`, `from_user_idx`, `from_user_name`,
    						`type`, `article_idx`, `datetime`, `read_chk`)
    						VALUES ('{$leader_idx}', '{$leader_name}', '{$user_idx}', '{$user_name}',
    									'team_acc', '{$team_idx}', '{$datetime}', '1')");

      msg("함께하기 요청이 되었습니다.");
      req_move("team_info?idx={$team_idx}");
    }else{
      mysql_query("UPDATE `user` SET `team_idx` = NULL WHERE `idx`=".$_SESSION['idx']);

      mysql_query("INSERT INTO `user_alarm`
    						(`to_user_idx`, `to_user_name`, `from_user_idx`, `from_user_name`,
    						`type`, `article_idx`, `datetime`, `read_chk`)
    						VALUES ('{$leader_idx}', '{$leader_name}', '{$user_idx}', '{$user_name}',
    									'team_out', '{$team_idx}', '{$datetime}', '1')");

      msg("팀에서 탈퇴되었습니다.");
      req_move("team_list");
    }
  }
}else{
  msg("잘못된 접근입니다.");
  back();
}

?>
