<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetProductThumbnail extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'productThumbnail';

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
        'params' => array(
            "campaign" => "all",
            "page" => 1,
            "limit" => 6,
            "orderBy" => "discount_started",
            "order" => "desc"
        ),
        'products' => array()
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
        $theme->asset()->container("footer")->usePath()->add('product-thumbnail', 'js/product-thumbnail.js');
        //$this->setAttribute('user', User::find($this->getAttribute('userId')));
    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        $label = $this->getAttribute('label');

        //$this->setAttribute('label', 'changed');
        $attrs = $this->getAttributes();
        
        $params = $this->getAttribute("params");
        
        $pcmsClient = App::make('pcms');
        $res = $pcmsClient->apiv2("discount-campaigns/list-product", $params);
        if(isset($res['code']) && $res['code'] == 200){
             $attrs['products'] = $res["data"];
        }else{
            $attrs['products'] = array();
        }
        
        return $attrs;
    }

}