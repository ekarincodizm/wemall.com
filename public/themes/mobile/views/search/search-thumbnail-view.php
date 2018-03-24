
    <?php
        $i = 0;
        $pkey_arr = array();
        if(isset($data['products'])){
        foreach ($data['products'] as $product) {
            $pkey_arr[] = $product['pkey'];
            if(isset($product['title']))
                if(App::getLocale()=='th')
                {
                    $product_title = array_get($product, 'title');
                }
                else
                {
                    if(array_get($product,'translate') != null)
                    {
                        $product_title = array_get($product, 'translate.title');
                    }
                    else
                    {
                        $product_title = array_get($product, 'title');
                    }
                }

            $product_image = '';
            if(isset($product["image_cover"]['thumbnails']['medium']))
                $product_image = $product["image_cover"]['thumbnails']['medium'];
            if(isset($product["image_cover"]['thumbnails']['large']))
                $product_image_l = $product["image_cover"]['thumbnails']['large'];
            $normal_price_min = $product['net_price_range']['min'];
            $normal_price_max = $product['net_price_range']['max'];
            $spec_price_min = $product['special_price_range']['min'];
            $spec_price_max = $product['special_price_range']['max'];
            $normal_price = '';
            $special_price = '';
            $caption = '';
            $percent_discount = 0;
            $trueyouDiscountStr = '';

            if($normal_price_min != $normal_price_max && $normal_price_min > 0)
                // $normal_price = str_replace(" .--", "-", priceMobile($normal_price_min).'-'.priceMobile($normal_price_max));
                $normal_price = priceMobile($normal_price_min, $normal_price_max);
            else
                $normal_price = priceMobile($normal_price_min);

            if($spec_price_min != $spec_price_max && $spec_price_min > 0)
                // $special_price = str_replace(" .--", "-", priceMobile($spec_price_min).'-'.priceMobile($spec_price_max));
                $special_price = priceMobile($spec_price_min, $spec_price_max);
            else
                $special_price = priceMobile($spec_price_min);

            if(isset($product['caption']))
                $caption = $product['caption'];

            if(isset($product['percent_discount']['max']))
                $percent_discount = $product['percent_discount']['max'];

            $trueyouDiscountStr = '';
            $trueyouDiscountType = '';
            $trueyouMax = 0;
            $trueyouMin = 0;
            $labelTrueYou = FALSE;

            foreach ($product['variants'] as $variant)
            {
                if ( !empty($variant['active_trueyou_discount']) )
                {
                    if ( !empty($variant['active_trueyou_discount']['red']) )
                    {
                        $labelTrueYou = TRUE;
                        $trueyouDiscountType = $variant['active_trueyou_discount']['red']['discount_type'];

                        $redDiscount = (int) $variant['active_trueyou_discount']['red']['discount'];
                        $trueyouMax = ($trueyouMax < $redDiscount) ? $redDiscount : $trueyouMax ;
                        $trueyouMin = ($trueyouMin == 0) ? $trueyouMax : $trueyouMin;
                        $trueyouMin = ($trueyouMin > $redDiscount) ? $redDiscount : $trueyouMin;
                    }

                    if ( !empty($variant['active_trueyou_discount']['black']) )
                    {
                        $labelTrueYou = TRUE;
                        $trueyouDiscountType = $variant['active_trueyou_discount']['black']['discount_type'];

                        $blackDiscount = (int) $variant['active_trueyou_discount']['black']['discount'];
                        $trueyouMax = ($trueyouMax < $blackDiscount) ? $blackDiscount : $trueyouMax ;
                        $trueyouMin = ($trueyouMin == 0) ? $trueyouMax : $trueyouMin;
                        $trueyouMin = ($trueyouMin > $blackDiscount) ? $blackDiscount : $trueyouMin;
                    }

                }
            }

            if ($labelTrueYou == TRUE)
            {
                $trueyouDiscountStr = ($trueyouMin == $trueyouMax) ? "{$trueyouMax}" : "{$trueyouMin}-{$trueyouMax}" ;
                $trueyouDiscountStr .= ($trueyouDiscountType == 'percent') ? "%" : __('Baht') ;
            }

            $side = 'left';
            if($i % 2 == 1)
                $side = 'right';
            $i++;
        ?>

        <!-- SEARCH THUMBNAIL -->

            <?php
            $product_name = null;
            if(App::getLocale()=='th')
            {
                $product_name = array_get($product,'title');
            }
            else
            {
                if(array_get($product,'translate') != null)
                {
                    $product_name =  array_get($product,'translate.title');
                }
                else
                {
                    $product_name =  array_get($product,'title');
                }
            }
            ?>
        <div class="col-xs-12 margin-top-20">
            <div class="view-thumbnail">
                <?php if($percent_discount > 0) { ?>
                <div class="price-tag">
                    <span class="price-red">
                        <?php echo floor($percent_discount); ?>
                    </span>
                    <img src="<?php echo Theme::asset()->usePath()->url('img/dummy_sale_tag_03.png'); ?>" alt="<?php echo $percent_discount;?>">
                </div>
                <?php } ?>
                <div class="product-image">
                    <?php
                    $slug = (isset($product['slug']) && !empty($product['slug'])) ? $product['slug']  : url_title($product['title']);
                    ?>
                    <a href="<?php echo levelDUrl($slug, $product['pkey']); ?>">
                        <img src="<?php echo $product_image_l; ?>" alt="<?php echo $product_name;?>">
                    </a>
                </div>
                <div class="col-xs-12 product-name"><?php echo $product_title; ?></div>
                <div class="col-xs-12 caption">
                    <?php if($caption != '') { ?>
                        <img src="<?php echo Theme::asset()->usePath()->url('img/icon_caption.png') ?>" alt="<?php echo $caption; ?>" style="vertical-align: middle">
                        <h3><?php echo $caption; ?></h3>
                    <?php } ?>
                </div>
                <div class="col-xs-12">
                    <div class="row">
                        <?php
                            $price_only = '';
                            if(empty($labelTrueYou)) {
                                $price_only = 'price_only';
                            }
                        ?>
                        <div class="col-xs-4 price <?php echo $price_only;?>">
                            <?php if($special_price != '') { ?>
                            <h2><?php echo $special_price; ?></h2>
                            <span><?php echo $normal_price; ?></span>
                            <?php } else { ?>
                            <h2 style="font-style:normal; color:#959595;"><?php echo $normal_price; ?></h2>
                            <?php } ?>
                        </div>
                        <div class="col-xs-8 truecard">
                            <?php if($labelTrueYou) { ?>
                            <div class="row">
                                <!-- <img src="img/true_card.png"> -->
                                <img src="<?php echo Theme::asset()->usePath()->url('img/true_card.png') ?>" alt="<?php echo $labelTrueYou;?>" style="vertical-align: middle">
                                <div>
                                    <p><?php echo __('discount-trueyou'); ?></p>
                                    <span><?php echo $trueyouDiscountStr; ?></span>
                                </div>
                            </div>
                            <?php } //echo $i;?>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-xs-12 rating">
                    <img class="star" src="img/star_active.png">
                    <img class="star" src="img/star_active.png">
                    <img class="star" src="img/star_active.png">
                    <img class="star" src="img/star_normal.png">
                    <img class="star" src="img/star_normal.png">
                    <span>(1,295)</span>
                </div> -->
            </div>
        </div>
        <a href="<?php echo URL::toLang('search/view'); ?>?collection=<?php echo !empty($collection)? $collection:""; ?>&q=<?php echo !empty($currentKey)?$currentKey:"";?>&viewBy=<?php echo $viewBy; ?>&orderBy=<?php echo $orderBy; ?>&order=<?php echo $order; ?>&page=<?php echo $page + 1; ?>&per_page=<?php echo $per_page ?>" class="anchor_href"></a>
        <?php }} ?>
    <?php
    $allProductIds = '';
    if(!empty($pkey_arr)){
        $allProductIds = implode('|', $pkey_arr);
    }

    $collection_name = !empty($data['collection_name'])?$data['collection_name']:'';
    ?>

    <script type="text/javascript" src="//static.criteo.net/js/ld/ld.js"></script>
    <script type="text/javascript">

        var allproductids = "<?php echo $allProductIds;?>";
        var delimiter = "|";

        var productlist = [];
        var products = allproductids.split(delimiter);

        for (var i=0;i<products.length;i++)
        {
            productlist[i] = products[i];
        }

        window.criteo_q = window.criteo_q || [];
        window.criteo_q.push(
            { event: "setAccount", account: 26653 },
            { event: "setHashedEmail", email: "<?php echo criteoGetHashEmail();?>" },
            { event: "setSiteType", type: "<?php echo criteoGetContentType();?>" },
            { event: "viewList", item: productlist, keywords: "<?php echo $collection_name;?>" }
        );
    </script>