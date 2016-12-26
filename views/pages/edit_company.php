<?
	$company_idx = $_POST['company_idx'];

	$cquery = mysql_query("SELECT `name` FROM `company`
						   WHERE `idx` = '{$company_idx}'");
	$cdata = mysql_fetch_array($cquery);
?>
<h2 class="ui header">프로그램 수정</h2>
<div class="ui divider"></div>
<form class="ui form" action = "./do_edit_company.php" method = "post">
<input type="hidden" name="company_idx" value="<?= $company_idx ?>" />
    <div class="required field">
        <label>프로그램 이름</label>
        <input type="text" name="name" value="<?= $cdata['name'] ?>">
    </div>
    <button class="ui button primary" type="submit" id = "save">저장</button>
</form>