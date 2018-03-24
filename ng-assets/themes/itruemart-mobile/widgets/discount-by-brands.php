<?php
    $currentRouteAction = Route::currentRouteAction();

    switch($currentRouteAction)
    {
        case 'ProductsController@getFlashsaleProducts' :
            $firstSectionUri = 'flash-sale/brand';
            break;
        case 'ProductsController@getItruemartTvProducts' :
            $firstSectionUri = 'itruemart-tv/brand';
            break;
        case 'ProductsController@getDiscountProducts' :
            $firstSectionUri = 'discount-products/brand';
            break;
        case 'ProductsController@getTrueyouProducts' :
            $firstSectionUri = 'trueyou/brand';
            break;
        default :
            $firstSectionUri = 'brand';
            break;
    }
?>
<div class="base_seller_items" style="height:236px; overflow:hidden; margin-bottom:20px;">
    <div class="tap_product_main">
        <div class="promotion">
            <div class="div_promotion">
                <div id="bestseller_loader">
                    <div id="promotion_back"></div>
                    <div class="promotion_space"></div>
                    <div id="div_promotion_content">
                        <div class="over">
                            
                            <?php foreach ($brands as $brand) { ?>
                            <div class="slide">
                                <div class="promotionlist">
                                    <div class="pic">
                                        <div class="discounttextbg"></div>
                                        <div class="discounttext"><span class="discountfont"></span></div>
                                        <div class="shadow">
                                            <a href="<?php echo get_permalink($firstSectionUri, $brand) ?>" title="<?php echo $brand['name'] ?>"><img src="<?php echo $brand['thumbnail'] ?>" alt="<?php echo $brand['name'] ?>" width="150"  height="150"></a>
                                        </div>
                                    </div>
                                    <div class="detail">
                                        <a href="<?php echo get_permalink($firstSectionUri, $brand) ?>" title="<?php echo $brand['name'] ?>">
                                            <span class="font2 strong"><?php echo $brand['name'] ?></span><br>
                                            <div class="valid_end">
                                                <strong><span class="font2">หมดเขต</span></strong>
                                            </div>
                                            <div class="ex">
                                                <span class="font1"><?php echo date('j M Y', strtotime($brand['ended_at'])) ?></span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                        </div>
                    </div>
                    <div class="promotion_space"></div>
                    <div id="promotion_next"></div>
                </div>
            </div>
        </div>
    </div>
</div>