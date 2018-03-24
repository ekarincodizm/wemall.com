<?php

//Route::get('/robots.txt', array(
//    'as' => 'robots',
//    function()
//    {
//        $robots = Config::get('seo.robots');
//
//        $response = Response::make($robots());
//
//        $response->header('Content-Type', 'text/plain');
//
//        return $response;
//    }
//));

// Route::get('/404', array(
//     'as' => '404',
//     function()
//     {
//         $uses = (preg_match("#^m\.#", Request::server('HTTP_HOST'))) ? 'itruemart-mobile' : 'itruemart';

//         $theme = Theme::uses($uses)->layout('default');

//         if ($uses == "itruemart-mobile")
//         {
//             $theme->asset()->usePath()->add('css-main', 'css/main.css');
//             $theme->asset()->usePath()->add('css-addon', 'css/addon.css');
//         }
//         return $theme->scope('errors.404')->render(404);
//     }
// ));//

Route::get('/order_tracking', function() {
    return Redirect::to("/member/orders");
});

Route::get('/cache-control', function() {
    if ( !isset($_COOKIE['injectconsole'])) {
        return App::abort(404);
    }

    echo '<h1>Cache Control</h1><hr />';

    $find = Input::get('find', false);
    $view = Input::get('view_cache', false);

    echo '<form action="/cache-control" method="get">Clear cache where key like = <input type="text" name="find" value="' . $find . '"><input type="submit" value="Submit"></form>';

    echo '<form action="/cache-control" method="get">Search cache value where key like = <input type="text" name="view_cache" value="' . $view . '"><input type="submit" value="Submit"></form>';

    if (!empty($find)) {
        echo '<h2>Found "' . $find . '"</h2>';

        $keys = ElastiCache::getAllKeys();
        $found = array();

        foreach ($keys as $key) {
            if (preg_match("/" . $find . "/i", $key)) {
                $found[] = $key;
            }
        }

        if (empty($found)) {
            echo 'empty result.';
        }
        else {
            foreach ($found as $key) {
                $key = str_replace('laravel:', '', $key);
                try {
                    ElastiCache::remove($key);
                    echo "<br /> - CLEAR: " . $key;
                } catch(Exception $e) {
                    echo "<br /> x ERROR: " . $key;
                    echo "<br />..." . $e->getMessage();
                }
            }
        }
    }

    if (!empty($view)) {
        echo '<h2>Found "' . $view . '"</h2>';

        $keys = ElastiCache::getAllKeys();
        $found = array();

        foreach ($keys as $key) {
            if (preg_match("/" . $view . "/i", $key)) {
                $found[] = $key;
            }
        }

        if (empty($found)) {
            echo 'empty result.';
        }
        else {
            foreach ($found as $key) {
                $key = str_replace('laravel:', '', $key);
                try {
                    $result = ElastiCache::getResult($key);
                    echo "<br /> - RESULT: " . $key;
                    echo "<br /><textarea>" . $result . "</textarea>";
                } catch(Exception $e) {
                    echo "<br /> x ERROR: " . $key;
                    echo "<br />..." . $e->getMessage();
                }
            }
        }
    }
});