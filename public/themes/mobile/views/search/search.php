<?php echo Theme::widget('mobileSearchBox')->render(); ?>

<?php echo Theme::widget('mobileCategoryLink')->render(); ?>
<h1 class="seo_search_mobile"> <?php if(Input::has('q')) { echo Input::get('q'); } ?> <?php echo __('seo_h1_home');?></h1>
<?php if ( ! empty($data['total_item'])) : ?>
    <?php $total_item = $data['total_item']; ?>
<?php else : ?>
<?php $total_item = 0; ?>
<?php endif; ?>

<?php echo Theme::widget('viewBy', array('totalItems' => $total_item))->render(); ?>

<?php
$sortBy = array(
    'orderBy' => $orderBy,
    'order' => $order
);

?>

<?php echo Theme::widget('sortBy', $sortBy)->render(); ?>
<input type="hidden" name="per_page" id="per_page" value="<?php echo $per_page;?>">
<div id="load-more" data-page="1" total-page="<?php echo $data['total_page']; ?>" style="display:none;" data-href="<?php echo URL::toLang('search/view'); ?>"></div>
<div class="row search_content" id="pkey-content"
     data-collection="<?php echo !empty($collection)?$collection:""; ?>"
     data-keyword="<?php echo !empty($currentKey)?$currentKey:""; ?>">
    <?php /*
        $i = 0;
        if(isset($data['products'])){
        foreach ($data['products'] as $product) {
            if(isset($product['title']))
                if(App::getLocale() == 'th')
                    $product_title = $product['title'];
                else
                    $product_title = $product['translate']['title'];

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
                $normal_price = str_replace(" .--", "-", priceMobile($normal_price_min).'-'.priceMobile($normal_price_max));
            else
                $normal_price = priceMobile($normal_price_min);

            if($spec_price_min != $spec_price_max && $spec_price_min > 0)
                $special_price = str_replace(" .--", "-", priceMobile($spec_price_min).'-'.priceMobile($spec_price_max));
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
                $trueyouDiscountStr .= ($trueyouDiscountType == 'percent') ? " %" : __('Baht') ;
            }

            $side = 'left';
            if($i % 2 == 1)
                $side = 'right';
            $i++;
        ?>

        <!-- SEARCH DEFAULT -->

        <div class="col-xs-6 margin-top-20 col-<?php echo $side ?>">
            <div class="view-default">
                <?php if($percent_discount > 0) { ?>
                <div class="price-tag">
                    <span class="price-red">
                        <?php echo floor($percent_discount); ?>
                    </span>
                    <img src="<?php echo Theme::asset()->usePath()->url('img/dummy_sale_tag_03.png'); ?>">
                </div>
                <?php } ?>
                <div class="col-xs-12">
                    <div class="product-image">
                        <a href="<?php echo levelDUrl($product['slug'], $product['pkey']); ?>">
                            <img src="<?php echo $product_image; ?>">
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 product-name"><?php echo $product_title; ?>
                </div>

                <div class="col-xs-12 caption">
                    <?php if($caption != '') { ?>
                    <img src="<?php echo Theme::asset()->usePath()->url('img/icon_caption.png') ?>" alt="" style="vertical-align: middle">
                    <span><?php echo $caption; ?></span>
                    <?php } ?>
                </div>

                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-6 price">
                            <?php if($special_price != '') { ?>
                            <h2><?php echo $special_price; ?></h2>
                            <span><?php echo $normal_price; ?></span>
                            <?php } else { ?>
                            <?php echo $normal_price; ?>
                            <?php } ?>
                        </div>

                        <div class="col-xs-6 truecard">
                            <?php if($labelTrueYou) { ?>
                            <div class="row">
                                <div class="col-xs-6"><img src="<?php echo Theme::asset()->usePath()->url('img/true_card.png') ?>" alt="" style="vertical-align: middle">
                                </div>
                                <div class="col-xs-6">
                                    <p><?php echo __('true you discount'); ?></p>
                                    <span><?php echo $trueyouDiscountStr; ?></span>
                                </div>
                            </div>
                            <?php } ?>
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

        <?php }} */?>
        <!-- <a href="<?php //echo URL::toLang('search/view'); ?>" class="anchor_href"></a> -->
        <!-- <a href="<?php //echo URL::toLang('search/view'); ?>?collectionKey=samsung&viewBy=default&page=2&orderBy=price&orderType=desc" class="anchor_href"></a> -->
</div>


