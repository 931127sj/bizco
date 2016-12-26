<?php
$company_id = $_SESSION['company'];

$query = mysql_query("SELECT * from article where company_id = '$company_id' and board_id = 'faq'");
$rs = mysql_fetch_array($query);
?>

<div class="clearfix">
    <h2 class="ui header left floated" style="margin: 3px 0;">FAQ</h2>
    <? if($_SESSION['level'] >= 5) { ?><a class="ui right floated blue button" href="/public/faq_write?company=<?=$company_id?>">수정</a><? } ?>
</div>
<div class="ui divider forh2"></div>

<div class="ui segment selene-basic">
<?=$rs['content']?>
</div>