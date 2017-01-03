<h2 class="ui header">프로그램 추가</h2>
<div class="ui divider"></div>
<form class="ui form" action = "./do_add_company.php" method = "post">
    <div class="required field">
        <label>프로그램 이름</label>
        <input type="text" name="name" placeholder="이름">
    </div>
    <div class="required field">
        <label>프로그램 아이디</label>
        <input type="text" name="company_id" placeholder="아이디">
    </div>
    <div class="field">
        <label>커리큘럼 복사</label>
          <select name="curriculum" class="ui fluid dropdown" required>
            <option value="0">복사 안 함</option>
          <?
            $cquery = mysql_query("SELECT * FROM `company`");
            while($cdata = mysql_fetch_array($cquery)){
              $cur_query = mysql_query("SELECT `idx` FROM `curriculum_step` WHERE `company_id`='".$cdata['company_id']."'");
              $cur_num = mysql_fetch_array($cur_query);
              if($cur_num > 0){
          ?>
            <option value="<?= $cdata['company_id'] ?>"><?= $cdata['name'] ?></option>
            <? } ?>
          <? } ?>
          </select>
    </div>
    <button class="ui button primary" type="submit" id = "save">저장</button>
</form>
