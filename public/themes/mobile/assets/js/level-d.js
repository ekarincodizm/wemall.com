 var loopProcessActive = {status: true};

$(document).on('doneLevelDContent', function() {

    var $mySwiper1Loop = ($(".swiper-product-container .swiper-slide").length > 1)? true : false;
    var mySwiper1 = new Swiper('.swiper-product-container',{
        pagination: '.pagination',
        loop: $mySwiper1Loop,
        grabCursor: true,
        paginationClickable: true
    })
    //related slider
    var mySwiper = new Swiper('.swiper-related-container',{
        paginationClickable: true,
        slidesPerView: 'auto'
    });

    $(document).ready(function() {

        if ($('.add-to-cart').data('loading-status')=='success') {
            $('.add-to-cart').data('loading-status', false);
            return window.location.reload();
        }

        //share button
        $('#button-share').click(function() {
            if($('#share-button').hasClass("active")){
                $('#share-button').removeClass( "active" );
                $('#button-share').html("Share");
            }else{
                $('#share-button').addClass( "active" );
                $('#button-share').html("Close");
            }
        });

        //calculate Policy Tab
        var numTabs = $('.nav-tabs').find('li').length;
        var tabWidth = 100 / numTabs;
        var tabPercent = tabWidth + "%";
        $('.nav-tabs li').width(tabPercent);

        //วางกากบาทบนช่อง disable
        var w_capacity = $('.capacity-option.disable').width();
        var w_color = $('.color-option.disable').width();
        var h_capacity = $('.capacity-option.disable').height();
        var h_color = $('.color-option.disable').height();
        var padding_capacity_top = $('.capacity-option.disable').css('padding-top');
        var padding_capacity_left = $('.capacity-option.disable').css('padding-left');
        var padding_color_top = $('.color-option.disable').css('padding-top');
        var padding_color_left = $('.color-option.disable').css('padding-left');
        //convert to int
        var p_capacity_top = parseInt(padding_capacity_top);
        var p_capacity_left = parseInt(padding_capacity_left);
        var p_color_top = parseInt(padding_color_top);
        var p_color_left = parseInt(padding_color_left);
        //set margin กากบาท
        $('.capacity-option.disable img').css("margin-top", "-" + (p_capacity_top-2) + "px");
        $('.capacity-option.disable img').css("margin-left", "-" + padding_capacity_left);
        $('.color-option.disable img').css("margin-top", "-" + padding_color_top);
        $('.color-option.disable img').css("margin-left", "-" + padding_color_left);
        //set width กากบาท
        $('.capacity-option.disable img').width(w_capacity + (p_capacity_left*2));
        $('.color-option.disable img').width(w_color + (p_color_left*2));
        $('.capacity-option.disable img').height(h_capacity + (p_capacity_top*2));
        $('.color-option.disable img').height(h_color + (p_color_top*2));

        //countdown : more information http://hilios.github.io/jQuery.countdown/
        var dateTime = $('#countdown-discount').data('datetime');
        $("#countdown-discount").countdown(dateTime, function(event) {
            var totalHour = event.offset.totalDays * 24 + event.offset.hours;
            $(this).html(event.strftime(totalHour + ':%M:%S'));
        });

        // show/hide BackToTop
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() > 1500) {
                //show arrow back to top
                $('#backtotop-arrow').show();
            } else {
                //hide arrow back to top
                $('#backtotop-arrow').hide();
            }
        });

        // if dont't have style_option add margin:30px
        var product_style = $('.product-style_types').find('div').length;
        if(product_style == 0)
        {
            $('.quantity').parent().attr('style', 'margin-top:30px');
        }

    });

    var addItemData = {};

    // add to cart
    $('.add-to-cart').on('click', function()
    {
        if($(this).hasClass('disabled')) {
            return false;
        }
        if (typeof Cart.data == 'undefined') showAlertDialog('System error! Please try again code:1'); // rare case but just for sure

        var loading_status = $(this).data('loading-status');
        if ( loading_status=='loading' ) {
            return;
        }

        if ( loading_status=='success' ) {
            window.location.reload();
            return;
        }

        $(this).data('loading-status', 'loading');

        if ( ! $(this).data('inventory-id'))
        {
            showAlertDialog(__("select_option"));

            $(this).data('loading-status', 'fail');
            return;
        }
        
        /*if ( $(this).data('wow'))
        {
            showAlertDialog(__('item-already-in-cart-limit-1-item'));

            $(this).data('loading-status', 'fail');
            return;
        }*/

        addItemData.inventory_id = $(this).data('inventory-id');
        addItemData.qty = $('.qty').val();
        addItemData.type = 'normal';

        var stock = $(this).data('stock');

        if (stock == 'no' || stock < addItemData.qty)
        {
            showAlertDialog('Out of stock');
            $(this).data('loading-status', 'fail');
            $('.button-buy .button').css({"text-align": "center"});
            $('.button-buy .button').html('<div class="button"><span>'+__('buy')+'</span></div>');
        }
        /*else if (Cart.data.type == 'installment' && Cart.data.totalQty >= 1)
        {
            // dialog: can not add anywany
            showAlertDialog('ไม่สามารถนำสินค้าชินนี้ใส่ตะกร้าได้ เนื่องจากสินค้าในตระกร้าเป็นแบบ "ผ่อนชำระ" กรุณาชำระสินค้าในตระกร้าก่อนค่ะ');
        }*/
//
//        else if (Product.data.installment.allow)
//        {
//            //dialog: select type
//            $('#popup-choose').modal('show');
//        }
//
        else
        {
            $(document).trigger('add-to-cart', addItemData);
        }

        return false;
    });

    $('.select-type-continue').on('click', function()
    {
        $('#popup-choose').modal('hide');

        if (typeof Cart.data == 'undefined') showAlertDialog('System error! Please try again code:2'); // rare case but just for sure

        addItemData.type = $('[name="optionsRadios"]:checked').val();

        /*if (addItemData.type == 'installment')
        {
            if (Cart.data.totalQty >= 1)
            {
                showAlertDialog('สินค้าชินนี้ไม่สามารถผ่อนชำระได้ เนื่องจากสินค้าผ่อนชำระ"ไม่"สามารถชำระรวมกับชิ้นอื่นได้', 'เพิ่มสินค้าแบบชำระเงินปกติ', function()
                {
                    addItemData.type = 'normal';

                    $(document).trigger('add-to-cart', addItemData);
                });
            }
            else
            {
                $(document).trigger('add-to-cart', addItemData);
            }
        }
        else
        {
            $(document).trigger('add-to-cart', addItemData);
        }*/

        $(document).trigger('add-to-cart', addItemData);
    });

    $(document).on('add-to-cart', function(e, data)
    {
        loopProcessActive.status = true;

        //script for animate processing button ดำเนินการ
        var terms = [__("processing")+"...", __("processing")+".. .", __("processing")+". ..", __("processing")+" ..."];
        function loopProcess() {
            var processButton = $('.button-buy .button span');
            processButton.parent(".button").css({"text-align": "left"});
            processButton.attr("id", "button-processing-green");

            if (loopProcessActive.status == false)
            {
                return;
            }
            var ct = processButton.data("term") || 0;
            processButton.data("term", ct == terms.length -1 ? 0 : ct + 1).text(terms[ct]).show()
                    .delay(250).show(200, loopProcess);
        }
        $('.button-buy a').click(function(){
            $('.button-buy .button').html('<span id="button-processing-green"></span>');
            $('.button-buy .button').css({"text-align": "left"});
            loopProcessActive.status = true;
            loopProcess();
        });

        loopProcess();

        var addCartUrl = "/cart/add-item";
        if(LANG == "en"){
            addCartUrl = "/"+LANG+addCartUrl;
        }
        $.ajax({
            type: 'POST',
            url: addCartUrl,
            data: data,
            success: function(response) {

                if (response.status == 'error')
//                if (typeof cart.totalQty == 'undefined')
                {
                    loopProcessActive.status = false;
                    $('.button-buy .button').css({"text-align": "center"});
                    $('.button-buy .button').html('<div class="button"><span>สั่งซื้อ</span></div>');
                    if(response.message == 'item-already-in-cart-limit-1-item')
                    {
                        showAlertDialog(__(response.message));
                    }
                    else
                    {
                        showAlertDialog('Out of stock');
                    }

                    $('.add-to-cart').data('loading-status', 'fail');
                    return;
                }

                var cart = response.data;

                //prepair lang to redirect.
                var lang_segment = "/";
                if(LANG != "th"){
                    lang_segment = lang_segment + LANG + "/";
                }

                $('.add-to-cart').data('loading-status', 'success');

                location.href = lang_segment+'cart';
//                if (cart.totalQty > 1)
//                {
//
//                    location.href = lang_segment+'cart';
//                }
//                else
//                {
//                    location.href = lang_segment+'checkout/step1';
//                }
            }
        });
    });

    function showAlertDialog(message, continue_text, callback)
    {
        message = message || '';
        continue_text = continue_text || __("ok");
        callback = callback || function(){};

        if ( ! message) return;

        $('#alert-dialog .alert-dialog-message').html(message);
        $('#alert-dialog .alert-dialog-continue').text(continue_text);
        $('#alert-dialog').modal('show');

        callback();
    }

});