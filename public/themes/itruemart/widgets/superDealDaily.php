<?php

$ln = Lang::getLocale();
/* typeidea script */
$ec_banner = array();
/* //typeidea script */
?>

<?php if (!empty($product_today)): ?>
    <div class="daily-deal">
        <div class="today">
            <div class="dd-title">
                <h2 class="dd-title-name">
                    <?php
                    if ( ! empty($product_today[0]['is_next_deal']) ) {
                        echo "Soon ";
                    } else {
                        echo "Now ";
                    }
                    ?>
                    <span class="orange">Wow!</span>
                </h2>
            </div>
        </div>
        <div class="tomorrow">
            <div class="dd-title">
                <h2 class="dd-title-name">
                    Next <span class="orange">Wow!</span>
                </h2>
            </div>
        </div>
    </div>

    <div class="superdeal__wrapper">
        <div class="daily-deal">
            <?php foreach ($product_today as $key => $product): ?>
                <?php
                if (empty($product)) {
                    continue;
                }

                

                if ($key == 0) {
                    $div_class_name = 'today';
                    $disabled = '';
                    //$tagIcon = 'label-red-1.png';
                } else {
                    $div_class_name = 'tomorrow';
                    $disabled = 'disabled';
                    //$tagIcon = 'label-red-2.png';
                }

                if (!empty($product['variants'][0]['active_special_discount']['discount_title'])) {
                    $tagIcon = "label-red-1.png";
                } else {
                    $tagIcon = 'label-red-2.png';
                }

                $current_time = array_get($product, 'response_time');
                ?>
                <div class="<?php echo $div_class_name ?>">
                    <div class="sd-product-info <?php echo $disabled; ?>">
                        <div class="label-red">
                    <span class="label-percent-discount">
                            <?php
                            //echo (isset($product["percent_discount"]["max"])) ? floor($product["percent_discount"]["max"]) : "0";
                            $percent_show = 0;
                            if (isset($product["percent_discount"]["max"])) {
                                $cal_percent = floor($product["percent_discount"]["max"]);

                                if ($cal_percent == 100) {
                                    $percent_show = 99;
                                } else {
                                    $percent_show = $cal_percent;
                                }
                            }
                            echo $percent_show;
                            ?><sup>%</sup><sub>OFF</sub>
                    </span>

                            <?php
                            $discount_title = !empty($product['variants'][0]['active_special_discount']['discount_title']) ? $product['variants'][0]['active_special_discount']['discount_title'] : '';
                            $banner_web_today = !empty($product['variants'][0]['active_special_discount']['banner_web_today']) ? $product['variants'][0]['active_special_discount']['banner_web_today'] : '';
                            $banner_web_tomorrow = !empty($product['variants'][0]['active_special_discount']['banner_web_tomorrow']) ? $product['variants'][0]['active_special_discount']['banner_web_tomorrow'] : '';
                            $banner_mobile_tomorrow = !empty($product['variants'][0]['active_special_discount']['banner_mobile_tomorrow']) ? $product['variants'][0]['active_special_discount']['banner_mobile_tomorrow'] : '';
                            $product_pkey = !empty($product['variants'][0]['active_special_discount']['product_pkey']) ? $product['variants'][0]['active_special_discount']['product_pkey'] : '';
                            $started_at = !empty($product['variants'][0]['active_special_discount']['started_at']) ? str_replace('T', ' ', $product['variants'][0]['active_special_discount']['started_at']) : '';
                            $ended_at = !empty($product['variants'][0]['active_special_discount']['ended_at']) ? str_replace('T', ' ', $product['variants'][0]['active_special_discount']['ended_at']) : '';

                            $is_next_deal = array_get($product, 'is_next_deal', false);

                            // $is_next_deal = true;
                            // $started_at = '2014-12-08 11:50:00';
                            ?>

                            <?php if (!empty($discount_title)): ?>
                                <span class="label-campaign">
                        <?php echo $discount_title; ?>
                        </span>
                            <?php endif; ?>

                            <img class="img-eaves"
                                 src="<?php echo Theme::asset()->usePath()->url('images/label/' . $tagIcon); ?>"
                                 alt="Today's Top Wow <?php echo $product['title'] ?>"/>
                        </div>
                        <!-- <a href="#">
                    <img src="<?php echo Theme::asset()->usePath()->url('images/ex-today.jpg'); ?>" />
                </a>
                -->
                        <?php
                        /* typeidea script */
                        array_push($ec_banner, array( 'id' => $product['pkey'], 'name' => $product["title"],'position' => 'everyday-wow-' . $div_class_name ));
                        /* //typeidea script */
                        $slug = (isset($product['slug']) && !empty($product['slug'])) ? $product['slug'] : url_title($product['title']);
                        ?>
                        <!-- typeidea script -->
                        <a href="<?php echo URL::toLang("products/" . $slug . "-" . $product['pkey'] . ".html"); ?>" class="ec-promotion" data-ec-promotion="<?php echo $product['pkey']; ?>|<?php echo $product["title"]; ?>|everyday-wow-<?php echo $div_class_name;?>">
                        <!-- //typeidea script -->
                            <?php if ($key == 0): ?>
                                <img
                                    src="<?php echo !empty($banner_web_today) ? $banner_web_today : Theme::asset()->usePath()->url('images/ex-today.jpg'); ?>?q=<?php echo md5($slug); ?>"
                                    alt="Tomorrow's Wow <?php echo $product['title']; ?>"/>
                            <?php else: ?>
                                <img
                                    src="<?php echo !empty($banner_web_tomorrow) ? $banner_web_tomorrow : Theme::asset()->usePath()->url('images/ex-tmr.jpg'); ?>?q=<?php echo md5($slug); ?>"
                                    alt="Tomorrow's Wow <?php echo $product['title']; ?>"/>
                            <?php endif; ?>
                        </a>

                        <div class="sd-product-name">
                            <?php
                            $product_name = "";
                            if ($ln == 'th') {
                                $product_name = (!empty($product["title"])) ? $product["title"] : "";
                            } else {
                                $product_name = (!empty($product ['translate']["title"])) ? $product ['translate']["title"] : $product["title"];
                            }
                            ?>
                            <?php if ($key == 0) : ?>
                                <h4>
                                    <?php echo $product_name; ?>
                                </h4>
                            <?php else: ?>
                                <h5>
                                    <?php echo $product_name; ?>
                                </h5>
                            <?php endif; ?>
                        </div>

                        <div class="sd-prop-info">
                            <?php if ($key == 0): ?>
                                <div class="box-timecount">
                                    <span class="box-title">
                                    <?php if ($is_next_deal == true): ?>
                                        <?php echo __('open_in'); ?> :
                                        <div class="countdown" data-eventtype="open" data-current="<?php echo $current_time; ?>"
                                             data-countdown="<?php echo (!empty($started_at)) ? str_replace("-", "/", $started_at) : date("Y/m/d H:i:s"); ?>"></div>
                                    <?php else: ?>
                                        <?php echo __('time_left_to_buy'); ?>
                                        <div class="countdown" data-eventtype="close"
                                             data-countdown="<?php echo (!empty($ended_at)) ? str_replace("-", "/", $ended_at) : date("Y/m/d H:i:s"); ?>"></div>
                                    <?php endif; ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                            <div class="box-price">
                                <div class="box-price-discount">
                            <span class="box-title">
                    <?php echo __('normal_price'); ?>
                            </span>
                            <span class="price-discount">
                                <?php if ($product["net_price_range"]["min"] != $product["net_price_range"]["min"]): ?>
                                    <?php echo price_format($product["net_price_range"]["min"]) . " - " . price_format($product["net_price_range"]["max"]); ?>
                                <?php else: ?>
                                    <?php echo price_format($product["net_price_range"]["max"]); ?>
                                <?php endif; ?>
                            </span> .-
                                </div>
                                <div class="box-price-normal">
                            <span class="box-title">
                                <?php echo __('special_price'); ?>
                            </span>
                            <span class="price-normal">
                                <?php if ($product["price_range"]["min"] != $product["price_range"]["min"]): ?>
                                    <?php echo price_format($product["price_range"]["min"]) . " - " . price_format($product["price_range"]["max"]); ?>
                                <?php else: ?>
                                    <?php echo price_format($product["price_range"]["max"]); ?>
                                <?php endif; ?>
                            </span> .-
                                </div>
                            </div>
                            <?php if ($key == 0): ?>
                                <div class="box-action">
                                    <?php
                                    $slug = (isset($product['slug']) && !empty($product['slug'])) ? $product['slug'] : url_title($product['title']);
                                    ?>
                                    <!-- typeidea script -->
                                    <a href="<?php echo URL::toLang("products/" . $slug . "-" . $product['pkey'] . ".html"); ?>"
                                       class="btn-order ec-promotion" data-ec-promotion="<?php echo $product['pkey'] ?>|<?php echo $product["title"]; ?>|everyday-wow-<?php echo $div_class_name;?>">
                                        <?php
                                        if ( ! empty($product['is_next_deal']) ) {
                                            echo __('soon');
                                        } else {
                                            echo __('buy');
                                        } ?>
                                    <!-- //typeidea script -->
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ($key == 1): ?>
                                <div class="box-timecount">
                                    <?php echo __('open_in'); ?> :
                                    <div class="countdown" data-eventtype="open"
                                         data-current="<?php echo $current_time; ?>"
                                         data-countdown="<?php echo (!empty($started_at)) ? str_replace("-", "/", $started_at) : date("Y/m/d H:i:s"); ?>"></div>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if(!empty($wowBanner)): ?>
            <div class="extra-wow-banner-top">
                <a href="<?php echo (!empty($wowBanner["url_link"]))? $wowBanner["url_link"] : "#"; ?>" target="<?php echo ($wowBanner["target"])? $wowBanner["target"] : "_blank" ; ?>">
                    <img alt="iTruemart Everyday Wow Gadget ราคาถูกที่สุดทุกวัน" src="<?php echo ($wowBanner["img_path"])? $wowBanner["img_path"] : "#"; ?>" <?php if(!empty($wowBanner["width"])){ echo "width='".$wowBanner["width"]."'"; } ?> <?php if(!empty($wowBanner["height"])){ echo "height='".$wowBanner["height"]."'"; } ?> />
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($_GET['show_msg'])): ?>
        <a href="#" id="open-timeup-box" data-reveal-id="timeout-open" data-animation="none"
           style="display:none;">Modal</a>
        <a class="close-reveal-modal" style="display:none;">&#215;</a>
        <div class="reveal-modal" id="timeout-open">
            <div class="font2 msg-header important-green-bg"><?php echo __('everyday-time-out-head'); ?></div>
            <div class="basket_put font2" id="popup_content">
                <div id="popup_message">
                    <dl>
                        <dt></dt>
                        <dd><?php echo __('everyday-time-out-content'); ?></dd>
                    </dl>
                </div>
                <div id="popup_panel">
                    <input type="button" value="<?php echo __('everyday-time-out-button'); ?>"
                           class="popup_ok btn btn-success">
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php endif; ?>
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
