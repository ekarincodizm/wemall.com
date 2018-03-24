<?php
// set current category
$total_page = array_get($pagination, 'total_page', 1);
$total_item = array_get($pagination, 'total_item', 0);

$sortby = $params["sortby"];
$orderby = $params["orderby"] == "desc" ? "down" : "up";

$current_category_slug = $category_slug;
$current_category_name = __("all-category");
$current_page_url = URL::toLang( 'everyday-wow' . (empty($current_category_slug) ? '' : '-' . $current_category_slug) );

?>

<!-- Search -->
<?php echo Theme::widget('WidgetMobileSearchBox')->render(); ?>

<!-- SuperDeal Banner-->
<!-- Mobile don't use banner [new design confirm by UI] -->
<?php //echo Theme::widget("superDealMobileBanner", array())->render(); ?>

<!-- Category -->
<?php echo Theme::widget('WidgetMobileCategoryLink')->render(); ?>

<!-- SuperDeals -->
<?php echo Theme::widget("superDealDaily", array())->render(); ?>

<!-- Banner -->
<?php echo Theme::widget("superDealMobileBanner", array())->render(); ?>
<p></p>

<div class="extra-wow-container">
    <div class="extra-wow-title">
        <h1 class="extra-wow-name">
            <span>Extra</span> <span>Wow!</span>
        </h1>
    </div>
    <div class="swiper-container extra-wow-category-container">
        <ul class="swiper-wrapper extra-wow-category list-unstyled">
            <li class="swiper-slide extra-wow-item swiper-slide-visible<?php echo $current_category_slug=='all' ? ' active' : ''; ?>">
                <a href="<?php echo URL::toLang('everyday-wow'); ?>" id="category-all" class="category-link">
                    <span><?php echo __("all-category"); ?></span>
                </a>
            </li>
            <?php foreach ($category as $key => $category_data): ?>
            <?php if ( $current_category_slug==$category_data['slug'] ) { $current_category_name = $category_data['name']; } ?>
            <li class="swiper-slide extra-wow-item<?php echo $current_category_slug==$category_data['slug'] ? ' active' : ''; ?>">
                <a href="<?php echo URL::toLang('everyday-wow-' . $category_data['slug']); ?>" id="category-<?php echo $category_data['id']; ?>" class="category-link">
                    <span><?php echo $category_data['name']; ?></span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<!-- <div class="row row-extra-wow-category-name"> -->
<div class="row row-extra-wow-category-name">
    <div class="col-xs-12">
        <h2 class="extra-wow-category-name"><?php echo $current_category_name; ?></h2>
    </div>
</div>

<!-- <div class="row row-extra-wow-amount"> -->
<div class="row row-extra-wow-amount">
    <div class="col-xs-4">
        <span class="extra-wow-amount">
            <span><?php echo $total_item; ?></span>
            <span><?php echo __('wow-total'); ?></span>
        </span>
    </div>
    <div class="col-xs-8">
        <div id="superdeal-filter-mobile" class="btn-group order-by text-right">
            <button type="button" data-href="<?php echo $current_page_url . '?sortby=published_at'; ?>" class="btn btn-default box-filter-type-mobile active <?php if ($params['sortby'] == 'published_at') { echo $params['orderby'] == 'desc' ? 'down' : 'up'; } ;?>" 
                data-orderby="published_at">
                <?php echo __("filter_latest_txt"); ?> 
                <img src="/themes/mobile/assets/img/order_by_both_<?php echo $params['orderby'] == 'desc' ? 'down' : 'up'; ?>_active.png">
                <span class="filter-status"></span>
            </button>
            <button type="button" data-href="<?php echo $current_page_url . '?sortby=price'; ?>" class="btn btn-default box-filter-type-mobile  <?php if ($params['sortby'] == 'price') { echo $params['orderby'] == 'desc' ? 'down' : 'up'; } ;?>" 
                data-order-by="price" 
                data-order="price">
                <?php echo __("Price"); ?>
                <img src="/themes/mobile/assets/img/order_by_both.png">
                <span class="filter-status"></span>
            </button>
            <button type="button" data-href="<?php echo $current_page_url . '?sortby=discount'; ?>" class="btn btn-default box-filter-type-mobile  <?php if ($params['sortby'] == 'discount') { echo $params['orderby'] == 'desc' ? 'down' : 'up'; } ;?>" 
                data-order-by="discount" 
                data-order="<?php echo $params["sortby"] == "discount" ? $orderby : "both"; ?>">
                <?php echo __("filter_discount_txt"); ?>
                <img src="/themes/mobile/assets/img/order_by_both.png">
                <span class="filter-status"></span>
            </button>
        </div>
    </div>
</div>


<!-- <div class="row superdeal"></div> -->
<div class="row superdeal" id="everydaywow-product-list">
    <div class="jscroll-inner">

        <?php for($page = 1; $page <= $total_page; $page++ ): ?>
        <div class="product-page page  <?php echo ($page==1) ? ' displayed' : ''; ?>" id="page-<?php echo $page;?>" data-url="<?php echo $current_page_url . '?page=' . $page. '&orderby=' . $params['orderby']. '&sortby=' . $params['sortby']; ?>">
            <?php if ($page == 1 && !empty($products)): ?>
                <?php foreach ($products as $key => $product) : ?>
                    <?php
                    $txtClass = 'left';
                    if(($key % 2) != 0)
                    {
                        $txtClass = 'right';
                    }
                    ?>
                    <?php
                    $dummy_sale_tag = 'dummy_sale_tag_01.png';
                    $price_tag = 'price-red';
                    if($product['isLineCampaign'])
                    {
                        $dummy_sale_tag = 'dummy_sale_tag_02.png';
                        $price_tag = 'price-line';
                    }
                ?>
                <div class="col-xs-6 product-item-wrapper everyday-wow-product-wrapper">
                    <div class="superdeal-home-thumb everyday-wow-product-box loading">
                    <div class="product-item everyday-wow-product-content">

                        <?php if($product['isLineCampaign']):?>
                            <?php if(!empty($product['discount_icon'])):?>
                                <div class="line-special">
                                    <?php
                                        $discount_icon = '';
                                        if($product['discount_icon'] == 'tmvh')
                                        {
                                            $discount_icon = 'line_truemove_h.png';
                                        }
                                        elseif($product['discount_icon'] == 'trueu')
                                        {
                                            $discount_icon = 'line_trueyou.png';
                                        }
                                    ?>
                                    <img alt="<?php echo $product['descriptionLogo'];?>" src="<?php echo Theme::asset()->usePath()->url('img/'.$discount_icon); ?>">
                                </div>
                            <?php endif;?>
                        <?php endif;?>

                        <div class="col-xs-12">
                            <div class="product-img">
                                <!-- typeidea script -->
                                <a href="<?php echo get_permalink('product', $product);?>" class="ec-product" data-ec-item="everyday-wow|<?php echo $product['pkey']?>|<?php echo $key+1; ?>"><img class="lazyload" title="<?php echo $product['title']?>" alt="<?php echo $product['title']?>" src="" data-original="<?php echo $product['mobile_image'];?>"></a>
                                <!-- //typeidea script -->
                            </div>
                        </div>
                        <div class="col-xs-12 time-remaining"><?php echo __("time_left_to_buy"); ?> :
                            <span style="color:#444" data-reload="0" data-countdown="<?php echo array_get($product, 'ended_at', false); ?>">
                                164:37:17
                            </span>
                        </div>
                        <div class="col-xs-12 product-everyday-wow--name"><?php echo $product['title'];?></div>
                        <div class="col-xs-12 price-superdeal margin-top-20">
                            <div class="row">
                                <div class="col-xs-8">
                                    <p><?php echo $product['special_price']; ?>.-</p>
                                    <span><?php echo $product['normal_price']; ?>.-</span>
                                </div>
                                <div class="col-xs-4">

                                    <span class="<?php echo $price_tag;?>"><?php echo $product['percent_discount'];?></span>

                                    <img alt="<?php echo $product['title'];?>" src="<?php echo Theme::asset()->usePath()->url('img/'.$dummy_sale_tag); ?>">
                                </div>
                            </div>
                        </div>

                    </div>
                    </div>
                </div>
                <?php endforeach;?>
            <?php else: ?>
                <?php
                $start = ($page - 1) * 6;
                $end = $start + 6;
                $end = $total_item<$end ? $total_item : $end;
                for ($i = $start; $i<$end; $i++) { echo '<div class="col-xs-6 product-item-wrapper everyday-wow-product-wrapper"><div class="superdeal-home-thumb everyday-wow-product-box loading"><div class="product-item everyday-wow-product-content"></div></div></div>'; }
                ?>
            <?php endif;?>
        </div>
        <?php endfor;?>

    </div>
</div>
    <!-- typeidea script -->
    <script type="text/javascript">
    <?php $ec_products = array(); ?>
      <?php 
        $ec_products = array();
        if (!empty($products)):
            foreach ($products as $key => $product) :
                array_push($ec_products, 
                array(  'id' => $product['product_pkey'], 
                        'name' => $product['product_title'], 
                        'list' => 'everyday-wow',
                        'position' => $key+1));
                
            endforeach; 
        endif;
        ?>
        if(typeof ec_products === 'undefined'){
            var ec_products = [];
        } 
        ec_products['everyday-wow'] = <?php echo jsonUnescapedUnicode(json_encode($ec_products)); ?>;

        dataLayer.push({
          'event': 'productImpressions',
          'ecommerce': {
            'currencyCode': 'PHP',
            'impressions': <?php echo jsonUnescapedUnicode(json_encode($ec_products)); ?>
          }
        });
        dataLayer.push({
            'event': '',
          'ecommerce': {
            'currencyCode': 'PHP',
            'impressions': []
          }
        });
    </script>
    <!-- //typeidea script -->

<script type="template" id="product-box-template">
    <div class="col-xs-6 product-item-wrapper everyday-wow-product-wrapper"><div class="superdeal-home-thumb everyday-wow-product-box loading"><div class="product-item everyday-wow-product-content"></div></div></div>
</script>

<script type="template" id="single-product-template">
<%
console.log('template loaded');
var pkey = product.pkey;
var dummy_sale_tag = 'dummy_sale_tag_01.png';
var price_tag = 'price-red';
if(product.isLineCampaign) {
    dummy_sale_tag = 'dummy_sale_tag_02.png';
    price_tag = 'price-line';
}
%>
<% if(product.isLineCampaign) { %>
<% if(product.discount_icon.length != 0) { %>
<%
var discount_icon = '';
if(product.discount_icon == 'tmvh') {
    discount_icon = 'line_truemove_h.png';
} else if(product.discount_icon == 'trueu') {
    discount_icon = 'line_trueyou.png';
}
%>
<% if(discount_icon){ %>
<div class="line-special">
    <img alt="<%= product.descriptionLogo %>" src="/themes/mobile/assets/img/<%= discount_icon %>">
</div>
<% } %>
<% } %>
<% } %>
<div class="col-xs-12">
    <div class="product-img">
        <a href="<%= product.product_url %>" class="ec-product"
           data-ec-item="everyday-wow|<%= pkey %>|<%= ((page_data.current_page-1)*6)+pkey+1 %>">
            <img class="lazyload" title="<%= product.title %>" alt="<%= product.title %>" src="" data-original="<%= product.mobile_image %>">
        </a>
    </div>
</div>
<div class="col-xs-12 time-remaining"><%= __("time_left_to_buy")%> :
    <span style="color:#444" data-reload="0" data-countdown="<%= product.ended_at %>">000:00:00</span>
</div>
<div class="col-xs-12 product-everyday-wow--name"><%= product.title %></div>
<div class="col-xs-12 price-superdeal margin-top-20">
    <div class="row">
        <div class="col-xs-8">
            <p><%= product.special_price %>.-</p>
            <span><%= product.normal_price %>.-</span>
        </div>
        <div class="col-xs-4">
            <span class="<%= price_tag %>"><%= product.percent_discount %></span>
            <img alt="<%= product.title %>" src="/themes/mobile/assets/img/<%= dummy_sale_tag %>">
        </div>
    </div>
</div>
</script>