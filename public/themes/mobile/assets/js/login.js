$(document).ready(function(){
	var addSpan = '<span class="no-display icon-error">!</span>';

    $("#formLogin").validate({
		rules: {
			username: {
				required: true,
				digits: {
					depends: function(element){
						if($.isNumeric($('#username').val())) return true;
						else return false;
					}
				},
				email: {
					depends: function(element){
						if($.isNumeric($('#username').val())) return false;
						else return true;
					}
				}
			},
			password: {
				required: true,
				minlength: 4
			}
		},
		messages: {
			username: {
				required: addSpan+__('email-or-tureid-required'),
				digits: addSpan+__('email-or-tureid-required'),
				email: addSpan+__('email-or-trueid-wrong')
			},
			password: {
				required: addSpan+__('enter-password'),
				minlength: addSpan+__('password-length')
			}
		},
		errorPlacement: function(error, element) {
            $(element).siblings().remove();
            error.insertAfter(element);
            if($(element).attr('name') == 'username') {
                $(element).siblings().attr('data-id', 'email-error-message');
            }else{
                $(element).siblings().attr('data-id', 'password-error-message');
            }
        },
        onfocusout: function(element){
        	$(element).valid();	
        },
        errorClass: 'help-block error',
		highlight: function(element){
			$(element).siblings().remove();
			//$(element).siblings('p').addClass('help-block error').removeClass('no-display');
			$(element).parent().addClass('has-error').removeClass('success-input');
		},
		unhighlight: function(element){
			$(element).siblings().remove();
			//$(element).siblings('p').addClass('no-display').removeClass('help-block error');
			$(element).parent().removeClass('has-error').addClass('success-input');
		}


	});	
});

