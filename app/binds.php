<?php

// Route Bind productPkey (get only pkey from uri)
Route::bind('productPkey', function($value, $route)
{
    $pattern = '!(\d+)(\.html|\.htm)?$!';

    preg_match($pattern, $value, $match);
    $pkey = ( !empty($match) ) ? $match[1] : '' ;

    if ( !empty($pkey) )
    {
        $pcmsClient = App::make('pcms');
        $response = $pcmsClient->api("products/real-pkey/{$pkey}");

        if ( !empty($response['data']) )
        {
            $pkey = $response['data']['pkey'];
        }
    }

    return $pkey;
});

// Route Bind collectionPkey (get only pkey from uri)
Route::bind('collectionPkey', function($value, $route)
{
    $pattern = '!(\d+)(\.html|\.htm)?$!';

    preg_match($pattern, $value, $match);
    $pkey = ( !empty($match) ) ? $match[1] : '' ;

    if ( !empty($pkey) )
    {
        $pcmsClient = App::make('pcms');
        $response = $pcmsClient->api("collections/real-pkey/{$pkey}");

        if ( !empty($response['data']) )
        {
            $pkey = $response['data']['pkey'];
        }
    }

    return $pkey;
});

// Route Bind brandPkey (get only pkey from uri)
Route::bind('brandPkey', function($value, $route)
{
    $pattern = '!(\d+)(\.html|\.htm)?$!';

    preg_match($pattern, $value, $match);
    $pkey = ( !empty($match) ) ? $match[1] : '' ;

    if ( !empty($pkey) )
    {
        $pcmsClient = App::make('pcms');
        $response = $pcmsClient->api("brands/real-pkey/{$pkey}");

        if ( !empty($response['data']) )
        {
            $pkey = $response['data']['pkey'];
        }
    }

    return $pkey;
});