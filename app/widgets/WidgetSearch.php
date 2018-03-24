<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetSearch extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'search';

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
        $theme->asset()->container('footer')->usePath()->add('search', 'js/search.js', array('jquery'));
    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        $attrs = $this->getAttributes();
        
        $pcms = App::make('pcms');
        
        // TODO cache
        $response = $pcms->api('collections', array('level' => 'root', 'is_category'=>1));

        $attrs['collections'] = array();
        
        if (isset($response['status']) && $response['status'] == 'success')
        {
            $attrs['collections'] = $response['data'];
        }

        return $attrs;
    }

}