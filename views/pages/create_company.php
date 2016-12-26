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
    <button class="ui button primary" type="submit" id = "save">저장</button>
</form>