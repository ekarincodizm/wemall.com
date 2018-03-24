$(function() {

    /**
     * Form register submmited.
     *
     * @return void
     */
    $('[name=btn_register]').on('click', function(e) {

        $form  = $('form#formRegister');
        //$error = $('#register_error_msg');
        $error = $('.all_register_error_msg');

        // Clear error message.
        $(".all_error").hide();
        $error.text('');

        // Channel to register.
        var type = $('#register_channel').val();

        var data = $form.serialize();
        var canSubmit = false;
        canSubmit = (type == 'email' && $('#email_accept').is(':checked')) || (type=="mobile" && $('#mobile_accept').is(':checked'));
       
        if (canSubmit) {
            $.ajax({
                url: $form.attr('url'),
                type: 'POST',
                data: data,
                success: function(res) {
                    //alert('test');
                    // Having error.
					
                    if ( ! res.status) {
                        //alert(__('Please enter username.'));
                        $(".all_error").show();
                        $error.text(__(''+res.error));

                        return false;
                    }
					
                    $(".all_error").hide();
                    var data = res.data;

                    // redirect to somewhere.
                    // alert(data);
                    window.location.href = res.continue;
                }
            });
        }else{
//            $('#error').show();
//            $error.text(__('Please accept your condition.'));
            $(".all_error").show();
            $error.text(__('Please accept your condition.'));
        }

        e.preventDefault();
    });

/**
     * Policy agreement.
     *
     * @return void
     */
/*  $('#accept').on('click', function() {
        if ($('#accept').is(':checked')) {
            $('[name=btn_register]').css('display', 'block');
        }
        else {
            $('[name=btn_register]').css('display', 'none');
        }
    }); */

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