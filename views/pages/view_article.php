<?
require_once(VIEW.'common/_language.php');

///////////// SERVER
$board_id = $_GET['board_id'];
$article_id = $_GET['article_id'];
$company_id = $_SESSION['company'];

$cur_board_id = $_SESSION['company'] + "cur";

if($_GET['board_id'] == "landing_question")
    $company_search = "";
else
    $company_search = "AND  `company_id` =  '{$company_id}'";


if($_GET['board_type']){
	$board_type = "team";
	$type_team = "&board_type=team";
}

$article_query = mysql_query("SELECT *
FROM  `article`
WHERE  `idx` =$article_id
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

if($_SESSION['lang'] == 'en'){
	$lang_subject = "Subject";
	$lang_contents = "Contents";
	$lang_youtube = "Youtube";
	$lang_files = "Add files";
	$lang_total = "Total Max.";
  $lang_like = "Like";
  $lang_comments = "Comments";

  $lang_notice1 = "Please click the complete button ";
  $lang_notice2 = "after watching videos or contents";

  $lang_mod_comment = "Modify comments";
  $lang_success_cmt = "Your comment has been successfully changed.";

  $lang_del_cmt = "Do you really want to delete the comment?";
  $lang_del_article = "Do you really want to delete posts?";
}else{
	$lang_subject = "제목";
	$lang_contents = "내용";
	$lang_youtube = "유투브";
	$lang_files = "첨부파일";
	$lang_total = "합산 최대";
  $lang_like = "좋아요";
  $lang_comments = "의견 남기기";

  $lang_notice1 = "동영상/글읽기 완료후에";
  $lang_notice2 = "버튼을 누르세요";

  $lang_mod_comment = "댓글 수정";
  $lang_success_cmt = "댓글을 성공적으로 변경하였습니다.";

  $lang_del_cmt = "정말로 댓글 삭제를 원하십니까?";
  $lang_del_article = "정말로 게시물 삭제를 원하십니까?";
}
?>


<section>
    <!-- contents start -->
    <div class="ui segment padding--0 selene-basic noline" style="min-height:500px;">
      <div class="ui internally celled grid">
            <div class="row">
					<? if($isYoutube){ ?>
                <div class="nine wide column" style="padding: 0 10px 0 0; margin:0px;">
                  <div class="ui embed" data-source="youtube" data-id="<?=$article_data['youtube_link']?>"></div>
                </div>
                <div class="seven wide column line" style="box-shadow: none;">
          <? }else{ ?>
                <div class="sixteen wide column line">
          <? } ?>
                    <h2 class="ui header apost"><?=$article_data['title']?></h2>

                    <p><?=$article_data['content']?></p>
                    <div>
                    <?
                        $file = mysql_query("SELECT *
                                            FROM  `attach`
                                            WHERE  `article_idx` =$article_id");
                        $i =0;
                        while($file_data = mysql_fetch_array($file)) {
                            $i++;
                            ?> <?= $lang_files ?><?= $i; ?> : <a href="http://sbe.center/public/down.php?file=<?= urlencode($file_data['name']); ?>&file_name=<?= urlencode($file_data['url']); ?>" target="_blank"><?= $file_data['name']; ?></a><br>
                        <?
                        }
                     ?>

                    </div>
                </div>
        </div>
    </div>
    <!-- contents end -->

    <div class="ui clearing segment">
      <p class="ui left floated header"><?= $lang_notice1 ?><?= $lang_notice2 ?></p>
      <? if($board_id !== "etc_question") { ?>
      <div class="ui two right floated buttons" style="width:30%;">
        <? if($board_id == "{$company_id}_cur") {

          $homework_query= mysql_query("SELECT * FROM  `homework` WHERE  `user_idx` =".$_SESSION['idx']." AND  `article_idx` =".$article_data['idx']." AND state = 1");
          // homwork complete
          if(mysql_num_rows($homework_query) > 0) {
          ?>
                    <div class="ui green button fluid" tabindex="0">
                        <div class="visible content"><?= $lang_complete1 ?></div>

                    </div>
                    <?
          // homework incomplete
          } else { ?>
          <div onClick="location.href='/public/do_homework.php?idx=<?=$article_data['idx']; ?>'" class="ui fade animated primary button basic fluid" tabindex="0">
              <div class="visible content"><?= $lang_incomplete1 ?></div>
              <div class="hidden content">
                  <i class="write icon"></i>
              </div>
          </div>
          <? } ?>
          <? } // curriculum board end ?>
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
              <div class="visible content"><?= $lang_like ?> <?=$is_liked?"{$lang_cancel}":""?> <strong><? echo $like_count; ?></strong></div>
              <div class="hidden content">
                  <i class="heart icon"></i>
              </div>
          </div>
      </div>
      <? } ?>
    </div>

    <?
    // COMMENT SERVER
    $comment_query = mysql_query("SELECT *
            FROM  `comment`
            WHERE  `article_idx` = $article_id AND ( `parent_idx` IS NULL OR `parent_idx` = 0)
            ORDER BY  `comment`.`idx` DESC");
    ?>
    <!-- comments start -->
    <div class="ui comments">
      <h3 class="ui dividing header">Comments</h3>

      <form class="ui reply form" action="/public/do_add_comment.php" method="post">
        <input type="hidden" name="article_id" value="<? echo $article_id; ?>">
        <input type="hidden" name="to_user_idx" value="<? echo $article_data['user_idx']; ?>">

        <div class="ui action input" style="width:100%;">
          <textarea rows="3" name="content"></textarea>
          <button class="ui button" onclick="$(this).closest('form').submit()"><?= $lang_comments ?></button>
        </div>
      </form>

      <?
      while($comment_data = mysql_fetch_array($comment_query)) {
        $comment_user_query= mysql_query("SELECT * FROM  `user` WHERE  `idx` =".$comment_data['user_idx']);
        $comment_user_data = mysql_fetch_array($comment_user_query);
        $comment_idx = $comment_data['idx'];

          //대댓글가져오기
          $ccmt_query = mysql_query("SELECT * FROM  `comment`
                                    WHERE  `article_idx` = '{$article_id}' AND `parent_idx` = '{$comment_idx}'
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
              <span class="team"><? echo $team_data['name']; ?></span><a class="ccmt_open"><?= $lang_submit ?></a>
              <? if($_SESSION['idx'] == $comment_user_data['idx']) { ?>
                <a href="#" onClick="del_comment('<?= $comment_idx ?>');"><?= $lang_delete ?></a>
                <a href="#" onClick="modify_comment('<?= $comment_idx ?>','', '<?=$comment_data['content']; ?>');"><?= $lang_modify ?></a>
              <? } ?>
          </div>
          <div class="text">
              <? echo $comment_data['content'];  ?>
          </div>
        </div>
      </div>
      <? // 대댓글 출력 ?>
      <div class="ui comments ccmt" style="<? if($ccmt_count < 1) { ?>display:none;<? } ?>" >
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
                        &nbsp;&nbsp;
                        <? if($_SESSION['idx'] == $comment_user_data['idx']) { ?>
                          <a href="#" onClick="del_comment('<? echo $ccmt_data['idx']; ?>');"><?= $lang_delete ?></a>
                          <a href="#" onClick="modify_comment('<?=$ccmt_data['idx']; ?>','<?=$ccmt_data['parent_idx']; ?>', '<?=$ccmt_data['content']; ?>');"><?= $lang_modify ?></a>
                        <? } ?>
                  </div>
                  <div class="text">
                      <? echo $ccmt_data['content'];  ?>
                  </div>
              </div>
          </div>
          <? } ?>
        </div>

        <form class="ui reply form ccmtreply" style="display:none;" action="/public/do_add_comment.php" method="post">
          <input type="hidden" name="article_id" value="<? echo $article_id; ?>">
          <input type="hidden" name="comment_id" value="<? echo $comment_data['idx']; ?>">
          <input type="hidden" name="to_user_idx" value="<? echo $comment_user_data['idx']; ?>">
          <div class="ui action input" style="width:100%;">
            <textarea rows="3" name="content"></textarea>
            <button class="ui button" onclick="$(this).closest('form').submit()"><?= $lang_comments ?></button>
          </div>
         </form>
      <? } ?>
    </div>
    <!-- comments end -->

</section>
<script>
//댓글 삭제 스크립트
function del_comment(idx) {
	var con = confirm('<?= $lang_del_cmt ?>');
	if(con == 1) {

		location.replace ( "/public/do_del_comment.php?idx=" + idx);
	}
}

function del_article(idx, board_id, board_type='') {
	var con = confirm('<?= $lang_del_article ?>');
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


<? if($board_id==$cur_board_id) { ?>
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
                alert("<?= $lang_success_cmt ?>");
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
      <?= $lang_mod_comment ?>
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
