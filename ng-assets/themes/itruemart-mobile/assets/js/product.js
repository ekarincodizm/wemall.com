$(document).ready(function(){

    bindAddToCartButton();

    $campaign = $('#campaign');
    var len = $campaign.find('li').length;
    $campaign.bxSlider({
        autoHover: true,
        controls: false,
        infiniteLoop: len,
        auto: $campaign.find('li').length,
        preloadImages: 'visible'
    });

    productPkey = $('#campaign').attr('data-product-pkey');

    $.post(
        '/ajax/campaign/product/check-stock',
        {
            isAjax: true,
            nocache: $('#campaign').attr('data-no-cache'),
            data_inv_id: $('#container').attr('data-inv-id'),
            product_pkey: $('#campaign').attr('data-product-pkey')
        },
        function (data){
            if (data !=  undefined && data  != "" && data != NaN && data != null)
            {
                var jsonDecode = $.parseJSON(data); 

                if (jsonDecode.status == 200)
                {
                    if (jsonDecode.stock == 'out')
                    {
                        $('.style_types').css('display', 'none');
                        //$('.buy').css('display','none');
                        $('.btn-addcart').addClass('btn-disable').unbind('click');
                        $('.btn-blue-l-slide').addClass('btn-disable');
                        $('.soldout').css('display', 'inline');
                        return false;
                    }
                   
                    $('.btn-addcart').attr('data-inventory-id', jsonDecode.inventory_id);
                    
                    $('.style_types').find('ul').each(function(){
                        ul = $(this);
                        ul.find('li').each(function(){
                            li = $(this);
                            //alert(li.attr('data-pkey'));
                            $.each(jsonDecode.pkey_variants, function(i, v){
                                if (li.attr('data-pkey') == v)
                                {
                                    li.addClass('active');
                                    optionName = li.attr('data-option-name'); 
                                    li.parent().siblings('.option-name').html(optionName);
                                    if (li.parent().attr('data-media-set') == 1)
                                    {
                                        //console.log('media_set_pkey = ' + li.attr('data-pkey'));
                                        //console.log('product_pkey = ' + $('#campaign').attr('data-product-pkey'));
                                        //--- Get Images By Style Type ---//
                                        $.post(
                                            '/ajax/campaign/product/get-image',
                                            {
                                                isAjax: true,
                                                product_pkey: $('#campaign').attr('data-product-pkey'),
                                                media_set_pkey: li.attr('data-pkey')
                                            },
                                            function (data){
                                                if (data != undefined && data != "" && data != "" && data != NaN)
                                                {
                                                    var jsonDecode = $.parseJSON(data);

                                                    $('.btn-addcart').attr('data-inventory-id', jsonDecode.inventory_id);
                                                    //console.log(data);
                                                    $li = '';
                                                    $('.bx-wrapper').remove();
                                                    $li = '<ul id="campaign" data-product-pkey="'+productPkey+'">';
                                                    $.each(jsonDecode, function(i, v){
                                                        //console.log('i = ' + i + 'v = ' + v);
                                                        $li += '<li><a href="#"><img src="'+v.large+'"></a></li>'; 
                                                    });
                                                    $li += '</ul>';

                                                    $('.banner').append($li);

                                                    $campaign = $('#campaign');
                                                    var len = $campaign.find('li').length;
                                                    $campaign.bxSlider({
                                                        autoHover: true,
                                                        controls: false,
                                                        infiniteLoop: len,
                                                        auto: $campaign.find('li').length,
                                                        preloadImages: 'visible'
                                                    });
											
                                                }
                                            },
                                            'html'
                                            );
                                    }	
                                }

                            });
                        });
                    });					
                }
                else
                {
                //--- Blank ---// 
                }
            }
        },
        'html'
        );
	

    $('a.show_thumb').on('click', function(event){
        event.preventDefault(); 

        anchor = $(this);
        pathOriginal = anchor.siblings('img.path_original').attr('src');
        pathShow = anchor.siblings('img.path_show').attr('src');

        $('.product_img_big a.zoomer').attr('href', pathOriginal);
        $('.product_img_big a.zoomer img').attr('src', pathShow);

        if ($.browser.msie)
        {
            $('.product_img_big a.zoomer').jqzoom({
                zoomType: 'standard',
                lens:true,
                preloadImages: false,
                alwaysOn:false,
                zoomWidth: 300,
                zoomHeight: 300
            });
        }
        else
        {
            $('.product_img_big img').addimagezoom({ // single image zoom
                zoomrange: [2, 8],
                magnifiersize: [500,350],
                magnifierpos: 'right',
                cursorshade: true,
                largeimage: anchor.siblings('img.path_original').attr('src') //<-- No comma after last option!
            }); 
        }

    });

    $('.img_preview_content').bxSlider({
        slideWidth: 68,
        minSlides: 3,
        maxSlides: 3,
        slideMargin: 8,
        pager: false,
        moveSlide: 1,
        nextSelector: '#img_preview_prev',
        prevSelector: '#img_preview_next',
        nextText: '<img src="/assets/itruemart_new/images/product_preview_prv.jpg" alt="" />',
        prevText : '<img src="/assets/itruemart_new/images/product_preview_next.jpg" alt="" />',
        infiniteLoop:true,
        moveSlides: 1

			

    });
	


	


    $('.time_group').each(function(){
        var timeDiv = $(this);
		
        $(this).countdown({
            until: timeDiv.attr('data-time'),
            format: 'dHMs', 
            layout: '<div class="day">'
        + '<div class="time_number">{d10}</div>'
        + '<div class="time_number">{d1}</div>'
        + '<div class="time_text">d</div>'
        + '</div>'
        + '<div class="time_space"></div>'
        + '<div class="day">'
        + '<div class="time_number">{h10}</div>'
        + '<div class="time_number">{h1}</div>'
        + '<div class="time_text">h</div>'
        + '</div>'
        + '<div class="time_space"></div>'
        + '<div class="day">'
        + '<div class="time_number">{m10}</div>'
        + '<div class="time_number">{m1}</div>'
        + '<div class="time_text">m</div>'
        + '</div>'
        + '<div class="time_space"></div>'
        + '<div class="day">'
        + '<div class="time_number">{s10}</div>'
        + '<div class="time_number">{s1}</div>'
        + '<div class="time_text">s</div>'
        + '</div>'
        });
    }); 	

    $('.style-option').on('click', function(event){
        event.preventDefault();

        anchor = $(this);
		
        mediaSet = anchor.parent().attr('data-media-set');
        media_set_pkey = anchor.attr('data-pkey');
        //alert(mediaSet);
        productPkey = $('#campaign').attr('data-product-pkey');
		
        if ( ! anchor.hasClass('active'))
        {
            anchor.addClass('active');
            anchor.siblings('li').removeClass('active');
            anchor.parent().siblings('.option-name').html(anchor.attr('data-option-name'));

            option_pkey = {};
			
			
            //alert(0);
            $('.style_types').find('ul').each(function(i, v){
                ul = $(this);
                //console.log('pkey = ' + ul.children().attr('data-pkey'));
                //console.log('option-name = ' + ul.children().attr('data-option-name'));
                option_pkey[i] = ul.children('li.active').attr('data-pkey'); 
				
            });

            if (mediaSet == 1)
            {
                $.post(
                    '/ajax/campaign/product/get-image',
                    {
                        isAjax: true,
                        product_pkey : $('#campaign').attr("data-product-pkey"),
                        media_set_pkey: media_set_pkey
                    },
                    function (data){
                        if (data != undefined && data != "" && data != NaN && data != null)
                        {
                            var jsonDecode = $.parseJSON(data);
                            //console.log(data);
                            $('.bx-wrapper').remove();

                            $li = '<ul id="campaign" data-product-pkey="'+productPkey+'">';
                            $.each(jsonDecode, function(i, v){
                                //console.log('i = ' + i + 'v = ' + v);
                                $li += '<li><a href="#"><img src="'+v.large+'"></a></li>'; 
                            });
                            $li += '</ul>'; 

                            //console.log('$li = ' + $li);
                            $('.banner').append($li);
                            $campaign = $('#campaign');
                            var len = $campaign.find('li').length;
                            $campaign.bxSlider({
                                autoHover: true,
                                controls: false,
                                infiniteLoop: len,
                                auto: $campaign.find('li').length,
                                preloadImages: 'visible'
                            });
                        }
                    },
                    'html'
                    );
            }

            $.post(
                '/ajax/product/check-stock-by-variant',
                {
                    isAjax: true,
                    product_pkey: $('#campaign').attr('data-product-pkey'),
                    option_pkey: option_pkey
                },
                function (data){
					
                    if (data != undefined && data != null && data != "" && data != NaN)
                    {
                        var jsonDecode = $.parseJSON(data);
                        if (jsonDecode.code == 200)
                        {
                            if (jsonDecode.stock.toLowerCase() == 'out')
                            {
                                $('.soldout').css('display', 'inline');
                                //$('.btn-addcart').css('display', 'none');
                                //$('.btn-blue-l-slide').css('display', 'none');
                                $('.btn-addcart').addClass('btn-disable').unbind('click');
                                $('.btn-blue-l-slide').addClass('btn-disable');
                            }
                            else
                            {
                                $('.soldout').css('display', 'none');
                                //mediaSet = anchor.parent().attr('data-media-set');
                                //console.log('mediaSet = ' + mediaSet);


								
                                //$('.btn-addcart').css('display', 'inline');
                                //$('.btn-blue-l-slide').css('display', 'inline');
                                $('.btn-addcart').removeClass('btn-disable'); //.bind('click', function(){

                                //bindAddToCartButton();	
                                //});
                                $('.btn-blue-l-slide').removeClass('btn-disable'); 
                                $('.btn-addcart').attr('data-inventory-id', jsonDecode.inventory_id); 
										
                            }
							
								
                        }
                        else
                        {

                        }
                    }		
                },
                'html'
				
                );		
        }
    });

    $('.btn-blue-l-slide').on('click', function () {
        $('.add_cart').trigger('click');
    });
	
	$('#go_checkout').on('click', function () {
        window.location.href = '/'+currentLocale+'/checkout1';
    });

	$('.cart-installment-button_next').on('click', function () {
		var add_type = $('input[name=cart-installment-select]:checked').val();
        var inventory_id = $('.btn-addcart').attr('data-inventory-id');
		
		$('#cart-adding').reveal({
			animation: 'none'
		});
		
		$.get(
			'/ajax/cart',
			{
			},
			function (cart_data){
				if(cart_data.data.totalItem != null && cart_data.data.totalItem != undefined && cart_data.data.type != null && cart_data.data.type != undefined )
				{
					$('#cart-adding').trigger('reveal:close');
					$('#cart-select-installment').trigger('reveal:close');
					
					if(add_type == 'installment')
					{
						if(cart_data.data.totalItem > 0 && cart_data.data.type == 'installment')
						{
							$('.alert-title').text("ข้อความ");
							$('.alert-message').text(__('cannot-add-installment'));

							$('#cart-alert').reveal({
								animation: 'none',
								dismissmodalclass: 'popup_ok'
							});
						}
						else if(cart_data.data.totalItem > 0 && cart_data.data.type == 'normal')
						{
							$('.alert-title').text("ข้อความ");
							$('.alert-message').text(__('cannot-add-installment'));

							$('#cart-alert').reveal({
								animation: 'none',
								dismissmodalclass: 'popup_ok'
							});
						}
						else
						{
							$('#cart-adding').reveal({
								animation: 'none'
							});
							call_add_cart(inventory_id, add_type);
						}
					}
					else
					{
						if(cart_data.data.totalItem > 0 && cart_data.data.type == 'installment')
						{
							$('.alert-title').text("ข้อความ");
							$('.alert-message').text(__('cannot-add-installment'));

							$('#cart-alert').reveal({
								animation: 'none',
								dismissmodalclass: 'popup_ok'
							});
						}
						else
						{
							$('.alert-title').text(__("choose-payment-terms"));
							$('#cart-adding').reveal({
								animation: 'none'
							});
							call_add_cart(inventory_id, add_type);
						}
					}
				}
			}
		);
		
    });
});


function bindAddToCartButton()
{
    //--- Add to cart ---//
    $('.btn-addcart').click(function(event){
        event.preventDefault();
		
        button = $(this);

        inventory_id = button.attr('data-inventory-id');
		
        if (button != null && button != undefined && button != "" && button != NaN)
        {
			var data_installment = "false";//$(this).attr('data-allow-installment');
			
			var product_type = 'normal';
			var add_type = 'normal';
			
			if(data_installment == 'true')
			{
				product_type = 'installment';
			}
			
			// check cart before add
			$('#cart-adding').reveal({
				animation: 'none'
			});
			
			$.get(
				'/ajax/cart',
				{
				},
				function (cart_data){
					if(cart_data.data.totalItem != null && cart_data.data.totalItem != undefined && cart_data.data.type != null && cart_data.data.type != undefined )
					{
						if(product_type == 'normal')
						{
							if(cart_data.data.totalItem > 0 && cart_data.data.type == 'installment')
							{
								$('.alert-title').text("ข้อความ");
								$('.alert-message').text(__('cannot-add-installment'));

								$('#cart-alert').reveal({
									animation: 'none',
									dismissmodalclass: 'popup_ok'
								});
							}
							else
							{
								$('#cart-adding').reveal({
									animation: 'none'
								});
								call_add_cart(inventory_id, add_type);
							}
						}
						else
						{
							$('#cart-adding').trigger('reveal:close');
							$('#cart-select-installment').reveal({
								animation: 'none'
							});
						}
					}
				}
			);
        }		
    });
}

function call_add_cart(inventory_id, add_type)
{
	$.post(
	'/ajax/cart/add-item',
	{
		inventory_id: inventory_id,
		qty: $('#qty').val(),
		type: add_type
	},
	function (data){

		if (data != null && data != undefined && data != NaN && data != "")
		{
			$('#cart-adding').trigger('reveal:close');
			jsonDecode = $.parseJSON(data);
			console.log(jsonDecode);

			if (jsonDecode.status == 'success')
			{
				$('.alert-title').text("ข้อความ");
				$('.alert-message').text("เพิ่มสินค้าเข้าตะกร้าเรียบร้อยแล้ว");
				
				/*
				$('#cart-alert').reveal({
					animation: 'none',
					dismissmodalclass: 'popup_ok'
				});
				*/

				window.location.href = '/'+currentLocale+'/checkout1';
			}
			else
			{
				$('.alert-title').text(__("cannot-add"));
				if (jsonDecode.message != undefined && jsonDecode.message != "")
				{
					$('.alert-message').text(__(jsonDecode.message));
				}
				else
				{
					$('.alert-message').text('สินค้าในสต็อกเหลือไม่เพียงพอ');
				}				
				
				
				$('#cart-alert').reveal({
					animation: 'none',
					dismissmodalclass: 'popup_ok'
				});
			}
		}
	},
	'html'
	);
}