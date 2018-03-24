<!-- SuperDeals -->
<?php if ($todayProduct || $tomorrowProduct): ?>
    <div class="row margin-top-20">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <!-- Today wow -->
                <?php if (isset($todayProduct)): ?>
                    <div class="swiper-slide today-deals">
                        <?php
                        $flashsaleType = array_get($todayProduct, 'activeDiscountVariant.active_special_discount.flashsale_type');
                        $end = strtotime(array_get($todayProduct, 'activeDiscountVariant.active_special_discount.ended_at'));
                        $current_time = array_get($todayProduct, 'response_time');
                        /* typeidea script */
                        $ec_banner = array();
                        array_push($ec_banner, array( 'id' => array_get($todayProduct, 'pkey'), 'name' => array_get($todayProduct, 'title'),'position' => 'everyday-wow-today' ));
                        /* //typeidea script */
                        ?>
                        <div class="col-xs-8">
                            <h1><span style="color:#95c126">
                                <?php
                                if ( ! empty($todayProduct['is_next_deal']) ) {
                                    echo "Soon ";
                                } else {
                                    echo "Now ";
                                }
                                ?>
                                </span><span style="color:#ffae00">Wow!</span></h1>
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
                        ?>
                        <div class="col-xs-4 time-remaining"><span class="glyphicon glyphicon-time"></span> <span data-eventtype="<?php echo $is_next_deal ? 'open' : 'close'; ?>" <?php echo $is_next_deal ? 'data-current="' . $current_time . '"' : ''; ?> data-countdown="<?php echo $today_time;?>" ></span></div>
                        <div class="col-xs-12">
                            <div class="col-big">
                                <?php
                                /* typeidea script */
                                $slug = (isset($todayProduct['slug']) && !empty($todayProduct['slug'])) ? $todayProduct['slug']  : url_title($todayProduct['title']);
                                /* //typeidea script */
                                ?>
                                <a href="<?php echo levelDUrl($slug, array_get($todayProduct, 'pkey')); ?>" class="ec-promotion" data-ec-promotion="<?php echo array_get($todayProduct, 'pkey'); ?>|<?php echo array_get($todayProduct, 'title'); ?>|everyday-wow-today">
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
                        /* typeidea script */
                        array_push($ec_banner, array( 'id' => array_get($todayProduct, 'pkey'), 'name' => array_get($todayProduct, 'title'),'position' => 'everyday-wow-tomorrow' ));
                        /* //typeidea script */
                        ?>
                        <div class="col-xs-8">
                            <h2>Next <span style="color:#ffae00">Wow!</span></h2>
                        </div>

                        <?php $tomorrowtime = array_get($tomorrowProduct, 'activeDiscountVariant.active_special_discount.started_at'); ?>
                        <?php
                        if(!empty($tomorrowtime))
                        {
                            $tomorrowtime = date('Y/m/d H:i:s' , strtotime($tomorrowtime));
                        }
                        ?>

                        <div class="col-xs-4 time-remaining"><span class="glyphicon glyphicon-time"></span> <span data-eventtype="open" data-current="<?php echo $current_time; ?>" data-countdown="<?php echo $tomorrowtime; ?>" ></span></div>
                        <div class="col-xs-12">
                            <div class="col-big">
                                <?php
                                $slug = (isset($tomorrowProduct['slug']) && !empty($tomorrowProduct['slug'])) ? $tomorrowProduct['slug']  : url_title($tomorrowProduct['title']);

                                ?>
                                <!-- typeidea script -->
                                <a href="<?php echo levelDUrl($slug, array_get($tomorrowProduct, 'pkey')); ?>" class="ec-promotion" data-ec-promotion="<?php echo array_get($todayProduct, 'pkey'); ?>|<?php echo array_get($todayProduct, 'title'); ?>|everyday-wow-tomorrow">
                                <!-- //typeidea script -->
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
    <!-- typeidea script -->
    <script type="text/javascript">
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
    </script>
    <!-- //typeidea script -->
<?php endif; ?>
