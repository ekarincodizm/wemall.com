<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetProductsRelated extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'products-related';

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
        'relatedProduct' => array()
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

        $collectionKey = $product['collections'][0]['pkey'];

        $params = array(
            'collectionKey' => $collectionKey,
            'per_page'      => 16,
            'relate'        => 1
        );

        $productRepo = new ProductRepository;
        $relatedProduct = $productRepo->search($params);

        $this->setAttribute('relatedProduct', $relatedProduct);

        $attrs = $this->getAttributes();

        return $attrs;
    }

}