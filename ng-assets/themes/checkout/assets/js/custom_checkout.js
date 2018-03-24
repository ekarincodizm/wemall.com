$(document).ready(function(){
    // [S] set stage to cookie.
    var patStep1 = /checkout\/step1/gi;
    var patStep2 = /checkout\/step2/gi;
    var patStep3 = /checkout\/step3/gi;
    var patThankyou = /checkout\/thank-you/gi;

    if(patStep1.test(location.pathname)){
        document.cookie="stage=s1;path=/";
    }else if(patStep2.test(location.pathname)){
        document.cookie="stage=s2;path=/";
    }else if(patStep3.test(location.pathname)){
        document.cookie="stage=s3;path=/";
    }else if(patThankyou.test(location.pathname)){
        document.cookie="stage=; expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
    }
    // [E] set stage to cookie.

    $(document).bind("clear-stage-cookie", function(){
        document.cookie="stage=; expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
    });


    if($("#thankyou-register-lightbox").length > 0){
        var validator = $("#thankyou-register-lightbox").validate({
            rules: {
                email_password: {
                    required: true,
                    minlength: 6,
                    maxlength: 16
                }
            },
            messages:{
                email_password: {
                    required: __("thankyou-required-password"),
                    minlength: __("thankyou-password-limit"),
                    maxlength: __("thankyou-password-limit")
                }
            },
            errorPlacement: function(error, element) {
                $(element).siblings(".idcard-number-success").remove();
                error.insertAfter(element);
            },
            submitHandler: function(form) {
				form.submit();
                return false;
            },
            errorElement: 'div',
            errorClass: 'active-alert-text',
            highlight: function(element, errorClass) {
                $(element).siblings(".idcard-number-success").remove();
                $(element).css("border", "2px solid #fe040d");
            },
            unhighlight: function(element, errorClass){
                $(element).siblings(".idcard-number-success").remove();
                var correctIcoURL = site_url+'themes/checkout/assets/images/success.png';
                $(element).css("border", "2px solid #87c80a");
                $("<div class='left idcard-number-success'><img src='"+correctIcoURL+"' width='14' height='14' /></div>").insertAfter($(element));
            },
            onfocusout: function(element) {
                $(element).valid();
            }
        });
    }

});