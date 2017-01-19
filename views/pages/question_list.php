
<?
require_once(VIEW.'common/_language.php');

$board_id = $_GET['id'];
$company  = $_SESSION['company'];
$user_idx = $_SESSION['idx'];


/////////////////////BOARD CONTENT
$article_query = mysql_query("SELECT *
                              FROM `article`
                              WHERE `company_id` = '$company'
                              AND `board_id` = 'etc_question'
                              AND `user_idx` = '$user_idx'
                              ORDER BY `article`.`idx` DESC ");
?>



<div class="clearfix">
    <h2 class="ui header left floated" style="margin: 3px 0;">멘토링 게시판</h2>
    <a href="/public/question_write?company_id=<?=$company?>">
      <button class="ui right floated blue button"><?= $lang_write ?></button></a>
</div>
<div class="ui divider forh2"></div>
<table class="ui single line striped compact table">
    <tbody>
        <? while($article_data = mysql_fetch_array($article_query)) {
                $user_query = mysql_query("SELECT * FROM  `user` WHERE  `idx` =".$article_data['user_idx']);
                $user_data = mysql_fetch_array($user_query);
            ?>
        <tr>
            <td style="font-weight: bold;"><a href="/public/view_article?board_id=etc_question&article_id=<? echo $article_data['idx']?>"><?=$article_data['title']?></a></td>
            <td class="right aligned collapsing">
                <small><?=$user_data['name']?></small>
            </td>
            <td class="right aligned collapsing"><?=$article_data['write_datetime']?></td>
        </tr>
        <? } ?>
    </tbody>
</table>
