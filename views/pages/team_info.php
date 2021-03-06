<?php

require_once '_common.php';
require_once(VIEW.'common/_language.php');

$idx = $_GET['idx'];

$query = mysql_query("SELECT *
                        FROM  `team`
                        WHERE  `idx` =$idx");
$result = mysql_fetch_array($query);

$usr = mysql_fetch_array(mysql_query("SELECT * FROM  `user` WHERE  `idx` =".$result['leader_idx']));
$bm =  mysql_fetch_array(mysql_query("SELECT * FROM  `article` WHERE  `idx` =".$result['bm_idx']));

$user_data = mysql_fetch_array(mysql_query("SELECT `team_idx` FROM `user` WHERE `idx` = ".$_SESSION['idx']));

if($_SESSION['lang'] == "en"){
	$lang_register = "Register new team";
	$lang_mod_team = "Edit team infomation";

	$lang_info = "Information";
	$lang_name = "Team name";
  $lang_leader = "Team leader";
	$lang_member = "Members’ name";
	$lang_bm = "Business Model";
	$lang_award = "Award history";
	$lang_career = "Career";
	$lang_ability = "Team’s Ability";
	$lang_process = "Your workflow process";
  $lang_team_board = "Team board";
  $lang_join = "Join";

  $lang_mod_comment = "Modify comments";
  $lang_success_cmt = "Your comment has been successfully changed.";
}else{
	$lang_register = "신규 팀 등록";
	$lang_mod_team = "팀 수정";

	$lang_info = "기본정보";
	$lang_name = "팀 이름";
  $lang_leader = "팀 리더";
	$lang_member = "팀원";
	$lang_bm = "비즈니스 모델";
	$lang_award = "수상이력";
	$lang_career = "경력";
	$lang_ability = "보유역량";
	$lang_process = "진행사항";
  $lang_team_board = "팀 게시판 가기";
  $lang_join = "함께하기";

  $lang_mod_comment = "댓글 수정";
  $lang_success_cmt = "댓글을 성공적으로 변경하였습니다.";
}
?>

<style>
.file-upload {
    position: relative;
    overflow: hidden;
    margin: 10px;
}
.file-upload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
</style>
<? if($_SESSION['idx'] == $result['leader_idx']){
      $acc_query = mysql_query("SELECT `idx`, `from_user_idx`, `from_user_name` FROM `user_alarm`
                              WHERE `article_idx`='{$idx}' AND `type` = 'team_acc' AND `read_chk`=1");
      $acc = mysql_num_rows($acc_query);
      if($acc > 0){
?>
  <div class="ui segment basic" id="userPage" style="margin-bottom:30px;">
    <div class="ui items">
<? while($acc_data = mysql_fetch_array($acc_query)){ ?>
    <div class="item" style="position: relative;">
      <div style="position:left; width:70%;">
      <a href='/public/userpage?id=<?= $acc_data['from_user_idx'] ?>'>
    		<?= $acc_data['from_user_name'] ?></a>
      </div>
      <div style="position:right; width:30%;">
      <a href="/public/do_join_team.php?team_idx=<?= $idx ?>&user_idx=<?= $acc_data['from_user_idx']?>&join=0&alarm_idx=<?= $acc_data['idx']?>">
        <button class="ui button basic float--right">거절</button></a>
      <a href="/public/do_join_team.php?team_idx=<?= $idx ?>&user_idx=<?= $acc_data['from_user_idx']?>&join=1&alarm_idx=<?= $acc_data['idx']?>">
        <button class="ui button basic float--right">승인</button></a>
      </div>
    </div>
<? } ?>
          </tbody>
      </table>
    </div>
  </div>
    <? } ?>
<? } ?>
<div class="ui segment basic" id="userPage">
    <div class="ui items">
        <div class="item" style="position: relative;">
            <div style="position: absolute; top: 0; right: 0;">

                <!--<div class="ui divided selection list" style="margin-top:0;">
                    <a class="item">
                        <div class="ui horizontal label">로그인 횟수</div>
                        30회
                    </a>
                    <a class="item">
                        <div class="ui horizontal label">마지막 로그인</div>
                        3달 전
                    </a>
                </div>-->
            </div>

            <div class="content" style="float: left; width: 80%;">
                <h1 class="ui header"><?=$result['name']?></h1>
                <div class="meta">
                    <span><i class="bookmark icon" style="margin-right:0.4em;"></i><?= $lang_leader ?></span> <a href="/public/userpage?id=<?=$usr['idx']; ?>">@<?=$usr['name']?></a>
                </div>
                <div class="meta">
                    <?
                    $tm_query = mysql_query("SELECT `idx`, `name` FROM `user` WHERE `team_idx`='$idx' AND `idx` != '{$result['leader_idx']}'");
                    $tm_num = mysql_num_rows($tm_query);
                    ?>
                    <span><i class="bookmark icon" style="margin-right:0.4em;"></i><?= $lang_member ?>(<?= $tm_num ?><?= $lang_people ?>)</span>
                    <? while($tm_data = mysql_fetch_array($tm_query)){ ?>
                     <a href="/public/userpage?id=<?= $tm_data['idx'] ?>"><?=$tm_data['name']?></a>
                    <? } ?>
                </div>
                <div class="meta clearfix">
                    <a href="/public/bm_grade?board_id=business_model&article_id=<?=$bm['idx']; ?>"><div class="ui label teal">@<?=$bm['title']; ?></div></a>
                </div>
            </div>
            <div style="width: 20%; float:right; margin:auto;">
            <a href="/public/board_list?board_type=team&board_id=<?=$result['idx'] ?>" target="_blank">
            	<button class="ui blue basic button"><?= $lang_team_board ?></button></a>
            </div>
        </div>
        <div class="clearfix">
        <? if($_SESSION['idx'] == $result['leader_idx']) { ?>
            <a href="/public/do_del_team.php?idx=<?=$result['idx']; ?>"><button class="ui button basic float--right"><i class="ui icon privacy"></i> <?= $lang_delete ?></button></a>
            <a href="/public/team_new?type=edit&idx=<?=$result['idx']; ?>"><button class="ui button basic float--right"><i class="ui icon laptop"></i> <?= $lang_modify ?></button></a>
            <!--<button class="ui button basic primary float--right"><i class="ui icon cloud upload"></i> 프로필사진 변경</button>-->
        <? }else if($idx == $user_data['team_idx']){ ?>
            <a href="/public/do_join_team.php?team_idx=<?= $result['idx'] ?>&join=0"><button class="ui button basic float--right">탈퇴하기</button></a>
        <? }else{
              $acc = mysql_num_rows(mysql_query("SELECT `idx` FROM `user_alarm`
                    WHERE `type`='team_acc' AND `article_idx`='{$idx}' AND `from_user_idx`='{$_SESSION['idx']}' AND `read_chk`=1"));
               if($acc){ ?>
            <button class="ui button basic float--right">승인중</button>
            <? }else{ ?>
            <a href="/public/do_join_team.php?team_idx=<?= $result['idx'] ?>&join=1"><button class="ui button basic float--right"><?= $lang_join ?></button></a>
            <? } ?>
        <? } ?>
       </div>
       <div class="ui divider"></div>
        <h3 class="ui header"><?= $lang_award ?></h3>
        <p>
            <?=$result['award']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header"><?= $lang_career ?></h3>
        <p>
            <?=$result['history']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header"><?= $lang_ability ?></h3>
        <p>
            <?=$result['ability']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header"><?= $lang_process ?></h3>
        <p>
            <?=$result['progress']?>
        </p>

    </div>
</div>

<script>

function modify_comment(comment_idx, parent_idx, content) {

    $('.comment.modal').attr('id', comment_idx);
    $('.comment.modal')
      .modal('show')
    ;
}

function comment_action(){
//$("#password_change_form").submit();

    var comment_idx = $('.comment.modal').attr('id');

    $.ajax({
        type : "POST",
        url : "./do_edit_comment.php",
        data : {
            "comment_idx" : comment_idx,
            "content" : content
        },
        success : function (result) {
            if(result == "success"){
                alert("<?= $lang_success_cmt ?>");
                $(".comment.modal").modal('hide');
                window.location.reload(true);
            }else{
                alert(result);
            }
        }
    });
}
</script>

<div class="ui comment modal">
  <i class="close icon"></i>
  <div class="header">
    <?= $lang_mod_comment ?>
  </div>
  <div class="content">
    <div class="ui form" style="margin:0; ">
        <textarea name="comment" id="edit_area"></textarea>
    </div>
  </div>
  <div class="actions">
    <div class="ui green button" onClick="comment_action()"><?= $lang_modify ?></div>
  </div>
</div>
