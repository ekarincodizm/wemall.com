 
$(document).ready(function() {
 var imgPreviewContent = $('.img_preview_content').each(function(i){
        var o = this;
      $(o).bxSlider({
          slideWidth: 68,
          minSlides: 3,
          maxSlides: 3,
          slideMargin: 8,
          pager: false,
          moveSlide: 1,
          nextSelector: '#img_preview_prev_'+i,
          prevSelector: '#img_preview_next_'+i,
          nextText: '<img src="' + site_url + 'assets/itruemart_new/images/product_preview_prv.jpg" alt="" />',
          prevText: '<img src="' + site_url + 'assets/itruemart_new/images/product_preview_next.jpg" alt="" />',
          infiniteLoop: true,
          moveSlides: 1,
          onSliderLoad: function() {
            var p = $(o).parents('.img_preview_wrapper');
            if(p.hasClass('other-images'))
              p.hide();
          }
      });
    });

    var thumbnailTimeOut;
    $('#img_preview_next').on('touchstart mouseover', function() {
        GoToPrevSlide();
    }).mouseout(function() {
        clearTimeout(thumbnailTimeOut);
    });
    $('#img_preview_prev').on('touchstart mouseover', function() {
        GoToNextSlide();
    }).mouseout(function() {
        clearTimeout(thumbnailTimeOut);
    });
    ;

    function GoToPrevSlide() {
        imgPreviewContent.goToPrevSlide();
        clearTimeout(thumbnailTimeOut);
        thumbnailTimeOut = setTimeout(GoToPrevSlide, 1000);
    }
    function GoToNextSlide() {
        imgPreviewContent.goToNextSlide();
        clearTimeout(thumbnailTimeOut);
        thumbnailTimeOut = setTimeout(GoToNextSlide, 1000);
    }

});