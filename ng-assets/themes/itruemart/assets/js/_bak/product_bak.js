(function ($) {
    $.fn.ProductControls = function () {
        var prevType = 'zoom';
        var $previousView = $('.product_img_big');
        var $currentView;
		var vdo;
        var methods = {
            RemoveMultiZoom: function () {
                $('div.magnifyarea, div.cursorshade, div.zoomstatus, div.zoomtracker, .product_img_big, .img_preview_wrapper').hide();
            },
            Remove_360Degree: function () {
                var $product360Degree = $('.product_360degree-container');
                /*if($('.product_360degree').parent().is('div')){
                $('.product_360degree').unwrap();
                }*/
                $product360Degree.hide();
            },
            Remove_VDO: function () {
                vdo = $('.vdo-container').hide().find('.vdo-inner').html();
                $('.vdo-container').find('.vdo-inner').html(vdo);
            },
            Init_Zoom: function () {
                if ($.browser.msie) {
                    $('.product_img_big a.zoomer').jqzoom({
                        zoomType: 'standard',
                        lens: true,
                        preloadImages: false,
                        alwaysOn: false,
                        zoomWidth: 300,
                        zoomHeight: 300
                    });
                }
                else {
                    $('.product_img_big img').addimagezoom({ // single image zoom
                        zoomrange: [2, 8],
                        magnifiersize: [500, 350],
                        magnifierpos: 'right',
                        cursorshade: true,
                        largeimage: $('.product_img_big a').attr('href') //<-- No comma after last option!
                    });
                    $('div.cursorshade.featuredimagezoomerhidden').live('mouseover', function () {
                        $(this).draggable({ containment: 'div.zoomtracker', scroll: false });
                    });
                }
                $('.product_img_big, .img_preview_wrapper').show();
            },
            Init_360Degree: function () {
                var arr = [];
                for (var x = 0; x <= 35; x++)
                    arr.push(x);

                $(".product_360degree").threesixty({ images: arr, method: 'mousemove', direction: 'backward', sensibility: 1 });
                $('.product_360degree-container').show();
            },
            Init_VDO: function () {
                $('.vdo-container').show();
            }
        }

        return this.each(function () {
            $(this).find('a').bind('click', function () {
                var type = $(this).attr('rel');

                switch (prevType) {
                    case 'zoom':
                        methods.RemoveMultiZoom();
                        break;
                    case '360':
                        methods.Remove_360Degree();
                        break;
                    case 'vdo':
                        methods.Remove_VDO();
                        break;
                    default: break;
                }

                switch (type) {
                    case 'zoom':
                        methods.Init_Zoom();
                        break;
                    case '360':
                        methods.Init_360Degree();
                        break;
                    case 'vdo':
                        methods.Init_VDO();
                        break;
                    default: $currentView = undefined; break;
                }
                prevType = type;
            });
        });
    };
})(jQuery);

$(document).ready(function () {

	$('.product-control').ProductControls();

    if ($.browser.msie) {
        $('.product_img_big a.zoomer').jqzoom({
            zoomType: 'standard',
            lens: true,
            preloadImages: false,
            alwaysOn: false,
            zoomWidth: 300,
            zoomHeight: 300
        });
    }
    else {

        $('.product_img_big img').addimagezoom({ // single image zoom
            zoomrange: [2, 8],
            magnifiersize: [500, 350],
            magnifierpos: 'right',
            cursorshade: true,
            largeimage: $('.product_img_big a').attr('href') //<-- No comma after last option!
        });
        $('div.cursorshade.featuredimagezoomerhidden').live('mouseover', function () {
            $(this).draggable({ containment: 'div.zoomtracker', scroll: false });
        });
    }

    //Touch Screen
    $('a.show_thumb').on('touchstart', function (event) {
        event.preventDefault();

        anchor = $(this);
        pathOriginal = anchor.siblings('img.path_original').attr('src');
        pathShow = anchor.siblings('img.path_show').attr('src');

        $('.product_img_big a.zoomer').attr('href', pathOriginal);
        $('.product_img_big a.zoomer img').attr('src', pathShow);

        if ($.browser.msie) {
            $('.product_img_big a.zoomer').jqzoom({
                zoomType: 'standard',
                lens: true,
                preloadImages: false,
                alwaysOn: false,
                zoomWidth: 300,
                zoomHeight: 300
            });
        }
        else {
            $('.product_img_big img').addimagezoom({ // single image zoom
                zoomrange: [2, 8],
                magnifiersize: [500, 350],
                magnifierpos: 'right',
                cursorshade: true,
                largeimage: anchor.siblings('img.path_original').attr('src') //<-- No comma after last option!
            });
        }

    });
    // end
    $('a.show_thumb').live('mouseover', function (event) {
        event.preventDefault();

        anchor = $(this);
        pathOriginal = anchor.siblings('img.path_original').attr('src');
        pathShow = anchor.siblings('img.path_show').attr('src');

        $('.product_img_big a.zoomer').attr('href', pathOriginal);
        $('.product_img_big a.zoomer img').attr('src', pathShow);

        if ($.browser.msie) {
            $('.product_img_big a.zoomer').jqzoom({
                zoomType: 'standard',
                lens: true,
                preloadImages: false,
                alwaysOn: false,
                zoomWidth: 300,
                zoomHeight: 300
            });
        }
        else {
            $('.product_img_big img').addimagezoom({ // single image zoom
                zoomrange: [2, 8],
                magnifiersize: [500, 350],
                magnifierpos: 'right',
                cursorshade: true,
                largeimage: anchor.siblings('img.path_original').attr('src') //<-- No comma after last option!
            });
        }

    });



    /***
    $('.slide_container').bxSlider({
    slideWidth: 68,
    minSlides: 3,
    maxSlides: 3,
    slideMargin: 8,
    pager: false,
    moveSlide: 1,
    nextSelector: '#product_preview_prv',
    prevSelector: '#product_preview_next',
    nextText: '<img src="'+site_url+'assets/itruemart_new/images/product_preview_prv.jpg" alt="" />',
    prevText : '<img src="'+site_url+'assets/itruemart_new/images/product_preview_next.jpg" alt="" />',
    infiniteLoop:true,
    moveSlides: 1
    });
    **/
	var color = $('.product_color .active .select_color').attr('data');
	if(color)
	{
		var item_clone = $('.img_preview_wrapper .img_preview_content').clone();
		var item_show = item_clone.find('li[data-color='+color+']').remove().end();
		$('.img_preview_wrapper .img_preview_content li[data-color!='+color+']').remove();
	}

    $('.img_preview_content').each(function(i) {

      var o = this;
      $(o).bxSlider({
          slideWidth: 68,
          minSlides: 3,
          maxSlides: 3,
          slideMargin: 8,
          pager: false,
          moveSlide: 1,
          nextSelector: '#img_preview_prev_'+i,
          prevSelector: '#img_preview_next_'+i,
          nextText: '<img src="' + site_url + 'assets/itruemart_new/images/product_preview_prv.jpg" alt="" />',
          prevText: '<img src="' + site_url + 'assets/itruemart_new/images/product_preview_next.jpg" alt="" />',
          infiniteLoop: true,
          moveSlides: 1,
          onSliderLoad: function() {
            var p = $(o).parents('.img_preview_wrapper');
            if(p.hasClass('other-images'))
              p.hide();
          }
      });
    });

  //});

	if(color)
	{
		$('.img_preview_wrapper .img_preview_content').append(item_show.html());
	}

    var thumbnailTimeOut;
    $('#img_preview_next').on('touchstart mouseover', function () {
        GoToPrevSlide();
    }).mouseout(function () {
        clearTimeout(thumbnailTimeOut);
    });
    $('#img_preview_prev').on('touchstart mouseover', function () {
        GoToNextSlide();
    }).mouseout(function () {
        clearTimeout(thumbnailTimeOut);
    }); ;

    function GoToPrevSlide() {
        imgPreviewContent.goToPrevSlide();
        clearTimeout(thumbnailTimeOut);
        thumbnailTimeOut = setTimeout(GoToPrevSlide, 1000);
    }
    function GoToNextSlide() {
        imgPreviewContent.goToNextSlide();
        clearTimeout(thumbnailTimeOut);
        thumbnailTimeOut = setTimeout(GoToNextSlide, 1000);
    }

   //  //--- Select Color ---//
   //  $('.select_color').live('click', function (event) {
   //      event.preventDefault();

   //      anchor = $(this);
   //      //--- Not active ---//
   //      if (!anchor.parent().hasClass('active')) {
   //          $('span.color_name').html(anchor.attr('title'));
   //          anchor.parent().siblings('div.box_list').removeClass('active');
   //          anchor.parent().addClass('active');

   //          color_id = anchor.attr('data');
   //          size_id = $('.product_size div#size-' + color_id).find('.active').children().attr('data');
   //          //var img_path = $('.img_preview_content li[data-color='+color_id+'] a.show_thumb').siblings('img.path_original').attr('src');

   //          //var img_path_show = $('.img_preview_content li[data-color='+color_id+'] a.show_thumb').siblings('img.path_show').attr('src');
   //          var img_path_show = $('#img_path_by_color-' + color_id).val();
   //          var img_path = $('#img_original_by_color-' + color_id).val();
   //          //alert(img_path);
   //          $('.product_img_big .path_original').attr('src', img_path);

			// var clone = $('.img_preview_wrapper .img_preview_content').clone();
			// var item = clone.find('li[data-color='+color_id+']').remove().end();
			// //var item = $('.img_preview_wrapper .img_preview_content').find('li[data-color!='+color_id+']').parent().html();
			// $('.img_preview_wrapper .img_preview_content li[data-color!='+color_id+']').remove();
			// imgPreviewContent.reloadSlider();
			// $('.img_preview_wrapper .img_preview_content').append(item.html());

   //          $('.product_size div.color_of_size').css('display', 'none');
   //          $('.product_size div#size-' + color_id).css('display', 'block');
   //          $('.status_type').html('<img src="' + site_url + 'assets/itruemart_new/images/cart/ajax-loader.gif" alt="">');

   //          if ($.browser.msie) {
   //              $('.product_img_big a.zoomer').attr('href', img_path);
   //              $('.product_img_big a.zoomer img').attr('src', img_path);

   //              $('.product_img_big a.zoomer').jqzoom({
   //                  zoomType: 'standard',
   //                  lens: true,
   //                  preloadImages: false,
   //                  alwaysOn: false,
   //                  zoomWidth: 300,
   //                  zoomHeight: 300
   //              });

   //          }
   //          else {
   //              $('.product_img_big img').addimagezoom({ // single image zoom
   //                  zoomrange: [2, 8],
   //                  magnifiersize: [500, 350],
   //                  magnifierpos: 'right',
   //                  cursorshade: true,
   //                  largeimage: $('img.thumb_original').attr('src') //<-- No comma after last option!
   //              });
   //          }

   //          $.post(
			// 	anchor.attr('href'),
			// 	{
			// 	    is_ajax: true,
			// 	    color_id: color_id,
			// 	    size_id: size_id
			// 	},
			// 	function (data) {
			// 	    if (data != undefined && data != null) {
			// 	        var jsonDecode = $.parseJSON(data);
			// 	        if (jsonDecode.status == true) {
			// 				//--- Hidden Fields iTruemart Stock ---//
			// 				//alert(jsonDecode.quantity);
			// 				$('#hidden_itm_stock').val(jsonDecode.quantity);
			// 				$('#hidden_supply_chain_stock').val(jsonDecode.supply_chain_quantity);

			// 	            //--- Set Text (In stock or Out of stock ---//
			// 	            $('.status_type').html(jsonDecode.btn_txt);

			// 	            //--- remove both class (Instock and out of stock)  and add new class that call back from Ajax ---//
			// 	            $('.status_type').removeClass('instock').removeClass('out_of_stock').addClass(jsonDecode.btn_class);

			// 	            //--- Get Href from add_cart button ---//
			// 	            cartHref = $('a.add_cart').attr('href').split("/");

			// 	            //--- Set last segment (inv_id) with inv_id that received from call back ---//
			// 	            cartHref[cartHref.length - 1] = jsonDecode.inv_id;

			// 	            //--- Join array to string (/)   with .join function ---//
			// 	            cartHref = cartHref.join("/");

			// 	            //--- Set New href to add_cart button ---//
			// 	            $('a.add_cart').attr('href', cartHref);
			// 				$('a.add_now').attr('href', cartHref);

			// 				bulkHref = $('a.bulksale').attr('href').split("&inventory_id=");
			// 				bulkHref[bulkHref.length - 1] = jsonDecode.inv_id;
			// 				bulkHref = bulkHref.join("&inventory_id=");
			// 				$('a.bulksale').attr('href', bulkHref);
			// 	        }
			// 	        else {
			// 	        }
			// 	    }
			// 	},
			// 	'html'
			// );
   //      }
   //      //--- Not Active ---//
   //  });

   //  //--- Select Size ---//
   //  $('.select_size').click(function (event) {
   //      event.preventDefault();
   //      anchor = $(this);
   //      //--- Not Active ---//
   //      if (!anchor.parent().hasClass('active')) {
   //          $('span.size_name').html(anchor.attr('title'));
   //          anchor.parent().siblings('div.box_list').removeClass('active');
   //          anchor.parent().addClass('active');
   //          $('.status_type').html('<img src="' + site_url + 'assets/itruemart_new/images/cart/ajax-loader.gif" alt="">');
   //          color_id = $('.product_color').find('.active').children().attr('data');
   //          size_id = anchor.attr('data');
   //          $.post(
			// 	anchor.attr('href'),
			// 	{
			// 	    is_ajax: true,
			// 	    color_id: color_id,
			// 	    size_id: size_id
			// 	},
			// 	function (data) {
			// 	    if (data != undefined && data != null) {
			// 	        var jsonDecode = $.parseJSON(data);
			// 	        if (jsonDecode.status == true) {

			// 				//--- Hidden Fields iTruemart Stock ---//
			// 				//alert(jsonDecode.quantity);
			// 				$('#hidden_itm_stock').val(jsonDecode.quantity);
			// 				$('#hidden_supply_chain_stock').val(jsonDecode.supply_chain_quantity);

			// 	            //--- Set Text (In stock or Out of stock ---//
			// 	            $('.status_type').html(jsonDecode.btn_txt);

			// 	            //--- remove both class (Instock and out of stock)  and add new class that call back from Ajax ---//
			// 	            $('.status_type').removeClass('instock').removeClass('out_of_stock').addClass(jsonDecode.btn_class);

			// 	            //--- Get Href from add_cart button ---//
			// 	            cartHref = $('a.add_cart').attr('href').split("/");

			// 	            //--- Set last segment (inv_id) with inv_id that received from call back ---//
			// 	            cartHref[cartHref.length - 1] = jsonDecode.inv_id;

			// 	            //--- Join array to string (/)   with .join function ---//
			// 	            cartHref = cartHref.join("/");

			// 	            //--- Set New href to add_cart button ---//
			// 	            $('a.add_cart').attr('href', cartHref);
			// 				$('a.add_now').attr('href', cartHref);

			// 				bulkHref = $('a.bulksale').attr('href').split("&inventory_id=");
			// 				bulkHref[bulkHref.length - 1] = jsonDecode.inv_id;
			// 				bulkHref = bulkHref.join("&inventory_id=");
			// 				$('a.bulksale').attr('href', bulkHref);
			// 	        }
			// 	        else {
			// 	        }
			// 	    }
			// 	},
			// 	'html'
			// );
   //      }
   //      //--- Not Active ---//
   //  });

/*
 * add_cart is not defined
 *
    $('.add_cart').live('click', function (event) {
        event.preventDefault();
        anchor = $(this);
        if ($('#qty').length > 0 && $('#qty').val() != 0) {
            var reg = /^\d+$/;

            if (reg.test($('#qty').val())) {
                cartHref = anchor.attr('href').split("/");
                p_id = cartHref[cartHref.length - 2];
                inv_id = cartHref[cartHref.length - 1];
                add_cart(p_id, inv_id, $('#qty').val());
            }
        }

    });

    $('.add_now').live('click', function (event) {
        event.preventDefault();
        anchor = $(this);
        if ($('#qty').length > 0 && $('#qty').val() != 0) {
            var reg = /^\d+$/;

            if (reg.test($('#qty').val())) {
                cartHref = anchor.attr('href').split("/");
                p_id = cartHref[cartHref.length - 2];
                inv_id = cartHref[cartHref.length - 1];
				$('#is_press_add_now').val('Y');
				//-- Force Redirect to checkout ---//
                add_cart(p_id, inv_id, $('#qty').val(), null, 'Y');
            }
        }

    });
*/

    $('.list_product_upcoming').mouseover(function () {
        $(this).siblings().find('.today_name').css('visibility', 'hidden');
        $(this).children().css('visibility', 'visible');
    }).mouseleave(function () {
        $(this).children('.today_name').css('visibility', 'hidden');
    });

	$('.product-brand-bxslider').bxSlider({
		minSlides: 2,
		maxSlides: 2,
		moveSlides: 1,
		mode: 'vertical',
		infiniteLoop: true,
		touchEnabled: true,
		oneToOneTouch: true,
		pager: false
	});

});
