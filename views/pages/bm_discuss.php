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

<div class="ui top attached tabular menu">
    <span class="item left"><? echo $article_data['title']; ?></span>
    <a href="/public/bm_grade?board_id=business_model" class="item right " data-tab="intro">개요</a>
    <a href="/public/bm_grade?board_id=business_discuss" class="item active" data-tab="talk">토론</a>
    <a href="/public/bm_grade?board_id=business_result" class="item" data-tab="result">첫인상평가결과</a>
</div>
<!-- Step -->


<div class="ui bottom attached tab segment active" data-tab="talk">
    <form class="ui form" action="./do_add_discuss.php" method="post" id="discuss_form">
        <input type="hidden" name="article_id" value="<?=$article_id?>">
        <div class="ui comments" style="max-width: 100%; margin-bottom: 10px;">
            <div class="comment">
                <a class="avatar">
                    <img src="/images/avatar/small/jenny.jpg">
                </a>
                <div class="content">
                    <textarea placeholder="이 팀의 비즈모델에 대한 생각/질문을 남겨주세요." name="content"></textarea>
                </div>
            </div>
        </div>
        <div class="clearfix"><div class="ui blue labeled submit icon button float--right" onClick="add_discuss()"><i class="icon edit"></i> 등록</div> </div>
        <script>
            function add_discuss(){
                $("#discuss_form").submit();
            }
        </script>
    </form>
    <div class="ui divider"></div>
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
