$(function() {
    $('.checkout-info.full > sup, .checkout-info.full > span, .cart-wrapper').on('mouseenter touchstart', function() {
        $('.cart-wrapper').show();
    }).on('mouseleave', function() {
        $('.cart-wrapper').hide();
    });

    $('#sidemenu').SideMenu();

    // Stop propagation to make better feeling.
    $('#sidemenu .category-menu a').on('click', function(e){
        e.stopPropagation();
    });

    $('.product-box li').ViewProduct();

    $('a[rel^="slideDescription"]').SlideDescription();

    if ($("a[rel^='prettyPhoto']").length > 0) {
        $("a[rel^='prettyPhoto']").prettyPhoto({
            opacity: 0.4,
            social_tools: false
        });
    }

    levelBFunctions();

    var categoryBanner = $('.category-banner').bxSlider({
        auto: true,
        autoHover: true,
        preloadImages: 'visible',
        pause: 2000
    });
});

(function($) {
    $.fn.SideMenu = function(options) {

        var defaults = {
            sideMenu: this,
            sideMenuOrigin: '.navbar',
            content: '.content-home',
            contentMenu: '.category-menu'
        };

        var settings = $.extend({}, defaults, options);

        return this.each(function() {

            if ($(settings.content).length === 0)
                return;

            if ($(settings.content).hasClass('sub') || $(settings.content).hasClass('checkout')) {
                $(settings.sideMenu).on('click', function() {
                    //event.preventDefault();
                    $(settings.contentMenu).toggle();
                });
                return;
            }

            $(settings.contentMenu).show();

            var winHeight = $(window).height();
            var $sidemenu = $(settings.sideMenu);
            var sideMenuOriginOffset = $(settings.sideMenuOrigin).offset().top;
            var $contentmenu = $(settings.contentMenu);
            var contentMenuHeight = $contentmenu.height();
            var sidemenuHeight = $sidemenu.height() + contentMenuHeight;
            var contentHeight = $(settings.content).height();

            $(window).resize(function() {
                winHeight = $(window).height();
                if (winHeight < sidemenuHeight) {
                    $sidemenu.removeClass('fix-menu');
                }
            }).scroll(function() {
                if (winHeight < sidemenuHeight) {
                    return;
                }

                var documentTop = $(document).scrollTop();
                if (documentTop > sideMenuOriginOffset) {
                    $sidemenu.addClass('fix-menu').stop(true, true).fadeIn('fast');
                } else {
                    $sidemenu.removeClass('fix-menu');
                }

                if (contentHeight - documentTop < -300) {
                    $sidemenu.stop(true, true).fadeOut('fast').removeClass('fix-menu');
                }
            });
        });
    };

    $.fn.ViewProduct = function(options) {

        var defaults = {
            productBox: this,
            productParent: '.product-box'
        };

        var settings = $.extend({}, defaults, options);

        return this.each(function() {
            $(settings.productBox).on('mouseover', function() {
                $(this).parents(settings.productParent).find('li').removeClass('active');
                $(this).addClass('active');
            });
        });
    };

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
        };

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

    $.fn.SlideDescription = function() {

        var defaults = {
            banner: this,
            description: 'banner-desc'
        };

        var settings = $.extend({}, defaults, settings);

        return this.each(function() {
            $(settings.banner).hover(function() {
                $(this).find('.' + settings.description).slideDown('fast');
            }, function() {
                $(this).find('.' + settings.description).stop(true, false).slideUp('fast');
            });
        });
    };
})(jQuery);

var levelBFunctions = function() {
    var $brandstory = $('div.brandstory_options');
    var $brandlist = $('div.brandlist_options');
    var $sizelist = $('div.sizelist_options');
    if ($brandstory.length > 0) {
        $brandstory.slimScroll({
            height: '72px',
            size: '14px',
            railVisible: true,
            alwaysVisible: true
        });
    }
    if ($brandlist.length > 0 || $sizelist.legth > 0) {
        $('div.brandlist_options, div.sizelist_options').slimScroll({
            width: '249px',
            height: '107px',
            size: '14px',
            railVisible: true,
            alwaysVisible: true
        });
    }
};

