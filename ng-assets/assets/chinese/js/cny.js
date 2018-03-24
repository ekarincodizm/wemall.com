(function ( $, Custombox ) {

    if (!Object.create) {
        Object.create = function ( obj ) {
            function F () {
            };
            F.prototype = obj
            return new F ();
        }
    }

    var Chinese = {
        init: function ( elem, settings ) {
            var self = this,
                rand = Math.floor ( ( Math.random () * 50) + 1 ) * 100;

            self.elem = elem;
            self.$elem = $ ( elem );
            self.options = $.extend ( {}, $.fn.chineseNewYear.defaults, settings );

            self.events ();
            setTimeout ( function () {
                self.transitions ();
            }, rand );
        },

        events: function () {
            var self = this;

            self.$elem.filter ( function ( index ) {
                return $ ( 'img', this ).length === 1;
            } ).hover ( function () {
                clearTimeout ( self.transitionsTimeout );
            }, function () {
                self.transitions ();
            } ).on ( 'click', function ( e ) {
                e.preventDefault ();
                var $this = this;
                self.showDialogBox ();
                $('.msg--predict').hide();

                $(".msg--coupon").find("span").text("กรุณารอสักครู่...");
                self.getCouponCode ().done ( function ( data ) {

                    var num1  = data.search("<script>");

                    var obj = num1 > -1 ? data.substring(0, num1): data ;
                    obj = JSON.parse(obj);


                    var userstatus = parseInt(obj.userstatus);
                    var codestatus = obj.codestatus;
                    var enddate = obj.DateEnd;
                    var codename = obj.codename;
                    var codeurl = obj.codeurl;


                    if(codestatus == 0 ){
                        console.log('Pass', $(".msg--coupon span").length);
                        $(".msg--coupon").find('span').text('ขออภัยค่ะ ขณะนี้มีผู้รับคูปองครบจำนวนแล้วค่ะ');


                    }else if(userstatus == 1){
                        var couponName = codename;
                        if ($ ( '.msg--coupon' ).find ( 'span' ).length == 1 && couponName.match ( /^คูปอง/ )) {
                            $ ( '.msg--coupon' ).html ( '<span><span style="font-family: true_boldregular; display: block;">ซินเจียยู่อี่ ซินนี้ฮวดใช้</span><span>' + couponName.replace ( /ยกเว้นสินค้า(.*)/ig, '<span style="font-size: 18px; display: inline-block">(ยกเว้นสินค้าหมวด$1)</span>' ) + '</span></span>' );
                        }else{
                            $(".msg--coupon").find("span").html(codename);
                        }
                        $('.msg--predict' ).show().find ( 'span' ).text ( self.options.predict['lion-' + ($ ( $this ).index ( '.lions' ) + 1)] );

                    }else{
                        //console.log(enddate);
                        $('.msg--predict').hide();

                        $(".msg--coupon span").html('ขออภัยค่ะ คุณใช้สิทธิ์รับรางวัลสำหรับสัปดาห์นี้ไปแล้ว สามารถลุ้นรับสิทธิพิเศษอื่นๆ ได้อีกครั้ง <br/>วันที่ '+enddate);

                    }
                } );
            } );
        },

        showDialogBox: function ( idx ) {
            var self = this;
            Custombox.open ( {
                target: '#modal-msg',
                effect: 'newspaper',
                close: function () {
                    $('html').removeAttr('class');
                    self.transitions ();
                }
            } );
            $ ( '.msg--predict' ).find ( 'span' ).text ( this.options.predict['lion-' + (idx + 1)] );
        },

        transitions: function () {
            var self = this,
                $img = self.$elem.find ( 'img' ).length === 0 ? self.$elem : self.$elem.find ( 'img' ),
                imgPath = $img.attr ( 'src' ),
                tmpIdx = $img.attr ( 'data-idx' );

            if (imgPath.match ( /Fire\d{1}/ig )) {
                $img.attr ( 'src', imgPath.replace ( /\d/ig, $img.attr ( 'data-idx' ) ) )
                    .attr ( 'data-idx', tmpIdx === '1' ? '2' : '1' );
            } else if (imgPath.match ( /\d{1}\-\d{1}/ig )) {
                $img.attr ( 'src', imgPath.replace ( /\-\d{1}/ig, '-2' ) );
                setTimeout ( function () {
                    $img.attr ( 'src', imgPath.replace ( /\-\d{1}/ig, '-1' ) );
                }, 100 );
            }

            self.transitionsTimeout = setTimeout ( function () {
                self.transitions ();
            }, 1000 );
        },

        getCouponCode: function () {
            return $.ajax ( {url: this.options.ajaxUri, cache: false});
        }
    };

    $.fn.chineseNewYear = function ( settings ) {
        return this.each ( function () {
            var chinese = Object.create ( Chinese );
            chinese.init ( this, settings );
        } );
    }
    $.fn.chineseNewYear.defaults = {
        predict: {
            'lion-1': 'เจิดจรัสไปทุกย่างก้าว จิตใจเบิกบานแช่มชื่น จับอะไรก็เป็นเงินเป็นทอง รวยๆ เฮงๆ คนมีคู่ความรักของคุณก็ไม่น้อยหน้า จะสวีทหวานจนใครๆก็อิจฉาคู่ของคุณตลอดปี คนโสดมีเกณฑ์เจอคู่คิดถูกใจในปีนี้',
            'lion-2': 'ปีนี้ถือว่าเป็นปีที่ดีของคุณเลยทีเดียว คุณจะประสบความสําเร็จอย่างถึงขีดสุด ผู้ใหญ่ให้การสนับสนุนและเห็นในผลงานที่โดดเด่นของคุณ มีโอกาสได้เลื่อนตําแหน่งหรือได้รับโบนัสรางวัลก้อนใหญ่จากการทํางาน',
            'lion-3': 'ปีนี้คุณจะรู้สึกสนุกตื่นเต้นเป็นพิเศษ เป็นปีแห่งการเฉลิมฉลองอย่างมีความสุขและพักผ่อนหย่อนใจ หมดเรื่องทุกข์ใจในปีที่ผ่านมา คุณจะได้เที่ยวเปลี่ยนบรรยากาศ พบเจอสิ่งใหม่ๆ',
            'lion-4': 'ออร่าสว่างไสวเปล่งประกายแบบฉุดไม่อยู่ คุณจะเป็นที่ต้องตาต้องใจใครต่อใคร ดึงดูดใจแก่ผู้พบเห็น คุณจะมีโชคในการเจรจาต่อรอง ติดต่อประสานงานต่างๆด้วยความราบรื่นเป็นอย่างดี',
            'lion-5': 'เป็นปีแห่งการเริ่มต้นทําสิ่งใหม่ๆ มีผู้หลักผู้ใหญ่ที่มีอํานาจเข้ามาช่วยเหลือ คุณจะได้พบคู่คิดที่ดีมิตรสหายที่มีความสามารถมาให้คําปรึกษาและให้การสนับสนุน การเงินคล่องตัว คิดจะลงทุนทําสิ่งใดก็ประสบความสําเร็จ',
            'lion-6': 'ปีแห่งความอบอุ่นในครอบครัว มีงานมงคลที่จะทําให้คุณสดใสเป็นพิเศษ ญาติมิตรบริวารจะนําชื่อเสียงมาให้ มีโอกาสรับทรัพย์รับโชคหรือรับมรดกจากผู้ใหญ่ เรียกได้ว่าแฮปปี้สุขขีเปรมปรีย์กันไปทั้งครอบครัวเลยทีเดียว',
            'lion-7': 'เป็นปีแห่งความขยันขันแข็ง มีเกณฑ์ประสบความสําเร็จในเรื่องงานที่ตั้งใจเอาไว้ คุณจะได้รับความไว้วางใจจากเจ้านาย มีโอกาสเดินทางไปต่างประเทศและได้ของขวัญสุดพิเศษแสนถูกใจจากแดนไกล',
            'lion-8': 'ว๊าว ปีนี้ทําอะไรก็ดีไปหมดทุกอย่าง คนทําธุรกิจก็ไปได้สวยมีโอกาสขยับขยายกิจการให้โตมากยิ่งขึ้น ส่วนใครที่เป็นพนักงานออฟฟิศถือว่าปีนี้คุณจะได้โชว์ศักยภาพในการทํางานอย่างเต็มที่',
            'lion-9': 'เลิศสุดๆไปเลย ปีนี้คุณจะมีจังหวะดีๆที่จะทําสิ่งที่ตั้งใจไว้ ความสําเร็จย่อมเกิดขึ้นกับคุณอย่างแน่นอน คุณจะมีผู้ใหญ่ให้การสนับสนุนทั้งโอกาสและเงินทองตามที่หวังไว้อีกทั้งจะพบโชค 2 ชั้น'
        },
        ajaxUri: '/ang-pao'
    };


}) ( jQuery, Custombox );