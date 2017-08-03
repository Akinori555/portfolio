$(function() {
// 基本設定
var onImg = $('img.on');
onImg.on({
  mouseenter:function() {
    if(!$(this).hasClass('select')) {
      var img = $(this),
          path = img.attr('src').slice(0,-4),
          onPath = path + '_on.png';
      img.attr('src',onPath);
    }
  },
  mouseleave:function() {
    if(!$(this).hasClass('select')) {
      var img = $(this),
          onPath = img.attr('src').slice(0,-7),
          path = onPath + '.png';
      img.attr('src',path);
    }
  }
});

// news_naviをクリックした時
var seleImg = $('#news_navi ul li img, #event_navi ul li img');
seleImg.on('click', function() {
  var img = $(this);
  if(!img.hasClass('select')) {
    // newsかeventかの判定
    var naviType = img.parent().parent().parent().attr('id') === 'news_navi' ? '#news' : '#event';

    // 他のselectクラスを除去
    $(naviType+'_navi ul li').each(function() {
      if( $(this).children('img').hasClass('select') ) {
        var seledImg = $(this).children('img'),
            seledPath = seledImg.attr('src').slice(0,-11),
            path = seledPath + '.png';
        seledImg.attr('src',path).removeClass('select');
      }
    });
    // select用の画像に差し替え、selectクラス追加
    var path = img.attr('src').slice(0,-7),
        selePath = path + '_select.png';
    img.attr('src',selePath).addClass('select');

    // news_listを選択したメニューのもののみにする
    var articleType = img.attr('alt');
    $(naviType+'_list dt,' +naviType+'_list dd').css('display','none');
    if(articleType === 'all') {
      $(naviType+'_list dt,' +naviType+'_list dd').css('display','block');
    } else {
      $(naviType+'_list dt.'+articleType+',' +naviType+'_list dd.'+articleType).css('display','block');
    }
  }
});

});