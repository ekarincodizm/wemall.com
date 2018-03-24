<?php

$platform = (preg_match("/^(m|m2|m-(a|b|b1|b2))\.|-m\./i", Request::server('HTTP_HOST')) || isset($_COOKIE['force_mobile'])) ? 'mobile' : 'desktop';

$lang = LaravelLocalization::setLanguage();
$prefixLang = $lang ? $lang . '/' : '';

// route include checker
$routeIncluded = false;

if (isURL($prefixLang ?: '/')) {
    // route for homepage
    require_once app_path() . '/routes/home.php';
    $routeIncluded = true;
}

if (isURL($prefixLang . 'shopbybrand')) {
    // route for homepage
    require_once app_path() . '/routes/product-level-b.php';
    $routeIncluded = true;
}

if (isURL($prefixLang . 'category/[^/]+')) {
    // route for homepage
    require_once app_path() . '/routes/product-level-c-category.php';
    $routeIncluded = true;
}

if (isURL($prefixLang . 'brand/[^/]+')) {
    // route for homepage
    require_once app_path() . '/routes/product-level-c-brand.php';
    $routeIncluded = true;
}

if (isURL($prefixLang . 'products/[^/]+')) {
    // route for homepage
    require_once app_path() . '/routes/product-level-d.php';
    $routeIncluded = true;
}


if ($routeIncluded == false) {
    // route for all sites
    // we will optimize later
    require_once app_path() . '/routes/default.php';
}

if ($platform == 'mobile') {
    # Require route - Mobile version
    require_once app_path() . '/routes/mobile.php';
//   $routeIncluded = true;
}

/*
|--------------------------------------------------------------------------
| Addition Routes
|--------------------------------------------------------------------------
|
| Static, SEO, Robots.
|
*/

require_once app_path() . '/addition-routes.php';

/*
|--------------------------------------------------------------------------
| Route Binds
|--------------------------------------------------------------------------
|
| Blinding routes.
|
*/

require_once app_path() . '/binds.php';

