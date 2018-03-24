<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetRelatedProducts extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'relatedProducts';

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
    public $attributes = array('products' => '');

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
        $product = $this->getAttribute('product');

        $collectionKey = $product['collections'][0]['pkey'];

        $params = array(
            'collectionKey' => $collectionKey,
            'per_page'      => 5,
            'relate'        => 1
        );

        $repos = new ProductRepository;
        $results = $repos->search($params);

        sd($results);


        $attrs = $this->getAttributes();
        $attrs['products'] = $results;


        //$repos = new ProductRepository();
        //$attrs['products'] = $repos->getRalatedProducts();

        return $attrs;
    }

}
