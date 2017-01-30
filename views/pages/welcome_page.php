<style type="text/css">
    
    .ui.main.container{
        background-image : url(../../assets/css/background.png);
        background-position : center top;
        background-repeat : no-repeat;
        padding : 0px;
    }

    .footer .ui.huge.primary.button{
        width : 400px;
        height : 100px;
        font-size : 2.42857143rem;
        margin-top: 100px;
    }
    
    .fourth.ui.basic.segment{
        padding : 0px;
        margin-top : -50px;
        height : 405px;
    }
    
    .fixed.menu
    {
        position : fixed; 
        top : 80px; 
        left : 0px;
    }
    
    .fixed.menu .menu
    {
        background-image : url(../../assets/css/quickmenu.png); !important;
        background-repeat : no-repeat;
        width : 180px;
        height : 367px;
    }
    
    .fixed.menu .container
    {
        cursor : pointer;
        margin-top : -4px;
    }
    
    .fourth.segment .tab.segment{
        background-image : url(../../assets/css/fourth_ui_bg.png);
        background-repeat : no-repeat;
        width : 953px;
        height : 270px;
        margin-left : 164px;
    }
    
    .ui.secondary.menu .item
    {
        margin-right : 30px;
        font-size : 20px;
        color : skyblue;
        background-color : white;
        border-radius: 11.2em;
    }
    
    .ui.secondary.menu .active.item
    {
        border-radius: 11.2em;
        color : white;
        background-color : skyblue;
    }
    
    .fourth.segment .ui.items
    {
        height : 100%
    }
    
    .fourth.segment .item
    {
        height : 100%
    }
    
    .fourth.segment .ui.left.header
    {
        width : 350px; 
        height : 100%; 
        color : white; 
        margin-top : 100px; 
        margin-left : -13px;
    }
    
    .fourth.segment .content
    {
        height : 100%;
    }
    
    .fourth.segment .content .main.header
    {
        margin-top : 20px !important;
        color : #3f63bf !important
    }
    
    .fourth.segment .content img
    {
        position : absolute; 
        bottom : 5px; 
        right : 5px;
    }
    
    .fourth.segment .content .explain.content
    {
        margin-left : 120px; 
        margin-top : 50px
    }
    
    .fourth.segment .content .explain.content p
    {
        text-align : left
    }
    
    .auto.ui.shape
    {
        margin-top : 100px;
        margin-left : 65px;
    }
    
    .fifth .rail .icon
    {
        color : white
    }
    
    .fifth .rail .icon:hover
    {
        color : antiquewhite
    }
    
    .fifth .rail .right.icon
    {
        padding-right : 85px;
        margin-left : -80px;
    }
    
    .fifth .rail .left.icon
    {
        padding-left : 120px
    }
    
    .fifth .side img
    {
        margin-left : -40px
    }
    
</style>

<script>
    function changeShape(s) {
            if(s == "RIGHT")
                $('.fifth .shape').shape('flip right');
            else
                $('.fifth .shape').shape('flip left');
        }
</script>

<div class = "ui vertical masthead basic center aligned segment" style = "min-width : 1280px; margin-top : -100px; padding-bottom : 0px !important;">
    <div class = "ui main container" style = "min-width : 1280px !important;">
        <div class = "first ui basic segment" style = "width : 100%; height : 750px" id = "first">
            <div class = "ui first images" style = "margin-top : 435px">
                <?php
                    for($i = 1; $i < 7; $i++)
                    {
                ?>
                        <div class = "image">
                            <img src="../../assets/css/icon<?php echo $i?>.png" data-src="../../assets/css/icon<?php echo $i?>.png" class = "transition hidden" style = "margin-right : 30px">
                        </div>
                        <!--<img src="../../assets/css/right_arrow.png" class = "transition hidden" style = "margin-right : 15px; margin-top : -157px">-->
                <?php
                    }
                ?>
            </div>
        </div>

        <div class = "second ui basic segment" id = "second">
            <div class = "column stickyarrow" style = "margin-left : auto; margin-right : auto; height : 1200px; " >
                <div class="ui sticky" >
                    <img src = "../../assets/css/sticky_arrow.png">
                </div>
            </div>
        </div>
        
        <div class = "third ui header" style = "height : 300px" id = "third"></div>
        <div class = "third ui basic segment">
            <div class = "ui step images">
                <img src="../../assets/css/step1.png" data-src="../../assets/css/step1.png" class = "transition hidden">
                <img src="../../assets/css/step2.png" data-src="../../assets/css/step2.png" class = "transition hidden" style = "margin-top : -13px">
                <img src="../../assets/css/step3.png" data-src="../../assets/css/step3.png" class = "transition hidden" style = "margin-top : -23px">
            </div>
        </div>
        
        <div class = "fourth ui header" style = "height : 210px; margin-top : -30px" id = "fourth"></div>
        <div class = "fourth ui basic segment">
            <div class="ui secondary menu" style = "padding-top : 55px; padding-left : 182px">
                <a class="active item" data-tab="1">1</a>
                <a class="item" data-tab="2">2</a>
                <a class="item" data-tab="3">3</a>
                <a class="item" data-tab="4">4</a>
                <a class="item" data-tab="5">5</a>
                <a class="item" data-tab="6">6</a>
                <a class="item" data-tab="7">7</a>
                <a class="item" data-tab="8">8</a>
                <a class="item" data-tab="9">9</a>
                <a class="item" data-tab="10">10</a>
                <a class="item" data-tab="11">11</a>
            </div>
            
            <div class="ui active basic tab segment" data-tab="1">
                <div class = "ui items">
                    <div class="item">
                        <h1 class = "ui left header">STEP 1</h1>
                        <div class="content">
                           <h3 class="ui main header">스타트업과 기업가 정신</h3>

                            <div class = "explain content">
                                <p><i class = "angle right icon"></i>왜 기업가 정신인가?</p>
                                <p><i class = "angle right icon"></i>스타트업을 하는 이유</p>
                                <p><i class = "angle right icon"></i>선배창업가들의 조언 등 9개 콘텐츠</p>
                            </div>
                            
                            <img src = "../../assets/css/step1_icon.png">
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui tab basic segment" data-tab="2"></div>
            <div class="ui tab basic segment" data-tab="3"></div>
            <div class="ui tab basic segment" data-tab="4"></div>
            <div class="ui tab basic segment" data-tab="5"></div>
            <div class="ui tab basic segment" data-tab="6"></div>
            <div class="ui tab basic segment" data-tab="7"></div>
            <div class="ui tab basic segment" data-tab="8"></div>
            <div class="ui tab basic segment" data-tab="9"></div>
            <div class="ui tab basic segment" data-tab="10"></div>
            <div class="ui tab basic segment" data-tab="11"></div>
        </div>
        
        <div class = "fifth ui header" style = "height : 320px" id = "fifth"></div>
        
        <div class = "fifth ui basic segment">
            <div class = "auto ui shape">
                <div class = "sides">
                    <div class = "active first side">
                        <img src = "../../assets/css/fifth_program1.png" class = "ui image">
                    </div>
                    <div class = "second side">
                        <img src = "../../assets/css/fifth_program2.png" class = "ui image">
                    </div>
                    <div class = "third side">
                        <img src = "../../assets/css/fifth_program3.png" class = "ui image">
                    </div>
                    <div class = "fourth side">
                        <img src = "../../assets/css/fifth_program4.png" class = "ui image">
                    </div>
                </div>
                <div class="ui left attached rail">
                    <div class="ui right floated basic segment">
                        <i class = "massive angle left icon" onclick = "changeShape('LEFT')"></i>
                    </div>
                </div>
                <div class="ui right attached rail">
                    <div class="ui left floated basic segment">
                        <i class = "massive angle right icon" onclick = "changeShape('RIGHT')"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class = "sixth ui basic segment">
            <img src="../../assets/css/sixth_header.png" style = "margin-top : 790px">
            <div class = "ui sixth images" style = "margin-top : 30px">
                <img src="../../assets/css/sixth_chart1.png" class = "transition hidden" style = "margin-right : 30px">
                <img src="../../assets/css/sixth_chart2.png" class = "transition hidden" style = "margin-right : 30px">
                <img src="../../assets/css/sixth_chart3.png" class = "transition hidden" style = "margin-right : 30px">
            </div>
            <img src="../../assets/css/sixth_footer.png">
        </div>
        
        <div class = "footer ui basic segment">  
            <div class="ui huge primary animated fade button " onclick = "location.href = '/public/auth.php'" id = "footer">
                <div class="visible content">함께하기</div>
                <div class="hidden content">지금 바로!</div>
            </div>
                
            <div class="ui huge primary animated fade button " onclick = "location.href = '/public/do_landing_question.php'" id = "footer">
                <div class="visible content">문의하기</div>
                <div class="hidden content"><i class = "sign in icon"></i></div>
            </div>
        </div>
        

        <div class = "fixed menu">
            <div class = "ui vertical basic menu">
                <div class = "ui basic container" style = "height : 63px;">
                </div>
                <div class = "ui basic container" style = "height : 59px" onclick = "location.href = '#second'">
                </div>
                <div class = "ui basic container" style = "height : 58px" onclick = "location.href = '#third'">
                </div>
                <div class = "ui basic container" style = "height : 58px" onclick = "location.href = '#fourth'">
                </div>
                <div class = "ui basic container" style = "height : 58px" onclick = "location.href = '#fifth'">
                </div>
                <div class = "ui basic container" style = "height : 58px" onclick = "location.href = '#footer'">
                </div>
                <div class = "ui basic container" style = "height : 37px" onclick = "location.href = '#'">
                </div>
            </div>
        </div>

    </div>
</div>