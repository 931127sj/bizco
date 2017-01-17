<?

///////////// SERVER
$board_id = $_GET['board_id'];
$article_id = $_GET['article_id'];
$company_id = $_SESSION['company'];

if($_GET['board_type']){
	$board_type = "team";
	$type_team = "&board_type=team";
}

$article_query = mysql_query("SELECT *
FROM  `article`
WHERE  `idx` =$article_id
AND  `company_id` =  '{$company_id}'
AND  `board_id` =  '$board_id'");
$article_data = mysql_fetch_array($article_query);
if($article_data['youtube_link'] != '') {
	$isYoutube = true;
} else {
	$isYoutube = false;
}


parse_str( parse_url( $article_data['youtube_link'], PHP_URL_QUERY ), $my_array_of_vars );
if($my_array_of_vars['v'] == ''){
	$article_data['youtube_link'] = array_pop(explode('/', $article_data['youtube_link']));
}else{
	$article_data['youtube_link'] = $my_array_of_vars['v'];
}
?>


<section>
    <div class="ui segment padding--0 selene-basic noline" style="min-height:500px;">
        <div class="ui internally celled grid">
            <div class="row">
                <div class="twelve wide column line">
                    <h2 class="ui header apost"><?=$article_data['title']?></h2>

                    <p><?=$article_data['content']?></p>

					<? if($isYoutube): ?>
                    <div class="ui embed" data-source="youtube" data-id="<?=$article_data['youtube_link']?>"></div>
                	<? endif; ?>
                    <div>
                    <?
                        $file = mysql_query("SELECT *
                                            FROM  `attach`
                                            WHERE  `article_idx` =$article_id");
                        $i =0;
                        while($file_data = mysql_fetch_array($file)) {
                            $i++;
                            ?> 첨부파일<?= $i; ?> : <a href="http://sbe.center/public/down.php?file=<?= urlencode($file_data['name']); ?>&file_name=<?= urlencode($file_data['url']); ?>" target="_blank"><?= $file_data['name']; ?></a><br>
                        <?
                        }
                     ?>

                    </div>
                </div>
                <div class="four wide column cmt_style" style="position: relative; padding-bottom: 0px; padding-top: 0px">
                    <? if($_SESSION['idx'] == $article_data['user_idx']) { ?>
                    <div class="two ui buttons mini">
                        <div class="ui fade animated green button fluid edit" tabindex="0" onClick="edit_article('<?=$article_id; ?>', '<?= $board_id ?>', '<?= $board_type ?>');">
                            <div class="visible content"><?= $lang_modify ?></div>
                            <div class="hidden content">
                                <i class="wizard icon"></i>
                            </div>
                        </div>
                        <div class="ui fade animated red button fluid del" tabindex="0" onClick="del_article('<?=$article_id; ?>', '<?= $board_id ?>', '<?= $board_type ?>');">
                            <div class="visible content"><?= $lang_delete ?></div>
                            <div class="hidden content">
                                <i class="trash outline icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="ui divider basic"></div>
                    <? } ?>
                    <? if($board_id=="dankook_cur") { ?><p>동영상/글읽기 완료후에<br />버튼을 누르세요</p><? } ?>
                    <? if($board_id!=="etc_question") { ?>
                    <div class="two ui buttons">
                    	<? if($board_id=="dankook_cur") {
							$homework_query= mysql_query("SELECT * FROM  `homework` WHERE  `user_idx` =".$_SESSION['idx']." AND  `article_idx` =".$article_data['idx']." AND state = 1");
							if(mysql_num_rows($homework_query) > 0) {
						?>
                        <div class="ui green button fluid" tabindex="0">
                            <div class="visible content">숙제완료</div>

                        </div>
                        <?
							} else {
						?>
                        <div onClick="location.href='/public/do_homework.php?idx=<?=$article_data['idx']; ?>'" class="ui fade animated primary button basic fluid" tabindex="0">
                            <div class="visible content">숙제하기</div>
                            <div class="hidden content">
                                <i class="write icon"></i>
                            </div>
                        </div>
                        <?
							}
						?>


                        <? } ?>
                        <?
							// 내가 좋아요 했는지 여부 가지고 오기
							$my_like = mysql_query("SELECT *
										FROM  `like`
										WHERE  `user_idx` =".$_SESSION['idx']."
										AND  `article_idx` =$article_id");
							if(mysql_num_rows($my_like) >= 1) {
								$is_liked = true;
							} else {
								$is_liked = false;
							}

							// 전체 좋아요 개수 가지고 오기
							$all_like = mysql_query("SELECT *
													FROM  `like`
													WHERE  `article_idx` =$article_id");
							$like_count = mysql_num_rows($all_like);

						?>

                        <div onClick="location.href='/public/do_like.php?idx=<?=$article_id?>'" class="ui fade animated red button fluid <?=$is_liked?'':'basic'?>" tabindex="0">

                            <div class="visible content">좋아요 <?=$is_liked?"취소":""?> <strong><? echo $like_count; ?></strong></div>
                            <div class="hidden content">
                                <i class="heart icon"></i>
                            </div>

                        </div>


                    </div>
                    <!-- Comments -->
                    <? } ?>
                    <?
					 // COMMENT SERVER
					$comment_query = mysql_query("SELECT *
												FROM  `comment`
												WHERE  `article_idx` = $article_id AND ( `parent_idx` IS NULL OR `parent_idx` = 0)
												ORDER BY  `comment`.`idx` DESC");
					?>

                    <h3 class="ui dividing header">Comments</h3>
                    <div>
                    <form class="ui reply form" action="/public/do_add_comment.php" method="post" style="padding: 0 10px;">
                        <div class="field">
                            <textarea rows="3" name="content" style="height:100px;"></textarea>
                        </div>
                        <input type="hidden" name="article_id" value="<? echo $article_id; ?>">
												<input type="hidden" name="to_user_idx" value="<? echo $article_data['user_idx']; ?>">
                        <a href="#" onclick="$(this).closest('form').submit()">
                            <div class="ui blue submit icon button fluid">
                                	의견 남기기
                            </div>
                        </a>
                    </form>
                    </div>

                    <div class="ui comments scrollable" style="min-height:500px; height:auto">
					<?
                    while($comment_data = mysql_fetch_array($comment_query)) {
						$comment_user_query= mysql_query("SELECT * FROM  `user` WHERE  `idx` =".$comment_data['user_idx']);
						$comment_user_data = mysql_fetch_array($comment_user_query);

						/*$team_query = mysql_query("SELECT * FROM  `team` WHERE  `team_id` =  '".$comment_user_data['team_id']."'");
						$team_data = mysql_fetch_array($team_query);*/

                        //대댓글가져오기
                        $ccmt_query = mysql_query("SELECT *
                                            FROM  `comment`
                                            WHERE  `article_idx` = $article_id AND `parent_idx` = ".$comment_data['idx']."
                                            ORDER BY  `comment`.`idx` ASC ");
                        $ccmt_count = mysql_num_rows($ccmt_query);
					?>

                        <div class="comment">
                            <a class="avatar">
                                <img src="<?= get_profile_url($comment_user_data['idx']);  ?>">
                            </a>

                            <div class="content">
                                <a class="author"><? echo $comment_user_data['name']; ?></a>
                                <div class="metadata">
                                    <span class="team"><? echo $team_data['name']; ?></span><a class="ccmt_open">의견달기</a> <? if($_SESSION['idx'] == $comment_user_data['idx']) { ?> <a href="#" onClick="del_comment('<? echo $comment_data['idx']; ?>');">삭제</a> <a href="#" onClick="modify_comment('<?=$comment_data['idx']; ?>','', '<?=$comment_data['content']; ?>');">수정</a><? } ?>
                                </div>
                                <div class="text">
                                    <? echo $comment_data['content'];  ?>
                                </div>
                            </div>

                            <?

                            ?>
                            <? // 대댓글 출력 ?>
                            <div class="ui comments ccmt" style="height:auto;margin:0; <? if($ccmt_count < 1) { ?>display:none;<? } ?>" >
                                <? while($ccmt_data = mysql_fetch_array($ccmt_query)) {
                                    $comment_user_query= mysql_query("SELECT * FROM  `user` WHERE  `idx` =".$ccmt_data['user_idx']);
                                    $comment_user_data = mysql_fetch_array($comment_user_query);

                                    ?>
                                <div class="comment">
                                    <a class="avatar">
                                        <img src="<?= get_profile_url($comment_user_data['idx']);  ?>">
                                    </a>

                                    <div class="content">
                                        <a class="author"><? echo $comment_user_data['name']; ?></a>
                                        <div class="metadata">
                                              &nbsp;&nbsp;<? if($_SESSION['idx'] == $comment_user_data['idx']) { ?> <a href="#" onClick="del_comment('<? echo $ccmt_data['idx']; ?>');">삭제</a> <a href="#" onClick="modify_comment('<?=$ccmt_data['idx']; ?>','<?=$ccmt_data['parent_idx']; ?>', '<?=$ccmt_data['content']; ?>');">수정</a><? } ?>
                                        </div>
                                        <div class="text">
                                            <? echo $ccmt_data['content'];  ?>
                                        </div>
                                    </div>
                                </div>
                                <? } ?>
                            </div>
                            <form class="ui reply form ccmtreply" style="display:none;" action="/public/do_add_comment.php" method="post">
                                    <div class="field" style="padding:0;">
                                        <textarea rows="3" style="height:100px;" name="content"></textarea>
                                    </div>
                                    <input type="hidden" name="article_id" value="<? echo $article_id; ?>">
                                    <input type="hidden" name="comment_id" value="<? echo $comment_data['idx']; ?>">
																		<input type="hidden" name="to_user_idx" value="<? echo $comment_user_data['idx']; ?>">
                                    <a href="#" onclick="$(this).closest('form').submit()">
                                        <div class="ui blue mini submit button fluid">
                                           	 의견 남기기
                                        </div>
                                    </a>
                             </form>


					<?


                        }

                    ?>
 					</div>
                    <!-- Comments End -->

                </div>
            </div>
        </div>
    </div>
</section>
<script>
//댓글 삭제 스크립트
function del_comment(idx) {
	var con = confirm('정말로 댓글 삭제를 원하십니까?');
	if(con == 1) {

		location.replace ( "/public/do_del_comment.php?idx=" + idx);
	}
}

function del_article(idx, board_id, board_type='') {
	var con = confirm('정말로 게시물 삭제를 원하십니까?');
	if(con == 1) {
		var location_url = "/public/do_del_article.php?article_id=" + idx + "&board_id=" + board_id;
		if(board_type != '') location_url += "&board_type=" + board_type;

		location.replace (location_url);
	}
}

function edit_article(idx, board_id, board_type='') {
	var location_url = "/public/board_write?article_id=" + idx + "&board_id=" + board_id;
	if(board_type != '') location_url += "&board_type=" + board_type;

	location.replace (location_url);
}
</script>


<? if($board_id=="dankook_cur") { ?>
<script>

$(document).ready(function(){

	$.ajax ({
            "url" : "/public/do_running_homework.php?id=<?=$article_id; ?>",  // ----- (1)
            cache : false,
            success : function (html) { // ----- (2)
                console.log(html);
            }
        });

    timer = setInterval( function () {

        $.ajax ({
            "url" : "/public/do_running_homework.php?id=<?=$article_id; ?>",  // ----- (1)
            cache : false,
            success : function (html) { // ----- (2)
                console.log(html);
            }
        });

    }, 10000);
});
</script>

<?

//////////////////// 과제확인
$progress_query = mysql_query("SELECT *
								FROM  `homework_progress`
								WHERE  `user_idx` =".$_SESSION['idx']."
								AND  `article_idx` =$article_id");

if(mysql_num_rows($progress_query) >= 1) {
	$progress_data = mysql_fetch_array($progress_query);
	$rq = mysql_query("UPDATE  `startup`.`homework_progress` SET  `last_request_time` =  '2000-01-01 00:00:00' WHERE  `homework_progress`.`idx` =".$progress_data['idx']);
} else {
	$rq = mysql_query("INSERT INTO `homework_progress` (
					`idx` ,
					`user_idx` ,
					`article_idx` ,
					`complete_sec` ,
					`last_request_time`
					)
					VALUES (
					NULL ,  '".$_SESSION['idx']."',  '$article_id',  '0', '2000-01-01 00:00:00'
					);
					");

}







} ?>
<script>

$(document).ready(function(){
    $( ".ccmt_open" ).click(function() {
        var index = $(".ccmt_open").index(this);
        if($(".ccmtreply").eq(index).is(":visible")){
        	$(".ccmtreply").eq(index).css("display","none");
        }else{
            $(".ccmtreply").eq(index).css("display","block");
        }
    });

});

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
                alert("댓글을 성공적으로 변경하였습니다.");
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
      댓글 수정
    </div>
    <div class="content">
      <div class="ui form" style="margin:0; ">
          <textarea name="comment" id="edit_area"></textarea>
      </div>
    </div>
    <div class="actions">
      <div class="ui green button" onClick="comment_action()"><?= $lang_modify ?></div>
    </div>
  </div>
