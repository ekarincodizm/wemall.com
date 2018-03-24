var Tracking = Tracking || {};

Tracking.Lightbox = (function($){
    var o = {};
    var orderDetailUrl = "/ajax/member/tracking-data";
    var template = $("#tracking_template").html();
    var views = {
        customer_name: "",
        customer_address: "",
        customer_tel: "",
        product_name: "",
        quantity: 1,
        delivery_data: []
    };

    var _getTrackingData = function(trackingNo, callback){
        $.ajax({
            url: orderDetailUrl,
            method: "GET",
            data: {
                tracking_no: trackingNo
            },
            success: function(json){
                console.log(json);
                if(json.code == 200 && typeof callback == "function"){
                    callback(json.data);
                }else{
                    alert("No delivery information");
                    $(document).trigger("hide-ajax-loading");
                }
            },
            error: function(err){
                console.log(err);
                alert("No delivery information");
                $(document).trigger("hide-ajax-loading");
            }
        });
    };

    var _render = function(data){

        if(data.hasOwnProperty("delivery_data") && $.isArray(data.delivery_data)){
            $.each(data.delivery_data, function(idx, value){
                tmp = {
                    "datetime": value.datetime,
                    "detail": value.description,
                    "remark": (value.status == "ส่งสำเร็จ")? value.status : ""
                };

                views.delivery_data.push(tmp);
            });
        }


        var compiled = _.template(template);
        var displayHtml = compiled(views);
        $(document).trigger("hide-ajax-loading");
        $('#order-detail-content').html(displayHtml);
        $('#modal-dialog-order-status').modal('show');

    };

    o.init = function(){

        $(".show-tracking-detail").click(function(){

            if($(this).data("tracking-no") == ""){
                return false;
            }

            $(document).trigger("show-ajax-loading");

            views.customer_name = $(this).data("customer-name");
            views.customer_address = $(this).data("customer-address");
            views.customer_tel = $(this).data("customer-tel");
            views.product_name = $(this).data("product-name");
            views.quantity = $(this).data("product-quantity");
            views.delivery_data = [];
            trackingNo = $(this).data("tracking-no");
            _getTrackingData(trackingNo, _render);
        });
    };

    return o;
})(jQuery);

$(document).ready(function () {
    //$('#modal-dialog-true-privilege').on('click', '.btn-auth', function () {
    //    $('#modal-dialog-true-privilege').modal('hide');
    //    $('.information-message').hide().eq(1).show();
    //});

    Tracking.Lightbox.init();
});