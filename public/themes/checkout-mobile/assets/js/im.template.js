var isShow = false;
var idx_navi = 0;
var btnNavi;
$(function () {
    btnNavi = 'div#navigation ul li a';
    $(btnNavi).click(function (event) {
        $(this).addClass('actived');
        $(btnNavi).eq(idx_navi).removeClass('actived');
        idx_navi = $(this).index(btnNavi);
        $('div.search-container-xs').hide();
        switch (idx_navi) {
            case 1: $('div.search-container-xs').show(); break;
        }
        event.preventDefault();
    });

    $('.payment-channel > label, .payment-channel > input[type="radio"]').click(function () {
        var remarkLen = $('.add-remark').length;
        var $remark = $(this).parent().find('.add-remark');
        if ($remark.is(':visible'))
            return;

        $(this).parent().find('input[type="radio"]').attr('checked', 'checked');
        $('.add-remark').slideUp().parent().removeClass('divider-menu-active');
        $remark.parent().addClass('divider-menu-active');
        $remark.slideDown();
    });

    $('.how-to a').click(function (event) {
        event.preventDefault();
        var $li = $(this).parent();
        var idx = $li.index('.how-to li');
        $('.how-to li').removeClass('active');
        $(this).parent().addClass('active');
        $('.how-to-desc').hide().eq(idx).show();
    });

    CHECKOUT.instalment;
});

var CHECKOUT = CHECKOUT || {}

CHECKOUT.instalment = (function(){
    var $bank = $('.bank'), $paymentList;
    $bank.each(function(){
        $(this).on('click', function(){
			$paymentList = $(this).parent().find('.instalment-list');
			if($paymentList.is(':visible'))
				return;
				
			$paymentList.slideUp();
			$(this).parent().find('.instalment-list').slideDown();
		});
    });
})();