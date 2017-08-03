jQuery(function() {
  // 基本設定
  var body = $('body'),
      chgPt1 = 989,
      chgPt2 = 767,
      originHeaderWrpHeight = 680,
      hnaviTop = $('#hnavi_top'),
      slideTime = 300,
      slideEasing = 'swing',
      scrollTime = 300,
      scrollEasing = 'swing';

  $(window).on('load resize', function() {
    // ********************************************************
    // 幅989px以下の時の対応
    // ********************************************************
    if( $(window).width() <= chgPt1 ) {
      // ********************************************************
      // menuのスタイル調整
      // ********************************************************
      if ( $('#sweet dl').next().hasClass('symbol_img') ) {
        var sweetDl = $('#sweet').find('dl'),
            sweetDlText = sweetDl.html();
        sweetDl.remove();
        $('#sweet').append('<dl>'+sweetDlText+'</dl>');
      }

      // ********************************************************
      // 幅767px以下の場合
      // ********************************************************
      if( $(window).width() <= chgPt2 ) {
        // ********************************************************
        // 幅767px以下の場合、hnavi_slideメニューを追加
        // ********************************************************
        if (!$('#hnavi_slide_wrapper').length) {
          // html要素をappend
          body.prepend('<a id="slide_btn" href="javascript:void(0);"><div class="slide_btn1"></div><div class="slide_btn2"></div><div class="slide_btn3"></div><div class="slide_btn4"></div></a>');
          body.prepend('<nav id="hnavi_slide">'+ hnaviTop.html() +'</nav>');
          $('#slide_btn, #hnavi_slide').wrapAll('<div id="hnavi_slide_wrapper"></div>');

          var slideBtn = $('#slide_btn'),
              hnaviSlide = $('#hnavi_slide'),
              hnaviSlideLink = $('#hnavi_slide ul li a'),
              hnaviSlideWrap = $('#hnavi_slide_wrapper');

          // リンクを追加
          hnaviSlideLink.each(function(i) {
            var self = $(this);
            scrollPage(i,self);
          });
          function scrollPage(i,self) {
            var indexNum = i+1,
                offset = $('.link_tgt' + indexNum).offset().top;
            self.on('click', function() {
              $('body, html').stop().animate({scrollTop:offset},scrollTime,scrollEasing);
            });
          };
          // ********************************************************
          // slideBtnを押した時
          // ********************************************************
          slideBtn.on('click', function() {
          // slideBtn.on('click', function() {
            var self = $(this),
                elmExi = $('.slide_btn1, .slide_btn2'),
                elmRem = $('.slide_btn3, .slide_btn4');
            // slide_btn_clsクラスがある時
            if ( self.hasClass('slide_btn_cls') ) {
              // メニューをスライド
              hnaviSlideWrap.stop().animate({right:-200},slideTime,slideEasing);
              // ボタンのマークの変形
              self.removeClass('slide_btn_cls').css({'opacity':0.5});
              $('.slide_btn1').removeClass('slide_btn_cls1');
              $('.slide_btn2').removeClass('slide_btn_cls2');
              elmRem.stop().css({'display':'block'}).animate({opacity:1},slideTime,slideEasing);
            // slide_btn_clsクラスがない時
            } else {
              // ボタンのマークの変形
              elmRem.stop().animate({opacity:0},slideTime,slideEasing,function(){elmRem.css({'display':'none'});});
              $('.slide_btn1').addClass('slide_btn_cls1');
              $('.slide_btn2').addClass('slide_btn_cls2');
              self.addClass('slide_btn_cls').css({'opacity':0.8});
              // メニューをスライド
              hnaviSlideWrap.stop().animate({right:0},slideTime,slideEasing);
            }
          });

          // ********************************************************
          // hnavi_fixのスタイル調整
          // ********************************************************
          if ( $('#hnavi_fix').css('display') === 'block' ) {
            $('#hnavi_fix').css({'display':'none'});
          }
          // if ( $('#pagetop_wrapper').css('display') === 'block' ) {
          //   $('#pagetop_wrapper').css({'display':'none'});
          // }
        } //if (!$('#hnavi_slide_wrapper').length) {

      // ********************************************************
      // 幅767px以上、989px以下の場合
      // ********************************************************
      } else {
        // ********************************************************
        // hnavi_slideメニューを取り除く
        // ********************************************************
        if ($('#hnavi_slide_wrapper').length) {
          // html要素をremove
          $('#hnavi_slide_wrapper').stop().remove();
        }
      } //if( $(window).width() <= chgPt2 ) {

    // ********************************************************
    // 幅989px以上の場合
    // ********************************************************
    } else { // if( $(window).width() <= chgPt1 ) {
      // ********************************************************
      // hnavi_slideメニューを取り除く
      // ********************************************************
      if ($('#hnavi_slide_wrapper').length) {
        // html要素をremove
        $('#hnavi_slide_wrapper').stop().remove();
      }

      // ********************************************************
      // menuのスタイル調整
      // ********************************************************
      if ( !$('#sweet dl').next().hasClass('symbol_img') ) {
        var sweetDl = $('#sweet').find('dl'),
            sweetDlText = sweetDl.html();
        sweetDl.remove();
        $('#sweet').prepend('<dl>'+sweetDlText+'</dl>');
      }

    } // else
  }); // $(window).on('resize load', function() {

}); // jQuery