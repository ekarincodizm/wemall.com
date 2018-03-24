<?php 
    $minicartData = array(
        "checkout"=>$checkout, 
        'showShippingMethod'=>$showShippingMethod, 
        'showDiscount' => $showDiscount, 
        'isTUAvailablePage' => $isTUAvailablePage, 
        'showCoupon' => $showCoupon
        );
    echo Theme::widget('miniCart', $minicartData)->render(); 
?>