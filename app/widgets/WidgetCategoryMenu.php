<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetCategoryMenu extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'category-menu';

    /**
     * Arrtibutes pass from a widget.
     *
     * @var array
     */
    public $attributes = array(
        'collections' => array(),
        'currentPkey' => ''
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
        // $label = $this->getAttribute('label');

        //$this->setAttribute('label', 'changed');

        $attrs = $this->getAttributes();

        return $attrs;
    }

}