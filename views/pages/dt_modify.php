<?
require_once(VIEW.'common/_language.php');

$_SESSION['current_menu'] = "dt";
$article_id = $_GET['id'];
$user_idx   = $_SESSION['idx'];
$article_query = mysql_query("SELECT *
                              FROM  `design_thinking`
                              WHERE  `idx` ='$article_id' ");
$article_data = mysql_fetch_array($article_query);
if($article_data['user_idx'] != $user_idx){
    msg("접근할 수 없습니다.");
    back();
}
$extend_query = mysql_query("SELECT *
                             FROM  `design_thinking_article`
                             WHERE  `dt_idx` =$article_id");

$i = 0;
while($extend_data = mysql_fetch_array($extend_query)) {

    $datas[$i][0] = $extend_data['type'];
    $datas[$i][1] = $extend_data['content'];

    $i ++;
}

if($_SESSION['lang'] == "en"){
  $lang_modify_dt = "Modify Design Thinking";
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
  $lang_modify_dt = "디자인 씽킹 수정";
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
<h2 class="ui header"><?= $lang_modify_dt ?></h2>
<div class="ui segment area1200" id="dtArticle">
    <form class="ui form" action="do_edit_dt.php" method="post"  enctype="multipart/form-data">
        <?
            for($i =0; $i < count($datas); $i++){
                if($datas[$i][0] == 'link'){
                    //echo $datas[$i][1]."<br>";
                    //echo '<div class="field"><div class="ui action input"><input type="text" name="link[]" placeholder="Link..." value="'.$datas[$i][1].'"><div class="ui icon button" onclick="removeDThisField(this)"><i class="minus icon"></i></div></div></div>';
                    $temp_data = $datas[$i][1];
                    break;
                }
            }
        ?>
        <h4 class="ui header"><?= $lang_step1 ?></h4>
        <div class="field">
            <label><?= $lang_step1_1 ?></label>
            <div class="ui action input">
                <input type="text" name="link[]" placeholder="Link..." value="<?=$temp_data?>">
                <div class="ui icon button" onclick="addLinkField(this)">
                    <i class="plus icon"></i>
                </div>
            </div>
        </div>
        <?
            for($i = $i+1; $i < count($datas); $i++){
                if($datas[$i][0] == 'link'){
                    //echo $datas[$i][1]."<br>";
                    echo '<div class="field"><div class="ui action input"><input type="text" name="link[]" placeholder="Link..." value="'.$datas[$i][1].'"><div class="ui icon button" onclick="removeDThisField(this)"><i class="minus icon"></i></div></div></div>';
                }
            }
        ?>
        <h4 class="ui header"><?= $lang_step2 ?></h4>
        <div class="field">
            <label><?= $lang_img_upload ?></label>
            <input type="file" name="img2">
        </div>

        <div class="field">
            <label><?= $lang_step2_1 ?></label>
            <textarea rows="2" name = "problem_cause"><?=$article_data['problem_cause']?></textarea>
        </div>
        <?
            for($i =0; $i < count($datas); $i++){
                    if($datas[$i][0] == 'idea'){
                        //echo $datas[$i][1]."<br>";
                        $temp_data = $datas[$i][1];
                        break;
                    }
                }
        ?>
        <h4 class="ui header"><?= $lang_step3 ?></h4>
        <div class="field">
            <label><?= $lang_step3_1 ?></label>
            <div class="ui action input">
                <input type="text" name="idea[]" placeholder="<?= $lang_enter_idea ?>" value="<?=$temp_data?>">
                <div class="ui icon button" onclick="addIdeaField(this)">
                    <i class="plus icon"></i>
                </div>
            </div>
        </div>
        <?
            for($i = $i + 1; $i < count($datas); $i++){
                if($datas[$i][0] == 'idea'){
                    //echo $datas[$i][1]."<br>";
                    echo '<div class="field"><div class="ui action input"><input type="text" name="idea[]" placeholder="'.$lang_enter_idea.'" value="'.$datas[$i][1].'"><div class="ui icon button" onclick="removeDThisField(this)"><i class="minus icon"></i></div></div></div>';
                }
            }
        ?>
        <h4 class="ui header"><?= $lang_step4 ?></h4>
        <div class="field">
            <label><?= $lang_step4_1 ?></label><br>
            <label><?= $lang_img_upload ?></label>
            <input type="file" name="profile">
        </div>
        <div class="field">
            <label><?= $lang_youtube_url ?></label>
            <input type="text" name="youtube_link" placeholder="YouTube URL" value=<?=$article_data['youtube_link']?>>
        </div>
        <?
            for($i =0; $i < count($datas); $i++){
                    if($datas[$i][0] == 'test'){
                        //echo $datas[$i][1]."<br>";
                        $temp_data = $datas[$i][1];
                        break;
                    }
                }
        ?>
        <h4 class="ui header"><?= $lang_step5 ?></h4>
        <div class="field">
            <label><?= $lang_step5_1 ?></label>
            <textarea rows="2" name="test[]"><?=$temp_data?></textarea>
        </div>
        <?
            for($i = $i + 1; $i < count($datas); $i++){
                if($datas[$i][0] == 'test'){
                    //echo $datas[$i][1]."<br>";
                    echo '<div class="field"><textarea rows="2" name="test[]">'.$datas[$i][1].'</textarea><a onclick="removeThisField(this)">'.$lang_remove.'</a></div>';
                }
            }
        ?>
        <div class="field test-last-field">
            <div class="ui icon button" onclick="addTestField(this)"><i class="plus icon"></i></div>
        </div>
        <button class="ui button primary" tabindex="0"><?= $lang_modify ?></button>
        <input type="hidden" name="idx" value="<?=$article_id?>">
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
