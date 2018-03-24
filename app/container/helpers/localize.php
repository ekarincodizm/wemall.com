<?php

/**
 * Language helper.
 *
 * @param  string $line
 * @param  array  $args
 * @return string
 */
function __($line, $args = array())
{
    return Lang::translate($line, $args);
}

function _e($line, $args = array())
{
    echo __($line, $args);
}

function __plural($line, $number = 2, $args = array())
{
    if (App::getLocale() === 'en')
        return str_plural( Lang::translate($line, $args), $number);
    return __($line, $args);
}

function price_format($price=0, $currency=null, $decimals=null, $discount = false)
{
    $cookieCurrency = Cookie::get('currency', 'PHP');
    $currency = strtoupper( $currency ?: $cookieCurrency );

    switch ($currency)
    {
        case 'USD':
            if($discount == true && $price != 0):
                return '$ -' . number_format($price, $decimals ?: 2);
            else:
                return '$ ' . number_format($price, $decimals ?: 2);
            endif;
            break;
        default:
            if($discount == true && $price != 0):
                return '₱ -' . number_format($price, $decimals ?: 2);
            else:
                return '₱ ' . number_format($price, $decimals ?: 2);
            endif;
            break;
    }
}

function getTranslateLocale()
{
    $locale = array(
        'en' => 'en_US',
        'th' => 'th_TH',
    );
    return array_get($locale, App::getLocale());
}

function langToLocale($lang)
{
    switch ($lang)
    {
        case 'th':
            return 'th_TH';
        case 'en':
            return 'en_US';
        default:
            return $lang;
    }
}