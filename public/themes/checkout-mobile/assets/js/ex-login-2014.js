$(function() {
    ex.utilities();
    $('div#conditions_container').slimScroll({
        height: '478px',
        size: '30px',
        alwaysVisible: true
    });
    /**
     * Form register submmited.
     *
     */
    $(document).on('click','[name=btn_register]', function(e) {
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
                url: $form.attr('action'),
                type: 'POST',
                data: data,
                success: function(res) {
                    // Having error.
					
                    if ( ! res.status) {
                        //alert(__('Please enter username.'));
                        $(".all_error").show();
                        $error.text(__(''+res.error));

                        return false;
                    }
					
                    $(".all_error").hide();
                    //var data = res.data;

                    /*if(site_url == 'http://www.itruemart.com')
                    {
                        if(data.user_id != '' && data.user_id != undefined)
                        {
                            window._fbq.push(["track", "Register", {
                                member_id: data.user_id
                            }]);
                            // Conversion Event
                            window._fbq.push(['track', '6020486847532', {}]);
                        }
                    }*/

                    // redirect to somewhere.
                    // alert(data);
                    window.location.href = res.continue;
                    //setTimeout("location.href = res.continue;",4000);
                }
            });
        }else{
            $(".all_error").show();
            $error.text(__('Please accept your condition.'));
        }

        e.preventDefault();
    });
    
    /**
     * Register Channel.
     *
     */
	$("ul#register_tab li").on('click',function(){
		var register_channel = '';
		var aClass = $(this).attr('class');
		var rel = $(this).attr('rel');
		
		if(rel == 'register_email'){
			register_channel = 'email';
		}else if(rel == 'register_mobile'){
			register_channel = 'mobile';
		}else if(rel == 'register_truecard'){
			register_channel = 'truecard';
		}
		
		$('input[name="register_channel"]').val(register_channel);
	});
    
});

if (!('ex' in window)) {
    window.ex = {};
}

(function($) {
    ex.utilities = function() {
        /*$('.error_msg').each(function() {
            if ($(this).text().length === 0)
                $(this).hide();
        });*/
    	var first_type = $('[name="logintype"]:checked').val();		
    	var guest_url = $('#guest').attr('data-href');
    	var user_url = $('#user1').attr('data-href');
    	if(first_type == 'user')
    	{
    		$('#inc-panel-login').slideDown();
    		$('#form-checkout').attr('action', ''+user_url);
    	}
        $('[name="logintype"]').change(function()
    	{
            var type = $(this).val();
    		if(type == 'guest')
    		{   
                        $("#step1-username").attr("placeholder", __("email-placeholder-username"));
    			$('#form-checkout').attr('action', ''+guest_url);
    		}
    		else if(type == 'user')
    		{
                        $("#step1-username").attr("placeholder", __("user-placeholder-username"));
    			$('#form-checkout').attr('action', ''+user_url);
    		}
    	});
        
        $('#inc-regist-member').on('click',function(){
        	//$('[name="continue"]').val('');
        });
        
    	$('ul#register_tab li').on('click',function(){
	    	var tabs_regis = $(this).attr('rel');
	    	if(tabs_regis == 'register_email'){
	    		$('.error_msg').html('');
	    		$('#conditions').show();
	    		$('[name="accept"]').attr('id','email_accept');
				$('div#inc-action-box .m_regis').removeAttr("onclick").attr('name','btn_register');
	    	}else{
	    		$('.error_msg').html('');
	    		$('#conditions').hide();
	    		$('[name="accept"]').attr('id','mobile_accept');
	    		$('div#inc-action-box .m_regis').removeAttr("name").attr('onclick','javascript:registerValidateOtp(document.getElementById(\'mobile_username\'), document.getElementById(\'mobile_otp_password\')); return false;');
	    	}
		    	
	    });
        
        $('#inc-panel-login-type input:radio[name="logintype"]:first').attr('checked', true);
        $('#inc-panel-login-type input[type="radio"]').on('click', function() {
            if ($(this).is('#user1')) {
               // $('#inc-panel-login').slideDown();
                $('#profile_detail').find('p:eq(1)').slideDown(function(){
	                $('#forgetpassword_helper').show();
                });
            } else {
                //$('#inc-panel-login').slideUp();
                $('#forgetpassword_helper').hide();
            	$('#profile_detail').find('p:eq(1)').slideUp();
            }
        });
        $('#inc-regist-member').on('click', function() {
            $('#inc-panel-register').slideDown('fast', function() {
                $('#inc-panel-login-cont').slideUp('fast');
                $('#inc-action-prev').show();
            });

            $(this).css({textDecoration: 'none'});
        });

        $('#inc-action-prev').on('click', function() {
            $('#inc-panel-register').slideUp('fast', function() {
                $('#inc-panel-login-cont').slideDown('fast');
                $('#inc-action-prev').hide();
            });
            $('#inc-regist-member').css({textDecoration: 'underline'});
        });
    };

    var getParameterByName = function(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    };
})(jQuery);

/**
 * Check Number.
 *
 * @return void
 */
function check_number() 
{
	e_k=event.keyCode
	//if (((e_k < 48) || (e_k > 57)) && e_k != 46 ) {
	if (e_k != 13 && (e_k < 48) || (e_k > 57)) {
		event.returnValue = false;
		// alert("ต้องเป็นตัวเลขเท่านั้น... \nกรุณาตรวจสอบข้อมูลของท่านอีกครั้ง...");
		return false;
	}
}