$(function() {
	$('.regis-notice').notice({
        topic: 'ข้อตกลงการใช้บริการ',
        btnText: 'ตกลง',
    	msg: 'register_main_right_c'
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
            $('#st-mobile').hide('fast', function() {

                $('#show_mobile_number').val(mssisdn);

                $('#st-detail').show();

                $(this).remove();
            });
        }
    });
    
}
