<?
require_once(VIEW.'common/_language.php');

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
    <h2 class="ui header" style="margin-bottom: 0; margin-top: 5px;"><?= $lang_dt_list ?></h2>
</div>
<div class="ui grid" style="margin-bottom: 30px;">
  <div class="four wide column">
    <div class="ui basic buttons">
      <div class="ui button"><a href="/public/dt_list?id=business_model&order=recent"><?= $lang_latest ?></a></div>
      <div class="ui button"><a href="/public/dt_list?id=business_model&order=hot"><?= $lang_popular ?></a></div>
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
      <a href="/public/dt_article?id=design_thinking" class="ui right floated blue button"><?= $lang_write_dt ?></a>
  </div>
</div>

<div class="ui grid">
  <?
      $count = 1;
      while($article_data = mysql_fetch_array($article_query)) {
  		$score_query    = mysql_query("SELECT *
  									   FROM  `bm_grade`
  									   WHERE  `article_idx` =".$article_data['idx']."
  									   AND  `user_idx` =".$_SESSION['idx']);
  ?>
  <div class="right aligned four wide column">
    <div class="ui right floated mini label" style="margin-bottom:5px;">
          <?= substr($article_data['datetime'], 0, 10) ?>
    </div>
    <div class="ui attached segment" style="padding:0px;">
      <img class="ui image" src="<?= get_profile_url($article_data['user_idx']);  ?>">
    </div>
    <div class="ui bottom attached segment">
      <p class="ui center aligned container">
        <a class="user">
            <?=$article_data['user_name']?>
        </a><a href="/public/dt_grade?id=<?=$article_data['idx'] ?>"><?= $lang_dt ?></a>
      </p>
      <p class="ui center aligned container">
        <?=number_format($article_data['grade_count'])?><?= $lang_ratings ?>
      </p>
      <p class="ui center aligned container">
        <a class="ui primary button" href="/public/dt_grade?id=<?=$article_data['idx'] ?>">VIEW</a>
      </p>
    </div>
  </div>
  <? } ?>
</div>
