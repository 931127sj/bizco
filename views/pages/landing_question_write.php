<?
if($_SESSION['lang'] == "en"){
  $lang_subject = "Subject";
  $lang_name = "Name";
  $lang_contents = "Contents";
}else{
  $lang_subject = "문의 제목";
  $lang_name = "작성자";
  $lang_contents = "문의 내용";
}
?>
<form class="ui form" action="/public/do_write_board.php" method="post">
    <input type="hidden" name="company_id" value="<?=$company_id?>">
    <input type="hidden" name="board_id" value="landing_question">
    <input type="hidden" name="type" value="write">
    <input type="hidden" name="redirect" value="question_list?company=<?=$company_id?>">
    <div class="field">
        <label><?= $lang_subject ?></label>
        <input type="text" name="title" required>
    </div>
    <div class="field">
        <label><?= $lang_name ?></label>
        <input type="text" name="name" required>
    </div>
    <div class="field">
        <label><?= $lang_contents ?></label>
        <textarea rows="15" name="content" placeholder = "반드시 답변을 받을 이메일 또는 연락처를 남겨주세요." required></textarea>
    </div>
    <button class="ui button primary"><?= $lang_submit ?></button>
</form>
