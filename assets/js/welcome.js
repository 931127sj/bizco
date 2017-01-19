
window.semantic = {
    handler: {}
};
//namespace

semantic.visibility = {};



semantic.visibility.ready = function()
{
    $height = $(window).height()/2;

    // event handlers
    handler = {
        clearConsole: function() {
            $log.empty();
        },
        updateTable: function(calculations) {
          $.each(calculations, function(name, value) {
            var
              value = (typeof value == 'integer')
                ? parseInt(value, 10)
                : value.toString(),
              $td
            ;
            if(name == 'pixelsPassed' || name == 'width' || name == 'height') {
              value = parseInt(value, 10) + 'px';
            }
            else if(name == 'percentagePassed') {
              value = parseInt(value * 100, 10) + '%';
            }
          });
        },

        removeShape: function(){
              var
                shape = $(this).data('shape') || false
              ;
              if(shape) {
                $('.fifth .shape')
                  .removeClass(shape)
                ;
              }
        },

        changeShape: function(s) {
            if(s == "RIGHT")
                $('.fifth .shape').shape('flip right');
            else
                $('.fifth .shape').shape('flip left');
            /*
              var
                $shape       = $(this),
                $otherShapes = $shape.siblings(),
                shape        = $shape.data('shape')
              ;
              $shape
                .addClass('active')
              ;
              $otherShapes
                .removeClass('active')
                .each(handler.removeShape)
              ;
              $('.fifth')
                .removeAttr('style')
                .addClass(shape)
              ;
            */
        }
    };

    $('.ui.step.images')
      .visibility({
        onBottomVisible: function() {
            $('.step.images img')
                .transition({
                    animation : 'scale',
                    duration  : 800,
                    interval  : 200,
                })
            ;
        }
      })
    ;

    $('.first.images')
      .visibility({
        onBottomVisible: function() {
            $('.first.images img')
                .transition({
                    animation : 'slide up',
                    duration  : 800,
                    interval  : 200,
                })
            ;
        }
      })
    ;

    $('.ui.segment').tab('setting', 'onLoad', function() {
        $('.ui.sticky')
          .sticky('refresh')
        ;

        $(this).find('.visibility.example .overlay, .visibility.example .demo.segment, .visibility.example .items img')
          .visibility('refresh')
        ;

    });

    $('.second.segment .ui.sticky')
      .sticky({
        context: '.second.segment',
        offset: $(window).height()/2,
      })
    ;

    $('.fourth.segment .menu .item')
      .tab({
        cache: false,
        // faking API request
        apiSettings: {
          loadingDuration : 300,
          mockResponse    : function(settings) {
              var response = {
                  1  : '<div class = "ui items"><div class="item"><h1 class = "ui left header">STEP 1</h1><div class="content"><h3 class="ui main header">스타트업과 기업가 정신</h3><div class = "explain content"><p><i class = "angle right icon"></i>왜 기업가 정신인가?</p><p><i class = "angle right icon"></i>스타트업을 하는 이유</p><p><i class = "angle right icon"></i>선배창업가들의 조언 등 9개 콘텐츠</p></div><img src = "../../assets/css/step1_icon.png"></div></div></div>',
                  2 : '<div class = "ui items"><div class="item"><h1 class = "ui left header">STEP 2</h1><div class="content"><h3 class="ui main header">아이디어 제시와 상호평가</h3><div class = "explain content"><p><i class = "angle right icon"></i>좋은 아이디어의 중요성</p><p><i class = "angle right icon"></i>좋은 아이디어를 구상하는 세가지 방법</p><p><i class = "angle right icon"></i>사명감 기반과 작은 시장을 독점하는 아이디어 등 9개 콘텐츠</p></div><img src = "../../assets/css/step2_icon.png"></div></div></div>',
                  3  : '<div class = "ui items"><div class="item"><h1 class = "ui left header">STEP 3</h1><div class="content"><h3 class="ui main header">건강한 조직(팀) 만들기</h3><div class = "explain content"><p><i class = "angle right icon"></i>공동창업자 구성</p><p><i class = "angle right icon"></i>잘나가는 스타트업이 망하는 이유</p><p><i class = "angle right icon"></i>최악의 창업동료는? 등 7개 콘텐츠</p></div><img src = "../../assets/css/step3_icon.png"></div></div></div>',
                  4  : '<div class = "ui items"><div class="item"><h1 class = "ui left header">STEP 4</h1><div class="content"><h3 class="ui main header">디자인 씽킹과 아이템 창출</h3><div class = "explain content"><p><i class = "angle right icon"></i>디자인 씽킹을 통한 문제해결방법</p><p><i class = "angle right icon"></i>인터뷰를 통한 가설 검증</p><p><i class = "angle right icon"></i>국내외 특허 검색 방법 등 8개 콘텐츠</p></div><img src = "../../assets/css/step4_icon.png"></div></div></div>',
                  5  : '<div class = "ui items"><div class="item"><h1 class = "ui left header">STEP 5</h1><div class="content"><h3 class="ui main header">지식재산권 활용하기</h3><div class = "explain content"><p><i class = "angle right icon"></i>스타트업이 특허가 필요한 이유</p><p><i class = "angle right icon"></i>특허 출원 과정</p><p><i class = "angle right icon"></i>국내외 특허 검색 방법 등 8개 콘텐츠</p></div><img src = "../../assets/css/step5_icon.png"></div></div></div>',
                  6  : '<div class = "ui items"><div class="item"><h1 class = "ui left header">STEP 6</h1><div class="content"><h3 class="ui main header">비즈니스 모델 구현</h3><div class = "explain content"><p><i class = "angle right icon"></i>비즈니스 모델(BM)이란 무엇인가?</p><p><i class = "angle right icon"></i>비즈니스 모델이 필요한 이유</p><p><i class = "angle right icon"></i>국내외 스타트업의 BM사례 등 9개 콘텐츠</p></div><img src = "../../assets/css/step6_icon.png"></div></div></div>',
                  7  : '<div class = "ui items"><div class="item"><h1 class = "ui left header">STEP 7</h1><div class="content"><h3 class="ui main header">사업계획서 작성하기</h3><div class = "explain content"><p><i class = "angle right icon"></i>매력적인 사업계획서란?</p><p><i class = "angle right icon"></i>벤처투자자가 원하는 사업계획서 요건</p><p><i class = "angle right icon"></i>사업계획서 작성하는 법 등 8개 컨텐츠</p></div><img src = "../../assets/css/step7_icon.png"></div></div></div>',
                  8  : '<div class = "ui items"><div class="item"><h1 class = "ui left header">STEP 8</h1><div class="content"><h3 class="ui main header">창업정보 활용하기</h3><div class = "explain content"><p><i class = "angle right icon"></i>스타트업 단계별 자금 조달 방법</p><p><i class = "angle right icon"></i>정부 및 민간 투자지원사업</p><p><i class = "angle right icon"></i>스타트업 CEO가 알아야할 법률지식 등 7개 컨텐츠</p></div><img src = "../../assets/css/step8_icon.png"></div></div></div>',
                  9  : '<div class = "ui items"><div class="item"><h1 class = "ui left header">STEP 9</h1><div class="content"><h3 class="ui main header">랜딩페이지 / 프로토타입</h3><div class = "explain content"><p><i class = "angle right icon"></i>Wix를 통한 랜딩페이지 제작방법</p><p><i class = "angle right icon"></i>쥬커버그의 작은 프로토타입이 페이스북으로 발전된 과정</p><p><i class = "angle right icon"></i>스타트업 CEO가 알아야할 법률지식 등 7개 컨텐츠</p></div><img src = "../../assets/css/step9_icon.png"></div></div></div>',
                  10  : '<div class = "ui items"><div class="item"><h1 class = "ui left header">STEP 10</h1><div class="content"><h3 class="ui main header">데모데이</h3><div class = "explain content"><p><i class = "angle right icon"></i>1분 , 2분 , 5분 피칭방법</p><p><i class = "angle right icon"></i>1분 , 2분 , 5분 피칭 국내외 우수사례</p><p><i class = "angle right icon"></i>초기 스타트업 투자의 이해 등 11개 컨텐츠</p></div><img src = "../../assets/css/step10_icon.png"></div></div></div>',
                  11  : '<div class = "ui items"><div class="item"><h1 class = "ui left header">STEP 11</h1><div class="content"><h3 class="ui main header">지속성장과 네트워킹</h3><div class = "explain content"><p><i class = "angle right icon"></i>스타트업에서 성작동력의 중요성</p><p><i class = "angle right icon"></i>스타트업 경영실패 사례</p><p><i class = "angle right icon"></i>성공한 스타트업의 공통점 등 12개 컨텐츠</p></div><img src = "../../assets/css/step11_icon.png"></div></div></div>'
            };
            return response[settings.urlData.tab];
          }
        },
        context : 'parent',
        auto    : true,
        path    : '/'
      })
    ;

    $('.fifth .shape').shape();

    /*
    $('.fifth .button')
        .on('click', handler.changeShape("RIGHT"))
    ;
    */
}



$(document)
    .ready(semantic.visibility.ready);

/*
$(window).load(function() {
  $('.main.container .sticky').sticky('refresh');

});*/