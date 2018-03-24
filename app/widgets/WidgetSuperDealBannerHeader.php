<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetSuperDealBannerHeader extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'superDealBannerHeader';

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
        "banner" => array()
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
        
        $pcms = App::make('pcms');
        $params = array(
            "position" => Config::get("widget_params.superDealBannerHeader")
        );
        $response = $pcms->apiv2("banners", $params);
        if(!empty($response['data'][0]) && $response["code"] == 200){
            $attrs['banner'] = $response['data'][0];
        }else{
            $attrs['banner'] = array();
        }
        // sd($attrs);
		
        return $attrs;
    }

}