$(document).ready(function() {
    var slide = $('#bestseller_loader .over .slide').length;
    var infinite_chk = true;
    var slideWidth = 181;

    if (slide <= 4)
    {
        infinite_chk = false;
    }

    $('.base_seller_items .over').bxSlider({
        slideWidth: 183,
        minSlides: 1,
        maxSlides: 4,
        moveSlides: 1,
        nextSelector: '#promotion_next',
        prevSelector: '#promotion_back',
        auto: true,
        autoControls: false,
        autoDelay: 5,
        slideMargin: 32,
        infiniteLoop: infinite_chk,
        nextText: '&nbsp;',
        prevText: '&nbsp;',
        pager: false,
        onSliderLoad: function() {
            $('.bx-wrapper').css({maxWidth: '830px',margin: '0 auto'});
        }
    });

});

