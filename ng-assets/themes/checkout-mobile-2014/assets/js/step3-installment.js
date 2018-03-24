var InstallmentPayment = InstallmentPayment || {};

InstallmentPayment.Main = (function($){
    var me = {};
    var self = this;
    var months = {};
    var banks = {};
    var checkout_data = {};
    var optTemplate = '<option value=":value" data-abbreviation=":abbreviation" data-image=":bank_icon" :selecttxt >:bank_name</option>';
    var iconMapper = {
        kbank: "icon_kbank.png",
        bay: "icon_krungsri.png",
        centralcard: "icon_central.png",
        firstchoice: "icon_firstchoice.png",
        tescolotus: "icon_tesco.png",
        ktc: "icon_ktc.png",
        bbl: "icon_bbl.png"
    };

    me.init = function(){
        $("#installment_bank").change(function(){
            var bankAbbr = $("#installment_bank option:selected").data("abbreviation");
            $(".clear-error-msg").html("");
            if(bankAbbr == undefined)
            {
                $(".installment-current-bank-name").html('');
            }
            else
            {
                $('#installment_bank_msdd').css("border", "2px solid #87c80a");
                $('#installment_bank_msdd').siblings('.active-alert-text').remove();
                $(".installment-current-bank-name").html(__("bank-installment-" + bankAbbr));
            }


            me._renderMonth(checkout_data);
            me._checkCanPay();
        });

        $("#pay_per_month").change(function(){
            /*var can_pay = me._checkValidInstallment();
            if(can_pay == true)
            {
                me._saveCartInstallment(checkout_data);
            }*/
            me._checkCanPay();
        });

        $(document).bind("get-cart-v2", me._alignInstallment);
    }

    me._alignInstallment = function(event, checkout){
        if(checkout == undefined || checkout == null){
            return false;
        }

        months = {};
        banks = {};
        checkout_data = checkout;

        // Data months[bank_id][period] = price
        if(checkout != undefined){
            checkoutData = checkout;
            if (checkoutData.items_count > 0){
                $.each(checkoutData.bank_show, function(bank_id, bank){
                    months[bank.abbreviation] = bank.periods;
                });
            }
        }

        me._renderBank();
        me._renderMonth(checkout);

    }

    me._renderBank = function(){
        var selectBank = $('#installment_bank').val();
        // Rearrage Bank options
        var optText = '<option id="dd-list-option" value="">'+__('mobile-step3-select-bank')+'</option>';

        if($.isEmptyObject(banks)){
            return false;
        }

        var Allinst = $("#installment_bank_msdd ul li");
        var Alloption = (Allinst.length - 1);

        if(Alloption == Object.keys(banks).length)
        {
            return false;
        }

        $.each(banks, function(idx, instBank){
            var tmp = "";
            tmp = optTemplate.replace(":value", instBank.id);
            tmp = tmp.replace(":abbreviation", instBank.abbreviation);

            if(instBank.id == selectBank)
            {
                tmp = tmp.replace(":selecttxt", 'selected');
            }
            else
            {
                tmp = tmp.replace(":selecttxt", '');
            }

            tmp = tmp.replace(":bank_icon", "/themes/checkout-mobile-2014/assets/img/"+iconMapper[instBank.abbreviation]);
            tmp = tmp.replace(":bank_name", __("bank-installment-"+instBank.abbreviation));
            optText += tmp;
        });

        $("#installment_bank").msDropdown().data("dd").destroy();
        $("#installment_bank").html(optText);
        $("#installment_bank").msDropdown();

    }

    me._renderMonth = function(checkoutData){

        var abbr = $("#installment_bank option:selected").data("abbreviation");
        if(! abbr ){
            //var optionsObject = new Array();
            $("#pay_per_month").val('');
            return false;
        }

        var pay_per_month = $("#pay_per_month").val();
        var total_discount = 0;

        if(typeof checkoutData != "undefined" ){
            if(checkoutData.total_discount != 0){
                total_discount = checkoutData.total_discount;
            }
        }

        // Rearrage month options
        var optionsObject = new Array();

        if(typeof months[abbr] != "undefined"){

            $.each(months[abbr], function(period, price){
                //var payPerMonth = (price-total_discount)/period;
                var payPerMonth = price;

                optionsObject.push({
                    opt_text: __('step3-installment-pay')+' '+period+' '+__('step3-installment-month')+', '+__('step3-installment-for')+' '+payPerMonth.formatMoney()+' '+__('step3-installment-baht'),
                    opt_value: period
                });
            });

            $("#pay_per_month").loadSelect(optionsObject, __("inst-pay-per-month"), pay_per_month);

        }

        return true;
    }

    me._saveCartInstallment = function(checkout_data){

        $.ajax({
            type: "POST",
            url: UrlToLang("ajax/checkout/set-customer-info"),
            data: {
                installment: $('#pay_per_month').val(),
                bank_id: $('#installment_bank').val()
            },
            beforeSend: function(msg){
            },
            success: function(msg){
                $(".clear-error-msg").slideUp("slow", function() {
                    $(this).html("");
                });
                $("#payment-submit-btn").parent().parent().removeClass("disable");
            }
        });
    }

    me._checkValidInstallment = function(checkout_data)
    {
        var month_val = $("#pay_per_month").val();

        if(!month_val) return;

        var bank_name_val = $("#installment_bank option:selected").data("abbreviation");

        var can_pay = false;

        if(month_val.length > 0 && bank_name_val != undefined && bank_name_val.length > 0 &&
            month_val != undefined  &&
            month_val != '' && bank_name_val != '' )
        {
            var total_variants = Object.keys(manageItemPayment.Main.items).length;

            var total_install_valid = manageItemPayment.Main.installItems[bank_name_val][month_val].length;

            if( (total_variants !== total_install_valid) && (total_variants > 1) ){
                $("#payment-submit-btn").parent().parent().addClass("disable");
                errorInstalltmp = step3ErrorManager.getInstallErrorMessage();
                $('#conflict_month').html(errorInstalltmp).css({display:"none"}).slideDown();
            }
            else if(total_variants !== total_install_valid && total_variants == 1){
                $("#payment-submit-btn").parent().parent().addClass("disable");
                errorInstalltmp = step3ErrorManager.getInstallErrorMessage();
                $('#conflict_month').html(errorInstalltmp).css({display:"none"}).slideDown();
            }
            else{
                can_pay = true;
            }

        }

        return can_pay;
    }

    me._checkCanPay = function(){
        var can_pay = me._checkValidInstallment();
        if(can_pay == true)
        {
            me._saveCartInstallment(checkout_data);
        }
        return null;
    }

    return me;
})(jQuery);

$(document).ready(function(){
    InstallmentPayment.Main.init();

    showDetail();

    $('#installment').click(function(){
        var bank_select = $("#installment_bank").val();
        var month_select = $("#pay_per_month").val();

        if(bank_select != '' && month_select !='')
        {
            showDetail();
        }
    });

});

function showDetail()
{
    var pay_select = $('input[name="payment_channel"]:checked').val();

    switch (pay_select)
    {
        case 'installment':
            var bank_select = $("#installment_bank").val();
            var month_select = $("#pay_per_month").val();

            $('#box-installment').show();

            if(month_select != '' || (bank_select != '' && month_select == '' ) )
            {
                $('.bank-installment-detail').show();
            }

            break;
        case 'credit-card':
            $('#box-credit-card').show();
            break;
    }
    return pay_select;
}