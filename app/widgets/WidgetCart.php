<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetCart extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'cart';

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
    public $attributes = array();

    /**
     * Code to start this widget.
     *
     * @return void
     */
    public function init(Theme $theme)
    {
        $theme->asset()->container('footer')->usePath()->add('cart', 'js/cart.js', array('jquery'));
    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        $attrs = $this->getAttributes();

//        $pcms = App::make('pcms');
//
//        $response = $pcms->getCart();
//
//        if ($response['status'] != 'success')
//        {
//            $response['data'] = array(
//                'totalQty' => 0,
//                'totalItem' => 0
//            );
//        }
//
//        $attrs['cart'] = $response['data'];

        return $attrs;
    }

}