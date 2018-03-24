var manageItemPayment = manageItemPayment || {};

manageItemPayment.Main = (function($){

    var me = {};
    me.dialogSelector = "#error-message";
    me.btnCls = ".show-manageitempayment-btn";
    me.closeBtn = ".close-manage-item-lightbox";
    me.items = {};
    me.checkoutData = {};
    me.installItems = {};
    me.installBankInfo = {};
    me.installTotalPrice = {};
    me.deleteBtn = "#btn-delete-cart-popup";
    me.confirmDeleteBtn = ".confirm-itempayment-delete-btn";
    me.confirmCloseBtn = ".confirm-close-btn";
    me.deleteUrl = "cart/remove-items";

    me.itemTemplate = '<% $.each(itemlists, function(idx, item){ %> \n\
            <div class="row item-list <%= styleCls %>">    \n\
                <div class="col-xs-4">  \n\
                    <% if(item.thumbnail != undefined){ %>  \n\
                        <img src="<%= item.thumbnail %>">    \n\
                    <% } %>\n\
                </div>    \n\
                <div class="col-xs-8">  \n\
                    <% if(item.name) { %>     \n\
                        <h4 style="word-wrap: break-word !important;"><%= item.name %></h4> \n\
                    <% } %> \n\
                    <span class="price"><%= (item.price * item.quantity).formatMoney(2) %> .-</span>    \n\
                    <span class="quantity">(<% if(item.quantity != undefined) { print(item.quantity); } else { print("0"); } %> <%= __("cart-item-unit") %>)</span>   \n\
                </div>  \n\
            </div> \n\
        <%  }); %>';

    me.init = function(){

        $(document).on("click", me.btnCls, function(){
            var activeChannel = $("input[name='payment_channel']:checked").val();

            paymentChannel = getPaymentChannelPKey(activeChannel);

            if(paymentChannel != '' && paymentChannel != "156813837979402"){
                me.showManageItemLightbox(paymentChannel);
            }else if(paymentChannel != '' && paymentChannel == "156813837979402"){
                //in case of installment.
                var bank = $("#installment_bank option:selected").data("abbreviation");
                var period = $('#pay_per_month').val();
                me.showManageItemLightboxInstall(bank, period, paymentChannel);
            }
        });

        $(me.closeBtn).click(function(){
            me.hideManageItemLightbox();
        });

        $(me.deleteBtn).click(function(){
            me.hideManageItemLightbox();
            $("#confirm-message").modal("show");
        });

        $(me.confirmDeleteBtn).click(function(){
            me.removeItems(this);
        });

        $(me.confirmCloseBtn).click(function(){
            me.hideConfirmLightbox();
        });

        //listen on fullcart event to get latest qty, price and items.
//        $(document).bind('cart-update-item-qty', me._alignCheckoutData);
//        $(document).bind("cart-delete-item", me._alignCheckoutData);
//        $(document).bind("cart-get-cart", me._alignCheckoutData);
        $(document).bind("get-cart-v2", me._alignCheckoutData);
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
                }
            },
            error: function(err){

            }
        });
    }

    me.removeItems = function(that){

        var deleteItemUrl = UrlToLang('ajax/cart/remove-items');
        var inventotryIds = $(that).data("inventory-ids");

        $(".confirm-itempayment-delete-btn").attr("disabled", "disabled");
        me.hideConfirmLightbox();
        $(document).trigger("show-ajax-loading");
        $.ajax({
            type : 'POST',
            url : deleteItemUrl,
            data: {
                inventory_ids: inventotryIds
            },
            beforeSend : function(data) {

            },
            success : function(response) {
                if(response.code == 200){
                    $(document).trigger("refresh-minicart");
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
            me.installBankInfo = {};
            me.installTotalPrice = {};

            if (checkoutData.items_count > 0){
                $.each(checkoutData.shipments, function(skey, shipment){
                    $.each(shipment.items, function(ikey, item){
                        me.items[item.inventory_id] = item;

                        if(item.bank_installments != undefined){
                            $.each(item.bank_installments, function(idx, installment){
                                if(installment.periods.length > 0){

                                    me.installBankInfo[installment.abbreviation] = installment;

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

        $("span.manage-itempayment-notallow-count").html(notAllowItems.length);
        $("span#manage-itempayment-allow-count").html(allowItems.length);
        $(me.confirmDeleteBtn).data("inventory-ids", deleteInventoryId);

        //render not allow.
        var compiled = _.template(me.itemTemplate);
        var allowTemplate = compiled({itemlists: allowItems, styleCls: ""});
        var notAllowTemplate = compiled({itemlists: notAllowItems, styleCls: "error"});

        $("#manage-itempayment-allow-list").html(allowTemplate);
        $("#manage-itempayment-notallow-list").html(notAllowTemplate);

        $(me.dialogSelector).modal("show");
    }

    me.hideManageItemLightbox = function(){
        $(me.dialogSelector).modal("hide");
    }

    me.hideConfirmLightbox = function(){
        $("#confirm-message").modal("hide");
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
                title += " " + __("manage-item-" + $("#installment_bank option:selected").data("abbreviation"));

                return title;
            case "156513837979495":
                return __("atm-title");
            case "158913837979603":
                return __("ibanking-title");
            case "152313837979681":
                return __("bankcounter-title");
            case "155613837979771":
                return __("cod-title");
            case "153213837979857":
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