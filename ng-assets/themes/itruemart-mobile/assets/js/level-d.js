var Product = Product || {};

Product.levelD = (function($) {
    
    var me = me || {};
    
    me.buynow = false;
    
    me.addingDialog = $('#cart-adding');
    me.installmentDialog = $('#cart-installment');
    me.selectInstallmentDialog = $('#cart-select-installment');
    
    me.init = function() {
        $(document).on('set-inventory-id', function(e, inventory_id) {
            $('.container-product-installment').hide();
            //$('.container-trueyou').hide();
            //$('.promotion_block').hide();
            
            if (inventory_id == 'out_of_order')
            {
                $('.product-addtocart').data('inventory-id', inventory_id);
            }
            else if(inventory_id)
            {
                $('.product-addtocart').data('inventory-id', inventory_id);
                //var installmentDisplay = $('#installment-'+inventory_id);
                //$('.product-addtocart').data('inventory-id', inventory_id).data('allow-installment', installmentDisplay.length ? true : false);
                //$('#trueyou-'+inventory_id).show();
                //$('#promotion-block-'+inventory_id).show();
                //installmentDisplay.show();
            }
            else
            {
                $('.product-addtocart').data('inventory-id', null);
            }
            
        });
        
        $('.product-form').on('submit', function() {
            return false;
            
        });
        
        $('.product-addtocart').on('click', function() {
            
            //me.buynow = false;
            me.buynow = true;
            
            me.startAddToCart();
            
        });
        
        $('.product-buynow').on('click', function() {
            
            me.buynow = true;
            
            me.startAddToCart();
            
        });
        
        $(document).bind('cart:addedItem', function(e, response) {
            
            me.showResultDialog(response);
            
        });
        
        //me.countdown();
        
    };
    
    me.startAddToCart = function() {
        
        var inventory_id = $('.product-addtocart').data('inventory-id');

        if ( ! inventory_id)
        {
            me.showAlertDialog('ไม่สามารถนำสินค้าชิ้นนี้ใส่ตะกร้าได้', 'กรุณาเลือก option ของสินค้าก่อน');
            return;
        }
        
        if(inventory_id == 'out_of_order'){
            me.showAlertDialog('ไม่สามารถนำสินค้าชิ้นนี้ใส่ตะกร้าได้', 'สินค้าหมด');
            return;
        }
        
        if ($('.out_of_stock').length != 0)
        {
            me.showAlertDialog('ไม่สามารถนำสินค้าชิ้นนี้ใส่ตะกร้าได้', 'สินค้าหมด');
            
            return;
        }
        
        me.showInstallmentDialog();
        
    };
    
    me.showInstallmentDialog = function() {
        
        var cartAddable;
        var item_installment = $('.product-addtocart').data('allow-installment');
        
        var revealConfig = {
            animation: 'none',
            closeonbackgroundclick: true,
            dismissmodalclass: 'popup_ok'
        };
        
        Product.Cart.updateData();

        if (Cart.data.type == 'installment' && Cart.data.cart_details.length > 0)
        {
            cartAddable = false;
        }
        else
        {
            cartAddable = true;
        }

        $('.installment_message').hide();
        $('.cart-installment-button').hide();
        
        if (cartAddable == false)
        {
            if (item_installment == true)
            {
                $('.installment_message_3').show();
            }
            else
            {
                $('.installment_message_2').show();
            }
            
            $('.cart-installment-button_ok').show();
            
            //Go to checkout page if customer already have an installment cart.
            $(".cart-installment-button_ok").unbind("click");
            $(".cart-installment-button_ok").bind("click", function(){        
                me.goToCheckout();
                $(".cart-installment-button_ok").unbind("click");
            });
            me.installmentDialog.reveal(revealConfig);
        }
        else
        {
            if (item_installment == true)
            {   
                me.selectInstallmentDialog.reveal(revealConfig);
                
                $('.cart-installment-button_next').on('click', function() {
                    
                    me.selectInstallmentDialog.trigger('reveal:close');
                    
                    var type = $('.cart-installment-select:checked').val();
                    
                    if (type == 'normal' || Cart.data.cart_details.length == 0)
                    {
                        me.addItem();
                    }
                    else
                    {
                        $('.installment_message_1').show();
                        $('.cart-installment-button_add').show();
                        $('.cart-installment-button_cancel').show();
                
                        $('.cart-installment-button_add').on('click', function() {
                            $("input[name='cart-installment-select'][value='normal']").attr("checked", true);
                            me.addItem();

                        });

                        $('.cart-installment-button_cancel').on('click', function() {

                            me.selectInstallmentDialog.trigger('reveal:close');

                        });
            
                        me.installmentDialog.reveal(revealConfig);
                    }
                    
                    me.selectInstallmentDialog.trigger('reveal:close');
                });
                
                me.selectInstallmentDialog.on('reveal:close', function() {
                    
                    $('.cart-installment-button_next').off();
                    $('.cart-installment-button_ok').off();
                    $('.cart-installment-button_add').off();
                    $('.cart-installment-button_cancel').off();
                    
                });
            }
            else
            {
                me.addItem();
            }
        }
        
    };
    
    me.addItem = function() {
        
        me.installmentDialog.trigger('reveal:close');
        
        me.showAddingDialog();
        
        var response;
        
        var inventory_id = $('.product-addtocart').data('inventory-id');
        var qty = $('.product-qty').val();
        
        if ( ! inventory_id){
            me.showAlertDialog('กรุณาเลือก option ของสินค้าก่อน');
            return;
        }
        if(inventory_id == 'out_of_order'){
            me.showAlertDialog('ไม่สามารถนำสินค้าชิ้นนี้ใส่ตะกร้าได้', 'สินค้าหมด');
            return;
        }
        
        var data = {
            inventory_id: inventory_id,
            qty: qty,
            type: $('.cart-installment-select:checked').val()
        };

        var addCartUrl = "/ajax/v2/cart/add-item";
        if(LANG == "en"){
            addCartUrl = "/"+LANG+addCartUrl;
        }
        $.ajax({
            async: false,
            type : 'POST',
            url : addCartUrl,
            data : data,
            success: function(r) {
                
                me.hideAddingDialog();
                if (r.status == 'error')
                {
                    me.showAlertDialog('ไม่สามารถเพิ่มสินค้าได้', 'สินค้าในคลังคงเหลือไม่เพียงพอ');
                }
                else
                {
                    response = r;
                    $(document).trigger('cart:addedItem', [response]);
                }
            }
        });
        
    };
    
    me.showResultDialog = function(response) {
        
        var qty;
        var price;
        
        
        $(response.data.cart_details).each(function(k, v) {
            
            if (v.inventory_id == $('.product-addtocart').data('inventory-id'))
            {
                qty = v.quantity;
                price = v.totalPrice;
            }
            
        });
        
        $('#resp-product-qty').html(qty + ' ชิ้น');
        $('#resp-product-totalprice').html(me.numberFormat(price) + ' บาท');

        $('#cart-result').reveal({
            animation: 'none',
            dismissmodalclass: 'popup_ok'
        }).on('reveal:close',function() {

            Cart.data = eval(response.data);
            //Product.Cart.renderCartList();
            //Product.Cart.showCartList(2000);
            
            if (me.buynow || Cart.data.type == 'installment')
            {
                me.goToCheckout();
            }

        });
        
    };
    
    me.goToCheckout = function() {
		var go_to = site_url;
		if(use_secure == '1')
		{
			go_to = secure_site_url;
		}
        window.location = go_to+'/'+currentLocale+'/checkout/step1';
    };
    
    me.showAlertDialog = function(title, msg) {
        
        if ( ! msg) return;
        
        $('.alert-title').text(__(title));
        $('.alert-message').text(__(msg));
        
        $('#cart-alert').reveal({
            animation: 'none',
            dismissmodalclass: 'popup_ok'
        });
    };
    
    me.showAddingDialog = function() {
        
        me.addingDialog.reveal({
            animation: 'none'
        });
        
    };
    
    me.hideAddingDialog = function() {
        
        me.addingDialog.trigger('reveal:close');
        
    };
    
//    me.countdown = function() {
//        
//        $('.time_group').each(function () {
//            var timeDiv = $(this);
//            
//            $(this).countdown({
//                until: timeDiv.attr('data-time'),
//                format: 'dHMs',
//                layout: '<div class="day">'
//            + '<div class="time_number">{d10}</div>'
//            + '<div class="time_number">{d1}</div>'
//            + '<div class="time_text">d</div>'
//            + '</div>'
//            + '<div class="time_space"></div>'
//            + '<div class="day">'
//            + '<div class="time_number">{h10}</div>'
//            + '<div class="time_number">{h1}</div>'
//            + '<div class="time_text">h</div>'
//            + '</div>'
//            + '<div class="time_space"></div>'
//            + '<div class="day">'
//            + '<div class="time_number">{m10}</div>'
//            + '<div class="time_number">{m1}</div>'
//            + '<div class="time_text">m</div>'
//            + '</div>'
//            + '<div class="time_space"></div>'
//            + '<div class="day">'
//            + '<div class="time_number">{s10}</div>'
//            + '<div class="time_number">{s1}</div>'
//            + '<div class="time_text">s</div>'
//            + '</div>'
//            });
//        });
//        
//    };
    
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

$(document).ready(function() { 
    Product.levelD.init();
});
