<h2 class="ui header">과제생성</h2>
<div class="ui divider"></div>
<form class="ui form">
    <div class="required field">
        <label>제목</label>
        <input type="text" name="subject" placeholder="제목">
    </div>
    <div class="two fields">
        <div class="required field">
            <label>스텝</label>
            <select name="step" class="ui fluid dropdown">
                <option value="val1">첫인상평가/조직</option>
                <option value="val2">2</option>
                <option value="val3">3</option>
            </select>
        </div>
        <div class="required field">
            <label>과제타입</label>
            <select name="work_type" class="ui fluid dropdown">
                <option value="val1">글 읽기</option>
                <option value="val2">2</option>
                <option value="val3">3</option>
            </select>
        </div>
    </div>
    <div class="two fields">
        <div class="required field">
            <label>시작일</label>
            <input type="date" name="start_date" placeholder="시작일">
        </div>
        <div class="required field">
            <label>마감일</label>
            <input type="date" name="end_date" placeholder="마감일">
        </div>
    </div>
    <div class="required field">
        <label>설명 (간략한 안내)</label>
        <textarea rows="10" id="ir1" name="content" style="width: 100%"></textarea>
    </div>
    <div class="field">
        <label>참고링크 (비디오 과제의 경우 동영상 링크)</label>
        <input type="text" name="link">
    </div>

    <button class="ui button primary" type="submit">저장</button>
    <div class="field">
        <small>
            비디오 대본과 오프모임, 설문조사 상세내용은 일단 과제를 생성(저장)한 후에 추가로 작성하실 수 있습니다.
        </small>
    </div>
</form>