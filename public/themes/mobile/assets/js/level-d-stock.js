/*\
|*|
|*|  :: Number.isInteger() polyfill ::
|*|
|*|  https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/isInteger
|*|
\*/
if (!Number.isInteger) {
  Number.isInteger = function isInteger(nVal) {
    return typeof nVal === 'number'
      && isFinite(nVal)
      && nVal > -9007199254740992
      && nVal < 9007199254740992
      && Math.floor(nVal) === nVal;
  };
}

// get pkey of style option that selected currently
function getCurrentPkey()
{
    var styleOptionPkey = [];
    $('.style-options').each(function(index, item) {
        var $item = $(item);
        var active = $item.find('.style-option.active').first();
        if (active.length == 1)
        {
            styleOptionPkey.push(active.data('style-option-pkey'));
        }
    });

    return styleOptionPkey;
}

// get inventory id of selected or false
function getCurrentInventoryId()
{
    var styleOptionPkey = getCurrentPkey();

    var finder = styleOptionAvaliable;



    if (typeof finder[0] != 'undefined')
    {
        return finder[0]['inventory_id'];
    }


    //for(i in styleOptionPkey)
    for(i=0;i<styleOptionPkey.length;i++)
    {
        if (/^\d+$/.test(i))
        {
            //This inventory is disabled.
            if (typeof finder[styleOptionPkey[i]] == 'undefined') {
                return undefined;
            }
            finder = finder[styleOptionPkey[i]];
        }
    }
    /*
    if (typeof finder['inventory_id'] != 'string') {
        return false;
    }
    */


    return finder['inventory_id'];
}

function getCurrentVariant()
{
    var styleOptionPkey = getCurrentPkey();

    var finder = styleOptionAvaliable;


    if (typeof finder[0] != 'undefined')
    {
        return finder[0];
    }



    //for(i in styleOptionPkey)
    for(i=0;i<styleOptionPkey.length;i++)
    {
        if (/^\d+$/.test(i))
        {
            if (typeof finder[styleOptionPkey[i]] == 'undefined') {
                return false;
            }
            finder = finder[styleOptionPkey[i]];
        }
    }
    //console.log(typeof finder['inventory_id']);

    if (typeof finder['inventory_id'] != 'string') {
        //return false;
    }

    return finder;
}

function getWarningHtml(label)
{
    return  '<div class="col-xs-12 warning" style="display: none;">'
        + '<div class="warning-message-box">'
        + '<span class="warning-message-star">*</span>'
        + '<span class="warning-message-text">'+ __("Please choose") + ' ' + __(label) + ' ' + __("to_product") +'</span>'
        + '</div>'
        + '</div>';
}

// update disable box
function updateDisableBox()
{
    var styleOptionPkey = getCurrentPkey();

    // loop eacch level styleoptions
    $('.style-options').each(function(index, item) {
        var $item = $(item);
        // var childStyleOptions = $item.find('.style-option');
        // var finder = styleOptionAvaliable;

        // // loop in style option
        // for(i in styleOptionPkey)
        // {
        //     if (i == index)
        //     {
        //         break;
        //     }

        //     if (finder[styleOptionPkey[i]] != 'undefined')
        //     {
        //         finder = finder[styleOptionPkey[i]];
        //     }
        // }

        // // find deep child
        // childStyleOptions.each(function(index, item) {
        //     var $item = $(item);
        //     var pkey = $(item).data('style-option-pkey');

        //     if (typeof finder[pkey] == 'undefined') {
        //         $item.addClass('disable').removeClass('active');
        //     }
        //     else
        //     {
        //         $item.removeClass('disable');
        //     }
        // });


        if ($item.find('.style-option.active').length == 0)
        {
            if ($item.next('.warning').length == 0)
            {
                $item.after(getWarningHtml($item.data('style-type-name')));
                $item.next('.warning').slideDown();
            }
        }
        else
        {
            $item.next('.warning').slideUp(400, function(){
                $(this).remove();
            });
        }

    });
}

function updateAddToCart(inventoryStock)
{
    var $addToCart = $('.add-to-cart');
    // var inventoryStock = getInventoryStock();

    var stock = 'no';
    if (inventoryStock)
    {
        stock = inventoryStock;
    }
    $addToCart.data('stock', stock).attr('data-stock', stock);

    // update inv to cart
    var inventory_id = getCurrentInventoryId();
    if (! inventory_id)
    {
        inventory_id = '';
    }
    $addToCart.data('inventory-id', inventory_id).attr('data-inventory-id', inventory_id);
}

function updateStockStatus(inventoryStock)
{
    var $statusHolder = $('.product-option .status-holder');

    var $statusIndicator = $statusHolder.find('.status-indicator');
    var hasStock = { css: 'color:#95c126;', content: '<img src="/themes/mobile/assets/img/icon_check_green.png">  ' + __("in_stock")};
    var outOfStock = { css: 'color:#959595;', content: '<img src="/themes/mobile/assets/img/icon_out_of_stock.png"> <span style="color: #959595;">' + __("out_of_stock") + '</span>'};
    var waiting = { css: 'color:#959595;', content: '<img style="margin-top: 15px; margin-left: 52px;" src="/themes/mobile/assets/img/loading.gif">'};

    if (inventoryStock)
    {
        if (inventoryStock == 'waiting')
        {
            $statusIndicator.attr('style', waiting.css).html(waiting.content);
        }else if(inventoryStock == "options_is_required"){
            //show missing options inside status block.
            updateStatusIndicator();
            $(document).trigger("hide-ajax-loading");
        }
        else
        {
            $statusIndicator.attr('style', hasStock.css).html(hasStock.content);
            $('.button-buy .col-xs-12 .button').css({backgroundColor:'#95c126'});
            $('.add-to-cart').removeClass('disabled');
            $(document).trigger("hide-ajax-loading");
        }
    }
    else
    {
        $statusIndicator.attr('style', outOfStock.css).html(outOfStock.content);
        $('.button-buy .col-xs-12 .button').css({backgroundColor:'#a4a4a4',color:'#fff',borderColor:'#737373'});
        $('.add-to-cart').addClass('disabled');
        $(document).trigger("hide-ajax-loading");
    }

    var inventory_id = getCurrentInventoryId();

    if (! inventory_id)
    {
        //$statusHolder.slideUp();
        return;
    }

    $statusHolder.slideDown();
}

function updateInventoryStatus()
{
    var inventory_id = getCurrentInventoryId();
    var inventoryStock = false;


    updateStockStatus('waiting');
    //updateAddToCart(inventoryStock);

    //If inventory is disabled.
    if (inventory_id === undefined)
    {
        updateStockStatus(false);
        updateStatusIndicator();
        updateAddToCart(inventoryStock);
        console.log('return 240');
        return;
    }

    if (inventory_id === false)
    {
        updateStockStatus("options_is_required");
        updateAddToCart(inventoryStock);
        console.log('return line 248');
        return;
    }

    var pkey = Product.data.pkey;
    var product_promotion = $('.product_promotion').text();

    $.ajax({
        type: 'get',
        url: '/products/stocks/' + inventory_id,
        data:{'pkey':pkey, 'product_promotion':product_promotion}
        // async: false
    })
    .done(function( msg ) {
        if (typeof msg[inventory_id] == 'number' && msg[inventory_id] > 0)
        {
            inventoryStock = msg[inventory_id];
        }
    })
    .fail(function() {
    })
    .then(function() {

        updateStockStatus(inventoryStock);
        updateAddToCart(inventoryStock);
    });

}

function updatePrice()
{
    var variant = getCurrentVariant();

    var $productPrice = $('.product-price');
    var $variantPrice = $('.variant-price');

    if (variant)
    {
        // is variant

        if (variant.net_price == variant.price)
        {
            $variantPrice.find('.normal-price').find('span.number_price').text(variant.price).removeClass('style-line-through');
            $variantPrice.find('.special-price').hide();
        }
        else
        {
            $variantPrice.find('.normal-price').find('span.number_price').text(variant.net_price);
            $variantPrice.find('.special-price').show().find('span.number_price').text(variant.price);
        }

        $variantPrice.find();
        $productPrice.hide();
        $variantPrice.show();
    }
    else
    {
        $productPrice.show();
        $variantPrice.hide();

    }
    calculateInstallment();
}

function updateImageSwift()
{
    var inventory_id = getCurrentInventoryId();

    if (
        inventory_id
        && typeof inventoryImage[inventory_id] != 'undefined'
        && inventoryImage[inventory_id][0] != null
    ) {
        var $swiftProduct = $('.swiper-product-container.product');
        var $swiftProductPagination = $('.pagination.product');
        $swiftProduct.hide();
        $swiftProductPagination.hide();

        $('.swiper-product-container.variant').remove();
        $('.pagination.variant').remove();

        var $domImage = '';
        for (i in inventoryImage[inventory_id])
        {
            $domImage = $domImage + '<div class="swiper-slide"><img src="'+ inventoryImage[inventory_id][i] +'"> </div>';
        }
        var $domVariantImage = '<div class="swiper-product-container variant">'
            + '<div class="swiper-wrapper">'
            + $domImage
            + '</div>'
            + '</div>'
            + '<div class="pagination variant"></div>';
        $swiftProductPagination.after($domVariantImage);

        $loop = (inventoryImage[inventory_id].length > 1)? true :false;

        var mySwiper1 = new Swiper('.swiper-product-container.variant',{
            pagination: '.pagination.variant',
            loop: $loop,
            grabCursor: true,
            paginationClickable: true
        })
        // $swiftVariant.remove();
        return true;
    }

    return false;
}

function updateStatusIndicator(){

    var styleOptionsLength = 0;
    //count unselected option.
    $(".style-options").each(function(idx, optionElement){
        if( $(optionElement).find(".style-option.active").length == 0 ){
            styleOptionsLength++;
        }
    });

    //If there are options that haven't been selected then do check.
    if(styleOptionsLength > 0){
        var statusText = "";
        var optionArray = [];

        $(".style-options").each(function(idx, optionElement){
            if( $(optionElement).find(".style-option.active").length == 0 ){
                if(styleOptionsLength == 1){
                    statusText = $(optionElement).data('style-type-name');
                }else if( (styleOptionsLength-1) == idx){
                    statusText = optionArray.join(", ");
                    statusText += " and " + $(optionElement).data('style-type-name');
                }else{
                    optionArray.push($(optionElement).data('style-type-name'));
                }
            }
        });

        // GET inner HTML
        var statusHTML = $(getWarningHtml(statusText)).html();
        $(".status-indicator").html( statusHTML );
    }

}
$(document).on('doneLevelDContent', function(){

    if (getCurrentInventoryId())
    {
        updateInventoryStatus();
    }
    else
    {
        $('.product-option .style-option').on('click', function(e) {
            $(document).trigger("show-ajax-loading");
            var $this = $(this);

            // if ($this.hasClass('disable'))
            // {
            //     return;
            // }

            $this.addClass('active');

            var $parent = $this.parent('a').parent('div').first();
            var $styleOptionsAnother = $parent.find('div.style-option').not($this);
            $styleOptionsAnother.each(function(index, item) {
                var $item = $(item);
                $item.removeClass('active');
            });

            //updateDisableBox();
            updateStatusIndicator();

            updatePrice();

            updateInventoryStatus();

            updateImageSwift();

            // $(document).trigger("hide-ajax-loading");
        });
        //updateDisableBox();
        updateStatusIndicator();
    }

    //var count_variant = Object.keys(styleOptionAvaliable).length;
    //if(count_variant == 1)
    //{
    calculateInstallment();
    //}

});


function calculateInstallment()
{
    $('.row-promotion').each( function(index) {
        var pay = '-';

        var variant_var = $('.variant-price').attr('style');
        var product_price_var = $('.product-price').attr('style');

        var has_style = $('.product-style_types').text();

        if(has_style)
        {
            if(product_price_var == 'display: none;')
            {
                var price = $('.variant-price .normal-price .number_price').text();

                /// if special price show, get price from it ///
                var var_style = $('.variant-price .special-price').attr('style');

                if(var_style != 'display: none;')
                {
                    if ($('.variant-price .special-price .number_price').length)
                    {
                        price = $('.variant-price .special-price .number_price').text();
                    }
                }
            }
            else
            {
                var price = $('.product-price .normal-price .number_price').text();

                /// if special price show, get price from it ///
                var var_style = $('.product-price .special-price').attr('style');

                if(var_style != 'display: none;')
                {
                    if ($('.product-price .special-price .number_price').length)
                    {
                        price = $('.product-price .special-price .number_price').text();
                    }
                }
            }
        }
        else
        {
            var price = $('.product-price .normal-price .number_price').text();

            /// if special price show, get price from it ///
            var var_style = $('.product-price .special-price').attr('style');

            if(var_style != 'display: none;')
            {
                if ($('.product-price .special-price .number_price').length)
                {
                    price = $('.product-price .special-price .number_price').text();
                }
            }
        }


        //var price = $('.special_price').text();

        /// start with ///
        //$(this).find('.amount').text(__("pay-per-month"));

        /// if price is range, get the min price ///
        /*if (price.indexOf('-') >= 0)
        {
            $(this).find('.amount').text(__("pay-start"));

            var prices = price.split('-');
            price = prices[0].trim();

            if (price == "")
            {
                price = 0;
            }

        }*/

        /*** IF price is range-range Not Calculate ***/
        var price_range = price.search('-');
        if(price_range != -1)
        {
            //return true;
            var prices = price.split('-');
            price = prices[0].trim();
        }

        price = price.replace(',', "");
        price = parseInt(price);

        $('.row-promotion').each(function(idx, val){
            var self = $(this),
                period = self.find('.discount_period').text(),
                payPerMonth = self.find('.pay_per_month');

            period = parseInt(period);
            pay = price / period;

            payPerMonth.attr('style', 'font-size: inherit; font-style: inherit; color: rgb(232, 58, 39);');
            payPerMonth.text("₱ " + pay.formatMoney());

        });
        /*var period = $(this).find("#discount_period").text();
         period = parseInt(period);

         pay = price / period;

         $(this).find('#pay_per_month').text("₱ " + pay.formatMoney());*/
    });

    return true;
}