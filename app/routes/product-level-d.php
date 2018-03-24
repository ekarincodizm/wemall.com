<?php

Route::group(array('prefix' => LaravelLocalization::setLanguage(), 'before' => 'SimTMH|AwsCloud|AuthLoginRedirect|LaravelLocalizationRedirectFilter|detectDeviceFilter'), function()
{

    // Shop By Brand (Level B)
    Route::get('shopbybrand', array(
        'as'   => 'shopbybrand.index',
        'uses' => 'BrandsController@getIndex'
    ));

    Route::get('search', array(
        'as'   => 'search',
        'uses' => 'SearchController@getIndex'
    ));
    //search for Solr
    Route::get('search2', array(
        'as'   => 'search2',
        'uses' => 'SolrSearchController@getIndex'
    ));

    Route::get('auth/login', array(
        'as'   => 'auth.login',
        'uses' => 'AuthController@getLogin'
    ));

    Route::get('auth/logout', array(
        'as'   => 'auth.logout',
        'uses' => 'AuthController@getLogout'
    ));

    Route::get('users/register', array(
        'as'   => 'users.register',
        'uses' => 'UsersController@getRegister'
    ));

    // View Product (Level D)
    Route::get('products/{productPkey}', array(
        'as'   => 'products.detail',
        'uses' => 'ProductsController@getDetail'
    ));

    // Home page (Level-A)
    Route::get('/', array(
        'as'   => 'home',
        'uses' => 'HomeController@getIndex'
    ));

});

