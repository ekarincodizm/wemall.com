var Product = Product || {};

Product.Profile = (function($) {
    
    var me = me || {};

    me.showAlertDialog = function(title, msg) {
        
        if ( ! msg) return;
        
        $('#cart-alert-v2 .alert-title').text(__(title));
        $('#cart-alert-v2 .alert-message').text(__(msg));
        
        $('#cart-alert-v2').reveal({
            animation: 'none',
            dismissmodalclass: 'popup_ok'
        });
    };

    me.init = function(){
     //   $(".btn-id-card").on('click', function(){
    //
     //       var id_card = $("#id_card").val();
     //       if (id_card == null || id_card == "")
     //       {
     //               // modal
     //               me.showAlertDialog('รหัสบัตรประชาชน','กรุณากรอกรหัสบัตรประชาชน');
     //               return false;
     //       }
     //       else if (id_card.length != 13 || isNaN(id_card))
     //       {
     //               me.showAlertDialog('รหัสบัตรประชาชน','รหัสบัตรประชาชนควรจะเป็นตัวเลข 13 หลัก');
     //               return false;
     //       }
     //       $("#your_id_card_number").html(id_card);
     //       $("#myForm").hide();
     //       $("#id-card-confirm").show();
    //
	//});
    //
	//$("#confirm-button").on("click", function(){
	//	$("#myForm").submit();
	//});
	//$("#cancel-button").on("click", function(){
	//	location.reload();
	//});
    }
    return me;
    
})(jQuery);

$(document).ready(function() {
    
    Product.Profile.init();
    
});

