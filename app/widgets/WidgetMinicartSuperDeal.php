<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetMinicartSuperDeal extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'minicartSuperDeal';

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
        'cart' => 9999
    );

    /**
     * Turn on/off widget.
     *
     * @var boolean
     */
    public $enable = true;

    /**
     * Code to start this widget.
     *
     * @return void
     */
    public function init(Theme $theme)
    {
        // Initialize widget.

        $theme->asset()->container('footer')->usePath()->add('minicart-superdeal', 'js/minicart-superdeal.js', array());
        //$this->setAttribute('user', User::find($this->getAttribute('userId')));
    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        //$label = $this->getAttribute('label');

        //$this->setAttribute('label', 'changed');

        $attrs = $this->getAttributes();

        return $attrs;
    }

}