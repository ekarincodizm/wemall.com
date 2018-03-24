<!-- Search -->
<?php echo Theme::widget('WidgetMobileSearchBox')->render(); ?>

<!-- Category -->
<?php echo Theme::widget('WidgetMobileCategoryLink')->render(); ?>

<!-- SuperDeals -->
<?php if ($todayProduct || $tomorrowProduct): ?>
<div class="row margin-top-20">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <!-- Today wow -->
            <?php if ($todayProduct): ?>
            <div class="swiper-slide today-deals">
                <?php
                  $flashsaleType = array_get($todayProduct, 'activeDiscountVariant.active_special_discount.flashsale_type');
                  $end = strtotime(array_get($todayProduct, 'activeDiscountVariant.active_special_discount.ended_at'));
                  $current_time = array_get($todayProduct, 'response_time');
                ?>
                <div class="col-xs-8">
                    <h1><span style="color:#95c126">Today's Top </span><span style="color:#ffae00">Wow!</span></h1>
                </div>
                <?php
                    $is_next_deal = array_get($todayProduct, 'is_next_deal', false);

                    if ($is_next_deal) {
                        $today_time = array_get($todayProduct, 'activeDiscountVariant.active_special_discount.started_at');
                    }
                    else {
                        $today_time = array_get($todayProduct, 'activeDiscountVariant.active_special_discount.ended_at');
                    }

                    if(!empty($today_time))
                    {
                        $today_time = date('Y/m/d H:i:s' , strtotime($today_time));
                    }
                #$today_time = date('Y/m/d H:i:s' , strtotime('+10 seconds'));
                ?>
                <div class="col-xs-12">
                    <div class="col-big">
                        <?php
                        $slug = (isset($todayProduct['slug']) && !empty($todayProduct['slug'])) ? $todayProduct['slug']  : url_title($todayProduct['title']);

                        ?>
                        <a href="<?php echo levelDUrl($slug, array_get($todayProduct, 'pkey')); ?>">
                            <?php
                            if(App::getLocale()=='th')
                            {
                                $todayProduct_name =  array_get($todayProduct,'title');
                            }
                            else
                            {
                                if(array_get($todayProduct,'translate')!=null)
                                {
                                    $todayProduct_name =  array_get($todayProduct,'translate.title');
                                }
                                else
                                {
                                    $todayProduct_name =  array_get($todayProduct,'title');
                                }
                            }
                            ?>
                            <div class="col-xs-12 product-image">
                                <img alt="<?php echo $todayProduct_name;?>" src="<?php echo array_get($todayProduct, 'activeDiscountVariant.active_special_discount.banner_web_today', array_get($todayProduct, 'image_cover.normal')); ?>?q=<?php echo md5(array_get($todayProduct, 'pkey'));?>"></div>
                            <div class="col-xs-7">
                                <h4 class="product_title">
                                    <?php echo $todayProduct_name;?>
                                </h4>
                            </div>
                            <div class="col-xs-3 product-price">
                                <p><?php echo number_format(array_get($todayProduct, 'activeDiscountVariant.price')); ?>.-</p>
                                <span><?php echo number_format(array_get($todayProduct, 'activeDiscountVariant.net_price')); ?>.-</span>
                            </div>
                            <?php
                            $today_discount = array_get($todayProduct, 'percent_discount.max');
                            $today_percent_show = 0;

                            if(!empty($today_discount))
                            {
                                $cal_discount = floor($today_discount);
                                if($cal_discount == 100)
                                {
                                    $today_percent_show = 99;
                                }
                                else
                                {
                                    $today_percent_show = $cal_discount;
                                }
                            }
                            ?>

                            <?php if (
                                $flashsaleType == 'tmvh'
                                || $flashsaleType == 'trueu'): ?>
                                <div class="col-xs-2 price-superdeal"><span class="price-red"><?php echo $today_percent_show;//number_format(array_get($todayProduct, 'percent_discount.max')); ?></span><img src="<?php echo URL::asset('themes/mobile/assets/img/dummy_sale_tag_02.png'); ?>"></div>
                            <?php else: ?>
                                <div class="col-xs-2 price-superdeal"><span class="price-red"><?php echo $today_percent_show;//number_format(array_get($todayProduct, 'percent_discount.max')); ?></span><img src="<?php echo URL::asset('themes/mobile/assets/img/dummy_sale_tag_01.png'); ?>"></div>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <!-- Tomorrow wow -->
            <?php if ($tomorrowProduct): ?>
            <div class="swiper-slide tomorrow-deals">
                <?php
                  $flashsaleType = array_get($tomorrowProduct, 'activeDiscountVariant.active_special_discount.flashsale_type');
                  $end = strtotime(array_get($tomorrowProduct, 'activeDiscountVariant.active_special_discount.ended_at'));
                  $current_time = array_get($tomorrowProduct, 'response_time');
                ?>
                <div class="col-xs-8">
                    <h2>Next's <span style="color:#ffae00">Wow!</span></h2>
                </div>

                <?php $tomorrowtime = array_get($tomorrowProduct, 'activeDiscountVariant.active_special_discount.started_at'); ?>
                <?php
                if(!empty($tomorrowtime))
                {
                    $tomorrowtime = date('Y/m/d H:i:s' , strtotime($tomorrowtime));
                }
                ?>

                <div class="col-xs-12">
                    <div class="col-big">
                        <?php
                        $slug = (isset($tomorrowProduct['slug']) && !empty($tomorrowProduct['slug'])) ? $tomorrowProduct['slug']  : url_title($tomorrowProduct['title']);

                        ?>
                        <a href="<?php echo levelDUrl($slug, array_get($tomorrowProduct, 'pkey')); ?>">
                            <?php
                            if(App::getLocale()=='th')
                            {
                                $tomorrowProduct_name = array_get($tomorrowProduct,'title');
                            }
                            else
                            {
                                if(array_get($tomorrowProduct,'translate')!=null)
                                {
                                    $tomorrowProduct_name = array_get($tomorrowProduct,'translate.title');
                                }
                                else
                                {
                                    $tomorrowProduct_name = array_get($tomorrowProduct,'title');
                                }
                            }
                            ?>
                            <div class="col-xs-12 product-image">
                                <img alt="<?php echo $tomorrowProduct_name;?>" src="<?php echo array_get($tomorrowProduct, 'activeDiscountVariant.active_special_discount.banner_web_incoming', array_get($tomorrowProduct, 'image_cover.normal')); ?>?q=<?php echo md5(array_get($tomorrowProduct, 'pkey'));?>"></div>
                            <div class="col-xs-7">
                                <h5 class="product_title">
                                    <?php echo $tomorrowProduct_name;?>
                                </h5>
                            </div>
                            <div class="col-xs-3 product-price">
                                <p><?php echo number_format(array_get($tomorrowProduct, 'activeDiscountVariant.price')); ?>.-</p>
                                <span><?php echo number_format(array_get($tomorrowProduct, 'activeDiscountVariant.net_price')); ?>.-</span>
                            </div>
                            <?php
                            $tomorrow_discount = array_get($tomorrowProduct, 'percent_discount.max');
                            $tomorrow_percent_show = 0;

                            if(!empty($tomorrow_discount))
                            {
                                $cal_tomorrow_discount = floor($tomorrow_discount);
                                if($cal_tomorrow_discount == 100)
                                {
                                    $tomorrow_percent_show = 99;
                                }
                                else
                                {
                                    $tomorrow_percent_show = $cal_tomorrow_discount;
                                }
                            }

                            ?>
                            <?php if (
                                $flashsaleType == 'tmvh'
                                || $flashsaleType == 'trueu'): ?>
                                <div class="col-xs-2 price-superdeal"><span class="price-red"><?php echo $tomorrow_percent_show;//number_format(array_get($tomorrowProduct, 'percent_discount.max')); ?></span><img src="<?php echo URL::asset('themes/mobile/assets/img/dummy_sale_tag_02.png'); ?>"></div>
                            <?php else: ?>
                                <div class="col-xs-2 price-superdeal"><span class="price-red"><?php echo $tomorrow_percent_show;//number_format(array_get($tomorrowProduct, 'percent_discount.max')); ?></span><img src="<?php echo URL::asset('themes/mobile/assets/img/dummy_sale_tag_01.png'); ?>"></div>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>



<!-- Banner -->
<!--
<div class="row margin-top-20">
    <div class="col-xs-12"><img alt="itruemart every wow gadget" src="<?php /*echo URL::asset('themes/mobile/assets/img/banners/everywow_gadget.jpg?ran=a1b2c3'); */?>" width="100%"></div>
</div>
-->
<?php echo Theme::widget("superDealMobileBanner", array())->render(); ?>

<!-- Flash-Sale -->
<div class="row">
    <div class="col-xs-3">
        <h3><span style="color:#ffae00">Wow!</span></h3>
    </div>
    <div class="col-xs-9">
        <div class="btn-group order-by text-right">
            <button type="button" class="btn btn-default active" data-order-by="discount_started" data-order="down"><?php echo __("filter_latest_txt"); ?> <img src="<?php echo URL::asset('themes/mobile/assets/img/order_by_both_down_active.png'); ?>"></button>
            <button type="button" class="btn btn-default" data-order-by="price" data-order="both"><?php echo __("Price"); ?> <img src="<?php echo URL::asset('themes/mobile/assets/img/order_by_both.png'); ?>"></button>
            <button type="button" class="btn btn-default" data-order-by="discount" data-order="both"><?php echo __("filter_discount_txt"); ?> <img src="<?php echo URL::asset('themes/mobile/assets/img/order_by_both.png'); ?>"></button>
        </div>
    </div>
</div>

<div class="row superdeal"></div>

<?php
Theme::asset()->usePath()->add('swiper-css', 'css/idangerous.swiper.css', array('bootstrap'));
Theme::asset()->container('footer')->usePath()->add('countdowm', 'js/jquery.countdown.min.js', array('jquery'));
Theme::asset()->container('footer')->usePath()->add('swiper', 'js/idangerous.swiper-2.1.min.js', array('jquery'));
Theme::asset()->container('footer')->usePath()->add('jscroll', 'vendors/jscroll/jquery.jscroll.min.js', array('jquery'));
Theme::asset()->container('footer')->usePath()->add('ordering', 'js/ordering.js', array('jquery', 'custom'));
Theme::asset()->container('footer')->usePath()->add('superdeal', 'js/superdeal.js', array('jquery', 'custom'));

// Theme::asset()->usePath()->add('superdeal-css', 'css/superdeal.css', array('bootstrap'));

// Theme::asset()->writeStyle('SUPERDEAL', '
// .superdeal-left, .superdeal-right
// {
//     margin-top: 10px;
// }
// .superdeal-home-thumb
// {
//     border: 1px solid #dddddd !important;
// }
// .superdeal-left {
//     padding-right: 5px !important;
// }
// .superdeal-right {
//     padding-left: 5px !important;
// }
// ');

// Theme::asset()->container('footer')->writeScript('home', '
//     //swipe slider
//     var mySwiper = new Swiper(".swiper-container",{
//       paginationClickable: true,
//       slidesPerView: "auto"
//     });
// ', array('jquery'));
?>