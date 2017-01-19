<?
require_once(VIEW.'common/_language.php');

if($_SEESION['lang'] == 'en'){
  $lang_add_program = "Add New Program";
  $lang_program_name = "Program name";
  $lang_program_id = "Program ID";
  $lang_language = "Language";
  $lang_korean = "Korean(한국어)";
  $lang_English = "English(영어)";
  $lang_copy = "Copy curriculum";
  $lang_none = "None";
}else{
  $lang_add_program = "프로그램 추가";
  $lang_program_name = "프로그램 이름";
  $lang_program_id = "프로그램 아이디";
  $lang_language = "언어 선택";
  $lang_korean = "한국어(Korean)";
  $lang_English = "영어(English)";
  $lang_copy = "커리큘럼 복사";
  $lang_none = "선택 안 함";
}
?>

<h2 class="ui header"><?= $lang_add_program ?></h2>
<div class="ui divider"></div>
<form class="ui form" action = "./do_add_company.php" method = "post">
    <div class="required field">
        <label><?= $lang_program_name ?></label>
        <input type="text" name="name" placeholder="<?= $lang_program_name ?>">
    </div>
    <div class="required field">
        <label><?= $lang_program_id ?></label>
        <input type="text" name="company_id" placeholder="<?= $lang_program_id ?>">
    </div>
    <div class="required field">
        <label><?= $lang_language ?></label>
        <select name="lang" class="ui fluid dropdown" required>
          <option value="ko"><?= $lang_korean ?></option>
          <option value="en"><?= $lang_English ?></option>
        </select>
    </div>
    <div class="field">
        <label><?= $lang_copy ?></label>
          <select name="curriculum" class="ui fluid dropdown" required>
            <option value="0"><?= $lang_none ?></option>
          <?
            $cquery = mysql_query("SELECT * FROM `company`");
            while($cdata = mysql_fetch_array($cquery)){
              $cur_query = mysql_query("SELECT `idx` FROM `curriculum_step` WHERE `company_id`='".$cdata['company_id']."'");
              $cur_num = mysql_fetch_array($cur_query);
              if($cur_num > 0){
          ?>
            <option value="<?= $cdata['company_id'] ?>"><?= $cdata['name'] ?></option>
            <? } ?>
          <? } ?>
          </select>
    </div>
    <button class="ui button primary" type="submit" id = "save"><?= $lang_submit ?></button>
</form>
