jQuery(function() {
  var contentsWidth = 1200,
      headerHeight = 80,
      headerSns = $('#header_sns'),
      headerForm = $('#header_form'),
      gnaviWrapper = $('#gnavi_wrapper');

  $(window).on('resize', function() {
    var windowWidth = $(window).width();
    if( windowWidth > contentsWidth ) {
      var offset = (windowWidth - contentsWidth) / 2;
      headerSns.css({'left':offset});
      headerForm.css({'right':offset});

      $('.contents_icatch').css({
        'background-position-x':offset
      });
    } else {
      headerSns.css({'left':0});
      headerForm.css({'right':0});

      $('.contents_icatch').css({
        'background-position-x':0
      });
    }
  });

  $(window).on('scroll resize', function() {
    if( $(this).scrollTop() >= headerHeight ) {
      gnaviWrapper.css({'position':'fixed','width':'100%','top':0});
      headerSns.css({'top':'25px'});
      headerForm.css({'top':'25px'});
    } else {
      gnaviWrapper.css({'position':'relative','width':'auto','top':'auto'});
      headerSns.css({'top':'50px'});
      headerForm.css({'top':'50px'});
    }
  });

  $(window).trigger('resize');
  $(window).trigger('scroll');


  var section = $('contents_section'),
  contTextNml = $('div.normal .contents_text'),
  contTextRvs = $('div.reverse .contents_text'),
  contImgNml = $('div.normal .contents_img'),
  contImgRvs = $('div.reverse .contents_img'),
  fadeTime = 500,
  fadeEasing = 'linear';
  $(window).on('scroll resize', function() {
    var scrollY = $(this).scrollTop(),
        contentsLength = $('.contents_section').length;
    for(i=0; i<=contentsLength; i++) {
      sectionY = section.eq(i).offset().top;
      if( scrollY >= sectionY ) {
        section.eq(i).find($('div.normal')).find($('.contents_text')).stop().animate({opacity:1,marginLeft:0},fadeTime,fadeEasing);
        continue;
      } else {
        if( i === 0) {
          break;
        } else {

        }
      }
    }
  });

  contTextNml.stop().animate({opacity:1,marginLeft:0},fadeTime,fadeEasing);
  contTextRvs.stop().animate({opacity:1,marginRight:0},fadeTime,fadeEasing);
  contImgNml.stop().animate({opacity:1,marginRight:0},fadeTime,fadeEasing);
  contImgRvs.stop().animate({opacity:1,marginLeft:0},fadeTime,fadeEasing);

});