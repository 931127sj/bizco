<?
$_SESSION['current_menu'] = "dt";
$company_id = $_SESSION['company'];

///////////////////SERVER
$board_id = $_GET['id'];
$q        = $_GET['q']; // 검색어
$order    = $_GET['order']; // 정렬

/////////////////////BOARD CONTENT
if ($q) {
    $search_query = "AND (`article`.`title` like '%".mysql_escape_string($q)."%' OR `article`.`content` like '%".mysql_escape_string($q)."%')";
} else {
    $search_query = "";
}
if ($order === 'hot') {
    $order_query = "ORDER BY grade_count DESC";
} else {
    $order_query = "ORDER BY  `article`.`idx` DESC";
}
$article_query = mysql_query("SELECT * FROM  `design_thinking` WHERE `company_id` = '$company_id' ORDER BY `idx` DESC");

if($_SESSION['lang'] == "en"){
  $lang_dt_list = "Design Thinking List";
  $lang_write_dt = "Write Design Thinking";
  $lang_dt = "'s design thinking";
  $lang_ratings = " ratings";
}else{
  $lang_dt_list = "디자인씽킹 리스트";
  $lang_write_dt = "디자인씽킹 작성";
  $lang_dt = "의 디자인씽킹";
  $lang_ratings = "개의 평가";
}
?>
<div class="clearfix">
    <h2 class="ui header floated left" style="margin-bottom: 0; margin-top: 5px;"><?= $lang_dt_list ?></h2>
    <a href="/public/dt_article?id=design_thinking" class="ui right floated blue button"><?= $lang_write_dt ?></a>
</div>
<form class="ui clearing segment selene-basic">
    <div class="ui icon input">
        <input type="hidden" name="id" value="<?=$board_id?>">
        <input type="text" name="q" placeholder="<?= $lang_keywords ?>" value="<?=$q?>">
        <i class="search link icon"></i>
    </div>
    <select name="order" class="ui dropdown">
        <option value="recent" <?=$order === 'hot'?'':'selected'?>><?= $lang_latest ?></option>
        <option value="hot" <?=$order === 'hot'?'selected':''?>><?= $lang_popular ?></option>
    </select>
    <button class="ui right floated button"><?= $lang_search ?></button>
</form>
<div class="ui selene-basic segment">
    <div class="ui large feed">
<?
    $count = 1;
    while($article_data = mysql_fetch_array($article_query)) {
		$score_query    = mysql_query("SELECT *
									   FROM  `bm_grade`
									   WHERE  `article_idx` =".$article_data['idx']."
									   AND  `user_idx` =".$_SESSION['idx']);
?>
        <? if($count > 1) { ?><div class="ui divider"></div><? } ?>
        <div class="event">
            <div class="label">
                <img src="<?=get_profile_url($article_data['user_idx']);  ?>">
            </div>
            <div class="content">
                <div class="summary">
                    <a class="user">
                        <?=$article_data['user_name']?>
                    </a><a href="/public/dt_grade?id=<?=$article_data['idx'] ?>"><?= $lang_dt ?></a>
                    <div class="date">
                        <?=dateToSNSString($article_data['datetime'])?>
                    </div>
                    <? if(mysql_num_rows($score_query) >= 1): ?>
                    <a class="ui horizontal mini green label"><?= $lang_complete ?></a>
 					<? else: ?>
                    <a class="ui horizontal mini orange label"><?= $lang_incomplete ?></a>
                    <? endif; ?>
                </div>
                <div class="extra text blank"><?=xssHtmlProtect($article_data['message'])?></div>
                <div class="meta">
                	<!--
                    <a class="star">
                        <i class="star icon"></i> 즐겨찾기
                    </a>
                    -->
                    <a class="users">
                        <i class="users icon"></i> <?=number_format($article_data['grade_count'])?><?= $lang_ratings ?>
                    </a>
                    <!--
                    <a class="comment">
                        <i class="comment icon"></i> 20개의 토론
                    </a>
                    -->
                </div>
            </div>
        </div>
    <? $count++; } ?>
    </div>
</div>
<script>
$(document).ready(function(){

})
</script>
