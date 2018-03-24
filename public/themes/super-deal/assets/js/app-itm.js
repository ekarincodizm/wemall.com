$(function() {
    APP.itm.init();
});

var APP = APP || {};

APP.itm = function() {
    //Fixed IE

    function ieFixes() {
        if ($.browser.msie && $.browser.version.substr(0, 1) < 9) {

            var $_input;

            $('input[placeholder], textarea[placeholder]').each(function() {
                $_input = $(this);
                $_input.val($_input.attr('placeholder'))
                    .on('focus', function() {
                        if ($_input.val() == $_input.attr('placeholder')) {
                            $_input.val('');
                        }
                    })
                    .on('blur', function() {
                        if ($_input.val() == '') {
                            $_input.val($_input.attr('placeholder'));
                        }
                    });
            });
        }
    }

    //Image lazyload
    function imageLazyLoad() {
        $('img.lazyload').lazyload({
            threshold: 200,
            effect: 'fadeIn'
        });
    }

    //Count down
    function countdown() {

        var _idx;
        var _format;
        var _btnDisabled;
        var _boxExpire;
        var _bgWrapper;
        var _totalhour;

        $('[data-countdown]').each(function() {
            finalDate = $(this).data('countdown');
            _idx = $('[data-countdown]').index(this);
            $(this).countdown(finalDate, function(event) {
                _totalhour = event.offset.totalDays * 24 + event.offset.hours;
                _format = _totalhour + '<span class="cln">:</span>%M<span class="cln">:</span>%S';
                $(this).html(event.strftime(_format) + ' ชม.');
            }).on('finish.countdown', function(event) {
                if (_idx == 0) {
                    return;
                }

                _btnDisabled = $('<span class="btn-disabled"></span>').text('หมดโปรโมชั่น');
                _boxExpire = $('<div class="box-action-disabled"></div>').append(_btnDisabled);
                _bgWrapper = $('<div class="bg-wrapper"></div>');

                if (!$(this).closest('.sd-product-info').is('.disabled')) {
                    $(this).closest('.sd-product-info')
                        .addClass('disabled')
                        .append(_bgWrapper)
                        .append(_boxExpire);
                }
            });
        });
    }

    function navigationBar() {

        var $_navigateBar = $('.header__bg_nav'),
            $_searchBar = $('.header__bg_search'),
            _searchBarPos = $_searchBar.offset(),
            _navigateBarPos = $_navigateBar.offset();
        var _scroll,
            _scrollPos;
        var _mobile = ('ontouchstart' in document),
            _float;

        _scroll = (function(e) {
            //if (!_mobile) {

            _scrollPos = $(document).scrollTop();
            _float = (_scrollPos > _navigateBarPos.top);

            if (_float) {
                $_navigateBar.addClass('pos-fixed-desktop')
                    .next()
                    .css({
                        marginTop: $_navigateBar.height()
                    });
            } else if (_scrollPos <= (_searchBarPos.top + $_searchBar.height())) {
                $_navigateBar.removeClass('pos-fixed-desktop')
                    .next()
                    .css({
                        marginTop: 0
                    });
            }
            //}
        });

        $(document).on('scroll touchmove', _scroll).trigger('resize');

    }

    function sidebar() {

        var $_navigateCategory = $('.header__nav_category');
        var $_sidebar = $('.header__sidebar');
        var $_sidebar1 = $('.sidebar_1');
        var $_sidebarColumn;
        var _fade, _settings = {};
        var _visible;

        _settings.duration = 200;

        $_sidebar.find('[class^="sidebar_"] li').css({
            opacity: 0
        });

        _fade = function(_element, _settings, callback) {
            $(_element).find('[class^="sidebar_"] li')
                .animate({
                    opacity: _settings.opacity
                }, {
                    duration: _settings.duration
                }, callback);
        };

        $_navigateCategory.on('click touchstart', function(e) {
            e.preventDefault();
            $_sidebar.stop().slideToggle(function() {

                _visible = $(this).is(':visible');
                _settings.opacity = (_visible ? 1 : 0);

                _fade(this, _settings, function() {
                    alert('ok');
                    if (!_visible) {
                        $('.sidebar_2, .sidebar_3, .sidebar_4').removeClass('cate-active');
                    }
                });
            });
        });

        $_sidebar1.find('li > a').on('hover touchstart', function(e) {
            e.preventDefault();
            $('.sidebar_2, .sidebar_3, .sidebar_4').addClass('cate-active');
        });
    }

    return {
        init: function() {
            ieFixes();
            imageLazyLoad();
            countdown();
            navigationBar();
            sidebar();
        }
    }
}();