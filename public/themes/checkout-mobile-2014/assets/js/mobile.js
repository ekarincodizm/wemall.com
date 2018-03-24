(function (lib) {

    lib(window.jQuery, window, document);

}(function ($, window, document) {

        var uiMobile = {
            paymentGuideAccordian: function (settings) {

                var configs = {
                        items: $('.channel-payment__guide__heading'),
                        contents: $('.channel-payment__guide__content'),
                        carets: $('.caret--big'),
                        animateSpeed: 200,
                        previousItem: null
                    },
                    options = $.extend({}, configs, settings);

                options.items.on('click.widget', function () {

                    var item = $(this),
                        content = item.next(),
                        list = content.find('ol'),
                        caret = item.find(options.carets),
                        gutter = 30;

                    options.contents.slideUp(200, function () {
                        $(this).css({height: 0});
                    });
                    content.show().animate({
                        height: (list.height() + gutter) + 'px'
                    }, options.animateSpeed);

                    options.carets.removeClass('active');
                    if(this !== options.previousItem){
                        caret.addClass('active');
                        options.previousItem = this;
                    }else{
                        options.previousItem = null;
                    }

                });
            }
        }

        window.uiMobile = uiMobile;

        $(function () {
            uiMobile.paymentGuideAccordian();
        });

    }
));