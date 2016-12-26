<?

$type	= $_GET['type'];
$idx	= $_GET['idx'];
if($type == "edit") {
	$article = mysql_query("SELECT * 
								FROM  `article` 
								WHERE  `idx` =$idx");
	$article_data = mysql_fetch_array($article);
	
	$extend = mysql_query("SELECT * 
							FROM  `board_extend_data` 
							WHERE  `article_idx` =$idx");
	$i = 0;
	while($extend_temp = mysql_fetch_array($extend)) {
		$et = $extend_temp['extend_idx'];
		$extend_data[$et] = $extend_temp['content'];

	}
	//var_dump($article_data);
	//var_dump($extend_data);
?>
<h2 class="ui header">내 비즈니스모델 수정</h2>
<?
} else {
?>
<h2 class="ui header">신규 비즈니스모델 등록</h2>
<?	
}
?>

<div class="ui divider"></div>
<form class="ui form" action="/public/do_write_board.php" method="post">
    <div class="field inline">
        <h3><i class="ui icon send outline"></i> 기본정보</h3>
    </div>
    <div class="required field">
        <label>제목 (15자)</label>
        <input type="text" name="title" placeholder="제목" value="<?=$article_data['title']; ?>">
    </div>
    <div class="required field">
        <label>요약설명 (30자)</label>
        <input type="text" name="ex_message" placeholder="요약설명" value="<?=$extend_data['message']; ?>">
    </div>
    <!--<div class="field">
        <label>도메인</label>
        <input type="text" name="ex_domain" placeholder="확보한 도메인을 입력하세요.">
    </div>-->
    <div class="required field">
        <label>비즈니스 모델 유형</label>
        <select name="ex_bus_type" class="ui fluid dropdown">
            <option value="val1" <?=($extend_data['bus_type']=="val1")?" selected":""; ?>>선택</option>
            <option value="val2" <?=($extend_data['bus_type']=="val2")?" selected":""; ?>>지식서비스</option>
            <option value="val3" <?=($extend_data['bus_type']=="val3")?" selected":""; ?>>제조업</option>
        </select>
    </div>
    <div class="required field">
        <label>요약</label>
    </div>
    <!-- <div class="field inline">
        <input type="text" name="ex_summary_who" placeholder="누구에게 (20자)"> 에게 <input type="text" name="ex_summary_what" placeholder="무엇을? (20자)"> 을(를) 제공한다. <input type="text" name="ex_summary_why" placeholder="왜? (20자)">
    </div> -->
    <div class="field">
        <textarea name="content" rows="2"><?=$article_data['content']; ?></textarea>
    </div>
    <div class="ui divider"></div>
    <div class="field">
        <h3><i class="ui icon send outline"></i> 자신의 사업아이템</h3>
        <p>
            사업아이템을 아래의 문항을 통해 정리해주세요.
            <div class="ui bulleted list">
                <div class="item"><a href="#">사업아이템 작성법</a></div>
                <div class="item"><a href="#">참고자료: 단국대학교 엔턴십</a></div>
            </div>
        </p>
    </div>
    <div class="required field">
        <label>1. (Who) 나의 고객은?</label>
        <textarea rows="2" name="ex_slide_1"><?=$extend_data['slide_1']; ?></textarea>
    </div>
    <div class="required field">
        <label>2. (What) 고객의 문제는?</label>
        <textarea rows="2" name="ex_slide_2"><?=$extend_data['slide_2']; ?></textarea>
    </div>
    <div class="required field">
        <label>3. (HOW) 고객의 문제를 어떻게 해결할것인가?</label>
        <textarea rows="2" name="ex_slide_3"><?=$extend_data['slide_3']; ?></textarea>
    </div>
    <div class="field">
        <label>4. 수익 모델은?</label>
        <textarea rows="2" name="ex_slide_4"><?=$extend_data['slide_4']; ?></textarea>
    </div>
    <div class="required field">
        <label>5. 자신의 웹사이트 또는 랜딩페이지</label>
        <textarea rows="2" name="ex_slide_5"><?=$extend_data['slide_5']; ?></textarea>
    </div>
    <div class="required field">
        <label>6. 팀소개(팀의 역량)</label>
        <textarea rows="2" name="ex_slide_6"><?=$extend_data['slide_6']; ?></textarea>
    </div>
    <div class="field inline">
        <label style="margin-left: 10px;">구인중인 개발자</label>
        <input type="number" style="width: 80px;" name="ex_recruit_developer" value="<?=($extend_data['recruit_developer']!='')?$extend_data['recruit_developer']:"0"; ?>"> 명
        <label style="margin-left: 10px;">구인중인 디자이너</label>
        <input type="number" style="width: 80px;" name="ex_recruit_designer" value="<?=($extend_data['recruit_designer']!='')?$extend_data['recruit_designer']:"0"; ?>"> 명
        <label style="margin-left: 10px;">구인중인 기획자</label>
        <input type="number" style="width: 80px;" name="ex_recruit_planner" value="<?=($extend_data['recruit_planner']!='')?$extend_data['recruit_planner']:"0"; ?>"> 명
    </div>

    <div class="ui divider"></div>
    <input type="hidden" name="board_id" value="<? echo $_GET['id']; ?>">
    <input type="hidden" name="board_type" value="bm"/>
    <input type="hidden" name="company_id" value="<?= $_SESSION['company']; ?>"/>
    <? if($type == "edit") { ?>
    <input type="hidden" name="type" value="edit"/>
    <input type="hidden" name="article_id" value="<?=$idx; ?>"/>
    <? } ?>
    <a href="#" onclick="$(this).closest('form').submit()"><button class="ui button positive" type="button">저장하기</button></a>
    <button class="ui button red" type="button">취소하기</button>
</form>