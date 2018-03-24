<?php 
    $minicartData = array(
        "checkout"=>$checkout, 
        'showShippingMethod'=>$showShippingMethod, 
        'showDiscount' => $showDiscount, 
        'showTrueyou' => $showTrueyou, 
        'showCoupon' => $showCoupon
        );
    echo Theme::widget('miniCart', $minicartData)->render(); 
?>