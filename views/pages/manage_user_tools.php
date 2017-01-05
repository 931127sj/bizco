<?php
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
?>
<h2 class="ui header">참가자 관리</h2>

<div class="ui container">
    <form class="ui clearing segment selene-basic">
        <div class="ui icon input">
            <input type="text" name="q" placeholder="이름 / 이메일로 찾기" value="<?=$q?>">
            <i class="search link icon"></i>
        </div>
        <button class="ui button">검색</button>
    </form>

    <table class="ui celled compact striped table">
        <thead>
            <tr>
                <th>참가자 이름</th>
                <th>이메일</th>
                <th>팀</th>
                <th>도구</th>
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
                    <a class="mini ui button negative" href="/public/do_delete_user.php?user_idx=<?=$row['idx']?>">이 참가자 탈퇴</a>
<<<<<<< Updated upstream
                    <? if($row['level'] == 1) { ?>
                        <a class="mini ui button blue" href="/public/do_ack_to_user.php?user_idx=<?=$row['idx']?>">참가 승인</a>
                    <? }?>
=======
                        <? if($row['level'] < 5) { ?>
                            <a class="mini ui button blue" href="/public/do_level_to_admin.php?user_idx=<?=$row['idx']?>">관리자 권한 부여</a>
                        <? } else { ?>
                            <a class="mini ui button secondary" href="/public/do_level_to_general.php?user_idx=<?=$row['idx']?>">관리자 권한 제거</a>
                        <? } ?>
                        <? if($row['level'] == 0) { ?>
                            <a class="mini ui button blue" href="/public/do_ack_to_user.php?user_idx=<?=$row['idx']?>">참가 승인</a>
                        <? }?>
>>>>>>> Stashed changes
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
