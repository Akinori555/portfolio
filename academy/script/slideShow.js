$(function() {
// 基本設定
var fadeSpeed = 800,
    swtInter = 5000,
    fadeEasing = 'linear';

  console.log('hoge');

$('#icatch').each(function() {
  var self = $(this),
      findUl = self.find('ul'),
      findLi = findUl.find('li'),
      findLiFirst = findUl.find('li:first'),
      findLiCount = findLi.length,
      findImg = findLi.find('img'),
      fadeTimer;
  findLi.css({display:'block', opacity:'0', zIndex:'99'});
  findLiFirst.addClass('icatch_act').css({zIndex:'100'}).stop().animate({opacity:'1'},fadeSpeed,fadeEasing);

  findLi.each(function(i) {
    var listNum = i+1;
    $(this).addClass('icatch_list'+listNum);
  });

  if(findLiCount > 1) {
    self.append('<div id="pagination"></div>');
    findLi.each(function(i) {
      var listNum = i+1;
      $('#pagination').append('<a href="javascript:void(0)" class="pn'+listNum+'"></a>');
    });

    var pn = $('#pagination');
        pnPoint = pn.find('a'),
        pnFirst = pn.find('a:first'),
        pnLast = pn.find('a:last'),
        pnCount = pnPoint.length;

    pnFirst.addClass('pn_act');

    pnPoint.on('click', function() {
      if($(this).hasClass('pn_act')) { return false; }
      var onPn = $(this),
          pnNum = pnPoint.index(onPn)+1;
      findUl.find('.icatch_list' + pnNum).addClass('icatch_act').stop().animate({opacity:'1'},fadeSpeed,fadeEasing,function() { onPn.css({zIndex:'100'}); });
      findUl.find('.icatch_list' + pnNum).siblings().removeClass('icatch_act').stop().animate({opacity:'0'},fadeSpeed,fadeEasing,function() { onPn.css({zIndex:'99'}); });
      onPn.addClass('pn_act').siblings().removeClass('pn_act');
    });

    self.append('<a href="javascript:void(0);" class="icatch_prev"></a><a href="javascript:void(0);" class="icatch_next"></a>');
    var btnPrev = self.find('.icatch_prev'),
        btnNext = self.find('.icatch_next');

    function slidePrev() {
      var actPn = pn.find('.pn_act'),
          pnIndex = pnPoint.index(actPn),
          pnNum = pnIndex+1;

      if(pnNum === 1) {
        pnLast.click();
      } else {
        actPn.prev('a').click();
      }
    }
    function slideNext() {
      var actPn = pn.find('.pn_act'),
          pnIndex = pnPoint.index(actPn),
          pnNum = pnIndex+1;

      if(pnNum === pnCount) {
        pnFirst.click();
      } else {
        actPn.next('a').click();
      }
    }
    btnPrev.on('click',function() {slidePrev();});
    btnNext.on('click',function() {slideNext();});

    function autoSlide() {
      fadeTimer = setTimeout(function() {
        slideNext();
        autoSlide();
      },swtInter);
    }
    autoSlide();

    function autoSlideStop() {
      clearTimeout(fadeTimer);
    }

    self.hover(
      function() { autoSlideStop(); },
      function() { autoSlide(); }
    );

  } // if(findLiCount > 1) {
}); // $('#icatch').each(function() {

});