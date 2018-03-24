<?php

$language = Lang::locale();
?>
<?php
if(App::getLocale()=='th')
{
    $title = array_get($product, 'title');
}
else
{
    if(array_get($product,'translate') != null)
    {
        $title = array_get($product, 'translate.title');
    }
    else
    {
        $title = array_get($product, 'title');
    }
}

?>
<div id="share-button">
    <a id="facebook-share" style="cursor: pointer;">
        <img class="fb_share" src="<?php echo Theme::asset()->usePath()->url('img/s_facebook.png')?>" alt="Share <?php echo $title ?> On Facebook"></a>
    <a id="twitter-share" style="cursor: pointer;">
        <img class="tw_share" src="<?php echo Theme::asset()->usePath()->url('img/s_twitter.png')?>" alt="Share <?php echo $title ?> On twitter"></a>
    <a id="gplus-share" style="cursor: pointer;">
        <img class="gp_share" src="<?php echo Theme::asset()->usePath()->url('img/s_googleplus.png')?>" alt="Share <?php echo $title ?> On Google Plus"></a>
    <a style="cursor: pointer;" href="mailto:?Subject=<?php echo isset($product['translate']['title']) ? $product['translate']['title'] : "iTruemart"; ?>&body=<?php echo str_replace("http://m.", "http://www.", get_permalink('products', $product)); ?>" id="email-share"><img class="" src="<?php echo Theme::asset()->usePath()->url('img/s_email.png')?>"></a>
    <div style="cursor: pointer;" href="#" id="button-share">Share</div>
</div>

<!-- Search -->
<?php echo Theme::widget('WidgetMobileSearchBox')->render(); ?>

<!-- Category -->
<?php echo Theme::widget('WidgetMobileCategoryLink')->render(); ?>

<!-- Banner Everyday wow : มีหรือไม่มีก็ได้-->
<?php
/*
<div class="row margin-top-20">
    <div class="img-align-center"><img src="<?php echo Theme::asset()->usePath()->url('img/dummy_banner_640.png'); ?>"></div>
</div>
 */
?>

<!-- Product Name -->
<div class="row product-name">
    <div class="col-xs-12">
        <h1><?php echo $title; ?></h1>
        <!--<p>สนุกกับแอพ Android ที่ใช่ สไลด์เดียวเข้าถึงทุกแอพที่ชอบ</p>-->
    </div>
</div>

<!-- Caption -->
<?php if ( ! empty($product['caption'])): ?>
<div class="row box-caption">
    <div>
        <img src="<?php echo Theme::asset()->usePath()->url('img/icon_caption.png'); ?>" alt="<?php echo $title ?> <?php echo $product['caption']; ?>"><span><?php echo $product['caption']; ?></span>
    </div>
</div>
<?php endif; ?>

<!-- time-remain : มีหรือไม่มีก็ได้ -->
<?php if ( ! empty($product['discount_ended'])): ?>
<div class="row">
    <div class="col-xs-12 time-remaining">
        <?php
            $dateTime = new DateTime($product['discount_ended']);
        ?>
        <span class="glyphicon glyphicon-time"></span> <?php echo __('time_left_to_buy'); ?> <span style="color:#444444;" id="countdown-discount" data-datetime="<?php echo $dateTime->format('Y-m-d H:i:s'); ?>"></span>
    </div>
</div>
<?php endif; ?>

<!-- Porudct image -->
<div class="row product-image">
    <?php if (number_format($product['percent_discount']['max']) > 0): ?>
        <div class="price-tag"><span class="price-red"><?php echo floor($product['percent_discount']['max']); ?></span>
            <img src="<?php echo Theme::asset()->usePath()->url('img/dummy_sale_tag_03.png'); ?>" alt="<?php echo $title ?> Sales Tag"></div>
    <?php endif; ?>
    <div class="swiper-product-container product">
        <div class="swiper-wrapper">
            <?php foreach ($product['media_contents'] as $media_content): ?>
                <div class="swiper-slide"> <img src="<?php echo $media_content['thumb']['thumbnails']['large']; ?>" alt="<?php echo $title ?> Photo"> </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="pagination product"></div>
</div>

<div class="variant-price" style="display: none;">
    <div class="row normal-price">
        <div class="col-xs-5"><?php echo __('Net Price'); ?></div>
        <div class="col-xs-7"><span class="number_price style-line-through"></span> <?php echo __('cart-baht-lbl'); ?> <span class="each">/<?php echo __('piece'); ?></span></div>
    </div>
    <div class="row special-price box-padding">
        <div class="col-xs-5"><?php echo __('Discount Price'); ?></div>
        <div class="col-xs-7"><span class="number_price"></span> <?php echo __('cart-baht-lbl'); ?> <span class="each">/<?php echo __('piece'); ?></span></div>
    </div>
</div>

<div class="product-price">
    <!-- Price -->
    <?php if ( ($product['price_range']['min'] < $product['net_price_range']['min']) || ($product['price_range']['max'] < $product['net_price_range']['max']) ): ?>
        <div class="row normal-price">
            <div class="col-xs-5"><?php echo __('Net Price'); ?></div>
            <div class="col-xs-7"><span class="number_price style-line-through"><?php echo showPrice($product['net_price_range']['min'], $product['net_price_range']['max'], "%s", ""); ?></span> <?php echo __('cart-baht-lbl'); ?> <span class="each">/<?php echo __('piece'); ?></span></div>
        </div>
        <div class="row special-price box-padding">
            <div class="col-xs-5"><?php echo __('Discount Price'); ?></div>
            <div class="col-xs-7"><span class="number_price"><?php echo showPrice($product['price_range']['min'], $product['price_range']['max'], "%s", ""); ?></span> <?php echo __('cart-baht-lbl'); ?> <span class="each">/<?php echo __('piece'); ?></span></div>
        </div>
    <?php else: ?>
    <div class="row normal-price">
        <div class="col-xs-5"><?php echo __('Net Price'); ?></div>
        <div class="col-xs-7"><span class="number_price"><?php echo showPrice($product['price_range']['min'], $product['price_range']['max'], "%s", ""); ?></span> <?php echo __('cart-baht-lbl'); ?> <span class="each">/<?php echo __('piece'); ?></span></div>
    </div>
    <?php endif; ?>
</div>

<script>
    var styleOptionAvaliable = <?php echo json_encode($styleOptionAvaliable); ?>;
    var inventoryImage = <?php echo json_encode($inventoryImage); ?>;
</script>

<!-- Product option -->
<div class="row product-option">
    <div class="product-style_types">
        <?php foreach(array_get($product, 'style_types') ?: array() as $styleType): ?>
        <?php $option_exists = array_get($styleType, 'options', array()); ?>
        <?php if (!empty($option_exists)): ?>
            <div class="col-xs-12 style-type">
                <span class="option-title">
                    <?php echo __("select"); ?> <?php echo __(array_get($styleType, 'name')); ?>
                </span>
            </div>
            <div class="col-xs-12 style-options" data-style-type-name="<?php echo array_get($styleType, 'name'); ?>">
                <?php foreach (array_get($styleType, 'options') ?: array() as $key => $styleOption): ?>
                    <a><div class="style-option" data-style-option-pkey="<?php echo array_get($styleOption, 'pkey'); ?>">
                    <?php
                        $styleOptionType = array_get($styleOption, 'meta.type');
                        switch ($styleOptionType) {
                            case 'image':
                                echo '<img src="'.array_get($styleOption, 'meta.value').'" alt="Style '.$title.'">';
                                break;
                            case 'text':
                                echo '<span class="text">'.array_get($styleOption, 'meta.value').'</span>';
                                break;
                            case 'color':
                                echo '<span class="color" style="background:'.array_get($styleOption, 'meta.value').';"></span>';
                                break;
                            default:
                                echo array_get($styleOption, 'text');
                                break;
                        }
                    ?>
                    </div></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php /*
    <!-- รุ่น -->
    <div class="col-xs-12"><h2>เลือกรุ่น</h2></div>
    <div class="col-xs-12">
        <a href="#"><div class="capacity-option">16 GB</div></a>
        <a href="#"><div class="capacity-option active">32 GB</div></a>
        <a href="#"><div class="capacity-option disable"><img src="<?php echo Theme::asset()->usePath()->url('img/cross.png'); ?>">64 GB</div></a>
    </div>
    <!-- เลือกสี -->
    <div class="col-xs-12"><h2>เลือกสี</h2></div>
    <div class="col-xs-12">
        <!-- change color by using background color css -->
        <a href="#"><div class="color-option"><span style="background:#49a430;"></span></div></a>
        <a href="#"><div class="color-option active"><span style="background:#4390ee;"></span></div></a>
        <a href="#"><div class="color-option disable"><img src="<?php echo Theme::asset()->usePath()->url('img/cross.png'); ?>"><span style="background:#ff8604;"></span></div></a>
    </div>
*/ ?>

    <!-- เลือกจำนวน -->
    <div class="col-xs-12">
        <div class="row quantity">
            <div class="col-xs-4"><?php echo __('select_total'); ?></div>
            <div class="col-xs-3">
                <?php if($is_wow): ?>
                <?php $qty = range(0, 1); unset($qty[0]); ?>
                <?php else: ?>
                <?php $qty = range(0, 5); unset($qty[0]); ?>
                <?php endif; ?>
                <?php echo Form::select('qty', $qty, 1, array('class' => 'form-control qty')); ?>
            </div>
        </div>
    </div>
    <!-- สถานะ -->
    <div class="col-xs-12 status-holder">
        <div class="row status">
            <div class="col-xs-4"><?php echo __("Status_mobile");?></div>
            <div class="col-xs-8 status-indicator"></div>

            <!-- <div class="col-xs-8 status-indicator" style="color:#95c126;"><img src="<?php //echo Theme::asset()->usePath()->url('img/icon_check_green.png'); ?>"> มีสินค้า</div> -->
            <!-- <div class="col-xs-8" style="color:#959595;"><img src="<?php //echo Theme::asset()->usePath()->url('img/icon_out_of_stock.png'); ?>"> สินค้าหมด</div> -->
        </div>
    </div>
</div>

<!-- Buy Button -->
<?php
if(Config::get('maintenance.show_btn') == true)
{
?>
        <div class="row button-buy add-to-cart" data-inventory-id="" data-stock="" data-wow="<?php echo $this_wow_product_in_cart; ?>">
            <div class="col-xs-12"><a href="javascript: void(0);" class="button"><div class="button"><span><?php echo __('buy now'); ?></span></div></a></div>
        </div>
<?php } ?>

<!-- Promotion Code Manual -->
<div class="row promotion-manual-popup">
    <div class="col-xs-12">
        <a href="javascript:void(0);" data-toggle="modal" data-target="#howToUseCouponPopup" class="itruemart-link" data-id="promotion-popup-button">
            <span><?php echo __("how-to-use-coupon-button");?></span>
            <img src="<?php echo Theme::asset()->usePath()->url("img/mobile-ico-what.png"); ?>"  alt="how to use itruemart's coupon"/>
        </a>
    </div>
</div>

<!-- pay channel -->
<div class="row pay-channel">
    <div class="col-xs-12"><h2><?php echo __('Payment Channel'); ?></h2></div>
<!--    <div class="col-xs-12"><img src="--><?php //echo Theme::asset()->usePath()->url('img/icon_pay_channel.png'); ?><!--"></div>-->

    <div class="col-xs-12">
        <?php if ( ! empty($product['bank_installments'])){ ?>
<!--            <img style="width: 69px;" src="--><?php //echo Theme::asset()->usePath()->url('img/icon_pay_channel_installment.png'); ?><!--" alt="--><?php //echo $title ?><!-- can pay by visa master">-->
        <?php };?>
        <?php
        $check_channel = false;
        foreach($product['payment_methods'] as $key => $row) { ?>
            <?php
            $clower = strtolower($row['code']);
            switch ($clower) :
                case 'ibank':
                    ?>
                    <img style="width: 69px;"
                         src="<?php echo Theme::asset()->usePath()->url('img/icon_pay_channel_online_banking.png'); ?>"
                         alt="<?php echo __("payment_ibank"); ?>">
                <?php
                    $check_channel = true;
                    break;
                case 'cod':
                    ?>
                    <img style="width: 69px;"
                         src="<?php echo Theme::asset()->usePath()->url('img/icon_pay_channel_cod.png'); ?>"
                         alt="<?php echo __("payment_cod"); ?>">
                    <?php
                    $check_channel = true;
                    break;
                default:
            ?>
            <?php
            endswitch;
        }
        if(!$check_channel){?>
            <span style="color: #afafaf; ">Payment option not available on mobile</span>
        <?php
        }
        ?>

<!--        <img style="width: 69px;" src="--><?php //echo Theme::asset()->usePath()->url('img/icon_pay_channel_visa.png'); ?><!--" alt="--><?php //echo $title ?><!-- can pay by visa master">-->
    </div>
</div>

<!-- Installment & Promotion -->
<?php //echo Theme::widget('productsPromotion', array('product' => $product))->render(); ?>


<!-- ของแถม -->
<?php
/*
<div class="row box-padding">
    <div class="col-xs-12 img-align-center"><img src="<?php echo Theme::asset()->usePath()->url('img/dummy_banner.jpg'); ?>"></div>
</div>
 */
?>


<?php echo Theme::widget('productsPromotion', array('product' => $product))->render(); ?>

<!-- คุณสมบัติ -->
<div class="row row-feature box-padding">
    <div class="col-xs-12">
        <h2><?php echo __('Product Specifications'); ?></h2>
        <!-- recommend use <table></table> -->
        <?php
        if(App::getLocale()=='th')
        {
            $key_feature = array_get($product, 'key_feature');
        }
        else
        {
            if(array_get($product,'translate') != null)
            {
                $key_feature = array_get($product, 'translate.key_feature');
            }
            else
            {
                $key_feature = array_get($product, 'key_feature');
            }
        }
        ?>
        <?php echo $key_feature; ?>
    </div>
</div>

<!-- สรุปข้อดี -->
<?php if ( ! empty($product['advantage'])): ?>
<div class="row summary box-padding">
    <div class="col-xs-12">
        <h2><?php echo __('Benefits'); ?>  </h2>
        <?php
        if(App::getLocale()=='th')
        {
            $advantage = array_get($product, 'advantage');
        }
        else
        {
            if(array_get($product,'translate') != null)
            {
                $advantage = array_get($product, 'translate.advantage');
            }
            else
            {
                $advantage = array_get($product, 'advantage');
            }
        }
        ?>
        <?php echo $advantage; ?>
    </div>
</div>
<?php endif; ?>

<!-- รายละเอียด -->
<div class="row box-padding">
    <div class="col-xs-12">
        <?php
        $slug = (isset($product['slug']) && !empty($product['slug'])) ? $product['slug']  : url_title($product['title']);
        ?>
        <a href="<?php echo levelDUrl('detail/'.$slug, $product['pkey']) ?>"><div class="box_more"><?php echo __('Product Detail'); ?> <img src="<?php echo Theme::asset()->usePath()->url('img/arrow_more.png'); ?>"></div></a>
    </div>
</div>

<!-- Policy 3 tab -->
<!-- Nav tabs -->
<ul class="nav nav-tabs margin-top-20">
    <?php if (isset($policies['shipping'])): ?>
    <li class="active take-all-space-you-can"><a href="#freedelivery" role="tab" data-toggle="tab">
            <img src="<?php echo Theme::asset()->usePath()->url('img/policy_01.png'); ?>" alt="<?php echo $title ?> Policy free Delivery"> </a></li>
    <?php endif; ?>
    <?php if (isset($policies['refund'])): ?>
    <li class="take-all-space-you-can"><a href="#moneyback" role="tab" data-toggle="tab">
            <img src="<?php echo Theme::asset()->usePath()->url('img/policy_02.png'); ?>" alt="<?php echo $title ?> Policy Money Back"> </a></li>
    <?php endif; ?>
    <?php if (isset($policies['returnItem'])): ?>
    <li class="take-all-space-you-can"><a href="#returns" role="tab" data-toggle="tab">
            <img src="<?php echo Theme::asset()->usePath()->url('img/policy_03.png'); ?>" alt="<?php echo $title ?> Policy Return"> </a></li>
    <?php endif; ?>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <?php if (isset($policies['shipping'])): ?>
    <div class="tab-pane fade in active" id="freedelivery">
        <?php echo $policies['shipping']['description']; ?>
    </div>
    <?php endif; ?>
    <?php if (isset($policies['refund'])): ?>
    <div class="tab-pane fade" id="moneyback">
        <?php echo $policies['refund']['description']; ?>
    </div>
    <?php endif; ?>
    <?php if (isset($policies['returnItem'])): ?>
    <div class="tab-pane fade" id="returns">
        <?php echo $policies['returnItem']['description']; ?>
    </div>
    <?php endif; ?>
</div>
<!-- reivew -->
<?php /*
<div class="row product-review margin-top-20">
    <div class="col-xs-12"><h1 style="color:#95c126;">รีวิว</h1></div>
    <div class="col-xs-12">
        <!-- profile -->
        <div class="row profile">
            <div class="col-xs-3"><img src="<?php echo Theme::asset()->usePath()->url('img/profile.jpg'); ?>"></div>
            <div class="col-xs-9">
                <h3>Alongkorn Deepuke</h3>
                <img class="star" src="<?php echo Theme::asset()->usePath()->url('img/star_active.png'); ?>">
                <img class="star" src="<?php echo Theme::asset()->usePath()->url('img/star_normal.png'); ?>">
            </div>
        </div>
        <!-- comment -->
        <div class="row comment">
            <div class="col-xs-12">ปลุกมันจะตั้งเป็นช่วงเวลา เช่น 6:30 - 7:00 มันจะปลุกในเวลาที่เหมาะสมที่สุดตาม sleep cycle ระหว่าง 6:30 - 7:00 ส่วนงีบผมไม่เห็นนะ ทำไมอ่านๆ ไปก็นึกขึ้นว่าอุปกรณ์พวกนี้มันคล้ายๆ กับอุปกรณ์ที่เค้าเอาไว้ track พวกสัตว์ป่าเลยแฮะ</div>
        </div>
        <!-- read all review -->
        <div class="row">
            <div class="col-xs-12"><a class="blue-link" href="detail-review.html">อ่านรีวิวทั้งหมดจากผู้ซื้อ (<span>12</span>)</a></div>
        </div>
    </div>
</div>
 */
?>

<!-- related Product -->
<?php if (count($relateds) > 0): ?>
<div class="row">
    <div class="col-xs-12"><h3 style="color:#95c126;"><?php echo __('Related items'); ?>  </h3></div>
</div>
<div class="row margin-top-20">
    <div class="swiper-related-container">
        <div class="swiper-wrapper">
            <!-- item1 -->
            <?php foreach ($relateds as $key => $productRelate): ?>
            <div class="swiper-slide">
                <div class="col-medium">
                    <div class="col-xs-12"><div class="product-img">
                            <?php
                            $slug = (isset($productRelate['slug']) && !empty($productRelate['slug'])) ? $productRelate['slug']  : url_title($productRelate['title']);

                            ?>
                            <a href="<?php echo levelDUrl($slug, $productRelate['pkey']); ?>" title="<?php echo $productRelate['title']; ?>" class="ec-product" data-ec-item="product-relate-list|<?php echo $productRelate['pkey']; ?>|<?php echo $key+1; ?>">
                                <img alt="<?php echo $productRelate['title']; ?>" src="<?php echo array_get($productRelate, 'image_cover.thumbnails.large'); ?>"></a></div></div>
                    <div class="col-xs-12 product-name margin-top-20"><h4><?php echo $productRelate['title']; ?></h4></div>
                    <div class="col-xs-12 product-price">
                        <div class="row">
                            <div class="col-xs-8">
                                <p <?php echo ($productRelate['net_price_range']['min'] > 0 && $productRelate['net_price_range']['min'] > $productRelate['price_range']['min'])?'':'class="normal-price-only"'; ?>><?php echo number_format($productRelate['price_range']['min']); ?>.-</p>
                                <?php if ($productRelate['net_price_range']['min'] > 0 && $productRelate['net_price_range']['min'] > $productRelate['price_range']['min']): ?>
                                <span><?php echo number_format($productRelate['net_price_range']['min']); ?>.-</span>
                                <?php endif; ?>
                            </div>
                            <?php if ($productRelate['percent_discount']['max'] > 0): ?>
                            <div class="col-xs-4"><span class="price-discount"><?php echo floor($productRelate['percent_discount']['max']); ?></span>
                                <img src="<?php echo Theme::asset()->usePath()->url('img/dummy_sale_tag_03.png'); ?>" alt="<?php echo $productRelate['title']; ?> Sale Tag"></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<script type="text/javascript">
<?php  $ec_products = array(); ?>
  <?php
    $ec_products = array();
    if (count($relateds) > 0){
        foreach ($relateds as $key => $productRelate):
            array_push($ec_products,
            array(  'id' => $productRelate['pkey'],
                    'name' => $productRelate['title'],
                    'price' => $productRelate['net_price_range']['min'],
                    'brand' => $productRelate['brand']['name'],
                    'category' => $productRelate['collections'][0]['name'],
                    'list' => 'product-relate-list',
                    'position' => $key+1));


        endforeach;
    }

    ?>
    if(typeof ec_products === 'undefined'){
        var ec_products = [];
    }
    ec_products['product-relate-list'] = <?php echo jsonUnescapedUnicode(json_encode($ec_products)); ?>;

    dataLayer.push({
      'event': 'productImpressions',
      'ecommerce': {
        'currencyCode': 'PHP',
        'impressions': <?php echo jsonUnescapedUnicode(json_encode($ec_products)); ?>
      }
    });
</script>

<div class="modal fade" id="popup-choose">
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><?php echo __('level-d-dialog-select-installment-title'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo __('inst-alert-payment-method'); ?></p>
                <div class="radio">
                    <label>
                        <input type="radio" name="optionsRadios" id="optionsRadios1" value="installment" checked>
                        <?php echo __('inst-pay-installment'); ?>
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="optionsRadios" id="optionsRadios2" value="normal">
                        <?php echo __('inst-pay-full'); ?>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary select-type-continue"><?php echo __('Continue'); ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="alert-dialog" data-id="promotion-popup">
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">
            <div class="modal-body">
                <p class="alert-dialog-message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary alert-dialog-continue" data-dismiss="modal"></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="howToUseCouponPopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-id="promotion-popup">
    <div class="modal-dialog">
        <div class="modal-content">
            <a class="closes itruemart-coupon-close-button" data-id="itruemart-coupon-close-button" data-dismiss="modal" aria-label="Close">
                <img style="width: 25px;" src="<?php echo Theme::asset()->usePath()->url("img/close-Mobile.png"); ?>"  alt="close popup"/>
            </a>
            <img style="width: 100%;" src="<?php echo Theme::asset()->usePath()->url("img/mobile-popup.png"); ?>"  alt="how to use itruemart's coupon"/>
        </div>
    </div>
</div>

<div style="display: none;">
    <?php
        $product_promotion = 'normal';
        if(!empty($product['variants'][0]['active_special_discount']['campaign_type']))
        {
            $product_promotion = $product['variants'][0]['active_special_discount']['campaign_type'];
        }
    ?>
    <span class="product_promotion"><?php echo $product_promotion;?></span>
</div>
<script>
var Product = Product || [];
Product.data = <?php echo json_encode(array_only($product, array('installment','pkey'))); ?>;
</script>

