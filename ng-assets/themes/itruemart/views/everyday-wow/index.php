<?php

// set current category
$total_page = array_get($pagination, 'total_page', 1);
$total_item = array_get($pagination, 'total_item', 0);
$current_category_slug = $category_slug;
$current_category_name = __("all-category");
$current_page_url = URL::toLang( 'everyday-wow' . (empty($current_category_slug) ? '' : '-' . $current_category_slug) );

?>
<div id="superdeal">

    <?php echo Theme::widget("superDealDaily", array())->render(); ?>

    <!-- category block -->
    <div class="l-extra-wow">
        <div class="dd-title"><h2 class="dd-title-name">Extra Wow!</h2></div>

        <?php if (!empty($category)): ?>
        <div class="l-extra-wow-container">
            <ul class="l-extra-wow-category list-unstyled fix-paddng-left">
                <li class="extra-wow-item<?php echo $current_category_slug=='all' ? ' active' : ''; ?>">
                    <a href="<?php echo URL::toLang('everyday-wow'); ?>" id="category-all" class="category-link everyday-wow-category">
                        <span><?php echo __("all-category"); ?></span>
                    </a>
                </li>
                <?php foreach ($category as $key => $category_data): if ( $current_category_slug==$category_data['slug'] ) { $current_category_name = $category_data['name']; } ?>
                <li class="extra-wow-item<?php echo $current_category_slug==$category_data['slug'] ? ' active' : ''; ?>">
                    <a href="<?php echo URL::toLang('everyday-wow-' . $category_data['slug']); ?>" id="category-<?php  echo $category_data['id']?>" class="category-link">
                        <span><?php echo $category_data['name']; ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>

    <!-- products block -->
    <div class="flashsale">
        
        <div class="dd-title">
            <span class="dd-title-name"><?php echo $current_category_name; ?></span>

            <div class="box-filter">
                <ul id="superdeal-filter">
                    <li><span><?php echo __("filter_title"); ?> : </span></li>
                    <li class="<?php echo ($params["sortby"] == "published_at")? 'active':'';?>" >
                        <a id="published_at_filter" 
                            class="box-filter-type <?php if ($params["sortby"] == "published_at") { echo $params["orderby"] == "desc" ? "down" : "up"; } ?>"
                            href="<?php echo $current_page_url . '?sortby=published_at'; ?>" 
                            data-orderby="published_at">
                            <?php echo __("filter_latest_txt"); ?> <span class="caret-down"></span><span class="caret-up"></span>
                        </a>
                    </li>
                    <li class="<?php echo ($params["sortby"] == "price")? 'active':'';?>">
                        <a id="price_filter" 
                            class="box-filter-type <?php if($params["sortby"] == "price") { echo $params["orderby"] == "desc" ? "down" : "up"; } ?>"
                            href="<?php echo $current_page_url . '?sortby=price'; ?>" 
                            data-orderby="price">
                            <?php echo __("Price"); ?> <span class="caret-down"></span><span class="caret-up"></span>
                        </a>
                    </li>
                    <li class="<?php echo ($params["sortby"] == "discount")? 'active':'';?>">
                        <a id="discount_filter" 
                            class="box-filter-type <?php if($params["sortby"] == "discount") { echo $params["orderby"] == "desc" ? "down" : "up"; } ?>"
                            href="<?php echo $current_page_url . '?sortby=discount'; ?>" 
                            data-orderby="discount">
                            <?php echo __("filter_discount_txt"); ?> <span class="caret-down"></span><span class="caret-up"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- product list -->
        <div class="product-list" id="everydaywow-product-list">
            <?php for($page = 1; $page <= $total_page; $page++ ): ?>
            <div class="product-page page<?php echo ($page==1) ? ' displayed' : ''; ?>" id="page-<?php echo $page; ?>" data-url="<?php echo $current_page_url . '?page=' . $page. '&orderby=' . $params['orderby']. '&sortby=' . $params['sortby']; ?>">
                <?php if ($page==1 && !empty($products)): ?>
                <div class="fs-container">
                    <?php foreach ($products as $key => $product) : ?>
                    <div class="everyday-wow-product-wrapper">
                        <div class="fs-item-wrapper">
                            <div class="everyday-wow-product-box loading">
                            <div class="sd-product-info everyday-wow-product-content">
                                <div class="<?php echo $product['tagCls']; ?>">
                                    <?php if($product['isLineCampaign']): ?>
                                        <img src="<?php echo Theme::asset()->usePath()->url('images/logo/line.jpg'); ?>" alt="iTruemart Everyday Wow Line" />
                                    <?php endif; ?>
                                    <span class="label-percent-discount">
                                        <?php echo $product['percent_discount']?><sup>%</sup><sub>OFF</sub>
                                    </span>
                                    <?php if( !empty($product["discount_title"]) ) : ?>
                                        <span class="label-campaign"><?php echo $product["discount_title"]; ?></span>
                                    <?php endif; ?>
                                    <span class="img-eaves flag-tail"></span>
                                </div>
                                <!-- typeidea script -->
                                <a href="<?php echo get_permalink('products',$product)?>" class="ec-product" data-ec-item="everyday-wow|<?php echo $product['pkey']?>|<?php echo $key+1; ?>">
                                <!-- //typeidea script -->
                                    <div class="everyday-wow-thumbnail">
                                        <img class="lazyload" data-original="<?php echo $product['web_image']?>" alt="<?php echo $product['title']?>"/>
                                    </div>
                                </a>

                                <div class="sd-product-name">
                                    <h5><?php echo $product['title']?></h5>
                                    <?php if($product['isLineCampaign']): ?>
                                        <span class="sd-product-logo"><img src="<?php echo Theme::asset()->usePath()->url('images/logo/'.$product['logo']); ?>" alt="<?php echo $product['descriptionLogo'] ?>" /></span>
                                    <?php endif; ?>
                                </div>

                                <div class="sd-prop-info">
                                    <div class="box-price">
                                        <div class="box-price-discount">
                                            <span class="box-title"><?php echo __("normal_price"); ?></span>
                                            <span class="price-discount">
                                                ₱ <?php echo $product['normal_price']?>
                                            </span>
                                            .-
                                        </div>
                                        <div class="box-price-normal">
                                            <span class="box-title"><?php echo __("special_price"); ?></span>
                                            <span class="price-normal">
                                                ₱ <?php echo $product['special_price']?>
                                            </span>
                                            .-
                                        </div>
                                    </div>
                                    <div class="box-action">
                                        <!-- typeidea script -->
                                        <a href="<?php echo get_permalink('products',$product)?>" class="btn-order ec-product" data-ec-item="everyday-wow|<?php echo $product['pkey']?>|<?php echo $key+1; ?>">สั่งซื้อ</a>
                                        <!-- //typeidea script -->
                                    </div>
                                    <div class="box-timecount"><?php echo __("time_left_to_buy"); ?> :
                                        <div class="countdown" data-countdown="<?php echo array_get($product, 'ended_at', false); ?>"></div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="fs-container">
                    <?php
                    $start = ($page - 1) * 6;
                    $end = $start + 6;
                    $end = $total_item<$end ? $total_item : $end;
                    for ($i = $start; $i<$end; $i++):
                    ?>
                    <div class="everyday-wow-product-wrapper">
                        <div class="fs-item-wrapper">
                            <div class="everyday-wow-product-box loading">
                            <div class="sd-product-info everyday-wow-product-content"></div>
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endfor; ?>
        </div>

    </div>
</div>


    <!-- typeidea script -->
    <script type="text/javascript">
    <?php $ec_products = array(); ?>
      <?php 
        $ec_products = array();
        if (! empty($products) ):
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
    <div class="everyday-wow-product-wrapper">
        <div class="fs-item-wrapper">
            <div class="everyday-wow-product-box loading">
                <div class="sd-product-info everyday-wow-product-content"></div>
            </div>
        </div>
    </div>
</script>

<script type="template" id="single-product-template">
<%
var pkey = product.pkey;
%>
<div class="<%= product.tagCls %>">
    <% if(product.isLineCampaign){ %>
    <img src="<?php echo Theme::asset()->usePath()->url('images/logo/line.jpg');?>" alt="iTruemart Everyday Wow Line" />
    <% } %>
    <span class="label-percent-discount">
        <%= product.percent_discount %><sup>%</sup><sub>OFF</sub>
    </span>
    <% if(product.discount_title){ %>
    <span class="label-campaign"><%= product.discount_title %></span>
    <% } %>
    <span class="img-eaves flag-tail"></span>
</div>
<% /* typeidea script */ %>
<a href="<%= product.product_url %>" class="ec-product" data-ec-item="everyday-wow|<%= pkey %>|<%= ((page_data.current_page-1)*6)+pkey+1 %>">
    <% /* //typeidea script */ %>
    <div class="everyday-wow-thumbnail">
        <img class="lazyload" data-original="<%= product.web_image %>" alt="<%= product.title %>"/>
    </div>
</a>
<div class="sd-product-name">
    <h5><%= product.title %></h5>
    <% if(product.isLineCampaign){ %>
    <span class="sd-product-logo"><img src="/themes/itruemart/assets/images/logo/<%= product.logo %>" alt="<%= product.descriptionLogo %>" /></span>
    <% } %>
</div>
<div class="sd-prop-info">
    <div class="box-price">
        <div class="box-price-discount">
            <span class="box-title"><%= __("normal_price") %></span>
            <span class="price-discount">
                ₱ <%= product.normal_price %>
            </span> .-
        </div>
        <div class="box-price-normal">
            <span class="box-title"><%= __("special_price") %></span>
            <span class="price-normal">
                ₱ <%= product.special_price %>
            </span> .-
        </div>
    </div>
    <div class="box-action">
        <% /* typeidea script */ %>
        <a href="<%= product.product_url %>" class="btn-order ec-product" data-ec-item="everyday-wow|pkey|"><%= __("buy") %></a>
        <% /* //typeidea script */ %>
    </div>
    <div class="box-timecount"><%= __("time_left_to_buy")%> :
        <div class="countdown" data-countdown="<%= product.ended_at %>"></div>
    </div>
</div>
</script>

<script type="template" id="product_tpl">
    <div class="fs-container">
    <% if(product_data.length != 0){ %>
        <% 
        /* typeidea script */
        var _product = [];
        _.each(product_data, function(product, pkey){ 
            ec_products['everyday-wow'].push({
                'id': product.pkey,
                'name': product.title,
                'list': 'everyday-wow',
                'position': ((page_data.current_page-1)*6)+pkey+1,
            });

            
            _product.push({
                'id': product.pkey,
                'name': product.title,
                'list': 'everyday-wow',
                'position': ((page_data.current_page-1)*6)+pkey+1,
            });
            /* //typeidea script */
            %>
            <div class="fs-item-wrapper">
                <div class="sd-product-info">
                    <div class="<%= product.tagCls %>">
                        <% if(product.isLineCampaign){ %>
                            <img src="<?php echo Theme::asset()->usePath()->url('images/logo/line.jpg');?>" alt="iTruemart Everyday Wow Line" />
                        <% } %>
                        <span class="label-percent-discount">
                            <%= product.percent_discount %><sup>%</sup><sub>OFF</sub>
                        </span>
                        <% if(product.discount_title){ %>
                            <span class="label-campaign"><%= product.discount_title %></span>
                        <% } %>
                        <span class="img-eaves flag-tail"></span>
                    </div>
                    <% /* typeidea script */ %>
                    <a href="<%= product.product_url %>" class="ec-product" data-ec-item="everyday-wow|<%= product.pkey %>|<%= ((page_data.current_page-1)*6)+pkey+1 %>">
                    <% /* //typeidea script */ %>
                        <div class="everyday-wow-thumbnail">
                            <img class="lazyload" data-original="<%= product.web_image %>" alt="<%= product.title %>"/>
                        </div>
                    </a>

                    <div class="sd-product-name">
                        <h5><%= product.title %></h5>
                                        <% if(product.isLineCampaign){ %>
                                            <span class="sd-product-logo"><img src="/themes/itruemart/assets/images/logo/<%= product.logo %>" alt="<%= product.descriptionLogo %>" /></span>
                                        <% } %>
                                    </div>

                    <div class="sd-prop-info">
                        <div class="box-price">
                            <div class="box-price-discount">
                                <span class="box-title"><%= __("normal_price") %></span>
                                                <span class="price-discount">
                                                    ₱ <%= product.normal_price %>
                                                </span>
                                .-
                            </div>
                            <div class="box-price-normal">
                                <span class="box-title"><%= __("special_price") %></span>
                                                <span class="price-normal">
                                                    ₱ <%= product.special_price %>
                                                </span>
                                .-
                            </div>
                        </div>
                        <div class="box-action">
                            <% /* typeidea script */ %>
                            <a href="<%= product.product_url %>" class="btn-order ec-product" data-ec-item="everyday-wow|pkey|"><%= __("buy") %></a>
                            <% /* //typeidea script */ %>
                        </div>
                        <div class="box-timecount"><%= __("time_left_to_buy")%> :
                            <div class="countdown" data-countdown="<%= product.ended_at %>"></div>
                        </div>
                    </div>
                </div>
            </div>
        <% }); %>
    <% } %>
    <% /* typeidea script */ %>
    <% dataLayer.push({
      'event': 'productImpressions',
      'ecommerce': {
        'currencyCode': 'PHP',
        'impressions': _product
      }});  
      %>
      <% /* //typeidea script */ %>
    </div>
</script>