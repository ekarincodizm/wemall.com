<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetProductsBrandStory extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'products-brand-story';

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
        
    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        $attrs = $this->getAttributes();

        return $attrs;
    }

}

