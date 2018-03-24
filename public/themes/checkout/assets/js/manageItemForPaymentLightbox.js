var manageItemPayment = manageItemPayment || {};

manageItemPayment.Main = (function(){
    var me = {};
    me.dialogSelector = "#cart-popup-select";
    me.btnCls = ".show-manageitempayment-btn";
    me.closeBtn = ".close-manage-item-lightbox";
    me.items = {};
    me.checkoutData = {};
    me.installItems = {};
    me.installBankInfo = {};
    me.installTotalPrice = {};
    me.deleteBtn = ".manage-itempayment-delete-btn";
    me.confirmDeleteBtn = ".confirm-itempayment-delete-btn";
    me.confirmCloseBtn = ".confirm-close-btn";
    me.deleteUrl = site_url + "cart/remove-items";

    me.itemTemplate = '<% $.each(itemlists, function(idx, item){ %> \n\
            <div class="cart-title-list">    \n\
                <div class="cart-box-img">  \n\
                    <% if(item.thumbnail != undefined){ %>\n\
                    <img src="<%= item.thumbnail %>" width="95" height="95"/>    \n\
                    <% } %>\n\
                </div>    \n\
                <div class="left">  \n\
                    <div class="cart-box-name"> \n\
                        <% if(item.name) { %>     \n\
                        <h2><%= item.name %></h2>   \n\
                        <% } %> \n\
                    </div>  \n\
                    <div class="cart-box-price">    \n\
                        <% if( item.price != item.net_price ){ %>\n\
                            <span class="alert"><%= parseFloat(item.price).formatMoney(2) %></span>   \n\
                            <br/>   \n\
                            <span class="line-through"><%= parseFloat(item.net_price).formatMoney(2) %></span>    \n\
                            <br/>   \n\
                            <%= __("cart-discount-percent-lbl") %> <%= Math.floor(( (item.net_price - item.price) / item.net_price ) * 100) %> %    \n\
                        <% }else{ %>    \n\
                            <span class="alert"><%= parseFloat(item.price).formatMoney(2) %></span>   \n\
                            <br/>   \n\
                        <% } %>\n\
                    </div>  \n\
                    <div class="cart-box-no"> \n\
                        <span class="select-cart--view">    \n\
                            <% if(item.quantity != undefined) { print(item.quantity); } else { print("0"); } %>\n\
                        </span> \n\
                    </div> \n\
                    <div class="cart-box-price2"><%= (item.price * item.quantity).formatMoney(2) %></div> \n\
                    <div class="clear"></div> \n\
                </div> \n\
                <div class="clear"></div> \n\
            </div>  \n\
        <%  }); %>';

    me.init = function(){

        $(document).on("click", me.btnCls, function(){
            var activeChannel = $("#payment-channel-selection li.active").attr("class");
            var activeChannel = activeChannel.replace(" active", "");

            paymentChannel = getPaymentChannelPKey(activeChannel);
            if(paymentChannel != '' && paymentChannel != "156813837979402"){
                me.showManageItemLightbox(paymentChannel);
            }else if(paymentChannel != '' && paymentChannel == "156813837979402"){
                //in case of installment.
                var bank = $(".inst-bank-list input[name=radiog_lite]:checked").data("abbreviation");
                var period = $('#pay_per_month').val();
                me.showManageItemLightboxInstall(bank, period, paymentChannel);
            }
        });

        $(me.closeBtn).click(function(){
            me.hideManageItemLightbox();
        });

        $(me.deleteBtn).click(function(){
            me.hideManageItemLightbox();
            $(".confirm-delete-itm-dialog").modal("show");
        });

        $(me.confirmDeleteBtn).click(function(){
            me.removeItems(this);
        });

        $(me.confirmCloseBtn).click(function(){
            me.hideConfirmLightbox();
        });

        //listen on fullcart event to get latest qty, price and items.
        $(document).bind('cart-update-item-qty', me._alignCheckoutData);
        $(document).bind("cart-delete-item", me._alignCheckoutData);
        //$(document).bind("cart-update-shipping-method", me._alignCheckoutData);
        $(document).bind("cart-get-cart", me._alignCheckoutData);
        //$(document).bind("refresh-cart-lightbox", me._alignCheckoutData);

    };

    me._prepareData = function(){
        var cartDetailUrl = '/ajax/v2/checkout';
        if(LANG != 'th'){
            cartDetailUrl = "/" + LANG + cartDetailUrl;
        }
        $.ajax({
            type : 'POST',
            url : cartDetailUrl,
            success : function(response) {
                if(response.code == 200){
                    var checkoutData = response.data;
                    me._alignCheckoutData(null, checkoutData);
                    $(document).trigger("hide-ajax-loading");

                    //$(document).trigger("get-cart-v2", [checkoutData]);
                }
            },
            error: function(err){
                $(document).trigger("hide-ajax-loading");
            }
        });
    }

    me.removeItems = function(that){

        var deleteItemUrl = UrlToLang('/ajax/cart/remove-items');
        var inventotryIds = $(that).data("inventory-ids");

        $(document).trigger("show-ajax-loading");
        $(".confirm-itempayment-delete-btn").attr("disabled", "disabled");
        me.hideConfirmLightbox();

        $.ajax({
            type : 'POST',
            url : deleteItemUrl,
            data: {
                inventory_ids: inventotryIds
            },
            success : function(response) {
                if(response.code == 200){
                    $(document).trigger("refresh-cart-lightbox");
                    //me.hideConfirmLightbox();
                    $(".confirm-itempayment-delete-btn").removeAttr("disabled");
                }
            },
            error: function(err){
                $(document).trigger("hide-ajax-loading");
            }
        });
    }

    me._alignCheckoutData = function(event, checkoutData){

        if(checkoutData == undefined){
            me._prepareData();
            return false;
        }
        if(checkoutData.all_payment_methods == undefined){
            me._prepareData();
            return false;
        }

        try{
            me.items = {};
            me.installItems = {};
            me.checkoutData = checkoutData;
            me.installBankInfo = checkoutData.bank_show;
            me.installTotalPrice = {};

            if (checkoutData.items_count > 0){
                $.each(checkoutData.shipments, function(skey, shipment){
                    $.each(shipment.items, function(ikey, item){
                        me.items[item.inventory_id] = item;

                        if(item.bank_installments != undefined){
                            $.each(item.bank_installments, function(idx, installment){
                                if(installment.periods.length > 0){

                                    // me.installBankInfo[installment.abbreviation] = installment;

                                    if(typeof me.installItems[installment.abbreviation] != "object"){
                                        me.installItems[installment.abbreviation] = {};
                                        me.installTotalPrice[installment.abbreviation] = {};
                                    }

                                    $.each(installment.periods, function(pid, period){
                                        if(! $.isArray(me.installItems[installment.abbreviation][period])  ){
                                            me.installItems[installment.abbreviation][period] = [];
                                            me.installTotalPrice[installment.abbreviation][period] = 0;
                                        }
                                        me.installItems[installment.abbreviation][period].push(item.inventory_id);
                                        me.installTotalPrice[installment.abbreviation][period] += (parseFloat(item.price) * parseInt(item.quantity));
                                    });
                                }
                            });
                        }

                    });
                });

                $(document).trigger("get-cart-v2", [checkoutData]);
            }
        }catch(e){
            //do nothing.
        }
    }

    me.showManageItemLightbox = function(paymentChannel){
        var allowPaymentItems = me.checkoutData.all_payment_methods[paymentChannel].inventory_ids;
        me._renderLightbox(allowPaymentItems, paymentChannel);
    };

    me.showManageItemLightboxInstall = function(bank, period, paymentChannel){

        var allowPaymentItems = me.installItems[bank][period];

        me._renderLightbox(allowPaymentItems, paymentChannel);
    }

    me._renderLightbox = function(allowPaymentItems, paymentChannel){

        var allowItems = [];
        var allowsCount = 0;
        var notAllowItems = [];
        var notAllowCount = 0;
        var deleteInventoryId = '';

        $.each(me.items, function(inv_id, item){
            if($.inArray(inv_id.toString(), allowPaymentItems) !== -1){
                allowItems.push(item);
                allowsCount += parseInt(item.quantity);
            }else{
                notAllowItems.push(item);
                deleteInventoryId += inv_id + ",";
                notAllowCount += parseInt(item.quantity);
            }
        });

        $("span#manage-itempayment-title, .manage-itempayment-title").html(me._getPaymentTitle(paymentChannel));
//        $("span#manage-itempayment-total-count").html(me.checkoutData.items_count);
//        $("span.manage-itempayment-notallow-count").html(notAllowCount);
//        $("span#manage-itempayment-allow-count").html(allowsCount);

        $("span#manage-itempayment-total-count").html(notAllowItems.length + allowItems.length);
        $("span.manage-itempayment-notallow-count").html(notAllowItems.length);
        $("span#manage-itempayment-allow-count").html(allowItems.length);
        $(me.confirmDeleteBtn).data("inventory-ids", deleteInventoryId);

        //render not allow.
        var compiled = _.template(me.itemTemplate);
        var allowTemplate = compiled({itemlists: allowItems});
        var notAllowTemplate = compiled({itemlists: notAllowItems});

        $("#manage-itempayment-notallow-list .cart-title-list, #manage-itempayment-allow-list .cart-title-list").remove();
        $("#manage-itempayment-allow-list").prepend(allowTemplate);
        $("#manage-itempayment-notallow-list").prepend(notAllowTemplate);

        $(me.dialogSelector).modal("show");
    }

    me.hideManageItemLightbox = function(){
        $(me.dialogSelector).modal("hide");
    }

    me.hideConfirmLightbox = function(){
        $(".confirm-delete-itm-dialog").modal("hide");
    }

    me._getPaymentTitle = function(payment_id){

        switch (payment_id){
            case "155413837979192":
                return __("debit-credit-title");
            case "156813837979402":
                var title = __("installment-title");
                var period = $("#pay_per_month").val() || 0;
                title += " " + period;
                title += " " +__("month_unit");
                title += " " + __("manage-item-" + $(".inst-bank-list input[name=radiog_lite]:checked").data("abbreviation"));

                return title;
            case "156513837979495":
                return __("atm-title");
            case "158913837979603":
                return __("ibanking-title");
            case "152313837979681":
                return __("bankcounter-title");
            case "155613837979771":
                return __("cod-title");
            case "153211444223894":
                return __("counterservice-title");
            default :
                return "-";
        }
    }

    return me;

})(jQuery);

$(document).ready(function(){

    manageItemPayment.Main.init();
});