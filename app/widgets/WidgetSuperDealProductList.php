<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetSuperDealProductList extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'superdeal-product-list';

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
    public $attributes = array( 'limit' => 4, 'response' => 'product');

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

        $everyDayWowRepo = App::make('EverydaywowRepository');

        $data = array(
            'limit' => $attrs['limit'],
            'response' => $attrs['response']
            );

        $response = $everyDayWowRepo->getData($data);
        
        $products = array_get($response,'data.product_data');

        if (! $products)
        {
            $this->enable = false;
        }

        $attrs['products'] = $products;
        return $attrs;
    }

}