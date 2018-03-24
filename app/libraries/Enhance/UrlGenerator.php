<?php namespace Enhance;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Routing\UrlGenerator as LaravelUrlGenerator;
use Illuminate\Support\Facades\Request as IlluminateRequest;
use Illuminate\Support\Facades\URL as URL;
use Illuminate\Support\Facades\Input as Input;

class UrlGenerator extends LaravelUrlGenerator
{

    /**
     * URL::to with language.
     *
     * @param  string $path
     * @return string
     */
    public function toLang($path, $extra = array(), $secure = false)
    {
        $path = ltrim($path, '/');

        return $this->to(\LaravelLocalization::localizeURL($path), $extra, $secure);
    }

    /**
     * Switch language url generator.
     *
     * @param  string $lang
     * @return string
     */
    public function switchLang($lang)
    {
        if (IlluminateRequest::is('*search2*')) {
            $queryString = Input::except(
                'brand_th',
                'brand_en',
                'color_th',
                'color_en',
                'priceMin',
                'priceMax',
                'collection',
                'orderBy',
                'order',
                'size_en',
                'size_th',
                'payment_ccw',
                'payment_installment',
                'payment_bank_transfer',
                'payment_atm',
                'payment_cs',
                'payment_cod',
                'payment_internet_banking',
                'payment_over_the_counter',
                'page',
                'per_page'
            );

            return URL::to("/$lang/search2?" . http_build_query($queryString));
        } else {
            return \LaravelLocalization::getLocalizedURL($lang);
        }
    }

}