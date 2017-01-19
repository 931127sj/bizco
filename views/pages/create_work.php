<?
require_once(VIEW.'common/_language.php');

if($_SESSION['lang'] == "en"){
  $lang_create = "Create Assignment";
  $lang_subject = "Subject";
  $lang_step = "Step";
  $lang_impression = "First Impression Evaluation / Organization";
  $lang_type = "Assignment type";
  $lang_read = "Read article";
  $lang_start_date = "Start date";
  $lang_end_date = "End date";
  $lang_description = "Description (brief instructions)";
  $lang_link = "Reference link (video link for video assignment)";
  $lang_video = "Video transcripts, offline meetings, and survey details can be created once the assignment has been created (saved).";
}else{
  $lang_create = "과제생성";
  $lang_subject = "제목";
  $lang_step = "스텝";
  $lang_impression = "첫인상평가/조직";
  $lang_type = "과제타입";
  $lang_read = "글 읽기";
  $lang_start_date = "시작일";
  $lang_end_date = "종료일";
  $lang_description = "설명 (간략한 안내)";
  $lang_link = "참고링크 (비디오 과제의 경우 동영상 링크)";
  $lang_video = "비디오 대본과 오프모임, 설문조사 상세내용은 일단 과제를 생성(저장)한 후에 추가로 작성하실 수 있습니다.";
}
?>

<h2 class="ui header"><?= $lang_create ?></h2>
<div class="ui divider"></div>
<form class="ui form">
    <div class="required field">
        <label><?= $lang_subject ?></label>
        <input type="text" name="subject" placeholder="<?= $lang_subject ?>">
    </div>
    <div class="two fields">
        <div class="required field">
            <label><?= $lang_step ?></label>
            <select name="step" class="ui fluid dropdown">
                <option value="val1"><?= $lang_impression ?></option>
                <option value="val2">2</option>
                <option value="val3">3</option>
            </select>
        </div>
        <div class="required field">
            <label><?= $lang_type ?></label>
            <select name="work_type" class="ui fluid dropdown">
                <option value="val1"><?= $lang_read ?></option>
                <option value="val2">2</option>
                <option value="val3">3</option>
            </select>
        </div>
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
        <textarea rows="10" id="ir1" name="content" style="width: 100%"></textarea>
    </div>
    <div class="field">
        <label><?= $lang_link ?></label>
        <input type="text" name="link">
    </div>

    <button class="ui button primary" type="submit"><?= $lang_submit ?></button>
    <div class="field">
        <small>
            <?= $lang_video ?>
        </small>
    </div>
</form>
