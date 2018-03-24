$(function () {
    $('.anchor-view-by').on('click', function (event) {

        event.preventDefault();
        anchor = $(this);


        anchor.siblings('a').removeClass('active');
        anchor.addClass('active');

        var viewBy = anchor.attr('data-view-by');

        var imgSourceDefault = "";
        var imgSourceThumbnail = "";
        var imgSourceList = "";
        switch (viewBy) {
            case "default" :
                imgSourceDefault = "/themes/mobile/assets/img/icon_viewby_default_active.png";
                imgSourceThumbnail = "/themes/mobile/assets/img/icon_viewby_thumbnail.png";
                imgSourceList = "/themes/mobile/assets/img/icon_viewby_list.png";
                break;

            case "thumbnail" :
                imgSourceDefault = "/themes/mobile/assets/img/icon_viewby_default.png";
                imgSourceThumbnail = "/themes/mobile/assets/img/icon_viewby_thumbnail_active.png";
                imgSourceList = "/themes/mobile/assets/img/icon_viewby_list.png";
                break;

            case "list" :
                imgSourceDefault = "/themes/mobile/assets/img/icon_viewby_default.png";
                imgSourceThumbnail = "/themes/mobile/assets/img/icon_viewby_thumbnail.png";
                imgSourceList = "/themes/mobile/assets/img/icon_viewby_list_active.png";
                break;

            default :
                break;
        }

        $('.anchor-view-by[data-view-by="default"]').children('img').attr('src', imgSourceDefault);
        $('.anchor-view-by[data-view-by="thumbnail"]').children('img').attr('src', imgSourceThumbnail);
        $('.anchor-view-by[data-view-by="list"]').children('img').attr('src', imgSourceList);


        orderBy = $(".order-by button[class*='active']").attr('data-order-by');
        orderType = $('.order-by button[class*="active"]').attr('data-order-type');


        initLoad();
    });


    $('.btn-order-by').on('click', function (event) {

        event.preventDefault();
        button = $(this);
        orderBy = button.attr('data-order-by');
        orderType = button.attr('data-order-type');
        href = button.attr('data-shref');


        viewBy = $('.view-by').children('a[class~="active"]').attr('data-view-by');

        orderType = orderType.toLowerCase();
        newOrderType = orderType;
        if (button.hasClass('active')) {
            if (orderType == "desc") {
                orderType = "asc";
                newOrderType = "asc";
            }
            else {
                orderType = "desc";
                newOrderType = "desc";
            }
        }
        else {
            newOrderType = "desc";
        }


        button.attr('data-order-type', newOrderType);
        button.attr('data-order-current', orderType);
        // $('#load-more').attr('data-page', 1);
        switch (orderBy) {
            case "published_at" :
                if (orderType == "desc") {
                    $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
                }
                else {
                    $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
                }
                $('#img-order-by-price').attr('src', '/themes/mobile/assets/img/order_by_both.png');
                $('#img-order-by-discount').attr('src', '/themes/mobile/assets/img/order_by_both.png');

                $('.btn-order-by[data-order-by="price"]').attr('data-order-type', 'desc');
                $('.btn-order-by[data-order-by="discount"]').attr('data-order-type', 'desc');


                //for search solr
                $('#img-order-by-sell-price').attr('src', '/themes/mobile/assets/img/order_by_both.png');
                $('#img-order-by-percent-discount').attr('src', '/themes/mobile/assets/img/order_by_both.png');

                $('.btn-order-by[data-order-by="sell_price"]').attr('data-order-type', 'desc');
                $('.btn-order-by[data-order-by="percent_discount"]').attr('data-order-type', 'desc');

                break;

            case "price" :
                if (orderType == "desc") {
                    $('#img-order-by-price').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
                }
                else {
                    $('#img-order-by-price').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
                }
                $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both.png');
                $('#img-order-by-discount').attr('src', '/themes/mobile/assets/img/order_by_both.png');

                $('.btn-order-by[data-order-by="published_at"]').attr('data-order-type', 'desc');
                $('.btn-order-by[data-order-by="discount"]').attr('data-order-type', 'desc');
                break;

            case "discount" :
                if (orderType == "desc") {
                    $('#img-order-by-discount').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
                }
                else {
                    $('#img-order-by-discount').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
                }
                $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both.png');
                $('#img-order-by-price').attr('src', '/themes/mobile/assets/img/order_by_both.png');

                $('.btn-order-by[data-order-by="published_at"]').attr('data-order-type', 'desc');
                $('.btn-order-by[data-order-by="price"]').attr('data-order-type', 'desc');
                break;

            case "created_at" :
                if (orderType == "desc") {
                    $('#img-order-by-created-at').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
                }
                else {
                    $('#img-order-by-created-at').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
                }
                $('#img-order-by-sell-price').attr('src', '/themes/mobile/assets/img/order_by_both.png');
                $('#img-order-by-percent-discount').attr('src', '/themes/mobile/assets/img/order_by_both.png')

                $('.btn-order-by[data-order-by="sell_price"]').attr('data-order-type', 'desc');
                $('.btn-order-by[data-order-by="percent_discount"]').attr('data-order-type', 'desc');

                break;

            case "sell_price" :
                if (orderType == "desc") {
                    $('#img-order-by-sell-price').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
                }
                else {
                    $('#img-order-by-sell-price').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
                }
                $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both.png');
                $('#img-order-by-percent-discount').attr('src', '/themes/mobile/assets/img/order_by_both.png');

                $('.btn-order-by[data-order-by="published_at"]').attr('data-order-type', 'desc');
                $('.btn-order-by[data-order-by="percent_discount"]').attr('data-order-type', 'desc');
                break;

            case "percent_discount" :
                if (orderType == "desc") {
                    $('#img-order-by-percent-discount').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
                }
                else {
                    $('#img-order-by-percent-discount').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
                }
                $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both.png');
                $('#img-order-by-sell-price').attr('src', '/themes/mobile/assets/img/order_by_both.png');

                $('.btn-order-by[data-order-by="published_at"]').attr('data-order-type', 'desc');
                $('.btn-order-by[data-order-by="sell_price"]').attr('data-order-type', 'desc');
                break;

            case "best_match" :

                $('#img-order-by-created-at').attr('src', '/themes/mobile/assets/img/order_by_both.png');
                $('#img-order-by-sell-price').attr('src', '/themes/mobile/assets/img/order_by_both.png');
                $('#img-order-by-publish-at').attr('src', '/themes/mobile/assets/img/order_by_both.png');

                $('.btn-order-by[data-order-by="published_at"]').attr('data-order-type', 'desc');
                $('.btn-order-by[data-order-by="created_at"]').attr('data-order-type', 'desc');
                $('.btn-order-by[data-order-by="sell_price"]').attr('data-order-type', 'desc');
                break;
            default :
                break;
        }

        button.siblings().removeClass('active');
        button.addClass('active');

        initLoad();
    });

    initLoad();
});


function initLoad() {
    var loadMoreUrl = $('.anchor_href').attr('href');
    loadContent();
    $('#pkey-content').css('display', 'block');
}

function getSearch2QueryString(){
    var params = "";

    if($.getQueryString('priceMax')){
        params += "&priceMax=" + $.getQueryString('priceMax');
    }

    if($.getQueryString('priceMin')){
        params += "&priceMin=" + $.getQueryString('priceMin');
    }

    if($.getQueryString('color_en')){
        params += "&color_en=" + $.getQueryString('color_en');
    }

    if($.getQueryString('color_th')){
        params += "&color_th=" + $.getQueryString('color_th');
    }

    if($.getQueryString('size_th')){
        params += "&size_th=" + $.getQueryString('size_th');
    }

    if($.getQueryString('size_en')){
        params += "&size_en=" + $.getQueryString('size_en');
    }

    if($.getQueryString('brand_en')){
        params += "&brand_en=" + $.getQueryString('brand_en');
    }

    if($.getQueryString('brand_th')){
        params += "&brand_th=" + $.getQueryString('brand_th');
    }

    if($.getQueryString('payment_ccw')){
        params += "&payment_ccw=" + $.getQueryString('payment_ccw');
    }

    if($.getQueryString('payment_installment')){
        params += "&payment_installment=" + $.getQueryString('payment_installment');
    }

    if($.getQueryString('payment_bank_transfer')){
        params += "&payment_bank_transfer=" + $.getQueryString('payment_bank_transfer');
    }

    if($.getQueryString('payment_atm')){
        params += "&payment_atm=" + $.getQueryString('payment_atm');
    }

    if($.getQueryString('payment_cs')){
        params += "&payment_cs=" + $.getQueryString('payment_cs');
    }

    if($.getQueryString('payment_cod')){
        params += "&payment_cod=" + $.getQueryString('payment_cod');
    }

    if($.getQueryString('payment_internet_banking')){
        params += "&payment_internet_banking=" + $.getQueryString('payment_internet_banking');
    }

    if($.getQueryString('payment_over_the_counter')){
        params += "&payment_over_the_counter=" + $.getQueryString('payment_over_the_counter');
    }

    return params;
}

function loadContent() {

    var viewBy = $('.view-by').children('a[class~="active"]').attr('data-view-by');
    var button = $(".order-by button[class*='active']");
    var orderBy = $(".order-by button[class*='active']").attr('data-order-by');
    var orderType = $('.order-by button[class*="active"]').attr('data-order-type');
    var url = $('#load-more').attr('data-href');
    var collection = $('#pkey-content').attr('data-collection');
    var q = $('#pkey-content').attr("data-keyword");
    var page = parseInt($('#load-more').attr('data-page'));
    var anchorHref = $('a.anchor_href').attr('href');
    var regExp = /page=([0-9]*)/
    var newOrderType = orderType;
    var per_page = $('#per_page').val();

    orderType = orderType.toLowerCase();
    url = url + '?viewBy=' + viewBy + '&orderBy=' + orderBy + '&order='
    + orderType + '&page=' + page + '&per_page=' + per_page
    + '&collection=' + encodeURIComponent(collection) + '&q=' + q + getSearch2QueryString();

    button.attr('data-order-type', newOrderType);
    button.attr('data-order-current', orderType);

    switch (orderBy) {
        case "published_at" :
            if (orderType == "desc") {
                $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
            }
            else {
                $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
            }
            $('#img-order-by-price').attr('src', '/themes/mobile/assets/img/order_by_both.png');
            $('#img-order-by-discount').attr('src', '/themes/mobile/assets/img/order_by_both.png')

            $('.btn-order-by[data-order-by="price"]').attr('data-order-type', 'desc');
            $('.btn-order-by[data-order-by="discount"]').attr('data-order-type', 'desc');


            //for search solr
            $('#img-order-by-sell-price').attr('src', '/themes/mobile/assets/img/order_by_both.png');
            $('#img-order-by-percent-discount').attr('src', '/themes/mobile/assets/img/order_by_both.png');

            $('.btn-order-by[data-order-by="sell_price"]').attr('data-order-type', 'desc');
            $('.btn-order-by[data-order-by="percent_discount"]').attr('data-order-type', 'desc');

            break;

        case "price" :
            if (orderType == "desc") {
                $('#img-order-by-price').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
            }
            else {
                $('#img-order-by-price').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
            }
            $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both.png');
            $('#img-order-by-discount').attr('src', '/themes/mobile/assets/img/order_by_both.png');

            $('.btn-order-by[data-order-by="published_at"]').attr('data-order-type', 'desc');
            $('.btn-order-by[data-order-by="discount"]').attr('data-order-type', 'desc');
            break;

        case "discount" :
            if (orderType == "desc") {
                $('#img-order-by-discount').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
            }
            else {
                $('#img-order-by-discount').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
            }
            $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both.png');
            $('#img-order-by-price').attr('src', '/themes/mobile/assets/img/order_by_both.png');

            $('.btn-order-by[data-order-by="published_at"]').attr('data-order-type', 'desc');
            $('.btn-order-by[data-order-by="price"]').attr('data-order-type', 'desc');
            break;

        case "created_at" :
            if (orderType == "desc") {
                $('#img-order-by-created-at').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
            }
            else {
                $('#img-order-by-created-at').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
            }
            $('#img-order-by-sell-price').attr('src', '/themes/mobile/assets/img/order_by_both.png');
            $('#img-order-by-percent-discount').attr('src', '/themes/mobile/assets/img/order_by_both.png')

            $('.btn-order-by[data-order-by="sell_price"]').attr('data-order-type', 'desc');
            $('.btn-order-by[data-order-by="percent_discount"]').attr('data-order-type', 'desc');

            break;

        case "sell_price" :
            if (orderType == "desc") {
                $('#img-order-by-sell-price').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
            }
            else {
                $('#img-order-by-sell-price').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
            }
            $('#img-order-by-created-at').attr('src', '/themes/mobile/assets/img/order_by_both.png');
            $('#img-order-by-percent-discount').attr('src', '/themes/mobile/assets/img/order_by_both.png');

            $('.btn-order-by[data-order-by="created_at"]').attr('data-order-type', 'desc');
            $('.btn-order-by[data-order-by="percent_discount"]').attr('data-order-type', 'desc');
            break;

        case "percent_discount" :
            if (orderType == "desc") {
                $('#img-order-by-percent-discount').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
            }
            else {
                $('#img-order-by-percent-discount').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
            }
            $('#img-order-by-created-at').attr('src', '/themes/mobile/assets/img/order_by_both.png');
            $('#img-order-by-sell-price').attr('src', '/themes/mobile/assets/img/order_by_both.png');

            $('.btn-order-by[data-order-by="created_at"]').attr('data-order-type', 'desc');
            $('.btn-order-by[data-order-by="sell_price"]').attr('data-order-type', 'desc');
            break;

        default :
            break;
    }

    var loading = '<div class="row">'
        + '<div class="col-xs-12 scroll-loading">'
        + '<div><img src="/themes/mobile/assets/img/loading.gif"></div>'
        + '</div>'
        + '</div>';

    $('#pkey-content').html(loading);

    $.ajax({
        type: 'get',
        url: url
    }).done(function (msg) {
        totalPage = $('#pkey-content').attr('data-total-page');
        totalItem = $('#pkey-content').attr('data-total-item');
        id = $('#pkey-content').attr('id');
        collection = $('#pkey-content').attr('data-collection');
        q = $('#pkey-content').attr("data-keyword");

        newDiv = '<div class="row search_content"'
        + ' data-collection="' + collection + '"'
        + ' data-keyword="' + q + '"'
        + ' data-total-page="' + totalPage + '"'
        + ' data-total-item="' + totalItem + '"'
        + ' id="pkey-content"'
        + '>'
        + '</div>';

        $('#pkey-content').replaceWith(newDiv);

        $('#pkey-content')
            .html(msg)
            .jscroll({
                loadingHtml: '<div class="row search_content">'
                + '<div class="col-xs-12 scroll-loading">'
                + '<div><img src="/themes/mobile/assets/img/loading.gif"></div>'
                + '</div>'
                + '</div>',
                nextSelector: 'a:last',
                callback: function () {
                    $('#no-category').remove();
                }
            });

        //addCountdown();
    }).fail(function () {
        $('#pkey-content')
            .html('<div class="row search_content">'
            + '<div class="col-xs-12 scroll-loading">'
            + '<div>No response from server.</div>'
            + '</div>'
            + '</div>')
    });

}


function loadMore() {
    page = parseInt($('#load-more').attr('data-page')) + 1;
    totalPage = parseInt($('#pkey-content').attr('data-total-page'));

    if (page <= totalPage) {
        $('#load-more').attr('data-page', page);
        var loadingHtml = '<div class="row">'
            + '<div class="col-xs-12 scroll-loading">'
            + '<div><img src="/themes/mobile/assets/img/loading.gif"></div>'
            + '</div>'
            + '</div>';

        $('#pkey-content')
            //.append(callback)
            .jscroll({
                loadingHtml: loadingHtml,
                callback: loadMore,
                nextSelector: 'a.anchor_href:last'
            });
    }
    $('#pkey-content').css('display', 'block');
    $('#no-category').remove();
}
