<!DOCTYPE html><html><head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<title><?=is($this->title, true)?:'App Name'?></title><?php echoAssets($this->headerFiles); ?></head><body>
<?php
if (! preg_match('/\.php$/', $_SERVER['REQUEST_URI'])) {
	$usr = mysql_query("SELECT * FROM  `user` WHERE  `idx` =".$_SESSION["idx"]);
	$usr_data = mysql_fetch_array($usr);

	$alarm_query = mysql_query("SELECT * FROM `user_alarm` WHERE `to_user_idx` = ".$_SESSION["idx"]);
	$alarm_count = mysql_num_rows($alarm_query);

    // 나중에 dankook이 아닌 동적으로 처리를 해야합니다.
    $qs_count = mysql_query("SELECT
        (SELECT count(idx) FROM `article` WHERE `company_id` = 'dankook' AND `board_id` = 'program_notice') as program_notice,
        (SELECT count(idx) FROM `article` WHERE `company_id` = 'dankook' AND `board_id` = 'business_model') as business,
        (SELECT count(idx) FROM `user` WHERE `company_id` ='dankook') as join_user,
        (SELECT count(idx) FROM `design_thinking` WHERE `company_id` ='dankook') as design_thinking");
    $rs_counts = mysql_fetch_array($qs_count);
?>

<nav class="ui top fixed secondary menu">
    <div class="header item" style="padding:6px 13px">
        <div class="ui text container logo">
            <a id="headerLogo" href="http://sbe.center/public"><img src="../../assets/css/logo_top.png" alt="Startup on the base of Entrepreneurship"></a>
        </div>
    </div>
    <div class="right menu">
        <a class="ui item" href="/public/mypage"><strong><? echo $_SESSION['name']; ?></strong> 님</a>
        <a class="ui item logout" href="/public/do_logout.php">
            로그아웃
        </a>
    </div>
</nav>
<div id="menuCover">
<div class="ui secondary pointing menu basic-center">
    <a class="item <?=($_SESSION['current_menu']=="cur")?"active deep-blue":""; ?>" href="/public/cur_step">
        커리큘럼
    </a>
        <div class="ui dropdown item">
        비즈니스 모델
            <div class="menu">
                <a class="item <?=($_SESSION['current_menu']=='bm')?"active deep-blue":""; ?>" href="/public/bm_list?id=business_model">
                    비즈니스 모델
                </a>
                <a class="item <?=($_SESSION['current_menu']=='together')?"active deep-blue":""; ?>" href="/public/board_list?board_id=together">
                    함께해요
                </a>
            </div>
        </div>
    <a class="item <?=($_SESSION['current_menu']=='team')?"active deep-blue":""; ?>" href="/public/team_list">
        팀 빌딩
    </a>
    <a class="item <?=($_SESSION['current_menu']=='dt')?"active deep-blue":""; ?>" href="/public/dt_list">
        디자인 씽킹
    </a>
    <a class="item <?=($_SESSION['current_menu']=='user')?"active deep-blue":""; ?>" href="/public/group_user_list">
        참가자
    </a>
    <div class="ui dropdown item">
        멘토링
        <div class="menu">
            <a class="item <?=($_SESSION['current_menu']=='mento')?"active deep-blue":""; ?>" href="/public/group_mento_list">
            멘토 리스트
            </a>
            <a class="item <?=($_SESSION['current_menu']=='question')?"active deep-blue":""; ?>" href="/public/question_list">
            멘토링 게시판
            </a>
        </div>
    </div>
    <div class="ui dropdown item">
        통합 게시판

        <div class="menu">
             <a class="item <?=($_SESSION['current_menu']=='public_notice')?"active deep-blue":""; ?>" href="/public/board_list?board_id=program_notice">
                공지사항
            </a>
            <a class="item <?=($_SESSION['current_menu']=='faq')?"active deep-blue":""; ?>" href="/public/faq_view">
                FAQ
            </a>
             <a class="item <?=($_SESSION['current_menu']=='filebox')?"active deep-blue":""; ?>" href="/public/board_list?board_id=filebox">
                자료실
            </a>

        </div>
    </div>

    <? if($_SESSION['level'] >= 5) { ?>
    <div class="ui dropdown item <?=(in_array($_SESSION['current_menu'], ['manage_join_user', 'manage_user_tools', 'manage_step']))?"selection":""; ?>">
        관리자 메뉴
        <div class="menu">
            <a class="item admin" href="/public/question_list_mento">
                멘토링 답변
            </a>
             <a class="item admin" href="/public/manage_join_user">
                참가자 과제확인
            </a>
             <a class="item admin" href="/public/manage_user_tools">
                참가자 관리
            </a>
             <a class="item admin" href="/public/manage_step">
                스탭/과제 관리
            </a>
        </div>
    </div>
    <? } ?>
</div>
</div>
<section class="ui fluid container">
<?php
}
?>
