var Product = Product || {};

Product.levelD = (function($) {

    var me = me || {};
    me.addingDialog = $('#cart-adding');
    me.installmentDialog = $('#cart-installment');
    me.selectInstallmentDialog = $('#cart-select-installment');
    me.alertSelectOption = "";

    me.init = function() {
        me.alertSelectOption = "<div class='box_msg'><span>* " + __("level-d-option-alert") +  "</span></div>";

        $(".special_price").on('change', function() {
            me.calculatePromotions();
        });

        $('.product-addtocart').on('real-inventory-change', function(){
           var $this = $(this);
           var is_wow = $('.product-qty').data('is-wow');
           var currentInventory = $('.product-addtocart').data('real-inventory-id');
           var $productQty = $('.product-qty');

           // check is wow
           if(typeof is_wow[currentInventory] != 'undefined' && is_wow[currentInventory] == true)
           {
               $productQty.attr('max', 1).prop('max', 1).val(1).attr('disabled', 'disabled').prop('disabled', true);
               //$(this).data('is-wow', true);
           }
           else
           {
               $productQty.attr('max', 5).prop('max', 5).val(1).attr('disabled', '').prop('disabled', false);
               //$(this).data('is-wow', false);
           }
           //$('.product-addtocart').trigger('button-deactivate');
        });

        var product_pkey = $('.prd_price_list').data('product-pkey');

        $.ajax({
            type : 'GET',
            url : '/ajax/cart/wow-inventories?product_pkey=' + product_pkey,
            success : function(response) {

                    if ($('.product-addtocart').length < 1)
                    {
                        $('<div class="product-addtocart"></div>').appendTo('body');
                    }
                    $('.product-addtocart').data('inventories-wow-in-cart', response);
                //$('.product-addtocart').trigger('button-deactivate');
            },
            error: function(err){
                //$('.product-addtocart').trigger('button-deactivate');
            }
        });

        $('.product-addtocart').on('button-activate', function() {
            $(this).data('activate', 'true');
            $(this).css('background-color', 'rgb(164, 164, 164)');
            $(this).css('border-bottom-color', 'rgb(115, 115, 115)');
            $(this).css('cursor', '');
        });

        $('.product-addtocart').on('button-deactivate', function() {
            $(this).data('activate', 'false');
            $(this).css('background-color', '');
            $(this).css('border-bottom-color', '');
            $(this).css('cursor', 'default');
        });

        // $('.style-option').on('click', function(){
        //     $('.product-addtocart').trigger('button-activate');
        // });

        $('.product-addtocart').trigger('button-activate');

        $('.product-addtocart').hover(function(){
            $(this).css('cursor', ($(this).data('activate') == 'true' ? 'default' : ''));
        });


        $('.product-addtocart').on('click', function() {

            var $this = $(this);

            if($this.data('activate') == 'true')
            {
                return false;
            }

            var inventories_wow_in_cart = $('.product-addtocart').data('inventories-wow-in-cart');
            var currentInventory = $('.product-addtocart').data('real-inventory-id');

            //alert($(this).data('is-wow'));

            if($(this).data('is-wow') == true)
            {
                if(typeof inventories_wow_in_cart[currentInventory] != 'undefined' && inventories_wow_in_cart[currentInventory] != 'null')
                {
                    if(inventories_wow_in_cart[currentInventory] >= 100)
                    {
                        me.showAlertDialog(__('ไม่สามารถเพิ่มสินค้าได้'), __('item-already-in-cart-limit-1-item'));
                        return;
                    }


                    $(document).one('cart:addedItem', function(){
                        var added_product_index = inventories_wow_in_cart[currentInventory];
                        $.each(inventories_wow_in_cart, function(index, value)
                        {
                            if(inventories_wow_in_cart[index] == added_product_index)
                            {
                                inventories_wow_in_cart[index] = 100*inventories_wow_in_cart[index];
                            }
                        });

                        $('.product-addtocart').data('inventories-wow-in-cart', inventories_wow_in_cart);
                        return;
                    });
                    me.startAddToCart();
                }
            }
            else
            {

                me.startAddToCart();
            }

        });

//        $(function () {
//            $('.style-option').on('click', function(){
//                    var inventory_id = $('.product-addtocart').data('inventory-id');
//                    if(inventory_id)
//                    {
//                        alert(inventory_id);
//                    }
//            });
//        });

//        $('.product-qty').on('click', function())

        //listen with full cart event.
        $(document).bind('cart:addedItem', function(e, response) {
            me.showLightbox(response);
        });

    };

    me.startAddToCart = function() {

        var inventory_id = $('.product-addtocart').data('inventory-id');

        //return false;

        //To check unselected options.
        if ( ! inventory_id)
        {
            //$("div.box_msg").remove();
            $(".type_container").each(function(e){
                if( ! $(this).find("li a").hasClass("active") ){
                    var option_txt = $(this).data("options-name");
                   // $(this).after( me.alertSelectOption.replace(":message_placeholder", option_txt) );
                }
            });
            return false;
        }

        // If product is out of stock then do nothing.
        if (inventory_id == 'out_of_order')
        {
            return false;
        }

        return me.showInstallmentDialog();

    };

    me.showInstallmentDialog = function() {

        var item_installment = $('.product-addtocart').data('allow-installment');
        //To ensure that item_installment has value.
        if(item_installment == ""){
            item_installment = false;
        }
        //return false;
//        var revealConfig = {
//            animation: 'none',
//            closeonbackgroundclick: true,
//            dismissmodalclass: 'popup_ok'
//        };
        //Product.Cart.updateData();
        $('.installment_message').hide();
        $('.cart-installment-button').hide();

        $('.cart-installment-select[value="normal"]').click();


        //add normal cart
        return me.addItem();

        /**
        if (Cart.data.type == 'installment' && Cart.data.cart_details.length > 0)
        {
            if (item_installment == true)
            {
                $('.installment_message_2').show();
            }

            $('.cart-installment-button_ok').show();
            me.installmentDialog.reveal(revealConfig);
        }
        else
        {

            if (item_installment == true)
            {
                //add installment lightbox.
                me.selectInstallmentDialog.reveal(revealConfig);
                $('.cart-installment-button_next').on('click', function() {
                    me.selectInstallmentDialog.trigger('reveal:close');
                    var type = $('.cart-installment-select:checked').val();

                    if (type == 'normal' || Cart.data.cart_details.length == 0)
                    {
                        me.addItem();
                    }
                    else
                    {
                        $('.installment_message_1').show();
                        $('.cart-installment-button_add').show();
                        $('.cart-installment-button_cancel').show();

                        $('.cart-installment-button_add').on('click', function() {
                            $('.cart-installment-select[value="normal"]').click();
                            me.addItem();
                        });

                        $('.cart-installment-button_cancel').on('click', function() {
                            me.selectInstallmentDialog.trigger('reveal:close');
                        });

                        me.installmentDialog.reveal(revealConfig);
                    }

                    me.selectInstallmentDialog.trigger('reveal:close');
                });

                me.selectInstallmentDialog.on('reveal:close', function() {
                    $('.cart-installment-button_next').off();
                    $('.cart-installment-button_ok').off();
                    $('.cart-installment-button_add').off();
                    $('.cart-installment-button_cancel').off();
                });
            }
            else
            {
                $('.cart-installment-select[value="normal"]').click();
                //add normal cart
                me.addItem();
            }
        }
        **/
    };

    // when it's done. Show cart lightbox
    me.cartLightbox = function(){
        $(document).trigger('refresh-cart-lightbox');
        $('.topright-cart-btn').trigger("click");

        if (jQuery().textBlink) {
            $(".text-blink").textBlink();
        }
    };

    me.addItem = function() {
        $(document).trigger("show-ajax-loading");
        me.installmentDialog.trigger('reveal:close');
        //me.showAddingDialog();

        //return true;

        var response;
        var inventory_id = $('.product-addtocart').data('inventory-id');
        var qty = $('.product-qty').val();
        var type = $('.cart-installment-select:checked').val();
        var data = {
            inventory_id: inventory_id,
            qty: qty,
            type: type
        };

        var result = false;

        var addCartUrl = "/ajax/v2/cart/add-item?";
        if(LANG == "en"){
            addCartUrl = "/"+LANG+addCartUrl;
        }


        //$('.product-addtocart').trigger('button-activate');

        $.ajax({
            async: true,
            type : 'POST',
            url : addCartUrl + $.param(data),
            data : {},
            success: function(r) {
                //alert("alert");

                $(document).trigger("hide-ajax-loading");
                me.hideAddingDialog();
                //$('.product-addtocart').trigger('button-activate');
                if (r.status == 'error')
                {
                    me.showAlertDialog(__('ไม่สามารถเพิ่มสินค้าได้'), __(r.message));
                }
                else
                {
                    response = r;
                    $(document).trigger('cart:addedItem', [response]);
                }
            },
            error: function(e){
                $(document).trigger("hide-ajax-loading");

                //$('.product-addtocart').trigger('button-deactivate');
            }
        });

        return result;
    };

    me.showLightbox = function (response) {

        Cart.data = eval(response.data);
        Product.Cart.renderCartList();

        //trigger refresh full cart lightbox.
        //if(Cart.data.type == 'normal'){
            me.cartLightbox();
        //}

//        if ( Cart.data.type == 'installment')
//        {
//            me.selectPaymethodMethod();
//            me.goToCheckout();
//        }
    };

    me.goToCheckout = function() {
        //console.log('redirect to = /'+currentLocale+'/checkout/step1');
        location.href = '/'+currentLocale+'/checkout/step1';
    };

    me.showAddingDialog = function() {

        me.addingDialog.reveal({
            animation: 'none'
        });

    };

    me.hideAddingDialog = function() {

        me.addingDialog.trigger('reveal:close');

    };

    me.showAlertDialog = function(title, msg) {
        if ( ! msg) return;

        $('.alert-title').text(__(title));
        $('.alert-message').text(__(msg));

        $('#cart-alert').reveal({
            animation: 'none',
            dismissmodalclass: 'popup_ok'
        });
    };

    me.selectPaymethodMethod = function(){
        var pkey_channel = '156813837979402';
        $.ajax({
            async: false,
            type : 'POST',
            url : '/ajax/checkout/set-payment-info',
            data: {
                payment_method: pkey_channel
            },
            success: function(data){
                // Do nothing
            }
        });
    }

    me.calculatePromotions = function() {
        /// update pay / month for each box ///
        $('.product__promotion_item').each( function(index) {
            var pay = 0;
            var price = $('.normal_price').text();

            /// if special price show, get price from it ///
            if ($('.special_price').length)
            {
                price = $('.special_price').text();
            }
            //var price = $('.special_price').text();

            /// start with ///
            $(this).find('.product__promotion_bank_inst_text').text(__("pay-per-month"));

            /// if price is range, get the min price ///
            if (price.indexOf('-') >= 0)
            {
                $(this).find('.product__promotion_bank_inst_text').text(__("pay-start"));

                var prices = price.split('-');
                price = prices[0].trim();

                if (price == "")
                {
                    price = 0;
                }
            }

            price = price.replace(',', "");
            price = parseInt(price);

			$('.product__promotion_item').each(function(idx, val){
                var self = $(this),
                    period = self.find('.discount_period').text(),
                    payPerMonth = self.find('.pay_per_month');

                period = parseInt(period);
                pay = price / period;
                payPerMonth.text("₱ " + pay.formatMoney());

            });
            /*var period = $(this).find("#discount_period").text();
            period = parseInt(period);

            pay = price / period;

            $(this).find('#pay_per_month').text("₱ " + pay.formatMoney());*/
        });

        return true;
    }

    me.checkDiscountPrice = function() {
        /// if has special_price, add strike through to normal_price ///
        if ($('.special_price').length)
        {
            $('.normal_price').addClass('discount');
        }
    }

    me.setThumbnailZoom = function() {
        if ($.browser.msie) {
            $('#product_thumbnail').jqzoom({
                zoomType: 'standard',
                lens: true,
                preloadImages: false,
                alwaysOn: false,
                zoomWidth: 300,
                zoomHeight: 300
            });
        }
        else {
            $('#product_thumbnail').addimagezoom({
                zoomrange: [2, 8],
                magnifiersize: [320, 320],
                cursorshade: true
                //largeimage: $('.product_img_big a').attr('href')
            });
        }


        return true;
    }

    return me;

})(jQuery);

$(document).ready(function() {
    Product.levelD.init();

    //Product.levelD.setThumbnailZoom();
    Product.levelD.checkDiscountPrice();
    Product.levelD.calculatePromotions();

	$('.btn_trueyou_valid').click(function () {
		var data_url = $(this).attr('data-url');
		window.location = data_url;
	});

	var has_variant = $('.prd_price_list').attr('data-has-variant');
	if(has_variant == '1')
	{
		//$('.product-addtocart').trigger('click');
	}

	$('.style-option').on('click', function() {
		$(this).parents('.prd_control').find('.box_msg').remove();
	});
    //$(".special_price").text('30,000').trigger('change');
});
