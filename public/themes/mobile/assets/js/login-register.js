$(document).ready(function(){
    var addSpan = '<span class="icon-error">!</span>';

    $.validator.addMethod(
        "checkID",
        function(value, element) {
            if(value.length != 0){
                return checkID(value);
            }

            return true;
        },
        addSpan+__("thaiId-invalid")
    );

    $.validator.addMethod("regx", function(value, element, regexpr) {
        return regexpr.test(value);
    }, "<span class='icon-error'>!</span>Password must be between 8-25 characters with 1 special character, letters, and at least 1 number.");

    $.validator.addMethod("regxu", function(value, element, regexpr) {
        return !regexpr.test(value);
    }, "Display name must be between 2-20 characters. Allow letters, numbers, and spaces.");


    $("#formRegister").validate({
        rules: {
            email_username:{
                required:true,
                email: true
            },
            email_display_name: {
                required: true,
                minlength:2,
                maxlength:20,
                regxu:/[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+/
            },
            email_password: {
                required: true,
                minlength:8,
                maxlength:25,
                regx: /[A-z]+\d+[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+|[A-z]+[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+\d+|\d+[A-z]+[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+|\d+[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+[A-z]+|[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+[A-z]+\d+|[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+\d+[A-z]+/
            },
            email_password_confirmation: {
                required: true,
                equalTo: "#email_password"
            },
            email_thai_id: {
                checkID: true
            },
            accept: {
                required: true
            }
        },
        messages: {
            email_username: {
                required: addSpan+__('email-or-tureid-required'),
                email: addSpan+__('email-or-trueid-wrong')
                //remote: addSpan+__('email-or-trueid-wrong')
            },
            email_display_name: {
                required: addSpan+__('display-name-required')
            },
            email_password: {
                required: addSpan+__('enter-password'),
                minlength: addSpan+__('password-length')
            },
            email_password_confirmation: {
                required: addSpan+__('confirm-password-required'),
                equalTo: addSpan+__('register-invalid-re-password')
            },
            email_thai_id: {
                checkID: addSpan+__('thaiId-invalid')
            },
            accept: {
                required: addSpan+__('accept-term-condition-required')
            }
        },
        submitHandler: function(form) {

            $form  = $('form#formRegister');
            var data = $form.serialize();

            url_action = $("#formRegister").attr('action');

            $('.help-block').remove();

            $.ajax({
                url: $("#formRegister").attr('action'),
                type: "POST",
                data: data,
                success: function(res){

                    if(! res){
                        $(document).trigger("hide-ajax-loading");
                        return false;
                    }

                    if(res.status == true){
                        window.location.replace(site_url.replace('https', 'http')+"member/orders");
                        return true;
                    }

                    if(res.error == 'This email is already exists, please try again.(3003)'){
                        insertErrorElement('email_username');
                    }
                    else if(res.error == 'อีเมล์นี้มีอยู่ในระบบแล้ว กรุณาระบุใหม่ (3003)'){
                        insertErrorElement('email_username');
                    }
                    else if(res.error == 'Thai id used.'){
                        insertErrorElement('email_idcard', __(res.error));
                    }
                    else{
                        insertErrorElement('register_submit', res.error);
                    }

                    $(document).trigger("hide-ajax-loading");
                }
            });

            return false;
        },
        errorPlacement: function(error, element) {
            $(element).siblings('.help-block').remove();

            if($(element).attr('name') == 'accept'){
                error.insertAfter($("#termsAndCondition").siblings("span"));
                $(element).siblings("label").attr('data-id', $(element).attr('name')+'_error_message');
            }
            else{
                error.insertAfter(element);
                $(element).siblings(".help-block").attr('data-id', $(element).attr('name')+'_error_message');
            }

        },
        onfocusout: function(element){
            $(element).valid();
            
            $("[data-id='submit_register-message']").remove();

            var field_var = $(element).attr("name");
            var field_value = $(element).val();

            if(field_var == "email_username" && field_value != '' && field_value.length != 0)
            {
                checkEmail(addSpan);
            }

        },
        onclick: function(element){
            $(element).valid();
            if($(element).attr("name") == "accept"){
                if($("#termsAndCondition:checked").val() == 'ac'){
                    checkValidForm(true);
                }
                else{
                    checkValidForm(false);
                }
            }
        },
        errorClass: 'help-block error',
        highlight: function(element){
            $(element).siblings('.help-block').remove();
            $(element).parent().addClass('has-error').removeClass('success-input');
        },
        unhighlight: function(element){
            $(element).siblings('.help-block').remove();
            $(element).parent().removeClass('has-error').addClass('success-input');
        }

    });

    $( "#email_username" ).keydown(function() {
        $(this).removeAttr('data-valid');
    });

    $('#email_idcard').keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});



function checkID(id)
{
    if(id.length != 13) return false;
    for(i=0, sum=0; i < 12; i++)
        sum += parseFloat(id.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(id.charAt(12)))
    return false; return true;
}

function checkEmail(){

    if($("#email_username").attr('data-valid') == true){
        return false;
    }

    $.ajax({
        url: "/users/ajax-check-email",
        type: "POST",
        data: {
            email: $("#email_username").val()
        },
        beforeSend: function(){
            $(document).trigger("show-ajax-loading");
        },
        success: function(res){
            if(res.message == 'This email already taken.'){
                insertErrorElement('email_username', __('This email already taken.'));
            }
            else if(res.message == 'กรุณาระบุอีเมล์ให้ถูกต้อง (1004)'){
                $('#email_username').focus();
            }
            else{
                $("#email_username").attr('data-valid', true);
            }
        }
    });

    $(document).trigger("hide-ajax-loading");
}

function insertErrorElement(eleName, msg){
    var addSpan = '<span class="icon-error">!</span>';

    if(eleName == 'email_username'){
        if(! msg){
            msg = __('This email already taken.');
        }

        $('#email_username').focus();
        $("#email_username").parent().addClass('has-error').removeClass('success-input');
        var userDiv = '<label for="email_username" generated="true" class="help-block error" data-id="email_username_error_message">'+addSpan+msg+'</label>';
        $("#email_username").after( userDiv );
    }

    if(eleName == 'email_idcard'){
        $('#email_idcard').focus();
        $("#email_idcard").parent().addClass('has-error').removeClass('success-input');
        var userDiv = '<label for="email_idcard" generated="true" class="help-block error" data-id="email_idcard_error_message">'+addSpan+msg+'</label>';
        $("#email_idcard").after( userDiv );
    }

    if(eleName == 'register_submit'){
        $('#submit_register').focus();
        $("#submit_register").parent().addClass('has-error').removeClass('success-input');
        var userDiv = '<label for="submit" generated="true" class="help-block error" data-id="submit_register_error_message">'+addSpan+msg+'</label>';
        $("#submit_register").after( userDiv );
    }
}

function checkValidForm(validStatus){

    if(validStatus == false){
        $('#submit_register').attr("disabled", true);
        $("#submit_register").attr("style", "background-color:#d4d4d4;");
    }else{
        $("#submit_register").removeAttr("disabled");
        $("#submit_register").attr("style", "background-color:#95c126;");
    }

    return false;
}