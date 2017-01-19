<?
require_once(VIEW.'common/_language.php');

$_SESSION['current_menu'] = "dt";

if($_SESSION['lang'] == "en"){
  $lang_write_dt = "Write Design Thinking";
  $lang_img_upload = "Image Upload";
  $lang_youtube_url = "Youtube URL";

  $lang_step1 = "Step 1. EMPATHIZE";
  $lang_step2 = "Step 2. DEFINE";
  $lang_step3 = "Step 3. IDEATE";
  $lang_step4 = "Step 4. PROTOTYPE";
  $lang_step5 = "Step 5. TEST";

  $lang_step1_1 = "Link to observations and interviews on the subject of the item (Problem)";
  $lang_step2_1 = "Define the cause of the problem through in-team discussions";
  $lang_step3_1 = "Enter a solution (idea) to solve the problem";
  $lang_step4_1 = "Upload a photo or video for the prototype";
  $lang_step5_1 = "Please enter your Opinion (feedback)";

  $lang_enter_idea = "Please enter your ideas.";
  $lang_remove = "Remove the above box";
}else{
  $lang_write_dt = "디자인 씽킹 작성";
  $lang_img_upload = "이미지 업로드";
  $lang_youtube_url = "유투브 동영상 업로드";

  $lang_step1 = "1단계 공감하기";
  $lang_step2 = "2단계 문제정의";
  $lang_step3 = "3단계 아이디어 도출";
  $lang_step4 = "4단계 시제품 만들기";
  $lang_step5 = "5단계 테스트";

  $lang_step1_1 = "아이템(문제)의 대상에 대한 관찰 및 인터뷰 내용을 링크하세요";
  $lang_step2_1 = "팀내 토론을 거쳐 문제의 원인을 정리(정의)하세요";
  $lang_step3_1 = "문제를 해결하기 위한 솔루션(아이디어)를 입력하세요";
  $lang_step4_1 = "시제품에 대한 사진 또는 동영상을 업로드하세요";
  $lang_step5_1 = "테스트한 고객의 의견(피드백)을 입력해주세요";

  $lang_enter_idea = "아이디어를 입력해 주세요.";
  $lang_remove = "위의 칸 제거";
}
?>
<h2 class="ui header"><?= $lang_write_dt ?></h2>
<div class="ui segment area1200" id="dtArticle">
    <form class="ui form" action="do_add_dt.php" method="post"  enctype="multipart/form-data">
        <h4 class="ui header"><?= $lang_step1 ?></h4>
        <div class="field">
            <label><?= $lang_step1_1 ?></label>
            <div class="ui action input">
                <input type="text" name="link[]" placeholder="Link...">
                <div class="ui icon button" onclick="addLinkField(this)">
                    <i class="plus icon"></i>
                </div>
            </div>
        </div>
        <h4 class="ui header"><?= $lang_step2 ?></h4>
        <div class="field">
            <label><?= $lang_img_upload ?></label>
            <input type="file" name="img2">
        </div>

        <div class="field">
            <label><?= $lang_step2_1 ?></label>
            <textarea rows="2" name = "problem_cause"></textarea>
        </div>
        <h4 class="ui header"><?= $lang_step3 ?></h4>
        <div class="field">
            <label><?= $lang_step3_1 ?></label>
            <div class="ui action input">
                <input type="text" name="idea[]" placeholder="<?= $lang_enter_idea ?>">
                <div class="ui icon button" onclick="addIdeaField(this)">
                    <i class="plus icon"></i>
                </div>
            </div>
        </div>
        <h4 class="ui header"><?= $lang_step4 ?></h4>
        <div class="field">
            <label><?= $lang_step4_1 ?></label><br>
            <label><?= $lang_img_upload ?></label>
            <input type="file" name="profile">
        </div>
        <div class="field">
            <label><?= $lang_youtube_url ?></label>
            <input type="text" name="youtube_link" placeholder="YouTube URL">
        </div>
        <h4 class="ui header"><?= $lang_step5 ?></h4>
        <div class="field">
            <label><?= $lang_step5_1 ?></label>
            <textarea rows="2" name="test[]"></textarea>
        </div>
        <div class="field test-last-field">
            <div class="ui icon button" onclick="addTestField(this)"><i class="plus icon"></i></div>
        </div>
        <button class="ui button primary" tabindex="0"><?= $lang_submit ?></button>
    </form>
</div>

<script type="text/javascript">
    function addLinkField(self) {
        $(self).parent().parent().after('<div class="field"><div class="ui action input"><input type="text" name="link[]" placeholder="Link..."><div class="ui icon button" onclick="removeDThisField(this)"><i class="minus icon"></i></div></div></div>');
    }
    function addIdeaField(self) {
        $(self).parent().parent().after('<div class="field"><div class="ui action input"><input type="text" name="idea[]" placeholder="<?= $lang_enter_idea ?>"><div class="ui icon button" onclick="removeDThisField(this)"><i class="minus icon"></i></div></div></div>');
    }
    function addTestField(self) {
        $(self).parent().prev().after('<div class="field"><textarea rows="2" name="test[]"></textarea><a onclick="removeThisField(this)"><?= $lang_remove ?></a></div>');
    }
    function removeThisField(self) {
        $(self).parent().remove();
    }
    function removeDThisField(self) {
        $(self).parent().parent().remove();
    }
</script>
