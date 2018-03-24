<?php echo Theme::widget('homeHighlightBanner', array('banners' => $banners))->render(); ?>

<div class="content-home">
	<?php echo Theme::widget('homeRecommendBanner', array('banners' => $banners))->render(); ?>

    <?php
        $promotion1 = array(
            'type'  => 'promotion',
            'collection'  => array(),
			'banners' => array(),
			'banners_brand' => array(),
			'banners_promotion' => !empty($banners['position_28']) ? $banners['position_28'] : array(),
            'banner_area' => '',
            'pkeyCollection' => ''
        );
		
        $promotion2 = array(
            'type'  => 'promotion',
            'collection'  => array(),
			'banners' => array(),
			'banners_brand' => array(),
			'banners_promotion' => !empty($banners['position_29']) ? $banners['position_29'] : array(),
            'banner_area' => '',
            'pkeyCollection' => ''
        );
		
        $menWidgetParams = array(
            'type'  => 'collection',
            'collection'  => $collections['men'],
			'banners' => !empty($banners['position_16']) ? $banners['position_16'] : array(),
			'banners_brand' => isset($banners['position_22']) ? $banners['position_22'] : array(),
			'banners_promotion' => isset($banners['position_33']) ? $banners['position_33'] : array(),
            'banner_area' => 'banner-area-men',
            'pkeyCollection' => $collections['men']['pkey']
        );

        $womenWidgetParams = array(
            'type'  => 'collection',
            'collection'  => $collections['women'],
			'banners' => isset($banners['position_17']) ? $banners['position_17'] : array(),
			'banners_brand' => isset($banners['position_23']) ? $banners['position_23'] : array(),
			'banners_promotion' => isset($banners['position_34']) ? $banners['position_34'] : array(),
            'banner_area' => 'banner-area-women',
            'pkeyCollection' => $collections['women']['pkey']
        );

        $gadgetWidgetParams = array(
            'type'  => 'collection',
            'collection'  => $collections['gadget'],
			'banners' => isset($banners['position_18']) ? $banners['position_18'] : array(),
			'banners_brand' => isset($banners['position_24']) ? $banners['position_24'] : array(),
			'banners_promotion' => isset($banners['position_35']) ? $banners['position_35'] : array(),
            'banner_area' => '',
            'pkeyCollection' => $collections['gadget']['pkey']
        );

        $beautyWidgetParams = array(
            'type'  => 'collection',
            'collection'  => $collections['beauty'],
			'banners' => isset($banners['position_19']) ? $banners['position_19'] : array(),
			'banners_brand' => isset($banners['position_25']) ? $banners['position_25'] : array(),
			'banners_promotiony' => isset($banners['position_36']) ? $banners['position_36'] : array(),
            'banner_area' => '',
            'pkeyCollection' => $collections['beauty']['pkey']
        );

       # alert($womenWidgetParams, 'orange');
       # alert($menWidgetParams, 'yellow');
       # alert($gadgetWidgetParams, 'blue');
       # alert($beautyWidgetParams, 'red'); 
       # exit; 
		/* 
        $bookWidgetParams = array(
            'type'  => 'collection',
            'collection'  => $collections['beauty'],
			'banners' => isset($banners['position_20']) ? $banners['position_20'] : array(),
			'banners_brand' => isset($banners['position_26']) ? $banners['position_26'] : array(),
			'banners_promotiony' => isset($banners['position_37']) ? $banners['position_37'] : array(),
            'banner_area' => ''
        );

        $livingWidgetParams = array(
            'type'  => 'collection',
            'collection'  => $collections['beauty'],
			'banners' => isset($banners['position_21']) ? $banners['position_21'] : array(),
			'banners_brand' => isset($banners['position_27']) ? $banners['position_27'] : array(),
			'banners_promotiony' => isset($banners['position_38']) ? $banners['position_38'] : array(),
            'banner_area' => ''
        );
		 */
		 
    ?>
	

    <?php echo Theme::widget('homeCategoryBox', $promotion1)->render(); #Promotion 1 ?>
	
    <?php echo Theme::widget('homeCategoryBox', $menWidgetParams)->render(); ?>

    <?php echo Theme::widget('homeCategoryBox', $womenWidgetParams)->render(); ?>

    <?php echo Theme::widget('homeCategoryBox', $gadgetWidgetParams)->render(); ?>

    <?php echo Theme::widget('homeCategoryBox', $beautyWidgetParams)->render(); ?>
	
    <?php // echo Theme::widget('homeCategoryBox', $bookWidgetParams)->render(); ?>
	
    <?php // echo Theme::widget('homeCategoryBox', $livingWidgetParams)->render(); ?>
	
    <?php echo Theme::widget('homeCategoryBox', $promotion2)->render(); #Promotion 2 ?>
	
    <?php echo Theme::widget('itruemartTv', array() )->render(); #Promotion 2 ?>
	
	<?php echo Theme::widget('insightItruemart', array('banners' => $banners))->render(); ?>
   
</div>