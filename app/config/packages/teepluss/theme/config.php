<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Asset url path
      |--------------------------------------------------------------------------
      |
      | The path to asset, this config can be cdn host.
      | eg. http://cdn.domain.com
      |
     */

    'assetUrl' => URL::to('/'),
    /*
      |--------------------------------------------------------------------------
      | Asset compression path
      |--------------------------------------------------------------------------
      |
      | The path to compress assets after at public directory.
      |
     */
    'compressDir' => 'cache',
    /*
      |--------------------------------------------------------------------------
      | Force compress assets
      |--------------------------------------------------------------------------
      |
      | This forces Theme to (re)compile compression assets on every invocation.
      | By default this is FALSE. This is handy for development and debugging,
      | It should never be used in a production environment.
      |
     */
    'forceCompress' => false,
    /*
      |--------------------------------------------------------------------------
      | Capture asset compression
      |--------------------------------------------------------------------------
      |
      | When you queue asset to be compression, normally It read your file(s)
      | everytime, but on production you can stop the process by set capture
      | true, this will be increase performance.
      |
      | eg. (App::environment() == 'production') ? true : false
      |
     */
    'assetCapture' => false,
    /*
      |--------------------------------------------------------------------------
      | Theme Default
      |--------------------------------------------------------------------------
      |
      | If you don't set a theme when using a "Theme" class the default theme
      | will replace automatically.
      |
     */
    'themeDefault' => 'default',
    /*
      |--------------------------------------------------------------------------
      | Layout Default
      |--------------------------------------------------------------------------
      |
      | If you don't set a layout when using a "Theme" class the default layout
      | will replace automatically.
      |
     */
    'layoutDefault' => 'default',
    /*
      |--------------------------------------------------------------------------
      | Path to lookup theme
      |--------------------------------------------------------------------------
      |
      | The root path contains themes collections.
      |
     */
    'themeDir' => 'themes',
    /*
      |--------------------------------------------------------------------------
      | A pieces of theme collections
      |--------------------------------------------------------------------------
      |
      | Inside a theme path we need to set up directories to
      | keep "layouts", "assets" and "partials".
      |
     */
    'containerDir' => array(
        'layout' => 'layouts',
        'asset' => 'assets',
        'partial' => 'partials',
        'widget' => 'widgets',
        'view' => 'views'
    ),
    /*
      |--------------------------------------------------------------------------
      | Listener from events
      |--------------------------------------------------------------------------
      |
      | You can hook a theme when event fired on activities
      | this is cool feature to set up a title, meta, default styles and scripts.
      |
     */
    'events' => array(
        // Before all event, this event will effect for global.
        'before' => function($theme) {
    $locale = App::getLocale();
    $pcmsClient = App::make('pcms');
    $itruemartClient = App::make('itruemart');

    // Data passing to navbar.
    Theme::partialComposer('navbar', function($view) use ($locale, $pcmsClient) {
        // navbar horizontal
        $typos = Config::get('typos');
        $navbar = $typos['navbar'][$locale];
        $view->with('navbar', $navbar);

        // navbar verical menu
        $brands = Config::get('brands');
        $shop_by_band = $brands[$locale];
        $view->with('shop_by_band', $shop_by_band);

        // vertical menu
        $response = $pcmsClient->getVertical();
        $view->with('vertical', $response);
    });

    // Data passing to footer.
    Theme::partialComposer('footer', function($view) use ($locale, $pcmsClient, $itruemartClient) {
        
        $response = array();
        $currentUri = Request::path();
        if(! preg_match('/checkout/i', $currentUri) ){
            try {
                $response = (array) $itruemartClient->getSeoEssay('levelA')->getResponse();
            } catch (\Exception $e) {
                $response = array();
            }
        }
        $view->with('footer_seo_essay', array_get($response, 'data.seo'));
        
        $footerResponse = array();
        if(! preg_match('/checkout/i', $currentUri) ){
            try {
                $footerResponse = (array) $itruemartClient->getSeoFooter()->getResponse();
            } catch (\Exception $e) {
                $footerResponse = array();
            }
        }
        $footerResponse = array_get($footerResponse, 'data');

        if (is_array($footerResponse) && count($footerResponse)) {
            sort($footerResponse);
        }

        $view->with('footer_seo_link', $footerResponse);

        // Footer link product type
        $type_products = Config::get('typos.footer_link.type_products');
        $view->with('type_products', $type_products[$locale]);

        $promotions = Config::get('typos.footer_link.promotions');
        $view->with('promotions', $promotions[$locale]);

        $services = Config::get('typos.footer_link.services');
        $view->with('services', $services[$locale]);

        // Socials
        $socials = Config::get('socials');
        $view->with('footer_socials', $socials);

        // payments channel
        $payments = Config::get('typos.payments');
        $view->with('payments', $payments[$locale]);

        // ecommerce tracking
//        if (Request::segment(2) == 'thank-you') {
//            $user = ACL::getUser();
//            $params['order_id'] = Input::get('order_id');
//            $params['customer_ref_id'] = $user['user_id'];
//            $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
//            $params['sso_id'] = $user['ssoId'];
//            $response = $pcmsClient->api('payment/item', $params);
//            $view->with('order', $response);
//        }
    });
},
        // This event will fire as a global you can add any assets you want here.
        'asset' => function($asset) {
    // Preparing asset you need to serve after.
    // $asset->cook('backbone', function($asset)
    // {
    //     $asset->add('backbone', '//cdnjs.cloudflare.com/ajax/libs/backbone.js/1.0.0/backbone-min.js');
    //     $asset->add('underscorejs', '//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.4.4/underscore-min.js');
    // });
    // To use cook 'backbone' you can fire with 'serve' method.
    // Theme::asset()->serve('backbone');
}
    )
);
