$(function() {
// 基本設定
var chgPt1 = 972;
$(window).on('resize', function() {
  if($(window).width() <= chgPt1) {
    $('#gnavi ul li a').each(function() {
      if($(this).children('img').css('display') === 'block') {
        var gnaviLink = $(this),
            gnaviWord = gnaviLink.children('img').attr('alt');
        gnaviLink.children('img').css('display','none');
        gnaviLink.append('<span class="gnavi_word">'+ gnaviWord +'</span>');
      }
    });
  } else {
    $('#gnavi ul li a').each(function() {
      if($(this).children('img').css('display') === 'none') {
        $('.gnavi_word').remove();
        $(this).children('img').css('display','block');
      }
    });
  }
});
$(window).trigger('resize');

// function chgGnavi() {
//   if($(window).width() <= chgPt1) {
//     $('#gnavi ul li a').each(function() {
//       if($(this).children('img').css('display') === 'block') {
//         var gnaviLink = $(this),
//             gnaviWord = gnaviLink.children('img').attr('alt');
//         gnaviLink.children('img').css('display','none');
//         gnaviLink.append('<span class="gnavi_word">'+ gnaviWord +'</span>');
//         // gnaviLink.css({
//         //   display: 'block',
//         //   width: '165px',
//         //   height: '40px',
//         //   color: '#fff',
//         //   background: '#4d54d6'
//         //
//         // });
//       }
//     });
//   } else {
//     $('#gnavi ul li a').each(function() {
//       if($(this).children('img').css('display') === 'none') {
//         $('.gnavi_word').remove();
//         $(this).children('img').css('display','block');
//       }
//     });
//   }
// };

});