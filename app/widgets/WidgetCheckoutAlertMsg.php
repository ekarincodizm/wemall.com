<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetCheckoutAlertMsg extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'checkout-msg';

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
        $theme->asset()->container("footer")->usePath()->add("step3-errormsg", "js/step3-errormsg.js", array());

    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        $attrs = $this->getAttributes();
        $checkout = $this->getAttribute('checkout');

        return $attrs;
    }

}