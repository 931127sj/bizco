<?php
$company_id = $_GET['company'];

$query = mysql_query("SELECT * from article where company_id = '$company_id' and board_id = 'faq'");
$rs = mysql_fetch_array($query);
// print_r($rs);
?>
<form class="ui form" action="/public/do_write_faq.php" method="post">
    <input type="hidden" name="company_id" value="<?=$company_id?>">
    <div class="field">
        <label>FAQ 내용</label>
        <textarea rows="15" id="ir1" name="content" style="width: 100%;"><?=$rs['content']?></textarea>
    </div>
    <button class="ui button primary" id="save">등록 및 수정</button>
</form>