<?php
$cquery = mysql_query("SELECT *
						FROM `company`
						ORDER BY `idx`");
$current_step = 'manage_user_tools';
?>
<div class="ui container">
	<div class="clearfix">
	    <h2 class="ui header" style="margin-bottom: 0; margin-top: 5px;">프로그램 관리</h2>
	    <a href="/public/create_company" class="ui right floated blue button">새 프로그램 등록</a>
	</div>

    <form class="ui clearing segment selene-basic">
        <div class="ui icon input">
            <input type="text" name="q" placeholder="프로그램 찾기" value="<?=$q?>">
            <i class="search link icon"></i>
        </div>
        <button class="ui button">검색</button>
    </form>

    <table class="ui celled compact striped table">
    <colgroup>
    	<col width="*" />
    	<col width="15%" />
    	<col width="33%" />
    	<col width="15%" />
    </colgroup>
        <thead>
            <tr>
                <th>프로그램</th>
                <th>참가자 수</th>
                <th>관리자</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <? while ($cdata = mysql_fetch_array($cquery)) {
            		$entry = mysql_num_rows(mysql_query("SELECT `idx` 
            											FROM `user` 
            											WHERE `company_id` = '{$cdata['company_id']}'"));
            		$admin = mysql_fetch_array(mysql_query("SELECT `idx`, `name`, `email`
            												FROM `user`
            												WHERE `company_id = '{$cdata['company_id']}' and `level` = '6'"));
            ?>
            <tr>
                <td><?=$cdata['name']?></td>
                <td><?=$entry?> 명</td>
                <td>
                <?
                	if(!$admin){
                		echo "지정된 관리자가 없습니다.";
                	}else{
                		echo "{$admin['name']} ({$admin['email']})";
                	}
                ?>
                </td>
				<td class="text-align--center">
					<button class="mini ui button blue" value="<?=$cdata['idx']?>" onClick="company_edit(this)">수정</button>
					<button class="mini ui button red" value="<?=$cdata['idx']?>" onClick="check(this)">삭제</button>
				</td>
            </tr>
            <? } ?>
        </tbody>
    </table>
</div>

<script>
// 프로그램 삭제 버튼
function check(e){

	if(confirm("정말 이 프로그램을 삭제하시겠습니까?")){

		var value = $(e).val();
		var url = './do_del_company.php'
		var form = $('<form action="' + url + '" method="post">' +
		  '<input type="hidden" name="company_idx" value="' + value + '" />' +
		  '</form>');
		$('body').append(form);
		form.submit();

	}
}

// 프로그램 수정 버튼
function company_edit(e){
	var value = $(e).val();
	var url = './edit_company'
	var form = $('<form action="' + url + '" method="post">' +
	  '<input type="hidden" name="company_idx" value="' + value + '" />' +
	  '</form>');
	$('body').append(form);
	form.submit();
}

</script>