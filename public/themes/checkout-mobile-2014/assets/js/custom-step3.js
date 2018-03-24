$(document).ready(function(){

    saveStage();

    $( "#creditnum" ).keydown(function(e){
        //alert(e.keyCode);

        var txt = $(this).val();
        var txtlen = txt.length;

        var num_arr = [48,49,50,51,52,53,54,55,56,57,8,37,39];
        var findtxt = num_arr.indexOf(e.keyCode);

        if(findtxt != -1)
        {
            if(e.keyCode == 8 || e.keyCode == 37 || e.keyCode == 39)
            {
                return true;
            }

            if(txtlen < 16)
            {
                return true;
            }
            else
            {
                e.preventDefault();
            }
        }
        else
        {
            e.preventDefault();
        }

    });

    $("#payment-submit-btn").click(function(){

        if($(this).parent().parent().hasClass("disable")){
            return false;
        }

        var paymentChannel = $("input[name='payment_channel']:checked").val();

        if(paymentChannel != undefined && paymentChannel != null){
            $("#form-payment").submit();
        }else{
            alert(__("choose-payment-channel"));
        }

    });

    $('#ccw-info-name').keyup(function() {
        // store cursor positions
        var start = this.selectionStart;
        var end = this.selectionEnd;
        $(this).val($(this).val().toUpperCase());
        // move cursor positions back
        this.setSelectionRange(start, end);
    });

    //select payment channel
    $("input[name='payment_channel']").click(function(){

        var paymentChannel = $("input[name=payment_channel]:checked").val();
        if(paymentChannel == undefined){
            $("#payment-submit-btn").parent().parent().addClass("disable");
            return true;
        }

        savePaymentInfo(paymentChannel);
        validatePaymentChannel(paymentChannel);
    });

    initValidatePaymentForm();

    $(document).bind("after-manage-errormsg", initPayment);

    $('#promotion-ccw-popup-msg #close-btn').on( "click",function(){
        $("#promotion-ccw-popup-msg").modal("hide");
    });

});

function initValidatePaymentForm(){

    if($("#form-payment").length > 0){
        _addJqueryValidateRules();

        $("#form-payment").validate({
            rules: {
                // New CCW Card
                creditname: {
                    required:{
                        depends: function(element) {
                            if ( getPaymentChannel() == 'credit-card' ){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    },
                    validcardname: true
                },
                creditnum: {
                    required: {
                        depends: function(element) {
                            if ( getPaymentChannel() == 'credit-card' ){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    },
                    digits: true,
                    //rangelength: [16,16],
                    minlength: 16,
                    maxlength: 16,
                    prefix: function(element){
                        return $(element).val();
                    }
                },
                expiremonth: {
                    required: {
                        depends: function(element) {
                            if ( getPaymentChannel() == 'credit-card' ){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    }
                },
                expireyear: {
                    required: {
                        depends: function(element) {
                            if (  getPaymentChannel() == 'credit-card' ){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    }
                },
                ccv: {
                    required: {
                        depends: function(element) {
                            if ( getPaymentChannel() == 'credit-card' ){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    },
                    digits: true,
                    rangelength: [3,3]
                },

                // Billing Address
                bill_name: {
                    required: {
                        depends: function(element) {
                            if ( isBillAddressChecked() ){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    }
                },
                bill_province_id: {
                    required: {
                        depends: function(element) {
                            if ( isBillAddressChecked() ){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    }
                },
                bill_city_id: {
                    required: {
                        depends: function(element) {
                            if ( isBillAddressChecked() ){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    }
                },
                bill_district_id: {
                    required: {
                        depends: function(element) {
                            if ( isBillAddressChecked() ){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    }
                },
                bill_postcode: {
                    //required: {
                    //    depends: function(element) {
                    //        if ( isBillAddressChecked() ){
                    //            return false;
                    //        }else{
                    //            return true;
                    //        }
                    //    }
                    //}
                    digits: true,
                    rangelength: [4,4]
                },
                bill_address: {
                    required: {
                        depends: function(element) {
                            if ( isBillAddressChecked() ){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    }
                },
                pay_per_month: {
                    required: {
                        depends: function(element) {
                            if (getPaymentChannel() == 'installment'){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    }
                },
                installment_bank: {
                    required: {
                        depends: function(element) {
                            if (getPaymentChannel() == 'installment'){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    }
                }
            },
            messages: {
                creditname: {
                    required: __("step3-enter-creditname"),
                    validcardname: __("step3-enter-valid-creditname")
                },
                creditnum:{
                    required: __("step3-enter-creditno"),
                    digits: __("step3-enter-digit-creditno"),
                    //rangelength: __("step3-enter-range-length-16")
                    minlength: __("step3-enter-range-length-16"),
                    maxlength: __("step3-enter-range-length-16")
                },
                expiremonth:{
                    required: __("step3-select-day")
                },
                expireyear:{
                    required: __("step3-select-day")
                },
                ccv:{
                    required: __("step3-enter-cvv"),
                    digits: __("step3-enter-cvv-digit"),
                    rangelength: __("step3-enter-cvv-length-3")
                },
                // Billing Address
                bill_name: {
                    required: __("step3-enter-billing-name")
                },
                bill_province_id: {
                    required: __("step3-select-province")
                },
                bill_city_id: {
                    required: __("step3-select-district")
                },
                bill_district_id: {
                    required: __("step3-select-sub-district")
                },
                bill_postcode: {
                    //required: __("step3-select-postcode")
                    digits: __("step2-zipcode-onlydigit-required"),
                    rangelength: __("step2-zipcode-4digits-required")
                },
                bill_address: {
                    required: __("step3-enter-address")
                },
                pay_per_month:{
                    required: __("step3-select-install-period")
                },
                installment_bank:{
                    required: __("mobile-step3-select-bank")
                }
            },
            errorPlacement: function(error, element) {
                $(element).siblings(".icon-success-2").remove();
                if($(element).attr('name') != 'expiremonth')
                {

                    if($(element).attr('name') == 'installment_bank')
                    {
                        error.insertAfter('#installment_bank_msdd');
                    }
                    else
                    {
                        error.insertAfter(element);
                    }
                }
                else
                {
                    if($('#year').val() != '')
                    {
                        error.insertAfter($('#year'));
                    }
                }
            },
            submitHandler: function(form) {

                /** check product in campaign */
                var payable = ManageCampaignProductLightbox.Main.check();

                if(payable){
                    var activePaymentChannel = getPaymentChannel();
                    PaymentConfirmPopup(form, activePaymentChannel);
                }

                return false;
            },
            errorElement: 'div',
            errorClass: 'active-alert-text',
            highlight: function(element, errorClass) {

                if($(element).attr('name') == 'installment_bank')
                {
                    $('#installment_bank_msdd').siblings(".icon-success-2").remove();
                    $('#installment_bank_msdd').css("border", "2px solid #fe040d");
                }
                else
                {
                    $(element).siblings(".icon-success-2").remove();
                    $(element).css("border", "2px solid #fe040d");
                }

            },
            unhighlight: function(element, errorClass){

                $(element).css("border", "2px solid #87c80a");

            },
            //--- on blur auto save to cart ---//
            onfocusout: function(element) {
                $(element).valid();
                elemId = $(element).attr('id');
                elemVal = $(element).val();

                if (elemId == "bill_name" ||
                    elemId == "bill_province_id" ||
                    elemId == "bill_city_id" ||
                    elemId == "bill_district_id" ||
                    elemId == "bill_postcode" ||
                    elemId == "bill_address"

                    )
                {
                    var params = {

                        bill_name: $('#bill_name').val(),
                        bill_province_id: $('#bill_province_id').val(),
                        bill_city_id : $('#bill_city_id').val(),
                        bill_district_id : $('#bill_district_id').val(),
                        bill_postcode : $('#bill_postcode').val(),
                        bill_address: $('#bill_address').val()
                    };
                    //save Billing Info
                    saveBillingInfo(params);

                }

                //save creditnum
                if(elemId == 'creditnum')
                {
                    var creditnumVal = $('#creditnum').val();
                    if(creditnumVal.length == 16)
                    {
                        var subVal = creditnumVal.substring(0, 6);
                        setCardData(subVal);
                    }

                }

            },
            onclick : function(element) {
                elemId = $(element).attr('id');
                if(elemId == "address-tax"){
                    var chk = (element.checked)? "Y" : "N";
                    var params = {
                        field: 'bill_same_shipping',
                        val: chk
                    };
                    // Save use Billing checkbox.
                    saveCartInfo(params);
                }
            }
        });
    }
}

function _addJqueryValidateRules(){
    jQuery.validator.addMethod("prefix", function(value, element, params) {

        if ( ($('#new-ccw').is(':checked') || $('#new-ccw').length == 0) && (getPaymentChannel() == 'credit-card') ){
            if( params[0] == 4 || params[0] == 5)
            {
                return true;
            }
            else
            {
                if(getPaymentChannel() == 'credit-card')
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }
        }
        else
        {
            return true;
        }
    }, jQuery.validator.format(__('step3-credit-card-prefix')));

    // add rule for validate card name
    jQuery.validator.addMethod("validcardname", function(value, element) {
        return this.optional(element) || value.match('^[- A-Z_.,]+$');
    });
}

function savePaymentInfo(paymentChannel)
{
    switch(paymentChannel) {
        case 'credit-card':
            var pkey_channel = '155413837979192';
            break;
        case 'atm':
            var pkey_channel = '156513837979495';
            break;
        case 'ibank':
            var pkey_channel = '158913837979603';
            break;
        case 'bank':
            var pkey_channel = '152313837979681';
            break;
        case 'cservice':
            var pkey_channel = '153211444223894';
            break;
        case 'cod':
            var pkey_channel = '155613837979771';
            break;
        case 'installment':
            var pkey_channel = '156813837979402';
            break;
        default:
            var pkey_channel = '';
    }

    setCartType(paymentChannel);

    $.ajax({
        async: true,
        type : 'POST',
        url : UrlToLang('ajax/checkout/set-payment-info'),
        data: {
            payment_method: pkey_channel
        },
        beforeSend: function(data){

        },
        success: function(data){
        }
    });

    //if credit card must check credit
    if(paymentChannel == 'credit-card')
    {
        var creditnumVal = $('#creditnum').val();
        if(creditnumVal.length == 16)
        {
            var subVal = creditnumVal.substring(0, 6);
            setCardData(subVal);
        }
    }
    else
    {
        clearCreditForm();
        setCardData('');
    }
}

function saveCartInfo(params){

    $.post(
        UrlToLang('ajax/checkout/set-cart-info'),
        params,
        function (data){
            //do nothing
        },
        'html'
    );
}

function saveBillingInfo(params){
    $.post(UrlToLang('ajax/checkout/set-bill-info'),
        params,
        function (data){
            //do nothing
        },
        'html'
    );
}

function PaymentConfirmPopup(form, channel){

    if( ! $("#payment-submit-btn").parent().parent().hasClass("disable") ){
        $("#confirm-payment-submit").unbind("click").bind("click", function(){
            $(document).trigger("clear-stage-cookie");
            $("#confirm-payment-popup-msg").modal("hide");
            $(document).trigger("show-ajax-loading");
            form.submit();
        });

        $(".confirm-payment-close-btn").unbind("click").bind("click", function(){
            $("#confirm-payment-popup-msg").modal("hide");
        });

        var langKey = channel+"-confirm-payment";
        $("#confirm-payment-popup-text").html(__(langKey));
        $("#confirm-payment-popup-msg").modal("show");
    }

}

function getPaymentChannel(){
    try{
        return $("input[name='payment_channel']:checked").val().toLowerCase();
    }catch(err){
        return null;
    }
}

function isBillAddressChecked(){
    return $("#address-tax").is(':checked');
}


/** Set cart Type. */
var checkoutObject3 = null;
function setCartType(channel){

    cartType = '';
    if(channel == "installment"){
        cartType = "installment";
    }else{
        cartType = "normal"
    }

    if(checkoutObject3 != null){
        if(checkoutObject3.data.type == cartType){
            //reduce ajax called.
            return true;
        }
    }

    $(document).trigger("show-ajax-loading");
    $.ajax({
        async: true,
        type : 'POST',
        url : UrlToLang('ajax/cart/set-type'),
        data: {
            type: cartType
        },
        success: function(data){
            checkoutObject3 = data;
            $(document).trigger("refresh-minicart");
        }
    });
}

/**
 *  Payment Manangement. Show/Hide error message for each payment.
 */
function initPayment(){
    validatePaymentChannel($("input[name='payment_channel']:checked").val());
}
function validatePaymentChannel(paymentChannel){

    if(paymentChannel == undefined){
        return false;
    }

    $("#payment-submit-btn").parent().parent().addClass("disable");
    $(".payment-channel .add-remark").slideDown();

    var template = step3ErrorManager.validateErrorMessage(paymentChannel);

    //validate to be success
    if(template === true && paymentChannel != "installment"){
        // this payment can pay.
        $(".clear-error-msg").slideUp("slow", function() {
            $(this).html("");
        });
        $("#payment-submit-btn").parent().parent().removeClass("disable");
    }else if(typeof template == "boolean" && paymentChannel == "installment"){
        //trigger to show conflict products.
        $("#pay_per_month").trigger("change");
    }else if(typeof template == "string"){
        $("#"+paymentChannel+"-payment-block").hide();
        $("#"+paymentChannel+"-payment-error").html(template).slideDown();
    }
}

function setCardData(subVal)
{
    $.ajax({
        async: true,
        type : 'POST',
        url : '/ajax/cart/set-card-data',
        data: {
            'creditnum': subVal
        },
        beforeSend: function(){$(document).trigger("show-ajax-loading");},
        success: function(data){
            if(data.data.promotion_ccw == true)
            {
                var removeCouponElement = $('.remove-coupon');
                if(removeCouponElement)
                {
                    MiniCart.RemoveCoupon.removeCoupon(removeCouponElement);
                }
                $("#promotion-ccw-popup-msg").modal("show");
            }
            $(document).trigger("hide-ajax-loading");
        },
        error: function(data){
            $(document).trigger("hide-ajax-loading");
        }
    });
    return true;
}

function clearCreditForm()
{
    $('#form-payment .form-control').removeAttr('style');
    $('#form-payment .active-alert-text').remove();
    $('#ccw-info-name').val('');
    $('#creditnum').val('');
    $('input[name="expiremonth"]').val('');
    $('input[name="expireyear"]').val('');
    $('input[name="ccv"]').val('');
}

