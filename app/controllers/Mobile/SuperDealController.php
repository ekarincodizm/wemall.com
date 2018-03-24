<?php namespace Mobile;

use App;
use Cache;
use Input;
use MobileBaseController;
use Request;
use URL;

class SuperDealController extends MobileBaseController
{
    public $banner;

    public $campaign;

    public function getIndex()
    {
        $sec_cache = date('s') < 30 ? 00 : 30;
        $date = date('Y-m-d H:i:s', mktime(date('H'), date('i'), $sec_cache, date('m'), date('d'), date('Y')));
        $campaign = 'itruemart_tv'; //itruemart_tv == Everyday Wow

        $superDeal = App::make('SuperDealRepositoryInterface');

        /**
         * today or current product ja
         */
        $data = array(
            'campaign' => $campaign,
            'date' => $date,
            'date_rule' => 'current',
        );
        $response = $superDeal->getDiscountToday($data);
        $todayProduct = array_get($response, 'data') ? : array();

        /**
         * tomorrow or incoming product ja
         */
        $data = array(
            'date' => $date,
            'date_rule' => 'incoming',
            //'order' => 'desc',
            'campaign' => $campaign,
        );
        $response = $superDeal->getDiscountIncoming($data);
        $tomorrowProduct = array_get($response, 'data') ? : array();

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

        $viewData = array() + $products;

        $this->theme->setTitle('Everyday Wow | iTruemart.ph');
        $this->theme->setMetadescription(__('seo_description_home'));
        $this->theme->setMetakeywords(__('seo_keyword_home'));
        $this->theme->setCanonical('http://'.Request::server ("SERVER_NAME").'/'.Request::path());

        $this->theme->partialComposer('meta_og', function($view)
        {
            $view->with('meta_title', 'Everyday Wow | iTruemart.ph');
            $view->with('meta_image', 'http://m.itruemart.com/themes/itruemart/assets/images/meta-og/everydaywow.jpg');
            $view->with('meta_url', 'http://m.itruemart.com/everyday-wow');
            $view->with('meta_description', __('seo_description_home'));
            $view->with('meta_type', 'mobile');
        });

        return $this->theme->scope('superdeal.index', $viewData)->render();
    }

    public function getAjax()
    {
        $attrs = array(
            'limit' => 6,
            'page' => Input::get('page') ? : 1,
            'orderBy' => Input::get('orderBy', 'discount_ended'),
            'order' => Input::get('order', 'desc'),
            'campaign' => 'all'
        );
        $response = $this->theme->widget('WidgetSuperDealProductList', $attrs)->render();
        if (!$response) {
            return "";
        }

        $nextPage = null;
        $currentPage = URL::current() . '?' . Request::getQueryString();
        if (preg_match("#page=([0-9]+)&?#", $currentPage, $matches)) {
            $nextPage = str_replace("page=" . $matches[1], "page=" . ($matches[1] + 1), $currentPage);
        } else {
            $nextPage = $currentPage . '&page=2';
        }

        if(Input::has("no-cache")){
            $nextPage .= "&no-cache=" . Input::get("no-cache", '1');
        }

        if ($nextPage) {
            $response .= '<div class="next"><a href="' . $nextPage . '">next</a></div>';
        }

        return $response;
    }
}