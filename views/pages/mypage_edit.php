

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
<div class="ui segment basic">
    <div class="ui items">
        <div class="item" style="position: relative;">
            <div style="position: absolute; top: 0; right: 0;">
                <h3 class="ui header" style="margin-bottom:0;">멘토모드</h3>
                <div class="ui divided selection list" style="margin-top:0;">
                    <a class="item">
                        <div class="ui horizontal label">로그인 횟수</div>
                        null 회
                    </a>
                    <a class="item">
                        <div class="ui horizontal label">마지막 로그인</div>
                        null 달 전
                    </a>
                </div>
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
                    <span><?=$result['position']?></span> <a href="#">@<?=$result['company_id']?></a>
                </div>
                <div class="meta">
                    <span><i class="mail icon"></i> <?=$result['email']?></span>
                </div>
                <div class="meta clearfix">
                    <div class="ui label teal"><?=$result['part']?></div>
                    <div class="ui label">Startup on the base of Entrepreneurship</div>
                </div>
                <div class="clearfix">
                    <button class="ui button basic float--right" onclick="$('.modal.small.password').modal('show');"><i class="ui icon privacy"></i> 비밀번호 변경</button>
                    <form id="profile" action="/public/do_modify_profile.php" method="post" enctype="multipart/form-data">
                        <div class="file-upload ui button basic primary float--right">
                            <span><i class="ui icon cloud upload"></i> 프로필사진 변경</span>
                            <input type="file" name="profile" class="upload" />
                        </div>
                    </form>
                    <!--<button class="ui button basic primary float--right"><i class="ui icon cloud upload"></i> 프로필사진 변경</button>-->
                </div>
            </div>
        </div>
        <div class="ui divider"></div>
        <div class="field">
                    <textarea name="introduce" rows="2"></textarea>
                </div>
        <h3 class="ui header">자기소개</h3>
        <p>
                
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
        
    </div>
</div>

<div class="ui modal small password">
    <i class="close icon"></i>
    <div class="header">비밀번호 변경</div>
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
        <div class="ui button" onClick="cancle()">취소</div>
        <div class="ui primary button" onClick="change()">변경</div>
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
                    alert("비밀번호를 성공적으로 변경하였습니다.");
                    $(".modal").modal('hide');
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
            }
        });
    });

    </script>
</div>