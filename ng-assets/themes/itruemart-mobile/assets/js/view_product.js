var product = product || {};

product.options = (function($) {
    var option = {
        //postUrl: '/ajax/product/check_img',
        //        getData: function(config,obj) {
        //            $.get(option.postUrl, config, function(data) {
        //                if(data != null || data != undefined){
        //                    $('.bx-wrapper').remove();
        //                    $('.banner').append('<ul id="campaign">' + option.formatData(data) + '</ul>');
        //                    var $campaign = $('#campaign');
        //                    var len = $campaign.find('li').length;
        //                    $campaign.bxSlider({
        //                        autoHover: true,
        //                        controls: false,
        //                        infiniteLoop: len,
        //                        auto: $campaign.find('li').length,
        //                        preloadImages: 'visible'
        //                    });
        //                }
        //            },'json').fail(function(){
        //                console.log('Can\'t load data');
        //            });
        //        //                var data = '[{"image_id":6041,"path":"http:\/\/cdn.dev.itruemart.com\/files\/product\/189\/6664\/m29xv7KjQL6fUArVEIto8DunCvFNMp4lXHOkVbJsG0ZWS5ehwdPiqcgRB1Taz3_original.jpg","color_id":1319},{"image_id":6043,"path":"http:\/\/cdn.dev.itruemart.com\/files\/product\/189\/6664\/Q1XmgS8eifu29AokFvKVZJCMaH6vxUV4PwlLszDd53Njq70hBrtTGOpncWERbI_original.jpg","color_id":1319},{"image_id":6046,"path":"http:\/\/cdn.dev.itruemart.com\/files\/product\/189\/6664\/jTxLgwOGXv5347KcrJHQCAVseIp0DuNUq6t9EobMfPihWFzaVSv8BnlmdZ21kR_original.jpg","color_id":1319},{"image_id":11722,"path":"http:\/\/cdn.dev.itruemart.com\/files\/product\/189\/6664\/qQpWTsCh35k7Ho1gc0D6n8maSiUw2xINfbtRA4LP9evZVzrFBOVEdlvuGXjKMJ_original.jpg","color_id":1319}]';
        //        //                return this.formatData($.parseJSON(data));
        //        },
        
        //        formatData: function(data) {
        //			
        //            var html = '';
        //            for (var i = 0; i < data.length; i++) {
        //                html += '<li><img src="' + data[i].path + '" /></li>';
        //            }
        //				
        //            return html = (html.length) ? html : '';
        //        },
        setSlider: function(obj) {
 
            $('.bx-wrapper').remove();
            $('.banner').append('<ul id="campaign">' + obj.html() + '</ul>');
            var $campaign = $('#campaign');
            var len = $campaign.find('li').length;
            $campaign.bxSlider({
                autoHover: true,
                controls: false,
                infiniteLoop: len,
                auto: $campaign.find('li').length,
                preloadImages: 'visible'
            });
        }
    };

    return option;
}(jQuery));


jQuery(function() {
    //main slider.
    var $campaign = $('ul#campaign');
    var len = $campaign.find('li').length;
    var _campign = $campaign.bxSlider({
        autoHover: true,
        controls: false,
        infiniteLoop: len,
        auto: $campaign.find('li').length,
        preloadImages: 'visible'
    });
    
    $("#media-set .style-option").on("select", function(e) {
        var selected = $("#slider-template-" + $(this).data("style-option"));
        if(selected.find("li").length) 
        {
            product.options.setSlider(selected);
        }   
        else {
            product.options.setSlider($("#default-slider"));
        }
    });

//    sessionStorage.setItem('current', '-1');
//    $('.color li a').on('click', function(event) {
//        event.preventDefault();
//
//        var $this = $(this),
//        pid = $this.attr('data-product-id'),
//        cid = $this.attr('data-color-id'),
//        config = {
//            p_id: pid, 
//            color_id: cid
//        },
//        obj = {
//            c: 'campaign', 
//            s: _campign
//        };
//        isCurrent = (sessionStorage.getItem('current') === $this.index('.color li a').toString());
//
//        if (isCurrent)
//            return;
//
//        sessionStorage.setItem('current', $this.index('.color li a').toString());
//
//        $('.color li a').removeClass('active');
//        $this.addClass('active');
//        
//        product.options.getData(config, obj);
//
//    }).css({
//        cursor: 'pointer'
//    });
});
