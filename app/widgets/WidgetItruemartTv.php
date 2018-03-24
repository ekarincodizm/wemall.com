<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetItruemartTv extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'itruemart-tv';

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
		$data = array();
		
        $productRepo = new ProductRepository;
		
		$params = 	array(
						'campaign' => 'itruemart_tv',
						'per_page' => 4
					);
		$itruemartTv = $productRepo->search($params);
		
		if(!empty($itruemartTv))
		{
			#alert($itruemartTv);die;
			$data = $itruemartTv;
		}
		
		return $data;
		#sd($data['insight_itruemart']);
		#$this->theme->of('home.insight_itruemart', $data)->render();
    }

}