var MiniCart = MiniCart || {};

MiniCart.Main = (function ($) {
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

    me.minicartProductlistTemplate = '<h2><%= __("cart-summary") %></h2> \n\
        <% if (checkout.items_count > 0){ %>   \n\
        <% vendor_count = 1 %>  \n\
        <% show_group = false %>    \n\
        <% if(Object.keys(checkout.shipments).length > 1){ show_group = true }%>    \n\
            <% $.each(checkout.shipments, function(skey, shipment){ %> \n\
                <h3><%= __("cart-shops-product-lbl") %> :   \n\
                    <%= __("replace-shop-name") %>  \n\
                    <% if(show_group == true){ %> (<%= __("replace-vendor-name")%> <%= vendor_count %><% vendor_count++ %>) <% }%> \n\
                    (<%= shipment.items_count %> <%= __("cart-item-unit") %>) \n\
                </h3>   \n\
                <!-- [S] Product list per shop --> \n\
                 <% $.each(shipment.items, function(ikey, item){ %> \n\
                    <div class="row item-list"> \n\
                        <div class="col-xs-4"><img src="<% if(item.thumbnail != undefined && item.thumbnail != null && item.thumbnail != "") { print(item.thumbnail); }else{ print(site_url+"themes/checkout-mobile-2014/assets/img/image-not-found-105.jpg"); } %>"></div> \n\
                        <div class="col-xs-8">  \n\
                            <h4 style="word-wrap: break-word !important;"><%= item.name %></h4>   \n\
                            <span class="price"><%= (item.price * item.quantity).formatMoney(2) %>.-</span><span class="quantity">(<%= item.quantity %> <%= __("cart-item-unit") %>)</span>  \n\
                        </div>  \n\
                    </div>  \n\
                <% }); %> \n\
            <% }); %> \n\
         <% } else { %> \n\
            <div class="cart-title" style="text-align: center;color:red;"><%= __("cart-no-item") %></div> \n\
         <% } %> \n\
         <div class="row">  \n\
            <div class="col-xs-12"><a href=\"<%= UrlToLang("cart") %>\" class="blue-link"><%= __("cart-edit-btn") %></a></div> \n\
         </div>';

    me.minicartSumaryTemplate = '<% if(MiniCart.Main.config.showCoupon === true){ %>     \n\
            <div id="coupon-list">  \n\
            <% if(checkout.promotions.length > 0){ %>  \n\
                <% $.each(checkout.promotions, function(skey, promotion){ %> \n\
                    <div class="box-discount"> \n\
                        <p class="control-label-total clr-7 col-xs-9"> \n\
                            <span class="text-ani-1"><%= __("cart-discount-coupon")%> <%= promotion.name %></span> \n\
                        </p> \n\
                        <span id="totalDiscounts" class="close-discount col-xs-3 text-right text-ani-1"> \n\
                        <%= (promotion.totalDiscount>0 ? "-" : "") + promotion.totalDiscount.formatMoney(2) %>\n\
                            <span class="remove-coupon" data-code="<%= promotion.code %>"><img src="<% print(site_url+"themes/checkout-mobile-2014/assets/img/close.gif"); %>"></span> \n\
                        </span> \n\
                    </div> \n\
                <% }); %> \n\
            <% } %> \n\
            </div> \n\
            <div class="col-xs-12 coupon-box disable">  \n\
                <form action="" id="coupon-form" method="get" target="_top" autocomplete="off">  \n\
                    <input id="coupon-text" name="coupon" class="form-control" placeholder="<%= __("cart-coupon-placeholder") %>" type="text"/> \n\
                    <button id="coupon-button"><%= __("cart-use-coupon-btn") %></button>    \n\
                    <div id="coupon_code_error"></div>    \n\
                </form> \n\
            </div>  \n\
        <% } %> \n\
        <div class="col-xs-12"> \n\
            <div class="row">   \n\
                <div class="col-xs-7">  \n\
                    <p><%= __("cart-cost-lbl") %></p>   \n\
                </div>  \n\
                <div class="col-xs-5 text-right">   \n\
                    <div id="total_price"><p><%= checkout.total_price.formatMoney(2) %></p></div> \n\
                </div>  \n\
            </div>  \n\
        </div>  \n\
        <div class="col-xs-12"> \n\
            <div class="row">   \n\
                <div class="col-xs-9">  \n\
                    <p class="text-blink"><%= __("cart-total-delivery-fare") %><br/>\
                        <% if ( checkout.shipping_config.shipping_link != undefined && checkout.shipping_config.shipping_link != "" ){  %>  \n\
                            <a target="_blank" href="<%= checkout.shipping_config.shipping_link %>" class="text-blink minicart-noti-shipping-fee <% ( checkout.shipping_config.shipping_link != "javascript:void(0);" )? print("is-link"): print("isnot-link"); %>">\
                                <span style="font-size: 14px;"><%= checkout.shipping_config.shipping_note %></span>\
                            </a>\
                        <% } else if ( checkout.shipping_config.shipping_note != undefined && checkout.shipping_config.shipping_note != "" ){  %>  \n\
                            <span style="font-size: 14px;"><%= checkout.shipping_config.shipping_note %></span>\
                        <% } %>\n\
                    </p>   \n\
                </div>  \n\
                <div class="col-xs-3 text-right">   \n\
                    <div id="total_shipping_fee"><p class="text-blink <% (checkout.total_shipping_fee != undefined && checkout.total_shipping_fee == 0)?print("text-green"):print(""); %>"><% if (checkout.total_shipping_fee != undefined && checkout.total_shipping_fee == 0){    \n\
                        print(__("cart-free-lbl")); \n\
                    } else if (checkout.total_shipping_fee != undefined) { \n\
                        print( checkout.total_shipping_fee.formatMoney(2) ); \n\
                    } %></p></div>  \n\
                </div>  \n\
            </div>  \n\
        </div>  \n\
        <div class="col-xs-12"> \n\
            <div class="row">   \n\
                <div class="col-xs-7">  \n\
                    <% if(MiniCart.Main.config.showDiscount == true){ %>\n\
                        <p class="text-blink"><%= __("cart-discount-lbl") %></p>   \n\
                    <% } %> \n\
                </div>  \n\
                <div class="col-xs-5 text-right">   \n\
                    <% if(MiniCart.Main.config.showDiscount == true){ %>\n\
                        <div id="total_discount"><p class="text-blink"><%= (checkout.total_discount>0 ? "-":"") + checkout.total_discount.formatMoney(2) %></p></div>    \n\
                    <% } %> \n\
                </div>  \n\
            </div>  \n\
        </div>  \n\
        <div class="col-xs-12"> \n\
            <div class="row">   \n\
                <div class="col-xs-7">  \n\
                    <h3><%= __("cart-total-price-lbl") %></h3> \n\
                </div>  \n\
                <div class="col-xs-5 text-right">   \n\
                    <div id="sub_total"><h3><%= checkout.sub_total.formatMoney(2) %></h3></div>   \n\
                </div>  \n\
            </div>  \n\
        </div>  \n\
        <div class="col-xs-12 text-right tax-included">  \n\
            <span>(<%= __("cart-vat-included") %>)</span>   \n\
        </div>';

    me.minicartProductlistTemplateCompiler = _.template(me.minicartProductlistTemplate);
    me.minicartSumaryTemplateCompiler = _.template(me.minicartSumaryTemplate);

    me.init = function () {

        var step1pattern = /checkout\/step1/gi;
        var step2pattern = /checkout\/step2/gi;
        var step3pattern = /checkout\/step3/gi;
        var currenUri = location.pathname;

        if (step1pattern.test(currenUri)) {
            me.config.showShippingMethod = false;
            me.config.showDiscount = true;
            me.config.isTUAvailablePage = false;
            me.config.showCoupon = false;
        } else if (step2pattern.test(currenUri)) {
            me.config.showShippingMethod = true;
            me.config.showDiscount = true;
            me.config.isTUAvailablePage = false;
            me.config.showCoupon = false;
        } else if (step3pattern.test(currenUri)) {
            me.config.showShippingMethod = true;
            me.config.showDiscount = true;
            me.config.isTUAvailablePage = false;
            me.config.showCoupon = true;
        }

        //custom events
        $(document).bind("refresh-minicart", me._renderMinicart);

        me._blinkText();
    };

    me._blinkText = function () {
        if (jQuery().textBlink) {
            $(".text-blink").textBlink();
        }
    };

    me._prepareData = function () {
        var cartDetailUrl = '/ajax/v2/checkout';
        if (LANG != 'th') {
            cartDetailUrl = "/" + LANG + cartDetailUrl;
        }
        $.ajax({
            type: 'POST',
            url: cartDetailUrl,
            success: function (response) {
                if (response.code == 200) {
                    var checkoutData = response.data;
                    me._renderMinicart(null, checkoutData);
                    $(document).trigger("get-cart-v2", [checkoutData]);
                    $(document).trigger("hide-ajax-loading");
                }
            },
            error: function (err) {
                $(document).trigger("hide-ajax-loading");
            }
        });
    }

    me._renderMinicart = function (event, checkoutData) {
        if (checkoutData == undefined) {
            me._prepareData();
            return false;
        }

        /** [S] prepair data before render js template */
        var trueyouDiscount = 0;
        var hasCoupon = false;
        if (checkoutData.promotions != undefined) {
            $.each(checkoutData.promotions, function (key, promotion) {
                //check coupon in cart. if $hasCoupon is true. Cart will not show trueyou.
                if (promotion.type != undefined) {
                    if (promotion.type == 'coupon_code') {
                        hasCoupon = true;
                    }
                }

                if (promotion.type != undefined) {
                    if (promotion.type == 'trueyou') {
                        trueyouDiscount += promotion.totalDiscount;
                    }
                }
            });
        }

        me.config.trueyouDiscount = trueyouDiscount;

        if (checkoutData.isTrueyouable != undefined && hasCoupon == false) {
            if (checkoutData.isTrueyouable == true) {
                me.config.showTrueyou = true;
            } else {
                me.config.showTrueyou = false;
            }
        } else {
            me.config.showTrueyou = false;
        }

        if (checkoutData.shipping_config) {
            if (!checkoutData.shipping_config.shipping_link) {
                checkoutData.shipping_config.shipping_link = "javascript:void(0);";
            }

            if(!checkoutData.shipping_config.shipping_note){
                checkoutData.shipping_config.shipping_note = "";
            }
        } else {
            checkoutData.shipping_config = {};
            checkoutData.shipping_config.shipping_link = "javascript:void(0);";
            checkoutData.shipping_config.shipping_note = "";
        }

        /**
         * if this cart is installment cart
         */
        if (checkoutData.type != undefined) {
            if (checkoutData.type == 'installment') {
                me.config.showTrueyou = false;
            } else {
                me.config.showTrueyou = true;
            }
        }
        /** [E] prepair data before render js template */

            //update cart item list.
        productlistHtml = me.minicartProductlistTemplateCompiler({
            checkout: checkoutData
        });
        $("#minicart-container").html(productlistHtml);

        //update summary prices on minicart.
        summaryHtml = me.minicartSumaryTemplateCompiler({
            checkout: checkoutData
        });

        couponErrMsg = $("#coupon_code_error");
        $("#minicart-sum-container").html(summaryHtml);

        if (couponErrMsg.length > 0 && couponErrMsg.html() != "" && checkoutData.promotions.length == 0) {
            $("#coupon_code_error").html(couponErrMsg.html()).show();
        }

        me._blinkText();

        return false;
    };

    me._bindEvent = function () {
        //True You
        $('#auth-trueyou').off("click").on('click', function () {
            $('#popup-trueyou').modal('show');
        });

        //remove coupon.
        $('.close-discount').off("click").on('click', function () {
            $(this).parents('.box-discount').hide();
        });
    };

    return me;
})(jQuery);


MiniCart.ApplyTrueYou = (function ($) {
    var me = {};

    me.init = function () {
        if ($("#apply-trueyou-form").length > 0) {
            var validator = $("#apply-trueyou-form").validate({
                rules: {
                    idcart_number: {
                        required: true,
                        digits: true,
                        minlength: 13,
                        maxlength: 13
                    }
                },
                messages: {
                    idcart_number: {
                        required: __("cart-trueyou-is-required"),
                        digits: __("cart-trueyou-digit-only"),
                        minlength: __("cart-trueyou-13digits-only"),
                        maxlength: __("cart-trueyou-13digits-only")
                    }
                },
                errorPlacement: function (error, element) {
                    $(element).siblings(".idcard-number-success").remove();
                    error.insertAfter(element);
                },
                submitHandler: function (form) {
                    $('#popup-trueyou').modal('hide');
                    $('.trueyou-container span, .trueyou-container .sum').addClass('text-ani-1');

                    if ($("input[name='idcart_number']").val() != "") {
                        $.ajax({
                            type: 'POST',
                            url: '/ajax/cart/apply-trueyou',
                            data: {thai_id: $("input[name='idcart_number']").val()},
                            success: function (response) {
                                if (response.code == 200) {
                                    if (response.data.trueyou == 'red' || response.data.trueyou == 'black') {
                                        MiniCart.Main.config.usertrueyou = true;
                                        MiniCart.Main.config.usertrueyou_card = response.data.trueyou;
                                    }
                                } else {
                                    if (response.message != undefined) {
                                        //alert(response.message);
                                        $(".trueyou-container .trueyou-error").remove();
                                        $(".trueyou-container .edit-box").after("<div class='trueyou-error' >" + response.message + "</div>");
                                    }
                                }

                                $(document).trigger('refresh-cart-lightbox');
                            }
                        });
                    }
                    return false;
                },
                errorElement: 'div',
                errorClass: 'active-alert-text',
                highlight: function (element, errorClass) {
                    $(element).siblings(".idcard-number-success").remove();
                    $(element).css("border", "2px solid #fe040d");
                },
                unhighlight: function (element, errorClass) {
                    $(element).siblings(".idcard-number-success").remove();
                    var correctIcoURL = site_url + 'themes/checkout/assets/images/success.png';
                    $(element).css("border", "2px solid #87c80a");
                    $("<div class='left idcard-number-success'><img src='" + correctIcoURL + "' width='14' height='14' /></div>").insertAfter($(element));
                },
                onfocusout: function (element) {
                    $(element).valid();
                }
            });
        }
    }

    return me;
})(jQuery);

MiniCart.RemoveCoupon = (function ($) {

    var me = me || {};

    me.init = function () {
        $(document).on('click', '.remove-coupon', function (e) {

            me.removeCoupon($(this));

        });

        $(document).on('click', '#coupon-button', function (e) {
            e.preventDefault();

            me.addCoupon($(this));

            return;
        });
    };

    /**
     * addCoupon
     *
     * - Apply promotion code for mobile
     *
     * @param elm
     */
    me.addCoupon = function (elm) {
        var code = elm.parent().find('#coupon-text').val();

        $('#coupon_code_error').html('');
        $('#coupon_code_error').hide();

        if (code.length <= 0) {
            $('#coupon_code_error').show();
            $('#coupon_code_error').html(__('empty-promotion-code'));
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
                        $('#minicart-sum-container #coupon_code_error').html(response.description);
                    }
                    $(document).trigger("refresh-minicart");
                    $(document).trigger("hide-ajax-loading");
                    goToByScroll('coupon-text');
                }
            });
        }
    };

    me.removeCoupon = function (elm) {
        var code = elm.data('code'),
            _parent = elm.parents('.box-discount');

        _parent.animate({opacity: 0.5});

        $.ajax({
            async: true,
            type: 'POST',
            url: (LANG == 'en' ? '/en' : '') + '/ajax/cart/remove-coupon',
            data: {
                code: code
            },
            beforeSend: function () {
                $(document).trigger("show-ajax-loading");
            },
            success: function (response) {
                if (response.status == 'success') {
                    _parent.fadeOut('slow', function () {
                        $(this).remove();
                    });

                    //window.location.reload();
                    $(document).trigger("refresh-minicart");
                }
                else {
                    // do something
                    _parent.animate({opacity: 1});
                }
                $(document).trigger("hide-ajax-loading");
                goToByScroll('coupon-text');
            }
        });
        $('#coupon_code_error').html('');
        $('#coupon_code_error').hide();
    };

    return me;
})(jQuery);

$(document).ready(function () {
    MiniCart.Main.init();
    MiniCart.RemoveCoupon.init();
    $(document).trigger("refresh-minicart");
});
