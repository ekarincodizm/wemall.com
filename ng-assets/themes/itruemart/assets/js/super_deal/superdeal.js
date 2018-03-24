	
	$(function(){
		$('img.lazyload').lazyload({
			threshold: 200,
			effect: 'fadeIn'
		});
	
		$('[data-countdown]').each(function(){
			var $this = $(this), finalDate = $this.data('countdown');
			var _idx = $('[data-countdown]').index(this);
			$this.countdown(finalDate, function(event){
				var totalHours = event.offset.totalDays * 24 + event.offset.hours;
				var _format = totalHours + '<span class="cln">:</span>%M<span class="cln">:</span>%S ชม.';
				//if(event.offset.days > 0){
					//_format= '%-d<span class="cln">:</span>%!d' + _format;
				//}
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
		
		var touch_pos = null;
		$('.sd-product-info a').on('touchstart', function(e){					
		touch_pos = $(window).scrollTop();
					
		}).on("touchend", function(e){		
			if(e.type == 'touchend' && Math.abs(touch_pos-$(window).scrollTop()) > 3){
				return false;
			}					
			var _url = $(this).attr('href');
			//location.href = _url;
		});
		
	});