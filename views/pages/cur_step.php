<?
// 메뉴지정
$complete_homework = true;
$company_id = $_SESSION['company'];


// 내 현재step 단계 가져오기
$my_step = 0;
$my_step_query = mysql_query("SELECT *
                                FROM  `user_step_relation`
                                WHERE  `user_idx` =".$_SESSION['idx']);
$my_step_data = mysql_fetch_array($my_step_query);
$my_step_count = mysql_num_rows($my_step_query);

if($_SESSION['lang'] == 'en'){
  $lang_err_prev = "You must complete the previous steps before you can enter.";
  $lang_err_this = "You must complete the this steps before you can move on to the next step.";
  $lang_err_eval = "You must complete the evaluation before you can move on to the next step.";

  $lang_nextstep = "Next Step";
  $lang_curriculum = "Curriculum";
  $lang_viewcurriculum = "View Curriculum";
  $lang_step = "Step";
  $lang_evaluate = "Evaluating business model";
  $lang_bmc = "Business Model Canvas";

  $lang_msg1 = "You have completed your business model evaluation.";

  $lang_bmc1 = "Who is your customer";
  $lang_bmc2 = "What will solve the customer's problem?";
  $lang_bmc3 = "What are the core competencies that are most needed for problem solving?";
  $lang_bmc4 = "What is your revenue model?";
  $lang_bmc5 = "Enter demo site / screenshot image link";
  $lang_bmc6 = "Team Introduction";

  $lang_bm_grade1 = "Interested in the idea above? (necessary)";
  $lang_bm_grade2 = "I'm interested.";
  $lang_bm_grade3 = "I don't know";
  $lang_bm_grade4 = "What is your opinion on the idea above?";
  $lang_bm_grade5 = "One line summary";
  $lang_bm_grade6 = "Do you know similar domestic and international services? If so, please tell us that service name or site.";
  $lang_rate_it = "Rate it";
}else{
  $lang_err_prev = "이전 단계를 완료하여야 진입할 수 있습니다.";
  $lang_err_this = "이번 단계를 완수해야 다음 단계로 넘어갈 수 있습니다.";
  $lang_err_eval = "평가를 완료하여야 다음 단계로 넘어갈 수 있습니다.";

  $lang_nextstep = "다음 단계로";
  $lang_curriculum = "커리큘럼";
  $lang_viewcurriculum = "커리큘럼 보기";
  $lang_step = "단계";
  $lang_evaluate = "비즈니스 모델 평가하기";
  $lang_bmc = "비즈니스 모델 캔버스";

  $lang_msg1 = "비즈니스 모델 평가를 모두 완료하였습니다.";

  $lang_bmc1 = "나의 고객님은 어떤 문제점을 가진 누구인가?";
  $lang_bmc2 = "그 고객의 문제를 무엇으로 해결할 것인가?";
  $lang_bmc3 = "문제 해결을 위해 가장 필요한 핵심 역량은 무엇인가?";
  $lang_bmc4 = "수익 모델은?";
  $lang_bmc5 = "데모 사이트/스크린샷 이미지 링크를 입력하세요.";
  $lang_bmc6 = "팀소개";

  $lang_bm_grade1 = "위 아이디어에 관심이 있나요? (필수)";
  $lang_bm_grade2 = "관심이 있어요";
  $lang_bm_grade3 = "잘 모르겠어요";
  $lang_bm_grade4 = "위 아이디어에 대한 귀하의 의견은?";
  $lang_bm_grade5 = "한줄 정리";
  $lang_bm_grade6 = "유사한 국내외 서비스가 있나요? 있다면 서비스명이나 사이트를 말해주세요.";
  $lang_rate_it = "평가하기";
}

// step db등록 유/무확인
if(!($my_step_count >= 1 && $_SESSION['idx'])) {
    // 스탭이 없을 경우 새로 생성해 줌
    $rq = mysql_query("INSERT INTO  `user_step_relation` (
                `idx` ,
                `user_idx` ,
                `current_step_idx`
                )
                VALUES (
                NULL ,  '".$_SESSION['idx']."',  '1'
                );
                ");
    $my_step = 1;
} else {
    // 스탭이 있을 경우 현재 단계를 가져옴.
    $my_step = $my_step_data['current_step_idx'];
}
$step = ($_GET['step']!='')?$_GET['step']:$my_step;
if($step > $my_step && $_SESSION['level'] < 4) {
    msg("{$lang_err_prev}");
    back();
    exit();
}

$step_query = mysql_query("SELECT *
FROM  `curriculum_step`
WHERE `company_id` = '$company_id'
ORDER BY  `curriculum_step`.`step_seq` ASC ");
$step_all_count = mysql_num_rows($step_query);
?>
<div class="clearfix">
    <h2 class="ui header floated left" style="margin-bottom: 20px; margin-top: 5px;"><?= $lang_curriculum ?></h2>
</div>
<div id="curStep">
    <div class="nav">
        <div class="ui vertical menu basic">
            <div class="header item"><?= $lang_viewcurriculum ?></div>
            <div class="items-body">
                <a class="item hidden">don't remove</a>

                <?
                $i = 1;
                while($step_data = mysql_fetch_array($step_query)) {
                ?>
                <a class="item <?=($step==$i)?'active deep-blue':''?>" href="<? echo (($my_step<$i) && ($_SESSION['level'] < 4))?"javascript:no_permission();":"/public/cur_step?step=".$i; ?>">
                    <? echo $step_data['step_name']; ?>
                </a>
                <?
                    $i++;
                }
                ?>
            </div>
        </div>
    </div>

<div class="article">
<?
$now_step_query = mysql_query("SELECT *
FROM  `curriculum_step`
WHERE step_seq = '$step'
AND `company_id` = '$company_id'
ORDER BY  `curriculum_step`.`step_seq` ASC ");
$now_step_data = mysql_fetch_array($now_step_query);



?>
<h1 class="ui top attached header basic">
    <?= $lang_step ?> <? echo $now_step_data['step_seq']; ?>. <? echo $now_step_data['step_name']; ?>
</h1>
<div class="ui bottom attached segment explain">
    <p>
    	<? echo $now_step_data['step_explain']; ?>
    </p>

</div>
<?
///////// 과제 리스트 LIST
$homework = mysql_query("SELECT *
						FROM  `article`
						WHERE  `board_id` LIKE  '{$company_id}_cur'
						AND  `step_id` =".$now_step_data['step_seq']
						." ORDER BY `priority` ASC");

$homework_count = mysql_num_rows($homework);
if($homework_count > 0) {
	?>
	<div class="ui segments basic">
	<?
	while($homework_data = mysql_fetch_array($homework)) {

		$my_hr_query= mysql_query("SELECT * FROM  `homework` WHERE  `user_idx` =".$_SESSION['idx']." AND  `article_idx` =".$homework_data['idx']." AND state = 1");
		if(mysql_num_rows($my_hr_query) > 0) {
		?>
        <div class="ui segment">
            <a href="/public/view_article?board_id=dankook_cur&article_id=<? echo $homework_data['idx']; ?>">
              <div class="ui horizontal label"><?= $lang_complete1 ?></div> <? echo $homework_data['title']; ?></a>
        </div>
        <?

		} else {
            $complete_homework = false;
		?>
        <div class="ui segment">
            <a href="/public/view_article?board_id=dankook_cur&article_id=<? echo $homework_data['idx']; ?>">
              <div class="ui deep-blue horizontal label"><?= $lang_incomplete1 ?></div> <? echo $homework_data['title']; ?></a>
        </div>
        <?

		}
		?>

	<?	}	?>
	</div>
	<?
}
?>

<?
///////// BM평가
if($now_step_data['bm_link'] == 1) {

	// 전체 BM
	$bm_list_query = mysql_query("SELECT *
								FROM  `article`
								WHERE  `board_id` =  'business_model'
                AND `company_id` = '$company_id'");
	$bm_list_count = mysql_num_rows($bm_list_query);
    //$bm_list_count(전체 비엠)

	// 평가한 BM
	$user_bm_query = mysql_query("SELECT *
								FROM  `bm_grade`
								WHERE  `user_idx` =".$_SESSION['idx']);
	$user_bm_count = mysql_num_rows($user_bm_query);

	// 가져와서 평가 안한 것만 놔두기
	$i = 0;
	while($bm_list_data = mysql_fetch_array($bm_list_query)) {
		$all_bm_id[$i] = $bm_list_data['idx'];
		$i ++;
	}
	$i = 0;
	$final_bm_id = array();
	while($user_bm_data = mysql_fetch_array($user_bm_query)) {
		$final_bm_id[$i] = $user_bm_data['article_idx'];
		$i ++;
	}
	$diff_bm_id = array_diff($all_bm_id,$final_bm_id);
	$diff_bm_id = array_values(array_filter(array_map('trim',$diff_bm_id)));
	///var_dump($all_bm_id);
	//var_dump($final_bm_id);
	//var_dump($diff_bm_id);
	$article_id = $diff_bm_id[0];

	if($user_bm_count >= $bm_list_count) {
		?>
<div class="ui segment selene-basic" style="height: 250px;">
	<h2 class="ui center aligned icon header" style="margin-top:15px;">
      <i class="checkmark icon"></i>
      <div class="content">
        <?= $lang_complete ?>
        <div class="sub header"><?= $lang_msg1 ?></div>
      </div>
    </h2>
</div>
		<?
    } else {
        $complete_homework = false;
		$article_query = mysql_query("SELECT *
									  FROM  `article`
									  WHERE  `idx` =$article_id
									  AND  `company_id` =  '$company_id'
									  AND  `board_id` =  'business_model'");
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
<div class="ui segment selene-basic wid100">
	<div class="ui top attached label" id="bm_grade"><?= $lang_evaluate ?> <strong>(<?=$user_bm_count ?>/<?= $bm_list_count ?>)</strong></div>
    <div class="clearfix">
        <img class="ui tiny left floated image" style="height: 94px; margin-right: 20px" src="<?= get_profile_url($article_data['user_idx']);  ?>">
        <h3 class="ui header" style="margin: 5px 0;"><?=$article_data['title']?>     </h3>
        <div class="meta">
            <span><?=$ex['message']?></span>
        </div>
        <div class="description">
            <p><?=$article_data['content']?></p>
        </div>
         <div class="ui label green float--right" style="margin:10px 0px 28px 8px;"><?= $lang_developers ?> <div class="detail"><?=$ex['recruit_developer']?></div></div>
         <div class="ui label blue float--right" style="margin:10px 0px 28px 8px;"><?= $lang_designers ?> <div class="detail"><?=$ex['recruit_designer']?></div></div>
         <div class="ui label teal float--right" style="margin:10px 0px 28px 8px;"><?= $lang_planners ?> <div class="detail"><?=$ex['recruit_planner']?></div></div>
    </div>
    <h4 class="ui horizontal divider header">
      <i class="bar newspaper icon"></i>
      <?= $lang_bmc ?>
    </h4>

    <h4>#1 <?= $lang_bmc1 ?></h4>
    <p><?=$ex['slide_1']?></p>
    <h4>#2 <?= $lang_bmc2 ?></h4>
    <p><?=$ex['slide_2']?></p>
    <h4>#3 <?= $lang_bmc3 ?></h4>
    <p><?=$ex['slide_3']?></p>
    <h4>#4 <?= $lang_bmc4 ?></h4>
    <p><?=$ex['slide_4']?></p>
    <h4>#5 <?= $lang_bmc5 ?></h4>
    <p><?=$ex['slide_5']?></p>
    <h4>#6 <?= $lang_bmc6 ?></h4>
    <p><?=$ex['slide_6']?></p>
    <h4 class="ui horizontal divider header">
      <i class="bar chart icon"></i>
      <?= $lang_rate_it ?>
    </h4>
    <?
    $check_grade = mysql_query("SELECT *
                                FROM  `bm_grade`
                                WHERE  `article_idx` =$article_id
                                AND  `user_idx` =$user_idx");
    $check_grade_data = mysql_fetch_array($check_grade);
	?>

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
        <div style="text-align: center; margin: 52px 0 0 0">
            <button class="ui button primary"><?= $lang_rate_it ?></button>
        </div>
        <div style="text-align: center; margin: 10px 0 48px 0">
        	<span style="font-size:12px;"><?= $lang_err_eval ?></span>
        </div>
    </form>
</div>


<?
	}
}
?>
<?
// 과제완료, 현재페이지, 마지막페이지가 아닐 경우
if($complete_homework && ($step == $my_step) && ($step < $step_all_count)) {
?>
<div style="text-align:center;">
    <a href="/public/do_next_step.php"><button class="positive ui button" style="margin:10px auto;"><?= $lang_nextstep ?> <i class="angle right icon"></i></button></a>
</div>
<?
}
?>

<script>
function no_permission() {
	alert("<?= $lang_err_this ?>");
}

$('.explain a[href^=http]').attr('target','_blank');
</script>
</div>
</div>
