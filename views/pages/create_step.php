<?
if($_SESSION['lang'] == "en"){
  $lang_step_creation = "Step Creation";
  $lang_subject = "Subject";
  $lang_order = "Order";
  $lang_start_date = "Start date";
  $lang_end_date = "End date";
  $lang_description = "Description (brief instructions)";
  $lang_interlinking = "Interlinking with business model evaluation";
}else{
  $lang_step_creation = "스텝생성";
  $lang_subject = "제목";
  $lang_order = "순서";
  $lang_start_date = "시작일";
  $lang_end_date = "종료일";
  $lang_description = "설명 (간략한 안내)";
  $lang_interlinking = "비즈니스모델 평가 연동하기";
}
?>

<h2 class="ui header"><?= $lang_step_creation ?></h2>
<div class="ui divider"></div>
<form class="ui form" action = "./do_add_step.php" method = "post">
    <div class="required field">
        <label><?= $lang_subject ?></label>
        <input type="text" name="step_name" placeholder="<?= $lang_subject ?>">
    </div>
    <div class="required field">
        <label><?= $lang_order ?></label>
        <input type="number" name="step_seq" placeholder="<?= $lang_order ?>">
    </div>
    <div class="two fields">
        <div class="required field">
            <label><?= $lang_start_date ?></label>
            <input type="date" name="start_date" placeholder="<?= $lang_start_date ?>">
        </div>
        <div class="required field">
            <label><?= $lang_end_date ?></label>
            <input type="date" name="end_date" placeholder="<?= $lang_end_date ?>">
        </div>
    </div>
    <div class="required field">
        <label><?= $lang_description ?></label>
        <textarea rows="10" id="ir1" name="step_explain" style="width: 100%"></textarea>
    </div>
    <div class="field">
        <div class="ui checkbox">
          <input type="checkbox" name="bm_link">
          <label><?= $lang_interlinking ?></label>
        </div>
	</div>
    <button class="ui button primary" type="submit" id = "save"><?= $lang_submit ?></button>
</form>
