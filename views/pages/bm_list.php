<?
$_SESSION['current_menu'] = "bm";
$company_id = $_SESSION['company'];
///////////////////SERVER
$board_id = $_GET['id'];
$q        = $_GET['q']; // 검색어
$order    = $_GET['order']; // 정렬

$search_user = "";
$search_query = "";

/////////////////////BOARD CONTENT
if ($q) {
    $search_user_query = mysql_query("SELECT `idx` from `startup`.`user` WHERE `user`.`name` like '%".mysql_escape_string($q)."%'");
    $search_user_total = mysql_num_rows($search_user_query);

    $search_user = " ";
    if($search_user_total > 0){
    	while($search_user_data = mysql_fetch_array($search_user_query)){
    		$search_user .= " OR `article`.`user_idx`={$search_user_data['idx']}";
    	}
    }

    $search_query = " AND (`article`.`title` like '%".mysql_escape_string($q)."%' OR `article`.`content` like '%".mysql_escape_string($q)."%' {$search_user}) ";
}

if ($order === 'hot') {
    $order_query = " ORDER BY grade_count DESC ";
} else {
    $order_query = " ORDER BY  `article`.`idx` DESC ";
}
$article_query = mysql_query("SELECT `article`.*, floor(count(`bg`.`idx`)/2) as grade_count, `be_data`.`content` as message, `bm_count`.`developer_count`, `bm_count`.`designer_count`, `bm_count`.`planner_count`
                              FROM  `article`
                              LEFT JOIN `bm_grade` as `bg`
                              ON `bg`.`article_idx` = `article`.`idx`
                              LEFT JOIN `board_extend_data` as `be_data`
                              ON `be_data`.`article_idx` = `article`.`idx`
                              AND `be_data`.`extend_idx` = 'message'
                              LEFT JOIN `view_bm_recruit_count` as `bm_count`
                              on `bm_count`.`article_idx` = `article`.`idx`
                              WHERE  `article`.`company_id` =  '$company_id'
                              AND  `article`.`board_id` =  'business_model'
							  {$search_query}
                              GROUP BY `article`.`idx`
                              {$order_query}");
?>
<div class="clearfix">
    <h2 class="ui header floated left" style="margin-bottom: 0; margin-top: 5px;">비즈니스 모델 리스트</h2>
    <a href="/public/bm_new?id=business_model" class="ui right floated blue button">비즈니스 모델 등록</a>
    <a href="/public/board_list?board_id=together" class="ui right floated blue button">팀원 구하기</a>
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
    $bm_total = mysql_num_rows($article_query);

    if($bm_total == 0){
    	?>
            <div class="event bm">
    		<?
    			if($q){
    				echo "<span style='margin:auto;'>검색 결과가 존재하지 않습니다.</span>";
    			}else{
    				echo "<span style='margin:auto;'>게시판에 글을 작성해 주세요.</span>";
    			}
    		?>
            </div>
    <?
    }

    while($article_data = mysql_fetch_array($article_query)) {
        $score_query    = mysql_query("SELECT *
                                       FROM  `bm_grade`
                                       WHERE  `article_idx` =".$article_data['idx']."
                                       AND  `user_idx` =".$_SESSION['idx']);
?>
        <? if($count > 1) { ?><div class="ui divider"></div><? } ?>
        <div class="event bm">
            <div class="label">
                <img src="<?=get_profile_url($article_data['user_idx']);  ?>">
            </div>
            <div class="content">
                <div class="summary">
                    <a class="user">
                        <?=$article_data['user_name']?>
                    </a><a href="/public/bm_grade?board_id=<?=$board_id?>&article_id=<?=$article_data['idx'] ?>"> “<?=xssHtmlProtect($article_data['title'])?>”</a>
                    <div class="date">
                        <?=dateToSNSString($article_data['write_datetime'])?>
                    </div>
                    <? if(mysql_num_rows($score_query) >= 1): ?>
                    <a class="ui horizontal mini green label">평가완료</a>
 					<? else: ?>
                    <a class="ui horizontal mini orange label">미평가</a>
                    <? endif; ?>
                    <a class="ui horizontal mini teal label">기획 <div class="detail"><?=$article_data['planner_count']?:0?></div></a>
                    <a class="ui horizontal mini blue label">디자이너 <div class="detail"><?=$article_data['designer_count']?:0?></div></a>
                    <a class="ui horizontal mini green label">개발자 <div class="detail"><?=$article_data['developer_count']?:0?></div></a>
                </div>
                <div class="extra text"><?=xssHtmlProtect($article_data['message'])?></div>
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
