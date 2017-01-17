<<<<<<< Updated upstream
<?php
$q = $_GET['q'];
$company_id = $_SESSION['company'];

if ($q)
    $search_query = "AND (`user`.`name` like '%".mysql_escape_string($q)."%' OR `user`.`email` like '%".mysql_escape_string($q)."%')";
else
    $search_query = "";

// print_column 가공
$qs = mysql_query("SELECT `cs`.`idx` as `step_idx`,
                          `cs`.`step_seq`,
                          `article`.`idx` as `article_idx`
                   FROM `curriculum_step` as `cs`
                   LEFT JOIN `article`
                   ON `article`.`step_id` = `cs`.`step_seq`
                   ORDER BY `cs`.`step_seq`, `article`.`idx` ASC");
$print_column = array();
$step_count = 0;
while ($row = mysql_fetch_array($qs)) {
    $print_column[$row['step_seq']][] = $row['article_idx'];
    $step_count++;
}

$qs = mysql_query("SELECT `user`.`idx` as `user_idx`,
                          `user`.`name`,
                          `article`.`idx` as `article_idx`,
                          `article`.`title`, ifnull(`homework`.`state`, 0) as is_complete
                   FROM `user`
                   LEFT JOIN `article`
                   ON `article`.`board_id` = '{$company_id}_cur'
                   LEFT JOIN `homework`
                   ON `homework`.`article_idx` = `article`.`idx`
                   AND `homework`.`user_idx` = `user`.`idx`
                   LEFT JOIN `curriculum_step` as `cs`
                   ON `cs`.`step_seq` = `article`.`step_id`
                   WHERE `user`.`company_id` = '$company_id'
                   $search_query
                   GROUP BY `user`.`idx`, `article`.`idx`
                   ORDER BY `user`.`idx`, `cs`.`step_seq`, `article`.`idx` ASC");
$print_users  = array();
$print_users_name  = array();
$print_users_title  = array();
while ($row = mysql_fetch_array($qs)) {
    $print_users[$row['user_idx']][] = $row['is_complete'];
    $print_users_name[$row['user_idx']] = $row['name'];
    $print_users_title[] = $row['title'];
}

$current_step = 'manage_join_user';
?>
<h2 class="ui header">참가자 과제확인</h2>
<form class="ui clearing segment selene-basic">
    <div class="ui icon input">
        <input type="text" name="q" placeholder="이름 / 이메일로 찾기" value="<?=$q?>">
        <i class="search link icon"></i>
    </div>
    <button class="ui button"><?= $lang_search ?></button>
</form>

<div style="overflow: auto; width: 100%;">
  <table class="ui celled compact striped table">
      <thead>
          <tr>
              <th>스텝</th>
              <? foreach ($print_column as $key => $value) { ?>
              <th colspan="<?=count($value)?>"><?=$key?></th>
              <? } ?>
          </tr>
          <tr>
              <th>과제</th>
              <?  $i = 0;
              foreach ($print_column as $key => $value) { ?>
                <? foreach ($value as $key2 => $item) {
                if ($step_count-1 == $i)
                  break; ?>
              <th data-content="<?=xssHtmlProtect($print_users_title[$i])?>" data-variation="mini" data-variation="inverted"><i class="check circle icon"></i></th>
                <? $i++; } ?>
              <? } ?>
          </tr>
      </thead>
      <tbody>
          <? foreach ($print_users as $key => $value) { ?>
          <tr>
              <td><?=$print_users_name[$key]?></td>
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
=======
<?php
$q = $_GET['q'];
$company_id = $_SESSION['company'];

if ($q)
    $search_query = "AND (`user`.`name` like '%".mysql_escape_string($q)."%' OR `user`.`email` like '%".mysql_escape_string($q)."%')";
else
    $search_query = "";

// print_column 가공
$qs = mysql_query("SELECT `cs`.`idx` as `step_idx`,
                          `cs`.`step_seq`,
                          `article`.`idx` as `article_idx`
                   FROM `curriculum_step` as `cs`
                   LEFT JOIN `article`
                   ON `article`.`step_id` = `cs`.`step_seq`
                   ORDER BY `cs`.`step_seq`, `article`.`idx` ASC");
$print_column = array();
$step_count = 0;
while ($row = mysql_fetch_array($qs)) {
    $print_column[$row['step_seq']][] = $row['article_idx'];
    $step_count++;
}

$qs = mysql_query("SELECT `user`.`idx` as `user_idx`,
                          `user`.`name`,
                          `article`.`idx` as `article_idx`,
                          `article`.`title`, ifnull(`homework`.`state`, 0) as is_complete
                   FROM `user`
                   LEFT JOIN `article`
                   ON `article`.`board_id` = '{$company_id}_cur'
                   LEFT JOIN `homework`
                   ON `homework`.`article_idx` = `article`.`idx`
                   AND `homework`.`user_idx` = `user`.`idx`
                   LEFT JOIN `curriculum_step` as `cs`
                   ON `cs`.`step_seq` = `article`.`step_id`
                   WHERE `user`.`company_id` = '$company_id'
                   $search_query
                   GROUP BY `user`.`idx`, `article`.`idx`
                   ORDER BY `user`.`idx`, `cs`.`step_seq`, `article`.`idx` ASC");
$print_users  = array();
$print_users_name  = array();
$print_users_title  = array();
while ($row = mysql_fetch_array($qs)) {
    $print_users[$row['user_idx']][] = $row['is_complete'];
    $print_users_name[$row['user_idx']] = $row['name'];
    $print_users_title[] = $row['title'];
}

$current_step = 'manage_join_user';
?>
<h2 class="ui header">참가자 과제확인</h2>
<form class="ui clearing segment selene-basic">
    <div class="ui icon input">
        <input type="text" name="q" placeholder="이름 / 이메일로 찾기" value="<?=$q?>">
        <i class="search link icon"></i>
    </div>
    <button class="ui button">검색</button>
</form>

<div style="overflow: auto; width: 100%;">
  <table class="ui celled compact striped table">
      <thead>
          <tr>
              <th>스텝</th>
              <? foreach ($print_column as $key => $value) { ?>
              <th colspan="<?=count($value)?>"><?=$key?></th>
              <? } ?>
          </tr>
          <tr>
              <th>과제</th>
              <?  $i = 0;
              foreach ($print_column as $key => $value) { ?>
                <? foreach ($value as $key2 => $item) {
                if ($step_count-1 == $i)
                  break; ?>
              <th data-content="<?=xssHtmlProtect($print_users_title[$i])?>" data-variation="mini" data-variation="inverted"><i class="check circle icon"></i></th>
                <? $i++; } ?>
              <? } ?>
          </tr>
      </thead>
      <tbody>
          <? foreach ($print_users as $key => $value) { ?>
          <tr>
              <td><?=$print_users_name[$key]?></td>
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
>>>>>>> Stashed changes
