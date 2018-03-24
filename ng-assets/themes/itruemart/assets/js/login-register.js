$(function() {


    var register_active = false;
    var thai_idcard = '';

    $('#email_idcard').on('keyup', function () {
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });

    //add to prevent user accidentially post using 'return/enter' key
    $('#formRegister').bind('keypress', function (e) {
        // console.log(e.keyCode);

        if (e.keyCode == 13) {
            return false;
        }
    });

    /**
     * Form register submmited.
     *
     * @return void
     */
    $('[name=btn_register]').on('click', function(e) {

        if (register_active == true)
        {
            return false;
        }

        // Channel to register. email | mobile
        var type = $('#register_channel').val();

        if ( type == 'email' )
        {
            var thai_idcard = $("#email_idcard").val();
        }
        else
        {
            var thai_idcard = $("#mobile_idcard").val();
        }


        if ( thai_idcard != '' )
        {
            if(checkID(thai_idcard) == false)
            {
                showAlertDialog(__('id card incorrect'), __('id card incorrect'));
                return false;
            }
        }

        $form  = $('form#formRegister');
        $error = $('#register_error_msg');

        // Clear error message.
        $error.text('');

        // Channel to register.
        var type = $('#register_channel').val();

        var data = $form.serialize();

        register_active = true;

        $.ajax({
            url: $form.attr('url'),
            type: 'POST',
            data: data,
            success: function(res) {

                // Having error.
                if ( res.status == true )
                {
                    /*if(site_url == 'http://www.itruemart.com')
                    {
                        if(res.data.user_id != '' && res.data.user_id != undefined)
                        {
                            window._fbq.push(["track", "Register", {
                                member_id: res.data.user_id
                            }]);
                            // Conversion Event
                            window._fbq.push(['track', '6020486847532', {}]);
                        }
                    }*/
                    window.location = site_url;
                }
                else
                {
                    showAlertDialog(__(res.error), __(res.error));
                    return false;
                }


                //setTimeout("location.href = site_url;",4000);
                window.localtion = site_url;

            }
        }).then(function(data){
            register_active = false;
        });;

        e.preventDefault();
    });

    /**
     * Policy agreement.
     *
     * @return void
     */
    $('#accept').on('click', function() {
        if ($(this).is(':checked')) {
            $('[name=btn_register]').css('display', 'block');
        }
        else {
            $('[name=btn_register]').css('display', 'none');
        }
    });

});

/**
 * Toggel register type.
 */
var ProfileFunction = function() {
    // $('a.toggle_item').click(function(event) {
    //     event.preventDefault();
    //     anchor = $(this);
    //     divSlide = anchor.parents('#total_cart').next('.slide_list');
    //     if (divSlide.css('display') === "none")
    //         divSlide.slideDown('fast');
    //     else
    //         divSlide.slideUp('fast');
    // });

    $('#register_tab_wrapper > a').click(function() {
        var register_channel = '';
        var aClass = $(this).attr('class');
        var rel = $(this).attr('rel');
        $('#register_tab_wrapper > div').hide();
        $('#register_tab_wrapper > a').show();
        $('#register_tab_wrapper > div.' + aClass).show();
        $('#register_tab_wrapper > a.' + aClass).hide();

        $('#register_main_left_c > div').hide();
        $('#register_main_left_c > div.' + rel).show();

        if (rel === 'register_email') {
            register_channel = 'email';
        } else if (rel === 'register_mobile') {
            register_channel = 'mobile';
        } else if (rel === 'register_truecard') {
            register_channel = 'truecard';
        }

        $('input[name="register_channel"]').val(register_channel);
    });

};

ProfileFunction();


/**
 * Forget password pop up.
 *
 * @return void
 */
var forgetPassword = function() {
    url = 'http://trueid.truelife.com/userv4/forgot_password/th';

    popupWindow = window.open(url,'popUpWindow','height=600,width=1000,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes');
}

/**
 * Request OTP to register via mobile.
 *
 * @param  integer mobile
 * @return void
 */
var registerRequestOtp = function(mobile) {

    var mssisdn = $(mobile).val();

    if ( ! mssisdn) return;

    // Disable button.
    $('[name=get_otp_password]').addClass('disabled');

    $.post('/users/ajax-request-otp', { mobile: mssisdn }, function(res) {

        // Request fails.
        if (res.status != 'success') {
            alert(__('ขออภัยค่ะ สำหรับลูกค้า TrueMove และ TrueMove-H เท่านั้น'));
            return;
        }

        // Passes.
        if (res.status == 'success') {

        }
    });
}

/**
 * Validate OTP with mobile number.
 *
 * @param  integer mobile
 * @param  mixed   otp
 * @return void
 */
var registerValidateOtp = function(mobile, otp) {

    var mssisdn = $(mobile).val();

    var otp = $(otp).val();

    if ( ! mssisdn || ! otp) return;

    $.post('/users/ajax-validate-otp', { mobile: mssisdn, otp: otp }, function(res) {

        // Validate fails.
        if (res.status != 'success') {
            alert(__('รหัสการยืนยันไม่ถูกต้อง'));
            return;
        }

        // Passes.
        if (res.status == 'success') {
            $('#mobile_step1').hide('fast', function() {

                $('#show_mobile_number').text(mssisdn);
                //$('[name=username').val(mssisdn);

                $('#mobile_step2').show();

                $(this).remove();
            });
        }
    });
}


var registerCheckEmail = function(email) {

    var email = $(email).val();

    if ( ! email) return;

    $.post('/users/ajax-check-email', { email: email }, function(res) {
        //alert(res.message);
        showAlertDialog(res.message, res.message);
    });
}

var showAlertDialog = function(title, msg) {

    if ( ! msg) return;

    $('.alert-title').text(__(title));
    $('.alert-message').text(__(msg));

    $('#register-alert').reveal({
        animation: 'none',
        dismissmodalclass: 'popup_ok'
    });
};

function checkID(id)
{
    if(id.length != 13) return false;
    for(i=0, sum=0; i < 12; i++)
    sum += parseFloat(id.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(id.charAt(12)))
    return false; return true;
}
