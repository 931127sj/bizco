
<div class="clearfix">
    <h2 class="ui header left floated" style="margin: 3px 0;">문의하기</h2>
</div>

<form class="ui form" action="/public/do_write_board.php" method="post">
    <input type="hidden" name="company_id" value="<?=$company_id?>">
    <input type="hidden" name="board_id" value="landing_question">
    <input type="hidden" name="type" value="write">
    <input type="hidden" name="redirect" value="question_list?company=<?=$company_id?>">
    <div class="field">
        <label>문의 제목</label>
        <input type="text" name="title" required>
    </div>
    <div class="field">
        <label>작성자</label>
        <input type="text" name="name" required>
    </div>
    <div class="field">
        <label>이메일</label>
        <input type="email" name="email" required>
    </div>
    <div class="field">
        <label>연락처</label>
        <input type="text" name="address" required>
    </div>
    <div class="field">
        <label>문의 내용</label>
        <textarea rows="15" name="content" required></textarea>
    </div>
    <button class="ui button primary">확인</button>
</form>
