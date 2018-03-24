var Geolocation = Geolocation || {};

Geolocation.Main = (function ($) {
    geolocation = {};
    geolocation.provinces = null; // จังหวัด
    geolocation.cities = null; // อำเภอ
    geolocation.districts = null; //ตำบล
    geolocation.zipcode = null;

    geolocation.getProvinces = function () {
        try {
            return geolocation.provinces[LANG];
        } catch (e) {
            return null;
        }
    };

    geolocation.getCities = function (province_id) {
        try{
            return geolocation.cities[LANG][province_id];
        }catch(e){
            return null;
        }

    };

    geolocation.getDistricts = function (city_id) {
        try {
            return geolocation.districts[LANG][city_id];
        } catch (e) {
            return null;
        }
    };

    geolocation.getZipcode = function (distict_id) {
        try {
            return geolocation.zipcode[distict_id];
        } catch (e) {
            return null;
        }
    };

    geolocation._rearrangeGeolocationData = function (data, qkey) {
        var thBuffer = {};
        var enBuffer = {};

        $.each(data.th, function (idx, row) {

            //th
            if (!$.isArray(thBuffer[row[qkey]])) {
                thBuffer[row[qkey]] = [];
            }

            thBuffer[row[qkey]].push({
                opt_value: row.id,
                opt_text: row.name,
                delivery_area_id: row.delivery_area_id
            });
        });

        $.each(data.en, function (idx, row) {
            //en
            if (!$.isArray(enBuffer[row[qkey]])) {
                enBuffer[row[qkey]] = [];
            }
            enBuffer[row[qkey]].push({
                opt_value: row.id,
                opt_text: row.name,
                delivery_area_id: row.delivery_area_id
            });
        });

        return {th: thBuffer, en: enBuffer};
    };

    geolocation._rearrangeZipCode = function (data, qkey) {

        var Buffer = {};

        $.each(data.th, function (idx, row) {
            if (!$.isArray(Buffer[row[qkey]])) {
                Buffer[row[qkey]] = [];
            }
            Buffer[row[qkey]].push({
                opt_value: row.zip_code,
                opt_text: row.zip_code
            });
        });

        return Buffer;
    };

    geolocation.init = function () {
        $.getJSON("/assets/js/geolocation/geolocation.json", function (geodata) {
            try {
                if (geodata != undefined && typeof geodata == "object") {
                    if (geodata.provinces != undefined) {
                        geolocation.provinces = geolocation._rearrangeGeolocationData(geodata.provinces, "country_id");
                    }
                    if (geodata.cities != undefined) {
                        geolocation.cities = geolocation._rearrangeGeolocationData(geodata.cities, "province_id");
                    }
                    if (geodata.districts != undefined) {
                        geolocation.districts = geolocation._rearrangeGeolocationData(geodata.districts, "city_id");
                        geolocation.zipcode = geolocation._rearrangeZipCode(geodata.districts, "id");
                    }
                }
            } catch (e) {
                //do nothing.
            }
        }).error(function (xhr) {
            console.log(xhr);
        });
    };

    return geolocation;
})(jQuery);

$(document).ready(function () {
    Geolocation.Main.init();
});

