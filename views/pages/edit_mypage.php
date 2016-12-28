<?php

require_once '_common.php';

$query = mysql_query("SELECT * from user where idx = '".$_SESSION['idx']."'");
$result = mysql_fetch_array($query);

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
                            <span><i class="ui icon cloud upload"></i> 프로필사진 변경</span>
                            <input type="file" name="profile" class="upload" />
                        </div>
                    </form>

                    <button class="ui button basic float--right" onclick="$('.modal.small.password').modal('show');"><i class="ui icon privacy"></i> 비밀번호 변경</button>

                    <button class="ui button basic float--right" onclick="$('.modal.small.info').modal('show');"><i class="ui icon laptop"></i> 정보수정</button>


                    <!--<button class="ui button basic primary float--right"><i class="ui icon cloud upload"></i> 프로필사진 변경</button>-->
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


    </div>
</div>

<div class="ui modal small info">
    <i class="close icon"></i>
    <div class="header">정보수정</div>
    <div class="content">
        <form class="ui form" action = "./do_edit_info.php" method = "post" id = "info_change_form">
            <div class="two fields">
                <div class="required field">
                    <label>팀 이름</label>
                    <input type="text" placeholder="팀이름" name="team_id" id="team_id">
                </div>
                <div class="required field">
                    <label>역할</label>
                    <input type="text" placeholder="역할" name="position" id="position">
                </div>
            </div>

            <div class="one field">
                <div class="required field">
                    <label>참여동기</label>
                    <input type="text" placeholder="참여동기" name="join_type" id="join_type">
                </div>
            </div>

            <div class="two fields">
               <div class="required field">
                    <label>참여 파트</label>
                    <select name="part" class="ui fluid dropdown" required>
                        <option value="1">개발자</option>
                        <option value="2">디자이너</option>
                        <option value="3">기획자</option>
                    </select>
                </div>
                <div class="required field">
                    <label>진행사항</label>
                    <select name="progress" class="ui fluid dropdown" required>
                        <option value="1">아이디어 단계</option>
                        <option value="2">시제품 제작 단계</option>
                        <option value="3">제품 런칭 단계</option>
                        <option value="4">투자 단계</option>
                    </select>
                </div>
            </div>

            <div class="one field">
                <div class="field">
                    <label>창업이력</label>
                    <input type="text" placeholder="배달의민족 CEO" name="history" id="history">
                </div>
            </div>

            <div class="one field">
                <div class="field">
                    <label>보유역량</label>
                    <input type="text" placeholder="C++, JAVA, PHP, etc.." name="skills" id="skills">
                </div>
            </div>

            <div class="one field">
                <div class="field">
                    <label>사업에 필요한 자원</label>
                    <input type="text" placeholder="신규 기술 개발을 위한 투자유치" name="business_resource" id="business_resource">
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
            url : "./do_edit_info.php",
            data : {
                "company" : $("#company").val(),
                "team_id" : $("#team_id").val(),
                "position" : $("#position").val(),
                "join_type" : $("#join_type").val(),
                "part" : $("#part").val(),
                "progress" : $("#progress").val(),
                "business_resource" : $("#business_resource").val(),
                "history" : $("#history").val(),
                "skills" : $("#skills").val()

            },
            success : function (result) {
                if(result == "success"){
                    alert("사용자정보를 성공적으로 변경하였습니다.");
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
