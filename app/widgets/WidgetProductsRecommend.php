<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetProductsRecommend extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'products-recommend';

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
        'product' => array(),
        'recommendProduct' => array()
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
        $attrs = $this->getAttributes();
        
        $product = $this->getAttribute('product');

        //$this->setAttribute('label', 'changed');

        $q = $product['tag'];
        
        $attrs['recommendProduct'] = array('products' => array());
        
        if ( ! $q)
        {
            return $attrs;
        }

        $params = array(
            'q'        => $q,
            'per_page' => 16,
            'relate' => 1
        );

        $productRepo = new ProductRepository;
        $recommendProduct = $productRepo->search($params);

        $attrs['recommendProduct'] = $recommendProduct;

        return $attrs;
    }

}