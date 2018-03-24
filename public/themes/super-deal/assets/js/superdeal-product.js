var SuperDeal = SuperDeal || {};
SuperDeal.Product = (function($) {
    var me = me || {};
        
    me.addingDialog = null;
    me.installmentDialog = null;
    me.selectInstallmentDialog = null;
    
    me.init = function() {
        me.addingDialog = $('#cart-adding');
        me.installmentDialog = $('#cart-installment');
        me.selectInstallmentDialog = $('#cart-select-installment');
        
        $(document).bind('cart:addedItem', function(e, response) {
            me.showLightbox(response);
        });
    };
    
        
    me.showAddingDialog = function() {
        me.addingDialog.reveal({
            animation: 'none',
            closeonbackgroundclick:false
        });
    };

    me.hideAddingDialog = function() {
        me.addingDialog.trigger('reveal:close');
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
    
    me.startAddToCart = function(that) {

        var inventory_id = $(that).data('inventory-id');

        if ( ! inventory_id)
        {
            //me.showAlertDialog('ไม่สามารถนำสินค้าชิ้นนี้ใส่ตะกร้าได้', 'กรุณาเลือก option ของสินค้าก่อน');
            me.showAlertDialog('ไม่สามารถนำสินค้าชิ้นนี้ใส่ตะกร้าได้', 'สินค้าหมด');

            return;
        }

        if (inventory_id == 'out_of_order' || $('.out_of_stock:visible').length != 0)
        {
            me.showAlertDialog('ไม่สามารถนำสินค้าชิ้นนี้ใส่ตะกร้าได้', 'สินค้าหมด');
            return;
        }

        me.showInstallmentDialog(that);

    };
    
    me.showInstallmentDialog = function(that) {

        var cartAddable;
        var item_installment = $(that).data('allow-installment');
        var productTitle = $(that).data("product-title");
        var productImage = $(that).data("image");

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
        $(".product-image-dialog").attr("src", productImage);
        $(".product-title").html(productTitle);

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
            
            me.installmentDialog.reveal(revealConfig);
        }
        else
        {
            if (item_installment == true)
            {
                //add installment lightbox.
                me.selectInstallmentDialog.reveal(revealConfig);

                $('.cart-installment-button_next').on('click', function() {

                    me.selectInstallmentDialog.trigger('reveal:close');

                    var type = $('.cart-installment-select:checked').val();

                    if (type == 'normal' || Cart.data.cart_details.length == 0)
                    {
                        me.addItem(that);
                    }
                    else
                    {
                        $('.installment_message_1').show();
                        $('.cart-installment-button_add').show();
                        $('.cart-installment-button_cancel').show();

                        $('.cart-installment-button_add').on('click', function() {

                            $('.cart-installment-select[name="cart-installment-select"]').val('normal');
                            me.addItem(that);

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
                //add normal cart
                me.addItem(that);
            }
        }
    };
    
    me.addItem = function(that) {

        me.installmentDialog.trigger('reveal:close');

        me.showAddingDialog();

        var response;

        var inventory_id = $(that).data('inventory-id');
        var qty = 1; //$('.product-qty').val();

        if ( ! inventory_id)
        {
            me.showAlertDialog('กรุณาเลือก option ของสินค้าก่อน');

            return;
        }
        
        var type = $('.cart-installment-select:checked').val();

        var data = {
            inventory_id: inventory_id,
            qty: qty,
            type: type
        };

        $.ajax({
            async: false,
            type : 'POST',
            url : '/ajax/cart/add-item?' + $.param(data),
            data : {},
            success: function(r) {
                me.hideAddingDialog();
                if (r.status == 'error')
                {
                    me.showAlertDialog(__('ไม่สามารถเพิ่มสินค้าได้'), __(r.message));
                }
                else
                {
                    response = r;
                    $(document).trigger('cart:addedItem', [response]);
                }
            }
        });

    };
    
    me.showLightbox = function (response) {
        
        Cart.data = eval(response.data);
        Product.Cart.renderCartList();

        //trigger refresh full cart lightbox.
        if(Cart.data.type == 'normal'){
            me.cartLightbox();
        }
 
        if (Cart.data.type == 'installment')
        {
            me.selectPaymethodMethod();
            me.goToCheckout();
        }
    };
    
    // when it's done. Show cart lightbox
    me.cartLightbox = function(){
        $(document).trigger('refresh-cart-lightbox');
        $('.topright-cart-btn').trigger("click");
    };

    me.goToCheckout = function() {
        location.href = '/'+LANG+'/checkout/step1';
    };
    
    me.selectPaymethodMethod = function(){
        var pkey_channel = '156813837979402';
        
        $.ajax({
            async: false,
            type : 'POST',
            url : '/ajax/checkout/set-payment-info',
            data: {
                payment_method: pkey_channel
            },
            success: function(data){
            }
        });
    }
        
    return me;
})(jQuery);
    
    
$(document).ready(function(){
    SuperDeal.Product.init();
});
