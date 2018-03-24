require(['lib/jquery.countdown.min','controller/imgLazyLoad'], function(countdown, imgLazyLoad){
	$('[data-countdown]').each(function(){
		var $this = $(this), finalDate = $this.data('countdown');
		var _idx = $('[data-countdown]').index(this);
		$this.countdown(finalDate, function(event){
			var _format = '%H<span class="cln">:</span>%M<span class="cln">:</span>%S';
			if(event.offset.days > 0){
				_format= '%-d<span class="cln">:</span>%!d' + _format;
			}
			$this.html(event.strftime(_format));
		}).on('finish.countdown', function(event){
			if(_idx == 0) {
				return;
			}

			var _btnDisabled = $('<span class="btn-disabled"></span>').text('หมดโปรโมชั่น');
			var _boxExpire = $('<div class="box-action-disabled"></div>').append(_btnDisabled);
			var _bgWrapper = $('<div class="bg-wrapper"></div>');

			if(!$this.closest('.sd-product-info').is('.disabled')){
				$this.closest('.sd-product-info')
				.addClass('disabled')
				.append(_bgWrapper)
				.append(_boxExpire);
			}
		});
	});
});