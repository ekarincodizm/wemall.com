var Product = Product || {};

Product.Cart = (function($) {

    var me = me || {};

    //me.template = $('.cart-template').html();

    me.init = function() {

        $(".topright-cart-btn").click(function() {

            $('#cart-popup').css({overflow: 'visible', 'z-index': '10000'}).modal('show');
            if ($('#cart-box-info').length === 0) {
                $('.cart-box').wrapAll('<div id="cart-box-info"></div>');
            }
            $('#cart-box-info').css({overflow: 'auto', maxHeight: $('#cart-popup').height() - 251 + 'px'});

            if (jQuery().textBlink) {
                $(".text-blink").textBlink();
            }
        });

        /** Goto checkout */
        $('.checkout-info .btn-checkout-home').on('click', function() {

            var getCookie = function(cname) {
                var name = cname + "=";
                var ca = document.cookie.split(';');
                for(var i=0; i<ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0)==' ') c = c.substring(1);
                    if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
                }
                return "";
            }

            var stage = getCookie('stage');
            var addition = "";
            if (open_https == 'true')
            {
                checkout_url = site_url_https;
            }
            else
            {
                checkout_url = site_url;
            }

            if (LANG != "th") {
                addition = LANG + "/";
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
        });



        //custom events to listen cartlightbox event.
        $(document).bind('cart-update-item-qty', function() {
            Product.Cart.updateData('cart-update-item-qty');
        });
        $(document).bind("cart-delete-item", function() {
            Product.Cart.updateData('cart-delete-item');
        });
        $(document).bind("cart-get-cart", function() {
            Product.Cart.updateData('cart-get-cart');
        });
    };

    me.renderCartList = function()
    {

        //var html = '';
        var $cart_quantity = $('.cart-quantity');
        $('.cart-items').remove();

        if (Cart.data.cart_details && Cart.data.cart_details.length > 0)
        {
            $cart_quantity.text(Cart.data.totalQty).show();
            $(".btn-checkout-home").show();

        }
        else
        {
            $cart_quantity.text(0).hide();
            $(".btn-checkout-home").hide();
        }


    };


    me.updateData = function(ref)
    {

        $.ajax({
            async: false,
            type: 'GET',
            url: '/ajax/cart',
            success: function(response)
            {
                Cart.data = eval(response.data);
                Product.Cart.renderCartList();
            }
        });
    };

    return me;

})(jQuery);

$(document).ready(function() {
    Product.Cart.init();
});