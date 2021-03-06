<?php
        $i = 0;
        $pkey_arr = array();
        // $page = $data['page'];
        // $i = $i + ($page - 1) * 20;
        if(!empty($data['data'])){
        foreach ($data['data'] as $product) {
            $pkey_arr[] = $product['pkey'];
            $product_image = '';
            if(!empty($product["image_relate_path_scale"]['m']))
            {
                $product_image = $product["image_relate_path_scale"]['m'];
            }
            else
            {
                $product_image = !empty($product["default_image_scale"]['m'])?$product["default_image_scale"]['m']: '';
            }


            $normal_price = priceMobile($product["normal_price"]);
            $special_price = priceMobile($product["special_price"]);
            $caption = '';

            if(!empty($product['caption_th']))
            {
                if(App::getLocale() == 'th')
                {
                    $caption = $product['caption_th'];
                }
                else
                {
                    if(!empty($product['caption_'.App::getLocale()]))
                    {
                        $caption = $product['caption_'.App::getLocale()];
                    }
                    else
                    {
                        $caption = $product['caption_th'];
                    }
                }
            }

            $percent_discount = 0;
            $trueyouDiscountStr = '';

            if(!empty($product['percent_discount']))
                $percent_discount = $product['percent_discount'];

            $trueyouDiscountStr = '';
            $trueyouDiscountType = '';


            $labelTrueYou = FALSE;

            if(!empty($product['trueyou_red_discount']) || !empty($product['trueyou_black_discount']))
            {
                $labelTrueYou = TRUE;
                if($product['trueyou_red_discount'] > $product['trueyou_black_discount'])
                {
                    $trueyouDiscountStr = $product['trueyou_red_discount'];
                }
                else
                {
                    $trueyouDiscountStr = $product['trueyou_black_discount'];
                }
            }

            if ($labelTrueYou == TRUE)
            {
                //$trueyouDiscountStr = ($trueyouMin == $trueyouMax) ? "{$trueyouMax}" : "{$trueyouMin}-{$trueyouMax}" ;
                $trueyouDiscountStr .= "%";
            }

            $side = 'left';
            if($i % 2 == 1)
                $side = 'right';
            $i++;

        ?>
        <?php
        $product_name = null;
        if(App::getLocale()=='th')
        {
            $product_name = array_get($product, 'product_name_th');
        }
        else
        {
            if(!empty($product['product_name_'.App::getLocale()]))
            {
                $product_name =  array_get($product, 'product_name_'.App::getLocale());
            }
            else
            {
                $product_name =  array_get($product, 'product_name_th');
            }
        }
        ?>
        <!-- SEARCH DEFAULT -->

        <div class="col-xs-6 margin-top-20 col-<?php echo $side ?>">
            <div class="view-default">
                <?php if($percent_discount > 0) { ?>
                <div class="price-tag">
                    <span class="price-red">
                        <?php echo floor($percent_discount); ?>
                    </span>
                    <img src="<?php echo Theme::asset()->usePath()->url('img/dummy_sale_tag_03.png'); ?>" alt="Sale Tags">
                </div>
                <?php } ?>
                <div class="col-xs-12">
                    <div class="product-image">
                        <?php
                        $slug = (isset($product['slug']) && !empty($product['slug'])) ? $product['slug']  : url_title($product_name);

                        ?>
                        <a href="<?php echo levelDUrl($slug, $product['pkey']); ?>">
                            <img src="<?php echo $product_image; ?>" alt="<?php echo $product_name;?>">
                        </a>
                    </div>
                </div>
                <h2 class="col-xs-12 product-name"><?php echo $product_name; ?></h2>

                <div class="col-xs-12 caption">
                    <?php if($caption != '') { ?>
                    <img src="<?php echo Theme::asset()->usePath()->url('img/icon_caption.png') ?>" alt="<?php echo $caption;?>" style="vertical-align: middle">
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
                        <div class="col-xs-6 price <?php echo $price_only;?>">
                            <?php if($special_price != '') { ?>
                            <span><?php echo $special_price; ?></span>
                            <span><?php echo $normal_price; ?></span>
                            <?php } else { ?>
                            <span style="font-style:normal; color:#959595;"><?php echo $normal_price; ?></span>
                            <?php } ?>
                        </div>
                        <?php if($labelTrueYou) { ?>
                        <div class="col-xs-6 truecard">

                            <div class="row">
                                <div class="col-xs-6"><img src="<?php echo Theme::asset()->usePath()->url('img/true_card.png') ?>" alt="True Card" style="vertical-align: middle">
                                </div>
                                <div class="col-xs-6">
                                    <p><?php echo __('discount-trueyou'); ?></p>
                                    <h3><?php echo $trueyouDiscountStr; ?></h3>
                                </div>
                            </div>


                        </div>
                        <?php } //echo $i;?>

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
        <!-- <a href="<?php //echo URL::toLang('search/view'); ?>" class="anchor_href"></a> -->
        <a href="<?php echo URL::toLang('search2/view?'.$nextQueryUrl); ?>" class="anchor_href"></a>
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