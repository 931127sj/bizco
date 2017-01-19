<?php
require_once(VIEW.'common/_language.php');
$company_id = $_GET['company_id'];
?>
<form class="ui form" action="/public/do_write_board.php" method="post">
    <input type="hidden" name="company_id" value="<?=$company_id?>">
    <input type="hidden" name="board_id" value="etc_question">
    <input type="hidden" name="type" value="write">
    <input type="hidden" name="redirect" value="question_list?company=<?=$company_id?>">
    <div class="field">
        <label>문의 제목</label>
        <input type="text" name="title" required>
    </div>
    <div class="field">
        <label>문의 내용</label>
        <textarea rows="15" name="content" required></textarea>
    </div>
    <button class="ui button primary"><?= $lang_write ?></button>
</form>
