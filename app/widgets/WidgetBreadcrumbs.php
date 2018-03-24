<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetBreadcrumbs extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'breadcrumbs';

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
    public $attributes = array('banners' => '', 'showBanner' => '');

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

        $repos = new BannerRepository();
        $position  = Config::get("widget_params.breadcrumbBanner");
        $response = $repos->getByPosition($position);
        // dd($response);

        if(!empty($response)){
            if(isset($response['position_'.$position]['group_list'][0]) && isset($response['position_'.$position]['group_list'][0]['banner_list'][0])){
                $banner = $response['position_'.$position]['group_list'][0]['banner_list'][0];
                $attrs['banners'] = $banner;
            }else{
                $attrs['banners'] = array('url_link' => Request::server ("SERVER_NAME"), 'img_path' => '');
            }
            // dd($banner);
        } else {
            //add condition if banner not found
            $attrs['banners'] = array('url_link' => Request::server ("SERVER_NAME"), 'img_path' => '');
        }

        // dd($banners);

        return $attrs;
    }

}