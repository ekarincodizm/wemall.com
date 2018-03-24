<?php

Route::group(array('prefix' => LaravelLocalization::setLanguage(), 'before' => 'AwsCloud|AuthLoginRedirect|LaravelLocalizationRedirectFilter|detectDeviceFilter'), function()
{

    // List Products By Brand (Level C)
    Route::get('brand/{brandPkey?}', array(
        'as'   => 'brands.products',
        'uses' => 'ProductsController@getBrandProducts'
    ));

    Route::get('search', array(
        'as'   => 'search',
        'uses' => 'SearchController@getIndex'
    ));

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

    // Shop By Brand (Level B)
    Route::get('shopbybrand', array(
        'as'   => 'shopbybrand.index',
        'uses' => 'BrandsController@getIndex'
    ));

    // Home page (Level-A)
    Route::get('/', array(
        'as'   => 'home',
        'uses' => 'HomeController@getIndex'
    ));

});

