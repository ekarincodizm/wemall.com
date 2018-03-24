$(document).ready(function() {


    function getItem(list, item_id){
        arr = jQuery.grep(ec_products[list], function( item ) {
            return item.id == item_id;
        });

        return arr;
    }

    $("body").on("click", 'a.ec-product', function() {
        //event.preventDefault();
        var product = {};
        product.list = $(this).attr('data-ec-item').split('|')[0];
        product.id = $(this).attr('data-ec-item').split('|')[1];



        var item = getItem( product.list, product.id );
        console.log(item);

        dataLayer.push({
            "event": "productClick",
            "ecommerce": {
                "click": {
                    "actionField": {
                        "list": product.list,
                        "products": item
                    }
                }
            }
        });
    });

    $("body").on("click", 'a.ec-promotion', function() {
        var banner = {};
        banner.id = $(this).attr('data-ec-promotion').split('|')[0];
        banner.name = $(this).attr('data-ec-promotion').split('|')[1];
        banner.position = $(this).attr('data-ec-promotion').split('|')[2];
        console.log(banner);
        dataLayer.push({
            "event": "promotionClick",
            "ecommerce": {
                "promoClick": {
                    "promotions": [{
                        "id": banner.id,
                        "name": banner.name,
                        "position": banner.position
                    }]
                }
            }
        });
    });


});