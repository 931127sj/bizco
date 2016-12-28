<?
$_SESSION['current_menu'] = "user";
$company_id = $_SESSION['company'];

//////////// SERVER
$user_query = mysql_query("SELECT *
FROM  `user`
WHERE  `company_id` ='$company_id'");
?>

<h2 class="ui header">참가팀 리스트</h2>
<div style="margin: 10px 0;">
    <div class="ui icon input">
        <input type="text" placeholder="Search...">
        <i class="search link icon"></i>
    </div>
    <select class="ui dropdown">
        <option value="">종류</option>
        <option value="1">지식서비스</option>
        <option value="2">제조업</option>
    </select>
    <a href="#" class="ui right floated primary button">팀 등록</a>
</div>
<div class="ui divider"></div>
<div class="ui stackable two column grid">
<? while($user_data =  mysql_fetch_array($user_query)) { ?>
    <div class="column">
        <div class="ui fluid card">
            <div class="content">
                <div class="header"><? echo $user_data['teamname']; ?></div>
                <div class="meta"><? echo $user_data['position']; ?></div>
                <div class="description">
                    <img class="ui top aligned small bordered image floated left" src="" style="height: 150px">
                    <p>
                        - 자기소개 <br>
                        <br>
                        자기소개가 없습니다.
                    </p>
                </div>
            </div><!--
            <div class="extra content">
                <a class="left floated like">
                    <i class="info circle icon"></i>
                    자세히
                </span>
                <a class="right floated">
                    <i class="mail icon"></i>
                    메세지
                </a>
            </div>
            -->
        </div>
    </div>
<? } ?>
</div>
