var MiniCart = MiniCart || {};

MiniCart.Main = (function($){
    var me = {};
    me.config = {
        editQty: false,
        showShippingMethod: false,
        editShippingMethod: false,
        showDiscount: true,
        showTrueyou: false,
        showCoupon: true,
        maxQty: 5,
        trueyouDiscount: 0,
        isTUAvailablePage: false,
        usertrueyou: false
    };


    me.minicartProductlistTemplate = "<% if(LANG == 'th'){ Coupon_LANG = '';}else{ Coupon_LANG = LANG; } %><div class='cart'> \n\
         <% if (checkout.items_count > 0){ %><% vendor_count = 1 %> \n\
            <% show_group = false %>\n\
            <% if(Object.keys(checkout.shipments).length > 1){ show_group = true }%>\n\
            <% $.each(checkout.shipments, function(skey, shipment){ %> \n\
                <ul> \n\
                    <div class='cart-title'><%= __('cart-shops-product-lbl') %> : \n\
                        <span class='vendor-name'> \n\
                            <%= __('replace-shop-name') %> <% if(show_group == true){ %> (<%= __('replace-vendor-name')%> <%= vendor_count %><% vendor_count++ %>) <% }%> \n\
                        </span>  \n\
                        (<%= shipment.items_count %> <%= __('cart-item-unit') %>) \n\
                    </div> \n\
                    <!-- [S] Product list per shop --> \n\
                    <% $.each(shipment.items, function(ikey, item){ %> \n\
                        <li> \n\
                            <div class='total-list'> \n\
                                <p class='left product-name'><%= item.name %></p> \n\
                                <div class='no-product-list'> \n\
                                    <p class='left'> \n\
                                        <% if (MiniCart.Main.config.editQty === true){ %> \n\
                                            <% // set maxQty to maximum if $item['quantity'] more than maxQty. \n\
                                                limit = Math.max(MiniCart.Main.config.editQty, item.quantity); \n\
                                            %> \n\
                                            <select name='' class='select-cart' data-inventory-id='<%= item.inventory_id %>'> \n\
                                                <% for (var i = 0; i <= limit; i++){ %> \n\
                                                    <option <% if(item.quantity == i){ %> selected='selected' <% } %>  value='<%= i %>'><% if(i == 0){  print(__('delete') ); }else{ print( i ); } %></option> \n\
                                                <% } %> \n\
                                            </select> \n\
                                        <% }else{ %> \n\
                                            <span class='select-cart select-disable'><%= item.quantity %></span> \n\
                                        <% } %> \n\
                                    </p> \n\
                                    <p><%= (item.price * item.quantity).formatMoney(2) %></p> \n\
                                    <div class='clear'></div> \n\
                                </div> \n\
                                <div class='clear'></div> \n\
                            </div> \n\
                            <div class='clear'></div> \n\
                        </li> \n\
                    <% }); %> \n\
                    <!-- [E] Product list per shop --> \n\
                    <!-- [S] Shipment method --> \n\
                    <% if (MiniCart.Main.config.showShippingMethod === true){ %> \n\
                        <% if (MiniCart.Main.config.editShippingMethod === true){ %> \n\
                           <!-- <li> \n\
                                <div class='total-list bdr-btm-none'> \n\
                                    <p class='left product-name clr-5'><%= __('cart-shipping-method-lbl') %></p> \n\
                                    <div class='no-product-list'> \n\
                                        <p class='right'> \n\
                                            <span class='clr-5'> \n\
                                                <select> \n\
                                                    <% if (shipment.available_shipping_methods){ %> \n\
                                                        <% $.each(shipment.available_shipping_methods, function(key, shipmentMethod){ %> \n\
                                                            <option <% if(key.toString() == shipment.shipping_method){ print('selected=\"selected\"'); } %> value='<%= key %>'>\n\
                                                                <%= shipmentMethod.name + ' (' + shipmentMethod.fee.formatMoney(2) + ' ' + __('cart-baht-lbl') + ')' %>\n\
                                                            </option> \n\
                                                        <% }); %> \n\
                                                    <% }else{ %> \n\
                                                        <option><%= __('cart-enter-address-lbl') %></option> \n\
                                                    <% } %> \n\
                                                </select> \n\
                                            </span> \n\
                                        </p> \n\
                                        <div class='clear'></div> \n\
                                    </div> \n\
                                    <div class='clear'></div> \n\
                                </div> \n\
                                <div class='clear'></div> \n\
                            </li> --> \n\
                        <% }else{ %> \n\
                           <!-- <li> \n\
                                <div class='total-list bdr-btm-none'> \n\
                                    <p class='left product-name clr-5'><%= __('cart-shipping-method-lbl') + 'xxxxxxxxsd' %></p> \n\
                                    <div class='no-product-list'> \n\
                                        <p class='right'> \n\
                                            <span class='clr-5'> \n\
                                                <%  var shipping_method = shipment.shipping_method;  \n\
                                                    if (shipment.available_shipping_methods[shipping_method] != undefined){  \n\
                                                        var shipmentMethod = shipment.available_shipping_methods[shipping_method];  \n\
                                                        //print( shipmentMethod.name + ' (' + shipmentMethod.description + ') ' + __('cart-delivery-fare')  + ' ' + shipmentMethod.fee.formatMoney(2) + ' ' + __('cart-baht-lbl') ); \n\
                                                        print( shipmentMethod.name + ' (' + shipmentMethod.fee.formatMoney(2) + ' ' + __('cart-baht-lbl') + ')' );  \n\
                                                    } else { \n\
                                                        print( __('cart-free-shipping-lbl') ); \n\
                                                    } %> \n\
                                            </span> \n\
                                        </p> \n\
                                        <div class='clear'></div> \n\
                                    </div> \n\
                                    <div class='clear'></div> \n\
                                </div> \n\
                                <div class='clear'></div> \n\
                           </li> --> \n\
                        <% } %> \n\
                    <% } %> \n\
                    <!-- [E] Shipment method --> \n\
                </ul> \n\
            <% }); %> \n\
         <% } else { %> \n\
            <div class='cart-title' style='text-align: center;color:red;'><%= __('cart-no-item') %></div> \n\
         <% } %> \n\
    </div>";
    
    me.minicartSimaryTemplate = "<div class='total-list'> \n\
        <p class='control-label-total'><%= __('cart-cost-lbl') %></p> \n\
        <div class='sum sum_total_price'><%= checkout.total_price.formatMoney(2) %></div>  \n\
        <div class='clear'></div>   \n\
    </div>  \n\
    <div class='total-list'> \n\
        <p class='control-label-total text-blink'><%= __('cart-total-delivery-fare') %></p>    \n\
        <div class='sum text-blink'> \n\
            <% if (checkout.total_shipping_fee != undefined && checkout.total_shipping_fee == 0){  %>  \n\
                <span class='text-blink' style='color:#95C126'><% print(__('cart-free-lbl')); %> </span> <% \n\
            } else if (checkout.total_shipping_fee != undefined) { \n\
                var float_total_shipping_fee = parseFloat(checkout.total_shipping_fee); \n\
                print( float_total_shipping_fee.formatMoney(2) ); \n\
            } else {    \n\
                var shippingFee = 0; \n\
                print( shippingFee.formatMoney(2) ); \n\
            } %> \n\
        </div>  \n\
        <div>\
            <% if(checkout.shipping_config && checkout.shipping_config.shipping_link != undefined && checkout.shipping_config.shipping_link != ''){ %> \n\
                <a target='_blank' href='<% print(checkout.shipping_config.shipping_link); %>'><span class='text-blink' style='color:#1155cc;'><% print(checkout.shipping_config.shipping_note); %></span></a>\n\
            <% } else if ( checkout.shipping_config && checkout.shipping_config.shipping_note != undefined ) { %> \n\
                <span class='text-blink'> <% print( checkout.shipping_config.shipping_note ); %> </span> \n\
            <% } %> \n\
        </div>    \n\
        <div class='clear'></div>   \n\
    </div>  \n\
    <% if(MiniCart.Main.config.showCoupon === true){ %>     \n\
        <div class='total-list' id='coupon-container'>  \n\
            <% $.each(checkout.promotions, function(key, promotion){ %> \n\
                <% if( promotion.code != undefined ){ %>\n\
                    <div class='box-discount'>  \n\
                        <p class='control-label-total clr-7 text-ani-1'>   \n\
                            <span><%= __('cart-discount-coupon') + ' ' + promotion.name %></span> \n\
                            <span class='close-discount remove-coupon' data-code='<%= promotion.code %>'> \n\
                                <img src='<%= site_url + 'themes/checkout/assets/images/close.gif' %>' /> \n\
                            </span> \n\
                        </p>    \n\
                        <div class='sum clr-7 text-ani-1'><%= (promotion.totalDiscount>0 ? '-' : '') + promotion.totalDiscount.formatMoney(2) %></div>   \n\
                    </div>  \n\
                <% } %> \n\
            <% }); %> \n\
            <% if( isStep3 ) { %> \n\
            <div class='box-discount'>  \n\
                <div class='control-group'> \n\
                    <form id='coupon_voucher_code' method='post' action='<%= site_url+ Coupon_LANG + '/checkout/apply-coupon' %>'>   \n\
                        <input id='coupon-text' type='text' name='code' class='input-info control-form-coupon' placeholder='<%= __('cart-coupon-placeholder') %>' autocomplete='off' /><input id='coupon_button' type='submit' class='btn-use-coupon' value='<%= __('cart-use-coupon-btn') %>'/>  \n\
                        <div id='coupon_code_error' style='<% if( $('#coupon_code_error').text().length > 0 && checkout.promotions.length == 0 ){ print('display:block;'); }else{ print('display:none;'); } %>'><%= $('#coupon_code_error').html() %></div>   \n\
                    </form> \n\
                </div>  \n\
                <p class='coupon-title clr-7 text-ani-1'><%= __('cart-remark-coupon') %></p>   \n\
            </div>  \n\
            <% } %> \n\
        </div>  \n\
    <% } %>\n\
    <% if(MiniCart.Main.config.showDiscount == true){ %>\n\
        <div class='total-list'>    \n\
            <p class='control-label-total text-blink'><%= __('cart-discount-lbl') %></p> \n\
            <div class='sum text-blink'><%= (checkout.total_discount>0 ? '-' : '') + checkout.total_discount.formatMoney(2) %></div> \n\
            <div class='clear'></div>   \n\
        </div>  \n\
    <% } %>\n\
    <div class='total-list box'> \n\
        <p class='control-label-total clr-5'><%= __('cart-total-price-lbl') %></p>  \n\
        <div class='sum clr-3'><%= checkout.sub_total.formatMoney(2) %><br/><small>(<%= __('cart-vat-included') %>)</small></div> \n\
        <div class='clear'></div>   \n\
    </div>\n\
    <div class='clear'></div>";
    
    me.minicartProductlistTemplateCompiler = _.template(me.minicartProductlistTemplate);
    me.minicartSumaryTemplateCompiler = _.template(me.minicartSimaryTemplate);
    
    me.init = function(){
        
        var step1pattern = /checkout\/step1/gi;
        var step2pattern = /checkout\/step2/gi;
        var step3pattern = /checkout\/step3/gi;
        var currenUri = location.pathname;
        
        if(step1pattern.test(currenUri)){
            me.config.showShippingMethod = false;
            me.config.showDiscount = true;
            me.config.isTUAvailablePage = false;
            me.config.showCoupon = false;
        }else if(step2pattern.test(currenUri)){
            me.config.showShippingMethod = true;
            me.config.showDiscount = true;
            me.config.isTUAvailablePage = false;
            me.config.showCoupon = false;
        }else if(step3pattern.test(currenUri)){
            me.config.showShippingMethod = true;
            me.config.showDiscount = true;
            me.config.isTUAvailablePage = true;
            me.config.showCoupon = true;
        }

        $(document).on('click', '#coupon_button', function(e) {
            e.preventDefault();

            me.addCoupon($(this));

            return;
        });

        //custom events
        $(document).bind('cart-update-item-qty', me._renderMinicart);
        $(document).bind("cart-delete-item", me._renderMinicart);
        $(document).bind("cart-update-shipping-method", me._renderMinicart);
        $(document).bind("cart-get-cart", me._renderMinicart);
        
        me._bindEvent();
    };


    /**
     * addCoupon
     *
     *  - Apply promotion code for web
     *
     * @param elm (HTML DOM)
     */
    me.addCoupon = function (elm) {
        var code = elm.parent().find('#coupon-text').val();
        $('#coupon_code_error').html('');
        $('#coupon_code_error').hide();

        if (code.length <= 0) {
            $('#coupon_code_error').show();
            $('#coupon-container #coupon_code_error').html(__('empty-promotion-code'));
        }
        else {
            $.ajax({
                type: 'POST',
                url: (LANG == 'en' ? '/en' : '') + '/checkout/apply-coupon',
                data: {
                    code: code
                },
                beforeSend: function () {
                    $(document).trigger("show-ajax-loading");
                },
                success: function (response) {
                    if (response.status !== 'success') {
                        $('#coupon_code_error').show();
                        $('#coupon-container #coupon_code_error').html(response.description);
                    }
                    $(document).trigger("refresh-cart-lightbox");
                    $(document).trigger("hide-ajax-loading");
                }
            });
        }

    };

    me._renderMinicart = function(event, checkoutData){

        if(checkoutData == undefined){
            return false;
        }

        /** [S] prepair data before render js template */
        var trueyouDiscount = 0;
        var hasCoupon = false;
        if(checkoutData.promotions != undefined){
            $.each(checkoutData.promotions, function(key, promotion){
                //check coupon in cart. if $hasCoupon is true. Cart will not show trueyou.
                if( promotion.type != undefined ){ 
                    if( promotion.type == 'coupon_code' ){
                        hasCoupon = true;
                    }
                }
                
                if ( promotion.type != undefined){
                    if( promotion.type == 'trueyou'){
                        trueyouDiscount += promotion.totalDiscount;
                    }
                }
            });
        }
        me.config.trueyouDiscount = trueyouDiscount;
        
        if( checkoutData.isTrueyouable != undefined && hasCoupon == false ){
            if( checkoutData.isTrueyouable == true ){
                me.config.showTrueyou = true;
            }else{
                me.config.showTrueyou = false;
            }
        }else{
            me.config.showTrueyou = false;
        }
        
        /**
         * if this cart is installment cart
         */	
        if ( checkoutData.type != undefined ) {
            if( checkoutData.type == 'installment') {
                me.config.showTrueyou = false;
            }else{
                me.config.showTrueyou = true;
            }
        }
        /** [E] prepair data before render js template */
        
        //update cart item quantity.
        $("#minicart-item-quantity").html(checkoutData.items_count);
        
        //update cart item list.
        var productlistHtml = me.minicartProductlistTemplateCompiler({
            checkout: checkoutData
        });
        $("#minicart-container .cart").replaceWith(productlistHtml);

        var isStep3 = false;
        if(/checkout\/step3/gi.test(location.pathname)){
            isStep3 = true;
        }
        
        //update summary prices on minicart.
        var summaryHtml = me.minicartSumaryTemplateCompiler({
            checkout: checkoutData,
            isStep3: isStep3
        });
        $("#minicart-container > .total-list, #minicart-container > .clear").remove();
        $("#minicart-container").append(summaryHtml);
        
        me._bindEvent();

        me.blinkText();
        
        return false;
    };
    
    me._bindEvent = function(){
        //True You
        $('#auth-trueyou').off("click").on('click', function() {
            $('#popup-trueyou').modal('show');
        });
        
        //remove coupon.
        $('.close-discount').off("click").on('click',function(){
            $(this).parents('.box-discount').hide();
        });
    };

    me.blinkText = function () {
        if (jQuery().textBlink) {
            $(".text-blink").textBlink();
        }
    };
    
    return me;
})(jQuery);


MiniCart.ApplyTrueYou = (function($){
//    var me = {};
//
//    me.init = function(){
//        if($("#apply-trueyou-form").length > 0){
//            var validator = $("#apply-trueyou-form").validate({
//                rules: {
//                    idcart_number: {
//                        required: true,
//                        digits: true,
//                        minlength: 13,
//                        maxlength: 13
//                    }
//                },
//                messages:{
//                    idcart_number: {
//                        required: __("cart-trueyou-is-required"),
//                        digits: __("cart-trueyou-digit-only"),
//                        minlength: __("cart-trueyou-13digits-only"),
//                        maxlength: __("cart-trueyou-13digits-only")
//                    }
//                },
//                errorPlacement: function(error, element) {
//                    $(element).siblings(".idcard-number-success").remove();
//                    error.insertAfter(element);
//                },
//                submitHandler: function(form) {
//                    //$('.trueyou-container').toggle();
//                    $('#popup-trueyou').modal('hide');
//                    $('.trueyou-container span, .trueyou-container .sum').addClass('text-ani-1');
//
//                    if($("input[name='idcart_number']").val() != ""){
//                        $.ajax({
//                            type : 'POST',
//                            url : '/ajax/cart/apply-trueyou',
//                            data: { thai_id : $("input[name='idcart_number']").val() },
//                            success : function(response){
//                                //console.log('response apply true you:', response);
//                                if(response.code == 200){
//                                    if(response.data.trueyou == 'red' || response.data.trueyou == 'black'){
//                                        MiniCart.Main.config.usertrueyou = true;
//                                        MiniCart.Main.config.usertrueyou_card = response.data.trueyou;
//                                    }
//                                }else{
//                                    if(response.message != undefined){
//                                        //alert(response.message);
//                                        $(".trueyou-container .trueyou-error").remove();
//                                        $(".trueyou-container .edit-box").after("<div class='trueyou-error' >"+response.message+"</div>");
//                                    }
//                                }
//
//                                $(document).trigger('refresh-cart-lightbox');
//                            }
//                        });
//                    }
//                    return false;
//                },
//                errorElement: 'div',
//                errorClass: 'active-alert-text',
//                highlight: function(element, errorClass) {
//                    $(element).siblings(".idcard-number-success").remove();
//                    $(element).css("border", "2px solid #fe040d");
//                },
//                unhighlight: function(element, errorClass){
//                    $(element).siblings(".idcard-number-success").remove();
//                    var correctIcoURL = site_url+'themes/checkout/assets/images/success.png';
//                    $(element).css("border", "2px solid #87c80a");
//                    $("<div class='left idcard-number-success'><img src='"+correctIcoURL+"' width='14' height='14' /></div>").insertAfter($(element));
//                },
//                onfocusout: function(element) { $(element).valid(); }
//            });
//        }
//    }
//
//    return me;
})(jQuery);

MiniCart.RemoveCoupon = (function($) {
    
    var me = me || {};
    
    me.init = function ()
    {
        $(document).on('click','.remove-coupon', function(e) {
            
            me.removeCoupon($(this));
            
        });
    };
    
    me.removeCoupon = function(elm)
    {
        var code = elm.data('code');
        
        elm.parent().fadeOut('slow', function() {
            
           $(this).remove(); 
            
        });
        
        $.ajax({
            async: true,
            type: 'POST',
            url: '/ajax/cart/remove-coupon',
            data: {
                code: code
            },
            beforeSend: function() { $(document).trigger("show-ajax-loading") },
            success: function(response) {
                $(document).trigger("refresh-cart-lightbox");
                $(document).trigger("hide-ajax-loading");
                //window.location.reload();
            }
        });
    };
	
    return me;

})(jQuery);


$(document).ready(function(){
    MiniCart.Main.init();
    //MiniCart.ApplyTrueYou.init();
    MiniCart.RemoveCoupon.init();
});
