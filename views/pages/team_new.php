
<?
require_once(VIEW.'common/_language.php');

// 작성한 비즈모델이 있나 확인, 없으면 종료
$query = mysql_query("SELECT *
						FROM  `article`
						WHERE  `board_id` =  'business_model'
						AND  `user_idx` =".$_SESSION['idx']);
if(mysql_num_rows($query) < 1) {
	msg("작성한 비즈니스 모델이 없습니다. 비즈니스 모델을 먼저 작성 후 팀을 만드세요.");
	back();
	exit();
}
$type = $_GET['type'];

if($type == "edit") {
    $tdata = mysql_fetch_array(mysql_query("SELECT * FROM  `team` WHERE  `idx` =".$_GET['idx']));
}

if($_SESSION['lang'] == "en"){
	$lang_register = "Register new team";
	$lang_mod_team = "Edit team infomation";

	$lang_info = "Information";
	$lang_name = "Team name";
	$lang_member = "Members’ name";
	$lang_bm = "Business Model";
	$lang_award = "Award history";
	$lang_career = "Career";
	$lang_ability = "Team’s Ability";
	$lang_process = "Your workflow process";
}else{
	$lang_register = "신규 팀 등록";
	$lang_mod_team = "팀 수정";

	$lang_info = "기본정보";
	$lang_name = "팀 이름";
	$lang_member = "팀원";
	$lang_bm = "비즈니스 모델";
	$lang_award = "수상이력";
	$lang_career = "경력";
	$lang_ability = "보유역량";
	$lang_process = "진행사항";
}

?>

<h2 class="ui header"><?=($type=="edit")?"{$lang_mod_team}":"{$lang_register}";  ?></h2>
<div class="ui divider"></div>
<form class="ui form" action="/public/do_add_team.php" method="post">
    <div class="field inline">
        <h3><i class="ui icon send outline"></i> <?= $lang_info ?></h3>
    </div>
    <div class="required field">
        <label><?= $lang_name ?></label>
        <input type="text" name="team_name" placeholder="<?= $lang_name ?>" value="<?=$tdata['name']; ?>">
    </div>
    <div class="required field">
        <label><?= $lang_member ?></label>
        <input type="text" name="team_member" placeholder="<?= $lang_member ?>" value="<?=$tdata['members']; ?>">
    </div>
    <div class="required field">

        <label><?= $lang_bm ?></label>
        <select name="bm" class="ui fluid dropdown" required>
        	<?
			//BMLIST 가져오기
			while($bm_list = mysql_fetch_array($query)) {
				?>
				<option <?=($bm_list['idx']==$tdata['bm_idx'])?"selected":""; ?> value="<?=$bm_list['idx']; ?>"><?=$bm_list['title']; ?></option>

				<?
			}

			?>


		</select>

    </div>
    <div class="field">
        <label><?= $lang_award ?></label>
        <textarea name="contest" rows="2"><?=$tdata['award']; ?></textarea>
    </div>
    <div class="field">
        <label><?= $lang_career ?></label>
        <textarea name="career" rows="2"><?=$tdata['history']; ?></textarea>
    </div>
    <div class="field">
        <label><?= $lang_ability ?></label>
        <textarea name="skills" rows="2"><?=$tdata['ability']; ?></textarea>
    </div>
    <div class="field">
        <label><?= $lang_process ?></label>
        <textarea name="process" rows="2"><?=$tdata['progress']; ?></textarea>
    </div>
    <input type="hidden" name="type" value="<?=($type=="edit")?"edit":"new";  ?>">
    <input type="hidden" name="idx" value="<?=$_GET['idx']; ?>">
    <div class="ui divider"></div>
    <a href="#" onclick="$(this).closest('form').submit()"><button class="ui button positive" type="button"><?= $lang_submit ?></button></a>
    <a href="/public/team_list">
    	<button class="ui button red" type="button"><?= $lang_cancel ?></button>
    </a>
</form>
