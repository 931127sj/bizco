<!-- Datas from PHP -->
<?php
  require_once '_common.php';
  require_once(VIEW.'common/_language.php');

  $company_id = $_SESSION['company'];

  if($_SESSION['lang'] == "en"){
    $lang_title = "Manage Step/Assignment";
    $lang_add_steps = "Add steps";
    $lang_manage = "Manage step access condition";
    $lang_step = "Step";
    $lang_subject = "Subject";
    $lang_comments = "Comments";
    $lang_like = "Like";
    $lang_view = "View";
    $lang_add_contents = "Add contents";

    $lang_please = "Please add an assignment.";
    $lang_del_step = "Are you sure you want to delete this step?";
    $lang_del_post = "Do you really want to delete posts?";
  }else{
    $lang_title = "스텝/과제 관리";
    $lang_add_steps = "스텝 추가";
    $lang_manage = "스텝 진입조건 관리";
    $lang_step = "스텝";
    $lang_subject = "제목";
    $lang_comments = "댓글";
    $lang_like = "좋아요";
    $lang_view = "조회수";
    $lang_add_contents = "과제 추가";

    $lang_please = "과제를 추가해주세요.";
    $lang_del_step = "정말 이 스텝을 삭제하시겠습니까?";
    $lang_del_post = "정말로 게시물 삭제를 원하십니까?";
  }
?>
<div class="clearfix">
    <h2 class="ui header floated right" style="margin-bottom: 0; margin-top: 5px;"><?= $lang_title ?></h2>
    <button class="ui button primary float--right" onClick="step_add()"><?= $lang_add_steps ?></button>
    <button class="ui button disabled float--right"><?= $lang_manage ?></button>
</div>
<table class="ui table compact">
    <thead>
        <tr>
            <th><?= $lang_step ?></th>
            <th><?= $lang_subject ?></th>
            <th></th>
            <th><?= $lang_comments ?></th>
            <th><?= $lang_like ?></th>
            <th><?= $lang_view ?></th>
            <th>Quiz</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
<?
    $query = mysql_query("SELECT * from `curriculum_step` where `company_id` = '$company_id' order by step_seq asc ");

    while($row = mysql_fetch_array($query)){

      $start = str_replace("-","/", $row['start_date']);
      $end = str_replace("-","/", $row['end_date']);

              $cur_query = mysql_query("SELECT * from article where step_id = '".$row['step_seq']."' and board_id = '{$company_id}_cur' ORDER BY `priority` ASC");
              $cur_num = mysql_num_rows($cur_query);
?>
			<tr>
				<td rowspan="<?=$cur_num+2?>"><?=$row['step_seq']?></td>
				<td><b><?=xssHtmlProtect($row['step_name'])?></b> <? if ( ! $cur_num) { ?><a><i class="ui icon angle double left"></i><?= $lang_please ?></a><? } ?></td>
				<td style="text-align: right;"><div class="ui label yellow"><i class="calendar outline icon"></i> <?=$start."~".$end?></div></td>
				<td colspan="4"></td>
				<td class="text-align--center">
					<button class="mini ui button blue" value="<?=$row['idx']?>" onClick="step_edit(this)"><?= $lang_modify ?></button>
					<button class="mini ui button red" value="<?=$row['idx']?>" onClick="check(this)"><?= $lang_delete ?></button>
				</td>
			</tr>
            <?
            while($cur_row = mysql_fetch_array($cur_query)){
                ?>
                <tr>
                    <td><a><?=xssHtmlProtect($cur_row['title'])?></a></td>
                    <td colspan="5"></td>
                    <td class="text-align--center">
                        <button class="mini ui basic button blue" value="<?=$cur_row['idx']?>" onClick="edit_article(<?=$cur_row['idx']?>)"><?= $lang_modify ?></button>
                        <button class="mini ui basic button red" value="<?=$cur_row['idx']?>" onClick="del_article(<?=$cur_row['idx']?>)"><?= $lang_delete ?></button>

                        <div class="ui mini icon basic buttons">
                            <button class="ui button" onClick="location.replace('/public/do_modify_priority.php?type=0&id=<?=$cur_row['idx'] ?>')">
                                <i class="arrow up icon"></i>
                            </button>
                            <button class="ui button" onClick="location.replace('/public/do_modify_priority.php?type=1&id=<?=$cur_row['idx'] ?>')">
                                <i class="arrow down icon"></i>
                            </button>
                        </div>

                    </td>
                </tr>
                <?
            }
            ?>
			<tr>
				<td colspan="7"><button class="ui button positive" value="<?=$row['idx']?>" onClick="cur_add(this)">과제추가</button></td>
			</tr>
			<?
			}

		?>
		<!-- Datas from PHP End -->
    </tbody>
</table>
<script>
// 스텝 삭제 버튼
function check(e){

	if(confirm("<?= $lang_del_step ?>")){

		var value = $(e).val();
		var url = './do_delete_step.php'
		var form = $('<form action="' + url + '" method="post">' +
		  '<input type="hidden" name="step_idx" value="' + value + '" />' +
		  '</form>');
		$('body').append(form);
		form.submit();

	}
}
// 스텝 추가 버튼
function step_add(){
	document.location.href = './create_step';
}
// 스텝 수정 버튼
function step_edit(e){
	var value = $(e).val();
	var url = './edit_step'
	var form = $('<form action="' + url + '" method="post">' +
	  '<input type="hidden" name="id" value="' + value + '" />' +
	  '</form>');
	$('body').append(form);
	form.submit();
}
// 과제 추가 버튼
function cur_add(e){
    var value = $(e).val();
    document.location.href = './board_write?board_id=<?= $company_id ?>_cur&redirect=manage_step&step_id='+value;
}
function del_article(idx) {
	var con = confirm('<?= $lang_del_post ?>');
	if(con == 1) {

		location.href =  "/public/do_del_article.php?article_id=" + idx;
	}
}
function edit_article(idx) {

	location.href =  "/public/board_write?redirect=manage_step&article_id=" + idx;

}

// 스텝 삭제 버튼
function check(e){

	if(confirm("<?= $lang_del_step ?>")){

		var value = $(e).val();
		var url = './do_delete_step.php'
		var form = $('<form action="' + url + '" method="post">' +
		  '<input type="hidden" name="step_idx" value="' + value + '" />' +
		  '</form>');
		$('body').append(form);
		form.submit();

	}
}
// 스텝 추가 버튼
function step_add(){
	document.location.href = './create_step';
}
// 스텝 수정 버튼
function step_edit(e){
	var value = $(e).val();
	var url = './edit_step'
	var form = $('<form action="' + url + '" method="post">' +
	  '<input type="hidden" name="id" value="' + value + '" />' +
	  '</form>');
	$('body').append(form);
	form.submit();
}
// 과제 추가 버튼
function cur_add(e){
    var value = $(e).val();
    document.location.href = './board_write?board_id=<?= $company_id ?>_cur&redirect=manage_step&step_id='+value;
}
function del_article(idx) {
	var con = confirm('<?= $lang_del_post ?>');
	if(con == 1) {

		location.href =  "/public/do_del_article.php?article_id=" + idx;
	}
}
function edit_article(idx) {

	location.href =  "/public/board_write?redirect=manage_step&article_id=" + idx;

}
</script>
