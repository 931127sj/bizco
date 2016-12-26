<?
////////// SERVER
$board_id   = $_GET['board_id'];
$article_id = $_GET['article_id'];
$user_idx   = $_SESSION['idx'];
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

?>

<div class="ui top attached tabular menu" id="bmGrade1">
    <span class="item header"><?=xssHtmlProtect($article_data['title'])?></span>
    <a href="/public/bm_grade?board_id=business_model" class="item right active" data-tab="intro">개요</a>
    <!--<a href="/public/bm_grade?board_id=business_discuss" class="item" data-tab="talk">토론</a>-->
    <a href="/public/bm_grade?board_id=business_result" class="item" data-tab="result">첫인상평가결과</a>
    <!--<a href="/public/bm_grade?board_id=business_result" class="item" data-tab="talk">토론</a>-->
    <? if($_SESSION['idx'] == $article_data['user_idx']) { ?>
    <a href="/public/bm_new?type=edit&board_id=business_model&article_id=<?= $article_id; ?>" class="item">수정</a>
    <a href="/public/do_del_article.php?board_id=business_model&article_id=<?= $article_id; ?>" class="item">삭제</a>
    <? } ?>
</div>
<!-- Step -->


<div id="bmGrade2" class="ui bottom attached tab segment active" data-tab="intro">

    <div class="clearfix" style="position: relative;">
        <img class="ui tiny left floated image" style="height: 94px" src="<?=get_profile_url($article_data['user_idx']);  ?>">
        <a class="image-bottom-info-text" href = "./userpage?id=<?=$article_data['user_idx']?>">
            <i class="info circle icon"></i>
            기획자 정보
        </a>
        
        <h3 class="ui header" style="margin:0;"><?=$article_data['title']?></h3>
        <div class="meta">
            <span><?=xssHtmlProtect($ex['message'])?></span>
        </div>
        <div class="description">
            <p><?=xssHtmlProtect($article_data['content'])?></p>
        </div>
        <div class="ui label green float--right" style="margin:10px 1px 0 8px;">개발자 <div class="detail"><?=$ex['recruit_developer']?></div></div>
         <div class="ui label blue float--right" style="margin:10px 1px 0 8px;">디자이너 <div class="detail"><?=$ex['recruit_designer']?></div></div>
         <div class="ui label teal float--right" style="margin:10px 1px 0 8px;">기획 <div class="detail"><?=$ex['recruit_planner']?></div></div>
    </div>

   <h4 class="ui divider header">
      <i class="bar newspaper icon"></i>
      비즈니스모델 캔버스
    </h4>


    <h3>1. (Who) 나의 고객은?</h3>
    <p><?=$ex['slide_1']?></p>
    <h3>2. (What) 고객의 문제는?</h3>
    <p><?=$ex['slide_2']?></p>
    <h3>3. (HOW) 고객의 문제를 어떻게 해결할것인가?</h3>
    <p><?=$ex['slide_3']?></p>
    <h3>4. 수익 모델은?</h3>
    <p><?=$ex['slide_4']?></p>
    <h3>5. 자신의 웹사이트 또는 랜딩페이지</h3>
    <p><?=$ex['slide_5']?></p>
    <h3>6. 팀소개(팀의 역량)</h3>
    <p><?=$ex['slide_6']?></p>

    <h4 class="ui divider header">
      <i class="bar chart icon"></i>
      평가하기
    </h4>
    <?
    $check_grade = mysql_query("SELECT *
                                FROM  `bm_grade`
                                WHERE  `article_idx` =$article_id
                                AND  `user_idx` =$user_idx");
    $check_grade_data = mysql_fetch_array($check_grade);

    if (mysql_num_rows($check_grade) >= 1):
    ?>
    <div class="ui form">
        <div class="grouped fields">
            <label>위 아이디어에 관심이 있나요? (필수)</label>
            <div class="field">
                <div class="ui radio checkbox">
                    <input type="radio" name="score" value="1" readonly <?=($check_grade_data['score']==1)?'checked="checked"':''?>>
                    <label>관심이 있어요</label>
                </div>
            </div>
            <div class="field">
                <div class="ui radio checkbox">
                    <input type="radio" name="score" value="0" readonly <?=($check_grade_data['score']==0)?'checked="checked"':''?>>
                    <label>잘 모르겠어요</label>
                </div>
            </div>
        </div>
        <div class="grouped fields">
            <label>위 아이디어에 대한 귀하의 의견은?</label>
            <div class="field">
                <div class="ui fluid input">
                    <input type="text" name="summary" readonly value="<?=$check_grade_data['summary']?>" placeholder="한줄 정리">
                </div>
            </div>
        </div>
        <div class="grouped field">
            <label>유사한 국내외 서비스가 있나요? 있다면 서비스명이나 사이트를 말해주세요.</label>
            <textarea name="opinion" rows="2" readonly><?=$check_grade_data['opinion']?></textarea>
        </div>
        <input type="hidden" name="article_id" value="<?=$article_id?>">
    </div>
    <div style="text-align: center; margin: 10px 0 0 0">
        <button class="ui basic button">평가완료</button>
    </div>
    <? else: ?>
    <form action="/public/do_bm_grade.php" method="post">
        <div class="ui form">
            <div class="grouped fields">
                <label>위 아이디어에 관심이 있나요? (필수)</label>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input type="radio" name="score" value="1" checked="checked">
                        <label>관심이 있어요</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input type="radio" name="score" value="0">
                        <label>잘 모르겠어요</label>
                    </div>
                </div>
            </div>
            <div class="grouped fields">
                <label>위 아이디어에 대한 귀하의 의견은?</label>
                <div class="field">
                    <div class="ui fluid input">
                        <input type="text" name="summary" placeholder="한줄 정리">
                    </div>
                </div>
            </div>
            <div class="grouped field">
                <label>유사한 국내외 서비스가 있나요? 있다면 서비스명이나 사이트를 말해주세요.</label>
                <textarea name="opinion" rows="2"></textarea>
            </div>
            <input type="hidden" name="article_id" value="<? echo $article_id?>">
        </div>
        <div style="text-align: center; margin: 10px 0 0 0">
            <button class="ui primary button">평가하기</button>
        </div>
    </form>
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
<div id="bmGrade4" class="ui bottom attached tab segment" data-tab="talk" style="margin:0px auto;">
    <form class="ui form" action="./do_add_discuss.php" method="post" id="discuss_form">
        <input type="hidden" name="article_id" value="<?=$article_id?>">
    </form>
    <div class="ui feed">
        <?php
        while($row = mysql_fetch_array($bm_grade_query)){
            ?>
        <div class="event">
            <div class="label">
                <img src="http://shalomtalk.kr/data/profile_thumb/sample.png">
            </div>
            <div class="content">
                <div class="summary">
                    <div class="ui tit">첫인상평가</div>
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
                            <img src="<?=get_profile_url($comment['user_idx']);  ?>">
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
                            <div class="ui blue submit button" onClick="reply(this)" value="<?=$row['idx']?>">
                                등록
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
<div id="bmGrade3" class="ui bottom attached tab segment" data-tab="result">
    <table class="ui very basic table" id="ccmtable">
        <colgroup>
            <col width="10%">
            <col width="*">
            <col width="32%">
            <col width="10%">
        </colgroup>
        <thead>
            <tr>
                <th class="icenter">평가</th>
                <th class="icenter">이 비즈니스 모델을 한마디로 말 한다면?</th>
                <th class="icenter">유사 제품/서비스 및 의견</th>
                <th class="icenter">피드백</th>
            </tr>
        </thead>
        <?
			$grade_query = mysql_query("SELECT *
										FROM  `bm_grade`
										WHERE  `article_idx` =$article_id");
		?>
        <tbody>
        	<? while($grade_data = mysql_fetch_array($grade_query)) { ?>
            <tr class="ccmtr">
                <td class="icenter"><i class="<?=($grade_data['score'])?"thumbs outline up icon blue":"thumbs outline down icon red" ?>"></i></td>
                <td><?=$grade_data['summary'];  ?></td>
                <td><?=$grade_data['opinion']; ?></td>
                <td class="icenter"><a class="ccmt_open">의견달기</a></td>
            </tr>
            <?
            	$ccmt_query = mysql_query("SELECT *
            							   FROM `comment`
            							   WHERE `article_idx` = '{$article_id}'
										   AND `parent_idx` = '{$grade_data['idx']}'
            							   ORDER BY idx ASC");
            	while($ccmt_data = mysql_fetch_array($ccmt_query)){
            		$user_data = mysql_fetch_array(mysql_query("SELECT `name` FROM `user` WHERE idx = '{$ccmt_data['user_idx']}'"));
            ?>
            <tr>
            	<td class="icenter"><?= $user_data['name'] ?></td>
            	<td colspan="2"><?= $ccmt_data['content'] ?></td>
            	<td class="icenter"><? if($ccmt_data['user_idx'] == $_SESSION['idx']){ ?>
            	<a href="#" onClick="modify_comment('<?=$ccmt_data['idx']; ?>','<?=$ccmt_data['parent_idx']; ?>', '<?=$ccmt_data['content']; ?>');">수정</a>
            	<a href="#" onClick="del_comment('<? echo $ccmt_data['idx']; ?>');">삭제</a>
            	<? } ?>
            	</td>
            </tr>
            <? } ?>
            <tr class="ccmtreply" style="display: none;">
	        <form class="ui reply form" action="/public/do_add_comment.php" method="post">
	        	<input type="hidden" name="article_id" value="<?= $article_id ?>" />
	        	<input type="hidden" name="comment_id" value="<?= $grade_data['idx'] ?>" />
	        	<input type="hidden" name="company_id" value="<?= $_SESSION['company'] ?>" />
            	<td colspan="3"><textarea rows="2" style="width:98%;margin-top:5px;" name="content"></textarea></td>
				<td class="icenter"><button class="ui blue submit icon button fluid" id="save">의견 남기기</button>
				</td>
			</form>
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

$(document).ready(function(){
    $( ".ccmt_open" ).click(function() {
        var index = $(".ccmt_open").index(this);
        $(".ccmtreply").eq(index).toggle();
    });
 
});

function del_comment(idx) {
	var con = confirm('정말로 댓글 삭제를 원하십니까?');
	if(con == 1) {

		location.replace ( "/public/do_del_comment.php?idx=" + idx);
	}
}

function modify_comment(comment_idx, parent_idx, content) {

    $('#edit_area').val(content);
    $('.comment.modal').attr('id', comment_idx);
    $('.comment.modal')
      .modal('show')
    ;
}

function comment_action(){
	//$("#password_change_form").submit();
	    var content = $('#edit_area').val();
	    var comment_idx = $('.comment.modal').attr('id');

	    $.ajax({
	        type : "POST",
	        url : "./do_edit_comment.php",
	        data : {
	            "comment_idx" : comment_idx,
	            "content" : content
	        },
	        success : function (result) {
	            if(result == "success"){
	                alert("의견을 성공적으로 수정하였습니다.");
	                $(".comment.modal").modal('hide');
	                window.location.reload(true);
	            }else{
	                alert(result);
	            }
	        }
	    });
	}
</script>

  <div class="ui comment modal">
    <i class="close icon"></i>
    <div class="header">
      의견 수정
    </div>
    <div class="content">
      <div class="ui form" style="margin:0; ">
          <textarea name="comment" id="edit_area"></textarea>
      </div>
    </div>
    <div class="actions">
      <div class="ui green button" onClick="comment_action()">수정하기</div>
    </div>
  </div>