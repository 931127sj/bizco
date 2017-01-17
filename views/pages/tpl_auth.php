<?

if($_SESSION['lang'] == "en"){
  $lang_keep_login = "Keep me logged in";
  $lang_sign_up = "Sign up";
  $lang_login = "Log in";

}else{
  $lang_keep_login = "로그인 유지하기";
  $lang_sign_up = "새 계정가입";
  $lang_login = "로그인";
}
?>
<style type="text/css">
body {
background:url(../../assets/css/bg_login.jpg) center center no-repeat;
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
}
h1.ui.header {
max-width:350px;
margin:0px auto;
font-family: 'notoR', 'Lato', 'Helvetica Neue', Arial, Helvetica, sans-serif !important;
}
.ui.header img{
width:100%;
}
.ui.checkbox label.white {
color:#fff;
}
#inputStyle input.input_style {
background: none;
border: 0;
border-bottom: 1px solid #fff;
border-radius: 0;
padding:0.9rem 0;
color:#fff;
}
.ui.form .field .ui.input {
color:#fff;
}
#inputStyle .fields.two a.awhite {
color:#fff;
}
#inputStyle .fields.two a.awhite:hover, #inputStyle .fields.two a.awhite:focus {
color:#49e7c3;
}
#inputStyle div.fields.two {
margin: 1.6rem 0;
}
.ui.deep-blue.button {
border-radius: 30rem;
}
</style>

<div style="width:100%; margin-top:50px; margin-left:50px;">한국어 English</div>

<nav class="ui top fixed secondary menu">
    <div class="header item">
        <div class="ui text container logo">
            Startup on the base of<br>Entrepreneurship
        </div>
    </div>
</nav>

<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h1 class="ui header">
            <div class="ui header">
                <img src="../../assets/css/logo_login.png" width="420" height="290" alt="Startup on the base of Entrepreneurship">
            </div>
            <small class="ui text teal">스타트업 온라인 육성 프로그램</small>
        </h1>
        <form class="ui large form" action="/public/do_login.php" method="post">
            <div id="inputStyle" class="ui basic segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input class="input_style" type="text" name="email" placeholder="E-mail address" required>
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input class="input_style" type="password" name="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="fields two">
                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" tabindex="0" class="hidden">
                            <label class="white"><?= $lang_keep_login ?></label>
                        </div>
                    </div>
                    <div class="field">
                        <a class="awhite" href="/public/join.php"><i class="ui icon child"></i> <?= $lang_sing_up ?></a>
                    </div>
                </div>

                <input type="submit" class="ui fluid large deep-blue submit button" value="<?= $lang_login ?>">

            </div>

            <div class="ui error message"></div>

        </form>
    </div>
</div>
