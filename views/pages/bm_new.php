<?
require_once(VIEW.'common/_language.php');

$type	= $_GET['type'];
$idx	= $_GET['idx'];

if($_SESSION['lang'] == "en"){
	$lang_mod_mybm = "Modify My Business Model";
	$lang_newbmr = "Register New B.M.";

	$lang_info = "Infomation";
	$lang_subject = "Subject";
	$lang_bm_keywords = "Keywords";
	$lang_bm_type = "B.M. Type";
	$lang_summary = "Summary";
	$lang_bm_item = "Business Item";
	$lang_bm_item1 = "Please describe your items with following questions.";

	$lang_select = "Select..";
	$lang_it = "IT Service";
	$lang_manufact = "Manufacturing";

	$lang_bm1 = "Who is your customer?";
	$lang_bm2 = "What is the problems customer has?";
	$lang_bm3 = "How can you solve these problems?";
	$lang_bm4 = "Revenue Model";
	$lang_bm5 = "Your website or landing page";
	$lang_bm6 = "Team Information (Team Ability)";
	$lang_recruitment = "Recruitment";

	$lang_item = "Business item writing method";
	$lang_references = "References: Dankook University Enternship";

	$lang_character = " characters";

}else{
	$lang_mod_mybm = "내 비즈니스 모델 수정";
	$lang_newbmr = "신규 비즈니스 모델 등록";

	$lang_info = "기본정보";
	$lang_subject = "제목";
	$lang_bm_keywords = "요약설명";
	$lang_bm_type = "비즈니스 모델 유형";
	$lang_summary = "요약";
	$lang_bm_item = "자신의 사업아이템";
	$lang_bm_item1 = "사업아이템을 아래의 문항을 통해 정리해주세요.";

	$lang_select = "선택";
	$lang_it = "지식서비스";
	$lang_manufact = "제조업";

	$lang_bm1 = "(Who) 나의 고객은?";
	$lang_bm2 = "(What) 고객의 문제는?";
	$lang_bm3 = "(HOW) 고객의 문제를 어떻게 해결할것인가?";
	$lang_bm4 = "수익 모델은?";
	$lang_bm5 = "자신의 웹사이트 또는 랜딩페이지";
	$lang_bm6 = "팀소개(팀의 역량)";
	$lang_recruitment = "구인중인";

	$lang_item = "사업아이템 작성법";
	$lang_references = "참고자료: 단국대학교 엔턴십";

	$lang_character = "자";
}

if($type == "edit") {
	$article = mysql_query("SELECT *
								FROM  `article`
								WHERE  `idx` =$idx");
	$article_data = mysql_fetch_array($article);

	$extend = mysql_query("SELECT *
							FROM  `board_extend_data`
							WHERE  `article_idx` =$idx");
	$i = 0;
	while($extend_temp = mysql_fetch_array($extend)) {
		$et = $extend_temp['extend_idx'];
		$extend_data[$et] = $extend_temp['content'];

	}
	//var_dump($article_data);
	//var_dump($extend_data);
?>
<h2 class="ui header"><?= $lang_mod_mybm ?></h2>
<?
} else {
?>
<h2 class="ui header"><?= $lang_newbmr ?></h2>
<?
}
?>

<div class="ui divider"></div>
<form class="ui form" action="/public/do_write_board.php" method="post">
    <div class="field inline">
        <h3><i class="ui icon send outline"></i> <?= $lang_info ?></h3>
    </div>
    <div class="required field">
        <label><?= $lang_subject ?> (15<?= $lang_character ?>)</label>
        <input type="text" name="title" placeholder="<?= $lang_subject ?>" value="<?=$article_data['title']; ?>">
    </div>
    <div class="required field">
        <label><?= $lang_bm_keywords ?> (30<?= $lang_character ?>)</label>
        <input type="text" name="ex_message" placeholder="<?= $lang_bm_keywords ?>" value="<?=$extend_data['message']; ?>">
    </div>
    <!--<div class="field">
        <label>도메인</label>
        <input type="text" name="ex_domain" placeholder="확보한 도메인을 입력하세요.">
    </div>-->
    <div class="required field">
        <label><?= $lang_bm_type ?></label>
        <select name="ex_bus_type" class="ui fluid dropdown">
            <option value="val1" <?=($extend_data['bus_type']=="val1")?" selected":""; ?>><?= $lang_select ?></option>
            <option value="val2" <?=($extend_data['bus_type']=="val2")?" selected":""; ?>><?= $lang_it ?></option>
            <option value="val3" <?=($extend_data['bus_type']=="val3")?" selected":""; ?>><?= $lang_manufact ?></option>
        </select>
    </div>
    <div class="required field">
        <label><?= $lang_summary ?></label>
    </div>
    <!-- <div class="field inline">
        <input type="text" name="ex_summary_who" placeholder="누구에게 (20자)"> 에게 <input type="text" name="ex_summary_what" placeholder="무엇을? (20자)"> 을(를) 제공한다. <input type="text" name="ex_summary_why" placeholder="왜? (20자)">
    </div> -->
    <div class="field">
        <textarea name="content" rows="2"><?=$article_data['content']; ?></textarea>
    </div>
    <div class="ui divider"></div>
    <div class="field">
        <h3><i class="ui icon send outline"></i> <?= $lang_bm_item ?></h3>
        <p>
            <?= $lang_bm_item1 ?>
            <div class="ui bulleted list">
                <div class="item"><?= $lang_item ?></div>
                <div class="item"><a href="#"><?= $lang_references ?></a></div>
            </div>
        </p>
    </div>
    <div class="required field">
        <label>1. <?= $lang_bm1 ?></label>
        <textarea rows="2" name="ex_slide_1"><?=$extend_data['slide_1']; ?></textarea>
    </div>
    <div class="required field">
        <label>2. <?= $lang_bm2 ?></label>
        <textarea rows="2" name="ex_slide_2"><?=$extend_data['slide_2']; ?></textarea>
    </div>
    <div class="required field">
        <label>3. <?= $lang_bm3 ?></label>
        <textarea rows="2" name="ex_slide_3"><?=$extend_data['slide_3']; ?></textarea>
    </div>
    <div class="field">
        <label>4. <?= $lang_bm4 ?></label>
        <textarea rows="2" name="ex_slide_4"><?=$extend_data['slide_4']; ?></textarea>
    </div>
    <div class="required field">
        <label>5. <?= $lang_bm5 ?></label>
        <textarea rows="2" name="ex_slide_5"><?=$extend_data['slide_5']; ?></textarea>
    </div>
    <div class="required field">
        <label>6. <?= $lang_bm6 ?></label>
        <textarea rows="2" name="ex_slide_6"><?=$extend_data['slide_6']; ?></textarea>
    </div>
    <div class="field inline">
        <label style="margin-left: 10px;"><?= $lang_recruitment ?> <?= $lang_developer ?></label>
        <input type="number" style="width: 80px;" name="ex_recruit_developer" value="<?=($extend_data['recruit_developer']!='')?$extend_data['recruit_developer']:"0"; ?>"> 명
        <label style="margin-left: 10px;"><?= $lang_designer ?></label>
        <input type="number" style="width: 80px;" name="ex_recruit_designer" value="<?=($extend_data['recruit_designer']!='')?$extend_data['recruit_designer']:"0"; ?>"> 명
        <label style="margin-left: 10px;"><?= $lang_planner ?></label>
        <input type="number" style="width: 80px;" name="ex_recruit_planner" value="<?=($extend_data['recruit_planner']!='')?$extend_data['recruit_planner']:"0"; ?>"> 명
    </div>

    <div class="ui divider"></div>
    <input type="hidden" name="board_id" value="<? echo $_GET['id']; ?>">
    <input type="hidden" name="board_type" value="bm"/>
    <input type="hidden" name="company_id" value="<?= $_SESSION['company']; ?>"/>
    <? if($type == "edit") { ?>
    <input type="hidden" name="type" value="edit"/>
    <input type="hidden" name="article_id" value="<?=$idx; ?>"/>
    <? } ?>
    <a href="#" onclick="$(this).closest('form').submit()"><button class="ui button positive" type="button"><?= $lang_submit ?></button></a>
    <button class="ui button red" type="button"><?= $lang_cancel ?></button>
</form>
