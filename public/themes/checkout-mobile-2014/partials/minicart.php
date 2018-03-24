<?php 
    $minicartData = array(
        "checkout"=>$checkout, 
        'showShippingMethod'=>$showShippingMethod, 
        'showDiscount' => $showDiscount, 
        'isTUAvailablePage' => $isTUAvailablePage, 
        'showCoupon' => $showCoupon,
        'open_https' => Config::get("https.useHttps"),
        );

    echo Theme::widget('miniCart', $minicartData)->render();
?>