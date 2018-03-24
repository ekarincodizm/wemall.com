$(function() {
	var oIdx = 0, nIdx;
    $(function () {
        $('ul#register_tab li').click(function () {
            nIdx = $(this).index('ul#register_tab li');
            $('ul#register_tab li').eq(oIdx).removeAttr('class').addClass('register_tab_default');
            $(this).removeAttr('class').addClass('register_tab_active');

            $('div.register_info').hide().eq(nIdx).show();
            oIdx = nIdx;
        });
    });
});

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
    //$('[name=get_otp_password]').addClass('disabled');
    $('[name=get_otp_password]').attr("disabled", 'disabled').css({'color':'#CCCCCC'}).css({'cursor':'text'});

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
                $('#mobile_step2').show();
                $('#conditions').show();
                $('[name="accept"]').attr('id','mobile_accept');
                $('div#inc-action-box .m_regis').removeAttr("onclick").attr('name','btn_register');
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
