<?
require_once(VIEW.'common/_language.php');

$where = '';
$company_id = $_SESSION['company'];

$q = $_GET['q'];
$_SESSION['current_menu'] = "user";
if ($q) {
    $where = " AND `name` like '%".mysql_escape_string($q)."%'";
}

//////////// SERVER
$user_query = mysql_query("SELECT *
FROM  `user`
WHERE level < 4 AND `company_id` ='{$company_id}' {$where}");

if($_SESSION['lang'] == "en"){
	$lang_participant_list = "Participants List";
	$lang_search_participant = "Searching participants…";
	$lang_check_profile = "Check profile";
	$lang_noresult = "No result";
	$lang_empty = "Empty";
	$lang_details = "Details";
}else{
	$lang_participant_list = "참가자 리스트";
	$lang_search_participant = "참가자 검색";
	$lang_check_profile = "프로필을 확인하세요.";
	$lang_noresult = "검색된 참가자가 존재하지 않습니다.";
	$lang_empty = "참가자가 존재하지 않습니다.";
	$lang_details = "자세히";
}
?>

<h2 class="ui header"><?= $lang_participant_list ?></h2>
<div style="margin: 10px 0; text-align: center;">
	<form action="/public/group_user_list" method="get">
    <div class="ui icon input right">

        <input name="q" type="text" placeholder="<?= $lang_search_participant ?>" value="<?=$_GET['q']?>">
        <i class="search link icon"></i>

    </div>
    </form>
    <!--
    <select class="ui dropdown">
        <option value="">참가자격</option>
        <option value="1">아이템</option>
    </select>
    <select class="ui dropdown">
        <option value="">직군</option>
        <option value="1">개발자</option>
        <option value="2">디자이너</option>
        <option value="3">기획자</option>
    </select>
    -->
</div>
<div class="ui divider forh2"></div>
<div class="ui stackable two column grid" id="profilePage">
<?
	$user_total = mysql_num_rows($user_query);
	if($user_total == 0){
		if($q){
			echo "<span style='margin: 20px auto;'>{$lang_noresult}</span>";
		}else{
			echo "<span style='margin: 20px auto;'>{$lang_empty}</span>";
		}
	}
?>
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
            <div class="content cnt">
                <div class="profile_image">
                    <img class="ui top aligned small bordered image floated left" src="<?=get_profile_url($user_data['idx']);  ?>" style="height: 150px">
                </div>
                <div class="header"><a style="color:#212121;" href="./userpage?id=<?=$user_data['idx']?>"><? echo $user_data['name']; ?></a></div>
                <div class="meta"><? echo $user_data['position']; ?></div>
                <?
                    if(isset($bm_data['title'])){
                        ?>
                        <a href="/public/bm_grade?board_id=business_model&article_id=<?=$bm_data['idx']?>">@<?=$bm_data['title']?></a><br>
                        <?
                    }
                ?>

                <div class="description">
                    <p>
                        <?= $lang_check_profile ?><br>
                    </p>
                </div>
            </div>
            <div class="extra content">
                <a class="right floated like" href = "./userpage?id=<?=$user_data['idx']?>">
                    <i class="info circle icon"></i>
                   	 <?= $lang_details ?>
                </span>
                <a class="right floated">
                    <!--<i class="mail icon"></i>
                    메세지-->
                </a>

            </div>

        </div>
    </div>
<? } ?>
</div>
