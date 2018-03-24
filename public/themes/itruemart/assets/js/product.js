// ตัดออก
(function($) {
    $.fn.ProductControls = function() {
        var prevType = 'zoom';
        var $previousView = $('.product_img_big');
        var $currentView;
        var vdo;
        var methods = {
            RemoveMultiZoom: function() {
                $('div.magnifyarea, div.cursorshade, div.zoomstatus, div.zoomtracker, .product_img_big, .img_preview_wrapper').hide();
            },
            Remove_360Degree: function() {
                var $product360Degree = $('.product_360degree-container');
                /*if($('.product_360degree').parent().is('div')){
                 $('.product_360degree').unwrap();
                 }*/
                $product360Degree.hide();
            },
            Remove_VDO: function() {
                vdo = $('.vdo-container').hide().find('.vdo-inner').html();
                $('.vdo-container').find('.vdo-inner').html(vdo);
            },
            Init_Zoom: function() {
                if ($.browser.msie) {
                    $('.product_img_big a.zoomer').jqzoom({
                        zoomType: 'standard',
                        lens: true,
                        preloadImages: false,
                        alwaysOn: false,
                        zoomWidth: 300,
                        zoomHeight: 300
                    });
                }
                else {
                    $('.product_img_big img').addimagezoom({// single image zoom
                        zoomrange: [2, 8],
                        magnifiersize: [500, 350],
                        magnifierpos: 'right',
                        cursorshade: true,
                        largeimage: $('.product_img_big a').attr('href') //<-- No comma after last option!
                    });
                    $('div.cursorshade.featuredimagezoomerhidden').live('mouseover', function() {
                        $(this).draggable({containment: 'div.zoomtracker', scroll: false});
                    });
                }
                $('.product_img_big, .img_preview_wrapper').show();
            },
            Init_360Degree: function() {
                var arr = [];
                for (var x = 0; x <= 35; x++)
                    arr.push(x);

                $(".product_360degree").threesixty({images: arr, method: 'mousemove', direction: 'backward', sensibility: 1});
                $('.product_360degree-container').show();
            },
            Init_VDO: function() {
                $('.vdo-container').show();
            }
        }

        return this.each(function() {
            $(this).find('a').bind('click', function() {
                var type = $(this).attr('rel');

                switch (prevType) {
                    case 'zoom':
                        methods.RemoveMultiZoom();
                        break;
                    case '360':
                        methods.Remove_360Degree();
                        break;
                    case 'vdo':
                        methods.Remove_VDO();
                        break;
                    default:
                        break;
                }

                switch (type) {
                    case 'zoom':
                        methods.Init_Zoom();
                        break;
                    case '360':
                        methods.Init_360Degree();
                        break;
                    case 'vdo':
                        methods.Init_VDO();
                        break;
                    default:
                        $currentView = undefined;
                        break;
                }
                prevType = type;
            });
        });
    };
})(jQuery);

$(document).ready(function() {

    $('.product-control').ProductControls();

    if ($.browser.msie) {
        $('.product_img_big a.zoomer').jqzoom({
            zoomType: 'standard',
            lens: true,
            preloadImages: false,
            alwaysOn: false,
            zoomWidth: 300,
            zoomHeight: 300
        });
    }
    else {

        $('.product_img_big img').addimagezoom({// single image zoom
            zoomrange: [2, 8],
            magnifiersize: [500, 350],
            magnifierpos: 'right',
            cursorshade: true,
            largeimage: $('.product_img_big a').attr('href') //<-- No comma after last option!
        });
        $('div.cursorshade.featuredimagezoomerhidden').live('mouseover', function() {
            $(this).draggable({containment: 'div.zoomtracker', scroll: false});
        });
    }

    //Touch Screen
    $('a.show_thumb').on('touchstart', function(event) {
        event.preventDefault();

        anchor = $(this);
        pathOriginal = anchor.siblings('img.path_original').attr('src');
        pathShow = anchor.siblings('img.path_show').attr('src');

        $('.product_img_big a.zoomer').attr('href', pathOriginal);
        $('.product_img_big a.zoomer img').attr('src', pathShow);

        if ($.browser.msie) {
            $('.product_img_big a.zoomer').jqzoom({
                zoomType: 'standard',
                lens: true,
                preloadImages: false,
                alwaysOn: false,
                zoomWidth: 300,
                zoomHeight: 300
            });
        }
        else {
            $('.product_img_big img').addimagezoom({// single image zoom
                zoomrange: [2, 8],
                magnifiersize: [500, 350],
                magnifierpos: 'right',
                cursorshade: true,
                largeimage: anchor.siblings('img.path_original').attr('src') //<-- No comma after last option!
            });
        }

    });
    // end
    $('a.show_thumb').live('mouseover', function(event) {
        event.preventDefault();

        anchor = $(this);
        pathOriginal = anchor.siblings('img.path_original').attr('src');
        pathShow = anchor.siblings('img.path_show').attr('src');

        $('.product_img_big a.zoomer').attr('href', pathOriginal);
        $('.product_img_big a.zoomer img').attr('src', pathShow);

        if ($.browser.msie) {
            $('.product_img_big a.zoomer').jqzoom({
                zoomType: 'standard',
                lens: true,
                preloadImages: false,
                alwaysOn: false,
                zoomWidth: 300,
                zoomHeight: 300
            });
        }
        else {
            $('.product_img_big img').addimagezoom({// single image zoom
                zoomrange: [2, 8],
                magnifiersize: [500, 350],
                magnifierpos: 'right',
                cursorshade: true,
                largeimage: anchor.siblings('img.path_original').attr('src') //<-- No comma after last option!
            });
        }

    });
    
    var imgPreviewContent = $('.img_preview_content').bxSlider({
        slideWidth: 68,
        minSlides: 3,
        maxSlides: 3,
        slideMargin: 8,
        pager: false,
        moveSlide: 1,
        nextSelector: '#img_preview_prev',
        prevSelector: '#img_preview_next',
        nextText: '<img src="' + site_url + 'assets/itruemart_new/images/product_preview_prv.jpg" alt="" />',
        prevText: '<img src="' + site_url + 'assets/itruemart_new/images/product_preview_next.jpg" alt="" />',
        infiniteLoop: true,
        moveSlides: 1
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

    $('.time_group').each(function() {
        var timeDiv = $(this);

        $(this).countdown({
            until: timeDiv.attr('data-time'),
            format: 'dHMs',
            layout: '<div class="day">'
                    + '<div class="time_number">{d10}</div>'
                    + '<div class="time_number">{d1}</div>'
                    + '<div class="time_text">d</div>'
                    + '</div>'
                    + '<div class="time_space"></div>'
                    + '<div class="day">'
                    + '<div class="time_number">{h10}</div>'
                    + '<div class="time_number">{h1}</div>'
                    + '<div class="time_text">h</div>'
                    + '</div>'
                    + '<div class="time_space"></div>'
                    + '<div class="day">'
                    + '<div class="time_number">{m10}</div>'
                    + '<div class="time_number">{m1}</div>'
                    + '<div class="time_text">m</div>'
                    + '</div>'
                    + '<div class="time_space"></div>'
                    + '<div class="day">'
                    + '<div class="time_number">{s10}</div>'
                    + '<div class="time_number">{s1}</div>'
                    + '<div class="time_text">s</div>'
                    + '</div>'
        });
    });

    $('.add_cart').live('click', function(event) {
        event.preventDefault();
    });

    $('.add_now').live('click', function(event) {
        event.preventDefault();
    });

    $('.list_product_upcoming').mouseover(function() {
        $(this).siblings().find('.today_name').css('visibility', 'hidden');
        $(this).children().css('visibility', 'visible');
    }).mouseleave(function() {
        $(this).children('.today_name').css('visibility', 'hidden');
    });

    $('.product-brand-bxslider').bxSlider({
        minSlides: 2,
        maxSlides: 2,
        moveSlides: 1,
        mode: 'vertical',
        infiniteLoop: true,
        touchEnabled: true,
        oneToOneTouch: true,
        pager: false
    });

});
