$(document).ready(function () {

    $(document).on('click', '.delete_inventory', function (event) {
        var inventory_id = $(this).data("inventory-id");
        var cartDeleteUrl = '/ajax/checkout/remove-item';
        if (LANG != 'th') {
            cartDeleteUrl = "/" + LANG + cartDeleteUrl;
        }
        $.ajax({
            type: 'POST',
            url: cartDeleteUrl,
            data: {
                inventory_id: inventory_id
            },
            success: function (response) {
                if (response.code == 200) {
                    checkoutData = response.data;
                    location.reload();
                } else {
                    alert(__(response.message));
                    checkoutData = null;
                }
            }
        });
    });

    $(".input-sm").focusout(function (e) {
        var qty = $(this).val();
        var inventory_id = $(this).data("inventory-id");
        var data = {};
        data[inventory_id] = qty;
        var checkoutData = {};
        var cartUpdateItemUrl = '/ajax/checkout/update-item';
        if (LANG != 'th') {
            cartUpdateItemUrl = "/" + LANG + cartUpdateItemUrl;
        }

        var can_update = false;
        if (qty) {
            if (qty.length !== 0 && qty != '' && qty != 0) {
                can_update = true;
            }
        }

        if (can_update == true) {
            $.ajax({
                type: 'POST',
                url: cartUpdateItemUrl,
                data: {
                    items: data
                },
                success: function (response) {
                    if (response.code == 200) {
                        checkoutData = response.data;
                        //                        $.each(checkoutData.shipments, function(key, shipment) {
                        //                            items_count = shipment.items_count;
                        //                            $("#shipment_count_" + shipment.shop_id).html(items_count);
                        //                            $.each(shipment.items, function(key, item) {
                        //                                if (inventory_id == item.inventory_id)
                        //                                {
                        //                                    total = (item.total_price * 1) + (item.total_discount * 1);
                        //                                    $("#total_inventory_id_" + item.inventory_id).html(total);
                        //                                }
                        //                            });
                        //                        });
                        location.reload();
                    } else {
                        alert(__(response.message));
                        checkoutData = null;
                    }
                }
            });
        }
        else {
            alert('จำนวนไม่ถูกต้อง');
        }

    });
    $(document).on('change', '#selected-ship-addr', function (event) {
        event.preventDefault();

        $('#province-control').clearError();
        $('#district-control').clearError();
        $('#sub-district-control').clearError();
        $('#zip-code-control').clearError();

        if ($(this).val() == '') {
            _clearAddressLightbox();

            $('#hidden_address_id').val('');
            $('#name').val('');
            $('#telephone').val('');
            $('#address').val('');
            $('#province-control').val('');
            $('#district-control').resetSelect(__('step2-select-city'));
            $('#sub-district-control').resetSelect(__('step2-select-district'));
            $('#zip-code-control').resetSelect(__('step2-select-zipcode'));

            $('#fill-address-form').slideDown(400, function () {
                var pos = $('#fill-address-form').offset();
                var $html = $('html, body');
                $html.animate({
                    scrollTop: pos.top
                }, '500', 'swing');
            });

            $('#title-shipping-address').html(__('step2-input-shipping-address'));
            $('#btnSave').val(__('step2-save-this-address'));

            //$('#add-address-frm').valid();
            $('#province-control').clearError();
            $('#district-control').clearError();
            $('#sub-district-control').clearError();
            $('#zip-code-control').clearError();
            $('#add-address-frm').valid();


            return false;
        } else {
            $('#province-control').disabled();
            //$('#province-control').showLoading('');
            //('#province-control').showLoading('Loading...');
            $('#district-control').disabled();
            $('#district-control').showLoading(__('step2-loading'));

            $('#sub-district-control').disabled();
            $('#sub-district-control').showLoading(__('step2-loading'));

            $('#zip-code-control').disabled();
            $('#zip-code-control').showLoading(__('step2-loading'));

            $('#name').disabled();
            $('#telephone').disabled();
            $('#address').disabled();
            $('#email').disabled();
            $('#btnSave').val(__('Continue'));

            $('#province-control').clearError();
            $('#district-control').clearError();
            $('#sub-district-control').clearError();
            $('#zip-code-control').clearError();

            $.getJSON(
                $(this).attr('data-edit-href') + '?id=' + $(this).val(),
                {},
                function (data) {

                    if (data != undefined && data != NaN && data != "" && data != null) {

                        $('#hidden_address_id').val(data.id);

                        $('#name').enabled();
                        $('#telephone').enabled();
                        $('#province-control').enabled();
                        $('#district-control').enabled();
                        $('#sub-district-control').enabled();
                        $('#address').enabled();
                        $('#zip-code-control').enabled();
                        $('#email').enabled();

                        $('#name').val(data.name);
                        $('#telephone').val(data.phone);
                        $('#email').val(data.email);
                        //

                        $('#province-control').val(data.province_id);
                        $('#address').val(data.address);
                        $('#zip-code-control').val(data.postcode);

                        if (data.province_id == 1) {
                            $('#district-name').html(__('step2-special-district'));
                            $('#sub-district-name').html(__('step2-special-subdistrict'));
                        }
                        else {
                            $('#district-name').html(__('step2-district'));
                            $('#sub-district-name').html(__('step2-subdistrict'));
                        }

//                            _renderDistrictDropdown(data);
//                            $('#district-control').val(data.city_id);
                        $('#district-control').loadSelect(data.cities, __("step2-select-city"), data.city_id);

//                            _renderSubDistrictDropdown(data);
//                            $('#sub-district-control').val(data.district_id);
                        $('#sub-district-control').loadSelect(data.districts, __("step2-select-district"), data.district_id);

//                            _renderZipcodeDropdown(data);
//                            $('#zip-code-control').val(data.postcode);
                        $('#zip-code-control').loadSelect(data.zip_code, __("step2-select-zipcode"), data.postcode);

                        $('#add-address-frm').valid();


                        $.ajax({
                            async: true,
                            url: '/ajax/checkout/set-customer-info',
                            type: "POST",
                            data: {
                                customer_name: $('#name').val(),
                                customer_tel: $('#telephone').val(),
                                customer_province_id: $('#province-control').val(),
                                customer_city_id: $('#district-control').val(),
                                customer_district_id: $('#sub-district-control').val(),
                                customer_postcode: $('#zip-code-control').val(),
                                customer_address: $('#address').val(),
                                customer_email: $('#email').val()
                            },
                            beforeSend: function (res) {
                                $('#btnSave').attr("disabled", true);
                            },
                            success: function (res) {
                                $("#btnSave").removeAttr("disabled");
                            }
                        });

                    }
                }
            );
        }

    });

    // [B] Change province dropdown
    $('#province-control').change(function () {

        $('#district-control').resetSelect(__('step2-select-city'));
        $('#sub-district-control').resetSelect(__('step2-select-district'));
        $('#zip-code-control').resetSelect(__('step2-select-zipcode'));

        var provinceName = $('#province-control :selected').text();
        //provinceName = $('#province-control :selected').text();
        var isBKK = (provinceName === 'กรุงเทพมหานคร');
        $('#district-name').text(isBKK ? __('step2-special-district') : __('step2-district'));
        $('#sub-district-name').text(isBKK ? __('step2-special-subdistrict') : __('step2-subdistrict'));

        if ($(this).val() != "") {
            idx = $(this).index("select.form-control");
            $("select.form-control:gt(" + idx + ")").disabled();
            //$("#district-control").disabled();
            $('#district-control').showLoading(__('step2-loading'));
            $.post(
                $(this).attr('data-url'),
                {
                    province_id: $(this).val(),
                    mode: 'province'
                },
                function (data) {
                    $("select.form-control").enabled();
                    if (data != null && data != NaN && data != "" && data != undefined) {
                        var jsonDecode = $.parseJSON(data);
                        if ($('#province-control :selected').text() == "กรุงเทพมหานคร") {
                            $('#district-control').loadSelect(jsonDecode, __('step2-select-city-special'));
                            $('#sub-district-control').resetSelect(__("step2-select-district-special"));
                        }
                        else {
                            $('#district-control').loadSelect(jsonDecode, __('step2-select-city'));
                            $('#sub-district-control').resetSelect(__("step2-select-district"));
                        }
                    }
                },
                'html'
            );
        }
        else {

        }

    });
    // [E] End province change dropdown

    // [B] City (district) change dropdown

    $('#district-control').change(function () {
        $('#sub-district-control').resetSelect(__('step2-select-district'));
        $('#zip-code-control').resetSelect(__('step2-select-zipcode'));
        if ($(this).val() != "") {
            idx = $(this).index("select.form-control");
            $("select.form-control:gt(" + idx + ")").disabled();
            $('#sub-district-control').showLoading(__('step2-loading'));
            $.post(
                $(this).attr('data-url'),
                {
                    city_id: $(this).val(),
                    mode: 'city'
                },
                function (data) {
                    if (data != null && data != NaN && data != "" && data != undefined) {
                        $("select.form-control").enabled();
                        var jsonDecode = $.parseJSON(data);
                        if ($('#province-control :selected').text() == "กรุงเทพมหานคร") {
                            $('#sub-district-control').loadSelect(jsonDecode, __("step2-select-district-special"));
                        }
                        else {
                            $('#sub-district-control').loadSelect(jsonDecode, __("step2-select-district"));
                        }
                        //$('#sub-district-control').loadSelect(jsonDecode, __('step2-select-district'));
                    }
                },
                'html'
            );
        }
        else {
            $('#sub-district-control').resetSelect(__('step2-select-district'));
            $('#zip-code-control').resetSelect(__('step2-select-zipcode'));
        }
    });
    // [E] City (district) change dropdown

    // [B] District (Sub-District) change dropdown
    $('#sub-district-control').change(function () {
        $('#zip-code-control').resetSelect(__('step2-select-zipcode'));
        if ($(this).val() != "") {
            idx = $(this).index("select.form-control");
            $("select.form-control:gt(" + idx + ")").disabled();
            $('#zip-code-control').showLoading(__('step2-loading'));
            $.post(
                $(this).attr('data-url'),
                {
                    district_id: $(this).val(),
                    mode: 'district'
                },
                function (data) {
                    $('select.form-control').enabled();
                    if (data != null && data != NaN && data != "" && data != undefined) {
                        var jsonDecode = $.parseJSON(data);
                        $('#zip-code-control').loadSelect(jsonDecode, __('step2-select-zipcode'));


                    }
                },
                'html'
            );

            // [B] Check shipping
            $.post(
                '/checkout/check-shipping',
                {},
                function (data) {
                    if (data != NaN && data != "" && data != null && data != undefined) {
                        var jsonDecode = $.parseJSON(data)
                        if (jsonDecode.shipments == null) {
                            $('.no-product-list .right .clr-5').html('<strong style="color:#FF0000;">' + __("cart-cannot-ship") + '</strong>');

                            $('#btnSave').css('display', 'none');
                        }
                        else {
                            $('.no-product-list .right .clr-5').html(__("cart-free"));
                            $('#btnSave').css('display', 'inline');

                            //$('.no-product-list .right .clr-5').html(jsonDecode.shipments.name + ' (' + jsonDecode.shipments.description + ') ' + __("cart-delivery-fare") + jsonDecode.shipments.fee + __("cart-baht-lbl"));
                        }

                    }

                },
                'html'
            );
            // [E] check shipping


        }
        else {
            $('#zip-code-control').resetSelect(__('step2-select-zipcode'));
        }
    });

    //[E] District (Sub-District) changedropdown.
    jQuery.validator.addMethod("validname", function(value, element) {
        return this.optional(element) || value.match('^[- a-zA-Z_ก-ํ.,]+$');
    });

    // rule to validate telephone number
    jQuery.validator.addMethod("validphone", function (value, element) {
        return this.optional(element) || value.match('^0');
    }, "invalid telephone number format");

    $("#add-address-frm").validate({
        rules: {
            name: {
                required: true,
                validname: true
            },
            phone_number: {
                required: true,
                digits: true,
                rangelength: [11, 11],
                validphone: true
            },
            province: {
                required: true
            },
            district: {
                required: true
            },
            subdistrict: {
                required: true
            },
            zip_code: {
                //required: true,
                digits: true,
                rangelength: [4, 4]
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
            district: {
                required: __("step2-district-required")
            },
            subdistrict: {
                required: __("step2-subdistrict-required")
            },
            zip_code: {
                //required: __("step2-zipcode-required"),
                digits: __("step2-zipcode-onlydigit-required"),
                rangelength: __("step2-zipcode-4digits-required")
            },
            address: {
                required: __("step2-address-required")
            },
            email: {
                required: __('step2-email-required'),
                email: __('step2-email-valid-email')
            }
        },
        //--- on blur auto save to cart ---//
        onfocusout: function (element) {

            var elemId = $(element).attr('id');
            var isValid = this.element("#"+elemId);

            if(isValid) {

                if (elemId == "name" ||
                    elemId == "telephone" ||
                    elemId == "province-control" ||
                    elemId == "district-control" ||
                    elemId == "sub-district-control" ||
                    elemId == "zip-code-control" ||
                    elemId == "address" ||
                    elemId == "email"
                ) {
                    $.ajax({
                        async: true,
                        url: '/ajax/checkout/set-customer-info',
                        type: "POST",
                        data: {
                            customer_name: $('#name').val(),
                            customer_tel: $('#telephone').val(),
                            customer_province_id: $('#province-control').val(),
                            customer_city_id: $('#district-control').val(),
                            customer_district_id: $('#sub-district-control').val(),
                            customer_postcode: $('#zip-code-control').val(),
                            customer_address: $('#address').val(),
                            customer_email: $('#email').val()
                        },
                        beforeSend: function (res) {
                            $('#btnSave').attr("disabled", true);
                        },
                        success: function (res) {
                            $("#btnSave").removeAttr("disabled");
                        }
                    });
                }
            }
        },
        onkeyup: function (element, event) {
            elementId = $(element).attr('id');

            if (elementId === "telephone") {
                if (isKeyCodeForReplacing(event.keyCode)) {
                    text = $(element).val();
                    caret = $(element).getCursorPosition();
                    text = text.replace(/[- a-zA-Z_ก-ํ.,]+/, "");
                    $(element).val(text);
                    setCaretPosition('telephone', caret);
                }
            }
        },
        errorPlacement: function (error, element) {
            elemId = $(element).attr('id');
            if (elemId == 'district-control' || elemId == 'sub-district-control' || elemId == 'zip-code-control') {
                if ($(document).find('#' + elemId + ' option').length <= 1) {
                    $(element).removeAttr("style");
                    $(element).siblings(".active-alert-text").remove();
                }
                else {
                    error.insertAfter(element);
                }
            }
            else {
                error.insertAfter(element);
            }
            $(element).siblings(".icon-success").remove();
        },
        submitHandler: function (form) {
            //--- Save to cart ---//
            $('#btnSave').val(__("processing"));
            $.ajax({
                async: true,
                url: '/ajax/checkout/set-customer-info',
                type: "POST",
                data: {
                    customer_name: $('#name').val(),
                    customer_tel: $('#telephone').val(),
                    customer_province_id: $('#province-control').val(),
                    customer_city_id: $('#district-control').val(),
                    customer_district_id: $('#sub-district-control').val(),
                    customer_postcode: $('#zip-code-control').val(),
                    customer_address: $('#address').val(),
                    customer_email: $('#email').val()
                },
                beforeSend: function (res) {
                    $('#btnSave').attr("disabled", true);
                },
                success: function (res) {
                    if ($('#address_list_container').length == 0) {
                        //$('#add-address-frm').submit();
                        form.submit();
                    }
                }
            });

            if ($('#address_list_container').length == 0) {
                return false;
            }

            //--- Is Member ---//
            //--- Save data to master table customer address ---//

            if ($('#address_list_container').length > 0) {
                $.post(
                    '/ajax/customers/save-ship-addr',
                    {
                        address_id: $('#hidden_address_id').val(),
                        name: $('#name').val(),
                        phone: $('#telephone').val(),
                        province_id: $('#province-control').val(),
                        city_id: $('#district-control').val(),
                        district_id: $('#sub-district-control').val(),
                        postcode: $('#zip-code-control').val(),
                        address: $('#address').val(),
                        email: $('#email').val()
                    },
                    function (data) {
                        var jsonDecode = $.parseJSON(data);

                        if (jsonDecode.code == 200) {
                            //in case of saving new address
                            if(jsonDecode.data.address_id != undefined){
                                $("#hidden_address_id").val(jsonDecode.data.address_id);
                            }

                            var select_href = $('#address_list_container').attr('data-href');
                            $.post(
                                select_href,
                                {
                                    id: $('#hidden_address_id').val()
                                },
                                function (data) {
                                    if (data != null && data != undefined && data != NaN && data != "") {
                                        jsonDecode = $.parseJSON(data);
                                        if (jsonDecode.code == 200) {
                                            window.location.href = jsonDecode.return_step;
                                        }
                                    }
                                },
                                'html'
                            );

                        }


                    },
                    'html'
                );
            }

            return false;
        },
        errorElement: 'div',
        errorClass: 'active-alert-text',
        highlight: function (element, errorClass) {
            $(element).siblings(".icon-success").remove();
            $(element).css("border", "2px solid #fe040d");
        },
        unhighlight: function (element, errorClass) {
            var correctIcoURL = site_url + 'themes/checkout/assets/images/ss_thank.png';
            $(element).css("border", "2px solid #87c80a");
            //$("<div class='left icon-success'><img src='" + correctIcoURL + "' width='14' height='14' /></div>").insertAfter($(element));
        }

    });
    if ($("#selected-ship-addr").find('option').length > 1) {
        if (localStorage.getItem('addr') == null || localStorage.getItem('addr').length == 0) {
            $("#selected-ship-addr").find('option:eq(1)').attr('selected', 'selected');
        } else {
            $('#selected-ship-addr option').each(function () {
                if ($(this).attr('value') == localStorage.getItem('addr')) {
                    $(this).attr('selected', 'selected');
                }
            });
        }
        $('#hidden_address_id').val($("#selected-ship-addr").find(":selected").attr('value'));
        $('#selected-ship-addr').trigger('change');
    }
});


function _renderAddressBlock(data) {

    if (data.mode == 'insert') {
        var template = _.template(addressBlockTemplate);
        var activeAddress = $(template(data));
        $("#address_list_container > div:not(.add-addres, .clear)").removeClass("address-box-active").addClass("address-box");
        $("#address_list_container > div:not(.add-addres, .clear) p input").removeClass("form-bot-address-active").addClass("form-bot-address");

        $("#address_list_container").prepend(activeAddress);
        activeAddress.fadeIn();

        $('#fill-address-form').slideUp(400, function () {
            var $html = $('html, body');
            $html.animate({
                scrollTop: 0
            }, '500', 'swing');
        });
    }
    else {
        var template = _.template(addrUpdateTemplate);
        var activeAddress = $(template(data));

        $('div[data-id="' + data.address_id + '"]').html(activeAddress);
    }

    return false;
}

function _clearAddressLightbox() {
    $("#wrapper_address input[type='text'], #wrapper_address textarea").val("");
    $("#wrapper_address select").val($("#wrapper_address select option:first").val());
}

function _renderDistrictDropdown(data) {
    var optionTemplate = _.template("<% $.each(lists, function(key, value){  %> <option value='<%=value.id%>'><%=value.name%></option>\n <%  }); %>");

    if (data.cities != undefined) {
        var citiesList = optionTemplate({lists: data.cities});
        $("#district-control").html(citiesList);
    }
}

function _renderSubDistrictDropdown(data) {
    var optionTemplate = _.template("<% $.each(lists, function(key, value){  %> <option value='<%=value.id%>'><%=value.name%></option>\n <%  }); %>");
    if (data.districts != undefined) {
        var districtsList = optionTemplate({lists: data.districts});
        $("#sub-district-control").html(districtsList);
    }
}

function _renderZipcodeDropdown(data) {
    var optionTemplate = _.template("<% $.each(lists, function(key, value){  %> <option value='<%=value.zipcode%>'><%=value.zipcode%></option>\n <%  }); %>");

    if (data.zip_code != undefined) {
        var zipcodeList = optionTemplate({lists: data.zip_code});
        $("#zip-code-control").html(zipcodeList);
    }
}
function AllowedNumber(e) {
    var allowedNum = true;
    var k = 0;
    if (window.event) {
        k = e.keyCode;
    } else if (e.which) {
        k = e.which;
    }

    if ((k >= 48) && (k <= 57) || (k == 8) || (k == 46) || (k == 0)) {
        return allowedNum;
    } else {
        return false;
    }
}


function isKeyCodeForReplacing(keyCode) {
    if (keyCode !== 8 && keyCode !== 37 && keyCode !== 38 && keyCode !== 39 && keyCode !== 40) {
        return true;
    }
    return false;
}
new function ($) {
    $.fn.getCursorPosition = function () {
        var pos = 0;
        var el = $(this).get(0);
        // IE Support
        if (document.selection) {
            el.focus();
            var Sel = document.selection.createRange();
            var SelLength = document.selection.createRange().text.length;
            Sel.moveStart('character', -el.value.length);
            pos = Sel.text.length - SelLength;
        }
        // Firefox support
        else if (el.selectionStart || el.selectionStart == '0')
            pos = el.selectionStart;
        return pos;
    }
}(jQuery);

function setCaretPosition(elemId, caretPos) {
    var elem = document.getElementById(elemId);

    if (elem != null) {
        if (elem.createTextRange) {
            var range = elem.createTextRange();
            range.move('character', caretPos);
            range.select();
        }
        else {
            if (elem.selectionStart) {
                elem.focus();
                elem.setSelectionRange(caretPos, caretPos);
            }
            else
                elem.focus();
        }
    }
}