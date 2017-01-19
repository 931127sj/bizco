<<<<<<< HEAD
<?php
  require_once '_common.php';

  $query = mysql_query("SELECT * from user where idx = '".$_GET['id']."'");
  $result = mysql_fetch_array($query);

  $total = mysql_num_rows($query);
  if($_GET['id'] == 0){
    msg("잘못된 접근입니다.");
    back();
  }else if($total == 0){
    msg("탈퇴한 회원입니다.");
    back();
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
<form class="ui large form"  action="/public/do_level_to_admin.php" method="post">
<input type="hidden" name="user_idx" value="<?=$_GET['id']?>">
<div class="ui segment basic" id="userPage">
    <div class="ui items">
        <div class="item" style="position: relative;">
            <div style="position: absolute; top: 0; right: 0;">

            </div>
            <div class="image">
                <img src="<?=get_profile_url($_GET['id']);  ?>">
            </div>
            <div class="content">
                <h1 class="ui header"><?=$result['name']?>
                </h1>
                <div class="meta">
                    <span><i class="bookmark icon" style="margin-right:0.4em;"></i><?=$result['position']?></span> <a href="#">@<?=$result['team_id']?></a>
                </div>
                <div class="meta">
                    <span><i class="mail icon"></i> <?=$result['email']?></span>
                </div>

                <div class="meta clearfix">
                    <div class="ui label teal"><?=$result['part']?></div>

                </div>

                <div class="meta clearfix">

                </div>

            </div>
        </div>
        <div class="ui divider"></div>
        <h3 class="ui header">참여동기</h3>
        <p>
            <?=$result['join_type']?>
        </p>
        
        <div class="ui divider"></div>
        <h3 class="ui header">연락처</h3>
        <p>
            <?=$result['phone']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header">진행사항</h3>
        <p>
            <?=$result['progress']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header">창업이력</h3>
        <p>
            <?=$result['history']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header">보유역량</h3>
        <p>
            <?=$result['skills']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header">사업에 필요한 자원</h3>
        <p>
            <?=$result['business_resource']?>
        </p>

        <? if($_SESSION['level'] > 4){
             $company_admin = mysql_num_rows(mysql_query("SELECT `idx` FROM `user`
                                          WHERE `company_id` = '{$result['company_id']}' AND `level` = 6"));
             $cquery = mysql_query("SELECT `name` FROM `company` WHERE `company_id` = '{$result['company_id']}'");
             $cdata = mysql_fetch_array($cquery);
           ?>
        <div class="ui divider"></div>
        <h3 class="ui header">회원 레벨 조정</h3>
        <select name="level" class="ui fluid dropdown" required>
          <? if($_SESSION['level'] > 6){?>
          <option value="7" <?= ($result['level'] == 7)? 'selected' : '' ;?>>사이트 관리자</option>
          <? } ?>
          <? if($_SESSION['level'] > 6 && $company_admin == 0){?>
          <option value="6" <?= ($result['level'] == 6)? 'selected' : '' ;?>><?=$cdata['name']?> 최종 관리자</option>
          <? } ?>
          <option value="5" <?= ($result['level'] == 5)? 'selected' : '' ;?>><?=$cdata['name']?> 관리자</option>
          <option value="4" <?= ($result['level'] == 4)? 'selected' : '' ;?>><?=$cdata['name']?> 멘토</option>
          <? if($result['team_idx'] > 0){
                $leader_chk = mysql_num_rows(mysql_query("SELECT `idx` FROM `team`
                                            WHERE `idx` = '{$result['team_idx']}' AND `leader_idx` = '{$_GET['id']}'"));
                if($leader_chk){
                ?>
                <option value="3" <?= ($result['level'] == 3)? 'selected' : '' ;?>><?=$cdata['name']?> 참여자</option>
                <? }?>
          <? }else{ ?>
            <option value="2" <?= ($result['level'] == 2)? 'selected' : '' ;?>><?=$cdata['name']?> 참여자</option>
          <? } ?>
        </select>
        <? } ?>

    </div>
</div>
<? if($_SESSION['level'] > 4){ ?>
<button class="ui button primary" type="submit" id = "save">저장</button>
<? } ?>
</form>
=======
<?php
  require_once '_common.php';
  require_once(VIEW.'common/_language.php');

  $query = mysql_query("SELECT * from user where idx = '".$_GET['id']."'");
  $result = mysql_fetch_array($query);

  $total = mysql_num_rows($query);
  if($_GET['id'] == 0){
    msg("잘못된 접근입니다.");
    back();
  }else if($total == 0){
    msg("탈퇴한 회원입니다.");
    back();
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
<form class="ui large form"  action="/public/do_level_to_admin.php" method="post">
<input type="hidden" name="user_idx" value="<?=$_GET['id']?>">
<div class="ui segment basic" id="userPage">
    <div class="ui items">
        <div class="item" style="position: relative;">
            <div style="position: absolute; top: 0; right: 0;">

            </div>
            <div class="image">
                <img src="<?=get_profile_url($_GET['id']);  ?>">
            </div>
            <div class="content">
                <h1 class="ui header"><?=$result['name']?>
                </h1>
                <div class="meta">
                    <span><i class="bookmark icon" style="margin-right:0.4em;"></i><?=$result['position']?></span> <a href="#">@<?=$result['team_id']?></a>
                </div>
                <div class="meta">
                    <span><i class="mail icon"></i> <?=$result['email']?></span>
                </div>

                <div class="meta clearfix">
                    <div class="ui label teal"><?=$result['part']?></div>

                </div>

                <div class="meta clearfix">

                </div>

            </div>
        </div>
        <div class="ui divider"></div>
        <h3 class="ui header">참여동기</h3>
        <p>
            <?=$result['join_type']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header">진행사항</h3>
        <p>
            <?=$result['progress']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header">창업이력</h3>
        <p>
            <?=$result['history']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header">보유역량</h3>
        <p>
            <?=$result['skills']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header">사업에 필요한 자원</h3>
        <p>
            <?=$result['business_resource']?>
        </p>

        <? if($_SESSION['level'] > 4){
             $company_admin = mysql_num_rows(mysql_query("SELECT `idx` FROM `user`
                                          WHERE `company_id` = '{$result['company_id']}' AND `level` = 6"));
             $cquery = mysql_query("SELECT `name` FROM `company` WHERE `company_id` = '{$result['company_id']}'");
             $cdata = mysql_fetch_array($cquery);
           ?>
        <div class="ui divider"></div>
        <h3 class="ui header">회원 레벨 조정</h3>
        <select name="level" class="ui fluid dropdown" required>
          <? if($_SESSION['level'] > 6){?>
          <option value="7" <?= ($result['level'] == 7)? 'selected' : '' ;?>>사이트 관리자</option>
          <? } ?>
          <? if($_SESSION['level'] > 6 && $company_admin == 0){?>
          <option value="6" <?= ($result['level'] == 6)? 'selected' : '' ;?>><?=$cdata['name']?> 최종 관리자</option>
          <? } ?>
          <option value="5" <?= ($result['level'] == 5)? 'selected' : '' ;?>><?=$cdata['name']?> 관리자</option>
          <option value="4" <?= ($result['level'] == 4)? 'selected' : '' ;?>><?=$cdata['name']?> 멘토</option>
          <? if($result['team_idx'] > 0){
                $leader_chk = mysql_num_rows(mysql_query("SELECT `idx` FROM `team`
                                            WHERE `idx` = '{$result['team_idx']}' AND `leader_idx` = '{$_GET['id']}'"));
                if($leader_chk){
                ?>
                <option value="3" <?= ($result['level'] == 3)? 'selected' : '' ;?>><?=$cdata['name']?> 참여자</option>
                <? }?>
          <? }else{ ?>
            <option value="2" <?= ($result['level'] == 2)? 'selected' : '' ;?>><?=$cdata['name']?> 참여자</option>
          <? } ?>
        </select>
        <? } ?>

    </div>
</div>
<? if($_SESSION['level'] > 4){ ?>
<button class="ui button primary" type="submit" id = "save"><?= $lang_update ?></button>
<? } ?>
</form>
>>>>>>> origin/master
