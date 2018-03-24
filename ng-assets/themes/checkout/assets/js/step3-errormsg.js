var step3ErrorManager = step3ErrorManager || {};


step3ErrorManager = (function(){
    me = this;

    me.currentData = null;

    // Error message type 1
    me.Template1 = '<div id="<%= payment_channel_txt %>" style="display:none;" class="ui-msg-box alert alert-danger">     \n\
                        <p class="ui-msg-box__main-text--alert"> \n\
                        <img class="icn__close-msgbox" src="<%= site_url + "themes/checkout/assets/images/warning_icon_s.png" %>"></p>    \n\
                        <p class="ui-msg-box__main-text--alert"><%= __("checkout3-your-cart-cannot-pay-with-this-method").replace(":paymentmethod", __(payment_channel_txt)) %></p>    \n\
                        <p class="ui-msg-box__sub-text--alert"><%= __("checkout3-please-select-other-channel") %></p> \n\
                   </div>';

    // Error message type 2
    me.Template2 = '<div id="<%= payment_channel_txt %>" style="display:none;" class="ui-msg-box alert alert-danger" rel="">     \n\
                        <p class="ui-msg-box__main-text--alert"> \n\
                        <img class="icn__close-msgbox" src="<%= site_url + "themes/checkout/assets/images/warning_icon_s.png" %>"></p>    \n\
                        <p class="ui-msg-box__main-text--alert"><%= __("checkout3-your-area-is-not-available-for-payment-channel").replace(":paymentmethod", __(payment_channel_txt)) %></p>    \n\
                        <p class="ui-msg-box__sub-text--alert"><%= __("checkout3-please-select-other-channel") %></p> \n\
                   </div>';

    // Error message type 3
    me.Template3 = '<div id="<%= payment_channel_txt %>" style="display:none;" class="ui-msg-box alert alert-danger" rel="different"> \n\
                        <p class="ui-msg-box__main-text--alert">    \n\
                            <img class="icn__close-msgbox" src="<%= site_url + "themes/checkout/assets/images/warning_icon_s.png" %>"></p>    \n\
                        <p class="ui-msg-box__main-text--alert"><%= __("checkout3-some-product-in-your-cart-cannot-select").replace(":paymentmethod", __(payment_channel_txt)) %></p>    \n\
                        <p class="ui-msg-box__sub-text--alert"><%= __("checkout3-please-select-other-channel") %></p> \n\
                        <p class="ui-msg-box__sub-text--alert"><%= __("checkout3-or") %></p> \n\
                        <p class="ui-msg-box__sub-text--alert"><%= __("checkout3-if-you-want-to-pay-this-method") %><br><%= __("checkout3-please-delete-unpayable-list-from-your-cart") %></p>   \n\
                        <a href="javascript:void(0);" class="ui-msg-box_link show-manageitempayment-btn"><%= __("checkout3-delete-item-in-cart") %></a>    \n\
                    </div>';

    // Error message type 4
    me.Template4 = '<div id="<%= payment_channel_txt %>" style="display:none;" class="ui-msg-box alert alert-danger" rel="different"> \n\
                        <p class="ui-msg-box__main-text--alert">    \n\
                            <img class="icn__close-msgbox" src="<%= site_url + "themes/checkout/assets/images/warning_icon_s.png" %>"></p>    \n\
                        <p class="ui-msg-box__main-text--alert"><%= __("checkout3-some-product-in-your-cart-cannot-select-installment").replace(":paymentmethod", __(payment_channel_txt)) %></p>    \n\
                        <p class="ui-msg-box__sub-text--alert"><%= __("checkout3-please-select-other-channel-3") %></p> \n\
                        <p class="ui-msg-box__sub-text--alert"><%= __("checkout3-or") %></p> \n\
                        <p class="ui-msg-box__sub-text--alert"><%= __("checkout3-if-you-want-to-pay-this-method") %><br><%= __("checkout3-please-delete-unpayable-list-from-your-cart") %></p>   \n\
                        <a href="javascript:void(0);" class="ui-msg-box_link show-manageitempayment-btn"><%= __("checkout3-delete-item-in-cart") %></a>    \n\
                    </div>';

    me.payment_channel = {
        '155413837979192': 'visa', // Credit Card
        '156513837979495': 'atm', // ATM
        '158913837979603': 'ibank', // iBanking
        '152313837979681': 'bank', // Banktrans
        '153213837979857': 'cservice', // Counter Service
        '155613837979771': 'hservice', // COD
        '156813837979402': 'install' // Installment
    }

    me.init = function(){
        //listen to re-render error msg.
        $(document).bind("get-cart-v2", me.callbackRenderError);
    }

    me.callbackRenderError = function(event, checkoutv2){
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
                        // Not available thgis payment channel
                        if (me.payment_channel[item] != undefined)
                        {
                            $("#payment-channel-selection li."+me.payment_channel[item]).attr("rel", "");
                        }
                        template +=  template1({ payment_channel_txt: me.payment_channel[item] });

                        if (me.payment_channel[item] == 'hservice')
                        {

                            if (availableCODShop == 0)
                            {
                                $("#payment-channel-selection li.hservice").attr("rel", "");
                            }
                        }
                    }else{
                        $("#payment-channel-selection li."+me.payment_channel[item]).attr("rel", "available");
                        if(value["inventory_ids"].length == count_inv){
                            if( me.payment_channel[item] == 'hservice' && cod == false){
                                template +=  template2({ payment_channel_txt: me.payment_channel[item] });
                                $("#payment-channel-selection li.hservice").attr("rel", "");
                            }
                            else
                            {
                                if (me.payment_channel[item] != "install")
                                {
                                    $('#step3-submit')
                                        .removeAttr("disabled")
                                        .removeClass("btn-disabled");
                                }
                            }
                        }else{
                            if (me.payment_channel[item] != "install")
                            {
                                template += template3({ payment_channel_txt: me.payment_channel[item] });
                            }
                        }
                    }
                }
            });
        }

        $("#step3-errmsg-container").html(template);
        $("#step3-install-errmsg-container").html("");

        var activeChannel = $("#payment-channel-selection li.active").attr("class");
        var activeChannel = activeChannel.replace(" active", "");
        $("#"+activeChannel).show();
        me.setAlertMsg();
    }

    me.installError = function(){
        var template4 = _.template(me.Template4);
        channel = "install";
        $("#step3-install-errmsg-container").html(template4({ payment_channel_txt: channel }));
        $("#"+channel).show();
    }


    me.setAlertMsg = function (event)
    {
        if(event == undefined)
        {
            //var attr_pay = $('.last-payment').text();
            var attr_pay = check_payment();
        }
        else
        {
            var attr_pay = event;
        }

        // Show Error MSG Box

        var tab_pane_name = attr_pay;
        var tab_pane_id = "channel-" + attr_pay;

        switch (attr_pay)
        {
            case "install" :
                tab_pane_name = "instalment";
                tab_pane_id = "instalment";
                break;

            case "bank" :
                tab_pane_id = "channel-paymentcounter";
                break;

            case "hservice" :
                tab_pane_id = "channel-cod";
                break;

            case "visa" :
                tab_pane_id = "channel-ccw";
                break;

            case "cservice" :
                tab_pane_id = "channel-counterservice";
                break;

            case "ibank" :
                tab_pane_id = "channel-ibanking";
                break;

            default :
                tab_pane_name = attr_pay;
                tab_pane_id = "channel-" + attr_pay;
                break;
        }

        try{
            if(attr_pay != undefined && attr_pay != ""){
                if ($('.c-main .c-tab-2 .'+attr_pay).attr('rel') == "available")
                {
                    $('.tab-pane').css("display", "none");
                    $('#'+tab_pane_id).css("display", "block");
                    $('.form-max-info').css("display", "block");

                    $(".c-info div#"+tab_pane_id).show();

                    if(attr_pay == "install"){
                        //in case of installment. We have to check some more conditions to make sure options are checked.
                        if($(".install_bank").val() != undefined && $("#pay_per_month").val() != undefined && $("#pay_per_month").val() != "" ){
                            $('#step3-submit')
                                .removeAttr("disabled")
                                .removeClass("btn-disabled");

                            // Message
                            $('.c-info .alert-danger').css("display", "none");
                            if ($('#'+attr_pay).attr("rel") == "different")
                            {
                                $('.form-max-info').css("display", "block");
                                $('#'+attr_pay).css("display", "block");
                                $('#'+tab_pane_id).css("display", "block");
                                $('#step3-submit')
                                    .addClass("btn-disabled")
                                    .attr("disabled", "disabled");
                            }
                        }
                    }else{
                        $('#step3-submit')
                            .removeAttr("disabled")
                            .removeClass("btn-disabled");

                        // Message
                        $('.c-info .alert-danger').css("display", "none");
                        if ($('#'+attr_pay).attr("rel") == "different")
                        {
                            $('.form-max-info').css("display", "block");
                            $('#'+attr_pay).css("display", "block");
                            $('#'+tab_pane_id).css("display", "block");
                            $('#step3-submit')
                                .addClass("btn-disabled")
                                .attr("disabled", "disabled");
                        }
                    }

                }
                else
                {
                    $('.tab-pane').css("display", "none");
                    $('#'+tab_pane_id).css("display", "none");
                    $('.form-max-info').css("display", "none");

                    // Message
                    $('.c-info .alert-danger').css("display", "none");
                    $('#'+attr_pay).css("display", "block");
                }
            }
        }catch(err){
            console.log("error", err);
        }

    }


    return me;
})(jQuery);

$(document).ready(function(){
    //step3ErrorManager.init();

    $(document).bind("get-cart-v2", step3ErrorManager.callbackRenderError);
});