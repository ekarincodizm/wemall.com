<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetAjaxLoading extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'ajaxLoading';

    /**
     * Watching widget tpl on everywhere.
     *
     * @var boolean
     */
    public $watch = true;

    /**
     * Arrtibutes pass from a widget.
     *
     * @var array
     */
    public $attributes = array(

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

        $theme->asset()->container("footer")->add("ajaxLoadingWidget-css", "assets/widget/css/ajaxLoadingWidget.css", array());
        $theme->asset()->container("footer")->add('ajaxLoadingWidget-js', 'assets/widget/js/ajaxLoadingWidget.js', array());
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