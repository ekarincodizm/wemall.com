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

    $.validator.addMethod("regx", function(value, element, regexpr) {
        return regexpr.test(value);
    }, "* Password must be between 8-25 characters with 1 special character, letters, and at least 1 number.");

    $.validator.addMethod("regxu", function(value, element, regexpr) {
        return !regexpr.test(value);
    }, "* Display name must be between 2-20 characters. Allow letters, numbers, and spaces.");


    if($("#thankyou-register-lightbox").length > 0){
        var validator = $("#thankyou-register-lightbox").validate({
            rules: {
                email_display_name: {
                    required: true,
                    minlength:2,
                    maxlength:20,
                    regxu:/[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+/
                },
                email_password: {
                    required: true,
                    minlength: 8,
                    maxlength: 25,
                    regx: /[A-z]+\d+[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+|[A-z]+[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+\d+|\d+[A-z]+[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+|\d+[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+[A-z]+|[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+[A-z]+\d+|[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+\d+[A-z]+/
                }
            },
            messages:{
                email_display_name: {
                    required: __('display-name-required')
                },
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