var renderScrollContent = function() {

    var lazyImage = function(){
        $('img.lazyload:not(.lazyloaded)').attr('src', function() {
            return $(this).attr('data-original');
        }).fadeIn().trigger('load');

        $('img.lazyload:not(.lazyloaded)').on('load', function() {
            var _this = $(this);

            setTimeout(function() {
                _this
                    .addClass('lazyloaded')
                    .css('height', 'auto');

                _this
                    .parents('.everyday-wow-product-content')
                    .animate({ opacity: 1 }, 'slow');

                _this
                    .parents('.everyday-wow-product-box')
                    .removeClass('loading');
            }, (500 * Math.random()) + 500);
        });
    };

    var _template = _.template($('#single-product-template').html());

    LazyContent.init({
        item: 'product-page',
        displayed: 'displayed',
        onRender: function(elem, response){
            var page_data = response.page_data;
            window._product = window._product || [];

            _.each(response.product_data, function(product, pkey) {
                var product_html = _template({
                    product: product,
                    page_data: page_data
                });

                elem.find('.everyday-wow-product-wrapper').eq(pkey)
                    .find('.everyday-wow-product-content').html(product_html);

                window.ec_products['everyday-wow'].push({
                    'id': product.pkey,
                    'name': product.title,
                    'list': 'everyday-wow',
                    'position': ((page_data.current_page-1)*6)+pkey+1,
                });

                window._product.push({
                    'id': product.pkey,
                    'name': product.title,
                    'list': 'everyday-wow',
                    'position': ((page_data.current_page-1)*6)+pkey+1,
                });
            });

            window.dataLayer.push({
                'event': 'productImpressions',
                'ecommerce': {
                    'currencyCode': 'PHP',
                    'impressions': window._product
                }
            });
        },
        onLoaded: function(elem, response) {
            //if version mobile use addCountdown()
            if(typeof APP == "undefined")
            {
                addCountdown();
            }
            else
            {
                APP.itm.countdown();
            }

            elem.removeAttr('style');

            lazyImage();
        },
        onInit: function() {
            lazyImage();
        }
    });
};

renderScrollContent();

var _product_box = $('#product-box-template').html();

$('.box-filter-type').on('click', function(e) {
    e.preventDefault();

    // if change tab don't load last content
    $(".product-page").addClass("displayed");

    var _this = $(this),
        _url = _this.attr('href'),
        _orderBy = $(this).attr('data-orderby'),
        _orderType = $(this).hasClass('up') ? 'down' : 'up',
        _param = {};

    // set param
    // _param.sortby = _orderBy; // since sortby already in href
    _param.orderby = _orderType=='down' ? 'desc' : 'asc';

    // toggle active
    _this.parents('#superdeal-filter').find('li').removeClass('active');
    _this.parent().addClass('active');

    // toggle type
    _this
        .removeClass('up')
        .removeClass('down')
        .addClass( _orderType );

    _this.parent().siblings().find('a').removeClass('down');
    _this.parent().siblings().find('a').removeClass('up');
    // display loading
    $(document).trigger("show-ajax-loading");

    var _xhr = $.getJSON(_url, _param);
    _xhr.done(function(response) {
        if (response.code!=200) {
            $(document).trigger("hide-ajax-loading");
            return;
        }

        var total_page = response.data.page_data.total_page,
            total_item = response.data.page_data.total_item,
            current_page_url = _url,
            layout = '';

        for (var page = 1; page <= total_page; page++) {
            layout += '<div class="product-page page" id="page-' + page + '" data-url="' + current_page_url + '&page=' + page +  '&orderby=' + _param.orderby + '">';
            layout += '<div class="fs-container">';
            var start = (page - 1)*6,
                end = start + 6;
            end = total_item<end ? total_item : end;
            for (var i = start; i<end; i++ ) {
                layout += _product_box;
            }
            layout += '</div>';
            layout += '</div>';
        }

        $('#everydaywow-product-list').html( layout );

        $(document).trigger("hide-ajax-loading");

        renderScrollContent();
    });
});

$('.box-filter-type-mobile').on('click', function(e) {
    e.preventDefault();

    // if change tab don't load last content
    $(".product-page").addClass("displayed");

    var _this = $(this),
        _url = _this.attr('data-href'),
        _orderBy = $(this).attr('data-orderby'),
        _orderType = $(this).hasClass('up') ? 'down' : 'up',
        _param = {};

    // set param
    // _param.sortby = _orderBy; // since sortby already in href
    _param.orderby = _orderType=='down' ? 'desc' : 'asc';

    // toggle active
    _this.parents('#superdeal-filter-mobile').find('button').removeClass('active');
    _this.addClass('active');

    // toggle type
    _this
        .removeClass('up')
        .removeClass('down')
        .addClass( _orderType );

    _this.parents('#superdeal-filter-mobile').find('button').find('img').attr('src','/themes/mobile/assets/img/order_by_both.png');
    _this.find('img').attr('src','/themes/mobile/assets/img/order_by_both_'+ _orderType +'_active.png');

    // display loading
    $(document).trigger("show-ajax-loading");

    var _xhr = $.getJSON(_url, _param);
    _xhr.done(function(response) {
        if (response.code!=200) {
            $(document).trigger("hide-ajax-loading");
            return;
        }

        var total_page = response.data.page_data.total_page,
            total_item = response.data.page_data.total_item,
            current_page_url = _url,
            layout = '';

        for (var page = 1; page <= total_page; page++) {
            layout += '<div class="product-page page" id="page-' + page + '" data-url="' + current_page_url + '&page=' + page +  '&orderby=' + _param.orderby + '">';
            layout += '<div class="fs-container">';
            var start = (page - 1)*6,
                end = start + 6;
            end = total_item<end ? total_item : end;
            for (var i = start; i<end; i++ ) {
                layout += _product_box;
            }
            layout += '</div>';
            layout += '</div>';
        }

        $('#everydaywow-product-list').html( layout );

        $(document).trigger("hide-ajax-loading");

        renderScrollContent();
    });
});

// $(document).trigger("show-ajax-loading");