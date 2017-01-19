<!DOCTYPE html><html><head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<title><?=is($this->title, true)?:'App Name'?></title><?php echoAssets($this->headerFiles); ?></head><body>

	<?php
	if($_GET['lang']) $_SESSION['lang'] = $_GET['lang'];

	if (! preg_match('/\.php/', $_SERVER['REQUEST_URI'])) {
		$usr = mysql_query("SELECT * FROM  `user` WHERE  `idx` =".$_SESSION["idx"]);
		$usr_data = mysql_fetch_array($usr);

		$alarm_query = mysql_query("SELECT * FROM `user_alarm` WHERE `to_user_idx` = ".$_SESSION["idx"]);
		$alarm_count = mysql_num_rows($alarm_query);

	  // 나중에 dankook이 아닌 동적으로 처리를 해야합니다.
	  $qs_count = mysql_query("SELECT
	      (SELECT count(idx) FROM `article` WHERE `company_id` = '{$_SESSION['company_id']}' AND `board_id` = 'program_notice') as program_notice,
	      (SELECT count(idx) FROM `article` WHERE `company_id` = '{$_SESSION['company_id']}' AND `board_id` = 'business_model') as business,
	      (SELECT count(idx) FROM `user` WHERE `company_id` ='{$_SESSION['company_id']}') as join_user,
	      (SELECT count(idx) FROM `design_thinking` WHERE `company_id` ='{$_SESSION['company_id']}') as design_thinking");
	  $rs_counts = mysql_fetch_array($qs_count);

		// menu
		if($_SESSION['lang'] == "en"){
			$logout = "Log out";
			$curriculum = "Curriculum";
			$businessmodel = "Business Model";
			$join = "Join";
			$teambuilding = "Team Building";
			$designthinking = "Design Thinking";
			$participants = "Participants";
			$mentoring = "Mentoring";
			$mentorlist = "Mentor List";
			$mentoringboard = "Mentoring Board";
			$boards = "Boards";
			$notice = "Notice";
			$downloads = "Downloads";
			$administrator = "Administrator menu";
			$mentorboard = "Mentor Board";
			$assignmentcheck ="Assignment Check";
			$manageparticipants = "Manage participants";
			$managestepassignment = "Manage Step/Assignment";
			$manageprograms = "Manage Programs";
			$sendmessage = "Send Message";
		}else{
			$logout = "로그아웃";
			$curriculum = "커리큘럼";
			$businessmodel = "비즈니스 모델";
			$join = "함께해요";
			$teambuilding = "팀 빌딩";
			$designthinking = "디자인 씽킹";
			$participants = "참가자";
			$mentoring = "멘토링";
			$mentorlist = "멘토 리스트";
			$mentoringboard = "멘토링 게시판";
			$boards = "통합 게시판";
			$notice = "공지사항";
			$downloads = "자료실";
			$administrator = "관리자 메뉴";
			$mentorboard = "멘토링 답변";
			$assignmentcheck ="참가자 과제 확인";
			$manageparticipants = "참가자 관리";
			$managestepassignment = "스텝/과제 관리";
			$manageprograms = "프로그램 관리";
			$sendmessage = "전체 메세지 보내기";
		}
	?>

<nav class="ui top fixed secondary menu">
    <div class="header item" style="padding:6px 13px">
        <div class="ui text container logo">
            <a id="headerLogo" href="http://sbe.center/public"><img src="../../assets/css/logo_top.png" alt="Startup on the base of Entrepreneurship"></a>
        </div>
    </div>
		<div class="left menu" style="margin-left:20px;">
			<a class="item" href="javascript:setLeft('ko');" style="color:white;">한국어</a>&nbsp;&nbsp;
			<a class="item" href="javascript:setLeft('en');" style="color:white;">English</a>
		</div>
    <div class="right menu">
				<? if($alarm_count > 0){ ?>
					<div class="ui dropdown item">
						<?= $alarm_count ?>
						<div class="menu">
						<? while($alarm_data = mysql_fetch_array($alarm_query)) {
							$from_user_name = $alarm_data['from_user_name'];
							$article_idx = $alarm_data['article_idx'];

							$board_query = mysql_query("SELECT `board_id` FROM `article` WHERE `idx` = '$article_idx'");
							$board_data = mysql_fetch_array($board_query);
							$board_id = $board_data['board_id'];

							if($alarm_data['type'] == 'comment'){
								$alarm_msg = "<b>{$from_user_name}</b> 님이 댓글을 달았습니다.";
								$alarm_url = "/public/view_article?board_id={$board_id}&article_id={$article_idx}";
							}
							?>
							<a class="item" href="<?= $alarm_url ?>"><?= $alarm_msg ?></a>
						<? } ?>
						</div>
					</div>
				<? }else{ ?>
					<a class="ui item" style="background:rgba(0, 0, 0, 0.03);"><?= $alarm_count ?></a>
				<? } ?>
        <a class="ui item" href="/public/mypage"><strong><? echo $_SESSION['name']; ?></strong> 님</a>
        <a class="ui item logout" href="/public/do_logout.php">
            <?= $logout ?>
        </a>
    </div>
</nav>
<div id="menuCover">
<div class="ui secondary pointing menu basic-center">
    <a class="item <?=($_SESSION['current_menu']=="cur")?"active deep-blue":""; ?>" href="/public/cur_step">
        <?= $curriculum ?>
    </a>
        <div class="ui dropdown item">
        <?= $businessmodel ?>
            <div class="menu">
                <a class="item <?=($_SESSION['current_menu']=='bm')?"active deep-blue":""; ?>" href="/public/bm_list?id=business_model">
                    <?= $businessmodel ?>
                </a>
                <a class="item <?=($_SESSION['current_menu']=='together')?"active deep-blue":""; ?>" href="/public/board_list?board_id=together">
                    <?= $join ?>
                </a>
            </div>
        </div>
    <a class="item <?=($_SESSION['current_menu']=='team')?"active deep-blue":""; ?>" href="/public/team_list">
    <?= $teambuilding ?>
    </a>
    <a class="item <?=($_SESSION['current_menu']=='dt')?"active deep-blue":""; ?>" href="/public/dt_list">
    <?= $designthinking ?>
    </a>
    <a class="item <?=($_SESSION['current_menu']=='user')?"active deep-blue":""; ?>" href="/public/group_user_list">
    <?= $participants ?>
    </a>
    <div class="ui dropdown item">
    <?= $mentoring ?>
        <div class="menu">
            <a class="item <?=($_SESSION['current_menu']=='mento')?"active deep-blue":""; ?>" href="/public/group_mento_list">
            <?= $mentorlist ?>
            </a>
            <a class="item <?=($_SESSION['current_menu']=='question')?"active deep-blue":""; ?>" href="/public/question_list">
            <?= $mentoringboard ?>
            </a>
        </div>
    </div>
    <div class="ui dropdown item">
    <?= $boards ?>

        <div class="menu">
            <a class="item <?=($_SESSION['current_menu']=='public_notice')?"active deep-blue":""; ?>" href="/public/board_list?board_id=program_notice">
            <?= $notice ?>
            </a>
            <a class="item <?=($_SESSION['current_menu']=='faq')?"active deep-blue":""; ?>" href="/public/faq_view">
            FAQ
            </a>
            <a class="item <?=($_SESSION['current_menu']=='filebox')?"active deep-blue":""; ?>" href="/public/board_list?board_id=filebox">
            <?= $downloads ?>
            </a>

        </div>
    </div>

    <? if($_SESSION['level'] >= 5) { ?>
    <div class="ui dropdown item <?=(in_array($_SESSION['current_menu'], ['manage_join_user', 'manage_user_tools', 'manage_step']))?"selection":""; ?>">
    <?= $administrator ?>
        <div class="menu">
            <a class="item admin" href="/public/question_list_mento">
            <?= $mentorboard ?>
            </a>
             <a class="item admin" href="/public/manage_join_user">
            <?= $assignmentcheck ?>
            </a>
             <a class="item admin" href="/public/manage_user_tools">
            <?= $manageparticipants ?>
            </a>
             <a class="item admin" href="/public/manage_step">
            <?= $managestepassignment ?>
            </a>
						<? if($_SESSION['level'] >= 7){ ?>
						<a class="item admin" href="/public/manage_company">
            <?= $manageprograms ?>
            </a>
						<? } ?>
						<a class="item admin" href="/public/manage_message">
						<?= $sendmessage ?>
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

<script type="text/javascript">
	function setLeft(str)
	{
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				if(str=="hide")
				{
					document.getElementById("left_side").style.display='none';
					document.getElementById("left_side_show").style.display='';
				}
				if(str=="show")
				{
					document.getElementById("left_side").style.display='';
					document.getElementById("left_side_show").style.display='none';
				}
			}
		}
		xmlhttp.open("GET","setSession.php?lang="+str,true);
		xmlhttp.send();
		location.reload();
	}
</script>
