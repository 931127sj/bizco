

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
            <?php

            require_once '_common.php';

            $idx = $_GET['idx'];

            $query = mysql_query("SELECT * 
                                    FROM  `team` 
                                    WHERE  `idx` =$idx");
            $result = mysql_fetch_array($query);

            $usr = mysql_fetch_array(mysql_query("SELECT * FROM  `user` WHERE  `idx` =".$result['leader_idx']));
            $bm =  mysql_fetch_array(mysql_query("SELECT * FROM  `article` WHERE  `idx` =".$result['bm_idx']));

            ?>
                <h1 class="ui header"><?=$result['name']?></h1>
                <div class="meta">
                    <span><i class="bookmark icon" style="margin-right:0.4em;"></i>팀 리더</span> <a href="/public/userpage?id=<?=$usr['idx']; ?>">@<?=$usr['name']?></a>
                </div>
                <div class="meta">
                    <span><i class="bookmark icon" style="margin-right:0.4em;"></i>팀원</span> <a href="#"><?=$result['members']?></a>
                </div>
                <div class="meta clearfix">
                    <a href="/public/bm_grade?board_id=business_model&article_id=<?=$bm['idx']; ?>"><div class="ui label teal">@<?=$bm['title']; ?></div></a>
                    
                </div>
                <? if($_SESSION['idx'] == $result['leader_idx']) { ?>
                <div class="clearfix">


                    <a href="/public/do_del_team.php?idx=<?=$result['idx']; ?>"><button class="ui button basic float--right"><i class="ui icon privacy"></i> 팀 삭제</button></a>

                    <a href="/public/team_new?type=edit&idx=<?=$result['idx']; ?>"><button class="ui button basic float--right"><i class="ui icon laptop"></i> 정보수정</button></a>

                    
                    <!--<button class="ui button basic primary float--right"><i class="ui icon cloud upload"></i> 프로필사진 변경</button>-->
                </div>
                <? } ?>
            </div>
            <div style="width: 20%; float:right; margin:auto;">
            <a href="/public/board_list?board_type=team&board_id=<?=$result['idx'] ?>" target="_blank">
            	<button class="ui blue basic button">팀 게시판 가기</button></a>
            </div>
        </div>
       <div class="ui divider"></div>
        <h3 class="ui header">수상이력</h3>
        <p>
            <?=$result['award']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header">경력</h3>
        <p>
            <?=$result['history']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header">보유역량</h3>
        <p>
            <?=$result['ability']?>
        </p>

        <div class="ui divider"></div>
        <h3 class="ui header">진행사항</h3>
        <p>
            <?=$result['progress']?>
        </p>

    </div>
</div>