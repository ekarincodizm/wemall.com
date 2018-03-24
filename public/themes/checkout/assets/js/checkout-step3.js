var check_first_load = true;
jQuery(document).ready(function($){

    if (check_first_load == true)
    {


        check_first_load == false;
        //if ($(".c-main .c-tab-2 li.install").attr("rel") == "available")
        //{
        //    //$('.c-tab-2 ul li.install h2 a').trigger('click');
        //}
        //else
        //{
        //    $('.c-tab-2 ul li.visa h2 a').trigger('click');
        //}
        $(document).bind("show-ajax-loading",me.show);
        //$('.c-tab-2 ul li.ibank h2 a').trigger('click');

    }

    $(".credit-card-content input:text").val('');
    $(".credit-card-content input:password").val('');

    // make ccw-info-name always capital letter
    $('#ccw-info-name').css('text-transform', 'uppercase');
    $('#ccw-info-name').keyup(function() {
        // store cursor positions
        var start = this.selectionStart;
        var end = this.selectionEnd;

        $(this).val($(this).val().toUpperCase());

        // move cursor positions back
        this.setSelectionRange(start, end);
    });

    var select_credit_card = $("#select-credit-card").val();

    if(select_credit_card === undefined)
    {
        $(".credit-card-content").show();
    }

    $(document).on('click', '#add-invoice',  function() {
        if($(this).is(':checked'))
        {
            $.post(
                '/ajax/checkout/set-cart-info',
                {
                    field: 'bill_same_shipping',
                    val: 'Y'
                },
                function (data){

                },
                'html'
                );
        }
        else
        {
            $.post(
                '/ajax/checkout/set-cart-info',
                {
                    field: 'bill_same_shipping',
                    val: 'N'
                },
                function (data){

                },
                'html'
                );
        }
    });


    $(document).on('click', '.c-main .c-tab-2 li',  function() {
        var str = $(this).attr('class');
        var attr_val = str.replace(" active", "");

        last_payment = $('.last-payment').text();

        if( hasCODShippingMethod() && attr_val == 'hservice')
        {
            $('.cartlightbox-update-shipping-method').find('option[value="14456917914435"]').attr('selected','selected');
            cartLightbox.updateShippingMethod();
        }
        else if( hasCODShippingMethod() && (last_payment == 'hservice' || last_payment == 'COD') )
        {
            $('.cartlightbox-update-shipping-method').val($('.cartlightbox-update-shipping-method option:first').val());
            cartLightbox.updateShippingMethod();
        }

        $('.last-payment').text(attr_val);

        $('.c-main .c-tab-2 li').removeAttr('active');
        $(this).addClass('active');

        step3ErrorManager.setAlertMsg();

        save_payment_info(attr_val);
    });

    if ($('.c-main').attr('data-tab-active') == "")
    {
        // -- save_payment_info -- //
        var ctab2 = $(".c-main .c-tab-2 li.active").attr('class');
        if(ctab2 == undefined)
        {
            if($(".c-main .c-tab-2 li.visa").length > 0){
                var attr_val = 'visa';
            }else{
                attr_val = $(".c-main .c-tab-2 li:first").attr("class");
            }

        }
        else
        {
            var attr_val = ctab2.replace(" active", "");
        }

        save_payment_info(attr_val);
    }
    else
    {
        var tabActive = $('.c-main').attr('data-tab-active');
        /**
         * check to see that there is a payment method you choosed before.
         * if it isn't here. we will click the first payment instead.
         */
        var classMap = {
            atm: "atm",
            ccinstm: "install",
            ccw: "visa",
            ibank: "ibank",
            banktrans: "bank",
            cod: "hservice",
            cs: "cservice"
        };


     if($(".c-tab-2 ul li."+classMap[tabActive.toLowerCase()]).length > 0){
        switch (tabActive.toLowerCase())
        {
            case "atm" :
                $('.c-tab-2 ul li.atm h2 a').trigger('click');
                break;

            case "ccinstm" :
                $('.c-tab-2 ul li.install h2 a').trigger('click');
                break;

            case "ccw" :
                $('.c-tab-2 ul li.visa h2 a').trigger('click');
                break;

            case "ibank" :
                $('.c-tab-2 ul li.ibank h2 a').trigger('click');
                break;

            case "banktrans" :
                $('.c-tab-2 ul li.bank h2 a').trigger('click');
                break;

            case "cod" :
                $('.c-tab-2 ul li.hservice h2 a').trigger('click');
                break;

            case "cs" :
                $('.c-tab-2 ul li.cservice h2 a').trigger('click');
                break;

            default :
                $('.c-tab-2 ul li:first h2 a').trigger('click');
                break;
        }
     }else{
            $('.c-tab-2 ul li:first h2 a').trigger('click');
     }

    }



    jQuery.validator.addMethod("prefix", function(value, element, params) {

        attr_val = check_payment();
        if ( ($('#new-ccw').is(':checked') || $('#new-ccw').length == 0) && (attr_val == 'visa') ){
            if( params[0] == 4 || params[0] == 5)
            {
                return true;
            }
            else
            {
                if(attr_val == 'visa')
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

    if($("#form-payment").length > 0){
        $("#form-payment").validate({
            rules: {
                // Select CCW Card
                creditno: {
                    required: {
                        depends: function(element) {
                            attr_val = check_payment();
                            if ($('#select-credit-card').is(':checked') && (attr_val == 'visa') ){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    }
                },

                // New CCW Card
                creditname: {
                    required:{
                        depends: function(element) {
                            attr_val = check_payment();
                            if ( ($('#new-ccw').is(':checked') || $('#new-ccw').length == 0) && (attr_val == 'visa') ){
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
                            attr_val = check_payment();
                            if (($('#new-ccw').is(':checked') || $('#new-ccw').length == 0) && (attr_val == 'visa') ){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    },
                    digits: true,
                    rangelength: [16,16],
                    prefix: function(element){
                        return $(element).val();
                    }
                },
                expiremonth: {
                    required: {
                        depends: function(element) {
                            attr_val = check_payment();
                            if ( ($('#new-ccw').is(':checked') || $('#new-ccw').length == 0) &&  (attr_val == 'visa') ){
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
                            attr_val = check_payment();
                            if ( ($('#new-ccw').is(':checked') || $('#new-ccw').length == 0) && (attr_val == 'visa') ){
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
                            attr_val = check_payment();

                            if ( ($('#new-ccw').is(':checked') || $('#new-ccw').length == 0) && (attr_val == 'visa') ){
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
                            if ($('#add-invoice').is(':checked')){
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
                            if ($('#add-invoice').is(':checked')){
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
                            if ($('#add-invoice').is(':checked')){
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
                            if ($('#add-invoice').is(':checked')){
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
                    //        if ($('#add-invoice').is(':checked')){
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
                            if ($('#add-invoice').is(':checked')){
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
                            if ($('.box-left .install.active').length > 0){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    }
                }
            },
            messages: {
                pay_per_month:{
                    required: __("step3-select-install-period")
                },
                creditno: {
                    required:  __("step3-select-credit")
                },
                creditname: {
                    required: __("step3-enter-creditname"),
                    validcardname: __("step3-enter-valid-creditname")
                },
                creditnum:{
                    required: __("step3-enter-creditno"),
                    digits: __("step3-enter-digit-creditno"),
                    rangelength: __("step3-enter-range-length-16")
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
                }
            },

            errorPlacement: function(error, element) {
                $(element).siblings(".icon-success-2").remove();
                if($(element).attr('name') != 'expiremonth')
                {
                    error.insertAfter(element);
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

                var str = $('.c-main .c-tab-2 li.active').attr('class');
				var attr_val = str.replace(" active", "");

				var payable = ManageCampaignProductLightbox.Main.check();

                if(payable){
                    if(attr_val == "visa" || attr_val == "install"){
                        PaymentConfirmPopup(form, attr_val);
                    }else{
                        $(document).trigger("clear-stage-cookie");
                        $('#step3-submit').attr("disabled", true);
                        $('#step3-submit').val(__('processing'), true);
                        $(document).trigger("show-ajax-loading");
                        form.submit();
                    }
                }

                return false;
            },
            errorElement: 'div',
            errorClass: 'active-alert-text',
            highlight: function(element, errorClass) {
                $(element).siblings(".icon-success-2").remove();
                $(element).css("border", "2px solid #fe040d");
            },
            unhighlight: function(element, errorClass){
                var correctIcoURL = site_url+'themes/checkout/assets/images/success.png';
                $(element).css("border", "2px solid #87c80a");
                $("<div class='left icon-success-2'><img src='"+correctIcoURL+"' width='14' height='14' /></div>").insertAfter($(element));
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

                    $.post(
                        '/ajax/checkout/set-bill-info',
                        {

                            bill_name: $('#bill_name').val(),
                            bill_province_id: $('#bill_province_id').val(),
                            bill_city_id : $('#bill_city_id').val(),
                            bill_district_id : $('#bill_district_id').val(),
                            bill_postcode : $('#bill_postcode').val(),
                            bill_address: $('#bill_address').val()
                        },
                        function (data){

                        },
                        'html'
                        );
                }

                if(
                    elemId == "creditno")
                    {
                    elemText = $('[name="creditno"] option:selected').text();
                    $.post(
                        '/ajax/checkout/set-bill-info',
                        {
                            card_token: elemVal,
                            card_label: elemText
                        },
                        function (data){

                        },
                        'html'
                        );
                }

                //save creditnum
                if(elemId == 'ccw-info-no')
                {
                    var creditnumVal = $('#ccw-info-no').val();
                    if(creditnumVal.length == 16)
                    {
                        var subVal = creditnumVal.substring(0, 6);
                        setCardData(subVal);
                    }

                }

            },
            onclick : function(element) {
                elemId = $(element).attr('id');
                elemVal = $(element).val();

                if(
                    elemId == "select-credit-card" ||
                    elemId == "new-ccw")
                    {
                    $.post(
                        '/ajax/checkout/set-bill-info',
                        {
                            is_new_ccw: elemVal
                        },
                        function (data){

                        },
                        'html'
                        );
                }

                if(elemId == "save_ccw")
                {
                    var is_check = $(element).is(':checked');

                    if(is_check)
                    {
                        val = 'Y';
                    }
                    else
                    {
                        val = 'N';
                    }

                    $.post(
                        '/ajax/checkout/set-bill-info',
                        {
                            save_ccw: val
                        },
                        function (data){

                        },
                        'html'
                        );
                }
            }
        });

        $( '[name="savecredit"]' ).on( "click", function() {
            var new_option =  $('[name="creditno"] option').size();
            if(new_option >= 5)
            {
                $('#modal-save-credit').modal('show');
                $(this).attr('checked', false);
            }
        });
    }

    // [B] Change province drop down billing address
    $('#bill_province_id').change(function(){

        var provinceName = $('#bill_province_id :selected').text();
        var isBKK = (provinceName === 'กรุงเทพมหานคร');
        //$('#city-name').text(isBKK ? __('step3-special-district') : __('step3-district'));
        //$('#district-name').text(isBKK ? __('step3-special-subdistrict') : __('step3-subdistrict') );

        $('#bill_city_id').resetSelect(__("step2-select-city"));
        $('#bill_district_id').resetSelect(__("step2-select-district"));
        $('#bill_postcode').resetSelect(__("step2-select-zipcode"));

        if ($(this).val() != "")
        {
            $('#bill_city_id').showLoading(__('step2-loading'));

            var cities = Geolocation.Main.getCities($(this).val());
      
            if( cities != undefined && cities != null ){
                if ($('#bill_province_id :selected').text() == "กรุงเทพมหานคร")
                {
                    $('#bill_city_id').loadSelect(cities, __('step2-select-city-special'));
                    $('#bill_district_id').resetSelect(__("step2-select-district-special"));
                }
                else
                {
                    $('#bill_city_id').loadSelect(cities, __('step2-select-city'));
                    $('#bill_district_id').resetSelect(__("step2-select-district"));
                }
            }else{

                $.post(
                    $(this).attr('data-url'),
                    {
                        province_id : $(this).val(),
                        mode: 'province'
                    },
                    function (data){

                        if (data != null && data != NaN && data != "" && data != undefined)
                        {
                            var jsonDecode = $.parseJSON(data);
                            if ($('#bill_province_id :selected').text() == "กรุงเทพมหานคร")
                            {
                                $('#bill_city_id').loadSelect(jsonDecode, __('step2-select-city-special'));
                                $('#bill_district_id').resetSelect(__("step2-select-district-special"));
                            }
                            else
                            {
                                $('#bill_city_id').loadSelect(jsonDecode, __('step2-select-city'));
                                $('#bill_district_id').resetSelect(__("step2-select-district"));
                            }
                        }
                    },
                    'html'
                    );
            }
        }
    });
    // [E] Change province drop down billing address

    // [B] Change city drop down billing address
    $('#bill_city_id').change(function(){
        $('#bill_district_id').resetSelect(__("step2-select-district"));
        $('#bill_postcode').resetSelect(__("step2-select-zipcode"));
        if ($(this).val() != "")
        {
            $('#bill_district_id').showLoading(__('step2-loading'));

            var districts = Geolocation.Main.getDistricts($(this).val());
            // get all districts from js object first (geolocation.js).
            if( districts != undefined && districts != null ){
                if ($("#bill_province_id :selected").text() == "กรุงเทพมหานคร")
                {
                    $('#bill_district_id').loadSelect(districts, __('step2-select-district-special'));
                }
                else
                {
                    $('#bill_district_id').loadSelect(districts, __('step2-select-district'));
                }
            }else{
                $.post(
                    $(this).attr('data-url'),
                    {
                        city_id : $(this).val(),
                        mode: 'city'
                    },
                    function (data){
                        if (data != null && data != NaN && data != "" && data != undefined)
                        {
                            var jsonDecode = $.parseJSON(data);

                            if ($("#bill_province_id :selected").text() == "กรุงเทพมหานคร")
                            {
                                $('#bill_district_id').loadSelect(jsonDecode, __('step2-select-district-special'));
                            }
                            else
                            {
                                $('#bill_district_id').loadSelect(jsonDecode, __('step2-select-district'));
                            }
                        }
                    },
                    'html'
                );
            }

        }
    });
    // [E] Change city drop down billing address

    // [B] Change district drop down billing address
    $('#bill_district_id').change(function(){
        $('#bill_postcode').resetSelect(__("step2-select-zipcode"));
        if ($(this).val() != "")
        {
            $('#bill_postcode').showLoading(__('step2-loading'));

            var zipcode = Geolocation.Main.getZipcode($(this).val());
            // get all districts from js object first (geolocation.js).
            if( zipcode != undefined && zipcode != null ){
                $('#bill_postcode').loadSelect(zipcode, __('step2-select-zipcode'));
            }else{
                $.post(
                    $(this).attr('data-url'),
                    {
                        district_id : $(this).val(),
                        mode: 'district'
                    },
                    function (data){
                        var jsonDecode = $.parseJSON(data);
                        if (data != null && data != NaN && data != "" && data != undefined)
                        {
                            $('#bill_postcode').loadSelect(jsonDecode, __('step2-select-zipcode'));
                        }
                    },
                    'html'
                    );
            }
        }
    });
    // [E] Change district drop down billing address

    $('input[name=channel-atm]').on( "click",function(){

        $.post(
            '/ajax/checkout/set-customer-info',
            {
                bank_name: $('input[name=channel-atm]:checked').val()
            },
            function(data){

            },
            'html'
            );
    });

    $('#promotion-ccw-popup-msg #close-btn').on( "click",function(){
        $("#promotion-ccw-popup-msg").modal("hide");
    });
    $("#promotion-ccw-popup-msg .confirm-payment-close-btn").on("click", function(){
        $("#promotion-ccw-popup-msg").modal("hide");
    });
});

function call_cod()
{
    $.ajax({
        async: true,
        type : 'GET',
        url : '/ajax/widget/payment-cod',
        success: function(data){
            $(".c-tab-2 ul").append(data.menu);
            $(".c-info-in").prepend(data.content);
        }
    });
}

function check_payment()
{
    var ctab2 = $(".c-main .c-tab-2 li.active").attr('class');
    var attr_val = ctab2.replace(" active", "");
    return attr_val;
}

function save_payment_info(attr_val)
{
    switch(attr_val) {
        case 'visa':
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
        case 'hservice':
            var pkey_channel = '155613837979771';
            break;
        case 'install':
            var pkey_channel = '156813837979402';
            break;
        default:
            var pkey_channel = '';
    }

    //To set user's cart can apply promotions or not.
    setCartType(attr_val);

    //if credit card must check credit
    if(attr_val == 'visa')
    {
        var creditnumVal = $('#ccw-info-no').val();
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

    $.ajax({
        async: true,
        type : 'POST',
        url : '/ajax/checkout/set-payment-info',
        data: {
            payment_method: pkey_channel
        },
        beforeSend: function(data){
            $(document).trigger("show-ajax-loading");
            $('#step3-submit').attr("disabled", true);
        },
        success: function(data){
            var modalDanger = $('.alert-danger');
            if(modalDanger.is(':visible')){
                $("#step3-submit").attr("disabled","disabled");
            }else{
                $("#step3-submit").removeAttr("disabled");
            }
            $(document).trigger("hide-ajax-loading");
        }
    });
}

function hasCODShippingMethod(){
    var CODSelected = false;
    $('.cartlightbox-update-shipping-method').each(function(){
        $.each($(this).find("option"), function(idx, el){
            if($(el).val() == "14456917914435"){
                CODSelected = true;
                //break each by return true.
                return true;
            }
        });
        if(CODSelected == true){
            //break each by return true.
            return true;
        }
    });

    return CODSelected;
}

var checkoutObject3 = null;
function setCartType(channel){

    //no need to do this function if it's mobile.
    if( isMobile() ){
        return true;
    }

    cartType = '';
    if(channel == "install"){
        cartType = "installment";
    }else{
        cartType = "normal"
    }

    if(checkoutObject3 != null){
        if(checkoutObject3.data.type == cartType){
            //reduce ajax called.
            $(document).trigger("hide-ajax-loading");
            return true;
        }
    }

    $(document).trigger("show-ajax-loading");
    $.ajax({
        async: true,
        type : 'POST',
        url : '/ajax/cart/set-type',
        data: {
            type: cartType
        },
        success: function(data){
            checkoutObject3 = data;
            $(document).trigger("refresh-cart-lightbox");
        }
    });

}

function PaymentConfirmPopup(form, channel){

    if( ! $("#step3-submit").hasClass("btn-disabled") ){
        $("#confirm-payment-submit").unbind("click").bind("click", function(){

            $(document).trigger("clear-stage-cookie");
            $("#confirm-payment-popup-msg").modal("hide");
            $(this).attr("disabled", "disabled");
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
    $('#form-payment .input-info').removeAttr('style');
    $('#form-payment .select-month-day').removeAttr('style');
    $('#form-payment .active-alert-text').remove();
    $('.icon-success-2').remove();
    $('#ccw-info-name').val('');
    $('#ccw-info-no').val('');
    $('#month').val('');
    $('#year').val('');
    $('input[name="ccv"]').val('');
}




