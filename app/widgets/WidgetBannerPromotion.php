<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetBannerPromotion extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'bannerPromotion';

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
        'position' => null,
        'width'    => null,
        'height'   => null
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
        $banner = App::make('BannerRepositoryInterface');

        $position = $this->getAttribute('position');


        $response = $banner->getByPosition($position);

        // if (App::environment('dev', 'local'))
        // {
        //     $response = '
        //         {"status":"success","code":200,"message":"200 OK","data":[{"id":"8","name":"Level B C : Promotion Banner","description":"Banner promotion for Level B C and promotion page(flash sale, today, discount, trueyou)Size : 246 x 246","max_group_active":"0","status_flg":"Y","group_total":1,"group_list":[{"id":"52","pkey":"23771012496579","name":"B C Promotion","description":"","is_random":"N","status_flg":"Y","show_per_time":"1","banner_total":1,"banner_list":[{"id":"65","pkey":"25246169758416","banner_group_id":"52","name":"Level B C Promotion","type":"1","target":"_blank","width":"246","height":"246","img_path":"http:\/\/cdn.alpha.itruemart.com\/pcms\/uploads\/\/banners\/52\/65.jpg","url_link":"http:\/\/www.itruemart.com","status_flg":"Y","youtube_embed":"","description":"","effectived_at":"0000-00-00 00:00:00","expired_at":"0000-00-00 00:00:00"}]}]}]}';
        //     $response = json_decode(trim($response), true);
        // }


        $group = array_get($response, 'position_'.$position.'.group_list.0');

        $banners = array_get($group, 'banner_list');

        if (isset($group['is_random']) and $group['is_random'] == 'Y')
        {
            shuffle($banners);
        }

        if (isset($group['show_per_time']) and $group['show_per_time'])
        {
            $amount = - (int) $group['show_per_time'];

            array_splice($banners, 0, $amount);
        }

        $this->setAttribute('banners', $banners);
    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        $attrs = $this->getAttributes();

        return $attrs;
    }

}