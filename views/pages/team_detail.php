<?
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

?>

<div class="ui top attached tabular menu" id="bmGrade1">
    <span class="item header"><?=xssHtmlProtect($article_data['title'])?></span>
    <a href="/public/bm_grade?board_id=business_model" class="item right active" data-tab="intro">개요</a>
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
      비즈니스모델 캔버스
    </h4>


    <h3>#1 나의 고객님은 어떤 문제점을 가진 누구인가?</h3>
    <p><?=$ex['slide_1']?></p>
    <h3>#2 그 고객의 문제를 무엇으로 해결할 것인가?</h3>
    <p><?=$ex['slide_2']?></p>
    <h3>#3 문제 해결을 위해 가장 필요한 핵심 역량은 무엇인가?</h3>
    <p><?=$ex['slide_3']?></p>
    <h3>#4 수익 모델은?</h3>
    <p><?=$ex['slide_4']?></p>
    <h3>#5 데모 사이트/스크린샷 이미지 링크를 입력하세요.</h3>
    <p><?=$ex['slide_5']?></p>
    <h3>#6 팀소개</h3>
    <p><?=$ex['slide_6']?></p>

    <h4 class="ui divider header">
      <i class="bar chart icon"></i>
      평가하기
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
            <label>위 아이디어에 관심이 있나요? (필수)</label>
            <div class="field">
                <div class="ui radio checkbox">
                    <input type="radio" name="score" value="1" readonly <?=($check_grade_data['score']==1)?'checked="checked"':''?>>
                    <label>관심이 있어요</label>
                </div>
            </div>
            <div class="field">
                <div class="ui radio checkbox">
                    <input type="radio" name="score" value="0" readonly <?=($check_grade_data['score']==0)?'checked="checked"':''?>>
                    <label>잘 모르겠어요</label>
                </div>
            </div>
        </div>
        <div class="grouped fields">
            <label>위 아이디어에 대한 귀하의 의견은?</label>
            <div class="field">
                <div class="ui fluid input">
                    <input type="text" name="summary" readonly value="<?=$check_grade_data['summary']?>" placeholder="한줄 정리">
                </div>
            </div>
        </div>
        <div class="grouped field">
            <label>유사한 국내외 서비스가 있나요? 있다면 서비스명이나 사이트를 말해주세요.</label>
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
                <label>위 아이디어에 관심이 있나요? (필수)</label>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input type="radio" name="score" value="1" checked="checked">
                        <label>관심이 있어요</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input type="radio" name="score" value="0">
                        <label>잘 모르겠어요</label>
                    </div>
                </div>
            </div>
            <div class="grouped fields">
                <label>위 아이디어에 대한 귀하의 의견은?</label>
                <div class="field">
                    <div class="ui fluid input">
                        <input type="text" name="summary" placeholder="한줄 정리">
                    </div>
                </div>
            </div>
            <div class="grouped field">
                <label>유사한 국내외 서비스가 있나요? 있다면 서비스명이나 사이트를 말해주세요.</label>
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
