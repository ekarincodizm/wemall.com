<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetSuperDealDaily extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'superDealDaily';

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
        'userId' => 9999,
        'label' => 'Generated Widget',
        'wowBanner' => array()
    );

    /**
     * Turn on/off widget.
     *
     * @var boolean
     */
    public $enable = true;
    protected $pcmsClient;

    /**
     * Code to start this widget.
     *
     * @return void
     */
    public function init(Theme $theme) {
        $this->pcmsClient = App::make("pcms");
    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run() {
        $label = $this->getAttribute('label');
        $attrs = $this->getAttributes();

        $campaign = 'itruemart_tv'; //itruemart_tv == Everyday Wow
        $sec_cache = date('s');
        $sec_cache  = $sec_cache < 30 ? 00 : 30;
        $date = date('Y-m-d H:i:s',mktime(date('H'),date('i'),$sec_cache,date('m'),date('d'),date('Y')));

        $attrs['product_today'] = array();

        ### Today ###
        $params1 = array(
            'campaign' => $campaign,
            'date' => $date,
            'date_rule' => 'current',
        );
        $res_today = $this->pcmsClient->apiv2("discount-campaigns/single-product", $params1);

        ### Tomorrow ###
        $params2 = array(
            'campaign' => $campaign,
            'date' => $date,
            'date_rule' => 'incoming'
        );
        $res_tomorrow = $this->pcmsClient->apiv2("discount-campaigns/single-product", $params2);

        $platform = ( preg_match("/^(m|m2|m-(a|b|b1|b2))\.|-m\./i", Request::server('HTTP_HOST')) || isset($_COOKIE['force_mobile'])) ? 'mobile' : 'desktop' ;

        if ($platform == 'mobile') {
            // Product today
            $todayProduct = array_get($res_today, 'data') ? : array();

            //Product tomorow
            $tomorrowProduct = array_get($res_tomorrow, 'data') ? : array();

            $products = compact('todayProduct', 'tomorrowProduct');

            foreach ($products as $index => $product) {
                if (count($product) > 0) {
                    $activeDiscountVariant = array();

                    foreach (array_get($product, 'variants') ? : array() as $key => $variant) {
                        $special_discount_ended = array_get($product, 'discount_ended');
                        $discount_ended = array_get($variant, 'active_special_discount.ended_at');
                        if (str_replace("T", " ", $special_discount_ended) == str_replace("T", " ", $discount_ended)) {
                            $activeDiscountVariant = $variant;
                        }
                    }
                    $products[$index] += compact('activeDiscountVariant');
                }
            }

            $attrs = $products;

        } else {
            // Product today
            if (isset($res_today['code']) && $res_today['code'] == 200 && !empty($res_today["data"]) ) {
                $attrs['product_today'][0] = $res_today["data"];
            } else {
                $attrs['product_today'][0] = array();
            }

            // Product tomorow
            if (isset($res_tomorrow['code']) && $res_tomorrow['code'] == 200 && !empty($res_tomorrow["data"]) ) {
                $attrs['product_today'][1] = $res_tomorrow["data"];
            } else {
                $attrs['product_tomorrow'][1] = array();
            }
        }

        $attrs["wowBanner"] = $this->getWowBanner();

        return $attrs;
    }


    protected function getWowBanner(){
        $wowBannerPosition = Config::get("widget_params.superDealBannerPosition");
        $bannerWow = array();
        $params = array(
            "position" => $wowBannerPosition
        );
        $response = $this->pcmsClient->apiv2("banners", $params);
        if(!empty($response['data'][0]) && $response["code"] == 200){
            $data = $response['data'][0];
            if ( !empty($data["group_list"][0]["banner_list"][0]) ){
                $data = $data["group_list"][0]["banner_list"][0];
                $bannerWow["url_link"] = array_get($data, "url_link","#");
                $bannerWow["img_path"] = array_get($data, "img_path", "#");
                $bannerWow["width"] = array_get($data, "width", null);
                $bannerWow["height"] = array_get($data, "height", null);
                $bannerWow["target"] = array_get($data, "target", '_blank');
            }
        }

        return $bannerWow;
    }

}
