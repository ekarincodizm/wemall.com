var ProductThumbnailObject = ProductThumbnailObject || {};

ProductThumbnailObject = (function($){
    me = {};

    me.tagCls = "";
    me.tagIcon = "";
    me.isLineCampaign = false;

    me.template = '<% if( products.products != undefined) { %> \
        <% $.each(products.products, function(key, product) { %>   \
            <% if(product.variants.length > 0) { %>    \
                <% if( product.variants[0].active_special_discount != undefined ) { %>  \
                <%  if( product.variants[0].active_special_discount.flashsale_type == undefined ){  \
                        ProductThumbnailObject.tagCls = "label-red";  \n\
                        ProductThumbnailObject.tagIcon = "label-red-2.png"; \n\
                        ProductThumbnailObject.isLineCampaign = false;  \n\
                    } else if( product.variants[0].active_special_discount.flashsale_type == "tmvh" || product.variants[0].active_special_discount.flashsale_type == "trueu"){  \
                        ProductThumbnailObject.tagCls = "label-green";  \n\
                        ProductThumbnailObject.tagIcon = "label-green-1.png";   \n\
                        ProductThumbnailObject.isLineCampaign = true;   \n\
                    } else {  \
                        ProductThumbnailObject.tagCls = "label-red";    \n\
                        ProductThumbnailObject.tagIcon = "label-red-2.png"; \n\
                        ProductThumbnailObject.isLineCampaign = false;  \n\
                    } %>\n\
                <div class="fs-item-wrapper">   \n\
                    <div class="sd-product-info">   \n\
                        <div class="<%=  ProductThumbnailObject.tagCls %>">    \n\
                            <% if(ProductThumbnailObject.isLineCampaign) { %>   \
                                <img src="<%= site_url_nolang + "themes/super-deal/assets/images/logo/line.jpg" %>" />   \n\
                            <% } %> \n\
                            <span class="label-percent-discount">   \n\
                                <% if (product.percent_discount.min != undefined){ print(Math.floor(product.percent_discount.min)); } else { print("0"); } %><sup>%</sup><sub>OFF</sub>   \
                            </span> \n\
                            <% if( product.variants[0].active_special_discount != undefined ) { %>    \n\
                                <% if( product.variants[0].active_special_discount.discount_title != undefined && product.variants[0].active_special_discount.discount_title != "" ) { %>   \n\
                                    <span class="label-campaign"><%= product.variants[0].active_special_discount.discount_title %></span> \n\
                                <% } %> \n\
                            <% } %>    \n\
                            <img class="img-eaves" src="<%= site_url_nolang + "themes/super-deal/assets/images/label/" + ProductThumbnailObject.tagIcon %>" />    \n\
                        </div>  \n\
                        <a href="<%= site_url + "products/" + product.slug + "-" + product.pkey + ".html" %>">  \n\
                            <div style="height: 290px;overflow: hidden;width: 100%;">   \n\
                                <img style="width:100%;" src="<% if(product.image_cover.thumbnails.large != undefined){ print(product.image_cover.thumbnails.large); } %>" />    \
                            </div>  \n\
                        </a>    \n\
                        <div class="sd-product-name">   \n\
                            <h5>    \n\
                                <% if ( LANG == "th" ){  \n\
                                        print( product.title );     \n\
                                    } else {    \n\
                                        print( product.translate.title );   \n\
                                    } %> \n\
                            </h5>    \n\
                            <% if( ProductThumbnailObject.isLineCampaign && product.variants[0].active_special_discount.flashsale_type != undefined ) { %> \
                                <% if(product.variants[0].active_special_discount.flashsale_type == "tmvh") { %>    \
                                    <span class="sd-product-logo"><img src="<%= site_url_nolang + "themes/super-deal/assets/images/logo/line-truemove.png" %>" /></span>   \n\
                                <% } else if(product.variants[0].active_special_discount.flashsale_type == "trueu") { %>  \
                                    <span class="sd-product-logo"><img src="<%= site_url_nolang + "themes/super-deal/assets/images/logo/line-trueyou.png" %>" /></span> \n\
                                <% } %> \n\
                            <% } %> \n\
                        </div>  \n\
                        <div class="sd-prop-info">  \n\
                             <div class="box-price"> \n\
                                 <div class="box-price-discount">    \n\
                                    <span class="box-title"><%= __("normal_price") %></span>  \n\
                                    <span class="price-discount">   \n\
                                        <% if(product.net_price_range.min != product.net_price_range.min) { %>  \
                                            <%= price_format(product.net_price_range.min) + " - " + price_format(product.net_price_range.max) %>  \n\
                                        <% } else { %>  \
                                            <%= price_format(product.net_price_range.max) %>  \n\
                                        <% } %> \
                                    </span> .- \n\
                                </div>  \n\
                                <div class="box-price-normal">  \n\
                                    <span class="box-title"><%= __("special_price") %></span>   \n\
                                    <span class="price-normal"> \n\
                                        <% if(product.price_range.min != product.price_range.min ) { %> \
                                            <%= price_format(product.price_range.min) + " - " + price_format(product.price_range.max) %>  \n\
                                        <% } else { %>  \
                                            <%= price_format(product.price_range.max) %>   \n\
                                        <% } %> \
                                    </span> .- \n\
                                </div>  \n\
                            </div> \n\
                             <div class="box-action">    \n\
                                <a href="<%= site_url + "products/" + product.slug + "-" + product.pkey + ".html" %>" class="btn-order"><%= __("buy") %></a>    \n\
                             </div>  \n\
                             <div class="box-timecount"><%= __("time_left_to_buy") %> :   \n\
                                <div class="countdown" data-countdown="<% if( product.discount_ended != undefined ){ print( product.discount_ended.toString().replace("-", "/") ); } else { print( ProductThumbnailObject._getExpiredDate() ); } %>"></div>  \n\
                             </div>  \n\
                        </div>  \n\
                    </div>\n\
                </div>\n\
                <% if( (key+1)%3 == 0) { %>  \
                    <div class="clearfix"></div>    \n\
                <% } %> \
                <% } %> \
            <% } %> \
        <% }); %> \
    <% } %>';

    me.init = function(){
        me.initFilter();
        me.initInfiniteScroll();
    };

    me.initFilter = function(){
        $("#superdeal-filter .box-filter-type").bind("click", function(){
            //unbind cick event to prevent multiple click.
            $("#superdeal-filter .box-filter-type").unbind("click")
            
            var filter = $(this).data("orderby");
            var upCls = $(this).hasClass("up");
            var downCls = $(this).hasClass("down");
            var order = "desc";

            //pause infinite scroll
            $('#infinite-container').infinitescroll('pause');

            //remove 'up' & 'down' class on all button
            $("#superdeal-filter .box-filter-type").removeClass("up").removeClass("down");
            if(upCls || downCls){
                if(upCls){
                    $(this).addClass("down");
                    me._ajaxCall(filter, order, me._renderTemplate);
                }else{
                    $(this).addClass("up");
                    order = "asc";
                    me._ajaxCall(filter, order, me._renderTemplate);
                }
            }else{
                $("#"+filter+"_filter").addClass("down");
                me._ajaxCall(filter, order, me._renderTemplate);
            }

        });
    };

    me._ajaxCall = function(filter, order, callback){
        //set current filter
        $("#next_product_btn").data("orderby", filter);
        $("#next_product_btn").data("order", order);
        $("#next_product_btn").data("page", 1);

        //generate api url
        var productUrl = $("#next_product_btn").attr("href");
        productUrl += "?page=1&limit=" + $("#next_product_btn").data("limit") +
            "&orderBy=" + filter +
            "&order=" + order +
            "&campaign=" + $("#next_product_btn").data("campaign");

        $.ajax({
            url: productUrl,
            data: {},
            beforeSend: function(){
                $("#infinite-container .fs-item-wrapper, #infinite-container .clearfix").remove();
                $("#infinite-container").prepend("<div class='loading-icon'><img src='" + site_url + "assets/images/ajax-loader.gif" + "' /></div>");
            },
            type: "GET",
            dataType: "json",
            success: function(json){
                $("#infinite-container .loading-icon").remove();
                //bind event on filter button again.
                me.initFilter();
                
                if(typeof(callback) == "function" && json.data != undefined){
                    callback(json.data);
                }
            },
            error: function(err){
                console.log(err);
            }
        });

//
    };

    me._renderTemplate = function(productsList){
        var compiler =  _.template(me.template);
        var productHTML = compiler({products: productsList});
        $("#infinite-container").prepend(productHTML);
        me.callThirdScript();

        $('#infinite-container').infinitescroll('resume');
    };


    me._getExpiredDate = function () {
        var date = new Date();
        var str = (date.getFullYear()-1) + "/" + (date.getMonth() + 1) + "/" + date.getDate() + " " +  date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
        return str;
    }

    me.callThirdScript = function(){
        APP.itm.countdown();
    }

    me.initInfiniteScroll = function(){

        $("#infinite-container").infinitescroll({
            navSelector  	: "#next_product_btn:last",
            nextSelector 	: "a#next_product_btn:last",
            dataType        : 'json',
            debug   : false,
            appendCallback    : false,
            errorCallback: function(){
                console.log("infinite score error.");
            },
            path: function(currentPage){
                var path = $("#next_product_btn").attr("href");
                var current_page = $("#next_product_btn").data("page");
                $("#next_product_btn").data("page", parseInt(current_page) + 1);

                var customPath = path +
                    "?limit=" + $("#next_product_btn").data("limit") +
                    "&orderBy=" + $("#next_product_btn").data("orderby") +
                    "&order=" + $("#next_product_btn").data("order") +
                    "&campaign=" + $("#next_product_btn").data("campaign") +
                    "&page=" + $("#next_product_btn").data("page");
                return customPath;
            },
            loading: {
                finished: undefined,
                finishedMsg: "<em>Congratulations, you've reached the end of the internet.</em>",
                img: site_url_nolang + "assets/images/ajax-loader.gif",
                msg: null,
                msgText: "",
                selector: null,
                speed: 'fast',
                start: undefined
            }
        }, function( productList, opts ) {
            if(productList.data != undefined){
                if(productList.data.products.length > 0){
                    var compiler =  _.template(me.template);
                    var productHTML = compiler({products: productList.data});
                    $("#infinite-container .next-product-container").before(productHTML);

                    me.callThirdScript();
                }else{
                    $('#infinite-container').infinitescroll('pause');
                }
            }else{
                $('#infinite-container').infinitescroll('pause');
            }

        });
    };

    return me;
})(jQuery);


$(document).ready(function(){
    ProductThumbnailObject.init();
});
