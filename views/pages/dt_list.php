<?
$_SESSION['current_menu'] = "dt";
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
$article_query = mysql_query("SELECT *
                              FROM  `design_thinking`");

?>
<div class="clearfix">
    <h2 class="ui header floated left" style="margin-bottom: 0; margin-top: 5px;">디자인씽킹 리스트</h2>
    <a href="/public/dt_article?id=design_thinking" class="ui right floated blue button">디자인씽킹 작성</a>
</div>
<form class="ui clearing segment selene-basic">
    <div class="ui icon input">
        <input type="hidden" name="id" value="<?=$board_id?>">
        <input type="text" name="q" placeholder="검색어" value="<?=$q?>">
        <i class="search link icon"></i>
    </div>
    <select name="order" class="ui dropdown">
        <option value="recent" <?=$order === 'hot'?'':'selected'?>>최근 업데이트</option>
        <option value="hot" <?=$order === 'hot'?'selected':''?>>인기</option>
    </select>
    <button class="ui right floated button">검색</button>
</form>
<div class="ui selene-basic segment">
    <div class="ui large feed">
<?
    $count = 1;
    while($article_data = mysql_fetch_array($article_query)) {
		$list_user_query= mysql_query("SELECT * FROM  `user` WHERE  `idx` =".$article_data['user_idx']);
		$list_user_data = mysql_fetch_array($list_user_query);
		$score_query    = mysql_query("SELECT *
									   FROM  `bm_grade`
									   WHERE  `article_idx` =".$article_data['idx']."
									   AND  `user_idx` =".$_SESSION['idx']);
?>
        <? if($count > 1) { ?><div class="ui divider"></div><? } ?>
        <div class="event">
            <div class="label">
                <img src="<?=get_profile_url($list_user_data['idx']);  ?>">
            </div>
            <div class="content">
                <div class="summary">
                    <a class="user">
                        <?=$list_user_data['name']?>
                    </a><a href="/public/dt_grade?id=<?=$article_data['idx'] ?>">의 디자인씽킹</a>
                    <div class="date">
                        <?=dateToSNSString($article_data['datetime'])?>
                    </div>
                    <? if(mysql_num_rows($score_query) >= 1): ?>
                    <a class="ui horizontal mini green label">평가완료</a>
 					<? else: ?>
                    <a class="ui horizontal mini orange label">미평가</a>
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
                        <i class="users icon"></i> <?=number_format($article_data['grade_count'])?>개의 평가
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