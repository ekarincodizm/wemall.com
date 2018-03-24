    <?php   
        /* typeidea script */
        $collection_name = !empty($data['collection_name'])?$data['collection_name']:'';
        /* //typeidea script */
        if ( ! empty($data['products'])) : ?>
        <?php $i = 0; $pkey_arr = array();?>
        <?php foreach ($data['products'] as $key => $value) : ?>

            <?php
            $pkey_arr[] = $value['pkey'];
            $product_name = null;
            if(App::getLocale()=='th')
            {
                $product_name = array_get($value,'title');
            }
            else
            {
                if(array_get($value,'translate') != null)
                {
                    $product_name =  array_get($value,'translate.title');
                }
                else
                {
                    $product_name =  array_get($value,'title');
                }
            }
            ?>

            <?php $side = ($i % 2) ? "right" : "left"; ?>
            <?php #alert($value, 'green'); ?>
            <div class="col-xs-6 margin-top-20 col-<?php echo $side; ?>">
                <div class="view-default overflow-hidden">
                    <?php if ( ! empty($value['percent_discount']['max'])) : ?>
                        <div class="price-tag">
                            <span class="price-red"><?php $percent_discount = floor($value['percent_discount']['max']); echo $percent_discount>=100 ? 99: $percent_discount; ?></span>

                            <img src="<?php echo Theme::asset()->usePath()->url('img/dummy_sale_tag_03.png'); ?>">

                        </div>
                    <?php endif; ?>
                    <div class="col-xs-12"><div class="product-image">
                            <?php
                            $slug = (isset($value['slug']) && !empty($value['slug'])) ? $value['slug']  : url_title($value['title']);
                            ?>
                            <!-- typeidea script -->
                            <a href="<?php echo levelDUrl($slug, $value['pkey']); ?>" class="ec-product" data-ec-item="category-<?php echo $collection_name; ?>|<?php echo $value['pkey']; ?>|<?php echo (($page-1)*20) + $key+1; ?>"><img src="<?php echo ( ! empty($value['image_cover']['normal'])) ? $value['image_cover']['normal'] : ""; ?>" alt="<?php echo $product_name; ?>"></a></div></div>
                            <!-- //typeidea script -->
                    <div class="col-xs-12 product-name">
                        <h2>
                        <?php if (App::getLocale() == 'th') : ?>
                            <?php echo $value['title']; ?>
                        <?php else : ?>
                            <?php echo ( ! empty($value['translate']['title'])) ? $value['translate']['title'] : $value['title']; ?>
                        <?php endif; ?>
                        </h2>
                    </div>
                    <?php if ( ! empty($value['caption'])) : ?>
                        <div class="col-xs-12 caption">
                            <img src="<?php echo Theme::asset()->usePath()->url('img/icon_caption.png'); ?>" alt="<?php echo $value['caption']; ?>"><span><?php echo $value['caption']; ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="col-xs-12">
                        <div class="row">
                            <?php
                                $price_only = '';
                                if ( empty($value['active_trueyou_discount'])) {
                                    $price_only = 'price_only';
                                }
                            ?>
                            <div class="col-xs-6 price <?php echo $price_only; ?>">
                                <?php if ( ! empty($value['special_price_range']['min']) && ! empty($value['special_price_range']['max'])) : ?>
                                    <?php if ($value['net_price_range']['min'] == $value['net_price_range']['max']) : ?>
                                        <span><?php echo priceMobile($value['price_range']['min']); ?></span>
                                        <span><?php echo priceMobile($value['net_price_range']['min']); ?></span>

                                    <?php else : ?>
                                        <span><?php echo priceMobile($value['price_range']['min'], $value['price_range']['max']); ?></span>
                                        <span><?php echo priceMobile($value['net_price_range']['min'], $value['net_price_range']['max']); ?></span>

                                    <?php endif; ?>
                                <?php else : ?>
                                    <?php if ($value['price_range']['min'] == $value['price_range']['max']) : ?>
                                        <span class="normal-price-only"><?php echo priceMobile($value['price_range']['min']); ?></span>
                                    <?php else : ?>
                                        <span class="normal-price-only"><?php echo priceMobile($value['price_range']['min'], $value['price_range']['max']); ?></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php /**
                                <h2>4,000.-</h2>
                                <span>9,900.-</span>
                                 *                      **/ ?>
                            </div>
                            <?php if ( ! empty($value['active_trueyou_discount'])) : ?>
                                <div class="col-xs-6 truecard">
                                    <div class="row">
                                        <div class="col-xs-6"><img src="<?php echo Theme::asset()->usePath()->url('img/true_card.png'); ?>" alt="True Card"></div>
                                        <div class="col-xs-6">
                                            <p><?php echo __("discount-trueyou"); ?></p>
                                            <?php if ( ! empty($value['active_trueyou_discount']['black']) && ! empty($value['active_trueyou_discount']['red'])) : ?>
                                                <span><?php echo $value['active_trueyou_discount']['red']['discount']; ?>-<?php echo $value['active_trueyou_discount']['black']['discount']; ?>%</span>
                                            <?php elseif ( ! empty($value['active_discount']['black'])) : ?>
                                                <span><?php echo $value['active_trueyou_discount']['black']; ?></span>
                                            <?php else : ?>
                                                <span><?php echo $value['active_trueyou_discount']['red']; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>

            <a href="<?php echo URL::toLang('cate/search-view'); ?>?collectionKey=<?php echo $currentKey; ?>&viewBy=<?php echo $viewBy; ?>&orderBy=<?php echo $orderBy; ?>&order=<?php echo $order; ?>&page=<?php echo $page + 1; ?>" class="anchor_href"></a>

            <?php $i++; ?>
        <?php endforeach; ?>
    <?php else : ?>
        <div id="no-category" class="col-xs-12 margin-top-20 col-left">
            No Data
        </div>
    <?php endif; ?>

    <?php
        $allProductIds = '';
        if(!empty($pkey_arr)){
            $allProductIds = implode('|', $pkey_arr);
        }

        $collection_name = !empty($data['collection_name'])?$data['collection_name']:'';
    ?>
    <script type="text/javascript">

        var allproductids = "<?php echo $allProductIds;?>";
        var delimiter = "|";

        var productlist = [];
        var products = allproductids.split(delimiter);

        for (var i=0;i<products.length;i++)
        {
            productlist[i] = products[i];
        }
    </script>

    <?php if (Theme::get('criteo_tag')): ?>
        <?php echo Theme::get('criteo_tag');?>
    <?php endif; ?>

<!-- typeidea script -->
<script type="text/javascript">
<?php  $ec_products = array(); ?>
  <?php 
    $ec_products = array();
    if ( ! empty($data['products'])) :
        foreach ($data['products'] as $key => $product):
            array_push($ec_products,
                array(  'id' => $product['pkey'],
                        'name' => $product['title'],
                        'price' => $product['variants'][0]['price'],
                        'brand' => $product['brand']['name'],
                        // 'category' => $product['collections'][0]['name'],
                        'list' => 'category-' . $collection_name,
                        'position' => (($page-1)*20) + $key+1));
        endforeach;
    endif;
    ?>
    <?php if($page==1): ?>
        var ec_products = [];
        ec_products['category-<?php echo $collection_name; ?>'] = [];
    <?php endif; ?>
    ec_products['category-<?php echo $collection_name; ?>'] = $.merge(ec_products['category-<?php echo $collection_name; ?>'], <?php echo jsonUnescapedUnicode(json_encode($ec_products)); ?>);
    dataLayer.push({
      'event': 'productImpressions',
      'ecommerce': {
        'currencyCode': 'PHP',
        'impressions': <?php echo jsonUnescapedUnicode(json_encode($ec_products)); ?>
      }
    });
</script>
<!-- //typeidea script -->

