(function ($) {
  var img = 'public/backoffice/default/plugins/wpaint/file/img/icons-menu-main-file.png';

  // extend menu
  $.extend(true, $.fn.wPaint.menus.main.items, {
    save: {
      icon: 'generic',
      title: 'Save Image',
      img: img,
      index: 0,
      callback: function () {
        this.options.saveImg.apply(this, [this.getImage()]);
      }
    },
    loadBg: {
      icon: 'generic',
      group: 'loadImg',
      title: 'Load Image to Foreground',
      img: img,
      index: 2,
      callback: function () {
        this.options.loadImgFg.apply(this, []);
      }
    },
    loadFg: {
      icon: 'generic',
      group: 'loadImg',
      title: 'Load Image to Background',
      img: img,
      index: 1,
      callback: function () {
        this.options.loadImgBg.apply(this, []);
      }
    }  
  });

  // extend defaults
  $.extend($.fn.wPaint.defaults, {
    saveImg: null,   // callback triggerd on image save
    loadImgFg: null, // callback triggered on image fg
    loadImgBg: null  // callback triggerd on image bg
  });

  // extend functions
  $.fn.wPaint.extend({
    _showFileModal: function (type, images) {
      var _this = this,
          $content = $('<div></div>'),
          $img = null;

      function appendContent(type, image) {
        function imgClick(e) {

          // just in case to not draw on canvas
          e.stopPropagation();
          if (type === 'fg') { _this.setImage(image); }
          else if (type === 'bg') { _this.setBg(image, null, null, true); }

          $('#photo_id').val($('img[src="'+image+'"').attr('data-id'));
          $('.wPaint-modal-bg, .wPaint-modal').remove();
        }

        $img.on('click', imgClick);
      }

      for (var i = 0, ii = images.length; i < ii; i++) {
        var imgData = images[i].split("?")
        $img = $('<img class="wPaint-modal-img" data-id="'+imgData[1]+'" />').attr('src', imgData[0]);
        $img = $('<div class="wPaint-modal-img-holder"></div>').append($img);

        (appendContent)(type, imgData[0]);

        $content.append($img);
      }

      this._showModal($content);
    }
  });
})(jQuery);