$(function(){
    $('.ui.dropdown').dropdown();
    $('.accordion').accordion();
    $('.ui.checkbox').checkbox();
    $('.ui.embed').embed();
    $('.ui.tabular.menu .item').tab();
    $('[data-content]').popup();

    var inputFocus = false;

    commentResize();
    $(window).on('resizeEnd', function() {
        if (inputFocus) return false;
        commentResize();
    });

    $(window).resize(function() {
        if (inputFocus) return false;
        if(this.resizeTO) {
            clearTimeout(this.resizeTO);
        }
        this.resizeTO = setTimeout(function() {
            $(this).trigger('resizeEnd');
        }, 500);
    });

    $('input, textarea').focus(function () {
        inputFocus = true;
    })
    .blur(function(){
        inputFocus = false;
    });

    if ($('#ir1').length) {
        var oEditors = [];
        nhn.husky.EZCreator.createInIFrame({
            oAppRef: oEditors,
            elPlaceHolder: "ir1", //textarea에서 지정한 id와 일치해야 합니다.
            sSkinURI: "/assets/smarteditor/SmartEditor2Skin.html",
            htParams : {
                bUseToolbar : true,
                bUseVerticalResizer : true,
                bUseModeChanger : true,
                fOnBeforeUnload : function(){}
            },
            fOnAppLoad : function(){
                //기존 저장된 내용의 text 내용을 에디터상에 뿌려주고자 할때 사용
                oEditors.getById["ir1"].exec("PASTE_HTML", [""]);
            },
            fCreator: "createSEditor2"
        });
        //저장버튼 클릭시 form 전송
        $("#save").click(function(){
            oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
            console.log($(this).parents('form'));
            $(this).parents('form').submit();
        });
    }


    // $('.small.modal').modal('show');
});


function commentResize() {
    // 댓글 리사이즈
    var $obj = $('.scrollable').css('display', 'none');
    var h = $obj.parents('.ui.grid').height() - 310;
    $obj.css('display', 'inline-block').css('overflow-y', 'auto').css('max-height', h);
}
