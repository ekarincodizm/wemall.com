$(function(){
	$('.signup').click(function(event){
		event.preventDefault();
		window.location.href = $(this).attr('data-href');

	});


	$('.buy_now').click(function(event){
		event.preventDefault();
		window.location.href = $(this).attr('data-href');
	});



});



/**
 * Forget password pop up.
 *
 * @return void
 */
var forgetPassword = function() {
    url = 'http://trueid.truelife.com/userv4/forgot_password/th';

    popupWindow = window.open(url,'popUpWindow','height=600,width=1000,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes');
}