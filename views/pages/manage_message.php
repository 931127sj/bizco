<div class="clearfix">
    <h2 class="ui header left floated" style="margin: 3px 0;">전체 메세지 보내기</h2>
</div>

<form class="ui form"  action="/public/do_send_email.php" method="post">
    <div class="field">
        <label>메세지 제목</label>
        <input type="text" name="title" required>
    </div>
    <div class="field">
        <label>메세지 내용</label>
        <textarea rows="15" name="content" required></textarea>
    </div>
    <button class="ui button primary" >작성 완료</button>
</form>
