if (!('APP' in window)) {
    window.APP = {};
}

if (!('APP.itm' in window)) {
    window.APP.itm = {};
}

(function(itm, $, undefined) {

    itm.ieFixes = function() {

        var controller = {
            inputForm: $('input[placeholder], textarea[placeholder]')
        }

        var self;

        if ($.browser.msie && $.browser.version.substr(0, 1) < 9) {
            if (controller.inputForm.val().length == 0)
                controller.inputForm.val(controller.inputForm.attr('placeholder'));

            controller.inputForm.on('focus', function() {
                self = $(this);
                if (self.val() == self.attr('placeholder')) {
                    self.val('');
                }
            }).on('blur', function() {
                self = $(this);
                if (self.val().length == 0) {
                    self.val(self.attr('placeholder'));
                }
            });
        }
    }

    itm.imageLazyLoad = function() {
        $('img.lazyload').lazyload({
            threshold: 200,
            effect: 'fadeIn'
        });
    }

    itm.bannerMove = function() {
        var controller = {

            navBanner: $('.header__nav_banner'),
            settings: {
                duration: 650,
                ease: 'easeOutQuad',
                distance: '5px'
            },

            _animate: function() {

                var self = this;

                if (location.href.indexOf('everyday-wow') > 0) {
                    return;
                }

                self.navBanner.animate({
                    right: self.settings.distance
                }, self.settings.duration, self.settings.ease, function() {
                    self.navBanner.animate({
                        right: 0
                    }, self.settings.duration, self.settings.ease, function() {
                        self._animate();
                    })
                })
            }
        }

        /*controller._animate();*/
    }

    itm.countdown = function() {

        var _idx;
        var _format;
        var _btnDisabled;
        var _boxExpire;
        var _bgWrapper;
        var _totalhour;
        var _status;

        var controller = {

            countdown: '[data-countdown]',
            current: '[data-current]',
            dailyDeal: $('.daily-deal'),
            excludeClass: 'registered-countdown',
            dailyDealAmount: function() {
                return this.dailyDeal.find(this.countdown).length;
            },
            hashTag: '',
            setHashTag: function(name) {
                return this.hashTag += name;
            }
        }

        $(controller.countdown).not(controller.excludeClass).each(function(idx) {
            if ( $(this).hasClass(controller.excludeClass) ) return;
            $(this).addClass(controller.excludeClass);

            var _self = $(this),
                finalDate = _self.data('countdown'),
                eventType = _self.data('eventtype');

            _self.countdown(finalDate, function(event) {
                _totalhour = event.offset.totalDays * 24 + event.offset.hours;
                _format = _totalhour + '<span class="cln">:</span>%M<span class="cln">:</span>%S';
                $(this).html(event.strftime(_format) +' '+ __('hour_txt'));
            }).on('finish.countdown', function(event) {

                if (eventType == 'open') {
                    var url = location.href;
                    var url_refresh = (url.indexOf('?') > 0 ? url.split('?')[0] : url) + '?frefresh=1&rand='+Math.floor(Math.random() * 9999)+1001;
                    var finalDateCountDown = (new Date(finalDate)).getTime()+90000;
                    setInterval(function(){
                        var now = new Date();
                        if (now.getTime() > finalDateCountDown)
                        {
                            window.location = url_refresh;
                        }
                    }, 30000);
                }
                else {
                    _btnDisabled = $('<span class="btn-disabled"></span>').text(__('promotion_text'));
                    _boxExpire = $('<div class="box-action-disabled"></div>').append(_btnDisabled);
                    _bgWrapper = $('<div class="bg-wrapper"></div>');

                    if ( ! _self.parents(".sd-product-info").hasClass('.disabled')) {
                        _self.parents(".sd-product-info")
                            .addClass('disabled')
                            .append(_bgWrapper)
                            .append(_boxExpire);
                    }

                    setTimeout(function() {
                        window.location.href = (window.location.href.indexOf('?') > 0 ? window.location.href.split('?')[0] : window.location.href) + '?_=' + Math.random();
                    }, 60000);
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
            headerBanner: $('.header__nav_banner'),

            isVisible: function() {
                return this.headerSidebar.is(':visible');
            },
            isFloat: false,
            settings: {
                opacity: 0,
                duration: 200
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
                var self = this;

                if (!('ontouchstart' in document)) {

                    self.isFloat = (docScrollTop >= bgNavPos.top && bgNavPos.top >= (searchBarPos.top + searchBarHeight));

                    if (self.isFloat) {
                        if (!self.headerBgNav.hasClass('pos-fixed-desktop')) {
                            self.headerBgNav.addClass('pos-fixed-desktop')
                                .next()
                                .css({
                                    marginTop: self.headerBgNav.height()
                                });
                        }
                        if (self.isVisible()) {
                            self.headerSidebar.slideUp('fast');
                            // self.headerBanner.stop().animate({
                            //     top: '-50px'
                            // }, {
                            //     duration: 'fast',
                            //     complete: function() {
                            //         self.headerBanner.hide();
                            //     }
                            // });
                        }
                    } else if (docScrollTop <= (searchBarPos.top + searchBarHeight)) {
                        this.headerBgNav.removeClass('pos-fixed-desktop')
                            .next()
                            .css({
                                marginTop: 0
                            });
                    }
                }
            },

            _sidebarHover: function(ev) {
                var self = $(ev.target);
                this.headerSidebar.css({
                    width: self.is('[data-id]') || self.closest('.sidebar_group').length ? '100%' : 'auto'
                });
            }
        }

        controller.headerSidebar.on('mouseover', function(ev) {
            controller._sidebarHover(ev);
        });

        controller.navigateCategory.on('click touchstart', function(event) {
            controller._slide(event);
        });

        $('.sidebar_1 > li').on('mouseover touchstart', function(e) {
            e.preventDefault();

            if ('ontouchstart' in window) {
                if ($(this).hasClass('active')) {
                    var url = $(this).find('> a').attr('href');
                    window.location.href = url;
                }
            }

            $('.sidebar_1 > li').removeClass('active');
            $(this).addClass('active');
            controller.headerSidebar.css({
                width: '100%'
            });

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
            if ('ontouchstart' in window) {
                if (controller.accordionBanner.index(this) != controller.idx)
                    e.preventDefault();
            }
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
                pagination: false,
                responsive: false
            });
            $('.productCarousel__navigate_prev').on('click touchstart', function(e) {
                e.preventDefault();
                owl.trigger('owl.prev');
            });
            $('.productCarousel__navigate_next').on('click touchstart', function(e) {
                e.preventDefault();
                owl.trigger('owl.next');
            });

            $('.productCarousel__container').find('a').on('click touchstart', function(ev) {
                ev.preventDefault();
                var zoomLarge = $(this).find('img').data('zoom-large');
                $('#product_image').attr('data-zoom-image', zoomLarge)
                    .find('img').attr('src', zoomLarge).attr('data-original', zoomLarge);

                $('#product_image').removeData('zoom-image');
            });
        }

        var hilightBanner = $('.hilight_banner');
        hilightBanner.owlCarousel({
            singleItem: true,
            slideSpeed: 500,
            autoPlay: true,
            //autoPlay: 60000,
            items: 4,
            paginationNumbers: true,
            stopOnHover: true
        });
    }

    itm.stepper = function() {
        $("input[type='number']").stepper();
    }

    itm.productPaymentList = function() {
        var controller = {

            paymentList: $('.productPayment_list'),

            _hover: function() {

                var ctrl = this;

                this.paymentList.find('li').on('mouseover touchstart', function(e) {
                    ctrl.paymentList.find('li > div').removeAttr('style');
                    $(this).find('div').css({
                        display: 'inline-block',
                        height: '30px'
                    });
                }).on('mouseout touchend',function(e){
                    $(this).find('div').css({display: 'none'});
                });
            }
        }

        controller._hover();
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

        // if (!('ontouchstart' in window)) {
        controller._init();
        // }
    }

    itm.sharrre = function() {
        $('#share').sharrre({
            share: {
                twitter: true,
                facebook: true,
                googlePlus: true
            },
            template: '<ul class="productSocial_list">' + '<li>' + '<img src="/themes/itruemart/assets/images/icn/social_fb.jpg" class="facebook" />' + '</li>' + '<li>' + '<img src="/themes/itruemart/assets/images/icn/social_tweet.jpg" class="twitter" />' + '</li>' + '<li>' + '<img src="/themes/itruemart/assets/images/icn/social_g.jpg" class="googleplus" />' + '</li>' + '<li>' + '<span class="productSocial_total">{total}</span>' + '</li>' + '<li>' + '<span class="productSocial_share">' + 'share<br/>this page' + '</span>' + '</li>' + '</ul>',
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

        // var interval;
        // if (!$('.productSocial_total').length) {
        //     interval = setInterval(function() {
        //         var productSocialTotal = $('.productSocial_total');
        //         if (productSocialTotal.length) {
        //             if (productSocialTotal.text() == '0') {
        //                 var defaultTotal = $('#share').attr('rel');
        //                 productSocialTotal.text(defaultTotal);
        //             }
        //             clearInterval(interval);
        //         }
        //     }, 1000);
        // }
    }

    itm.campaignBanner = function() {

        var controller = {

            campaignBanner: $('.campaign_banner'),
            breadcrumb: $('.breadcrumb__bg'),
            productInfo: $('.product__info'),
            self: this,

            _setPosition: function() {
                if (!this.campaignBanner.length) {
                    this.breadcrumb.css({
                        backgroundColor: 'transparent',
                        height: 'auto'
                    });

                    this.productInfo.addClass('default_pos');
                } else {

                    // var img = this.campaignBanner.find('img');

                    // img.on('ab-color-found', function(e, data) {
                    //     controller.breadcrumb.css({
                    //         backgroundColor: data.color
                    //     });
                    // });

                    // $.adaptiveBackground.run();
                }
            },

            _init: function() {
                this._setPosition();
            }
        }

        controller._init();
    }

    itm.zoom = function() {

        $('#product_image').on('click touchstart', function() {

            var self = $(this);

            if (self.data('events').zoom != undefined)
                return;

            self.css({
                width: '910px',
                height: self.height(),
                border: 'solid 1px #ddd',
                position: 'relative',
                zIndex: 51,
                backgroundColor: '#fff'
            }).find('img').hide().end().zoom({
                url: self.data('zoom-image'),
                callback: function() {
                    $(this).animate({
                        opacity: 1
                    }).css({
                        cursor: 'url(/themes/itruemart/assets/images/icn/mag-minus.png), auto'
                    });
                },
                onZoomOut: function() {
                    self.trigger('zoom.destroy').removeAttr('style').find('img').show();
                }
            });
        });

        $(document).on('click', '.zoomImg', function(e) {
            $('#product_image').trigger('zoom.destroy').removeAttr('style').css({
                cursor: 'url(/themes/itruemart/assets/images/icn/mag-plus.png), auto'
            }).find('img').show();
        });

        $(document).on('touchstart', function(e) {
            if (!$(event.target).closest('#product_image').length) {
                $('#product_image').trigger('zoom.destroy').removeAttr('style').find('img').show();
            }
        });
    }

    itm.initShowroom = function() {
        if($(".showroom-container").length <= 0) {
            return false;
        }

        var _template = _.template($('#single-showroom-template').html());

        LazyContent.init({
            item: 'showroom-container',
            displayed: 'displayed',
            onRender: function(elem, response) {
                elem.html(_template(response));
                elem.removeClass('loading');
            }
        });
    };

    itm.init = function() {

        for (var key in itm) {
            if (key !== 'init') {
                itm[key]();
            }
        }

    };

})(window.APP.itm, jQuery);

jQuery(function($) {
    APP.itm.init();

});