<?
require_once(VIEW.'common/_language.php');

	$company_idx = $_POST['company_idx'];

	$cquery = mysql_query("SELECT `name` FROM `company`
						   WHERE `idx` = '{$company_idx}'");
	$cdata = mysql_fetch_array($cquery);

	if($_SESSION['lang'] == "en"){
		$lang_modify_program ="Modify Program";
		$lang_program_name = "Program Name";
	}else{
		$lang_modify_program ="프로그램 수정";
		$lang_program_name = "프로그램 이름";
	}
?>
<h2 class="ui header"><?= $lang_modify_program ?></h2>
<div class="ui divider"></div>
<form class="ui form" action = "./do_edit_company.php" method = "post">
<input type="hidden" name="company_idx" value="<?= $company_idx ?>" />
    <div class="required field">
        <label><?= $lang_program_name ?></label>
        <input type="text" name="name" value="<?= $cdata['name'] ?>">
    </div>
    <button class="ui button primary" type="submit" id = "save"><?= $lang_modify ?></button>
</form>
