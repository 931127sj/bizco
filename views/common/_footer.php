<?php
if (! preg_match('/\.php$/', $_SERVER['REQUEST_URI'])) {
?>
</section>

<!-- Modal -->
<div class="ui modal small">
    <i class="close icon"></i>
    <div class="header">
        공지사항
    </div>
    <div class="content">
        <div class="description">
            A description can appear on the right
        </div>
    </div>
    <div class="actions">
        <div class="ui secondary cancel button">그만보기</div>
    </div>
</div>

<!--
마크다운으로 하려면 아래를 써도 괜찮음...
$('.ui.attached.segment').each(function(idx, item){
$(item).html(marked($(item).html()));
});
 -->
<?php
}
?>
 <?php echoAssets($this->footerFiles); ?></body></html>