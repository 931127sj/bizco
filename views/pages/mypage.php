<?
  require_once(VIEW.'common/_language.php');

  if($_SESSION['lang'] == "en"){
    $lang_email = "E-mail address";
    $lang_name = "Name";
    $lang_pw = "Password";
    $lang_repw = "Retype password";
    $lang_phone = "Phone";
    $lang_course = "Course";
    $lang_team = "Team name";
    $lang_motivation = "Participation Motivation";
    $lang_position = "Position";
    $lang_career = "Startup career";
    $lang_abilities = "Abilities";
    $lang_stage = "Stage";
    $lang_idea = "Idea stage";
    $lang_proto = "Prototype stage";
    $lang_launching = "Launching stage";
    $lang_investment = "Investment stage";
    $lang_resource = "Resources which you need to startup";
    $lang_change_profile = "Change profile photo";
    $lang_change_pw = "Change Password";
    $lang_change_info = "Changing information";

    $lang_success_pw = "Your password was successfully changed.";
    $lang_success_info = "Successfully changed user information.";
    $lang_success_profile = "Your profile photo has been changed successfully.";

  }else{
    $lang_email = "이메일";
    $lang_name = "이름";
    $lang_pw = "암호";
    $lang_repw = "암호 재입력";
    $lang_phone = "연락처";
    $lang_course = "참여";
    $lang_team = "팀 이름";
    $lang_motivation = "참여 동기";
    $lang_position = "참여 파트";
    $lang_career = "창업이력";
    $lang_abilities = "보유역량";
    $lang_stage = "진행사항";
    $lang_idea = "아이디어 단계";
    $lang_proto = "시제품 제작 단계";
    $lang_launching = "제품 런칭 단계";
    $lang_investment = "투자 단계";
    $lang_resource = "사업에 필요한 자원";
    $lang_change_profile = "프로필사진 변경";
    $lang_change_pw = "비밀번호 변경";
    $lang_change_info = "정보수정";

    $lang_success_pw = "비밀번호를 성공적으로 변경하였습니다.";
    $lang_success_info = "사용자정보를 성공적으로 변경하였습니다.";
    $lang_success_profile = "프로필 사진이 정상적으로 변경되었습니다.";
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
<div class="ui segment basic" id="userPage">
    <div class="ui items">
        <div class="item" style="position: relative;">
            <div style="position: absolute; top: 0; right: 0;">
                <h3 class="ui header" style="margin-bottom:0;">참가자</h3>
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

            <div class="image">
                <img src="<?=get_profile_url($_SESSION['idx']);  ?>">
            </div>
            <div class="content">
            <?php

            require_once '_common.php';

            $query = mysql_query("SELECT * from user where idx = '".$_SESSION['idx']."'");
            $result = mysql_fetch_array($query);

            ?>
                <h1 class="ui header"><?=$result['name']?></h1>
                <div class="meta">
                    <span><i class="bookmark icon" style="margin-right:0.4em;"></i><?=$result['position']?></span> <a href="#">@<?=$result['team_id']?></a>
                </div>
                <div class="meta">
                    <span><i class="mail icon"></i> <?=$result['email']?></span>
                </div>
                <div class="meta clearfix">
                    <div class="ui label teal"><?=$result['part']?></div>

                </div>
                <div class="clearfix">

                    <form id="profile" action="/public/do_modify_profile.php" method="post" enctype="multipart/form-data">
                        <div class="file-upload ui button basic primary float--right">
                            <span><i class="ui icon cloud upload"></i> <?= $lang_change_profile ?></span>
                            <input type="file" name="profile" class="upload" />
                        </div>
                    </form>

                    <button class="ui button basic float--right" onclick="$('.modal.small.password').modal('show');"><i class="ui icon privacy"></i> <?= $lang_change_pw ?></button>

                    <button class="ui button basic float--right" onclick="$('.modal.small.info').modal('show');"><i class="ui icon laptop"></i> <?= $lang_change_info ?></button>


                    <!--<button class="ui button basic primary float--right"><i class="ui icon cloud upload"></i> 프로필사진 변경</button>-->
                </div>
            </div>
        </div>
       <div class="ui divider"></div>
        <h3 class="ui header"><?= $lang_motivation ?></h3>
        <p>
            <?=$result['join_type']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header"><?= $lang_stage ?></h3>
        <p>
            <?=$result['progress']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header"><?= $lang_career ?></h3>
        <p>
            <?=$result['history']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header"><?= $lang_abilities ?></h3>
        <p>
            <?=$result['skills']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header"><?= $lang_resource ?></h3>
        <p>
            <?=$result['business_resource']?>
        </p>


    </div>
</div>

<div class="ui modal small password">
    <i class="close icon"></i>
    <div class="header"><?= $lang_change_pw ?></div>
    <div class="content">
        <form class="ui form" action = "./do_edit_password.php" method = "post" id = "password_change_form">
            <div class="two fields">
                <div class="field">
                    <label>현재 패스워드</label>
                    <input type="password" placeholder="현재 패스워드" name="password_old" id="password_old">
                </div>
                <div class="field">
                    <label>변경할 패스워드</label>
                    <input type="password" placeholder="새로 변경할 패스워드" name="password" id="password">
                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui button" onClick="cancle()"><?= $lang_cancel ?></div>
        <div class="ui primary button" onClick="change()"><?= $lang_modify ?></div>
    </div>
</div>

<div class="ui modal small info">
    <i class="close icon"></i>
    <div class="header"><?= $lang_change_info ?></div>
    <div class="content">
    <?
        $query = mysql_query("SELECT * from user where idx = '".$_SESSION['idx']."'");
        $result = mysql_fetch_array($query);
     ?>
        <form class="ui form" action = "./do_edit_info.php" method = "post" id = "info_change_form">

            <div class="one field">
                <div class="required field">
                    <label><?= $lang_team ?></label>
                    <input type="text" placeholder="<?= $lang_team ?>" name="team_id" id="team_id" value="<?=$result['team_id'] ?>">
                </div>
            </div>

            <div class="one field">
                <div class="required field">
                    <label><?= $lang_motivation ?></label>
                    <input type="text" placeholder="<?= $lang_motivation ?>" name="join_type" id="join_type" value="<?=$result['join_type'] ?>">
                </div>
            </div>

            <div class="two fields">
               <div class="required field">
                    <label><?= $lang_position ?></label>
                    <select name="part" id="part" class="ui fluid dropdown" required>
                        <option value="개발자" <?=($result['part']=="개발자")?"selected=\"selected\"":""; ?>><?= $lang_developer ?></option>
                        <option value="디자이너" <?=($result['part']=="디자이너")?"selected=\"selected\"":""; ?>><?= $lang_designer ?></option>
                        <option value="기획자" <?=($result['part']=="기획자")?"selected=\"selected\"":""; ?>><?= $lang_planner ?></option>
                    </select>
                </div>
                <div class="required field">
                    <label><?= $lang_stage ?></label>
                    <select name="progress" id="progress" class="ui fluid dropdown" required>
                        <option value="아이디어 단계" <?=($result['progress']=="아이디어 단계")?"selected=\"selected\"":""; ?>><?= $lang_idea ?></option>
                        <option value="시제품 제작 단계" <?=($result['progress']=="시제품 제작 단계")?"selected=\"selected\"":""; ?>><?= $lang_proto ?></option>
                        <option value="제품 런칭 단계" <?=($result['progress']=="제품 런칭 단계")?"selected=\"selected\"":""; ?>><?= $lang_launching ?></option>
                        <option value="투자 단계" <?=($result['progress']=="투자 단계")?"selected=\"selected\"":""; ?>><?= $lang_investment ?></option>
                    </select>
                </div>
            </div>

            <div class="one field">
                <div class="field">
                    <label><?= $lang_career ?></label>
                    <textarea type="text" placeholder="<?= $lang_career ?>" name="history" id="history"><?=$result['history'] ?></textarea>
                </div>
            </div>

            <div class="one field">
                <div class="field">
                    <label><?= $lang_abilities ?></label>
                    <textarea type="text" placeholder="C++, JAVA, PHP, etc.." name="skills" id="skills"><?=$result['skills'] ?></textarea>
                </div>
            </div>

            <div class="one field">
                <div class="field">
                    <label><?= $lang_resource ?></label>
                    <textarea type="text" placeholder="<?= $lang_resource ?>" name="business_resource" id="business_resource" ><?=$result['business_resource'] ?></textarea>
                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui button" onClick="cancle()"><?= $lang_cancel ?></div>
        <div class="ui primary button" onClick="info_change()"><?= $lang_modify ?></div>
    </div>
</div>

<script>

    function cancle(){
        $(".modal").modal('hide');
    }

    function change(){
       //$("#password_change_form").submit();
       $.ajax({
            type : "POST",
            url : "./do_edit_password.php",
            data : {
                "password_old" : $("#password_old").val(),
                "password" : $("#password").val()
            },
            success : function (result) {
                if(result == "success"){
                    alert("<?= $lang_success_pw ?>");
                    $(".modal").modal('hide');
                }else{
                    alert(result);
                }
            }
        });
    }

    function info_change(){
       //$("#password_change_form").submit();
       $.ajax({
            type : "POST",
            url : "./do_edit_info.php",
            data : {
                "team_id" : $("#team_id").val(),
                "join_type" : $("#join_type").val(),
                "part" : $("#part").val(),
                "progress" : $("#progress").val(),
                "business_resource" : $("#business_resource").val(),
                "history" : $("#history").val(),
                "skills" : $("#skills").val()

            },
            success : function (result) {
                if(result == "success"){
                    alert("<?= $lang_success_info ?>");
                    $(".modal").modal('hide');
                    window.location.reload(true);
                }else{
                    alert(result);
                }
            }
        });
    }

    $('input[type=file]').change(function(e){
        //alert("a");

        var formData = new FormData();
        formData.append("profile", $("input[name=profile]")[0].files[0]);
        $.ajax({
            url: '/public/do_modify_profile.php',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){
                alert(data);
                if(data == "<?= $lang_success_profile ?>"){
                    window.location.reload(true);
                }
            }
        });
    });
</script>
