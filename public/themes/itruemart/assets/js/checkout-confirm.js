var Checkout = Checkout || {};

Checkout.Confirm = (function($) {
    
    var me = me || {};
    
    me.init = function ()
    {
        $('body').on('remove-item', function() {
            
            window.location.href = '/'+currentLocale+'/checkout';
            
        });
        
        me.setPaymentInfo();
        
        $('[name="payment_channel"]').on('click', function() {
            
            var label = $(this).siblings('label:first').html();
            
            $('#payment-select-show').html(label);
            
        });
        
        $('#form-coupon').on('submit', function() {
            
            if ( ! me.validateCoupon())
            {
                return false;
            }
            
        });
        
        $('.btn-paid').on('click', function() {
            
            me.savePaymentMethod();
            
            me.goToProcess();
            
        });
        
        $('.remove-coupon').on('click', function() {
            
            me.removeCoupon($(this));
            
        });
    };
    
    me.validateCoupon = function()
    {
        var code = $('.checkout-coupon').val();
        
        if (code == '')
        {
            me.showAlertDialog('ไม่สามารถดำเนินการได้', 'กรุณากรอกคูปองให้ถูกต้อง');
            
            return false;
        }
        
        return true;
        
    };
    
    me.setPaymentInfo = function()
    {
        var payment_method = Checkout.data.payment_method;
        
        if ( ! payment_method)
        {
            $('[name="payment_channel"]:first').prop('checked', true).click();
        }
        else
        {
            $('[name="payment_channel"][value="'+payment_method+'"]').prop('checked', true).click();
        }

        if (payment_method == '156813837979402')
        {
            var period = Checkout.data.installment.period;
            $('[name="installment"][value="'+period+'"]').prop('checked', true).click();
        }
    };
    
    me.savePaymentMethod = function()
    {
        var payment_method = $('[name="payment_channel"]:checked').val();
        var installment = $('[name="installment"]:checked').val();
        
        $.ajax({
            async: false,
            type: 'POST',
            url: '/ajax/checkout/set-payment-info',
            data: {
                payment_method: payment_method,
                installment: installment
            },
            success: function(response) {

            }
        });
        
    };
    
    me.removeCoupon = function(elm)
    {
        var code = elm.data('code');
        
        elm.parent().fadeOut('slow', function() {
            
           $(this).remove(); 
            
        });
        
        $.ajax({
            async: true,
            type: 'POST',
            url: '/ajax/cart/remove-coupon',
            data: {
                code: code
            },
            success: function(response) {
                
                window.location.reload();
                
            }
        });
    };
    
    me.goToProcess = function() {
        
        window.location.href = '/checkout/process';
        
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

    return me;

})(jQuery);
$(function() {

    Checkout.Confirm.init();

});