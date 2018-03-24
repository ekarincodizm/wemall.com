if (!('APP' in window)) {
    window.APP = {};
}

if (!('APP.itm' in window)) {
    window.APP.itm = {};
}

(function(itm, $, undefined) {

    itm.ieFixes = function() {

        var input;

        if ($.browser.msie && $.browser.version.substr(0, 1) < 9) {
            $('input[placeholder], textarea[placeholder]').each(function() {
                input = $(this);
                input.val(input.attr('placeholder'))
                    .on('focus', function() {
                        if (input.val() == input.attr('placeholder')) {
                            input.val('');
                        }
                    })
                    .on('blur', function() {
                        if (input.val() == '') {
                            input.val(input.attr('placeholder'));
                        }
                    });
            });
        }
    }

    itm.imageLazyLoad = function() {
        $('img.lazyload').lazyload({
            threshold: 200,
            effect: 'fadeIn'
        });
    }

    itm.countdown = function() {

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
                $(this).html(event.strftime(_format) + ' ' + __("hour_txt"));
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

    itm.navigationbar = function() {

        var controller = {

            navigateCategory: $('.header__nav_category'),
            headerSidebar: $('.header__sidebar'),
            headerBgNav: $('.header__bg_nav'),
            headerBgSearch: $('.header__bg_search'),

            isVisible: function() {
                return this.headerSidebar.is(':visible');
            },
            isFloat: false,
            settings: {
                opacity: 0,
                duration: 200,
            },

            _slide: function(e) {

                var ctrl = this;

                e.stopPropagation();
                e.preventDefault();

                if (this.isVisible()) {
                    this.headerSidebar.find('[class^="sidebar_"] li').css({
                        opacity: 0
                    });
                }

                this.headerSidebar.stop(true, false).slideToggle(this.settings.duration, function() {

                    var self = this;

                    ctrl.settings.opacity = (ctrl.isVisible() ? 1 : 0);
                    ctrl._fade(self, ctrl.settings, function() {
                        if (ctrl.isVisible()) {
                            $('[class^="sidebar_"]:not(:first-child)').removeClass('cate-active');
                        }
                    });
                });
            },

            _fade: function(_element, _settings, _callback) {
                $(_element).find('[class^="sidebar_"] li')
                    .animate({
                        opacity: _settings.opacity
                    }, {
                        duration: _settings.duration,
                        complete: _callback
                    });
            },

            _scroll: function(e) {

                var docScrollTop = $(document).scrollTop();
                var bgNavPos = this.headerBgNav.offset();
                var searchBarHeight = this.headerBgSearch.height();
                var searchBarPos = this.headerBgSearch.offset();

                if (!('ontouchstart' in document)) {

                    this.isFloat = (docScrollTop >= bgNavPos.top && bgNavPos.top >= (searchBarPos.top + searchBarHeight));

                    if (this.isFloat) {
                        if (!this.headerBgNav.hasClass('pos-fixed-desktop')) {
                            this.headerBgNav.addClass('pos-fixed-desktop')
                                .next()
                                .css({
                                    marginTop: this.headerBgNav.height()
                                });
                        }
                        if (this.isVisible()) {
                            this.headerSidebar.slideUp('fast');
                        }
                    } else if (docScrollTop <= (searchBarPos.top + searchBarHeight)) {
                        this.headerBgNav.removeClass('pos-fixed-desktop')
                            .next()
                            .css({
                                marginTop: 0
                            });
                    }
                }
            }
        }

        controller.navigateCategory.on('click touchstart', function(event) {
            controller._slide(event);
        });

        $(document).on('scroll touchmove', function(e) {
            controller._scroll(e);
        }).trigger('resize');

    }

    itm.accordionBanner = function() {

        var controller = {

            idx: -1,

            accordionBanner: $('[class^="ac_banner_"]'),

            _slide: function(element) {

                var obj = $(element);

                $.fn._animate = function(custom) {

                    var defaultOptions = {
                        duration: 'fast',
                        easing: 'linear',
                        posLeft: 0
                    }

                    var options = $.extend({}, defaultOptions, custom);

                    return this.each(function() {
                        var self = $(this);
                        self.animate({
                            left: options.posLeft
                        }, options.duration, options.easing);
                    });
                }

                this.idx = obj.index();
                if (this.idx == 0) {
                    obj.next().stop()._animate({
                        posLeft: '582px'
                    }).next().stop()._animate({
                        posLeft: '766px'
                    });
                } else if (this.idx == 2) {
                    obj.stop()._animate({
                        posLeft: '366px'
                    }).prev().stop()._animate({
                        posLeft: '182px'
                    });
                } else {
                    if (obj.next().hasClass('open')) {
                        obj.next().stop()._animate({
                            posLeft: '766px'
                        });
                    } else {
                        obj.stop()._animate({
                            posLeft: '182px'
                        });
                    }
                }

                $('[class^="ac_banner_"]').removeClass('open');
                obj.addClass('open');
            }
        };

        controller.accordionBanner.on('mouseover touchstart', function(e) {
            controller._slide(this);
        });
    }

    itm.productSlider = function() {
        var owl = $(".productCarousel__container");
        if (owl.length) {
            owl.owlCarousel({
                items: 5,
                scrollPerPage: true,
                slideSpeed: 500,
                paginationSpeed: 500,
                pagination: false
            });
            $('.productCarousel__navigate_prev').on('click', function(e) {
                e.preventDefault();
                owl.trigger('owl.prev');
            });
            $('.productCarousel__navigate_next').on('click', function(e) {
                e.preventDefault();
                owl.trigger('owl.next');
            });
        }

        var hilightBanner = $('.hilight_banner');
        hilightBanner.owlCarousel({
            singleItem: true,
            slideSpeed: 500
        });
    }

    itm.stepper = function() {
        $("input[type='number']").stepper();
    }

    itm.animateTop = function() {

        var controller = {

            settings: {
                maxLimit: 200,
                speed: 500
            },

            doc: $(document),
            html: $('html, body'),
            anchor: $('.productScrolltop'),

            _scroll: function() {
                if ((this.doc.scrollTop() > this.settings.maxLimit)) {
                    this.anchor.fadeIn();
                } else {
                    this.anchor.fadeOut();
                }
            },

            _init: function() {

                var ctrl = this;

                this.doc.on('scroll', function() {
                    ctrl._scroll();
                });

                this.anchor.on('click', function(e) {
                    e.preventDefault();
                    ctrl.html.animate({
                        scrollTop: 0
                    }, ctrl.settings.speed, 'swing');
                });
            }
        }

        controller._init();
    }

    itm.sharrre = function() {
        $('#share').sharrre({
            share: {
                twitter: true,
                facebook: true,
                googlePlus: true
            },
            template: '<ul class="productSocial_list">' + '<li>' + '<img src="images/icn/social_fb.jpg" class="facebook" />' + '</li>' + '<li>' + '<img src="images/icn/social_tweet.jpg" class="twitter" />' + '</li>' + '<li>' + '<img src="images/icn/social_g.jpg" class="googleplus" />' + '</li>' + '<li>' + '<span class="productSocial_total">{total}</span>' + '</li>' + '<li>' + '<span class="productSocial_share">' + 'share<br/>this page' + '</span>' + '</li>' + '</ul>',
            enableHover: false,
            enableTracking: true,
            render: function(api, options) {
                $(api.element).on('click', '.twitter', function() {
                    api.openPopup('twitter');
                });
                $(api.element).on('click', '.facebook', function() {
                    api.openPopup('facebook');
                });
                $(api.element).on('click', '.googleplus', function() {
                    api.openPopup('googlePlus');
                });
            }
        });
    }

    itm.campaignBanner = function() {

        var controller = {

            campaignBanner: $('.campaign_banner'),
            breadcrumb: $('.breadcrumb__bg'),
            productInfo: $('.product__info'),

            _setPosition: function() {
                if (!this.campaignBanner.length) {
                    this.breadcrumb.css({
                        backgroundColor: 'transparent',
                        height: 'auto'
                    });

                    this.productInfo.addClass('default_pos');
                }
            },

            _init: function() {
                this._setPosition();
            }
        }

        controller._init();
    }


    itm.init = function() {
        itm.ieFixes();
        itm.imageLazyLoad();
        itm.countdown();
        itm.navigationbar();
        itm.accordionBanner();
        itm.productSlider();
        itm.stepper();
        itm.animateTop();
        itm.sharrre();
        itm.campaignBanner();
    };


})(window.APP.itm, jQuery);

jQuery(function($) {
    APP.itm.init();
});