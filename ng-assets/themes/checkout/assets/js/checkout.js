$(function() {
    //$('.box-popup-regis').modal('show');
    app.checkout.init();
});

if (!('app' in window)) {
    window.app = {};
}

if (!('app.checkout' in window)) {
    window.app.checkout = {};
}

(function() {
    app.checkout.init = function() {
        (function(settings) {
            settings.cart();
            settings.login();
            settings.address();
            settings.payment();
            settings.order_success();
        })(app.checkout.settings);
    };

    app.checkout.settings = {
        cart: function() {
            //Edit Cart
//            $('#btn-edit-cart').on('click', function() {
//                $('#cart-popup').css({overflow: 'visible'}).modal('show');
//                if ($('#cart-box-info').length === 0)
//                    $('.cart-box').wrapAll('<div id="cart-box-info"></div>');
//                //45 29 197
//                $('#cart-box-info').css({overflow: 'auto', maxHeight: $('#cart-popup').height() - 251 + 'px'});
//            });
            
            // I moved these code to cartLightboxWidget.js (Neng).
//            //Cart close
//            $('html, .cart-close').on('click', function(e) {
//                if ($(this).is('html') || $(this).is('.cart-close')) {
//                    if ($(e.target).hasClass('modal-backdrop') || $(this).is('.cart-close')) {
//                        $('#cart-popup').modal('hide');
//                    }
//                }
//            });
//
//            //Resize cart scrolling
//            $(window).bind('resize', function() {
//                $('#cart-box-info').css({overflow: 'auto', maxHeight: $('#cart-popup').height() - 214 + 'px'});
//            }).trigger('resize');
        },
        login: function() {
            $('[name="logintype"]').on('change', function() {
                $('#pwd-box').slideToggle(400);
            });
        },
        address: function() {
            //Fill address form
            $('#btn-fill-address-form, .address-edit a').on('click', function(e) {
                e.preventDefault();
                $('#fill-address-form').slideDown(400, function() {
                    var pos = $('#fill-address-form').offset();
                    var $html = $('html, body');
                    $html.animate({
                        scrollTop: pos.top
                    }, '500', 'swing', function() {
                        $('input:eq(0)', '#fill-address-form').focus();
                    });
                });
            });
            /*
            $('#province-control').on('change', function() {
                var proviceName = $('option:selected', this).text();
                var isBKK = (proviceName === 'กรุงเทพมหานคร');
                $('#district-name').text(isBKK ? __('step2-special-district') : __('step2-district'));
                $('#sub-district-name').text(isBKK ? __('step2-special-subdistrict') : __('step2-subdistrict') );
            }).trigger('change');
            */
        },
        payment: function() {
//            //True You
//            $('#auth-trueyou').on('click', function() {
//                $('#popup-trueyou').modal('show');
//            });

            $('html, .close-modal').on('click', function(e) {
                if ($(this).is('html') || $(this).is('.close-modal')) {
                    if ($(e.target).hasClass('modal-backdrop') || $(this).is('.close-modal')) {
                        $('#popup-trueyou ').modal('hide');
                    }
                }
            });

            //Select Payment
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $(e.target).parents('li').addClass('active');
            });

            //CCW select card
            $('.select-visa').on('change', function() {
                var target = $(this).attr('data-target');
                $('.credit-card-content').slideUp(400);
                $('.' + target).slideDown(400, function() {
                    $('input:eq(0)', this).focus();
                });
            }).each(function() {
                if ($(this).is(':checked')) {
                    var target = $(this).attr('data-target');
                    $('.credit-card-content').hide();
                    $('.' + target).show();
                    $('input:eq(0)', '.' + target).focus();
                }
            });

            //Select CC type
            $('#ccw-info-no').on('keyup', function() {
                if ($(this).val().length === 0)
                    return;

                var c = $(this).val().charAt(0);
                if (c === '4' || c === '5') {
                    var mTop = 0;
                    if (c === '4')
                        mTop = -26;
                    else if (c === '5')
                        mTop = 0;
                    else
                        mTop = -52;
                }
                $('.icn-cc img').css({marginTop: mTop + 'px'});
            });

                    $('.icon-success-ex a').hover(function() {
                $('.icon-success-ex .tooltip').css({
                    opacity: 1,
                    display: 'block',
                    marginTop: -1 * ($('.icon-success-ex .tooltip').height() + 25) + 'px',
                    marginLeft: -1 * (($('.icon-success-ex .tooltip').width() / 2) - 7) + 'px'
                });
                console.log($('.icon-success-ex .tooltip').height());
            }, function() {
                $('.icon-success-ex .tooltip').css({
                    display: 'none',
                    opacity: 0
                });
            });

            //Select invoice address
            $('.inv-addr').on('click', function() {
                if (!$(this).is(':checked')) {
                    $('.invoice-info').slideDown(400, function() {
                        var pos = $(this).offset();
                        var $html = $('html, body');
                        $html.animate({
                            scrollTop: pos.top
                        }, '500', 'swing', function() {
                            $('input:eq(0)', '.invoice-info').focus();
                        });
                    });
                } else {
                    $('.invoice-info').slideUp(400);
                    var $html = $('html, body');
                    $html.animate({
                        scrollTop: 0
                    }, '500', 'swing');
                }
            });

            if (!$('.inv-addr').is(':checked')) {
                $('.invoice-info').show();
            }

            //ATM select bank
            $('.channel-atm').on('change', function() {
                var target = $(this).attr('data-target');
                $('.process-atm').hide();
                $('#' + target).show();
            }).each(function() {
                if ($(this).is(':checked')) {
                    var target = $(this).attr('data-target');
                    $('.process-atm').hide();
                    $('#' + target).show();
                }
            });

            $('.channel-ibank').on('change', function() {
                var target = $(this).attr('data-target');
                $('.process-ibank').hide();
                $('#' + target).show();
            }).each(function() {
                if ($(this).is(':checked')) {
                    var target = $(this).attr('data-target');
                    $('.process-ibank').hide();
                    $('#' + target).show();
                }
            });
        },
        order_success: function() {
            //popup register
            if($("#popup-regis").data('show') == true){
                $('#popup-regis').modal('show');
            }

            //Close register box
            $('html, .close-modal, .regis-btm p').on('click', function(e) {
                if ($(this).is('html') || $(this).is('.close-modal') || $(this).is('.regis-btm p')) {
                    if ($(e.target).hasClass('modal-backdrop') || $(this).is('.close-modal') || $(this).is('.regis-btm p')) {
                        $('#popup-regis').modal('hide');
                    }
                }
            });

            //set height
            var header = $('.p-header').outerHeight(true);
            var name = $('.p-name').outerHeight(true);
            var order = $('.p-order').outerHeight(true);
            var boxRightHeight = $('.success-box3').outerHeight(true);
            var mainHeight = header + name + order;
            //console.log($('.p-box-footer').height() + ':' + name + ':' + header);
            if (mainHeight > boxRightHeight) {
                $('.success-box3').height(mainHeight);
            }
        }
    };
})(window.jQuery);