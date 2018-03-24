<?php 
    $widgetData = array();
    $widgetData['editQty'] = (isset($editQty))? $editQty : true;
    $widgetData['checkout'] = (!empty($checkout))? $checkout : array();
    $widgetData['showShippingMethod'] = (!empty($showShippingMethod))? $showShippingMethod : false;
    $widgetData['editShippingMethod'] = (!empty($editShippingMethod))? $editShippingMethod : false;
    $widgetData['showCloseBtn'] = (!empty($showCloseBtn))? $showCloseBtn : false;
    $widgetData['nextBtnOperation'] = (!empty($nextBtnOperation))? $nextBtnOperation : 'Close';
    $widgetData['forceShowRemoveBtn'] = (!empty($forceShowRemoveBtn))? $forceShowRemoveBtn : false;
    $widgetData['showImage'] = ( isset($showImage) )? $showImage : true;

    echo Theme::widget('cartLightbox', $widgetData)->render();
?>