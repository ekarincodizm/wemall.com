<?php
    $labelTrueYou = FALSE;
    
    if(empty($product['promotion_type'])){
        $product['promotion_type'] = null;
        $product['promotionType'] = null;
    }

    if($product['percent_discount'] != 0 ){
        
        $product['promotionType'] = 'onsale';
        $product['percentDiscount'] = $product['percent_discount'];

        if($product['promotion_type'] == 'flash_sale'){
            $product['promotionType'] = 'flashsale';
        }else{
            $product['promotionType'] = 'onsale';
        }

    }else{
        $product['promotionType'] = null;
    }

    //if have black and red comparison and show value mor
    if(!empty($product['trueyou_red_discount']) && !empty($product['trueyou_black_discount'])){
        $labelTrueYou = TRUE;
        if($product['trueyou_red_discount'] < $product['trueyou_black_discount']){
            $trueYou = $product['trueyou_black_discount'];
        }
        else if($product['trueyou_red_discount'] > $product['trueyou_black_discount']){
            $trueYou = $product['trueyou_red_discount'];
        }
        else{
            $trueYou = $product['trueyou_red_discount'];
        }
    }
    else if (!empty($product['trueyou_red_discount']) || !empty($product['trueyou_black_discount'])){
        $labelTrueYou = TRUE;
        if(!empty($product['trueyou_red_discount'])){
            $trueYou = $product['trueyou_red_discount'];
        }
        else{
            $trueYou = $product['trueyou_black_discount'];
        }
    }  
?>

<?php /* <!-- Start New SEO --> */ ?>
<?php
    if ( !empty($product['image_relate_path']) )
    {
        $imgCoverThumbSquare = $product['image_relate_path'];
    }
    elseif(empty($product['image_relate_path']) && !empty($product['default_image'])){
        $imgCoverThumbSquare = $product['default_image'];

    }else
    {
        $imgCoverThumbSquare = '';
    }
?>
<?php /* <a href="<?php echo URL::route('products.detail', $product['pkey']) ?>"> */ ?>
<a href="<?php echo get_permalink('products', $product) ?>">
    <span class="bx-link-img">
        <?php if(!empty($imgCoverThumbSquare)) : ?>
            <img src="<?php echo $imgCoverThumbSquare ?>" alt="<?php echo $product['product_name_th'] ?>" width="150" height="150">
        <?php else: ?>
            <img src="<?php echo Theme::asset()->usePath()->url('images/product/image-not-found-150.jpg') ?>" width="150" height="150">
        <?php endif; ?>

        <img src="<?php echo Theme::asset()->usePath()->url('images/detail_'.App::getLocale().'.jpg'); ?>" alt="ดูรายละเอียด <?php echo $product['product_name_th'] ?>" class="bx-view-detail">
    </span>
    <span class="p-box-info">
            <!-- start installment-->

            <?php if (!empty($product['installment_month'])) { ?>
            <span class="label-instalment pull-left">
                <span class="label-ins-text"><?php echo __('installment'); ?> </span>
                <span class="label-ins-period"><?php echo implode(',', $product['installment_month']) ?> <?php echo __('month'); ?></span>
            </span>
            <?php } ?>
             <!-- end installment-->
            <span class="name-display p-box-slide" title="<?php echo $product['product_name_th'];?>">
                <?php
                    if (App::getLocale() == 'th')
                    {
                        echo Str::limit(array_get($product, 'product_name_th'), 45);
                    } else
                    {
                        echo Str::limit(array_get($product, 'product_name_en'), 45);
                    }
                ?>
            </span>
        <!-- start show price-->    
        <?php if ($product['normal_price'] != $product['special_price'] && $product['special_price'] != 0) { ?>
            <?php
                $specialPriceStr = price_format($product['special_price']);
                $normalPriceStr = price_format($product['normal_price']);
            ?>
            <span class="price-display">
                <span class="price-special"><?php echo $specialPriceStr ?>.-</span>
                <span class="price-normal discount"><?php echo $normalPriceStr ?>.-</span>

                <!-- flashsale, onsale, itruemart-tv -->
                <?php if ($product['promotionType'] != null) { ?>
                    <span class="box-sizing label-<?php echo $product['promotionType']?> pos-lg-5">
                        <span class="box-sizing label-amount label-text-mini">
                            <span class="label-text-lg"><?php echo $product['percentDiscount']?></span>%
                        </span>
                    </span>
                <?php } ?>
            </span>
            <!-- end flashsale, onsale, itruemart-tv -->
        <?php } else { ?>
            <?php
                $normalPriceStr = price_format($product['normal_price']);
            ?>
            <span class="price-display">
                <span class="price-normal"><?php echo $normalPriceStr ?>.-</span>
            </span>
        <?php } ?>
        <!-- end show price-->  

         <?php if ( !empty($product['promotion_end']) ) { ?>
        <span class="bx-valid-box">
            <span class="valid_end"><?php echo __('promotion end'); ?></span>
            <span class="ex"><?php echo date('j M Y', strtotime($product['promotion_end'])) ?></span>
        </span>
        <?php } ?>

        <?php if ($labelTrueYou) { ?>
            <span class="trueyou-discount-display">
                <img src="<?php echo Theme::asset()->usePath()->url('images/icn/icon_trueyou.png') ?>" alt="" style="vertical-align: middle">
                <span><span class="text-red"><?php echo __('true you discount'); ?> <?php echo $trueYou .'%'?></span></span>
            </span>
        <?php } ?>
    </span>
</a>
<?php /* <!-- End New SEO --> */ ?>
