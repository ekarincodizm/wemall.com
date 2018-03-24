"strict"

var initDeleteAddress = function () {

    $(".delete-member-address").on("click", function () {

        var ajaxUrl = $(this).data("action");
        var addrId = $(this).data("addr-id");
        var that = this;

        if (ajaxUrl && addrId) {
            $.ajax({
                url: ajaxUrl,
                method: "POST",
                cache: false,
                data: {
                    id: addrId
                },
                success: function (data) {
                    $(that).parents('.address-block').slideUp(400, function () {
                        $(this).remove();
                    });
                }
            });
        }
    });
};

var _saveUserAddress = function (_ele, callback) {

    var _addressId = $("input[name='address']:checked").val();

    if (_addressId) {
        $.ajax({
            url: UrlToLang("ajax/customers/saveaddr"),
            method: "POST",
            cache: false,
            data: {
                id: _addressId
            },
            beforeSend: function () {
                $(document).trigger("show-ajax-loading");

                if(typeof callback == "function"){
                    $('.button-buy .button').html('<span class="button-processing-green"></span>');
                    $('.button-buy .button').css({"text-align": "left"});
                    loopProcess();
                }
            },
            success: function (data) {

                if (typeof callback == "function") {
                    callback();
                } else {
                    $(document).trigger("hide-ajax-loading");
                }

                return false;
            }
        });
    } else {
        alert(__("step2-please-choose-shipping-address"));
    }
};

var initSaveMemberAddress = function () {

    $(".button-buy").on("click", function () {
        var callback = function () {
            $("#member-address").submit();
        };
        _saveUserAddress($(this), callback);
    });

    if (!$("input[name='address']:checked").val()) {
        $("input[name='address']").first().click();
        _saveUserAddress($("input[name='address']").first());
    }

};

$(document).ready(function () {

    initDeleteAddress();
    initSaveMemberAddress();

    saveStage();

});