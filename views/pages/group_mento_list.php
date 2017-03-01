<?
require_once(VIEW.'common/_language.php');

$where = '';
$company_id = $_SESSION['company'];

$q = $_GET['q'];
$_SESSION['current_menu'] = "mento";
if ($q) {
    $where = " AND `name` like '%".mysql_escape_string($q)."%'";
}

//////////// SERVER
$user_query = mysql_query("SELECT *
		FROM  `user`
		WHERE level = 4 AND `company_id` ='$company_id' {$where}");

if($_SESSION['lang'] == "en"){
	$lang_mentor_list = "Mentor List";
	$lang_search_mentor = "Searching mentors…";
	$lang_check_profile = "Check profile";
	$lang_noresult = "No result";
	$lang_empty = "Empty";
	$lang_details = "Details";
}else{
	$lang_mentor_list = "멘토 리스트";
	$lang_search_mentor = "멘토 검색";
	$lang_check_profile = "프로필을 확인하세요.";
	$lang_noresult = "검색된 멘토가 존재하지 않습니다.";
	$lang_empty = "멘토가 존재하지 않습니다.";
	$lang_details = "자세히";
}
?>

<h2 class="ui header"><?= $lang_mentor_list ?></h2>
<div style="margin: 10px 0 50px 0; text-align: center;">
	<form action="/public/group_user_list" method="get">
    <div class="ui icon input right">
        <input name="q" type="text" placeholder="<?= $lang_search_mentor ?>" value="<?=$_GET['q']?>">
        <i class="search link icon"></i>
    </div>
    </form>
</div>


<div class="ui three column grid">
  <? while($user_data =  mysql_fetch_array($user_query)) {
      $bm_query = "SELECT *
      FROM `article`
      WHERE `board_id` = 'business_model'
      AND `user_idx` = '".$user_data['idx']."'";

      $bm_result = mysql_query($bm_query);
      $bm_data = mysql_fetch_array($bm_result);
      ?>
  <div class="column">
    <div class="ui fluid card">
      <div class="content">
        <div class="ui floated left">
          <div class="profile_image">
              <img class="ui top aligned small bordered image floated left" src="<?=get_profile_url($user_data['idx']);  ?>" style="width:120px; height: 120px;">
          </div>
        </div>
        <div class="ui floated right">
          <p class="ui container">
          <a style="font-size: 1.2em; color:#212121;" href="./userpage?id=<?=$user_data['idx']?>"><?= $user_data['name']; ?></a>
          <span style="font-size: 1em; color: rgba(0, 0, 0, 0.4);"><?= $user_data['position']; ?></span>
          </p>
          <p class="ui container">
          <?
              if(isset($bm_data['title'])){
                  ?>
                  <a style="font-size: 0.9em;" href="/public/bm_grade?board_id=business_model&article_id=<?=$bm_data['idx']?>">
                    @<?=$bm_data['title']?></a><br>
                  <?
              }
          ?>
          </p>
          <p class="ui right aligned container">
            <a class="ui mini button" href="./userpage?id=<?=$user_data['idx']?>">VIEW</a>
          </p>
        </div>
      </div>
    </div>
  </div>
  <? } ?>
</div>
