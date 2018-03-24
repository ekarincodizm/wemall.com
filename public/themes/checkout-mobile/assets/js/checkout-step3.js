$(function() {
    var select_credit_card = $("#select-credit-card").val();
    var attr_val = $('input[type=radio][name=payment_channel]:checked').val();
	var data_tab = $('#form-payment').attr('data-tab-active');
	
	var classMap = {
            atm: "atm",
            ccinstm: "install",
            ccw: "visa",
            ibank: "ibank",
            banktrans: "bank",
            cod: "cod",
            cs: "cservice"
        };
	
	if(data_tab != '')
	{
		var tabActive = data_tab;
		var key_arr = tabActive.toLowerCase();
		attr_val = classMap[key_arr];
	}
	
    switch (attr_val)
    {
        case "install" :
            $('#install').attr('checked', true).trigger('click');
            set_payment_info(attr_val);
            break;
        case "visa" :
            $('#credit-card').attr('checked', true).trigger('click');
            set_payment_info(attr_val);
            break;
		case "atm" :
            $('#atm').attr('checked', true).trigger('click');
            set_payment_info(attr_val);
            break;
		case "ibank" :
            $('#ibanking').attr('checked', true).trigger('click');
            set_payment_info(attr_val);
            break;
		case "bank" :
            $('#bank-counter').attr('checked', true).trigger('click');
            set_payment_info(attr_val);
            break;
		case "cod" :
            $('#cod').attr('checked', true).trigger('click');
            set_payment_info(attr_val);
            break;
		case "cservice" :
            $('#counter-service').attr('checked', true).trigger('click');
            set_payment_info(attr_val);
            break;
        default :
			var install_var = $('#install').val();
			if(install_var == 'install')
			{
				$('#install').attr('checked', true).trigger('click');
				set_payment_info('install');
			}
			else
			{
				$('#credit-card').attr('checked', true).trigger('click');
				set_payment_info('visa');
            }
			break;
    }
    if (select_credit_card === undefined)
    {
        $(".credit-card-content").show();
    }
    // Check Check radion Select And      
    // Check m.itruemart.com Event Change Redio
    $('input[type=radio][name=payment_channel]').change(function() {
        var p_channel = $(this).val();
        set_payment_info(p_channel);


    });

    function set_payment_info(p_channel) {
        switch (p_channel) {
            case 'visa':
                var pkey_channel = '155413837979192';
                break;
            case 'atm':
                var pkey_channel = '156513837979495';
                break;
            case 'ibank':
                var pkey_channel = '158913837979603';
                break;
            case 'bank':
                var pkey_channel = '152313837979681';
                break;
            case 'cservice':
                var pkey_channel = '153213837979857';
                break;
            case 'hservice':
                var pkey_channel = '155613837979771';
                break;
            case 'install':
                var pkey_channel = '156813837979402';
                
                break;
            default:
                var pkey_channel = '';
        }
        $.ajax({
            async: true,
            type: 'POST',
            url: '/ajax/checkout/set-payment-info',
            data: {
                payment_method: pkey_channel
            },
            beforeSend: function(data) {
                $('#step3-submit').attr("disabled", true);
            },
            success: function(data) {
                $("#step3-submit").removeAttr("disabled");
            }
        });
    }



//    $(document).on('click', '#add-invoice', function() {
//        if ($(this).is(':checked'))
//        {
//            $.post(
//                    '/ajax/checkout/convert-shipping-to-bill',
//                    {
//                    },
//                    function(data) {
//
//                    },
//                    'html'
//                    );
//        }
//        else
//        {
//            $.post(
//                    '/ajax/checkout/set-cart-info',
//                    {
//                        field: 'bill_same_shipping',
//                        val: 'N'
//                    },
//            function(data) {
//
//            },
//                    'html'
//                    );
//        }
//    });




//    if ($('.c-main').attr('data-tab-active') == "")
//    {
//        // -- save_payment_info -- //
//        var ctab2 = $(".c-main .c-tab-2 li.active").attr('class');
//        if (ctab2 == undefined)
//        {
//            var attr_val = 'visa';
//        }
//        else
//        {
//            var attr_val = ctab2.replace(" active", "");
//        }
//
//        save_payment_info(attr_val);
//    }
//    else
//    {
////        var tabActive = $('.c-main').attr('data-tab-active');
////        switch (tabActive.toLowerCase())
////        {
////            case "atm" :
////                $('.c-tab-2 ul li.atm h2 a').trigger('click');
////                break;
////
////            case "ccinstm" :
////                $('.c-tab-2 ul li.install h2 a').trigger('click');
////                break;
////
////            case "ccw" :
////                $('.c-tab-2 ul li.visa h2 a').trigger('click');
////                break;
////
////            case "ibank" :
////                $('.c-tab-2 ul li.ibank h2 a').trigger('click');
////                break;
////
////            case "banktrans" :
////                $('.c-tab-2 ul li.bank h2 a').trigger('click');
////                break;
////
////            case "cod" :
////                $('.c-tab-2 ul li.hservice h2 a').trigger('click');
////                break;
////
////            case "cs" :
////                $('.c-tab-2 ul li.cservice h2 a').trigger('click');
////                break;
////
////            default :
////                break;
////        }
//    }


    $(document).on('click', '.c-main .c-tab-2 li', function() {
        var str = $(this).attr('class');
        var attr_val = str.replace(" active", "");
        $(this).addClass('active');

        if (attr_val == 'hservice')
        {
            $('.cartlightbox-update-shipping-method').val('14456917914435').trigger('change');
        }
        else
        {
            last_payment = $('.last-payment').text();
            if (last_payment == 'hservice' || last_payment == 'COD')
            {
                $('.cartlightbox-update-shipping-method').val($('.cartlightbox-update-shipping-method option:first').val()).trigger('change');
            }
        }

        $('.last-payment').text(attr_val);

        set_payment_info(attr_val);


    });
    
    //force CCW Name filed to Capital Letter.
    $('#ccw-info-name').css('text-transform', 'uppercase');
    $('#ccw-info-name').keyup(function() {
        // store cursor positions
        var start = this.selectionStart;
        var end = this.selectionEnd;

        $(this).val($(this).val().toUpperCase());

        // move cursor positions back
        this.setSelectionRange(start, end);
    });

    jQuery.validator.addMethod("prefix", function(value, element, params) {
        //alert(params[0]);
        attr_val = check_payment();
        if (params[0] == 4 || params[0] == 5)
        {
            return true;
        }
        else
        {
            if (attr_val == 'visa')
            {
                return false;
            }
            else
            {
                return true;
            }
        }
    }, jQuery.validator.format(__('step3-credit-card-prefix')));
    
    // add rule for validate card name
    jQuery.validator.addMethod("validcardname", function(value, element) {
        return this.optional(element) || value.match('^[- A-Z_.,]+$');
    });

    if ($("#form-payment").length > 0) {
        $("#form-payment").validate({
            rules: {
                // Select CCW Card
                creditno: {
                    required: {
                        depends: function(element) {
                            attr_val = check_payment();
                            if ($('#select-credit-card').is(':checked') && (attr_val == 'visa')) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                // New CCW Card
                creditname: {
                    required: {
                        depends: function(element) {
                            attr_val = check_payment();
                            if (attr_val == 'visa') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    },
                    validcardname: true
                },
                creditnum: {
                    required: {
                        depends: function(element) {
                            attr_val = check_payment();
                            if (attr_val == 'visa') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    },
                    digits: true,
                    rangelength: [16, 16],
                    prefix: function(element) {
                        return $(element).val();
                    }
                },
                expiremonth: {
                    required: {
                        depends: function(element) {
                            attr_val = check_payment();
                            if (attr_val == 'visa') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                expireyear: {
                    required: {
                        depends: function(element) {
                            attr_val = check_payment();
                            if (attr_val == 'visa') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                ccv: {
                    required: {
                        depends: function(element) {
                            attr_val = check_payment();

                            if (attr_val == 'visa') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    },
                    digits: true,
                    rangelength: [3, 3]
                },
				payment_channel: {
					required: true
				}
            },
            messages: {
                creditno: {
                    required: __("step3-select-credit")
                },
                creditname: {
                    required: __("step3-enter-creditname"),
                    validcardname: __("step3-enter-valid-creditname")
                },
                creditnum: {
                    required: __("step3-enter-creditno"),
                    digits: __("step3-enter-digit-creditno"),
                    rangelength: __("step3-enter-range-length-16")
                },
                expiremonth: {
                    required: __("step3-select-day")
                },
                expireyear: {
                    required: __("step3-select-day")
                },
                ccv: {
                    required: __("step3-enter-cvv"),
                    digits: __("step3-enter-cvv-digit"),
                    rangelength: __("step3-enter-cvv-length-3")
                },
				payment_channel: {
					required: __("step3-select-payment-channel")
				}
            },
            errorPlacement: function(error, element) {
                $(element).siblings(".icon-success-2").remove();
                if ($(element).attr('name') != 'expiremonth' && $(element).attr('name') != 'expireyear' && $(element).attr('name') != 'ccv')
                {
                    error.insertAfter(element);
                } else if ($(element).attr('name') == 'ccv')
                {
                    error.insertAfter($('#ccv_input'));
                }
                else if ($(element).attr('id') == 'expire')
                {
                	error.insertAfter($('#expired_input'));
                }
                else
                {
                    if ($('#year').val() != '')
                    {
                        error.insertAfter($('#year'));
                    }
                }
            },
            submitHandler: function(form) {
                $('#step3-submit').attr("disabled", true);
                $('#step3-submit').val(__('processing'), true);
                /* var str = $('.c-main .c-tab-2 li.active').attr('class');
                 var attr_val = str.replace(" active", "");
                 
                 save_payment_info(attr_val); */
                form.submit();

                return false;
            },
            errorElement: 'div',
            errorClass: 'active-alert-text',
            highlight: function(element, errorClass) {
                $(element).siblings(".icon-success-2").remove();
                $(element).css("border", "2px solid #fe040d");
            },
            unhighlight: function(element, errorClass) {
                var correctIcoURL = site_url + 'themes/checkout/assets/images/ss_thank.png';
                $(element).css("border", "2px solid #87c80a");
                //$("<div class='left icon-success-2'><img src='" + correctIcoURL + "' width='14' height='14' /></div>").insertAfter($(element));
            },
            //--- on blur auto save to cart ---//
            onfocusout: function(element) {
                $(element).valid();
                elemId = $(element).attr('id');
                elemVal = $(element).val();

                if (elemId == "bill_name" ||
                        elemId == "bill_province_id" ||
                        elemId == "bill_city_id" ||
                        elemId == "bill_district_id" ||
                        elemId == "bill_postcode" ||
                        elemId == "bill_address"

                        )
                {

                    $.post(
                            '/ajax/checkout/set-bill-info',
                            {
                                bill_name: $('#bill_name').val(),
                                bill_province_id: $('#bill_province_id').val(),
                                bill_city_id: $('#bill_city_id').val(),
                                bill_district_id: $('#bill_district_id').val(),
                                bill_postcode: $('#bill_postcode').val(),
                                bill_address: $('#bill_address').val()
                            },
                    function(data) {

                    },
                            'html'
                            );
                }

                if (
                        elemId == "creditno")
                {
                    elemText = $('[name="creditno"] option:selected').text();
                    $.post(
                            '/ajax/checkout/set-bill-info',
                            {
                                card_token: elemVal,
                                card_label: elemText
                            },
                    function(data) {

                    },
                            'html'
                            );
                }

            },
            onclick: function(element) {
                elemId = $(element).attr('id');
                elemVal = $(element).val();

                if (
                        elemId == "select-credit-card" ||
                        elemId == "new-ccw")
                {
                    $.post(
                            '/ajax/checkout/set-bill-info',
                            {
                                is_new_ccw: elemVal
                            },
                    function(data) {

                    },
                            'html'
                            );
                }

                if (elemId == "save_ccw")
                {
                    var is_check = $(element).is(':checked');

                    if (is_check)
                    {
                        val = 'Y';
                    }
                    else
                    {
                        val = 'N';
                    }

                    $.post(
                            '/ajax/checkout/set-bill-info',
                            {
                                save_ccw: val
                            },
                    function(data) {

                    },
                            'html'
                            );
                }
            }
        });

        $('[name="savecredit"]').on("click", function() {
            var new_option = $('[name="creditno"] option').size();
            if (new_option >= 5)
            {
                $('#modal-save-credit').modal('show');
                $(this).attr('checked', false);
            }
        });
    }



});
function call_cod()
{
    $.ajax({
        async: true,
        type: 'GET',
        url: '/ajax/widget/payment-cod',
        success: function(data) {
            $(".c-tab-2 ul").append(data.menu);
            $(".c-info-in").prepend(data.content);
        }
    });
}
function check_payment()
{
    attr_val = $('input[type=radio][name=payment_channel]:checked').val();
    return attr_val;
}



