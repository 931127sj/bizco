<?
///////////////////SERVER
$board_type = $_GET['board_type'];

$board_query = mysql_query("SELECT *
                            FROM  `article`
                            WHERE  `board_id` =  `landing_question`
                            ORDER BY `article`.`idx` DESC");
$board_data = mysql_fetch_array($board_query);

/////////////////////USER INFO

?>

<div class="clearfix">
    <h2 class="ui header left floated" style="margin: 3px 0;"><? echo $board_data['name']; ?></h2>
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
