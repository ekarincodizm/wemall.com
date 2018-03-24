var step3ErrorManager = step3ErrorManager || {};


step3ErrorManager = (function(){
    me = {};
    me.currentData = null;

    // Error message type 1 (No item for paying with channel).
    me.Template1 = '<div id="error-<%= payment_channel_txt %>" class="warning-message-box">   \n\
            <img src="<%= site_url + "themes/checkout-mobile-2014/assets/img/icon_error.png" %>" /> \n\
            <p><%= __("checkout3-your-cart-cannot-pay-with-this-method-mobile").replace(":paymentmethod", __(payment_channel_txt)) %> <%= __("checkout3-please-select-other-channel") %></p>    \n\
        </div>';

    // Error message type 2 (shipping area not avaiable).
    me.Template2 = '<div id="error-<%= payment_channel_txt %>" class="warning-message-box">   \n\
            <img src="<%= site_url + "themes/checkout-mobile-2014/assets/img/icon_error.png" %>" /> \n\
            <p><%= __("checkout3-your-area-is-not-available-for-payment-channel").replace(":paymentmethod", __(payment_channel_txt)) %> <%= __("checkout3-please-select-other-channel") %></p>    \n\
        </div>';

    // Error message type 3 (There are some product is not allowed for this payment.)
    me.Template3 = '<div id="error-<%= payment_channel_txt %>" class="warning-message-box">   \n\
            <img src="<%= site_url + "themes/checkout-mobile-2014/assets/img/icon_error.png" %>" /> \n\
            <p><%= __("checkout3-some-product-in-your-cart-cannot-select-mobile").replace(":paymentmethod", __(payment_channel_txt)) %> <%= __("checkout3-please-select-other-channel") %></p>   \n\
            <p><%= __("checkout3-or") %></p>    \n\
            <p><%= __("checkout3-if-you-want-to-pay-this-method") %><br><%= __("checkout3-please-delete-unpayable-list-from-your-cart") %></p>  \n\
            <a href="javascript:void(0);" class="blue-link show-manageitempayment-btn"><%= __("checkout3-delete-item-in-cart") %> \n\
                <span style="text-decoration: underline;"><%= __("click-here-txt") %></span>   \n\
            </a> \n\
        </div>';

    // Error message type 4 (There are some product is not allowed for Installment.)
    me.Template4 = '<div id="error-<%= payment_channel_txt %>" class="warning-message-box">   \n\
            <img src="<%= site_url + "themes/checkout-mobile-2014/assets/img/icon_error.png" %>" /> \n\
            <p><%= __("checkout3-some-product-in-your-cart-cannot-select-installment-mobile").replace(":paymentmethod", __(payment_channel_txt)) %> <%= __("checkout3-please-select-other-channel-3") %></p>   \n\
            <p><%= __("checkout3-or") %></p>    \n\
            <p><%= __("checkout3-if-you-want-to-pay-this-method") %><br><%= __("checkout3-please-delete-unpayable-list-from-your-cart") %></p>  \n\
            <a href="javascript:void(0);" class="blue-link show-manageitempayment-btn"><%= __("checkout3-delete-item-in-cart") %> \n\
                <span style="text-decoration: underline;"><%= __("click-here-txt") %></span>   \n\
            </a> \n\
        </div>';

    me.payment_channel = {
        '155413837979192': 'credit-card', // Credit Card
        '156513837979495': 'atm', // ATM
        '158913837979603': 'ibank', // iBanking
        '152313837979681': 'bank', // Banktrans
        '153213837979857': 'cservice', // Counter Service
        '155613837979771': 'cod', // COD
        '156813837979402': 'installment' // Installment
    };

    me.allErrorTemplates = {};

    me.init = function(){
        //listen to re-render error msg.
        $(document).bind("get-cart-v2", me.callbackRenderError);
    }

    me.callbackRenderError = function(event, checkoutv2){

        me.allErrorTemplates = {};
        me.currentData = checkoutv2;

        var template = "";
        var count_inv = 0;
        var cod = false;
        var shipment_cod = "14456917914435";
        var template1 = _.template(me.Template1);
        var template2 = _.template(me.Template2);
        var template3 = _.template(me.Template3);
        var availableCODShop = 0;

        // Check available COD
        if(checkoutv2.shipments != undefined){
            $.each(checkoutv2.shipments, function(i, val){

                count_inv += val.items.length;
                if(shipment_cod in val.available_shipping_methods){
                    availableCODShop++;

                }
            });
        }

        var shipmentLength = (jQuery.makeArray(checkoutv2.shipments).length == undefined) ? 0 : jQuery.makeArray(checkoutv2.shipments).length;
        if (shipmentLength != 0 && shipmentLength == availableCODShop)
        {
            cod = true;
        }

        if( checkoutv2.all_payment_methods != undefined ){
            $.each(checkoutv2.all_payment_methods, function(item, value){
                if(me.payment_channel[item] != undefined ){
                    if(value["inventory_ids"] == undefined || value["inventory_ids"].length < 1){
                        // Not available this payment channel
                        if (me.payment_channel[item] == 'cod' && cod == false)
                        {
                            // shipping area not avaiable by COD
                            me.allErrorTemplates[me.payment_channel[item]] = template2({ payment_channel_txt: me.payment_channel[item] });
                        }else{
                            // No any product to pay with this channel.
                            me.allErrorTemplates[me.payment_channel[item]] = template1({ payment_channel_txt: me.payment_channel[item] });
                        }
                    }else{

                        if(value["inventory_ids"].length == count_inv){
                            if( me.payment_channel[item] == 'cod' && cod == false){
                                // shipping area not avaiable by COD
                                me.allErrorTemplates[me.payment_channel[item]] = template2({ payment_channel_txt: me.payment_channel[item] });
                            }
                            else
                            {
                                //this payment is allowed.
                                me.allErrorTemplates[me.payment_channel[item]] = true;
                            }
                        }else{
                            if (me.payment_channel[item] == "installment")
                            {
                                /**
                                 * Incase: There're some product can pay installment.
                                 * Then Installment will be managed by itself.
                                 */
                                me.allErrorTemplates[me.payment_channel[item]] = false;
                            }else{
                                //There are some items can pay this payment.
                                me.allErrorTemplates[me.payment_channel[item]] = template3({ payment_channel_txt: me.payment_channel[item] });
                            }
                        }
                    }
                }
            });
        }
        $(document).trigger("after-manage-errormsg", [checkoutv2]);

    }

    me.getInstallErrorMessage = function(){
        var template4 = _.template(me.Template4);
        return template4({ payment_channel_txt: "installment" });
    }

    me.validateErrorMessage = function(paymentChannel){
        if(paymentChannel == undefined){
            paymentChannel = $("input[name='payment_channel']:checked").val();
        }

        try{
            return me.allErrorTemplates[paymentChannel];
        }catch(err){
            console.log(err);
        }
    }

    return me;
})(jQuery);

$(document).ready(function(){
    step3ErrorManager.init();
});