<?php if (!$showroom) { return; } ?>
<?php foreach ($showroom as $key => $showroomData): ?>
    <?php
    $products_data = array_get($showroomData, 'product');
    $products = array();
    if ($products_data) {
        $n = 1;
        foreach ($products_data as $key => $value) {
            if (strpos($value['position'], "P") > -1) {
                $products[] = $value;
                if ($n == 4){ break; }
                $n++;
            }
        }
    }

    if (count($products) > 0) {
        $layout_id = array_get($showroomData, 'layout_id', 0);
        /* typeidea script */
        $showroom_id = array_get($showroomData, 'showroom_id', 0);
        /* //typeidea script */
    ?>
        <div class="row layout_<?php echo $layout_id; ?>">
            <?php
            $showroom_url = trim(array_get($showroomData, 'showroom_link', ""));
            ?>

            <div class="col-xs-8">
                <h2 class="showroom-title">
                    <a href="<?php echo $showroom_url; ?>"><?php echo array_get($showroomData, 'showroom_title'); ?></a>
                </h2>
            </div>

            <div class="col-xs-4 button_more_new">
                <a class="btn btn-more" href="<?php echo $showroom_url; ?>"><?php echo __("more"); ?></a>
            </div>
            <?php foreach ($products as $index => $product): ?>
                <div
                    class="col-xs-6 margin-top-20 col-<?php echo ($index % 2 != 0) ? 'right' : 'left'; ?> box_<?php echo $index+1; ?>">
                    <div class="col-medium">
                        <?php if ($product['type'] == 'banner') : ?>
                        <?php
                            $thumb = array_get($product, 'thumbnail.mobile', "");
                            $link = array_get($product, 'link', "");
                            /* typeidea script */
                            $arr = explode("#", $link); 
                            $ec_banner_promo = end($arr); 
                            $product_position = array_get($product, 'position', null);
                            /* //typeidea script */
                        ?>
                        <span class="showroom-banner--container">
                            <?php if (!empty($thumb)):
                                $thumb = $thumb."?q=".md5($link);
                            ?>
                                <!-- typeidea script -->
                                <a <?php if ($link) {echo 'href="' . $link . '"';} ?>  class="ec-promotion" data-ec-promotion="<?php echo $ec_banner_promo; ?>|<?php echo $ec_banner_promo; ?>|showroom-<?php echo $showroom_id ?>-<?php echo $product_position ?>">
                                <!-- //typeidea script -->
                                    <img class="showroom-banner lazyload" data-original="<?php echo $thumb; ?>">
                                </a>
                            <?php endif; ?>
                        </span>
                        <?php else : ?>
                            <?php
                            $product_name = array_get($product, 'title', null);
                            /* typeidea script */
                            $product_key = array_get($product, 'pkey', null);
                            /* //typeidea script */
                            $product_url = array_get($product, 'link', null);
                            $product_img_path = array_get($product, 'thumbnail.mobile', "");
                            $price = str_replace(array('₱ ', ' .-'), '', array_get($product, 'price.normal.min', 0));
                            $netPrice = str_replace(array('₱ ', ' .-'), '', array_get($product, 'price.net.min', 0));
                            $normal_price_only = ($netPrice != $price) ? '' : 'class="normal-price-only"';
                            /* typeidea script */
                            $product_position = array_get($product, 'position', null);
                            /* //typeidea script */
                            
                            ?>
                            <div class="col-xs-12">
                                <div class="product-img">
                                    <!-- typeidea script -->
                                    <a href="<?php echo $product_url; ?>" class="ec-product" data-ec-item="showroom-<?php echo $showroom_id ?>|<?php echo $product_key ; ?>|<?php echo $product_position; ?>">
                                    <!-- //typeidea script -->
                                        <img  class="lazyload" data-original="<?php echo $product_img_path; ?>" alt="<?php echo $product_name; ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-12 product-name margin-top-20"><?php echo $product_name; ?></div>
                            <div class="col-xs-12 product-price">
                                <div class="row">
                                    <div class="col-xs-8">
                                        <p <?php echo $normal_price_only; ?> ><?php echo $price; ?> .-</p>
                                        <?php if ($netPrice != $price): ?>
                                            <span><?php echo $netPrice; ?>.-</span>
                                        <?php endif; ?>
                                    </div>
                                    <?php
                                    $discount = array_get($product, 'price.discount.max');
                                    if ($discount): ?>
                                        <div class="col-xs-4">
                                            <span class="price-discount"><?php echo floor($discount); ?></span>
                                            <img class="lazyload" data-original="<?php echo URL::asset('themes/mobile/assets/img/dummy_sale_tag_03.png'); ?>" alt="<?php echo $product_name; ?>">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($index == 3) {
                    break;
                } ?>
            <?php endforeach; ?>
        </div>
    <?php } ?>
<?php endforeach; ?>
<!-- typeidea script -->
<script type="text/javascript">
  <?php 
    $ec_products = array();
    $ec_banner = array();

    if ( ! empty($products)) {
        foreach ($products as $key => $product){
            if($product['type']=='product'){
                array_push($ec_products,
                array(  'id' => $product['pkey'],
                        'name' => $product['title'],
                        'list' => 'showroom-' . $showroom_id, 
                        'position' => $product['position']));
            }else if($product['type']=='banner'){
                $arr = explode("#", $product['link']); $ec_banner_promo = end($arr);
                array_push($ec_banner, array( 'id' => $ec_banner_promo, 'name' => $ec_banner_promo,'position' => 'showroom-' . $showroom_id . '-' . $product['position'] ));
            }

        }
    ?>
    if(typeof ec_products === 'undefined'){
        var ec_products = [];
    }
    ec_products['showroom-<?php echo $showroom_id; ?>'] = <?php echo jsonUnescapedUnicode(json_encode($ec_products)); ?>;


    dataLayer.push({
      'event': 'productImpressions',
      'ecommerce': {
        'currencyCode': 'PHP',
        'impressions': <?php echo jsonUnescapedUnicode(json_encode($ec_products)); ?>
      }
    });

    var ec_banner = <?php echo jsonUnescapedUnicode(json_encode($ec_banner)); ?>;
    dataLayer.push({
      'event': 'promoView',
      'ecommerce': {
        'currencyCode': 'PHP',
        'promoView': {
          "promotions": ec_banner
        }
      }
    });
    <?php
    }
    ?>
</script>
<!-- //typeidea script -->

<?php //if ($page == 1) : ?>
<!--    <div class="next-showroom-container">-->
<!--        <a href="--><?php //echo URL::toLang("home-ajax?action=showroom"); ?><!--" id="next-showroom-btn"-->
<!--           data-limit="--><?php //echo $limit; ?><!--" data-total-page="--><?php //echo $total_page; ?><!--" data-page="1"></a>-->
<!--    </div>-->
<?php //endif; ?>