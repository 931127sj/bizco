<?
$_SESSION['current_menu'] = "team";
$company_id = $_SESSION['company'];

///////////////////SERVER
$board_id = $_GET['id'];
$q        = $_GET['q']; // 검색어
$order    = $_GET['order']; // 정렬

$my_team_query = mysql_query("SELECT `team_idx` FROM `user` WHERE `idx` = ". $_SESSION['idx']);
$my_team_data = mysql_fetch_array($my_team_query);
$my_team = $my_team_data['team_idx'];

/////////////////////BOARD CONTENT
if ($q) {
	$search_query = " AND (`team`.`name` like '%".mysql_escape_string($q)."%') ";
} else {
	$search_query = "";
}

?>
<div class="clearfix">
    <h2 class="ui header floated left" style="margin-bottom: 0; margin-top: 5px;">팀 리스트</h2>
    <a href="/public/team_new" class="ui right floated blue button">팀 등록</a>
    <a href="/public/board_list?board_id=together" class="ui right floated blue button">팀원 구하기</a>
</div>

<form class="ui clearing segment selene-basic">
    <div class="ui icon input">
        <input type="hidden" name="id" value="<?=$board_id?>">
        <input type="text" name="q" placeholder="<?= $lang_keywords ?>" value="<?=$q?>">
        <i class="search link icon"></i>
    </div>
    <button class="ui right floated button"><?= $lang_search ?></button>
</form>

<div class="ui selene-basic segment">
    <div class="ui large feed">
<?
    $count = 1;
	$team_query = mysql_query("SELECT * FROM  `team` WHERE `company_id`='$company_id' {$search_query} ORDER BY `idx` DESC");

	$team_total = mysql_num_rows($team_query);
	if($team_total == 0){
?>
        <div class="event bm">
		<?
			if($q){
				echo "<span style='margin:auto;'>{$no_result}</span>";
			}else{
				echo "<span style='margin:auto;'>{$please_write}</span>";
			}
		?>
        </div>
<?
	}

    while($team_data = mysql_fetch_array($team_query)) {
        $list_user_query= mysql_query("SELECT * FROM  `user` WHERE  `idx` =".$team_data['leader_idx']);
        $list_user_data = mysql_fetch_array($list_user_query);

		$bm_query= mysql_query("SELECT * FROM  `article` WHERE  `idx` =".$team_data['bm_idx']);
		$bm_data = mysql_fetch_array($bm_query);

?>
        <? if($count > 1) { ?><div class="ui divider"></div><? } ?>
        <div class="event bm">
            <div class="label">
                <img src="<?=get_profile_url($list_user_data['idx']);  ?>">
            </div>
            <div class="content">
                <div class="summary">
                    <a class="user"  href="/public/team_info?idx=<?=$team_data['idx']; ?>">
                        <?=$list_user_data['name']?>
                    </a><a href="/public/team_info?idx=<?=$team_data['idx']; ?>"> “<?=xssHtmlProtect($team_data['name'])?>”</a>
										<? if($team_data['idx'] == $my_team){ ?>
											<a class="ui horizontal mini green label">참여중</a>
										<? } ?>

                </div>
                <div style="font-size:12px; color:#3f63bf">
                	<a style=" color:#3f63bf"; href="/public/bm_grade?board_id=business_model&article_id=<?=$bm_data['idx']; ?>">@<?=$bm_data['title']; ?></a>
				</div>
                <div class="extra text" style="margin-top:10px;"><?=xssHtmlProtect($team_data['members'])?></div>
                <!--
                <div class="meta">
                    <a class="users">
                        <i class="users icon"></i> 팀원 0명
                    </a>
                </div>
                -->
            </div>
        </div>
    <? $count++; } ?>
    </div>
</div>
