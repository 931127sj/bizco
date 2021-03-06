<?php
$q = $_GET['q'];
$company_id = $_SESSION['company'];
$board_id = $company_id ."_cur";

if ($q)
    $search_query = "AND (`user`.`name` like '%".mysql_escape_string($q)."%' OR `user`.`email` like '%".mysql_escape_string($q)."%')";
else
    $search_query = "";


$qs = mysql_query("SELECT `user`.`idx` as `user_idx`,
                          `user`.`name`,
                          `user_step_relation`.`current_step_idx` ,
                          ifnull(`homework`.`state`, 0) as is_complete
                   FROM `user`
                   LEFT JOIN `user_step_relation`
                   ON `user_step_relation`.`user_idx` = `user`.`idx`
                   LEFT JOIN `article`
                   ON `article`.`board_id` = '$board_id'
                   AND `article`.`step_id` = `user_step_relation`.`current_step_idx`
                   LEFT JOIN `homework`
                   ON `homework`.`article_idx` = `article`.`idx`
                   AND `homework`.`user_idx` = `user`.`idx`
                   LEFT JOIN `curriculum_step` as `cs`
                   ON `cs`.`idx` = `article`.`step_id`
                   WHERE `user`.`company_id` = '$company_id'
                   $search_query
                   GROUP BY `user`.`idx`, `article`.`idx` , `user_step_relation`.`user_idx`
                   ORDER BY `user`.`idx`, `cs`.`step_seq`, `article`.`idx` ASC, `user_step_relation`.`user_idx`");
$print_users  = array();
$print_users_name  = array();
$print_users_title  = array();
while ($row = mysql_fetch_array($qs)) {
    $print_users[$row['user_idx']][] = $row['is_complete'];
    $print_users_name[$row['user_idx']] = $row['name'];
    $print_users_title[$row['user_idx']] = $row['current_step_idx'];
}

$current_step = 'manage_join_user';

if($_SESSION['lang'] == "en"){
  $lang_title = "Assignment Check";
  $lang_searching = "Searching with name/e-mail address";
  $lang_name = "Name";
  $lang_step = "Step";
  $lang_assignment = "Assignment";
}else{
  $lang_title = "참가자 과제확인";
  $lang_searching = "이름 / 이메일로 찾기";
  $lang_name = "이름";
  $lang_step = "현재 스텝";
  $lang_assignment = "진행 상황";
}
?>
<h2 class="ui header"><?= $lang_title ?></h2>
<form class="ui clearing segment selene-basic">
    <div class="ui icon input">
        <input type="text" name="q" placeholder="<?= $lang_searching ?>" value="<?=$q?>">
        <i class="search link icon"></i>
    </div>
    <button class="ui button"><?= $lang_search ?></button>
</form>

<div style="overflow: auto; width: 100%;">
  <table class="ui celled compact striped table">
      <thead>
          <tr>
              <th><?= $lang_name ?></th>
              <th><?= $lang_step ?></th>
              <th colspan = "13"><?= $lang_assignment ?></th>
              <!--
              <? foreach ($print_column as $key => $value) { ?>
              <th colspan="<?=count($value)?>"><?=$key?></th>
              <? } ?>
                -->
          </tr>
      </thead>

      <tbody>
          <? foreach ($print_users as $key => $value) { ?>
          <tr>
              <td>
                  <?=$print_users_name[$key]?>
              </td>
              <td>
                  <?=$print_users_title[$key]?>
              </td>
              <? foreach ($value as $key2 => $item) { ?>
              <td>
                <?=$item?'<span style="color: green; font-weight: bold;">O</span>':'<span style="color: red; font-weight: bold;">X</span>'?>

              </td>
              <? } ?>
          </tr>
          <? } ?>
      </tbody>
  </table>
</div>
