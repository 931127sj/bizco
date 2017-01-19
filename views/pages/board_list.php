<?
///////////////////SERVER
$board_id = $_GET['board_id'];
$board_type = $_GET['board_type'];
$company_id = $_SESSION['company'];

//일반게시판
if($board_type != "team") {
    $board_query = mysql_query("SELECT *
    							FROM  `board`
    							WHERE  `board_id` =  '$board_id'
    							AND  `company_id` =  '{$company_id}' ORDER BY `idx` DESC");
    $board_data = mysql_fetch_array($board_query);
//팀게시판
} else {

    $team_query = mysql_query("SELECT *
                                FROM  `team`
                                WHERE  `idx` = '{$board_id}' ORDER BY `idx` DESC");
    $board_data = mysql_fetch_array($team_query);

    $type_team = "&board_type=team";
}
/////////////////////BOARD CONTENT
$article_query = mysql_query("SELECT *
				FROM  `article`
				WHERE  `company_id` =  '{$company_id}'
				AND  `board_id` =  '$board_id'
				ORDER BY  `article`.`idx` DESC ");

/////////////////////USER INFO

?>

<div class="clearfix">
    <h2 class="ui header left floated" style="margin: 3px 0;"><? echo $board_data['name']; ?></h2>
    <? if($_SESSION['level'] >= $board_data['write_level']) { ?>
    	<a href="/public/board_write?board_id=<? echo $board_id; ?><?= $type_team ?>">
        <button class="ui right floated blue button"><?= $lang_write ?></button></a>

	<? } ?>
</div>

<div class="ui divider forh2"></div>
<table class="ui single line striped compact table">
    <tbody>
    	<? while($article_data = mysql_fetch_array($article_query)) { ?>

                <td><a href='/public/view_article?board_id=<? echo $board_id; ?>&article_id=<? echo $article_data['idx']; ?><?= $type_team ?>'>
                		<? echo $article_data['title']; ?></a></td>
                <td class="right aligned collapsing">
                    <small><? echo $article_data['user_name']; ?></small>
                </td>
                <td class="right aligned collapsing"><? echo $article_data['write_datetime']; ?></td>

        </tr>
        <? } ?>

    </tbody>
</table>
