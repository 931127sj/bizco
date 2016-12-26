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
             
            </div>
            <div class="image">
                <img src="<?=get_profile_url($_GET['id']);  ?>">
            </div>
            <div class="content">
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
        

    </div>
</div>
