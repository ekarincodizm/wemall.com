<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetProductsDescription extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'products-description';

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
        'description' => array(),
        'keyfeature' => array(),
        // 'caption' => array(),
        'advantage' => array()
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
        $language = Lang::locale();
        $product = $this->getAttribute('product');

        if($language == 'en'){
            $description = array_get($product, 'translate.description');
            $keyfeature = array_get($product, 'translate.key_feature');
        } else {
            $description = array_get($product, 'description');
            $keyfeature = array_get($product, 'key_feature');
        }

        // $caption = $product['caption'];
        $advantage = array_get($product, 'advantage');

        $this->setAttribute('description', $description);
        $this->setAttribute('keyfeature', $keyfeature);
        // $this->setAttribute('caption', $caption);
        $this->setAttribute('advantage', $advantage);

        $attrs = $this->getAttributes();

        return $attrs;
    }
}
