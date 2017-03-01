<?
require_once(VIEW.'common/_language.php');

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

$team_query = mysql_query("SELECT * FROM  `team` WHERE `company_id`='$company_id' {$search_query} ORDER BY `idx` DESC");

if($_SESSION['lang'] == "en"){
	$lang_title = "Team List";
	$lang_join = "Join";
	$lang_register = "Register Team";
}else{
	$lang_title = "팀 리스트";
	$lang_join = "팀원 구하기";
	$lang_register = "팀 등록";
}
?>

<div class="clearfix">
    <h2 class="ui header" style="margin-bottom: 0; margin-top: 5px;"><?= $lang_title ?></h2>
</div>
<div class="ui grid" style="margin-bottom: 30px;">
  <div class="four wide column"></div>
  <form class="eight wide column ui center aligned container">
      <div class="ui icon input">
          <input type="hidden" name="id" value="<?=$board_id?>">
          <input type="text" name="q" placeholder="<?= $lang_keywords ?>" value="<?=$q?>">
          <i class="search link icon"></i>
      </div>
  </form>
  <div class="right aligned four wide column">
		<a href="/public/team_new" class="ui right floated blue button"><?= $lang_register ?></a>
		<a href="/public/board_list?board_id=together" class="ui right floated blue button"><?= $lang_join ?></a>
  </div>
</div>

<div class="ui grid">
	<?
	    while($team_data = mysql_fetch_array($team_query)) {
	        $list_user_query= mysql_query("SELECT * FROM  `user` WHERE  `idx` =".$team_data['leader_idx']);
	        $list_user_data = mysql_fetch_array($list_user_query);

			$bm_query= mysql_query("SELECT * FROM  `article` WHERE  `idx` =".$team_data['bm_idx']);
			$bm_data = mysql_fetch_array($bm_query);

	?>
  <div class="right aligned four wide column">
    <div class="ui attached segment" style="padding:0px;">
      <img class="ui image" src="<?= get_profile_url($list_user_data['idx']);  ?>">
    </div>
    <div class="ui bottom attached segment">
      <p class="ui center aligned container">
	      <a href="/public/team_info?idx=<?=$team_data['idx']; ?>"><?=xssHtmlProtect($team_data['name'])?></a>
      </p>
      <p class="ui center aligned container">
				<?
					$tm_query = mysql_query("SELECT `name`, `level` FROM `user` WHERE `team_idx` = {$team_data['idx']} ORDER BY `level` DESC");
					$tm_num = mysql_num_rows($tm_query);
					if($tm_num == 0) echo "{$team_data['members']}";
					while($tm_data = mysql_fetch_array($tm_query)){
							if($tm_data['level'] == 2){
								echo ", {$tm_data['name']}";
							}else{
								echo "{$tm_data['name']} (Leader)";
							}
					}
				?>
      </p>
      <p class="ui center aligned container">
        <a class="ui primary button" href="/public/team_info?idx=<?=$team_data['idx']; ?>">VIEW</a>
      </p>
    </div>
  </div>
  <? } ?>
</div>
