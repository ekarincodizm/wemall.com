<div id="line-content">
    <?php echo htmlspecialchars_decode( array_get($campaign_data, 'data.content', false) ); ?>
</div>
<script type="text/javascript">
$(document).ready(function () {
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
</script>