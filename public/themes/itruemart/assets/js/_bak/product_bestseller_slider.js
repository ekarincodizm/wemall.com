$(document).ready(function() {
    var slide = $('#bestseller_loader .over .slide').length;
    var infinite_chk = true;

    if (slide <= 4)
    {
        infinite_chk = false;
    }

    $('.base_seller_items .over').bxSlider({
        slideWidth: 181,
        minSlides: 1,
        maxSlides: 4,
        moveSlides: 1,
        nextSelector: '#promotion_next',
        prevSelector: '#promotion_back',
        auto: true,
        autoControls: false,
        slideMargin: 32,
        autoDelay: 5,
        infiniteLoop: infinite_chk,
        nextText: '&nbsp;',
        prevText: '&nbsp;',
        pager: false
    });

});

