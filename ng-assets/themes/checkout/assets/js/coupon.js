var Coupon = Coupon || {};

Coupon.Remove = (function($) {
    
    var me = me || {};
    
    me.init = function ()
    {
        $('.remove-coupon').on('click', function() {
            
            me.removeCoupon($(this));
            
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
	
    return me;

})(jQuery);

$(function() {

    Coupon.Remove.init();

});