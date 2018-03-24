<?php

Route::controller('truemove-h/api', 'TruemoveHController');

Route::group(array('namespace' => 'Mobile', 'prefix' => LaravelLocalization::setLanguage(), 'before' => 'AwsCloud|AuthLoginRedirect|LaravelLocalizationRedirectFilter|detectDeviceFilter|redirect_ph'), function()
{

    Route::post('ajax/customers/save-ship-addr', array(
        'as'   => 'ajax.customers.save-ship-addr',
        'uses' => 'CustomersController@postSaveShipAddress'
    ));

    Route::post('ajax/customers/edit-ship-addr', array(
        'as'   => 'ajax.post.customer.edit-ship-addr',
        'uses' => 'CustomersController@postSaveShipAddress'
    ));

    Route::post('ajax/customers/delete-ship-addr', array(
        'as'   => 'ajax.customer.delete-ship-addr',
        'uses' => 'CustomersController@postDeleteShipAddress'
    ));

    Route::get('/', array(
        'as'   => 'home',
        'uses' => 'HomeController@getIndex'
    ));

    Route::get('home-ajax', array(
        'as'   => 'home-ajax',
        'uses' => 'HomeController@getHomeAjax'
    ));

    /**
     * Customer
     */
    Route::get('customers/edit-shipping-address', array(
        'as'   => 'customer.edit-ship-addr',
        'uses' => 'CustomersController@getShippingAddressForm'
    ));
    Route::get('customers/create-shipping-address', array(
        'as'   => 'customer.create-ship-addr',
        'uses' => 'CustomersController@getShippingAddressForm'
    ));

    /**
     * Everyday wow route
     */
    /*
    Route::get('everyday-wow', array(
        'as'   => 'everyday-wow',
        'uses' => 'EverydayWowController@getIndex'
    ));
    Route::get('everyday-wow-{category_slug}', array(
        'as'   => 'everyday-wow',
        'uses' => 'EverydayWowController@getIndex'
    ));
    */
    Route::get('/categories', array(
        'as'   => 'categories.index',
        'uses' => 'CategoriesController@getIndex'
    ));

    Route::get('/categories/content', array(
        'as'   => 'categories.content',
        'uses' => 'CategoriesController@getContent'
    ));

    Route::get('/categories/{pkey}', array(
        'as'   => 'categories.sub-category',
        'uses' => 'CategoriesController@getSubCategory'
    ));

    Route::get('/categories/content/{pkey}', array(
        'as'   => 'categories.sub-category-content',
        'uses' => 'CategoriesController@getSubCategoryContent'
    ));

    Route::any('cate/search-view', array(

        'as'   => 'categories.search.view',
        'uses' => 'ProductsController@categoryProductsView'
    ));

    // List Products By Category (Level C)
    Route::get('category/{collectionPkey?}', array(
        'as'   => 'categories.products',
        'uses' => 'ProductsController@getCategoryProducts'
    ));

    Route::get('/products/stocks/{inventoryIds}', array(
        'as'   => 'products.stocks',
        'uses' => 'ProductsController@getStocks'
    ));

    Route::get('/products/rebuild-mobile-stocks/{inventoryIds}', array(
        'as'   => 'products.rebuild-mobile-stocks',
        'uses' => 'ProductsController@anyRebuildMobileStock'
    ));

    Route::get('/products/content/{productPkey}', array(
        'as'   => 'products.level-d.content',
        'uses' => 'ProductsController@getLevelDContent'
    ));

    Route::get('/products/detail/{productPkey}', array(
        'as'   => 'products.level-d-detail',
        'uses' => 'ProductsController@getLevelDDetail'
    ));

    Route::get('/products/detail-content/{productPkey}', array(
        'as'   => 'products.level-d-detail-content',
        'uses' => 'ProductsController@getLevelDDetailContent'
    ));

    Route::get('/products/{productPkey}', array(
        'as'   => 'products.level-d',
        'uses' => 'ProductsController@getLevelD'
    ));

    Route::get('/cart', array(
        'as'   => 'cart.index',
        'uses' => 'CartController@getIndex'
    ));

    Route::get('/cart/content', array(
        'as'   => 'cart.content',
        'uses' => 'CartController@getContent'
    ));

    Route::post('/cart/add-item', array(
        'as'   => 'cart.add-item',
        'uses' => 'CartController@postAddItem'
    ));

    Route::post('/cart/update-item', array(
        'as'   => 'cart.update-item',
        'uses' => 'CartController@postUpdateItem'
    ));

    Route::post('/cart/remove-item', array(
        'as'   => 'cart.remove-item',
        'uses' => 'CartController@postRemoveItem'
    ));

    Route::post('/cart/select-shipping-methods', array(
        'as'   => 'cart.select-shipping-methods',
        'uses' => 'CartController@postSelectShippingMethods'
    ));

    Route::get('/cart/mini-cart', array(
        'as'   => 'cart.minicart',
        'uses' => 'CartController@getMiniCart'
    ));

    Route::get('/search', array(
        'as'   => 'search.index',
        'uses' => 'SearchController@getIndex'
    ));

    Route::any('search/view', array(
        'as'   => 'search.view',
        'uses' => 'SearchController@searchView'
    ));

    Route::get('/search/content', array(
        'as'   => 'search.content',
        'uses' => 'SearchController@getContent'
    ));

    ### SolrSearch###

    Route::get('/search2', array(
        'as'   => 'solrSearch.index',
        'uses' => 'SolrSearchController@getIndex'
    ));

    Route::any('search2/view', array(
        'as'   => 'solrSearch.view',
        'uses' => 'SolrSearchController@searchView'
    ));

    Route::get('/search2/content', array(
        'as'   => 'solrSearch.content',
        'uses' => 'SolrSearchController@getContent'
    ));

    Route::get('news/detail/{newsSlug}.html', array(
        'as'   => 'news.detail',
        'uses' => 'NewsController@getDetail'
    ));

    ### TruemoveH Mobile ###
    Route::group(array('prefix' => 'truemove-h'), function()
    {
        // Landing Page
        Route::get('/', array(
            'as'   => 'truemove-h',
            'uses' => 'TruemoveHController@getIndex'
        ));

        // Registration
        Route::get('registration', array(
            'as'   => 'truemove-h/registration',
            'uses' => 'TruemoveHController@getRegister'
        ));

        // Forecast
        Route::get('forecasts', array(
            'as'   => 'truemove-h/forecasts',
            'uses' => 'TruemoveHController@getForecasts'
        ));

        /* Remove for reuse the web controller route controllers/TruemoveHController.php */
        // Route::controller('api', 'App\Controllers\TruemoveHController');

    });
});

