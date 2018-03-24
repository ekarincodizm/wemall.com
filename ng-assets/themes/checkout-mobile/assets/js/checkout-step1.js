$(document).ready(function() {
	var error_msg = $("#profile #inc-action-box .error_msg").text();
	if(error_msg != '' && error_msg.length !== 0)
	{
		$('#user1').trigger('click');
	}
	
    $("input[name='logintype']").on('click', function(e) {
        change_place_holder();
        $('#username').siblings(".active-alert-text").remove();
        $('#username').removeAttr("style");
        $('#password').siblings(".login-alert").remove();
    });
	
    if($("#form-checkout").length > 0){
        $("#form-checkout").validate({
            rules: {
                username: {
                    required: true,
                    email: {
                        depends: function(element){
                            if($('#user1').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    }
                },
                password: {
                    required: {
                        depends: function(element) {
                            if ($('#user1').is(':checked')){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    },
                    minlength: 4
                }
            },
            onfocusout: function(element){
				$(element).valid();	
				var field_var = $(element).attr("name");
                if(field_var == 'username')
                {
                    var field_value= $(element).val();
                    $.ajax({
                    	async: true,
                        url: site_url + 'ajax/checkout/set-customer-info',
                        type: "POST",
                        data: {
                            customer_email: field_value
                        },
						beforeSend:function(res){
							//$('#btnNext').attr("disabled", true);
                        },
                        success: function(res){
							//$("#btnNext").removeAttr("disabled");
                        }
                    });
                }
			},
            messages: {
                username: {
                    required: __('step1-enter-email'),
                    email: __('step1-enter-valid-email')
                },
                password: {
                    required: __('step1-enter-password'),
                    minlength: __('step1-enter-valid-password')
                }
            },
            errorPlacement: function(error, element) {
                $(element).siblings(".icon-success").remove();
                error.insertAfter(element);
            },
            submitHandler: function(form) {

                $('#btnNext').val(__("processing"));
                form.submit();
                    
                return false;
            },
            errorElement: 'div',
            errorClass: 'active-alert-text',
            highlight: function(element, errorClass) {
                $(element).siblings(".icon-success").remove();
                $(element).css("border", "2px solid #fe040d");
            },
            unhighlight: function(element, errorClass){
                var correctIcoURL = site_url+'themes/checkout/assets/images/success.png';
                $(element).css("border", "2px solid #87c80a");
                //$("<div class='left icon-success'><img src='"+correctIcoURL+"' width='14' height='14' /></div>").insertAfter($(element));
    			
            }
               
        });
    }
});

function change_place_holder()
{
	if($('#user1').is(':checked'))
	{
		$("#username").attr("placeholder", __("tel-placeholder-username"));
	}
	else
	{
		$("#username").attr("placeholder", __("email-placeholder-username"));
	}
	return false;
}