<?php 
    $url = '';
    if(App::getLocale() == 'th'){
        $url = Request::segment(1);
    }else{
        $url = Request::segment(2);
    }
 ?>
<div class="base_seller_items">
    <div class="tap_product_main">
        <div class="promotion">
            <div class="div_promotion">
                <div id="bestseller_loader">
                    <div id="promotion_back">
                    </div>
                    <div class="promotion_space"></div>
                    <div id="div_promotion_content">
                        <ul class="bx-listproduct-slider over">
                        <!-- typeidea script -->
                        <?php foreach ($bestSeller as $key => $product): ?>
                            <?php
                                $CollectName = isset($collectionDetail['name']) ? $collectionDetail['name'] : "" ; /////***
                                $product['list_position'] = ++$key;
                                $product['list_collection'] = 'category-bestseller-' . $CollectName; 
                            ?>
                            <!-- //typeidea script -->
                            <li class="bx-product">
                                <?php echo HTML::product($product) ?>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="promotion_space">
                    </div>
                    <div id="promotion_next">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- typeidea script -->
<script type="text/javascript">
<?php  $ec_products = array(); ?>
  <?php 
    $ec_products = array();
    foreach ($bestSeller as $key => $product):
        $price = 0;
        array_push($ec_products, 
            array(  'id' => $product['pkey'], 
                    'name' => $product['title'], 
                    'price' => $product['variants'][0]['price'], 
                    'brand' => $product['brand']['name'], 
                    // 'category' => $product['collections'][0]['name'],
                    'list' => $url . '-bestseller-' . $CollectName, 
                    'position' => $key+1));
    endforeach; 
    ?>
    if(typeof ec_products === 'undefined'){
        var ec_products = [];
    } 
    ec_products['category-bestseller-<?php echo $CollectName; ?>'] = <?php echo jsonUnescapedUnicode(json_encode($ec_products)); ?>;

    dataLayer.push({
        'event': 'productImpressions',
        'ecommerce': {
        'currencyCode': 'PHP',
        'impressions': <?php echo jsonUnescapedUnicode(json_encode($ec_products)); ?>
        }
    });
</script>
<!-- //typeidea script -->
