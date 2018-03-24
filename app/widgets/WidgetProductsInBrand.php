<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetProductsInBrand extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'products-in-brand';

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
        'product' => array()
    );

    /**
     * Code to start this widget.
     *
     * @return void
     */
    public function init(Theme $theme)
    {
        // Initialize widget.

        //$theme->asset()->usePath()->add('widget-name', 'js/widget-execute.js', array('jquery', 'jqueryui'));
        //$this->setAttribute('user', User::find($this->getAttribute('userId')));
    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        $product = $this->getAttribute('product');

        //$this->setAttribute('label', 'changed');

        $brandKey = $product['brand']['pkey'];

        $params = array(
            'brandKey' => $brandKey,
            'per_page' => 16,
            'relate'   => 1
        );

        $productRepo    = new ProductRepository;
        $InBrandProduct = $productRepo->search($params);

        $this->setAttribute('inBrandProduct', $InBrandProduct);

        $attrs = $this->getAttributes();

        return $attrs;
    }
}