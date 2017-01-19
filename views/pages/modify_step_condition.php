<?
  require_once(VIEW.'common/_language.php');
?>
<h2 class="ui header">스텝 진입조건 수정</h2>
<div class="ui divider"></div>
<form class="ui form">
    <div class="required field">
        <label>제목</label>
        <input type="text" name="subject" placeholder="제목">
    </div>
    <div class="two fields">
        <div class="required field">
            <label>타입</label>
            <select name="type" class="ui fluid dropdown">
                <option value="val1">첫인상평가</option>
                <option value="val2">2</option>
                <option value="val3">3</option>
            </select>
        </div>
        <div class="required field">
            <label>이 조건을 적용할 커리큘럼을 스텝을 선택하세요</label>
            <select name="cur_step" class="ui fluid dropdown">
                <option value="val1">Kickoff</option>
                <option value="val2">2</option>
                <option value="val3">3</option>
            </select>
        </div>
    </div>
    <div class="required field">
        <label>해당 조건을 만족하지 못할때 보여줄 에러 메세지</label>
        <input type="text" name="step" placeholder="첫인상 평가를 마쳐야 다음 스텝으로 넘어가실 수 있습니다.">
    </div>
    <button class="ui button primary" type="submit"><?= $lang_submit ?></button>
</form>
