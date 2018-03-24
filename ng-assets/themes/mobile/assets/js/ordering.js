function getOrderingUrl(url, domOrdeyBy)
{
    var query = {};
    var $domOrdeyBy = $(domOrdeyBy);
    // console.log($domOrdeyBy, $domOrdeyBy.find('button'));
    $domOrdeyBy.find('button').each(function(index, item) {
        var orderBy = $(item).data('order-by');
        var order = $(item).data('order');
        // console.log(orderBy, order);
        if (order != 'both')
        {
        	query['orderBy'] = orderBy;
            query['order'] = order == 'down' ? 'desc' : 'asc';
        }
    });

    // var queryString = $.param(query);
    return url + '?' + $.param(query);
    // console.log(queryString);
}

$(document).ready(function(){

    var orderImgButton = {
        'both' : '/themes/mobile/assets/img/order_by_both.png',
        'down' : '/themes/mobile/assets/img/order_by_both_down_active.png',
        'up'   : '/themes/mobile/assets/img/order_by_both_up_active.png'
    }
    
    $('.order-by > button').on('click', function(e){
        var $this = $(this);

        $this.addClass("active");

        if ($this.data('order') != 'down')
        {
            $this.data('order', 'down').find("img").attr("src", orderImgButton.down);
        }
        else
        {
            $this.data('order', 'up').find("img").attr("src", orderImgButton.up);
        }
        var $anotherButtons = $this.parent().find('button').not($this);
        $anotherButtons.each(function(index, item) {
            var $item = $(item);
            // console.log($item);
            $item.removeClass("active").data('order', 'both');
            $item.find("img").attr("src", orderImgButton.both);
        });
        
    });
    
});