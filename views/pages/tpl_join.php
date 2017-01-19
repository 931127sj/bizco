<?
require_once(VIEW.'common/_language.php');

if($_SESSION['lang'] == "en"){
  $lang_email = "E-mail address";
  $lang_name = "Name";
  $lang_pw = "Password";
  $lang_repw = "Retype password";
  $lang_phone = "Phone";
  $lang_course = "Course";
  $lang_team = "Team name";
  $lang_motivation = "Participation Motivation";
  $lang_position = "Position";
  $lang_career = "Startup career";
  $lang_abilities = "Abilities";
  $lang_stage = "Stage";
  $lang_idea = "Idea stage";
  $lang_proto = "Prototype stage";
  $lang_launching = "Launching stage";
  $lang_investment = "Investment stage";
  $lang_resource = "Resources which you need to startup";
  $lang_sing_up = "Sign up";
}else{
  $lang_email = "이메일";
  $lang_name = "이름";
  $lang_pw = "암호";
  $lang_repw = "암호 재입력";
  $lang_phone = "연락처";
  $lang_course = "참여";
  $lang_team = "팀 이름";
  $lang_motivation = "참여 동기";
  $lang_position = "참여 파트";
  $lang_career = "창업이력";
  $lang_abilities = "보유역량";
  $lang_stage = "진행사항";
  $lang_idea = "아이디어 단계";
  $lang_proto = "시제품 제작 단계";
  $lang_launching = "제품 런칭 단계";
  $lang_investment = "투자 단계";
  $lang_resource = "사업에 필요한 자원";
  $lang_sing_up = "가입";
}
?>

<style type="text/css">
body {
background:url(../../assets/css/bg_login.jpg) center center fixed no-repeat;
}
body > .grid {
height: 100%;
}
nav.ui.top.fixed.secondary.menu {
display:none;
}
.image {
margin-top: -100px;
}
.column {
max-width: 450px;
margin-top: 220px;
}
.ui.form .field>label {
color: #fff;
text-align: left;
padding:0.4rem;
}
#formDiv .field input, #formDiv .field textarea, #formDiv .field .dropdown {
background: rgba(255,255,255,0.1);
color:#fff;
padding:0.8rem;
-webkit-border-radius: 1.2rem;-moz-border-radius: 1.2rem;-ms-border-radius: 1.2rem;border-radius: 1.2rem;
}
#formDiv .field i {
color:#fff;
}
.ui.deep-blue.button {
-webkit-border-radius: 2rem;-moz-border-radius: 2rem;-ms-border-radius: 2rem;border-radius: 2rem;
margin-top:1rem;
margin-bottom:100px;
}
</style>

<nav class="ui top fixed secondary menu">
    <div class="header item">
        <div class="ui text container logo">
            Startup on the base of<br>Entrepreneurship
        </div>
    </div>
</nav>

<div class="ui middle aligned center aligned grid" style="min-height: 1150px;">
    <div class="column">
        <form class="ui large form"  action="/public/do_join.php" method="post">
            <div class="ui basic segment" id="formDiv">
                <div class="required field">
                    <label><?= $lang_email ?></label>
                    <div class="ui left icon input">
                        <i class="at icon"></i>
                        <input type="text" name="email" placeholder="<?= $lang_email ?>" required>
                    </div>
                </div>
                <div class="required field">
                    <label><?= $lang_name ?></label>
                    <div class="ui left icon input">
                        <i class="tag icon"></i>
                        <input type="text" name="name" placeholder="<?= $lang_name ?>" required>
                    </div>
                </div>
                <div class="required field">
                    <label><?= $lang_pw ?></label>
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" placeholder="<?= $lang_pw ?>" required>
                    </div>
                </div>
                <div class="required field">
                    <label><?= $lang_repw ?></label>
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password_retype" placeholder="<?= $lang_repw ?>" required>
                    </div>
                </div>
                <div class="required field">
                    <label><?= $lang_phone ?></label>
                    <div class="ui left input">
                        <input type="text" name="phone" placeholder="<?= $lang_phone ?>" required>
                    </div>
                </div>
                <div class="required field">
                    <label><?= $lang_course ?></label>
                    <div class="ui left icon input">
                        <select name="company" class="ui fluid dropdown" required>
                        <?
                        	$cquery = mysql_query("SELECT * FROM `company`");
                        	while($cdata = mysql_fetch_array($cquery)){
                        		if($cdata['company_id'] != 'default'){
                        ?>
                        	<option value="<?= $cdata['company_id'] ?>"><?= $cdata['name'] ?></option>
                        	<? } ?>
                        <? } ?>
                        </select>
                    </div>
                </div>
                <div class="field">
                    <label><?= $lang_team ?></label>
                    <div class="ui left icon input">
                        <i class="bookmark icon"></i>
                        <input type="text" name="team_id" placeholder="<?= $lang_team ?>" required>
                    </div>
                </div>
                <!--
                <div class="required field">
                    <label>역할</label>
                    <div class="ui left icon input">
                        <i class="anchor icon"></i>
                        <input type="text" name="position" placeholder="역할" required>
                    </div>
                </div>
                -->
                <div class="required field">
                    <label><?= $lang_motivation ?></label>
                    <div class="ui left icon input">
                        <i class="share icon"></i>
                        <input type="text" name="join_type" placeholder="<?= $lang_motivation ?>" required>
                    </div>
                </div>
                <div class="required field">
                    <label><?= $lang_position ?></label>
                    <select name="part" class="ui fluid dropdown" required>
                        <option value="1"><?= $lang_developer ?></option>
                        <option value="2"><?= $lang_designer ?></option>
                        <option value="3"><?= $lang_planner ?></option>
                    </select>
                </div>
                <div class="field">
                    <label><?= $lang_career ?></label>
                    <textarea name="history" rows="2"></textarea>
                </div>
                <div class="field">
                    <label><?= $lang_abilities ?></label>
                    <textarea name="skills" rows="2"></textarea>
                </div>
                <div class="required field">
                    <label><?= $lang_stage ?></label>
                    <select name="progress" class="ui fluid dropdown" required>
                        <option value="1"><?= $lang_idea ?></option>
                        <option value="2"><?= $lang_proto ?></option>
                        <option value="3"><?= $lang_launching ?></option>
                        <option value="4"><?= $lang_investment ?></option>
                    </select>
                </div>

                <div class="field">
                    <label><?= $lang_resource ?></label>
                    <textarea name="business_resource" rows="2"></textarea>
                </div>

                <a href="#" onclick="$(this).closest('form').submit()">
                  <div class="ui fluid large deep-blue submit button"><?= $lang_sing_up ?></div></a>
            </div>

            <div class="ui error message"></div>

        </form>
    </div>
</div>
