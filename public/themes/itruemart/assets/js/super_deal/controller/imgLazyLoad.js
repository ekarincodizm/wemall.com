require(['lib/jquery.lazyload.min'], function(lazyload){
	$('img.lazyload').lazyload({
		threshold: 200,
		effect: 'fadeIn'
	});
});