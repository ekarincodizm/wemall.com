<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetHomeMiddleBanner extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'middleBanner';

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
    public $attributes = array('banners' => '');

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

        // $pcmsClient = new \PCMSClient;
        // $banners = $pcmsClient->getBannerByArea($attrs['banner_area']);

        // $attrs['banners'] = $banners;
        #sd($attrs);
        $repos = new MiddleBannerRepository();
        $attrs['banners'] = $repos->getMiddleBanner();
        return $attrs;
    }

}