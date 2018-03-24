$(function(){

    console.log("test...");

    $('.anchor-view-by').on('click', function(event){

        event.preventDefault();
        anchor = $(this);


        anchor.siblings('a').removeClass('active');
        anchor.addClass('active');

        var viewBy = anchor.attr('data-view-by');
        //alert(anchor.children('img').attr('src'));
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


    $('.btn-order-by').on('click', function(event){
        event.preventDefault();
        button = $(this);
        orderBy = button.attr('data-order-by');
        orderType = button.attr('data-order-type');
        pe = button.attr('data-pe');
        href = button.attr('data-href');


        viewBy = $('.view-by').children('a[class~="active"]').attr('data-view-by');

        orderType = orderType.toLowerCase();
        newOrderType = orderType;
        if (button.hasClass('active'))
        {
            if (orderType == "desc")
            {
                orderType ="asc";
                newOrderType = "asc";
            }
            else
            {
                orderType = "desc";
                newOrderType = "desc";
            }
        }
        else
        {
            newOrderType = "desc";
        }



        button.attr('data-order-type', newOrderType);
        button.attr('data-order-current', orderType);

        switch (orderBy)
        {
            case "published_at" :
                if (orderType == "desc")
                {
                    $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
                }
                else
                {
                    $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
                }
                $('#img-order-by-price').attr('src', '/themes/mobile/assets/img/order_by_both.png');
                $('#img-order-by-discount').attr('src', '/themes/mobile/assets/img/order_by_both.png')

                $('.btn-order-by[data-order-by="price"]').attr('data-order-type', 'desc');
                $('.btn-order-by[data-order-by="discount"]').attr('data-order-type', 'desc');

                break;

            case "price" :
                if (orderType == "desc")
                {
                    $('#img-order-by-price').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
                }
                else
                {
                    $('#img-order-by-price').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
                }
                $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both.png');
                $('#img-order-by-discount').attr('src', '/themes/mobile/assets/img/order_by_both.png');

                $('.btn-order-by[data-order-by="published_at"]').attr('data-order-type', 'desc');
                $('.btn-order-by[data-order-by="discount"]').attr('data-order-type', 'desc');
                break;

            case "discount" :
                if (orderType == "desc")
                {
                    $('#img-order-by-discount').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
                }
                else
                {
                    $('#img-order-by-discount').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
                }
                $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both.png');
                $('#img-order-by-price').attr('src', '/themes/mobile/assets/img/order_by_both.png');

                $('.btn-order-by[data-order-by="published_at"]').attr('data-order-type', 'desc');
                $('.btn-order-by[data-order-by="price"]').attr('data-order-type', 'desc');
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

function initLoad()
{

    var loadMoreUrl = $('.anchor_href').attr('href');
    //console.log('initLoad');
    loadContent();

    //$('#pkey-content').css('display', 'block');
}


function loadContent() {


    //console.log("function loadContent");
    viewBy = $('.view-by').children('a[class~="active"]').attr('data-view-by');
    orderBy = $(".order-by button[class*='active']").attr('data-order-by');
    button = $(".order-by button[class*='active']");
    orderType = $('.order-by button[class*="active"]').attr('data-order-type');
    url = $('#load-more').attr('data-href');
    collectionKey = $('#pkey-content').attr('data-collection-pkey');
    page = parseInt($('#load-more').attr('data-page'));

    // Cache Page Expired At
    pe = $('#load-more').attr('data-pe');


    anchorHref = $('a.anchor_href').attr('href');
    //alert("anchorHref Before = " + anchorHref);

    regExp = /page=([0-9]*)/
    //anchorHref = anchorHref.replace(regExp, "page=1");

    orderType = orderType.toLowerCase();
    newOrderType = orderType;
    // [B] Change Image
    button.attr('data-order-type', newOrderType);
    button.attr('data-order-current', orderType);
    // $('#load-more').attr('data-page', 1);
    switch (orderBy)
    {
        case "published_at" :
            if (orderType == "desc")
            {
                $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
            }
            else
            {
                $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
            }
            $('#img-order-by-price').attr('src', '/themes/mobile/assets/img/order_by_both.png');
            $('#img-order-by-discount').attr('src', '/themes/mobile/assets/img/order_by_both.png')

            $('.btn-order-by[data-order-by="price"]').attr('data-order-type', 'desc');
            $('.btn-order-by[data-order-by="discount"]').attr('data-order-type', 'desc');

            break;

        case "price" :
            if (orderType == "desc")
            {
                $('#img-order-by-price').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
            }
            else
            {
                $('#img-order-by-price').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
            }
            $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both.png');
            $('#img-order-by-discount').attr('src', '/themes/mobile/assets/img/order_by_both.png');

            $('.btn-order-by[data-order-by="published_at"]').attr('data-order-type', 'desc');
            $('.btn-order-by[data-order-by="discount"]').attr('data-order-type', 'desc');
            break;

        case "discount" :
            if (orderType == "desc")
            {
                $('#img-order-by-discount').attr('src', '/themes/mobile/assets/img/order_by_both_down_active.png');
            }
            else
            {
                $('#img-order-by-discount').attr('src', '/themes/mobile/assets/img/order_by_both_up_active.png');
            }
            $('#img-order-by-published-at').attr('src', '/themes/mobile/assets/img/order_by_both.png');
            $('#img-order-by-price').attr('src', '/themes/mobile/assets/img/order_by_both.png');

            $('.btn-order-by[data-order-by="published_at"]').attr('data-order-type', 'desc');
            $('.btn-order-by[data-order-by="price"]').attr('data-order-type', 'desc');
            break;

        default :
            break;
    }

    // [E] Change Image



    //console.log('anchorHref = ' + anchorHref);
    //$('a.anchor_href').attr('href', anchorHref);

    var loading = '<div class="row">'
        + '<div class="col-xs-12 scroll-loading">'
        + '<div><img src="/themes/mobile/assets/img/loading.gif"></div>'
        + '</div>'
        + '</div>';
    $('#pkey-content').html(loading);

    $.ajax({
        type: 'get',
        url: url + '?collectionKey='+collectionKey+'&viewBy='+viewBy
                 + '&orderBy='+orderBy+'&order='+orderType+'&page='+page+'&pe='+pe
    })
        .done(function( msg ) {



            collectionKey = $('#pkey-content').attr('data-collection-pkey');
            totalPage = $('#pkey-content').attr('data-total-page');
            totalItem = $('#pkey-content').attr('data-total-item');
            id = $('#pkey-content').attr('id');



            newDiv = '<div class="row"'
                       + ' data-collection-pkey="'+collectionKey+'"'
                       + ' data-total-page="'+totalPage+'"'
                       + ' data-total-item="'+totalItem+'"'
                       + ' data-pe="'+pe+'"'
                       + ' id="pkey-content"'
                    + '>'

                    + '</div>';


            $('#pkey-content').replaceWith(newDiv);

            $('#pkey-content')
                .html(msg)
                .jscroll({
                    loadingHtml: '<div class="row">'
                        + '<div class="col-xs-12 scroll-loading">'
                        + '<div><img src="/themes/mobile/assets/img/loading.gif"></div>'
                        + '</div>'
                        + '</div>',
                    nextSelector: 'a:last',
                    callback: function()
                    {
                        //addCountdown();
                        //console.log('callback jscroll');
                        $('#no-category').remove();
                    }
                });

            //addCountdown();
        })
        .fail(function() {
            $('#pkey-content')
                .html('<div class="row">'
                    + '<div class="col-xs-12 scroll-loading">'
                    + '<div>No response from server.</div>'
                    + '</div>'
                    + '</div>')
        });

}
function loadMore()
{
    //console.log('loadMOre');
    page = parseInt($('#load-more').attr('data-page')) + 1;
    totalPage = parseInt($('#pkey-content').attr('data-total-page'));
    //console.log('page = ' + page + ', totalPage = ' + totalPage);

    if (page <= totalPage)
    {

        //currentPage = parseInt($('#load-more').attr('data-page')) + 1;
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
                callback : loadMore,
                nextSelector: 'a.anchor_href:last'
            });


    }
    $('#pkey-content').css('display', 'block');
    $('#no-category').remove();
}
