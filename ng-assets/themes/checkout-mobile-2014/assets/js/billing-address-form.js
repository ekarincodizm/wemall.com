$(document).ready(function(){
    // [S] Change province drop down billing address
    $('#bill_province_id').change(function(){

        var provinceName = $('#bill_province_id :selected').text();
        var isBKK = (provinceName === 'กรุงเทพมหานคร');
        $('#city-name').text(isBKK ? __('step3-special-district') : __('step3-district'));
        $('#district-name').text(isBKK ? __('step3-special-subdistrict') : __('step3-subdistrict') );

        $('#bill_city_id').resetSelect(__("step2-select-city"));
        $('#bill_district_id').resetSelect(__("step2-select-district"));
        $('#bill_postcode').resetSelect(__("step2-select-zipcode"));

        if ($(this).val() != "")
        {
            var cities = Geolocation.Main.getCities($(this).val());

            // get all cities from js object first (geolocation.js).
            if( cities != undefined && cities != null ){
                if ($('#bill_province_id :selected').text() == "กรุงเทพมหานคร")
                {
                    $('#bill_city_id').loadSelect(cities, __('step2-select-city-special'));
                    $('#bill_district_id').resetSelect(__("step2-select-district-special"));
                }
                else
                {
                    $('#bill_city_id').loadSelect(cities, __('step2-select-city'));
                    $('#bill_district_id').resetSelect(__("step2-select-district"));
                }
            }else{

                $.post(
                    UrlToLang("ajax/customers/addr"),
                    {
                        province_id : $(this).val(),
                        mode: 'province'
                    },
                    function (data){

                        if (data != null && data != NaN && data != "" && data != undefined)
                        {
                            var jsonDecode = $.parseJSON(data);
                            if ($('#bill_province_id :selected').text() == "กรุงเทพมหานคร")
                            {
                                $('#bill_city_id').loadSelect(jsonDecode, __('step2-select-city-special'));
                                $('#bill_district_id').resetSelect(__("step2-select-district-special"));
                            }
                            else
                            {
                                $('#bill_city_id').loadSelect(jsonDecode, __('step2-select-city'));
                                $('#bill_district_id').resetSelect(__("step2-select-district"));
                            }
                        }
                    },
                    'html'
                );
            }
        }
    });
    // [E] Change province drop down billing address

    // [S] Change city drop down billing address
    $('#bill_city_id').change(function(){
        $('#bill_district_id').resetSelect(__("step2-select-district"));
        $('#bill_postcode').resetSelect(__("step2-select-zipcode"));
        if ($(this).val() != "")
        {

            var districts = Geolocation.Main.getDistricts($(this).val());
            // get all districts from js object first (geolocation.js).
            if( districts != undefined && districts != null ){
                if ($("#bill_province_id :selected").text() == "กรุงเทพมหานคร")
                {
                    $('#bill_district_id').loadSelect(districts, __('step2-select-district-special'));
                }
                else
                {
                    $('#bill_district_id').loadSelect(districts, __('step2-select-district'));
                }
            }else{
                $.post(
                    UrlToLang("ajax/customers/addr"),
                    {
                        city_id : $(this).val(),
                        mode: 'city'
                    },
                    function (data){
                        if (data != null && data != NaN && data != "" && data != undefined)
                        {
                            var jsonDecode = $.parseJSON(data);

                            if ($("#bill_province_id :selected").text() == "กรุงเทพมหานคร")
                            {
                                $('#bill_district_id').loadSelect(jsonDecode, __('step2-select-district-special'));
                            }
                            else
                            {
                                $('#bill_district_id').loadSelect(jsonDecode, __('step2-select-district'));
                            }
                        }
                    },
                    'html'
                );
            }

        }
    });
    // [E] Change city drop down billing address

    // [S] Change district drop down billing address
    $('#bill_district_id').change(function(){
        $('#bill_postcode').resetSelect(__("step2-select-zipcode"));
        if ($(this).val() != "")
        {
            var zipcode = Geolocation.Main.getZipcode($(this).val());
            // get all districts from js object first (geolocation.js).
            if( zipcode != undefined && zipcode != null ){
                $('#bill_postcode').loadSelect(zipcode, __('step2-select-zipcode'));
            }else{
                $.post(
                    UrlToLang("ajax/customers/addr"),
                    {
                        district_id : $(this).val(),
                        mode: 'district'
                    },
                    function (data){
                        var jsonDecode = $.parseJSON(data);
                        if (data != null && data != NaN && data != "" && data != undefined)
                        {
                            $('#bill_postcode').loadSelect(jsonDecode, __('step2-select-zipcode'));
                        }
                    },
                    'html'
                );
            }
        }
    });
    // [E] Change district drop down billing address
});