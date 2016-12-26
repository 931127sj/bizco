<?
$_SESSION['current_menu'] = "dt";
?>
<h2 class="ui header">디자인 씽킹 작성</h2>
<div class="ui segment area1200" id="dtArticle">
    <form class="ui form" action="do_add_dt.php" method="post"  enctype="multipart/form-data">
        <h4 class="ui header">1단계 공감하기</h4>
        <div class="field">
            <label>아이템(문제)의 대상에 대한 관찰 및 인터뷰 내용을 링크하세요</label>
            <div class="ui action input">
                <input type="text" name="link[]" placeholder="Link...">
                <div class="ui icon button" onclick="addLinkField(this)">
                    <i class="plus icon"></i>
                </div>
            </div>
        </div>
        <h4 class="ui header">2단계 문제정의</h4>
        <div class="field">
            <label>이미지 업로드</label>
            <input type="file" name="img2">
        </div>
        
        <div class="field">
            <label>팀내 토론을 거쳐 문제의 원인을 정리(정의)하세요</label>
            <textarea rows="2" name = "problem_cause"></textarea>
        </div>
        <h4 class="ui header">3단계 아이디어 도출</h4>
        <div class="field">
            <label>문제를 해결하기 위한 솔루션(아이디어)를 입력하세요</label>
            <div class="ui action input">
                <input type="text" name="idea[]" placeholder="아이디어를 입력해 주세요.">
                <div class="ui icon button" onclick="addIdeaField(this)">
                    <i class="plus icon"></i>
                </div>
            </div>
        </div>
        <h4 class="ui header">4단계 시제품 만들기</h4>
        <div class="field">
            <label>시제품에 대한 사진 또는 동영상을 업로드하세요</label><br>
            <label>이미지 업로드</label>
            <input type="file" name="profile">
        </div>
        <div class="field">
            <label>유튜브 동영상 업로드</label>
            <input type="text" name="youtube_link" placeholder="YouTube URL">
        </div>
        <h4 class="ui header">5단계 테스트</h4>
        <div class="field">
            <label>테스트한 고객의 의견(피드백)을 입력해주세요</label>
            <textarea rows="2" name="test[]"></textarea>
        </div>
        <div class="field test-last-field">
            <div class="ui icon button" onclick="addTestField(this)"><i class="plus icon"></i></div>
        </div>
        <button class="ui button primary" tabindex="0">저장하기</button>
    </form>
</div>

<script type="text/javascript">
    function addLinkField(self) {
        $(self).parent().parent().after('<div class="field"><div class="ui action input"><input type="text" name="link[]" placeholder="Link..."><div class="ui icon button" onclick="removeDThisField(this)"><i class="minus icon"></i></div></div></div>');
    }
    function addIdeaField(self) {
        $(self).parent().parent().after('<div class="field"><div class="ui action input"><input type="text" name="idea[]" placeholder="아이디어를 입력해 주세요."><div class="ui icon button" onclick="removeDThisField(this)"><i class="minus icon"></i></div></div></div>');
    }
    function addTestField(self) {
        $(self).parent().prev().after('<div class="field"><textarea rows="2" name="test[]"></textarea><a onclick="removeThisField(this)">위의 칸 제거</a></div>');
    }
    function removeThisField(self) {
        $(self).parent().remove();
    }
    function removeDThisField(self) {
        $(self).parent().parent().remove();
    }
</script>