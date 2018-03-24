<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetHomeCategoryBox extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'home-category-box';

    /**
     * Watching widget tpl on everywhere.
     *
     * @var boolean
     */
    public $watch = false;

    /**
     * Arrtibutes pass from a widget.
     *
     * @var array
     */
    public $attributes = array(
        'collection'     => '',
        'banner_area'    => '',
		'banners' => '',
		'banners_brand' => '',
		'banners_promotion' => '',
		'type' => '',
        'pkeyCollection' => ''
     );

    /**
     * Code to start this widget.
     *
     * @return void
     */
    public function init(Theme $theme)
    {

    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        $attrs = $this->getAttributes();

        #alert($attrs, 'red'); 
        #echo '<p>pkeyCollection = '.$pkeyCollection.'</p>';

        $bestSellerRepository = new \BestSellerRepository;
        if ( ! empty($attrs['pkeyCollection']))
        {
            #echo '<p>pkeyCollection = '.$pkeyCollection.'</p>';
            #exit; 
            $bestseller = $bestSellerRepository->getByCollection($attrs['pkeyCollection']);
            #alert($bestseller, 'red'); 
            if ( ! empty($bestseller))
            {
                shuffle_assoc($bestseller);
            }

            $attrs['bestseller'] = $bestseller;
        }

        return $attrs;
    }

}