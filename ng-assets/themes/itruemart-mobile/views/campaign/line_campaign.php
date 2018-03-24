<div id="line-content">
    <div style="margin: 0 auto; text-align: center; padding: 30px;">
    <img src="<?php echo Theme::asset()->url('images/bx_loader.gif'); ?>">
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $.get("<?php echo URL::route('campaign.content');?>",
            {
                id: '<?php echo $id;?>',
                previews: '<?php echo $previews;?>',
                no_cache: '<?php echo $no_cache;?>'
            },
            function (data) {
                $('#line-content').html(data);

                var slider;
                var deviceWidth = 0;
                $(window).bind('resize', function() {
                    deviceWidth = $('#wrapper').innerWidth();

                    $('#mp-content-container').width((deviceWidth * 45) / 100 * 3);

                    if (slider === undefined) {
                        slider = $('#mp-content-slider').bxSlider({
                            slideWidth: $('#mp-content-container').width() / 3,
                            autoHover: true,
                            controls: false,
                            infiniteLoop: true,
                            auto: false,
                            preloadImages: 'visible',
                            pager: false,
                            minSlides: 3,
                            maxSlides: 3,
                            moveSlides: 2,
                            slideMargin: 2
                        });
                    } else {
                        slider.reloadSlider();
                    }

                }).trigger('resize');


                $('.promotion-msg').on('click touchstart', function() {
                    $(this).hide();
                    $('.enquiry').show();
                    $('.enquiry input').animate({
                        width: '75%'
                    }, {queue: false, duration: 500, complete: function() {
                        $('.enquiry input').focus();
                    }
                    });
                });

                $('.enquiry button').on('click', function() {
                    $('.enquiry input').css({width: '100%'});
                    $('.enquiry').hide();
                    $('.promotion-msg').show();
                });
            });
    });
</script>