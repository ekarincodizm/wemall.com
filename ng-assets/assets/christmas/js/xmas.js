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
                '<img src="/assets/christmas/img/modal/modal-bg.png" alt=""/>',
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

                modal = self.templateModal ( '<span style="display:block;height: 230px;line-height: 230px;"><span style="line-height: normal;display: inline-block; text-align: center; width: 100%;">กรุณารอสักครู่...</span></span>', '#' );
                $ ( modal ).animate ( {
                    top: (($win.height () / 2 ) + $win.scrollTop () - (618 / 2)) + 'px'
                } ).addClass ( 'open' ).appendTo ( 'body' );
                $ ( 'body' ).off ( 'click', self.$el.find ( 'img' ) );

                self.getCouponCode ().done ( function ( data ) {
                   
                //console.log(data);
                var num1  = data.search("<script>");               
                // console.log(num1);
                var obj = num1 > -1 ? data.substring(0, num1): data ;  
               
                obj = JSON.parse(obj);
                //console.log(obj);  
                if(obj.codestatus ==0){
                   var out_txt = 'ขออภัยค่ะ รางวัลสหมด';
                }else{
                    if(obj.userstatus=="1")
                    {
                       // var out_txt = 'ยินดีด้วยค่ะ คุณได้รับสิทธิ์'+ obj.codename + 'เราได้ทำการส่งรหัสส่วนลดไปยังอีเมล์ หรือ เบอร์มือถือ ของคุณแล้วค่ะ';
                          var out_txt  = '<span class="text-welcome">ยินดีด้วยค่ะ</span>คุณได้รับสิทธิ์ <span class="msg-bold">' + obj.codename + '</span><span class="send-sms-email">เราได้ทำการส่งรหัสส่วนลดไปยังอีเมล์ หรือ เบอร์มือถือ ของคุณแล้วค่ะ</span>';
                    }
                    else if(obj.userstatus=="0")
                    {
                        var expdated = obj.DateEnd.substring(0,10);
                        var d = new Date(expdated);
                        d.setDate(d.getDate()+1 );
                        var expdate = d.getDate();
                        var expmonth = d.getMonth()+1;
                        var y = d.getYear();   
                        var ss = y.toString();    
                        var fullexpdate =  expdate+'-'+expmonth+'-20'+ss.slice(1);
                        
                        //var out_txt = 'ขออภัยค่ะ คุณใช้สิทธิ์รับรางวัลสำหรับสัปดาห์นี้ไปแล้ว สามารถลุ้นรับสิทธิพิเศษอื่นๆได้อีกครั้ง วันที่ '+obj.DateEnd.substring(0,10);
                        var out_txt = '<span style="display:block;height: 230px;line-height: 230px;"><span style="line-height: normal;display: inline-block;">ขออภัยค่ะ คุณใช้สิทธิ์รับรางวัลสำหรับสัปดาห์นี้ไปแล้ว สามารถลุ้นรับสิทธิพิเศษอื่นๆได้อีกครั้ง วันที่ '+ fullexpdate +'</span></span>';
                    }
                }
                    
                    $ ( '.xmas-modal-dialog' ).find ( '.modal-msg' ).find ( 'p' ).html (out_txt).end ()
                        .append ( obj.userstatus != '0' ? self.templateButton (obj.codeurl) : '' );
                } );
            }
        },
        getCouponCode: function () {
            var self = this;          
            
           // return $.getJSON ( self.options.ajaxUri );
            return $.get ( self.options.ajaxUri );
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
       ajaxUri: '/ang-pao'
          
       //ajaxUri: 'http://www.itruemart-dev.loc/ang-pao?jsoncallback=?'
    }

} ( jQuery ));