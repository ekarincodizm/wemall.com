$(document).ready(function(){

    initStep2();


    if( $("#sub-district-control").val() != undefined && $("#sub-district-control").val() != "" ){
        checkShippingAvailable();
    }

    $(document).on('click', '.delete-ship-addr', function(event){
        event.preventDefault();

        $('#modalConfirm').modal('show');
        $('#url-delete').val($(this).attr('data-href'));
    });

    $(document).on('click', '.edit-ship-addr', function(event){
        event.preventDefault();

        $('#fill-address-form').slideDown(400, function() {
                    var pos = $('#fill-address-form').offset();
                    var $html = $('html, body');
                    $html.animate({
                        scrollTop: pos.top
                    }, '500', 'swing', function() {
                        $('input:eq(0)', '#fill-address-form').focus();
                    });
                });

        $('#province-control').disabled();

        $('#district-control').disabled();
        $('#district-control').showLoading(__('step2-loading'));

        $('#sub-district-control').disabled();
        $('#sub-district-control').showLoading(__('step2-loading'));

        //$('#zip-code-control').disabled();
        //$('#zip-code-control').showLoading(__('step2-loading'));

        $('#name').disabled();
        $('#telephone').disabled();
        $('#email').disabled();
        $('#address').disabled();

        $('#title-shipping-address').html(__('step2-edit-shipping-address'));
        $('#btnSave').val(__('step2-save-this-address'));

        $.getJSON(
            $(this).attr('data-href'),
            {

            },
            function (data){

                if (data != undefined && data != NaN && data != "" && data != null)
                {

                    $('#hidden_address_id').val(data.id);

                    $('#name').enabled();
                    $('#telephone').enabled();
                    $('#email').enabled();
                    $('#province-control').enabled();
                    $('#district-control').enabled();
                    $('#sub-district-control').enabled();
                    $('#address').enabled();
                    $('#zip-code-control').enabled();

                    $('#name').val(data.name);
                    $('#telephone').val(data.phone);
                    var email = "";
                    var patt = new RegExp("\@truelife.com$");
                    if(! patt.test(data.email) ){
                        email = data.email;
                    }
                    $('#email').val(email);

                    $('#province-control').val(data.province_id);
                    $('#address').val(data.address);
                    $('#zip-code-control').val(data.postcode);

                    if (data.province_id == 1)
                    {
                        $('#district-name').html(__('step2-special-district'));
                        $('#sub-district-name').html(__('step2-special-subdistrict'));
                    }
                    else
                    {
                        $('#district-name').html(__('step2-district'));
                        $('#sub-district-name').html(__('step2-subdistrict'));
                    }

					$('#district-control').loadSelect(data.cities, __("step2-select-city"), data.city_id);

					$('#sub-district-control').loadSelect(data.districts, __("step2-select-district"), data.district_id);

					//$('#zip-code-control').loadSelect(data.zip_code, __("step2-select-zipcode"), data.postcode);

					$('#add-address-frm').valid();

                }
            }

        );
    });


    $(document).on('click', '#btnConfirmDelete', function(event){
        event.preventDefault();
        $.post(
            $('#url-delete').val(),
            {

            },
            function (data){
                if (data != null && data != undefined && data != NaN && data != "")
                {
                    jsonDecode = $.parseJSON(data);
                    if (jsonDecode.code == 200)
                    {
                        //--- Remove DOM address that deleted ---//
                        $('div[data-id="'+jsonDecode.return_id+'"]').remove();


                        $('#modalMessage').modal('show');
                        $('#modalMessage .modal-body').html(jsonDecode.message);

                        //--- Close Modal ---//
                        $('#btnCancel').trigger('click');

                        $('#address_list_container > div:first').removeClass('address-box').addClass('address-box-active');
                    }
                }
            },
            'html'
        );
    });
});



function initStep2(){
    var addressBlockTemplate = "<div data-id='<%= address_id %>' class='address-box-active' style='display:none;'> \
            <div class='address-inbox'> \
                <p style='padding-top:5px;'></p> \
                <h2><%= name %></h2> \
                <p></p> \
                <p style='padding:10px 0px 10px 0px;'> \
                    <%= address %> <%= __('step2-special-district') %><%= subdistrict %> <%= __('step2-special-subdistrict') %><%= district %> <%= province %> <br/> \
                    <%= zip_code %><br/> \
                    <%= __('step2-phone') %> <%= phone_number %> \
                </p> \
                <p> \
                    <input class='form-bot-address-active' name='' type='button' value='<%= __('step2-nextstep-btn') %>'> \
                </p> \
                <div class='ad-dress'> \
                    <div class='address-delete left'><a href='javascript:;' class='delete-ship-addr' data-href='<%= deleteUrl %>'><%= __('step2-delete-btn') %></a></div> \
                    <div class='address-edit left'> <a href='javascript:;' class='edit-ship-addr' data-href='<%= editUrl %>'><%= __('step2-edit-btn') %></a></div> \
                    <div class='clear'></div> \
                </div> \
            </div> \
        </div>";

    var addrUpdateTemplate = "<div class='address-inbox'> \
                <p style='padding-top:5px;'></p> \
                <h2><%= name %></h2> \
                <p></p> \
                <p style='padding:10px 0px 10px 0px;'> \
                    <%= address %> <%= __('step2-special-district') %><%= subdistrict %> <%= __('step2-special-subdistrict') %><%= district %> <%= province %> <br/> \
                    <%= zip_code %><br/> \
                    <%= __('step2-phone') %> <%= phone_number %> \
                </p> \
                <p> \
                    <input class='form-bot-address-active' name='' type='button' value='<%= __('step2-nextstep-btn') %>'> \
                </p> \
                <div class='ad-dress'> \
                    <div class='address-delete left'><a href='javascript:;' class='delete-ship-addr' data-href='<%= deleteUrl %>'><%= __('step2-delete-btn') %></a></div> \
                    <div class='address-edit left'> <a href='javascript:;' class='edit-ship-addr' data-href='<%= editUrl %>'><%= __('step2-edit-btn') %></a></div> \
                    <div class='clear'></div> \
                </div> \
            </div>";


    if($("#fill-address-form.iamuser").length == 0){
        $("#fill-address-form").show();
    }

    if($("#add-address-btn").length > 0){
        $("#add-address-btn").click(function(e){
            e.preventDefault();
            _clearAddressLightbox();


			$('#add-address-frm').resetForm();

            $('#hidden_address_id').val('');
            $('#name, #zip-code-control, #address').val('');
            //$('#telephone').val('');
            //$('#email').val('');
            $('#province-control').val(1);
            $("#district-control").attr("data-ref", "");
            $("#sub-district-control").attr("data-ref", "");
            $('#province-control').change();

            //var p_id = $("#province-control").attr("data-ref");
            //if(p_id){
            //    $('#province-control').val(p_id);
            //    $('#province-control').change();
            //    //$('#province-control').click();
            //}else{
            //    $('#province-control').val(1);
            //    $('#province-control').change();
            //    //$('#province-control').click();
            //}
            //$('#district-control').resetSelect(__('step2-select-city'));
            //$('#sub-district-control').resetSelect(__('step2-select-district'));
            //$('#zip-code-control').resetSelect(__('step2-select-zipcode'));

            $('#fill-address-form').slideDown(400, function() {
                var pos = $('#fill-address-form').offset();
                var $html = $('html, body');
                $html.animate({
                    scrollTop: pos.top
                }, '500', 'swing');
            });

            $('#title-shipping-address').html(__('step2-input-shipping-address'));
            $('#btnSave').val(__('step2-save-this-address'));

            return false;
        });
    }else{
        setTimeout(function(){
            var p_id = $("#province-control").attr("data-ref");
            if(p_id){
                $('#province-control').val(p_id);
                $('#province-control').change();
                //$('#province-control').click();
            }else{
                $('#province-control').val(1);
                $('#province-control').change();
                //$('#province-control').click();
            }
        }, 2000);
    }

    // add rule for validate name
    jQuery.validator.addMethod("validname", function(value, element) {
        return this.optional(element) || value.match('^[- a-zA-Z_ก-ํ.,]+$');
    });
    // rule to validate telephone number
    jQuery.validator.addMethod("validphone", function(value, element) {
        return this.optional(element) || value.match('^09');
    }, "Please enter a valid mobile #.");

    if($("#add-address-frm").length > 0){
        var validator = $("#add-address-frm").validate({
            rules: {
                name: {
                    required: true,
                    validname: true
                },
                phone_number: {
                    required: true,
                    digits: true,
                    rangelength: [11,11],
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
                    rangelength: [4,4]
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
            onfocusout: function(element) {
                elemId = $(element).attr('id');
                //if(elemId != "zip-code-control"){
                    $(element).valid();
                //}

                if (elemId == "name" ||
                    elemId == "telephone" ||
                    elemId == "province-control" ||
                    elemId == "district-control" ||
                    elemId == "sub-district-control" ||
                    elemId == "zip-code-control" ||
                    elemId == "address"
                    )
                {
                    //console.log('onfocusout');
                    $.post(
                        '/ajax/checkout/set-customer-info',
                        {
                            customer_name: $('#name').val(),
                            customer_tel: $('#telephone').val(),
                            customer_province_id: $('#province-control').val(),
                            customer_city_id : $('#district-control').val(),
                            customer_district_id : $('#sub-district-control').val(),
                            customer_postcode : $('#zip-code-control').val(),
                            customer_address: $('#address').val(),
                            customer_email: $('#email').val()
                        },
                        function (data){

                        },
                        'html'
                    );
                }
            },
            errorPlacement: function(error, element) {
                $(element).siblings(".icon-success").remove();
                error.insertAfter(element);
            },
            submitHandler: function(form) {
                //--- Save to cart ---//
                $('#btnSave').focus();
                $('#btnSave').val(__("processing"));
                $.post(
                    //'/ajax/checkout/set-customer-info',
                    $('#add-address-frm').attr('data-save-url'),
                    {
                        customer_name: $('#name').val(),
                        customer_tel: $('#telephone').val(),
                        customer_province_id: $('#province-control').val(),
                        customer_city_id : $('#district-control').val(),
                        customer_district_id : $('#sub-district-control').val(),
                        customer_postcode : $('#zip-code-control').val(),
                        customer_address: $('#address').val(),
                        customer_email: $('#email').val()
                    },
                    function (data){
                        //--- If user is guest will submit form ---//
                        if ($('#address_list_container').length == 0)
                        {
                            //$('#add-address-frm').submit();

                            form.submit();
                        }
                    },
                    'html'
                );


                if ($('#address_list_container').length == 0)
                {
                    return false;
                }


                //--- Is Member ---//
                //--- Save data to master table customer address ---//

                if ($('#address_list_container').length > 0)
                {
                    $.post(
                        //'/ajax/customers/save-ship-addr',
                        $('#add-address-frm').attr('data-save-url'),
                        {
                            address_id : $('#hidden_address_id').val(),
                            name: $('#name').val(),
                            phone: $('#telephone').val(),
                            email: $("#email").val(),
                            province_id: $('#province-control').val(),
                            city_id : $('#district-control').val(),
                            district_id : $('#sub-district-control').val(),
                            postcode : $('#zip-code-control').val(),
                            address: $('#address').val()
                        },
                        function (data){
                            var jsonDecode = $.parseJSON(data);
                            window.location.reload();
                        },
                        'html'
                    );
                }
                //--- Guest ---//
                //-- After save data to cart when redirect to step3 ---//
                else
                {

                }
                //alert("test");
                return false;
            },
            errorElement: 'div',
            errorClass: 'active-alert-text',
            highlight: function(element, errorClass) {
                $(element).siblings(".icon-success").remove();
                $(element).css("border", "2px solid #fe040d");
            },
            unhighlight: function(element, errorClass){
                var correctIcoURL = normal_url+'themes/checkout/assets/images/success.png';
                $(element).css("border", "2px solid #87c80a");
                $("<div class='left icon-success'><img src='"+correctIcoURL+"' width='14' height='14' /></div>").insertAfter($(element));
            },
            onkeyup:function(element,event){
                elementId = $(element).attr('id');

                if(elementId === "name"){
                    if(isKeyCodeForReplacing(event.keyCode)){
                        text = $(element).val();

                        caret = $(element).getCursorPosition();
                        text = text.replace(/[0-9]+/, "");
                        $(element).val(text);
                        setCaretPosition('name', caret);
                    }
                }

                if(elementId === "telephone"){
                    if(isKeyCodeForReplacing(event.keyCode)){
                        text = $(element).val();
                        //console.log(text);
                        //caret = doGetCaretPosition($(element));
                        //console.log("caret = " + $(element).caret().start);
                        caret = $(element).getCursorPosition();
                        //console.log('caret = ' + caret);
                        //$(element).caretTo(caret);

                        text = text.replace(/[- a-zA-Z_ก-ํ.,]+/, "");

                        $(element).val(text);
                        setCaretPosition('telephone', caret);
                    }
                }
            }

        });

		$('#btnTest').click(function(){
			//validator.resetForm();
			//$('#add-address-frm').find('input, select, textarea').css('border-color', '#e2e2e2');
			clearError();

		});


    }

	$.fn.clearError(function(){
		validator.resetForm();
	});

	/*
	function clearError(input)
	{
		validator.resetForm();
		if (input != undefined)
		{
			input.css('border-color', '#
		}
		else
		{
			$('#add-address-frm').find('input, select, textarea').css('border-color', '#e2e2e2');
			$('#add-address-frm').find('input, select, textarea').siblings('.icon-success').remove();
		}
	}
	*/

    function _renderAddressBlock(data){

        if (data.mode == 'insert')
        {
            var template = _.template(addressBlockTemplate);
            var activeAddress = $(template(data));
            $("#address_list_container > div:not(.add-addres, .clear)").removeClass("address-box-active").addClass("address-box");
            $("#address_list_container > div:not(.add-addres, .clear) p input").removeClass("form-bot-address-active").addClass("form-bot-address");

            $("#address_list_container").prepend(activeAddress);
            activeAddress.fadeIn();

            $('#fill-address-form').slideUp(400, function() {
                var $html = $('html, body');
                $html.animate({
                    scrollTop: 0
                }, '500', 'swing');
            });
        }
        else
        {
            var template = _.template(addrUpdateTemplate);
            var activeAddress = $(template(data));

            $('div[data-id="'+data.address_id+'"]').html(activeAddress);
        }

        return false;
    }

    function _clearAddressLightbox(){
        $("#wrapper_address input[type='text'], #wrapper_address textarea").val("");
        $("#wrapper_address select").val($("#wrapper_address select option:first").val());
    }

    // [B] Change province dropdown
    $('#province-control').change(function(){

        $('#district-control').resetSelect(__('step2-select-city'));
        $('#sub-district-control').resetSelect(__('step2-select-district'));
        //$('#zip-code-control').resetSelect(__('step2-select-zipcode'));

        var provinceName = $('#province-control :selected').text();
        //provinceName = $('#province-control :selected').text();
        var isBKK = (provinceName === 'กรุงเทพมหานคร');
        $('#district-name').text(isBKK ? __('step2-special-district') : __('step2-district'));
        $('#sub-district-name').text(isBKK ? __('step2-special-subdistrict') : __('step2-subdistrict') );

		$('#province-control').clearError();
		$('#district-control').clearError();
		$('#sub-district-control').clearError();
		//$('#zip-code-control').clearError();
        if ($(this).val() != "")
        {

            $('#district-control').showLoading(__('step2-loading'));

            var cities = Geolocation.Main.getCities($(this).val());

            // get all cities from js object first (geolocation.js).
            if( cities != undefined && cities != null ){
                if ($('#province-control :selected').text() == "กรุงเทพมหานคร")
                {
                    $('#district-control').loadSelect(cities, __('step2-select-city-special'));
                    $('#sub-district-control').resetSelect(__("step2-select-district-special"));
                }
                else
                {
                    $('#district-control').loadSelect(cities, __('step2-select-city'));
                    $('#sub-district-control').resetSelect(__("step2-select-district"));
                }
            }else{
                $.post(
                    $(this).attr('data-url'),
                    {
                        province_id : $(this).val(),
                        mode: 'province'
                    },
                    function (data){
                        if (data != null && data != NaN && data != "" && data != undefined)
                        {
                            var jsonDecode = $.parseJSON(data);

                            if ($('#province-control :selected').text() == "กรุงเทพมหานคร")
                            {
                                $('#district-control').loadSelect(jsonDecode, __('step2-select-city-special'));
                                $('#sub-district-control').resetSelect(__("step2-select-district-special"));
                            }
                            else
                            {
                                $('#district-control').loadSelect(jsonDecode, __('step2-select-city'));
                                $('#sub-district-control').resetSelect(__("step2-select-district"));
                            }
                        }
                    },
                    'html'
                );
            }
            var c_id = $("#district-control").attr("data-ref");
            if(c_id && $("#district-control option[value='"+c_id+"']").length > 0){
                $('#district-control').val(c_id);
                $('#district-control').change();
                //$('#district-control').click();
            }

        }
        else
        {
            $('#district-control').resetSelect(__('step2-select-city'));
            // Do nothing.
        }

    });
    // [E] End province change dropdown

    // [B] City (district) change dropdown

    $('#district-control').change(function(){
        $('#sub-district-control').resetSelect(__('step2-select-district'));
        //$('#zip-code-control').resetSelect(__('step2-select-zipcode'));

		$('#district-control').clearError();
		$('#sub-district-control').clearError();
		//$('#zip-code-control').clearError();
        if ($(this).val() != "" && $(this).val() != null)
        {
            $('#sub-district-control').showLoading(__('step2-loading'));

            var districts = Geolocation.Main.getDistricts($(this).val());
            // get all districts from js object first (geolocation.js).
            if( districts != undefined && districts != null ){
                if ($('#province-control :selected').text() == "กรุงเทพมหานคร")
                {
                    $('#sub-district-control').loadSelect(districts, __("step2-select-district-special"));
                }
                else
                {
                    $('#sub-district-control').loadSelect(districts, __("step2-select-district"));
                }
            }else{
                $.post(
                    $(this).attr('data-url'),
                    {
                        city_id : $(this).val(),
                        mode: 'city'
                    },
                    function (data){
                        if (data != null && data != NaN && data != "" && data != undefined)
                        {
                            var jsonDecode = $.parseJSON(data);
                            if ($('#province-control :selected').text() == "กรุงเทพมหานคร")
                            {
                                $('#sub-district-control').loadSelect(jsonDecode, __("step2-select-district-special"));
                            }
                            else
                            {
                                $('#sub-district-control').loadSelect(jsonDecode, __("step2-select-district"));
                            }
                            //$('#sub-district-control').loadSelect(jsonDecode, __('step2-select-district'));
                        }
                    },
                    'html'
                );
            }
            var sc_id = $("#sub-district-control").attr("data-ref");
            if(sc_id && $("#sub-district-control option[value='"+sc_id+"']").length > 0){
                $('#sub-district-control').val(sc_id);
                $('#sub-district-control').change();
                //$('#sub-district-control').click();
            }
        }
        else
        {
            $('#sub-district-control').resetSelect(__('step2-select-district'));
            //$('#zip-code-control').resetSelect(__('step2-select-zipcode'));
        }
    });
    // [E] City (district) change dropdown

    // [B] District (Sub-District) change dropdown
    $('#sub-district-control').change(function(){
        //$('#zip-code-control').resetSelect(__('step2-select-zipcode'));

		$('#sub-district-control').clearError();
        //$('#zip-code-control').clearError();
        //if ($(this).val() != "")
        //{
        //    //$('#zip-code-control').showLoading(__('step2-loading'));
        //
        //    var zipcode = Geolocation.Main.getZipcode($(this).val());
        //    // get all districts from js object first (geolocation.js).
        //    if( zipcode != undefined && zipcode != null){
        //        $('#zip-code-control').loadSelect(zipcode, __('step2-select-zipcode'));
        //    }else{
        //        $.post(
        //            $(this).attr('data-url'),
        //            {
        //                district_id : $(this).val(),
        //                mode: 'district'
        //            },
        //            function (data){
        //                if (data != null && data != NaN && data != "" && data != undefined)
        //                {
        //                    var jsonDecode = $.parseJSON(data);
        //                    $('#zip-code-control').loadSelect(jsonDecode, __('step2-select-zipcode'));
        //
        //
        //                }
        //            },
        //            'html'
        //        );
        //    }
        //
        //    // [B] Check shipping
        //    checkShippingAvailable();
        //    // [E] check shipping
        //
        //}
        //else
        //{
        //    $('#zip-code-control').resetSelect(__('step2-select-zipcode'));
        //}
    });

    //[E] District (Sub-District) changedropdown.

	// Save Adress
	$('#address_list_container').on("click" , "input" , function(event){
		event.preventDefault();

        $(this).val(__("processing"));
        $(document).trigger("show-ajax-loading");

        var that = this;
        //Closure function to submit form.
		var submitShipAddress = function(that){
            var select_href = $('#address_list_container').attr('data-href');
            $.post(
                select_href,
                {
                    id : $(that).parent().parent().parent().attr('data-id')
                },
                function (data){
                    if (data != null && data != undefined && data != NaN && data != "")
                    {
                        jsonDecode = $.parseJSON(data);
                        if (jsonDecode.code == 200)
                        {
                            window.location.href = jsonDecode.return_step;
                        }
                    }
                },
                'html'
            );
        };

        var checkEmailExistUrl = $(that).parent().parent().find(".address-edit .edit-ship-addr").data("href");

        if( checkEmailExistUrl != undefined && checkEmailExistUrl != ""){
            $.getJSON(checkEmailExistUrl,
                {},
                function (data){

                    if (data != undefined && data != NaN && data != "" && data != null)
                    {
                        var email = "";
                        var patt = new RegExp("\@truelife.com$");
                        if(! patt.test(data.email) && data.email != ""){
                            //email is found then goto step3.
                            submitShipAddress(that);
                        }else{
                            // please input email.
                            $(document).trigger("hide-ajax-loading");
                            $("#email").val("");
                            $(that).parent().parent().find(".address-edit .edit-ship-addr").click();
                        }
                    }
                }

            );
        }else{
            $(document).trigger("hide-ajax-loading");
        }

	});
}
function _renderDistrictDropdown(data){
    var optionTemplate = _.template("<% $.each(lists, function(key, value){  %> <option value='<%=value.id%>'><%=value.name%></option>\n <%  }); %>");

    if(data.cities != undefined){
        var citiesList = optionTemplate({lists: data.cities});
        $("#district-control").html(citiesList);
    }
}

function _renderSubDistrictDropdown(data){
    var optionTemplate = _.template("<% $.each(lists, function(key, value){  %> <option value='<%=value.id%>'><%=value.name%></option>\n <%  }); %>");
    if(data.districts != undefined){
        var districtsList = optionTemplate({lists: data.districts});
        $("#sub-district-control").html(districtsList);
    }
}

function _renderZipcodeDropdown(data){
    //var optionTemplate = _.template("<% $.each(lists, function(key, value){  %> <option value='<%=value.zipcode%>'><%=value.zipcode%></option>\n <%  }); %>");
    //
    //if(data.zip_code != undefined){
    //    var zipcodeList = optionTemplate({lists: data.zip_code});
    //    $("#zip-code-control").html(zipcodeList);
    //}
}

function isKeyCodeForReplacing(keyCode){
    if(keyCode !== 8 && keyCode !== 37 && keyCode !== 38 && keyCode !== 39 && keyCode !== 40){
        return true;
    }
    return false;
}

function checkShippingAvailable(){
    // [B] Check shipping
    $.post(
        '/checkout/check-shipping',
        {
        },
        function (data){
            if (data != NaN && data != "" && data != null && data != undefined)
            {
                var jsonDecode = $.parseJSON(data)
                if (jsonDecode.shipments == null)
                {
                    $('.no-product-list .right .clr-5').html('<strong style="color:#FF0000;">' + __("cart-cannot-ship") + '</strong>');

                    $('#btnSave').css('display', 'none');
                }
                else
                {
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
} (jQuery);

function setCaretPosition(elemId, caretPos) {
    var elem = document.getElementById(elemId);

    if(elem != null) {
        if(elem.createTextRange) {
            var range = elem.createTextRange();
            range.move('character', caretPos);
            range.select();
        }
        else {
            if(elem.selectionStart) {
                elem.focus();
                elem.setSelectionRange(caretPos, caretPos);
            }
            else
                elem.focus();
        }
    }
}