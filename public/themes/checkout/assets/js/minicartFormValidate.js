$(document).ready(function() {
    if($("#coupon_voucher_code").length > 0){
        var enableCoupon = function () {
            if($('#coupon-text').val().length == 0){
                $("#coupon-text").removeClass("coupon-text-border-green");
                $('#coupon_button').removeClass("background-green-btn");
            }else{
                $("#coupon-text").addClass("coupon-text-border-green");
                $('#coupon_button').addClass("background-green-btn");
            }
        }

        $(document).delegate('#coupon-text', 'change', enableCoupon);
        $(document).delegate('#coupon-text', 'keyup', enableCoupon);


        $("#coupon_voucher_code").validate({
            rules: {
                code: {
                    required: true
                }
            },
            onfocusout: function(element){
                $(element).valid();
            },
            messages: {
                code: {
                    required: __('step3-required-Coupon-Code')
                }
            },
            errorPlacement: function(error, element) {
                $(element).siblings(".icon-coupon-success").remove();
                
                $(error).attr('id', 'coupon_code_error');
                error.insertAfter($('#coupon_button'));
            },
            submitHandler: function(form) {
                form.submit();
            },
            errorElement: 'div',
            errorClass: 'active-alert-text',
            highlight: function(element, errorClass) {
                $(element).siblings(".icon-coupon-success").remove();
                $(element).css("border", "2px solid #fe040d");
            },
            unhighlight: function(element, errorClass){
                var correctIcoURL = site_url+'themes/checkout/assets/images/success.png';
                $(element).css("border", "2px solid #87c80a");
                $("<div class='left icon-coupon-success'><img src='"+correctIcoURL+"' width='14' height='14' /></div>").insertAfter($(element));
            }
               
        });
    }
});