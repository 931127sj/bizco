<style type="text/css">
    
    .ui.vertical.masthead.center.aligned.segment{
        background-image : url(../../assets/css/welcome.jpeg);
        background-position : center top;
        background-repeat : no-repeat;
        padding : 0px;
    }

    .ui.huge.primary.button{
        top : 7047px;
        position : relative;
        width : 400px;
        height : 100px;
        font-size : 2.42857143rem;
    }
    
</style>

<script>
    window.semantic = {
        handler: {}
    };
    
    semantic.visibility = {};
    
    semantic.visibility.ready = function()
    {
    
        $('.image img')
          .visibility({
            onOnScreen(): function()
            {
                type       : 'image',
                transition : 'fade in',
                duration   : 1000
            }
          })
        ;
    }
    
    $(document)
        .ready(semantic.visibility.ready);
    
</script>

<div class = "ui vertical masthead center aligned segment" style = "min-height : 7200px; margin-top : -100px;">
    <!--
    <div class = "image">
        <img src = "../../assets/css/logo_top.png" data-src = "../../assets/css/logo_top.png">
    </div>
    <div class = "image">
        <img src = "../../assets/css/logo_top.png" data-src = "../../assets/css/logo_top.png">
    </div>
    <div class = "image">
        <img src = "../../assets/css/logo_top.png" data-src = "../../assets/css/logo_top.png">
    </div>
    -->

    <div class="ui huge primary button" onclick = "location.href = '/public/index.php'">
        <span style = "vertical-align : middle; ">
            함께하기
        </span>
    </div>
</div>