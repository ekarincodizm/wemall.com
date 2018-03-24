$(document).ready(function() {
	$('.ft-payment li a').click(function(e){
		var tmp_class 		= 	$(this).attr('class');
		var li_class 		=	tmp_class.replace("payment-channel ", "");
		console.log(li_class);
		
		switch(li_class)
		{
			case 'ch-atm':
				$( "#menu-atm" ).trigger( "click" );
				break;
			case 'ch-paymentcounter':
				$( "#menu-payment-counter" ).trigger( "click" );
				break;
			case 'ch-counterservice':
				$( "#menu-counter-service" ).trigger( "click" );
				break;
			case 'ch-ibanking':
				$( "#menu-ibanking" ).trigger( "click" );
				break;
			default:
				$( "#menu-atm" ).trigger( "click" );
				e.preventDefault();
		}
		
	});
        
        
        $('.main-link_payment li a').click(function(e){
            e.preventDefault();
            var a_href = $(this).attr('href');

            var payment_counter_patt = /\#payment-counter$/gi;
            var counter_service_patt = /\#counter-service$/gi;
            var ibanking_patt = /\#ibanking$/gi;

            if(payment_counter_patt.test(a_href)){
                $( "#menu-payment-counter" ).trigger( "click" );
            }else if(counter_service_patt.test(a_href)){
                $( "#menu-counter-service" ).trigger( "click" );
            }else if(ibanking_patt.test(a_href)){
                $( "#menu-ibanking" ).trigger( "click" );
            }else{
                $( "#menu-atm" ).trigger( "click" );
            }
		
	});
});