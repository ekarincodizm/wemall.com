$(function () {

    var old_quantity;
    var ajax_processing = false;
    var continue_clicked = false;

    $(document).on('click', '.item-quantity', function () {
        old_quantity = parseInt($(this).val());
    });

    $(document).on('change', '.shipping-methods', function () {
        var shipment_key = $(this).data('shipment_key');
        var pkey = $(this).val();

        $.ajax({
            type: 'POST',
            url: '/cart/select-shipping-methods',
            data: {
                shipment_key: shipment_key,
                pkey: pkey
            },
            success: function (response) {

                // stop loading
                $('.checkout-calculating').hide();

                if (response.status == 'success') {
                    var checkout = response.data;

                    render(checkout);
                }
            }
        });
    });

    $(document).on('change', '.item-quantity', function () {
        var inventory_id = $(this).data('inventory_id');
        var quantity = parseInt($(this).val());

        $.ajax({
            type: 'POST',
            url: '/cart/update-item',
            data: {
                inventory_id: inventory_id,
                qty: quantity
            },
            success: function (response) {

                if (response.status == 'success') {
                    var checkout = response.data;

                    render(checkout);
                }
                else {
                    if (response.message == 'item-already-in-cart-limit-1-item') {
                        alert(__(response.message));
                    }
                    else {
                        alert('Out of stock');
                    }
                }
            }
        });
    });

    $(document).on('click', '.remove-item', function () {

        var inventory_id = $(this).data('inventory_id');
        var shipment_key = $(this).data('shipment_key');

        // start loading
        $(this).siblings('.checkout-calculating').show();

        $.ajax({
            type: 'POST',
            url: '/cart/remove-item',
            data: {
                inventory_id: inventory_id
            },
            success: function (response) {

                // stop loading
                $('.checkout-calculating').hide();

                $('#inventory_id-' + inventory_id).fadeOut();

                if (response.status == 'success') {
                    var checkout = response.data;

                    // remove shipments
                    if (typeof checkout.shipments[shipment_key] == 'undefined') {
                        $('#shipment_key-' + shipment_key).remove();
                    }

                    // reload if no items left
                    if (checkout.items_count == 0) {
                        location.reload();
                    }

                    render(checkout);
                }
                else {
                    alert('System error! Please try again');
                }
            }
        });

        return false;
    });

    $(document).on('click', '.continue-button', function () {
        //$($(this).children('div')[0]).text(__("processing")+"...");

        continue_clicked = true;

        return !ajax_processing;
    });

    $(document).ajaxStart(function () {
        ajax_processing = true;
    });

    $(document).ajaxStop(function () {
        ajax_processing = false;

        // if (continue_clicked)
        // {
        //     location.href = $('.continue-button').attr('href');
        // }
    });

    function render(checkout) {

        // render new quantity
        $('.checkout-items_count').text(checkout.items_count);
        var vendorkey = 0;
        for (shipment_key in checkout.shipments) {
            $('.shipment-' + shipment_key + '-items_count').text(checkout.shipments[shipment_key].items_count);
            $('.shipment-' + shipment_key + '-vendor').text(vendorkey + 1);
            vendorkey++;
        }

        if (vendorkey == 1) {
            $('.shop_vendor').remove();
        }

        // render new price
        $('.checkout-total_price').text(addCommas(checkout.total_price.toFixed(2)));

        var totalShippingFee = 0;
        if (checkout.total_shipping_fee) {
            $(".checkout-total_shipping_fee").removeClass("text-green");
            totalShippingFee = addCommas(checkout.total_shipping_fee.toFixed(2));
        } else {
            $(".checkout-total_shipping_fee").removeClass("text-green").addClass("text-green");
            totalShippingFee = __("cart-free-lbl");
        }
        $('.checkout-total_shipping_fee').text(totalShippingFee);
        $('.checkout-total_discount').text((checkout.total_discount > 0 ? "-" : "") + addCommas(checkout.total_discount.toFixed(2)));
        $('.checkout-sub_total').text(addCommas(checkout.sub_total.toFixed(2)));

        // render shipping_note
        if (checkout.shipping_config) {
            var notification_link = (checkout.shipping_config.shipping_link) ? checkout.shipping_config.shipping_link : "javascript:void(0);";
            $(".fullcart-noti-shipping-fee")
                .attr("href", notification_link)
                .text(checkout.shipping_config.shipping_note)
                .show();

            if(notification_link && notification_link != "javascript:void(0);"){
                $(".fullcart-noti-shipping-fee").removeClass("isnot-link").addClass("is-link");
            }else{
                $(".fullcart-noti-shipping-fee").removeClass("is-link").addClass("isnot-link");
            }
        } else {
            $(".fullcart-noti-shipping-fee").hide();
        }

        //render promoiton
        var i;
        var promo_text = '';
        if (checkout.promotions != undefined) {
            if (checkout.promotions.length > 0) {
                for (i in checkout.promotions) {
                    promo_text += checkout.promotions[i].name;
                }
            }
        }

        if (promo_text != '') {
            $('.show-promotion').show();
            $('.show-promotion').text(__('show-discount-promotion') + ' ' + promo_text);
        }
        else {
            $('.show-promotion').hide();
        }

        blinkText();
    }

    function blinkText(){
        if(jQuery().textBlink){
            $(".text-blink").textBlink();
        }
    }

    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    //script for animate processing button ดำเนินการ
    var terms = [__("processing") + "...", __("processing") + ".. .", __("processing") + ". ..", __("processing") + " ..."];

    function loopProcess() {
        var processButton = $('.continue-button div #button-processing-green');
        var ct = processButton.data("term") || 0;
        processButton.data("term", ct == terms.length - 1 ? 0 : ct + 1).text(terms[ct]).show()
            .delay(250).show(200, loopProcess);
    }

    $(document).on('click', '.continue-button div', function (e) {

        $(this).css({"text-align": "left"}).html('<span id="button-processing-green"></span>');
        loopProcess();

        redirect();

    });

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
        }
        return "";
    }

    function redirect() {
        /** [S] cookie */
        var stage = getCookie('stage');
        var addition = "";
        if (LANG != "th") {
            addition = LANG + "/";
        }

        if (open_https == 'true') {
            checkout_url = site_url_https;
        }
        else {
            checkout_url = site_url;
        }

        switch (stage) {
            case's1':
                page = checkout_url + addition + "checkout/step1";
                break;
            case's2':
                page = site_url + addition + "checkout/step2";
                break;
            case's3':
                page = checkout_url + addition + "checkout/step3";
                break;
            default:
                page = checkout_url + addition + "checkout/step1";
                break;
        }
        location.href = page;
        /** [E] cookie */
    }

});