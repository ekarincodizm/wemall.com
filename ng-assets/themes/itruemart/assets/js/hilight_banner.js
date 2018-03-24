
$(document).ready(function() {


    $(".basic").click(function(e) {
        e.preventDefault();
        $.fancybox({
            type: 'ajax',
            // href: "<?php echo base_url(); ?>/category/product_details/get_product_banner_hilight/"+$(this).attr('rel'),
            href: site_url + "banner/" + $(this).attr('rel'),
            hideOnContentClick: true,
            showCloseButton: true,
            overlayShow: true,
            overlayOpacity: 0.5,
            scrolling: 'no',
            centerOnScroll: true,
            titleShow: false,
            padding: 0,
            autoDimensions: false,
            margin: 0,
            width: 'auto',
            height: 'auto',
            // onComplete : function(){stopShow();}
            onComplete: function() {
                pauseH();
            }
            // onClosed : play()
        });
    });

//    $('#basic-modal').mouseover(function() {
//        pauseH();
//    });
//
//    $('#basic-modal').mouseleave(function() {
//        playH();
//    });

    var test = $('#c_slot').val();

    //$('#basic-modal').BasicModal();
    var bannerAmount = $('#basic-modal li').length;

    var slider = $('#basic-modal').bxSlider({
        mode: 'fade',
        auto: (bannerAmount > 1),
        autoHover: true,
        infiniteLoop: (bannerAmount > 1),
        preloadImages: 'visible',
        pause: 4000,
        onSliderLoad: function() {
            var amount = 0;
            $('#basic-modal img').each(function() {
                var $this = $(this);
                $this.rwdImageMaps();

                $this.parent().wrapInner('<span class="wrap-banner" style="background-image: url(\'' + $this.attr('src') + '\');"></span>');
                $this.attr('src', 'assets/images/transparent.png').width(1200);
                amount++;
            });

            $('#basic-modal').parents('.bx-wrapper').find('.bx-prev').css({left: 'auto', right: (amount * 20) + 40 + 'px'});
        }
    });
    $(document).on('click', '.bx-next, .bx-prev, .bx-pager-item a', function() {
        slider.stopAuto();
        slider.startAuto();
    });
});

(function($) {
    $.fn.rwdImageMaps = function() {
        var $img = this;

        var rwdImageMap = function() {
            $img.each(function() {
                if (typeof ($(this).attr('usemap')) == 'undefined')
                    return;

                var pattern = /(\/transparent.png)$/g;
                var reg = new RegExp(pattern);
                var src = $(this).attr('src');
                if(reg.test(src))
                    return;

				console.log(src);

                var that = this;
                var $that = $(that);
                var imgUrl = $that.attr('src');
                var map = '';

                //var w = $that.attr('width').replace('px','');
                var w = $that.attr('width');

                if (!w) {
                    var temp = new Image();
                    temp.src = $that.attr('src');
                    if (!w)
                        w = temp.width;
                }
                /*var wPercent = $that.width() / 100,
                 hPercent = $that.height() / 100,*/
                map = $that.attr('usemap').replace('#', ''),
                        c = 'coords';

                $('map[name="' + map + '"]').find('area').each(function() {
                    var $this = $(this);
                    if (!$this.data(c))
                        $this.data(c, $this.attr(c));

                    var coords = $this.data(c).split(','),
                            coordsPercent = new Array(coords.length);

                    for (var i = 0; i < coordsPercent.length; ++i) {
                        if (i % 2 === 0) {
                            coordsPercent[i] = parseInt(coords[i] - ((w - 1200) / 2));
                        }
                        else {
                            coordsPercent[i] = parseInt(coords[i]);
                        }
                    }
                    $this.attr(c, coordsPercent.toString());
                });

            });
        };
        $(window).resize(rwdImageMap).trigger('resize');
        return this;
    };


})(jQuery);


	