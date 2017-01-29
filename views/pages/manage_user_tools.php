<?php
require_once(VIEW.'common/_language.php');

$q = $_GET['q'];

if($_GET['company']) $_SESSION['company'] = $_GET['company'];
$company_id = $_SESSION['company'];

if ($q)
    $search_query = "AND (`name` like '%".mysql_escape_string($q)."%' OR `email` like '%".mysql_escape_string($q)."%')";
else
    $search_query = "";

$qs = mysql_query("SELECT `user`.*
                   FROM `user`
                   WHERE `company_id` = '$company_id'
                   $search_query
                   ORDER BY `user`.`idx`");
$current_step = 'manage_user_tools';

if($_SESSION['lang'] == "en"){
  $lang_title = "Manage participants";
  $lang_searching = "Searching with name/e-mail address";
  $lang_name = "Name";
  $lang_email = "E-mail address";
  $lang_team = "Team";
  $lang_tools = "Tools";

  $lang_withdraw = "Withdraw this participant";
  $lang_grant = "Grant administrator privileges";
  $lang_remove = "Remove administrator privileges";
}else{
  $lang_title = "참가자 관리";
  $lang_searching = "이름 / 이메일로 찾기";
  $lang_name = "참가자 이름";
  $lang_email = "이메일";
  $lang_team = "팀";
  $lang_tools = "도구";

  $lang_withdraw = "이 참가자 탈퇴";
  $lang_grant = "관리자 권한 부여";
  $lang_remove = "관리자 권한 제거";
}
?>
<h2 class="ui header"><?= $lang_title ?></h2>

<div class="ui container">
    <button class="ui fluid button" onclick = "location.href = '/public/do_export_xls.php'">엑셀 다운로드</button>
    <form class="ui clearing segment selene-basic">
        <div class="ui icon input">
            <input type="text" name="q" placeholder="<?= $lang_searching ?>" value="<?=$q?>">
            <i class="search link icon"></i>
        </div>
        <button class="ui button"><?= $lang_search ?></button>
    </form>

    <table class="ui celled compact striped table">
        <thead>
            <tr>
                <th><?= $lang_name ?></th>
                <th><?= $lang_email ?></th>
                <th><?= $lang_team ?></th>
                <th><?= $lang_tools ?></th>
            </tr>
        </thead>
        <tbody>
            <? while ($row = mysql_fetch_array($qs)) { ?>
            <tr>
                <td><a href="/public/userpage?id=<?=$row['idx']?>"><?=$row['name']?></a></td>
                <td><?=$row['email']?></td>
                <td><?=$row['team_name'] ?: '<small>팀이 없습니다.</small>'?></td>
                <td>
                    <? if($row['level'] != 8){?>
                    <? if($_SESSION['level'] >= 6) { ?>
                    <a class="mini ui button negative" href="/public/do_delete_user.php?user_idx=<?=$row['idx']?>"><?= $lang_withdraw ?></a>
                      <? if($row['level'] == 1) { ?>
                          <a class="mini ui button blue" href="/public/do_level_to_admin.php?user_idx=<?=$row['idx']?>&level=2">참가 승인</a>
                      <? }?>
                        <? if($row['level'] < 5) { ?>
                            <a class="mini ui button blue" href="/public/do_level_to_admin.php?user_idx=<?=$row['idx']?>"><?= $lang_grant ?></a>
                        <? } else { ?>
                            <a class="mini ui button secondary" href="/public/do_level_to_general.php?user_idx=<?=$row['idx']?>"><?= $lang_remove ?></a>
                        <? } ?>
                        <? if($row['level'] == 0) { ?>
                            <a class="mini ui button blue" href="/public/do_ack_to_user.php?user_idx=<?=$row['idx']?>">참가 승인</a>
                        <? }?>
                     <? } // session level 6 ?>
                    <? } // row level 8 ?>
                </td>
            </tr>
            <? } ?>
        </tbody>
    </table>
</div>

<style type="text/css">
  .table a.ui.button {
    padding:  4px 7px; margin-left:  10px;
  }
</style>
