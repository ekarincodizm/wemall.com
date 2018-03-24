$(function () {
    var hasVariants = $('.prd_price_list').attr('data-has-variant');

    if (hasVariants == 0) {
        $('.blank').css('display', 'none');
        $('.stock-loading').css('display', 'block');

        $.post(
            '/ajax/product/check-stock',
            {
                product_pkey: $('.prd_price_list').attr('data-product-pkey'),
                data_inv_id: $('.prd_price_list').attr('data-inventory-id')
            },
            function (data) {
                $('.stock-loading').css('display', 'none');
                if (data != "" && data != NaN && data != null && data != undefined) {
                    var jsonDecode = $.parseJSON(data);
                    if(typeof jsonDecode.inventory_id != 'undefined')
                    {
                        $('.product-addtocart').data('real-inventory-id', jsonDecode.inventory_id).trigger('real-inventory-change');
                    }

                    if (jsonDecode.status == 200) {
                        //--- Out of stock ---//
                        if (jsonDecode.stock.toLowerCase() == 'out') {
                            $('.product-addtocart').data('inventory-id', "out_of_order");

                            $('.box-status-has-stock').css('display', 'none');
                            $('.box-status-no-stock').css('display', 'none');

                            $('.box-status-no-stock').css('display', 'block');

                            $('.prd_price_box .order_container .btn_order').addClass('disabled');

                        }
                        //--- Has Stock ---//
                        else {
                            $('.product-addtocart').data('inventory-id', jsonDecode.inventory_id);
                            $('.box-status-has-stock').css('display', 'none');
                            $('.box-status-no-stock').css('display', 'none');
                            $('.box-status-has-stock').css('display', 'block');

                            $('.prd_price_box .order_container .btn_order').removeClass('disabled');
                        }
                    }
                }
            },
            'html'

        );

    }


    $('.style-option').on('click', function (event) {
        event.preventDefault();

        anchor = $(this);

        mediaSet = anchor.parent().parent().attr('data-media-set');
        media_set_pkey = anchor.attr('data-pkey');

        if (!anchor.hasClass('active')) {
            anchor.addClass('active');
            anchor.parent().siblings('li').children('a').removeClass('active');
            option_pkey = {};

            var countTypes = 0;
            typeSelected = 0;
            $('.style-types').find('ul.type_container').each(function (i, v) {
                ul = $(this);
                option_pkey[i] = ul.children('li').children('a.active').attr('data-pkey');
                if (ul.children('li').children('a.active').length > 0) {
                    typeSelected++;
                }
                countTypes++;
            });

            // There are both style types
            if ($('.style-color').length > 0 && $('.style-size').length > 0)
            {
                if (anchor.hasClass('style-color'))
                {
                    $('.no-color').css('display', 'none');
                    $('.no-color-size').css('display', 'none');
                    $('.no-size').css('display', 'inline');
                }
                else if (anchor.hasClass('style-size'))
                {
                    $('.no-color').css('display', 'inline');
                    $('.no-color-size').css('display', 'none');
                    $('.no-size').css('display', 'none');
                }
            }
            //--- There are color only
            else if ($('.style-color').length > 0 && $('.style-size').length <= 0)
            {
                $('.no-color').css('display', 'none');
            }
            //--- There are size only
            else if ($('.style-color').length <= 0 && $('.style-size').length == 0)
            {
                $('.no-size').css('display', 'none');
            }

            if (anchor.hasClass('style-size'))
            {

            }

            if (mediaSet == 1) {
                var ajaxLoader = $('<img src="/themes/itruemart/assets/images/ajax-loader.gif">');
                ajaxLoader.css({
                    position: 'absolute',
                    top: '50%',
                    left: '50%',
                    marginTop: '-33px',
                    marginLeft: '-33px'
                });
                $('.prd_img').html(ajaxLoader);
                $.post(
                    '/ajax/product/get-image',
                    {
                        product_pkey: $('.prd_price_list').attr('data-product-pkey'),
                        media_set_pkey: media_set_pkey
                    },
                    function (data) {
                        if (data != undefined && data != "" && data != NaN && data != null) {
                            var jsonDecode = $.parseJSON(data);

                            // [B]--- Remove Image Zoom ---//
                            $('.zoomtracker').remove();
                            $('.zoomstatus').remove();
                            $('.magnifyarea').remove();
                            // [E] Remove Image Zoom ---//

                            imgxl = '<div id="product_image" class="prd_img" data-zoom-image="' + jsonDecode[0].zoom + '" >';
                            $('.prd_img').replaceWith(imgxl);
                            img = '<img src="' + jsonDecode[0].zoom + '" id="product_thumbnail">'
                            $('.prd_img').html(img);

                            var thumbs = "";
                            // alert(jsonDecode.length);
                            for (var i = 0; i <= jsonDecode.length - 1; i++) {
                                var sm = jsonDecode[i].small;
                                var xl = jsonDecode[i].zoom;
                                thumbs += '<div class="owl-item">';
                                thumbs += '<div class="productCarousel__item">';
                                thumbs += '<a href="" class="show_thumb small" rel="nofollow">';
                                thumbs += '<img src="' + sm + '" data-zoom-large="' + xl + '" />';
                                thumbs += '</a></div></div>';
                            }
                            ;

                            $('.productCarousel__container').html(thumbs);


                            // $('#prd_img').addimagezoom({
                            //     zoomrange: [3, 10],
                            //     magnifiersize: [300, 300],
                            // });
                            // App.itm.zoom();
                            $('#product_image').on('click touchstart', function () {

                                var self = $(this);

                                if (self.data('events').zoom != undefined)
                                    return;

                                self.css({
                                    width: '910px',
                                    height: self.height(),
                                    border: 'solid 1px #ddd',
                                    position: 'relative',
                                    zIndex: 51,
                                    backgroundColor: '#fff'
                                }).find('img').hide().end().zoom({
                                        url: self.data('zoom-image'),
                                        callback: function () {
                                            $(this).animate({
                                                opacity: 1
                                            }).css({
                                                    cursor: 'url(/themes/itruemart/assets/images/icn/mag-minus.png), auto'
                                                });
                                        },
                                        onZoomOut: function () {
                                            self.trigger('zoom.destroy').removeAttr('style').find('img').show();
                                        }
                                    })
                            });

                            $(document).on('click', '.zoomImg', function (e) {
                                $('#product_image').trigger('zoom.destroy').removeAttr('style').css({
                                    cursor: 'url(/themes/itruemart/assets/images/icn/mag-plus.png), auto'
                                }).find('img').show();
                            });

                            $(document).on('touchstart', function (e) {
                                if (!$(event.target).closest('#product_image').length) {
                                    $('#product_image').trigger('zoom.destroy').removeAttr('style').find('img').show();
                                }
                            });

                            $('.productCarousel__container').find('a').on('click', function (ev) {
                                ev.preventDefault();
                                var zoomLarge = $(this).find('img').data('zoom-large');
                                $('#product_image').attr('data-zoom-image', zoomLarge)
                                    .find('img').attr('src', zoomLarge).attr('data-original', zoomLarge);

                                $('#product_image').removeData('zoom-image');
                            });
                        }
                    },
                    'html'
                );

            }

            if (typeSelected == countTypes) {
                $('.blank').css('display', 'none');
                $('.stock-loading').css('display', 'block');
                $('.box-status-no-stock').css('display', 'none');
                $('.box-status-has-stock').css('display', 'none');

                $('.style-option-status').css('display', 'none');


                $(document).trigger("show-ajax-loading");
                $.post(
                    '/ajax/product/check-stock-by-variant',
                    {
                        product_pkey: $('.prd_price_list').attr('data-product-pkey'),
                        option_pkey: option_pkey
                    },
                    function (data) {
                        $('.stock-loading').css('display', 'none');
                        if (data != undefined && data != null && data != "" && data != NaN) {
                            var jsonDecode = $.parseJSON(data);
                            if (jsonDecode.code == 200) {
                                $('.normal_price').html(jsonDecode.net_price);
                                $('.special_price').html(jsonDecode.sell_price).trigger('change');
                                if (jsonDecode.sell_price != 0) {
                                    $('.normal_price').addClass('discount');
                                    $('.special').parents('li').css('display', 'inline');
                                }
                                if ( jsonDecode.net_price == jsonDecode.sell_price) {
                                    $('.normal_price').removeClass('discount');
                                    $('.special').parents('li').css('display', 'none');
                                }

                                if(typeof jsonDecode.inventory_id != 'undefined')
                                {
                                    $('.product-addtocart').data('real-inventory-id', jsonDecode.inventory_id).trigger('real-inventory-change');
                                }

                                //--- Out of stock ---//
                                if (jsonDecode.stock.toLowerCase() == 'out') {
                                    $('.product-addtocart').data('inventory-id', "out_of_order");

                                    $('.box-status-has-stock').css('display', 'none');
                                    $('.box-status-no-stock').css('display', 'none');

                                    $('.box-status-no-stock').css('display', 'block');

                                    $('.prd_price_box .order_container .btn_order').addClass('disabled');

                                }
                                //--- Has Stock ---//
                                else {
                                    $('.product-addtocart').data('inventory-id', jsonDecode.inventory_id);
                                    $('.box-status-has-stock').css('display', 'none');
                                    $('.box-status-no-stock').css('display', 'none');


                                    $('.box-status-has-stock').css('display', 'block');
                                    $('.prd_price_box .order_container .btn_order').removeClass('disabled');                                    

                                }

                                Product.levelD.calculatePromotions();
                            }
                            else {
                            }
                        }
                        $(document).trigger("hide-ajax-loading");
                    },
                    'html');
            }
        }
    });

});
