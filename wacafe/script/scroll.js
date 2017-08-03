jQuery(function() {
  // ********************************************************
  // 固定ナビ、ページトップスクロール表示切り替え
  // ********************************************************
  // var hnaviFix = $('#hnavi_fix'),
  var pageTop = $('#pagetop_wrapper'),
      body = $('body'),
      hnaviFixToggle = $('#header_wrapper').height(),
      fadeSpeed = 300,
      fadeEasing = 'linear',
      chgPt2 = 767;

  body.append('<nav id="hnavi_fix">'+ $('#hnavi_top').html() +'</nav>');
  var hnaviFix = $('#hnavi_fix');

  $(window).on('scroll load resize', function() {
    console.log($(window).scrollTop());
    if( $(this).scrollTop() >= hnaviFixToggle ) {
      if( $(window).width() > chgPt2 ) {
        hnaviFix.stop().css({'display':'block'}).animate({opacity:'1'},fadeSpeed,fadeEasing);
      } else {
        hnaviFix.stop().animate({opacity:'0',display:'none'},fadeSpeed,fadeEasing);
      }
      pageTop.stop().css({'display':'block'}).animate({opacity:'0.5'},fadeSpeed,fadeEasing);
    } else {
      hnaviFix.stop().animate({opacity:'0',display:'none'},fadeSpeed,fadeEasing);
      pageTop.stop().animate({opacity:'0',display:'none'},fadeSpeed,fadeEasing);
    }
  });

  // ********************************************************
  // ページスクロールストップイベント
  // ********************************************************
  var scrollStopEvent = new $.Event('scrollstop'),
      delay = 3000,
      timer;

  function scrollStopEventTrigger() {
    if(timer) {
      clearTimeout(timer);
    }
    timer = setTimeout(function () {
      $(window).trigger(scrollStopEvent);
    },delay);
  };
  $(window).on('scroll load', scrollStopEventTrigger);
  $('body').on('touchmove', scrollStopEventTrigger);

  $(window).on('scrollstop', function() {
    hnaviFix.stop().animate({opacity:'0',display:'none'},fadeSpeed,fadeEasing);
    pageTop.stop().animate({opacity:'0',display:'none'},fadeSpeed,fadeEasing);
  });

  $('#hnavi_fix, #pagetop_wrapper')
    .mouseenter(function(){clearTimeout(timer);})
    .mouseleave(scrollStopEventTrigger);

  // ********************************************************
  // ページスクロール設定
  // ********************************************************
  $(window).on('load resize', function() {
    var hnaviTopLink = $('#hnavi_top ul li a'),
        hnaviFixLink = $('#hnavi_fix ul li a'),
        scrollTime = 300,
        scrollEasing = 'swing';
        // headerHeight = $('#header_wrapper').height();

    if( $(window).width() > chgPt2 ) {
      hnaviFixLink.each(function(i) {
        var self = $(this);
        scrollPage(i,self);
      });
      hnaviTopLink.each(function(i) {
        var self = $(this);
        scrollPage(i,self);
      });
    }
    function scrollPage(i,self) {
      var num = i+1,
          offset = $('.link_tgt' + num).offset().top;
      self.on('click', function() {
        $('body, html').stop().animate({scrollTop:offset},scrollTime,scrollEasing);
      });
    };

    // ********************************************************
    // トップページスクロール設定
    // ********************************************************
    $('#pagetop_wrapper').on('click', function() {
      $('body, html').stop().animate({scrollTop:0},scrollTime,scrollEasing);
    });

  });
});