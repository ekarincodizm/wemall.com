(function ( $ ) {

    if (!Object.create) {
        Object.create = function ( obj ) {
            function F () {
            };
            F.prototype = obj;
            return new F ();
        }
    }

    var Xmas = {
        initialize: function ( el, options ) {
            var self = this,
                rand = Math.floor ( ( Math.random () * 100) + 1 ) * 10;
            self.el = el;
            self.$el = $ ( el );
            self.options = $.extend ( {}, $.fn.xmas.defaults, options );

            setTimeout ( function () {
                self.rotate ();
            }, rand );
        },
        rotate: function () {
            var self = this;
            self.move ();
        },
        move: function () {
            var self = this,
                config = {angle: 0, direction: 'right'},

                interval = setInterval ( function () {

                    if (config.angle === -self.options.maxDegree) {
                        config.direction = 'left';
                    } else if (config.angle === self.options.maxDegree) {
                        config.direction = 'right';
                    }

                    if (config.direction == 'right') {
                        config.angle -= 1;
                    } else if (config.direction == 'left') {
                        config.angle += 1;
                    }

                    self.$el.find ( 'img' ).rotate ( {
                        angle: config.angle,
                        easing: $.easing.easeInExpo,
                        center: ['50%', '0'],
                        bind: {
                            mouseover: function () {
                                clearInterval ( interval );
                            },
                            mouseout: function () {
                                var currentAngle = $ ( this ).getRotateAngle ();
                                interval = setInterval ( function () {
                                    if (config.angle === -self.options.maxDegree) {
                                        config.direction = 'left';
                                    } else if (config.angle === self.options.maxDegree) {
                                        config.direction = 'right';
                                    }

                                    if (config.direction == 'right') {
                                        config.angle -= 1;
                                    } else if (config.direction == 'left') {
                                        config.angle += 1;
                                    }

                                    self.$el.find ( 'img' ).rotate ( {
                                        angle: config.angle,
                                        easing: $.easing.easeInExpo (),
                                        center: ['50%', '0']
                                    } )
                                }, 26 );
                            },
                            click: function ( e ) {
                                e.preventDefault ();
                                self.showModal ();
                            }
                        }
                    } );
                }, 26 );
        },
        templateModal: function ( text, productUri ) {
            return ['<div class="xmas-modal-dialog">',
                '<img src="img/modal/modal-bg.png" alt=""/>',
                '<div class="modal-msg">',
                '<p>' + text + '</p>',
                '</div>',
                '</div>'].join ( '' );
        },
        templateButton: function () {
            return ['<div class="modal-action">',
                '<div class="column left">',
                '<a href="http://support.itruemart.com/246198-เงอนไขการใชรหสสวนลด-Lucky-Xmas" target="_blank" class="coupon-conditions">',
                'ดูเงื่อนไขการใช้รหัสส่วนลดที่นี่',
                '</a>',
                '</div>',
                '<div class="column right">',
                '<a href="/">',
                '<img src="img/modal/backtoshopping.png" alt=""/>',
                '</a>',
                '</div>',
                '</div>'].join ( '' );
        },
        showModal: function () {
            var self = this,
                $win = $ ( window ),
                modal, name, url;

            if (!$ ( '.xmas-modal-dialog' ).length) {

                modal = self.templateModal ( 'กรุณารอสักครู่...', '#' );
                $ ( modal ).animate ( {
                    top: (($win.height () / 2 ) + $win.scrollTop () - (618 / 2)) + 'px'
                } ).addClass ( 'open' ).appendTo ( 'body' );
                $ ( 'body' ).off ( 'click', self.$el.find ( 'img' ) );

                var obj = {};
                obj.codename = 'คูปองส่วนลด 30% (*เฉพาะสินค้าหรือแบรนด์ที่กำหนด ได้แก่ Inspire, Pisen (ยกเว้นสินค้าในหมวด Everyday Wow), Rapoo (เฉพาะสินค้าที่กำหนด) และ Brita)';

                name = '<span class="text-welcome">ยินดีด้วยค่ะ</span>คุณได้รับสิทธิ์ <span class="msg-bold">' + obj.codename + '</span><span class="send-sms-email">เราได้ทำการส่งรหัสส่วนลดไปยังอีเมล์ หรือ เบอร์มือถือ ของคุณแล้วค่ะ</span>';
                $ ( '.xmas-modal-dialog' ).find ( '.modal-msg' ).find ( 'p' ).html ( name ).end ()
                    .append ( self.templateButton () );

                //self.getCouponCode ().done ( function ( data ) {
                //    name = '<span class="text-welcome">ยินดีด้วยค่ะ</span>คุณได้รับสิทธิ์ <span class="msg-bold">' + data.codename + '</span>';
                //    $ ( '.xmas-modal-dialog' ).find ( '.modal-msg' ).find ( 'p' ).html ( name ).end ()
                //        .append ( self.templateButton () );
                //} );
            }
        },
        getCouponCode: function () {
            var self = this;
            return $.getJSON ( self.options.ajaxUri );
        }
    }

    $.fn.xmas = function ( settings ) {
        return this.each ( function () {
            var xmas = Object.create ( Xmas );
            xmas.initialize ( this, settings );
        } );
    }

    $.fn.xmas.defaults = {
        maxDegree: 13,
        ajaxUri: 'http://www.dev.itruemart.com/ang-pao?jsoncallback=?'
    }

} ( jQuery ));