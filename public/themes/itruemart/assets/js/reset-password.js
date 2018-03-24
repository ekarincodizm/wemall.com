var showAlertDialog = function(title, msg) {

    if ( ! msg) return;

    $('.alert-title').text(__(title));
    $('.alert-message').text(__(msg));

    $('#register-alert').reveal({
        animation: 'none',
        dismissmodalclass: 'popup_ok'
    });
};

var showSuccessDialog = function(title, msg) {

    if ( ! msg) return;

    $('.alert-title').text(__(title));
    $('.alert-message').text(__(msg));

    $('#popup-reset-success').reveal({
        animation: 'none',
        dismissmodalclass: 'popup_ok'
    });
};

$('#formForgot').bind('keypress', function (e) {
    // console.log(e.keyCode);
    if (e.keyCode == 13) {
        return false;
    }
});

$('#btn_confirm_resetpassword').on('click', function(e) {
    $(this).attr('disabled', true);
    $.ajax({
        url: $('#formResetpassword').attr('action'),
        type: 'POST',
        data: $('#formResetpassword').serialize(),
        success: function(res) {

            // Having error.
            if ( res.status == true )
            {
                //window.location = site_url.replace("https", "http");
                showSuccessDialog('Success', __(res.message));
            }
            else
            {
                $('#btn_confirm_resetpassword').attr('disabled', false);
                showAlertDialog('Fail', __(res.error));
                return false;
            }


            //setTimeout("location.href = site_url;",4000);
            //window.localtion = site_url.replace("https", "http");

        }
    });

    e.preventDefault();
});

$('#btn-popup-reset-success').on('click', function(){
    window.location = "/auth/login";
});

$('#btn_forgot_submit').on('click', function(e){
    $(this).attr('disabled', true);
    $.ajax({
        url: $('#formForgot').attr('action'),
        type: 'POST',
        data: $('#formForgot').serialize(),
        success: function(res) {

            // Having error.
            if ( res.status == true )
            {
                //window.location = site_url.replace("https", "http");
                $('#register_main_left').html('');
                $('#forget_success').css('display','block').html(res.message);
                //showSuccessDialog(__(res.message), __(res.message));
            }
            else
            {
                showAlertDialog('Fail', __(res.error));
                $('#btn_forgot_submit').attr('disabled', false);
                return false;
            }


            //setTimeout("location.href = site_url;",4000);
            //window.localtion = site_url.replace("https", "http");

        }
    });

    e.preventDefault();
});
