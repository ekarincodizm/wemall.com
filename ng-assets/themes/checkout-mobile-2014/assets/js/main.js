/* jshint devel:true */

$(document).ready(function () {

// || animate radio button effect ||
// functions scrolls to #{blah}link
    function goToByScroll(id) {
        // Scroll
        $('html,body').animate({
                scrollTop: $("#" + id).offset().top
            },
            'slow');
    }

// function for collapseExpand box
    function collapseExpandPayment(payment_name) {
        if ($("#box-" + payment_name).css("display") == "block") {
            $(".divider-menu").slideUp("fast"); //Hide other box
            $(".payment-channel>input").prop('checked', false);
        } else {
            $(".divider-menu").hide(); //Hide other box
            $("#box-" + payment_name).show(); //Slide Down Effect
            goToByScroll(payment_name);
        }
    }

//hide all box first.
    $(".divider-menu").hide();
//when user click -> animate function
    $(".payment-channel>input").click(function () {
        var payment = $('input[name=payment_channel]:checked').val();
        collapseExpandPayment(payment);
    });

//init msdropdown | for dropdown in Installment
    $(".bank-dd-list").msDropDown();

//show/hide dropdown bank detail
    $(".bank-installment-detail").hide();
//detect the change event on dropdown .bank-dd-list
    $('.bank-dd-list').change(function () {
        if (document.getElementById("dd-list-option").selected != true) {
            $(".bank-installment-detail").show();
        }
    });

//Popup confirm
    $('#btn-delete-cart-popup').click(function () {
        //hide the current popup
        $('.modal').modal('hide');
        //show the confirm popup
        $('#confirm-message').modal('show');
    });

//Checkbox tax address
    $('.address-tax-field').hide();
    $('#address-tax').change(function () {
        if ($(this).is(':checked')) {
            //Slide up
            $('.address-tax-field').slideUp();
        } else {
            //Slide down
            $('.address-tax-field').slideDown();
        }
    });

//script for animate processing button ดำเนินการ
    var terms = [__("proceeding-to-nextstep-0"), __("proceeding-to-nextstep-1"), __("proceeding-to-nextstep-2"), __("proceeding-to-nextstep-3")];

    window.loopProcess = function () {
        var processButton = $('.button-buy .button span');
        var ct = processButton.data("term") || 0;
        processButton.data("term", ct == terms.length - 1 ? 0 : ct + 1).text(terms[ct]).show()
            .delay(250).show(200, loopProcess);
    };
//
//    $('.button-buy a').click(function () {
//
//        var isValid = true;
//        $("")
//
//        if(!$(".button-buy").hasClass("disable")){
//            $('.button-buy .button').html('<span class="button-processing-green"></span>');
//            $('.button-buy .button').css({"text-align": "left"});
//            loopProcess();
//        }
//    });

    //switch enable/disable coupon button
    function enableCoupon() {
        if ($('#coupon-text').val().length == 0) {
            $('.coupon-box').addClass("disable");
        } else {
            $('.coupon-box').removeClass("disable");
        }
    }

    $('#coupon-text').change(enableCoupon);
    $('#coupon-text').keyup(enableCoupon);

    $(".address-list>input").click(function () {
        $(".address-list").removeClass("selected");
        $(this).parent().addClass("selected");
    });
});
