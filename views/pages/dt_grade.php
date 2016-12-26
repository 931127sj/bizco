<?
////////// SERVER
$_SESSION['current_menu'] = "dt";

$article_id = $_GET['id'];
$user_idx   = $_SESSION['idx'];
$article_query = mysql_query("SELECT *
                              FROM  `design_thinking`
                              WHERE  `idx` ='$article_id' ");
$article_data = mysql_fetch_array($article_query);

$extend_query = mysql_query("SELECT *
                             FROM  `design_thinking_article`
                             WHERE  `dt_idx` =$article_id");

$i = 0;
while($extend_data = mysql_fetch_array($extend_query)) {

    $datas[$i][0] = $extend_data['type'];
    $datas[$i][1] = $extend_data['content'];

	$i ++;
}

?>

        <?
        $list_user_query= mysql_query("SELECT * FROM  `user` WHERE  `idx` =".$article_data['user_idx']);
        $list_user_data = mysql_fetch_array($list_user_query);
        ?>

<div class="ui top attached tabular menu">
    <span class="item header"><?=xssHtmlProtect($article_data['title'])?></span>
    <h2 class="ui header floated left" style="margin-bottom: 15px; margin-top: 5px;"><?=$list_user_data['name']?>의 디자인씽킹</h2>
</div>

<!-- Step -->
        <?
        $list_user_query= mysql_query("SELECT * FROM  `user` WHERE  `idx` =".$article_data['user_idx']);
        $list_user_data = mysql_fetch_array($list_user_query);
        ?>

<div id="dt" class="ui bottom attached tab segment active" data-tab="intro">

    <div class="clearfix">
        <img class="ui tiny left floated image" style="height: 94px; margin-right:17px" src="<?=get_profile_url($list_user_data['idx']);  ?>">
        <h3 class="ui header" style="margin:0;"><?=$list_user_data['name']?></h3>
        <div class="meta">
            <div class="meta">
                    <span><?=$result['position']?></span> <a href="#">@<?=$list_user_data['company_id']?></a>
                </div>
                <div class="meta clearfix">
                    <div class="ui label teal"><?=$list_user_data['part']?></div>
                    <div class="ui label">Startup on the base of Entrepreneurship</div>
                    <?
                    if($article_data['user_idx'] == $_SESSION['idx']){
                    ?>
                    <a class="mini ui button negative" href="/public/do_delete_dt.php?article_idx=<?=$article_data['idx']?>">삭제</a>
                     <a class="mini ui button negative" href="/public/dt_modify?id=<?=$article_data['idx']?>" style="background-color: #00B5AD !important">수정</a>
                    <?
                    }
                    ?>
                </div>
        </div>
        <div class="description">
            <p><?=xssHtmlProtect($article_data['content'])?></p>
        </div>
    </div>
    <div class="ui divider"></div>
    <h2 class="ui center aligned header">Design Think 6-STEP</h2>
    <h3>1단계 공감하기</h3>
    <p>
        <?
            for($i =0; $i < count($datas); $i++){
                if($datas[$i][0] == 'link'){
                    echo $datas[$i][1]."<br>";
                }
            }
        ?>
    </p>
    <h3>2단계 문제정의</h3>
    
    <p><?=$article_data['problem_cause']?></p>
 
	<p><a target="_blank" href="<?=($article_data['image2']!='')?"/data/dt_thumb/real_".$article_data['image2']:""; ?>">
	<img class= "ui big image" src="<?=($article_data['image2']!='')?"/data/dt_thumb/".$article_data['image2']:""; ?>"></a></p>

    <h3>3단계 아이디어 도출</h3>
    <p>
        <?
            for($i =0; $i < count($datas); $i++){
                if($datas[$i][0] == 'idea'){
                    echo $datas[$i][1]."<br>";
                }
            }
        ?>
    </p>
    <h3>4단계 시제품 만들기</h3>
    <p><a target="_blank" href="<?=($article_data['image']!='')?"/data/dt_thumb/real_".$article_data['image']:""; ?>"><img class = "ui big image" src="<?=($article_data['image']!='')?"/data/dt_thumb/".$article_data['image']:""; ?>"><?="<br>".$article_data['youtube_link']?></a></p>
    <h3>5단계 테스트</h3>
    <p>
        <?
            for($i =0; $i < count($datas); $i++){
                if($datas[$i][0] == 'test'){
                    echo $datas[$i][1]."<br>";
                }
            }
        ?>
    </p>
    <p><?=$ex['slide_6']?></p>
    <?
    $check_grade = mysql_query("SELECT *
                                FROM  `bm_grade`
                                WHERE  `article_idx` =$article_id
                                AND  `user_idx` =$user_idx");
    $check_grade_data = mysql_fetch_array($check_grade);

    if (mysql_num_rows($check_grade) >= 1):
    ?>

    <? else: ?>
    <? endif; ?>

</div>
<?
////////// SERVER
$board_id = $_GET['board_id'];
$article_id = $_GET['article_id'];
$user_idx = $_SESSION['idx'];
$article_query = mysql_query("SELECT *
FROM  `article`
WHERE  `idx` =$article_id
AND  `company_id` =  'dankook'
AND  `board_id` =  '$board_id'");
$article_data = mysql_fetch_array($article_query);

$extend_query = mysql_query("SELECT *
            FROM  `board_extend_data`
            WHERE  `article_idx` =$article_id");

$i = 0;
while($extend_data = mysql_fetch_array($extend_query)) {
    $exid = $extend_data['extend_idx'];
    $ex[$exid] = $extend_data['content'];

    $i ++;
}

$bm_grade_query = mysql_query("SELECT * FROM `bm_grade` WHERE `article_idx` = '".$_GET['article_id']."'");

?>
<div class="ui bottom attached tab segment" data-tab="talk">
    <form class="ui form" action="./do_add_discuss.php" method="post" id="discuss_form">
        <input type="hidden" name="article_id" value="<?=$article_id?>">
    </form>
    <div class="ui feed">
        <?php
        while($row = mysql_fetch_array($bm_grade_query)){
            ?>
        <div class="event">
            <div class="label">
                <img src="/images/avatar/small/jenny.jpg">
            </div>
            <div class="content">
                <div class="summary">
                    <div class="ui label green">첫인상평가</div>
                    <div class="date">
                        5달 전
                    </div>
                </div>
                <p>
                    <div class="ui list">
                        <div class="item clearfix">
                            <div class="left-header">평가</div>
                            <div class="left-header-content">
                            <?
                            if($row['score'] == 1){
                            ?>
                                <i class="thumbs outline up icon blue"></i>
                            <?
                            }else{
                            ?>
                                <i class="thumbs outline down icon red"></i>
                            <?
                            }
                            ?>
                            </div>
                        </div>
                        <div class="item clearfix">
                            <div class="left-header">비즈모델 재정의</div>
                            <div class="left-header-content"><?=$row['summary']?></div>
                        </div>
                        <div class="item clearfix">
                            <div class="left-header">유사서비스 및 의견</div>
                            <div class="left-header-content"><?=$row['opinion']?></div>
                        </div>
                    </div>
                </p>
                <div class="ui comments">
                    <div class="comment">
                        <?
                        $comment_query = mysql_query("SELECT * FROM comment join user on comment.user_idx = user.idx WHERE `parent_idx` = '".$row['idx']."' and `type` = 'discuss'");
                        while($comment = mysql_fetch_array($comment_query)){
                            //print_r($comment);
                        ?>
                        <a class="avatar">
                            <img src="/images/avatar/small/steve.jpg">
                        </a>
                        <div class="content">
                            <a class="author"><?=$comment['name']?></a>
                            <div class="metadata">
                                <div class="date">5달 전</div>
                            </div>
                            <div class="text">
                                <?=$comment['content']?>
                            </div>
                        </div>
                        <?
                        }
                        ?>
                        <form class="ui reply form">
                            <div class="field">
                                <textarea placeholder="댓글을 입력하세요" class="comment_input"></textarea>
                            </div>
                            <div class="ui primary submit labeled icon button" onClick="reply(this)" value="<?=$row['idx']?>">
                                <i class="icon edit"></i> 등록
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <?php
        }
        ?>
    </div>
</div>
<div class="ui bottom attached tab segment" data-tab="result">
    <table class="ui very basic table">
        <thead>
            <tr>
                <th>평가</th>
                <th>이 비즈니스 모델을 한마디로 말 한다면?</th>
                <th>유사 제품/서비스 및 의견</th>
                <th>피드백</th>
            </tr>
        </thead>
        <?
			$grade_query = mysql_query("SELECT *
										FROM  `bm_grade`
										WHERE  `article_idx` =$article_id");
		?>
        <tbody>
        	<? while($grade_data = mysql_fetch_array($grade_query)) { ?>
            <tr>
                <td><i class="<?=($grade_data['score'])?"thumbs outline up icon blue":"thumbs outline down icon red" ?>"></i></td>
                <td><?=$grade_data['summary'];  ?></td>
                <td><?=$grade_data['opinion']; ?></td>
                <td>-</td>
            </tr>

            <? } ?>
        </tbody>
    </table>
</div>

<script>

function reply(target){
    var value = $(target).attr("value");
    var comment = $(target).parent().find(".comment_input").val();
    var article_id = "<?=$article_id?>";

    var url = './do_add_discuss.php';
    var form = $('<form action="' + url + '" method="post">' +
      '<input type="hidden" name="content" value="' + comment + '" />' +
      '<input type="hidden" name="parent_idx" value="' + value + '" />' +
      '<input type="hidden" name="article_id" value="' + value + '" />' +
      '</form>');
    $('body').append(form);
    form.submit();

}

</script>