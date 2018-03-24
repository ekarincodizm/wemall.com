(function ($) {
    $.fn.step2form = function (options) {

        var that = this,
            _provinceName,
            _cities,
            _districts,
            _zipcodes;

        this.settings = $.extend(
            {
                submitBtn: ".button-buy",
                geolocation: Geolocation.Main
            },
            options);

        this.bindSubmitButton = function (ele) {
            $(this.settings.submitBtn).on("click", function () {
                if (!$(this).hasClass("disable")) {
                    ele.submit();
                }
            });
        };

        this.bindTelephoneInput = function (ele) {
            ele.find("#telephone").on("keydown", function (e) {

                if ((e.keyCode >= 48 && e.keyCode <= 57) ||
                    (e.keyCode >= 96 && e.keyCode <= 105) ||
                    (e.keyCode >= 37 && e.keyCode <= 40) ||
                    e.keyCode == 8 ||
                    e.keyCode == 9 ||
                    e.keyCode == 13) {
                    return true;
                }

                return false;
            });
        };

        this.bindProvinceInput = function () {
            $('#province-control').on("change", function () {
                $('#city-control').resetSelect(__('step2-select-city'));
                $('#district-control').resetSelect(__('step2-select-district'));
                $('#zip-code-control').resetSelect(__('step2-select-zipcode'));

                _provinceName = $('#province-control option:selected').text().trim();
                var isBKK = (_provinceName === 'กรุงเทพมหานคร');
                $('#city-label').text(isBKK ? __('step2-special-district') : __('step2-district'));
                $('#district-label').text(isBKK ? __('step2-special-subdistrict') : __('step2-subdistrict'));

                if ($(this).val()) {

                    $('#city-control').showLoading(__('step2-loading'));
                    _cities = that.settings.geolocation.getCities($(this).val());

                    if (_provinceName == "กรุงเทพมหานคร")
                    {
                        $('#city-control').loadSelect(_cities, __('step2-select-city-special'));
                        $('#district-control').resetSelect(__("step2-select-district-special"));
                    }
                    else
                    {
                        $('#city-control').loadSelect(_cities, __('step2-select-city'));
                        $('#district-control').resetSelect(__("step2-select-district"));
                    }
                }

            });
        };

        this.bindCityInput = function () {

            $('#city-control').on("change", function () {
                $('#district-control').resetSelect(__('step2-select-district'));
                $('#zip-code-control').resetSelect(__('step2-select-zipcode'));

                if ($(this).val()) {

                    $('#district-control').showLoading(__('step2-loading'));
                    _districts = that.settings.geolocation.getDistricts($(this).val());

                    if ($('#province-control option:selected').text().trim() == "กรุงเทพมหานคร")
                    {
                        $('#district-control').loadSelect(_districts, __("step2-select-district-special"));
                    }
                    else
                    {
                        $('#district-control').loadSelect(_districts, __("step2-select-district"));
                    }
                }
            });
        };

        this.bindDistrictInput = function () {

            $("#district-control").on("change", function(){
                $('#zip-code-control').resetSelect(__('step2-select-zipcode'));

                if ($(this).val()) {
                    $('#zip-code-control').showLoading(__('step2-loading'));

                    _zipcodes = that.settings.geolocation.getZipcode($(this).val());
                    $('#zip-code-control').loadSelect(_zipcodes, __('step2-select-zipcode'));
                }
            });

        };

        this.bindGlobalValidator = function (ele) {
            ele.validate({
                rules: {
                    name: {
                        required: true,
                        validname: true
                    },
                    phone_number: {
                        required: true,
                        digits: true,
                        rangelength: [9, 10],
                        validphone: true
                    },
                    province: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    district: {
                        required: true
                    },
                    zip_code: {
                        required: true,
                        digits: true
                    },
                    address: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    }

                },
                messages: {
                    name: {
                        required: __("step2-firstname-lastname-required"),
                        validname: __("step2-firstname-lastname-validname")
                    },
                    phone_number: {
                        required: __("step2-phone-number-required"),
                        digits: __("step2-phone-only-digit-required"),
                        rangelength: __("step2-phone-10digits-required"),
                        validphone: __("step2-phone-invalid")
                    },
                    province: {
                        required: __("step2-province-required")
                    },
                    city: {
                        required: __("step2-district-required")
                    },
                    district: {
                        required: __("step2-subdistrict-required")
                    },
                    zip_code: {
                        required: __("step2-zipcode-required"),
                        digits: __("step2-zipcode-onlydigit-required")
                    },
                    address: {
                        required: __("step2-address-required")
                    },
                    email: {
                        required: __('step2-email-required'),
                        email: __('step2-email-valid-email')
                    }
                },
                onfocusout: function (element) {

                    var elemId = $(element).attr('id');
                    var isValid = this.element("#" + elemId);

                    if (isValid) {

                        if (elemId == "name" ||
                            elemId == "telephone" ||
                            elemId == "province-control" ||
                            elemId == "city-control" ||
                            elemId == "district-control" ||
                            elemId == "zip-code-control" ||
                            elemId == "address" ||
                            elemId == "email"
                        ) {
                            $.ajax({
                                async: true,
                                url: UrlToLang('/ajax/checkout/set-customer-info'),
                                type: "POST",
                                data: {
                                    customer_name: $('#name').val(),
                                    customer_tel: $('#telephone').val(),
                                    customer_province_id: $('#province-control').val(),
                                    customer_city_id: $('#city-control').val(),
                                    customer_district_id: $('#district-control').val(),
                                    customer_postcode: $('#zip-code-control').val(),
                                    customer_address: $('#address').val(),
                                    customer_email: $('#email').val()
                                },
                                beforeSend: function (res) {
                                    //$(that.settings.submitBtn).addClass("disable");
                                },
                                success: function (res) {
                                    //$(that.settings.submitBtn).removeClass("disable");
                                }
                            });
                        }
                    }
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function (form) {

                    $('.button-buy .button').html('<span class="button-processing-green"></span>');
                    $('.button-buy .button').css({"text-align": "left"});
                    that.loopProcess();

                    $.ajax({
                        async: true,
                        url: UrlToLang('/ajax/checkout/set-customer-info'),
                        type: "POST",
                        data: {
                            customer_name: $('#name').val(),
                            customer_tel: $('#telephone').val(),
                            customer_province_id: $('#province-control').val(),
                            customer_city_id: $('#city-control').val(),
                            customer_district_id: $('#district-control').val(),
                            customer_postcode: $('#zip-code-control').val(),
                            customer_address: $('#address').val(),
                            customer_email: $('#email').val()
                        },
                        beforeSend: function (res) {
                            $(that.settings.submitBtn).attr("disabled", "disabled");
                        },
                        success: function (res) {
                            form.submit();
                        }
                    });

                    return false;
                },
                errorElement: 'div',
                errorClass: 'active-alert-text',
                highlight: function (element, errorClass) {
                    $(element).css("border-color", "#fe040d");
                },
                unhighlight: function (element, errorClass) {
                    $(element).css("border-color", "#87c80a");
                }

            });
        };

        this.loopProcess = function () {
            var terms = [__("proceeding-to-nextstep-0"), __("proceeding-to-nextstep-1"), __("proceeding-to-nextstep-2"), __("proceeding-to-nextstep-3")];
            var processButton = $('.button-buy .button span');
            var ct = processButton.data("term") || 0;

            processButton.data("term", ct == terms.length - 1 ? 0 : ct + 1).text(terms[ct]).show()
                .delay(250).show(200, that.loopProcess);
        };

        this.triggerAutoValidation = function(ele){
            _validate = false;

            if($("#telephone").val()){
                _validateElements = [
                    "name",
                    "email",
                    "city-control",
                    "district-control",
                    "zip-code-control",
                    "address"
                ];
            }else{
                _validateElements = [
                    "name",
                    "telephone",
                    "city-control",
                    "district-control",
                    "zip-code-control",
                    "address"
                ];
            }

            ele.find('input, select, textarea').each(function(){
                elemId = $(this).attr('id');
                if ($.inArray(elemId, _validateElements) != -1 && $(this).val() && !_validate)
                {
                    _validate = true;
                    return false;
                }
            });

            if(_validate){
                ele.valid();
            }
        };

        this.init = function (ele) {

            this.bindSubmitButton(ele);
            this.bindTelephoneInput(ele);
            this.bindProvinceInput();
            this.bindCityInput();
            this.bindDistrictInput();
            this.bindGlobalValidator(ele);
            this.triggerAutoValidation(ele);

        };

        return this.each(function () {
            var ele = $(this);
            that.init(ele);
        });
    };


})(jQuery);


$(document).ready(function () {
    $.validator.addMethod("validname", function (value, element) {
        return this.optional(element) || value.match('^[- a-zA-Z_ก-ํ.,()]+$');
    });

    $.validator.addMethod("validphone", function (value, element) {
        return this.optional(element) || value.match('^0');
    }, "invalid telephone number format");

    $("#add-address-frm").step2form();

    saveStage();
});