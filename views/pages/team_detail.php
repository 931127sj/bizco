<?
require_once(VIEW.'common/_language.php');

////////// SERVER
$board_id   = $_GET['board_id'];
$article_id = $_GET['article_id'];
$user_idx   = $_SESSION['idx'];
$company_id = $_SESSION['company'];

$article_query = mysql_query("SELECT *
                              FROM  `article`
                              WHERE  `idx` =$article_id
                              AND  `company_id` =  '$company_id'
                              AND  `board_id` =  '$board_id'");
$article_data = mysql_fetch_array($article_query);

$extend_query = mysql_query("SELECT *
                             FROM  `board_extend_data`
                             WHERE  `article_idx` =$article_id");

$i = 0;
while($extend_data = mysql_fetch_array($extend_query)) {
	$exid = $extend_data['extend_idx'];
	$ex[$exid] = $extend_data['content'];

	$i ++;
}

if($_SESSION['lang'] == "en"){
  $lang_bmc = "Business Model Canvas";

  $lang_summary = "Summary";

  $lang_td1 = "Who is your customer?";
  $lang_td2 = "What will solve the customer's problem?";
  $lang_td3 = "What are the core competencies that are most needed for problem solving?";
  $lang_td4 = "What is your revenue model?";
  $lang_td5 = "Enter demo site / screenshot image link";
  $lang_td6 = "Team Introduction";

  $lang_bm_grade1 = "Interested in the idea above? (necessary)";
  $lang_bm_grade2 = "I'm interested.";
  $lang_bm_grade3 = "I don't know";
  $lang_bm_grade4 = "What is your opinion on the idea above?";
  $lang_bm_grade5 = "One line summary";
  $lang_bm_grade6 = "Do you know similar domestic and international services? If so, please tell us that service name or site.";
  $lang_rate_it = "Rate it";
}else{
  $lang_bmc = "비즈니스 모델 캔버스";

  $lang_summary = "개요";

  $lang_td1 = "나의 고객님은 어떤 문제점을 가진 누구인가?";
  $lang_td2 = "그 고객의 문제를 무엇으로 해결할 것인가?";
  $lang_td3 = "문제 해결을 위해 가장 필요한 핵심 역량은 무엇인가?";
  $lang_td4 = "수익 모델은?";
  $lang_td5 = "데모 사이트/스크린샷 이미지 링크를 입력하세요.";
  $lang_td6 = "팀소개";

  $lang_bm_grade1 = "위 아이디어에 관심이 있나요? (필수)";
  $lang_bm_grade2 = "관심이 있어요";
  $lang_bm_grade3 = "잘 모르겠어요";
  $lang_bm_grade4 = "위 아이디어에 대한 귀하의 의견은?";
  $lang_bm_grade5 = "한줄 정리";
  $lang_bm_grade6 = "유사한 국내외 서비스가 있나요? 있다면 서비스명이나 사이트를 말해주세요.";
  $lang_rate_it = "평가하기";
}

?>

<div class="ui top attached tabular menu" id="bmGrade1">
    <span class="item header"><?=xssHtmlProtect($article_data['title'])?></span>
    <a href="/public/bm_grade?board_id=business_model" class="item right active" data-tab="intro"><?= $lang_summary ?></a>
    <? if($_SESSION['idx'] == $article_data['user_idx']) { ?>
    <a href="/public/bm_new?type=edit&id=business_model&idx=<?=$article_id; ?>" class="item"><?= $lang_modify ?></a>
    <? } ?>
</div>
<!-- Step -->


<div id="bmGrade2" class="ui bottom attached tab segment active" data-tab="intro">

    <div class="clearfix" style="position: relative;">
        <img class="ui tiny left floated image" style="height: 94px" src="<?=get_profile_url($article_data['user_idx']);  ?>">
        <a class="image-bottom-info-text" href = "./userpage?id=<?=$article_data['user_idx']?>">
            <i class="info circle icon"></i>
            기획자 정보
        </a>

        <h3 class="ui header" style="margin:0;"><?=$article_data['title']?></h3>
        <div class="meta">
            <span><?=xssHtmlProtect($ex['message'])?></span>
        </div>
        <div class="description">
            <p><?=xssHtmlProtect($article_data['content'])?></p>
        </div>
        <div class="ui label green float--right" style="margin:10px 1px 0 8px;"><?= $lang_developers ?> <div class="detail"><?=$ex['recruit_developer']?></div></div>
         <div class="ui label blue float--right" style="margin:10px 1px 0 8px;"><?= $lang_designers ?> <div class="detail"><?=$ex['recruit_designer']?></div></div>
         <div class="ui label teal float--right" style="margin:10px 1px 0 8px;"><?= $lang_planners ?> <div class="detail"><?=$ex['recruit_planner']?></div></div>
    </div>

   <h4 class="ui divider header">
      <i class="bar newspaper icon"></i>
      <?= $lang_bmc ?>
    </h4>


    <h3>#1 <?= $lang_td1 ?></h3>
    <p><?=$ex['slide_1']?></p>
    <h3>#2 <?= $lang_td2 ?></h3>
    <p><?=$ex['slide_2']?></p>
    <h3>#3 <?= $lang_td3 ?></h3>
    <p><?=$ex['slide_3']?></p>
    <h3>#4 <?= $lang_td4 ?></h3>
    <p><?=$ex['slide_4']?></p>
    <h3>#5 <?= $lang_td5 ?></h3>
    <p><?=$ex['slide_5']?></p>
    <h3>#6 <?= $lang_td6 ?></h3>
    <p><?=$ex['slide_6']?></p>

    <h4 class="ui divider header">
      <i class="bar chart icon"></i>
      <?= $lang_rate_it ?>
    </h4>
    <?
    $check_grade = mysql_query("SELECT *
                                FROM  `bm_grade`
                                WHERE  `article_idx` =$article_id
                                AND  `user_idx` =$user_idx");
    $check_grade_data = mysql_fetch_array($check_grade);

    if (mysql_num_rows($check_grade) >= 1):
    ?>
    <div class="ui form">
        <div class="grouped fields">
            <label><?= $lang_bm_grade1 ?></label>
            <div class="field">
                <div class="ui radio checkbox">
                    <input type="radio" name="score" value="1" readonly <?=($check_grade_data['score']==1)?'checked="checked"':''?>>
                    <label><?= $lang_bm_grade2 ?></label>
                </div>
            </div>
            <div class="field">
                <div class="ui radio checkbox">
                    <input type="radio" name="score" value="0" readonly <?=($check_grade_data['score']==0)?'checked="checked"':''?>>
                    <label><?= $lang_bm_grade3 ?></label>
                </div>
            </div>
        </div>
        <div class="grouped fields">
            <label><?= $lang_bm_grade4 ?></label>
            <div class="field">
                <div class="ui fluid input">
                    <input type="text" name="summary" readonly value="<?=$check_grade_data['summary']?>" placeholder="<?= $lang_bm_grade5 ?>">
                </div>
            </div>
        </div>
        <div class="grouped field">
            <label><?= $lang_bm_grade6 ?></label>
            <textarea name="opinion" rows="2" readonly><?=$check_grade_data['opinion']?></textarea>
        </div>
        <input type="hidden" name="article_id" value="<?=$article_id?>">
    </div>
    <div style="text-align: center; margin: 10px 0 0 0">
        <button class="ui basic button"><?= $lang_complete ?></button>
    </div>
    <? else: ?>
    <form action="/public/do_bm_grade.php" method="post">
        <div class="ui form">
            <div class="grouped fields">
                <label><?= $lang_bm_grade1 ?></label>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input type="radio" name="score" value="1" checked="checked">
                        <label><?= $lang_bm_grade2 ?></label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input type="radio" name="score" value="0">
                        <label><?= $lang_bm_grade3 ?></label>
                    </div>
                </div>
            </div>
            <div class="grouped fields">
                <label><?= $lang_bm_grade4 ?></label>
                <div class="field">
                    <div class="ui fluid input">
                        <input type="text" name="summary" placeholder="<?= $lang_bm_grade5 ?>">
                    </div>
                </div>
            </div>
            <div class="grouped field">
                <label><?= $lang_bm_grade6 ?></label>
                <textarea name="opinion" rows="2"></textarea>
            </div>
            <input type="hidden" name="article_id" value="<? echo $article_id?>">
        </div>
        <div style="text-align: center; margin: 10px 0 0 0">
            <button class="ui primary button"><?= $lang_submit ?></button>
        </div>
    </form>
    <? endif; ?>

</div>

<script>

function reply(target){
    var value = $(target).attr("value");
    var comment = $(target).parent().find(".comment_input").val();
    var article_id = "<?=$article_id?>";

    var url = './do_add_discuss.php';
    var form = $('<form action="' + url + '" method="post">' +
      '<input type="hidden" name="content" value="' + comment + '" />' +
      '<input type="hidden" name="parent_idx" value="' + value + '" />' +
      '<input type="hidden" name="article_id" value="' + value + '" />' +
      '</form>');
    $('body').append(form);
    form.submit();

}

</script>
