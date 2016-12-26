<h2 class="ui header">스텝생성</h2>
<div class="ui divider"></div>
<form class="ui form" action = "./do_add_step.php" method = "post">
    <div class="required field">
        <label>제목</label>
        <input type="text" name="step_name" placeholder="제목">
    </div>
    <div class="required field">
        <label>순서</label>
        <input type="number" name="step_seq" placeholder="순서">
    </div>
    <div class="two fields">
        <div class="required field">
            <label>시작일</label>
            <input type="date" name="start_date" placeholder="시작일">
        </div>
        <div class="required field">
            <label>종료일</label>
            <input type="date" name="end_date" placeholder="종료일">
        </div>
    </div>
    <div class="required field">
        <label>설명 (간략한 안내)</label>
        <textarea rows="10" id="ir1" name="step_explain" style="width: 100%"></textarea>
    </div>
    <div class="field">
        <div class="ui checkbox">
          <input type="checkbox" name="bm_link">
          <label>비즈니스모델 평가 연동하기</label>
        </div>
	</div>
    <button class="ui button primary" type="submit" id = "save">저장</button>
</form>