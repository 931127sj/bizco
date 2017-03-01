<?
require_once(VIEW.'common/_language.php');

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

if ($board_id == "lading_question"){
    $where_query = "";
}else{
    $where_query = "WHERE  `article`.`company_id` =  '$company_id'";
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
                              {$where_query}
                              AND  `article`.`board_id` =  'business_model'
							                {$search_query}
                              GROUP BY `article`.`idx`
                              {$order_query}");

if($_SESSION['lang'] == 'en'){
  $lang_bml = "Business Model List";
  $lang_bmr = "Register B.M.";
  $lang_join = "Join";
  $lang_ratings = " ratings";

}else{
  $lang_bml = "비즈니스 모델 리스트";
  $lang_bmr = "비즈니스 모델 등록";
  $lang_join = "팀원 구하기";
  $lang_ratings = "개의 평가";

}
?>
<div class="clearfix">
    <h2 class="ui header" style="margin-bottom: 0; margin-top: 5px;"><?= $lang_bml ?></h2>
</div>
<div class="ui grid" style="margin-bottom: 30px;">
  <div class="four wide column">
    <div class="ui basic buttons">
      <div class="ui button"><a href="/public/bm_list?id=business_model&order=recent"><?= $lang_latest ?></a></div>
      <div class="ui button"><a href="/public/bm_list?id=business_model&order=hot"><?= $lang_popular ?></a></div>
    </div>
  </div>
  <form class="eight wide column ui center aligned container">
      <div class="ui icon input">
          <input type="hidden" name="id" value="<?=$board_id?>">
          <input type="text" name="q" placeholder="<?= $lang_keywords ?>" value="<?=$q?>">
          <i class="search link icon"></i>
      </div>
  </form>
  <div class="right aligned four wide column">
      <a href="/public/bm_new?id=business_model" class="ui right floated blue button"><?= $lang_bmr ?></a>
      <a href="/public/board_list?board_id=together" class="ui right floated blue button"><?= $lang_join ?></a>
  </div>
</div>

<div class="ui grid">
  <?
    while($article_data = mysql_fetch_array($article_query)) {
          $score_query = mysql_query("SELECT * FROM  `bm_grade`
                                      WHERE  `article_idx` =".$article_data['idx']." AND  `user_idx` =".$_SESSION['idx']);
  ?>
  <div class="right aligned four wide column">
    <div class="ui mini label">
          <?= substr($article_data['write_datetime'], 0, 10) ?>
    </div>
    <div class="ui four top attached item mini menu">
      <? if(mysql_num_rows($score_query) >= 1): ?>
      <a class="active item"><?= $lang_complete ?></a>
      <? else: ?>
      <a class="active item"><?= $lang_incomplete ?></a>
      <? endif; ?>
      <a class="item"><?= $lang_planner ?> <div class="detail"><?=$article_data['planner_count']?:0?></div></a>
      <a class="item"><?= $lang_designer ?> <div class="detail"><?=$article_data['designer_count']?:0?></div></a>
      <a class="item"><?= $lang_developer ?> <div class="detail"><?=$article_data['developer_count']?:0?></div></a>
    </div>
    <div class="ui attached segment" style="padding:0px;">
      <img class="ui image" src="<?=get_profile_url($article_data['user_idx']);  ?>">
    </div>
    <div class="ui bottom attached segment">
      <p class="ui center aligned container">
      <a class="header" href="/public/bm_grade?board_id=<?=$board_id?>&article_id=<?=$article_data['idx'] ?>">
        <?=xssHtmlProtect($article_data['title'])?>
      </a>
      </p>
      <p class="ui center aligned container">
      <span class="user"><?=($article_data['user_name'])? $article_data['user_name'] : '&nbsp;'?></span>
      </p>
      <p class="ui center aligned container">
        <a class="ui primary button" href="/public/bm_grade?board_id=<?=$board_id?>&article_id=<?=$article_data['idx'] ?>">VIEW</a>
      </p>
      <p class="ui container">
      <?=number_format($article_data['grade_count'])?><?= $lang_ratings ?>
      </p>

    </div>
  </div>
  <? } ?>
</div>
