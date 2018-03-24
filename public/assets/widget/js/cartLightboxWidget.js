var cartLightbox = (function($) {
    var me = {};

    me.config = {
        editQty: true,
        showShippingMethod: false,
        editShippingMethod: false,
        maxQty: 5,
        itemCount: 0,
        forceShowRemoveBtn: false,
        showImage: true
    };

    me.productlistTemplate = "\n\
        <% if (checkout.items_count != undefined && checkout.items_count > 0){ %> <% vendor_count = 1 %> \n\
            <% show_group = false %>\n\
            <% if(Object.keys(checkout.shipments).length > 1){ show_group = true }%>\n\
            <% $.each(checkout.shipments, function(skey, shipment){ %> \n\
                <div class='cart-box'> \n\
                    <div class='cart-title'><%= __('cart-shops-product-lbl') %> : <span class='vendor-name'><%= __('replace-shop-name') %> <% if(show_group == true){ %>(<%= __('replace-vendor-name') %> <%= vendor_count %><% vendor_count++ %>) <% } %></span> (<%= shipment.items_count %> <%= __('cart-item-unit') %>)</div> \n\
                    <!-- [S] Product list per shop --> \n\
                    <% $.each(shipment.items, function(ikey, item){ %> \n\
                        <div class='cart-title-list' > \n\
                            <% if( cartLightbox.config.showImage === true ) { %>\n\
                                <div class='cart-box-img' ><img src='<% if(item.thumbnail != undefined && item.thumbnail != null && item.thumbnail != '') { print(item.thumbnail); }else{ print(site_url+'themes/checkout/images/image-not-found-105.jpg'); } %>' width='95' height='95' /></div> \n\
                            <% } %>\n\
                            <div class='left'> \n\
                                <div class='cart-box-name' <% if(cartLightbox.config.showImage == false){ print('style=\"width:529px;\"'); } %> > \n\
                                    <h2><%= item.name %></h2> \n\
                                </div> \n\
                                <div class='cart-box-price' >\n\
                                    <% if( item.price != item.net_price ) { %>\n\
                                        <span class='alert'><%= parseFloat(item.price).formatMoney(2) %></span><br /> \n\
                                        <span class='line-through'><%= parseFloat(item.net_price).formatMoney(2) %></span><br /> \n\
                                        <%= __('cart-discount-percent-lbl') %> <%= Math.floor(( (item.net_price - item.price) / item.net_price ) * 100) %> %\n\
                                    <% }else{ %>\n\
                                        <span><%= parseFloat(item.price).formatMoney(2) %></span>  \n\
                                    <% } %>\n\
                                </div> \n\
                                <div class='cart-box-no'> \n\
                                    <% if (typeof $('.product-addtocart').data('inventories-wow-in-cart') != 'undefined' && $('.product-addtocart').data('inventories-wow-in-cart')[item.inventory_id] < 100){ %> \n\
                                        <% \n\
                                            // set maxQty to maximum if item.quantity more than maxQty.\n\
                                            limit = Math.max(cartLightbox.config.maxQty, item.quantity);\n\
                                        %> \n\
                                        <select name='' class='select-cart cartlightbox-update-item-qty' data-inventory-id='<%= item.inventory_id %>'>\n\
                                            <% for (var i = 1; i <= limit; i++){ %> \n\
                                                <option <% if(item.quantity == i){ print('selected=\"selected\"'); }%>  value='<%= i %>'><%= i %></option> \n\
                                            <% } %> \n\
                                        </select> \n\
                                    <% }else{ %> \n\
                                        <% \n\
                                            // set maxQty to 1 if item is wow item.\n\
                                            limit = 1;\n\
                                        %> \n\
                                        <select name='' class='select-cart cartlightbox-update-item-qty' data-inventory-id='<%= item.inventory_id %>'>\n\\n\
                                            <option <% if(item.quantity == 1){ print('selected=\"selected\"'); }%>  value='<%= 1 %>'><%= 1 %></option> \n\
                                            <% if (item.quantity != 1){ %> \n\
                                                <option  selected = 'selected'  value='<%= item.quantity %>'><%= item.quantity %></option> \n\
                                            <% } %> \n\\n\
                                        </select> \n\
                                    <% } %> \n\
                                </div> \n\
                                <div class='cart-box-price2'><%= (item.price * item.quantity).formatMoney(2) %></div> \n\
                                <div class='clear'></div> \n\
                                <div  class='cart-box-action'> \n\
                                    <% if(cartLightbox.config.itemCount > 1 || cartLightbox.config.forceShowRemoveBtn == true){ %>  \n\
                                        <ul> \n\
                                            <li class='bullet-dot'><a class='cartlightbox-delete-item' data-inventory-id='<%= item.inventory_id %>' href='javascript:void();'><%= __('cart-delete-item-lbl') %></a></li> \n\
                                        </ul> \n\
                                    <% } %> \n\
                                </div> \n\
                            </div> \n\
                            <div class='clear'></div> \n\
                        </div> \n\
                    <% }); %>\n\
                    <!-- [E] Product list per shop --> \n\
                    <% if(cartLightbox.config.showShippingMethod === true) { %>    \n\
                        <% if (cartLightbox.config.editShippingMethod === true){ %> \n\
                           <!-- <div class='cart-send'> \n\
                                <div class='total-list bdr-none'> \n\
                                    <p class='control-label-total'><%= __('cart-shipping-method-lbl') +'sssswdwdwddwd' %> : \n\
                                        <select name='' class='select-cart-send cartlightbox-update-shipping-method' data-shipment-id='<%= skey %>'> \n\
                                            <% if (shipment.available_shipping_methods != undefined && Object.keys(shipment.available_shipping_methods).length > 0){ %> \n\
                                                <% $.each(shipment.available_shipping_methods, function(key, shipmentMethod){ %> \n\
                                                    <option <% if (key.toString() == shipment.shipping_method){ print('selected=\"selected\"'); } %> value='<%= key %>'>\n\
                                                        <%= shipmentMethod.name + ' (' + shipmentMethod.fee.formatMoney(2) + ' ' + __('cart-baht-lbl') + ')' %>\n\
                                                    </option> \n\
                                                <% }); %> \n\
                                            <% }else{ %> \n\
                                                <option><%= __('cart-enter-address-lbl') %></option> \n\
                                            <% } %> \n\
                                        </select> \n\
                                    </p> \n\
                                    <div class='clear'></div> \n\
                                </div> \n\
                            </div> --> \n\
                            <div class='clear'></div> \n\
                        <% }else{ %> \n\
                           <!-- <div class='cart-send'> \n\
                                <div class='total-list bdr-none'> \n\
                                    <p class='control-label-total'><%= __('cart-shipping-method-lbl') + 'sssfeefef' %> : \n\
                                        <%  var shipping_method = shipment.shipping_method; \n\
                                            if( shipment.available_shipping_methods[shipping_method] != undefined ){  \n\
                                                var shipmentMethod = shipment.available_shipping_methods[shipping_method]; \n\
                                                //print( shipmentMethod.name + ' (' + shipmentMethod.description + ') ' + __('cart-delivery-fare') + ' ' + shipmentMethod.fee.formatMoney(2) + ' ' + __('cart-baht-lbl') ); \n\
                                                print( shipmentMethod.name + ' (' + shipmentMethod.fee.formatMoney(2) + ' ' + __('cart-baht-lbl') + ')' ); \n\
                                            } %> \n\
                                    </p> \n\
                                    <div class='clear'></div> \n\
                                </div> \n\
                            </div> -->\n\
                            <div class='clear'></div>   \n\
                            <div class='clear'></div>    \n\
                        <% } %> \n\
                    <% } %>   \n\
                </div>  \n\
            <% }); %> \n\
        <% }else{ %> \n\
            <div style='text-align: center;color:red;padding-bottom: 50px; padding-top: 50px;'><%= __('cart-no-item') %></div> \n\
        <% } %>";
    me.cartSumaryTemplate = "<div class='total-list'> \n\
                    <p class='control-label-total'><%= __('cart-cost-lbl') %></p> \n\
                    <div class='sum'> \n\
                        <% if(checkout.total_price != undefined){  print(checkout.total_price.formatMoney(2)); } else { var totalPrice = 0; print( totalPrice.formatMoney(2) ); } %></div> \n\
                    <div class='clear'></div> \n\
                </div> \n\
                <div class='total-list'> \n\
                    <p class='control-label-total text-blink' ><%= __('cart-total-delivery-fare') %></p> \n\
                    <div class='sum text-blink'> \n\
                       <% if (checkout.items_count == 0){ %> \n\
                             <span class='text-blink'>-</span> <% \n\
                          } else if (checkout.total_shipping_fee != undefined && checkout.total_shipping_fee == 0) { %> \n\
                             <span class='text-blink' style='color:#95C126;'><% print( __('cart-free-lbl') ); %> </span> <% \n\
                          } else if (checkout.total_shipping_fee != undefined) { %> \n\
                             <span class='text-blink'><% print( checkout.total_shipping_fee.formatMoney(2) ); %> </span> <% \n\
                          } else { \n\
                            var totalShippingFee = 0; %> <span class='text-blink'><% print( totalShippingFee.formatMoney(2) ); %> </span> <% \n\
                          } %> \n\
                    </div> \n\
                    <div> \n\
                        <% if(checkout.shipping_config && checkout.shipping_config.shipping_link != undefined && checkout.shipping_config.shipping_link != ''){ %> \n\
                            <a target='_blank' href='<% print(checkout.shipping_config.shipping_link); %>'><span class='text-blink' style='color:#1155cc;'><% print(checkout.shipping_config.shipping_note); %></span></a>\n\
                        <% } else if ( checkout.shipping_config && checkout.shipping_config.shipping_note != undefined ) { %> \n\
                            <span class='text-blink'> <% print( checkout.shipping_config.shipping_note ); %> </span> \n\
                        <% } %> \n\
                    </div> \n\
                    <div class='clear'></div> \n\
                </div> \n\
                <div class='total-list'> \n\
                    <p class='control-label-total'><%= __('cart-discount-lbl') %></p> \n\
                    <div class='sum'> \n\
                        <% if( checkout.total_discount != undefined ){ \n\
                             print( (checkout.total_discount > 0 ? '-' : '') + checkout.total_discount.formatMoney(2) ); \n\
                           }else{ \n\
                             var discount = 0;  print( discount.formatMoney(2) ); \n\
                           } %> \n\
                    </div> \n\
                    <div> \n\
                        <% if(checkout.promotions != undefined ){ \n\
                             if(checkout.promotions.length > 0){ \n\
                                print('('+__('show-discount-promotion')+' '); \n\
                                    var i;  \n\
                                    for(i in checkout.promotions ){ \n\
                                        print(checkout.promotions[i].name+' '); \n\
                                        \n\
                                    } \n\
                                print(')');    \n\
                             } \n\
                         } %> \n\
                    </div> \n\
                    <div class='clear'></div> \n\
                </div> \n\
                <div class='total-list box'> \n\
                    <p class='control-label-total clr-5'><%= __('cart-total-price-lbl') %></p> \n\
                    <div class='sum clr-5'>\n\
                        <% if(checkout.sub_total != undefined){ \n\
                            print( checkout.sub_total.formatMoney(2) ); \n\
                         }else{ \n\
                            var subTotalPrice = 0; print( subTotalPrice.formatMoney(2) ); \n\
                         } %>\n\
                        <br/>   \n\
                        <small>(<%= __('cart-vat-included') %>)</small> \n\
                    </div>\n\
                    <div class='clear'></div> \n\
                </div>";

    me.productlistTemplateCompiler = _.template(me.productlistTemplate);
    me.cartSumaryTemplateCompiler = _.template(me.cartSumaryTemplate);

    me.init = function(){

        me._listenEvents();

        if($("#cart-popup").data("ajax")){
            me._getCart();
        }


        //Cart close
        $('html, .cart-close').on('click', function(e) {
            if ($(this).is('html') || $(this).is('.cart-close')) {
                if ($(e.target).hasClass('modal-backdrop') || $(this).is('.cart-close')) {
                    $('#cart-popup').modal('hide');
                }
            }
        });

        $('#btn-edit-cart, .checkout-info .topright-cart-btn').on('click', function() {

            $('#cart-popup').css({overflow: 'visible'}).modal('show');
            if ($('#cart-box-info').length === 0)
                $('.cart-box').wrapAll('<div id="cart-box-info"></div>');

            //45 29 197
            $('#cart-box-info').css({overflow: 'auto', maxHeight: $('#cart-popup').height() - 288 + 'px'});

            $(".cart-sum .text-blink").textBlink();
        });


        //Resize cart scrolling
        $(window).bind('resize', function() {
            $('#cart-box-info').css({
                overflow: 'auto',
                maxHeight: $('#cart-popup').height() - 288 + 'px'
                });
        }).trigger('resize');

        //goto checkout step
        $(".cart-goto-checkstep").on('click', function(e){

            $(document).trigger("show-ajax-loading");

            var getCookie = function(cname) {
                var name = cname + "=";
                var ca = document.cookie.split(';');
                for(var i=0; i<ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0)==' ') c = c.substring(1);
                    if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
                }
                return "";
            }

            var stage = getCookie('stage');
            var addition = "";
            if(LANG != "th"){
                addition = LANG + "/";
            }

			if(open_https == 'true')
			{
				checkout_url = site_url_https;
			}
			else
			{
				checkout_url = site_url;
			}

            switch (stage) {
                case's1':
                    page = checkout_url + addition + "checkout/step1";
                    break;
                case's2':
                    page = site_url + addition + "checkout/step2";
                    break;
                case's3':
                    page = checkout_url + addition + "checkout/step3";
                    break;
                default:
                    page = checkout_url + addition + "checkout/step1";
                    break;
            }
            location.href = page;
        });

        //custom events
        $(document).bind('refresh-cart-lightbox', me._renderCartLightbox);
        $(document).bind("update-shipping-method", me._renderCartLightbox);
        me.blinkText();
    };

    me._listenEvents = function(){
        //listen on events

        $(".cartlightbox-update-item-qty").off('change').on('change', me.updateItemQty);
        $(".cartlightbox-delete-item").off('click').on('click', me.deleteItem);
        $(".cartlightbox-update-shipping-method").off('change').on("change", me.updateShippingMethod);
    };

    me.updateItemQty = function(){
        var qty = $(this).val();
        var inventory_id = $(this).data("inventory-id");
        var data = {};
        data[inventory_id] = qty;
        var checkoutData = {};

        var cartUpdateItemUrl = '/ajax/checkout/update-item';
        if(LANG != 'th'){
            cartUpdateItemUrl = "/" + LANG + cartUpdateItemUrl;
        }

        $.ajax({
            type: 'POST',
            url: cartUpdateItemUrl,
            data: {
                items: data
            },
            beforeSend: function(){
                $(document).trigger("show-ajax-loading");
            },
            success: function(response) {
                $(document).trigger("hide-ajax-loading");

                if(response.code == 200){
                    checkoutData = response.data;
                }else{
                    if (response.message)
                    {
                        alert(__(response.message));
                    }
                    checkoutData = null;
                }

                me._renderCartLightbox(null, checkoutData);
                //trigger the event to minicart.
                $(document).trigger("cart-update-item-qty", [checkoutData]);
            },
            error: function(err){
                $(document).trigger("hide-ajax-loading");
            }
        });

        return false;
    };

    me._isInObject = function(key, obj){
        for(var name in obj){
            if(obj[name] == key){
                return true;
            }
        }
        return false;
    }


    me.updateShippingMethod = function(){
//        var shipment_id = $(this).data("shipment-id");
//        var shipping_id = $(this).val();
//        data[shipment_id] = shipping_id;

        var data = {};
        $(".cartlightbox-update-shipping-method").each(function(idx, el){
            data[$(el).data("shipment-id")] = $(el).val();
        });

        var cartShippingMethodUrl = '/ajax/v2/checkout/select-shipment-methods';
        if(LANG != 'th'){
            cartShippingMethodUrl = "/" + LANG + cartShippingMethodUrl;
        }

        $.ajax({
            type: 'POST',
            url: cartShippingMethodUrl,
            data: {
                shipments: data
            },
            beforeSend: function(){
                $(document).trigger("show-ajax-loading");
            },
            success: function(response) {
                $(document).trigger("hide-ajax-loading");

                if(response.code == 200){
                    checkoutData = response.data;
                }else{
                    if (response.message)
                    {
                        alert(__(response.message));
                    }
                    checkoutData = null;
                }

                me._renderCartLightbox(null, checkoutData);
                //trigger the event to minicart.
                $(document).trigger("cart-update-shipping-method", [checkoutData]);
            },
            error: function(){
                $(document).trigger("hide-ajax-loading");
            }
        });

        var last_payment = $('.last-payment').text();
        if(last_payment == 'hservice' || last_payment == 'COD')
        {
            //alert('เปลี่ยนช่องทางการชำระเงินที่ไม่ใช่ COD การจัดส่งจะไม่ใช่ COD');
            if( ! me._isInObject(14456917914435, data) )
            {
                var li_act = $('.c-main .c-tab-2 ul li.active').attr('class');
                if(li_act != undefined)
                {
                    var li_val = li_act.replace(" active", "");
                }
                else
                {
                    li_val = undefined;
                }

                /***
				*	ถ้า li_val = hservice คือ มีการเปลี่ยน  shipment เป็น COD โดยการ เลือก selectbox
				*	แต่ ถ้า li_val != hservice คือ มีการกดเปลี่ยน payment channel
				**/
                if(li_val != 'hservice' && li_val != undefined)
                {
                    var str = li_val;
                }
                else
                {
                    //var str = $('.c-main .c-tab-2 ul li').first().attr('class');
                    var str = $('.c-main .c-tab-2 ul li.visa').attr('class');
                }

                var attr_val = str.replace(" active", "");
                $('.last-payment').text(attr_val);
                $('.c-main .c-tab-2 ul li').removeClass('active');
                $('.c-main .c-tab-2 ul li.'+attr_val).addClass('active');
                var div_id = $('li.'+attr_val+' h2 a').attr('href');
                save_payment_info(attr_val);

                $('.c-info-in .tab-pane').removeClass('active');
                $(div_id).addClass('active');

                step3ErrorManager.setAlertMsg();

            }
        }
        else
        {
            if( me._isInObject(14456917914435, data) )
            {
                //alert('ถ้าเปลี่ยนเป็น COD ช่องทางการชำระเงิน จะเป็น COD ด้วย');
                attr_val = 'hservice';
                $('.last-payment').text('hservice');
                $('.c-main .c-tab-2 ul li').removeClass('active');
                $('.c-main .c-tab-2 ul li.'+attr_val).addClass('active');
                var div_id = $('li.'+attr_val+' h2 a').attr('href');

                save_payment_info(attr_val);
                $('.cartlightbox-update-shipping-method').val('14456917914435');
                $('.c-info-in .tab-pane').removeClass('active');
                $(div_id).addClass('active');

                step3ErrorManager.setAlertMsg();

            }
        }

        return false;
    };

    me.deleteItem = function(){

        if(me.config.removeAble < 2){
            alert(__("cart-notallow-remove"));
            return false;
        }

        if ( ! confirm(__('cart-delete-message'))){
            return false;
        }


        var inventory_id = $(this).data("inventory-id");
        var cartDeleteUrl = '/ajax/v2/checkout/remove-item';
        var inventory_id_in_cart = $('.product-addtocart').data('inventories-wow-in-cart');

        if(LANG != 'th'){
            cartDeleteUrl = "/" + LANG + cartDeleteUrl;
        }

		//$("#cart-box-info").html('<div style="text-align: center;color:red;padding-bottom: 50px; padding-top: 50px;">'+ __('loading-txt') +'</div>');

        $.ajax({
            type: 'POST',
            url: cartDeleteUrl,
            data: {
                inventory_id: inventory_id
            },
            beforeSend: function(){
                $(document).trigger("show-ajax-loading");
            },
            success: function(response) {
                $(document).trigger("hide-ajax-loading");

                if(response.code == 200){
                    checkoutData = response.data;
                }else{
                    if (response.message)
                    {
                        alert(__(response.message));
                    }
                    checkoutData = null;
                }

                me._renderCartLightbox(null, checkoutData);

                //trigger the event to minicart.
                $(document).trigger("cart-delete-item", [checkoutData]);

                var delete_inventory_id = inventory_id_in_cart[inventory_id];

                $.each(inventory_id_in_cart, function(index, value) {
                    if(inventory_id_in_cart[index] == delete_inventory_id)
                    {
                        inventory_id_in_cart[index] = value/100;
                    }
                });

//                alert(inventory_id_in_cart[inventory_id]);

                $('.product-addtocart').data('inventories-wow-in-cart', inventory_id_in_cart);

            },
            error: function(){
                $(document).trigger("hide-ajax-loading");
            }
        });

        return false;
    };

    me._renderCartLightbox =  function(event, checkoutData){

        if(checkoutData == undefined || checkoutData == null){
            me._getCart();
            me.blinkText();
            return false;
        }

        //reset value.
        me.config.itemCount = 0;

        if(checkoutData.shipments != undefined){
            $.each(checkoutData.shipments, function(key,shipment){
                $.each(shipment.items, function(key, item){
                    me.config.itemCount++;
                });
            });
        }

        // Hide ดำเนินการต่อ button if there is no item in fullcart.
        if(me.config.itemCount < 1){
            $("#cartlightbox-go-next").hide();
        }else{
            $("#cartlightbox-go-next").show();
        }

        //update cart item quantity.
        $("#cartlightbox-item-quantity").html(checkoutData.items_count);

        //update cart item list.
        var productlistHtml = me.productlistTemplateCompiler({
            checkout: checkoutData
        });

        $("#cart-box-info").html(productlistHtml);

        //update summary prices on cart lightbox.
        summaryHtml = me.cartSumaryTemplateCompiler({
            checkout: checkoutData
        });

        //$.each(checkoutData.checkPriceChange.is_change, function(key, changeitem){
        //    //console.log(changeitem);
        //    disableditem = '[data-inventory-id="'+changeitem+'"]';
        //    $('.select-cart').filter(disableditem).attr('disabled','disabled');
        //
        //});

        if(checkoutData.checkDeletedItem.length > 0){
            $.each(checkoutData.checkDeletedItem, function(key, deleteditem){
                disableditem = '[data-inventory-id="'+deleteditem+'"]';
                $('.select-cart').filter(disableditem).attr('disabled','disabled');
                $('.select-cart').filter(disableditem).addClass('disabled-select');

            });
        }

        $("#cartlightbox-sumary-bottom .total-list").remove();
        $("#cartlightbox-sumary-bottom").prepend(summaryHtml);

        me._listenEvents();
        me.blinkText();

        return false;
    };

    me._getCart = function(){
        var cartDetailUrl = '/ajax/v2/checkout';
        if (LANG != 'th') {
            cartDetailUrl = "/" + LANG + cartDetailUrl;
        }

        $("#cart-box-info").html('<div style="text-align: center;color:red;padding-bottom: 50px; padding-top: 50px;">'+ __('loading-txt') +'</div>');

        $('.product-addtocart').trigger('button-activate');

        $.ajax({
            type : 'POST',
            url : cartDetailUrl,
            success : function(response) {
                if(response.code == 200){
                    var checkoutData = response.data;

                    var product_pkey = $('.prd_price_list').data('product-pkey');
                    var url = '/ajax/cart/wow-inventories';
                    if(product_pkey) {
                        url = url + '?product_pkey=' + product_pkey;
                    }

                    $.ajax({
                        type: 'GET',
                        url: url,
                        success: function (response) {
                            if ($('.product-addtocart').length < 1) {
                                $('<div class="product-addtocart"></div>').appendTo('body');
                            }
                            $('.product-addtocart').data('inventories-wow-in-cart', response);
                            me._renderCartLightbox(null, checkoutData);
                            $('.product-addtocart').trigger('button-deactivate');
                        },
                        error: function (err) {
                        }
                    });

                    // Trigger the event to minicart.
                    // This might be problem, double triggers make double requests.
                    $(document).trigger("cart-get-cart", [checkoutData]);
                    $(document).trigger("hide-ajax-loading");
                }
            },
            error: function(err){
                //$('.product-addtocart').trigger('button-deactivate');
                $(document).trigger("hide-ajax-loading");
            }
        });
    };

    me.blinkText = function () {
        if (jQuery().textBlink && $('#cart-popup').css('display') != "none") {
            $(".text-blink").textBlink();
        }
    };

    return me;
})(jQuery);

$(document).ready(function(){

    cartLightbox.init();

});