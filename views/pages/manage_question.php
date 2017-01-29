
<?
require_once(VIEW.'common/_language.php');


/////////////////////BOARD CONTENT
$article_query = mysql_query("SELECT *
                              FROM `article`
                              WHERE `board_id` = 'landing_question'
                              ORDER BY `article`.`idx` DESC ");

if($_SESSION['lang'] == "en"){
  $lang_title = "Inquiry board";
}else{
  $lang_title = "문의 게시판";
}
?>



<div class="clearfix">
    <h2 class="ui header left floated" style="margin: 3px 0;"><?= $lang_title ?></h2>
    <a href="/public/question_write?company_id=<?=$company?>">
      <button class="ui right floated blue button"><?= $lang_write ?></button></a>
</div>
<div class="ui divider forh2"></div>
<table class="ui single line striped compact table">
    <tbody>
        <? while($article_data = mysql_fetch_array($article_query)) {
                $user_query = mysql_query("SELECT * FROM  `user` WHERE  `idx` =".$article_data['user_idx']);
            ?>
        <tr>
            <td style="font-weight: bold;"><a href="/public/view_article?board_id=landing_question&article_id=<? echo $article_data['idx']?>"><?=$article_data['title']?></a></td>
            <td class="right aligned collapsing">
                <small><?=$article_data['user_name']?></small>
            </td>
            <td class="right aligned collapsing"><?=$article_data['write_datetime']?></td>
        </tr>
        <? } ?>
    </tbody>
</table>
