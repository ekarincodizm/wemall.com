<?php echo Theme::widget("accordionBanner", array())->render(); ?>

<?php echo Theme::widget("homePolicy", array())->render(); ?>

<div id="infinite-showroom">
    <?php for($i=1; $i<=$totalShowroom; $i++): ?>
        <div class="showroom-container loading" data-url="<?php echo URL::toLang("ajax/showroom?&limit=1&page=" . $i); ?>"></div>
    <?php endfor; ?>
</div>

<script id="single-showroom-template" type="template">
<%
var $item = showroom.pop();
%>
<div class="home__showroom_container layout_<%= $item.layout_id %>"
     data-id="<%= $item.layout_id %>"
     id="<%= $item.showroom_id %>">
    <% // render banner %>
    <% if (typeof($item.banner.id)!='undefined') { %>
    <!-- typeidea script -->
    <% var $ec_banner_promo = $item.banner.link ? $item.banner.link.split("#").pop() : ''; %>
    <a class="showroom_banner ec-promotion" href="<%= $item.banner.link %>" data-ec-promotion="<%= $ec_banner_promo + '|' + $ec_banner_promo + '|showroom-' + $item.showroom_id + '-' + $item.banner.position %>">
        <!-- //typeidea script -->
        <img src="<%= $item.banner.thumbnail.desktop %>" class="lazyload"/>
    </a>
    <% } %>
    <% // render brand %>
    <% if ($item.brand) { %>
    <ul class="showroom_brand">
        <% _.each($item.brand, function($brand){ %>
        <li class="brand_item">
            <a class="brand_link" href="<%= $brand.link %>" id="<%= $brand.id %>">
                <img src="<%= $brand.thumbnail %>" alt="<%= $brand.name %>"/>
            </a>
        </li>
        <% }); %>
        <% // <li class="brand_item"><a href="{{{ URL::toLang("shopbybrand") }}}" class="brand_link"><span class="brand_more">...</span></a></li> %>
    </ul>
    <% } %>
    <% // render showroom %>
    <div class="showroom_wrapper">
        <div class="showroom_header">
            <div class="showroom_name">
                <h2 class="page_main_h2_subject"><%= $item.showroom_title %></h2>
                <b><a href="<%= $item.showroom_link %>"><%= $item.showroom_title %></a></b>
            </div>
        </div>
        <div class="showroom_content">
            <% for (var i = 0; i < $item.product.length; i++ ) { $product = $item.product[i]; %>
            <div class="box_<%= $product.box %> box_<%= $product.type %>" data-position="<%= $product.position %>" id="<%= $product.id %>">
                <% if ($product.type=='banner') { %>
                <!-- typeidea script -->
                <% $ec_banner_promo = $product.link ? $product.link.split("#").pop() : ''; %>
                <a href="<%= $product.link %>" class="ec-promotion" data-ec-promotion="<%= $ec_banner_promo + '|' + $ec_banner_promo + '|showroom-' + $item.showroom_id + '-' + $product.position %>">
                    <!-- //typeidea script -->
                    <img src="<%= $product.thumbnail.desktop %>" alt="" class="lazyload">
                </a>
                <% } else { %>
                <!-- typeidea script -->
                <a href="<%= $product.link %>" class="ec-product" data-ec-item="showroom-<%= $item.showroom_id + '|' + $product.pkey + '|' + $product.position %>">
                    <!-- typeidea script -->
                    <% if ($product.price.discount) { %>
                    <span class="price_tag">
                        <span class="price_no">
                            <% if ( $product.price.discount.min == $product.price.discount.max ) { %>
                                <%= $product.price.discount.min %>
                            <% } else { %>
                                <span class="price_text"><?php _e('up_to') ?></span>
                                <%= $product.price.discount.max %>
                            <% } %>
                        </span>
                        <sup>%</sup>
                        <sub>OFF</sub>
                    </span>
                    <% } %>
                    <span class="product_thumbnail">
                        <img src="<%= $product.thumbnail.desktop %>" class="lazyload" alt="<%= $product.title %>">
                    </span>
                    <span class="product_name"><%= $product.title %></span>
                    <span class="product_price">
                        <% if ($product.price.special) { %>
                            <span class="price_discount"><%= $product.price.special.min %></span>
                            <span class="price_normal discount"><%= $product.price.net.min %></span>
                        <% } else { %>
                            <span class="price_normal">
                                <% if ( $product.price.normal.min != $product.price.normal.max ) { %>
                                    <?php _e('start') ?>
                                    <%= $product.price.normal.min %>
                                <% } else { %>
                                    <%= $product.price.normal.min %>
                                <% } %>
                            </span>
                        <% } %>
                    </span>
                </a>
                <% } %>
            </div>
            <% }; %>
        </div>
    </div>
</div>
<%
// typeidea script

var $ec_products = [];
var $ec_banner = [];

if ($item.banner.link) {
    var $ec_banner_promo = $item.banner.link ? $item.banner.link.split('#').pop() : false;
    $ec_banner.push({
        'id': $ec_banner_promo,
        'name': $ec_banner_promo,
        'position': 'showroom-' + $item.showroom_id + '-' + $item.banner.position
    });
}

if ($item.product) {
    _.each($item.product, function($product) {
        if ($product.type=='product') {
            $ec_products.push({
                'id': $product.pkey,
                'name': $product.title,
                'list': 'showroom-' + $item.showroom_id,
                'position': $product.position
            });
        }
        if ($product.type=='banner' && $product.link) {
            $ec_banner_promo = $product.link.split('#').pop();
            $ec_banner.push({
                'id': $ec_banner_promo,
                'name': $ec_banner_promo,
                'position': 'showroom-' + $item.showroom_id + '-' + $product.position
            });
        }
    });
}

if(typeof ec_products === 'undefined'){
    var ec_products = [];
}

ec_products['showroom-' + $item['showroom_id']] = $ec_products;

dataLayer.push({
    'event': 'productImpressions',
    'ecommerce': {
        'currencyCode': 'PHP',
        'impressions': $ec_products
    }
});

var ec_banner = $ec_banner;
dataLayer.push({
    'event': 'promoView',
    'ecommerce': {
        'currencyCode': 'PHP',
        'promoView': {
            "promotions": $ec_banner
        }
    }
});
%>
</script>