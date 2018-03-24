var Product = Product || {};


Product.Cart = (function($) {
    
    var me = me || {};
    
    me.template = $('.cart-template').html();
    
//    me.init = function() {
//        
//        $('body').on('click', '.remove-item', function()
//        {
//            var $tr = $(this).parents('tr:first');
//            var inventory_id = $tr.data('inventory_id');
//            var $cart_quantity = $('.cart-quantity');
//            var cart_quantity = $cart_quantity.text();
//            var quantity = $tr.data('quantity');
//
//            $.ajax({
//                type: 'POST',
//                url: '/ajax/cart/remove-item',
//                data: {
//                    inventory_id: inventory_id
//                },
//                success: function(response) {
//                    
//                    Cart.data = eval(response.data);
//                    Product.Cart.renderCartList();
//                    
//                    $('body').trigger('remove-item');
//                    
//                }
//            });
//
//            var new_qty = cart_quantity-quantity;
//
//            $tr.fadeOut(200, function() {
//
//                if (new_qty == 0)
//                {
//                    $cart_quantity.hide();
//                }
//
//            });
//
//            return false;
//
//        });
//        
//        //me.renderCartList();
//        
//    };
    
//    me.renderCartList = function()
//    {    
//        var html = '';
//        
//        var $cart_quantity = $('.cart-quantity');
//        
//        $('.cart-items').remove();
//        
//        if (Cart.data.cart_details.length > 0)
//        {
//            $cart_quantity.text(Cart.data.totalQty).show();
//            
//            $('.cart-noitems').hide();
//            
//            $(Cart.data.cart_details).each(function(key, value) {
//
//                var _template = me.template;
//
//                _template = _template.replace(/{inventory_id}/g, value.inventory_id);
//                _template = _template.replace(/{title}/g, value.title);
//                _template = _template.replace(/{quantity}/g, value.quantity);
//                _template = _template.replace(/{thumbnail}/g, ' src="'+value.thumbnail+'" ');
//                _template = _template.replace(/{totalPrice}/g, me.numberFormat(value.totalPrice));
//                
//                html += _template;
//
//            });
//            
//            $('.cart-list').append(html);
//        }
//        else
//        {
//            $cart_quantity.text(0).hide();
//            $('.cart-noitems').show();
//        }
//        
//    };
    
//    me.showCartList = function(time)
//    {
//        time = typeof time !== 'undefined' ? time : 2000;
//        
//        $('.cart-wrapper').show();
//        
//        setTimeout(function() {
//            
//            $('.cart-wrapper').fadeOut();
//            
//        }, time);
//        
//    };
    
    me.updateData = function()
    {
        $.ajax({
            async: false,
            type : 'GET',
            url : '/ajax/cart',
            success : function(response)
            {
                Cart.data = eval(response.data);
                //Product.Cart.renderCartList();
            }
        });
    };
    
    me.numberFormat = function(number, type)
    {
        if ( ! type) type = 'price';
        
        switch (type)
        {
            case 'price':
                number += '';
                x = number.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                   x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2 + '.-';
                break;
        }
    };
    
    return me;
    
})(jQuery);

//$(document).ready(function() {
//    
//    Product.Cart.init();
//    
//});

