$(function() {
    $('.checkout-info.full > sup, .checkout-info.full > span, .cart-wrapper').on('mouseenter touchstart', function() {
        $('.cart-wrapper').show();
    }).on('mouseleave', function() {
        $('.cart-wrapper').hide();
    });

    $('#sidemenu').SideMenu();
    $('.product-box li').ViewProduct();
    $('.modeling').ModelMenu();
    $('a[rel^="slideDescription"]').SlideDescription();
    if ($("a[rel^='prettyPhoto']").length) {
        $("a[rel^='prettyPhoto']").prettyPhoto({
            opacity: 0.4,
            social_tools: false
        });
    }

    levelBFunctions();
    LevelDFunctions();
    CheckoutFunctions();
    ProfileFunction();
    ManualFunciton();
    InsightFunction();

    var defaultTitle = '';
    $('.category-menu > li > a').bind('touchstart', function(event) {
        var title = $(this).attr('title');
        if (defaultTitle != title) {
            event.stopPropagation();
            event.preventDefault();
            defaultTitle = title;
        }
    });

    if ($('.category-banner').length) {
        var categoryBanner = $('.category-banner').bxSlider({
            auto: true,
            autoHover: true,
            preloadImages: 'visible',
            pause: 2000,
            onSliderLoad: function() {
                $('.category-banner').each(function(idx) {
                    $(this).css('-webkit-transition', (idx * 5) + 's').css('transition', (idx * 10) + 's');
                    var amount = $(this).find('li').length - 2;
                    $(this).parents('.bx-wrapper').find('.bx-next').css({left: (amount * 20 + 30) + 'px'});
                });
            }
        });
    }
});



(function($) {
    $.fn.SideMenu = function(options) {

        var defaults = {
            sideMenu: this,
            content: '.content-home',
            contentMenu: '.category-menu',
            anchor: '.header-container a:eq(0)',
            footer: '.footer'
        };

        var settings = $.extend({}, defaults, options);

        return this.each(function() {

            $(settings.sideMenu).children('a').attr('href', 'javascript:;');
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
           
            //Only show sidemenu if page is insight
            if ($(settings.content).hasClass('insight'))
                return;

            var winHeight = $(window).height();
            var $sidemenu = $(settings.sideMenu);
            var $anchor = $(settings.anchor);
            var $contentmenu = $(settings.contentMenu);
            var contentMenuHeight = $contentmenu.height();
            var sidemenuHeight = $sidemenu.height() + contentMenuHeight;
            var contentHeight = $(settings.content).height();
            var footerPosition = $(settings.footer).position();
            var sidePosLeft = $anchor.position().left;

            $(window).resize(function() {
                winHeight = $(window).height();
                if (winHeight < sidemenuHeight) {
                    $sidemenu.removeClass('fix-menu');
                }
                sidePosLeft = $anchor.position().left;
                $sidemenu.css({left: sidePosLeft + 'px'});
            }).on('zoom', function() {
                $sidemenu.css({left: sidePosLeft + 'px'});
            }).scroll(function() {
                if (winHeight < sidemenuHeight) {
                    return;
                }

                var documentTop = $(document).scrollTop();
                var documentLeft = $(document).scrollLeft();
                if (documentTop > 145) {
                    $sidemenu.addClass('fix-menu').css({left: sidePosLeft + 'px'}).attr('data-role', 'header').attr('data-position', 'fixed').stop(true, true).fadeIn('fast');
                } else {
                    $sidemenu.removeClass('fix-menu').removeAttr('data-role').removeAttr('data-position').removeAttr('style').show();
                }

                var incMenu = 0;
                if (sidemenuHeight > winHeight / 2)
                    incMenu = sidemenuHeight - (winHeight / 2);

                if (documentTop + incMenu > footerPosition.top || (documentLeft > 9 && documentTop > 145)) {
                    $sidemenu.stop(true, true).fadeOut('fast').removeClass('fix-menu');
                }

//                var debug = '<div id="debug" style="position: fixed; bottom: 0; right: 0; width: 300px; height: 100px; background-color: #fff;"></div>';
//                if ($('#debug').length === 0)
//                    $('body').append(debug);
//
//                $('#debug').prepend($(window).height() + ':' + sidemenuHeight + ':' + footerPosition.top + '<br/>');

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

            $(settings.productBox).on('touchstart', function(event) {
                var $this = $(this);
                var title = $(this).attr('title');
                if (defaultTitle != title) {
                    $this.parents(settings.productParent).find('li').removeClass('active');
                    $this.addClass('active');
                    event.stopPropagation();
                    event.preventDefault();
                    defaultTitle = title;
                    $this.find('a').append('_c');
                }
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
    $.fn.ModelMenu = function() {

        var defaults = {
            model: this,
            subMenu: 'sub-categories-view',
            headerSubOfSub: 'header-view'
        };

        var settings = $.extend({}, defaults, settings);

        return this.each(function() {
            var subOfSubAmount = $(settings.headerSubOfSub).length;
            $(settings.model).parents('.' + settings.subMenu).find('li:eq(1)').after($(settings.model).parent().slice(subOfSubAmount).html());
        });
    };
    
    $.fn.InsightPane = function(){
        return this.each(function(){
            var $this = $(this);
            $this.find('li').on('mouseover',function(){
                $.each($this.find('li'), function(){
                    $(this).removeClass('active').find('em').remove();
                });
                var name = $(this).find('a').attr('href');
                var $container = $(this).addClass('active').find('a').prepend('<em>INSIGHT </em>').parents('.insight-news');
                $.each($container.find('.tab-pane'), function(){
                    $(this).removeClass('active');
                });
                $(name).addClass('active');
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

var LevelDFunctions = function() {
    if ($('#related_product').length) {
        $('#related_product').bxSlider({
            auto: true,
            autoHover: true,
            preloadImages: 'visible',
            pause: 3000,
            pager: false,
            slideWidth: 530,
            prevSelector: '#r_back',
            nextSelector: '#r_next',
            prevText: '',
            nextText: ''
        });
    }
    if ($('#similar_product').length) {
        $('#similar_product').bxSlider({
            auto: true,
            autoHover: true,
            preloadImages: 'visible',
            pause: 3000,
            pager: false,
            slideWidth: 530,
            prevSelector: '#s_back',
            nextSelector: '#s_next',
            prevText: '',
            nextText: ''
        });
    }

    $("#comment").click(function() {
        $('.product_tab_comment').removeClass('selected');
        $(this).addClass('selected');
        $('#product_tab_comment_text,#review_policy').hide();
        $('#product_tab_comment_text').show();
    });

    $('.product_tab_comment').on('click', function() {
        var $this = $(this);
        var id = $this.attr('id');
        $('.product_tab_comment').removeClass('selected');
        $this.addClass('selected');
        if (id === 'policy') {
            $('#product_tab_comment_text').hide();
            $('#review_policy').show();
        } else {
            $('#product_tab_comment_text').show();
            $('#review_policy').hide();
        }
    });

    $('a.product_service_name').on('click', function() {
        $('.product_tab_comment').removeClass('selected');
        $('#policy').addClass('selected');

        $('#review_comment').hide();
        $('#review_policy').show();
    });
};

var CheckoutFunctions = function() {
    $('.payment-channel > label, .payment-channel > input[type="radio"]').click(function() {
        var remarkLen = $('.add-remark').length;
        var $remark = $(this).parent().find('.add-remark');
        if ($remark.is(':visible'))
            return;

        $(this).parent().find('input[type="radio"]').attr('checked', 'checked');
        $('.add-remark').slideUp().parent().removeClass('divider-menu-active');
        $remark.slideDown().parent().addClass('divider-menu-active');
    });
    if ($('input.qty').length)
        $('input.qty').stepper();
};

var ManualFunciton = function() {
    var manual_url = document.URL;
    var res = manual_url.split("#");
    if (res[1] != undefined)
    {
        var show_id = "#" + res[1];
        if ($(".payment-channel a[href=" + show_id + "]").val() != undefined)
        {
            $(".payment-channel a[href=" + show_id + "]").tab('show');
            $('.payment-channel li').removeClass('selected');
            $(".payment-channel a[href=" + show_id + "]").parent().addClass('selected');
        }
        else
        {
            $(".payment-channel a[href=#atm]").tab('show');
            $('.payment-channel li').removeClass('selected');
            $(".payment-channel a[href=#atm]").parent().addClass('selected');
        }
    }

    $('.how-to-checkout a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $('.payment-channel a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
        $('.payment-channel li').removeClass('selected');
        $(this).parent().addClass('selected');
    });

    var idx_navi = 0;
    var btnNavi = 'div#navigation ul li a';
    $(btnNavi).click(function(event) {
        $(this).addClass('actived');
        $(btnNavi).eq(idx_navi).removeClass('actived');
        idx_navi = $(this).index(btnNavi);
        $('div.search-container-xs').hide();
        switch (idx_navi) {
            case 1:
                $('div.search-container-xs').show();
                break;
        }
        event.preventDefault();
    });
};

var ProfileFunction = function() {
    $('a.toggle_item').click(function(event) {
        event.preventDefault();
        anchor = $(this);
        divSlide = anchor.parents('#total_cart').next('.slide_list');
        if (divSlide.css('display') === "none")
            divSlide.slideDown('fast');
        else
            divSlide.slideUp('fast');
    });

    $('#register_tab_wrapper > a').click(function() {
        var register_channel = '';
        var aClass = $(this).attr('class');
        var rel = $(this).attr('rel');
        $('#register_tab_wrapper > div').hide();
        $('#register_tab_wrapper > a').show();
        $('#register_tab_wrapper > div.' + aClass).show();
        $('#register_tab_wrapper > a.' + aClass).hide();

        $('#register_main_left_c > div').hide();
        $('#register_main_left_c > div.' + rel).show();

        if (rel === 'register_email') {
            register_channel = 'email';
        } else if (rel === 'register_mobile') {
            register_channel = 'mobile';
        } else if (rel === 'register_truecard') {
            register_channel = 'truecard';
        }

        $('input[name="register_channel"]').val(register_channel);
    });

};

var InsightFunction = function(){
    $('#insight-tab').InsightPane();
};

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
    
   



});



