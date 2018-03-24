function addCountdown(firstload) {
    if (firstload == undefined) {
        firstload = 0;
    }
    //$(".time-remaining > span:not(.glyphicon)").each(function(){
    /*var $this = $(this);
     if ($this.text() != "--:--:--" && typeof $this.countdown == 'function')
     {
     $this.countdown("2015/01/01", function(event) {
     var $this = $(this);
     $(this).html(event.strftime("%H:%M:%S"));
     });
     }*/


    $('[data-countdown]').each(function (_idx) {

        if ( $(this).hasClass('registered-countdown') ) return;
        $(this).addClass('registered-countdown');

        var _self = $(this), finalDate = _self.data('countdown');
        var _ignore_reload = _self.attr('data-reload');
        var eventType = _self.data('eventtype');

        //var _idx = $('[data-countdown]').index(this);
        _self.countdown(finalDate,function (event) {

            var totalHours = event.offset.totalDays * 24 + event.offset.hours;
            var _format = totalHours + ':%M:%S';
            //if(event.offset.days > 0){
            //_format= '%-d<span class="cln">:</span>%!d' + _format;
            //}
            _self.html(event.strftime(_format));
        }).on('finish.countdown', function (event) {

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
                if (_ignore_reload!='0') {
                    setTimeout(function() {
                        window.location.href = (window.location.href.indexOf('?') > 0 ? window.location.href.split('?')[0] : window.location.href) + '?_=' + Math.random();
                    }, 60000);
                }
            }

        });
    });

    //});
}

$(document).ready(function () {

    $(".ajax-widget").each(function () {
        var $this = $(this),
            done_trigger = $this.data("done_trigger") || null,
            method = $this.data("method"),
            url = $this.data("url");
        $.ajax({
            type: method.toUpperCase(),
            url: url
        })
            .done(function (msg) {
                if (done_trigger=='showroomReady') {
                    $this.html(msg);
                }
                else {
                    $this.replaceWith(msg);
                }
                var ogImage = $('#content').find('.product-image .swiper-slide img').attr('src');
                var ogTitle = $('#content').find('.product-name h1').text();
                var ogUrl = 'http://www.itruemart.com/' + window.location.pathname;
                var ogDescription = ogTitle;

                createOpenGraphFB('image', ogImage);
                createOpenGraphFB('title', ogTitle);
                createOpenGraphFB('url', ogUrl);
                createOpenGraphFB('description', ogDescription);

                if (done_trigger != null) {
                    $(document).trigger(done_trigger);

                    if (done_trigger=='showroomReady') {
                        $this.css({
                            backgroundImage: 'none',
                            height: 'auto'
                        });
                    }
                }
            })
            .fail(function () {
                $this.remove();
            });
    });

    addCountdown(1);

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() > 1500) {
            //show arrow back to top
            $('#backtotop-arrow').show();
        } else {
            //hide arrow back to top
            $('#backtotop-arrow').hide();
        }
    });

});

function createOpenGraphFB(type, content) {

    if (content == undefined || content.length == 0)
        return;

    var $meta = $('meta[property="og:' + type + '"]');
    if ($meta.length == 0) {
        content = (type == 'image') ? 'http:' + content : content;
        $('head').append('<meta property="og:' + type + '" content="' + content + '">');
    }

}