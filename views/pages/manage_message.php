<div class="clearfix">
    <h2 class="ui header left floated" style="margin: 3px 0;">전체 메세지 보내기</h2>
</div>

<form class="ui form"  action="/public/do_send_email.php" method="post">
    <div class="field">
        <label>메세지 제목</label>
        <input type="text" name="title" required>
    </div>
    <div class="field">
        <select class="ui fluid dropdown" name = "target">
            <option value="">보낼 대상</option>
            <option value="2">참가자에게</option>
            <option value="4">멘토에게</option>
            <option value="7">관리자에게</option>
        </select>
    </div>
    <div class="field">
        <label>메세지 내용</label>
        <textarea rows="15" name="content" required></textarea>
    </div>
    <button class="ui button primary" ><?= $lang_submit ?></button>
</form>
