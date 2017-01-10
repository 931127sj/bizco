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
                    <label>이메일</label>
                    <div class="ui left icon input">
                        <i class="at icon"></i>
                        <input type="text" name="email" placeholder="이메일 주소를 입력해 주세요." required>
                    </div>
                </div>
                <div class="required field">
                    <label>성명</label>
                    <div class="ui left icon input">
                        <i class="tag icon"></i>
                        <input type="text" name="name" placeholder="성명" required>
                    </div>
                </div>
                <div class="required field">
                    <label>암호</label>
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" placeholder="암호" required>
                    </div>
                </div>
                <div class="required field">
                    <label>암호 재입력</label>
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password_retype" placeholder="암호 재입력" required>
                    </div>
                </div>
                <div class="required field">
                    <label>연락처</label>
                    <div class="ui left input">
                        <input type="text" name="phone" placeholder="연락처" required>
                    </div>
                </div>
                <div class="required field">
                    <label>참여</label>
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
                    <label>팀 이름</label>
                    <div class="ui left icon input">
                        <i class="bookmark icon"></i>
                        <input type="text" name="team_id" placeholder="팀 이름" required>
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
                    <label>참여 동기</label>
                    <div class="ui left icon input">
                        <i class="share icon"></i>
                        <input type="text" name="join_type" placeholder="참여 동기" required>
                    </div>
                </div>
                <div class="required field">
                    <label>참여 파트</label>
                    <select name="part" class="ui fluid dropdown" required>
                        <option value="1">개발자</option>
                        <option value="2">디자이너</option>
                        <option value="3">기획자</option>
                    </select>
                </div>
                <div class="field">
                    <label>창업이력</label>
                    <textarea name="history" rows="2"></textarea>
                </div>
                <div class="field">
                    <label>보유역량</label>
                    <textarea name="skills" rows="2"></textarea>
                </div>
                <div class="required field">
                    <label>진행사항</label>
                    <select name="progress" class="ui fluid dropdown" required>
                        <option value="1">아이디어 단계</option>
                        <option value="2">시제품 제작 단계</option>
                        <option value="3">제품 런칭 단계</option>
                        <option value="4">투자 단계</option>
                    </select>
                </div>

                <div class="field">
                    <label>사업에 필요한 자원</label>
                    <textarea name="business_resource" rows="2"></textarea>
                </div>

                <a href="#" onclick="$(this).closest('form').submit()"><div class="ui fluid large deep-blue submit button">가입</div></a>
            </div>

            <div class="ui error message"></div>

        </form>
    </div>
</div>
