<?
///////////////////SERVER
$board_id = $_GET['board_id'];
$step_id = $_GET['step_id'];
$board_type = $_GET['board_type'];
$company_id = $_SESSION['company'];

$article_id = $_GET['article_id'];

if($article_id != '') {

	$article_query = mysql_query("SELECT * FROM  `article` WHERE  `idx` =$article_id");
	$article_data = mysql_fetch_array($article_query);
}

if($_SESSION['lang'] == 'en'){
	$lang_subject = "Subject";
	$lang_contents = "Contents";
	$lang_youtube = "Youtube";
	$lang_files = "Add files";
	$lang_total = "Total Max.";
}else{
	$lang_subject = "제목";
	$lang_contents = "내용";
	$lang_youtube = "유투브";
	$lang_files = "첨부파일";
	$lang_total = "합산 최대";
}
?>
<form class="ui form"  enctype="multipart/form-data" action="/public/do_write_board.php" method="post">
    <input type="hidden" name="board_id" value="<?=$board_id?>">
    <input type="hidden" name="board_type" value="<?=$board_type?>">
    <input type="hidden" name="step_id" value="<?=$step_id?>">
    <input type="hidden" name="company_id" value="<?=$company_id?>">
    <input type="hidden" name="article_id" value="<?=$article_id?>">
    <input type="hidden" name="redirect" value="<?=$_GET['redirect']?>">
    <input type="hidden" name="type" value="<?=($article_id != '')?"edit":"write"?>">
    <div class="field">
        <label><?= $lang_subject ?></label>
        <input name="title" type="text" value="<?=$article_data['title']?>">
    </div>
    <div class="field">
        <label><?= $lang_contents ?></label>
        <textarea rows="15" id="ir1" name="content" style="width: 100%;"><?=$article_data['content']?></textarea>
    </div>
    <div class="field">
        <label><?= $lang_youtube ?> URL</label>
        <input name="youtube" type="text" value="<?=$article_data['youtube_link']?>">
    </div>
     <div class="field">
        <label><?= $lang_files ?> #1~#3 (<?= $lang_total ?> <?=ini_get('post_max_size') ?>)</label>
        <div style="margin-bottom:5px;"><input name="attach1" type="file"></div>
        <div style="margin-bottom:5px;"><input name="attach2" type="file"></div>
        <div style="margin-bottom:5px;"><input name="attach3" type="file"></div>
    </div>
    <button class="ui button primary" id="save"  onclick="return false; "><?= $lang_write ?></button>
</form>
