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
<div class="by_brand"><?php echo __('Brand') ?></div>
<div class="search_input_box">
    <input id="key_brand" name="key_brand" class="search_input">
</div>
<div class="search_button_box">
    <img class="btn_key_brand" src="http://www.itruemart.com/assets/itruemart_new/global/images/level_b/search_button.jpg" alt="search">
</div>
<div class="space"></div>
<div class="brandlist">
    <div>
        <div class="brandlist_options">
            <ul>
                <?php foreach ($brands as $brand) { ?>
                <li>
                    <a href="<?php echo get_permalink($firstSectionUri, $brand) ?>" title="<?php echo $brand['name'] ?>"><?php echo $brand['name'] ?></a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>