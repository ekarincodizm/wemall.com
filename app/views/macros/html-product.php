<?php
    $labelDelivery = FALSE;
    $labelTrueStore = FALSE;
    $labelSoldOut = FALSE;
    $labelInstallment = FALSE;
    $labelTrueYou = FALSE;
    $labelDiscount = 0;
    $discountPercentFromBaht = 0;
    $labelShowInstallmentVariant = FALSE;
    
    // if (TRUE)
    // {
    //     $labelDelivery = TRUE;
    // }

    // if (TRUE)
    // {
    //     $labelTrueStore = TRUE;
    // }

    // if (TRUE)
    // {
    //     $labelSoldOut = TRUE;
    // }

    if (!empty($product['installment']) && !empty($product['installment']['allow']) && $product['installment']['allow'] == TRUE && !empty($product['installment']['periods']))
    {

        $labelInstallment = TRUE;
        $test_installment = array();
        foreach ($product['variants'] as $variant)
        {
            if(!empty($variant['installment']['periods']))
            {
                $labelShowInstallmentVariant = TRUE;
                $test_installment = array_merge($variant['installment']['periods'],$product['installment']['periods']);
                sort($test_installment);
                $test_installment = array_unique($test_installment);
            }

        }

    }

    if (!empty($product['percent_discount']['max']) && $product['percent_discount']['max'] > 0)
    {

        $labelDiscount = (int) $product['percent_discount']['max'];

    }

    $trueyouDiscountStr = '';
    $trueyouDiscountType = '';
    $trueyouMax = 0;
    $trueyouMin = 0;
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


        if ( !empty($variant['active_special_discount']) )
        {

            /*
            * Discount Type
            * percent
            *
             */

            if ($variant['active_special_discount']['discount_type'] == 'percent')
            {
                if ( !empty($variant['active_special_discount']['campaign_type']) )
                {
                    //Log::info("Special discount [Percent] [inventory_id:".$variant['inventory_id'].", labelDiscount: ".$labelDiscount.", discountFromSpecialDiscount: :".$variant['active_special_discount']['discount']."]");


                    if($labelDiscount == $variant['active_special_discount']['discount'])
                    {
                        $discountType = $variant['active_special_discount']['campaign_type'];
                    }
                    else
                    {
                        $discountType = 'onsale';
                    }
                }
                else
                {
                    $discountType = 'onsale';
                }
            }
            else
            {
                // (normal_price - discount_price) / (normal_price * 100)
                $a = $variant['normal_price'] - $variant['active_special_discount']['discount_price'] ;
                $b = $variant['normal_price'];
                $c = (int) ($a * 100 / $b);
                $discountPercentFromBaht = $c;

                if ( !empty($variant['active_special_discount']['campaign_type']) )
                {
                    //Log::info("Special discount [Bath] [inventory_id:".$variant['inventory_id'].", labelDiscount: ".$labelDiscount.", discountFromBath: :".$discountPercentFromBaht."]");
                    //Log::info("KKK - Normal Price: ".$variant['normal_price'].", Special Discount: ".$variant['active_special_discount']['discount_price']."");
                    if($labelDiscount == $discountPercentFromBaht)
                    {
                        $discountType = $variant['active_special_discount']['campaign_type'];
                    }
                    else
                    {
                        $discountType = 'onsale';
                    }
                }
                else
                {
                    $discountType = 'onsale';
                }
            }

        }



    }

    if ($labelTrueYou == TRUE)
    {
        $trueyouDiscountStr = ($trueyouMin == $trueyouMax) ? "{$trueyouMax}" : "{$trueyouMin}-{$trueyouMax}" ;
        $trueyouDiscountStr .= ($trueyouDiscountType == 'percent') ? " %" : __('Baht') ;
    }
?>

<?php /* <!-- Start New SEO --> */ ?>
<?php
    if ( !empty($product['image_cover']['thumbnails']['square']) )
    {
        $imgCoverThumbSquare = $product['image_cover']['thumbnails']['square'];
    }
    else
    {
        $imgCoverThumbSquare = '';
    }
?>
<?php /* <a href="<?php echo URL::route('products.detail', $product['pkey']) ?>"> */ ?>
<!-- typeidea script -->
<a href="<?php echo get_permalink('products', $product) ?>" class="ec-product" data-ec-item="<?php echo $product['list_collection']; ?>|<?php echo $product['pkey']; ?>|<?php echo $product['list_position']; ?>">
<!-- //typeidea script -->
    <span class="bx-link-img">

        <?php if(!empty($imgCoverThumbSquare)) : ?>
            <img src="<?php echo $imgCoverThumbSquare ?>" alt="<?php echo $product['title'] ?>" width="150" height="150">
        <?php else: ?>
            <img src="<?php echo Theme::asset()->usePath()->url('images/product/image-not-found-150.jpg') ?>" width="150" height="150">
        <?php endif; ?>

        <img src="<?php echo Theme::asset()->usePath()->url('images/detail_'.App::getLocale().'.jpg'); ?>" alt="ดูรายละเอียด <?php echo $product['title'] ?>" class="bx-view-detail">

        <?php if ($labelDelivery) { ?>lev
            <span class="label-delivery pos-lg-1"><?php echo __('รับสินค้า'); ?> 1-2 <?php echo __('days'); ?></span>
        <?php } ?>

        <?php if ($labelTrueStore) { ?>
            <span class="label-truestore pos-lg-2"><span class="label-ts-text"><?php echo __('เครื่องศูนย์'); ?> True</span></span>
        <?php } ?>

        <?php if ($labelSoldOut) { ?>
            <img src="<?php echo Theme::asset()->usePath()->url('images/label/soldout.png') ?>" alt="" class="bx-soldout" />
        <?php } ?>
    </span>
    <span class="p-box-info">

            <?php if ($labelInstallment == TRUE) { ?>
            <span class="label-instalment pull-left">
                <span class="label-ins-text"><?php echo __('installment'); ?> </span>
                <span class="label-ins-period"><?php echo (!empty($test_installment)) ? implode(',', $test_installment) : implode(',', $product['installment']['periods']) ?> <?php echo __('month'); ?></span>
            </span>
            <?php } ?>

            <span class="name-display p-box-slide" title="<?php echo $product['title'];?>">
                <?php
                    if (App::getLocale() == 'th')
                    {
                        echo Str::limit(array_get($product, 'title'), 45);
                    } else
                    {
                        if (array_get($product, 'translate') != null)
                        {
                            echo Str::limit(array_get($product, 'translate.title'), 45);
                        } else
                        {
                            echo Str::limit(array_get($product, 'title'), 45);
                        }
                    }
                ?>
            </span>

        <?php if ($product['special_price_range']['max'] || $product['special_price_range']['min']) { ?>
            <?php
                $specialPriceStr = ($product['price_range']['max'] == $product['price_range']['min']) ? price_format($product['price_range']['max']) : price_format($product['price_range']['min']) . ' - ' . price_format($product['price_range']['max']) ;
                $normalPriceStr = ($product['net_price_range']['max'] == $product['net_price_range']['min']) ? price_format($product['net_price_range']['max']) : price_format($product['net_price_range']['min']) . ' - ' . price_format($product['net_price_range']['max']) ;
            ?>
            <span class="price-display">
                <span class="price-special"><?php echo $specialPriceStr ?>.-</span>
                <span class="price-normal discount"><?php echo $normalPriceStr ?>.-</span>

                <!-- flashsale, onsale, itruemart-tv -->
                <?php if ($labelDiscount > 0) { ?>
                    <?php
                        if (isset($discountType) && $discountType == 'flash_sale')
                        {
                            $labelDiscountClass = 'flashsale';
                        }
                        else
                        {
                            $labelDiscountClass = 'onsale';
                        }
                    ?>
                    <span class="box-sizing label-<?php echo $labelDiscountClass?> pos-lg-5">
                        <span class="box-sizing label-amount label-text-mini">
                            <span class="label-text-lg"><?php echo $labelDiscount ?></span>%
                        </span>
                    </span>
                <?php } ?>
            </span>
        <?php } else { ?>
            <?php
                $normalPriceStr = ($product['price_range']['max'] == $product['price_range']['min']) ? price_format($product['price_range']['max']) : price_format($product['price_range']['min']) . ' - ' . price_format($product['price_range']['max']) ;
            ?>
            <span class="price-display">
                <span class="price-normal"><?php echo $normalPriceStr ?>.-</span>
            </span>
        <?php } ?>

        <?php if ( !empty($product['discount_ended']) ) { ?>
        <span class="bx-valid-box">
            <span class="valid_end"><?php echo __('promotion end'); ?></span>
            <span class="ex"><?php echo date('j M Y', strtotime($product['discount_ended'])) ?></span>
        </span>
        <?php } ?>

        <?php if ($labelTrueYou) { ?>
            <span class="trueyou-discount-display">
                <img src="<?php echo Theme::asset()->usePath()->url('images/icn/icon_trueyou.png') ?>" alt="" style="vertical-align: middle">
                <span><span class="text-red"><?php echo __('true you discount'); ?> <?php echo $trueyouDiscountStr ?></span></span>
            </span>
        <?php } ?>
    </span>
</a>
<?php /* <!-- End New SEO --> */ ?>
