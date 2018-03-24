<?php

/*
  |--------------------------------------------------------------------------
  | Application & Route Filters
  |--------------------------------------------------------------------------
  |
  | Below you will find the "before" and "after" events for the application
  | which may be used to do any work before or after a request into your
  | application. Here you may also register your custom route filters.
  |
 */

App::before(function($request)
{

     $sanitized = Commons::globalXssClean(Input::all());
     Input::replace($sanitized);

    $notAllowOrigin = array("a-ng-develop", "aws-production", "aws-alpha", "alpha-aws", "production", "aws-staging");
    if( !in_array(App::environment(), $notAllowOrigin) ){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
    }

});


App::after(function($request, $response)
{
    //
});

/*
  |--------------------------------------------------------------------------
  | Authentication Filters
  |--------------------------------------------------------------------------
  |
  | The following filters are used to verify that the user of the current
  | session is logged into this application. The "basic" filter easily
  | integrates HTTP Basic authentication for quick, simple checking.
  |
 */

Route::filter('auth', function()
{
    if ( Auth::guest() )
        return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
    return Auth::basic();
});

Route::filter('auth.basic2', function()
{
    $users = array(
        '9gag' => 'lol'
    );

    $requestUser = Request::getUser();
    $requestPass = Request::getPassword();

    if ( array_get($users, $requestUser) != $requestPass )
    {
        $headers = array('WWW-Authenticate' => 'Basic');

        return new Symfony\Component\HttpFoundation\Response('Invalid credentials.', 401, $headers);
    }
});

Route::filter('auth.debug', function()
{
    // $users = array(
    //     'admin' => 'true'
    // );
    // $requestUser = Request::getUser();
    // $requestPass = Request::getPassword();
    // if (array_get($users, $requestUser) != $requestPass)
    // {
    //     $headers = array('WWW-Authenticate' => 'Basic');
    //     return new Symfony\Component\HttpFoundation\Response('Invalid credentials.', 401, $headers);
    // }
});

/*
  |--------------------------------------------------------------------------
  | Guest Filter
  |--------------------------------------------------------------------------
  |
  | The "guest" filter is the counterpart of the authentication filters as
  | it simply checks that the current user is not logged in. A redirect
  | response will be issued if they are, which you may freely change.
  |
 */

Route::filter('guest', function()
{
    if ( Auth::check() )
        return Redirect::to('/');
});

/*
  |--------------------------------------------------------------------------
  | CSRF Protection Filter
  |--------------------------------------------------------------------------
  |
  | The CSRF filter is responsible for protecting your application against
  | cross-site request forgery attacks. If this special token in a user
  | session does not match the one given in this request, we'll bail.
  |
 */

Route::filter('csrf', function()
{
    if ( Session::token() != Input::get('_token') )
    {
        throw new Illuminate\Session\TokenMismatchException;
    }
});

Route::filter('detect.mobile', function($route, $request)
{
    $pattern = App::environment('a-develop') ? 'm\-' : 'm\.';
    $replace = App::environment('a-develop') ? 'm-' : 'm.';

    // check m. as subdomain so force mobile layout
    $isMobileSubdomain = preg_match("#^" . $pattern . "#", Request::server('HTTP_HOST')) ? : false;

    if ( !$isMobileSubdomain )
    {
        if ( Input::get('force') == 'desktop' )
        {
            // if mobile site detect input force desktop so set session
            Cookie::queue('force_desktop', 'true', 10);
            return Redirect::refresh();
        }
    }

    if (
            !$isMobileSubdomain
            && Agent::isMobile()
            && !Agent::isTablet()
            && Cookie::get('force_desktop') != 'true'
    )
    {
        $url = preg_replace("#//(www\.)?#", "//" . $replace, URL::current());

        return Redirect::to($url);
    }
});

Route::filter('redirect.history', function($route, $request)
{
    /* $backurl = Input::get('backurl');

      if($backurl = 'Y')
      {
      $CustomerAddressRepository = New CustomerAddressRepository;

      $stage = $CustomerAddressRepository->getStage();
      $uri = $route->getUri();
      if(!empty($uri))
      {
      $uri_arr = explode('/', $uri);
      }
      $user = ACL::getUser();

      if($uri_arr[1] != $stage['current_stage'] )
      {
      if($stage['current_stage'] == 'step1')
      {
      return Redirect::to('checkout/step1');
      }
      elseif($stage['current_stage'] == 'step2')
      {
      return Redirect::to('checkout/step2');
      }
      elseif($stage['current_stage'] == 'step3')
      {
      return Redirect::to('checkout/step3');
      }
      }
      } */
});

Route::filter('checkNoItem', function($route, $request)
{

    $pcms     = App::make('pcms');
    $response = $pcms->getCheckoutV2();

    if ( !empty($response['status']) && !empty($response['data']) )
    {
        $items_count = isset($response['data']['items_count']) ? $response['data']['items_count'] : 0;
        if ( $items_count == 0 )
        {
            return Redirect::to(URL::toLang('checkout/no-item'));
        }
    }
    else
    {
        return Redirect::to(URL::toLang('checkout/no-item'));
    }
});

Route::filter('checkHaveItem', function($route, $request)
{
    $pcms     = App::make('pcms');
    $response = $pcms->getCheckoutV2();

    if ( !empty($response['status']) && !empty($response['data']) )
    {
        $items_count = isset($response['data']['items_count']) ? $response['data']['items_count'] : 0;
        if ( $items_count > 0 )
        {
            if ( App::environment('production') || App::environment('beta') )
            {
                // The environment is production
                return Redirect::to(URL::toLang('checkout/step1', array(), true));
            }
            else
            {
                return Redirect::to(URL::toLang('checkout/step1'));
            }
        }
    }
});

Route::filter('checkstep2', function($route, $request)
{
    $CustomerAddressRepository = New CustomerAddressRepository;

    $stage = $CustomerAddressRepository->getStage();
    $uri   = $route->getUri();
    if ( !empty($uri) )
    {
        $uri_arr = explode('/', $uri);
    }

    if ( !empty($stage['current_stage']) && !empty($uri_arr[1]) )
    {
        if ( $stage['current_stage'] != $uri_arr[1] )
        {
            if ( $stage['history_stage']['s1'] != 'Y' || $stage['history_stage']['s2'] != 'Y' )
            {
                if ( App::environment('production') || App::environment('beta') )
                {
                    // The environment is production
                    return Redirect::to(URL::toLang('checkout/step1', array(), true));
                }
                else
                {
                    return Redirect::to(URL::toLang('checkout/step1'));
                }
            }
        }
    }
    elseif( !ACL::isLoggedIn() )
    {
        if ( App::environment('production') || App::environment('beta') )
        {
            // The environment is production
            return Redirect::to(URL::toLang('checkout/step1', array(), true));
        }
        else
        {
            return Redirect::to(URL::toLang('checkout/step1'));
        }
    }
});

Route::filter('checkstep3', function($route, $request)
{

    $CustomerAddressRepository = New CustomerAddressRepository;

    $stage = $CustomerAddressRepository->getStage();
    $uri   = $route->getUri();
    if ( !empty($uri) )
    {
        $uri_arr = explode('/', $uri);
    }

    if ( !empty($stage['current_stage']) && !empty($uri_arr[1]) )
    {
        if ( $stage['current_stage'] != $uri_arr[1] )
        {
            if ( $stage['history_stage']['s1'] != 'Y' || $stage['history_stage']['s2'] != 'Y' || $stage['history_stage']['s3'] != 'Y' )
            {
                if ( $stage['history_stage']['s1'] == 'Y' || $stage['history_stage']['s2'] == 'Y' )
                {
                    return Redirect::to(URL::toLang('checkout/step2'));
                }
                else
                {
                    if ( App::environment('production') || App::environment('beta') )
                    {
                        // The environment is production
                        return Redirect::to(URL::toLang('checkout/step1', array(), true));
                    }
                    else
                    {
                        return Redirect::to(URL::toLang('checkout/step1'));
                    }
                }
            }
        }
    }
    else
    {
        if ( App::environment('production') || App::environment('beta') )
        {
            // The environment is production
            return Redirect::to(URL::toLang('checkout/step1', array(), true));
        }
        else
        {
            return Redirect::to(URL::toLang('checkout/step1'));
        }
    }
});


Route::filter('clearStage', function($route, $request){
    $CustomerAddressRepository = App::make("CustomerAddressRepositoryInterface");
    $CustomerAddressRepository->deleteStage();
});

/**
 * Redirect filter to http.
 */
Route::filter("redirect_http", function($route, $request)
{
    if ( $request->server("HTTPS") == 'on' || $request->server("HTTP_X_FORWARDED_HTTPS") == 'on' )
    {
        return Redirect::to(URL::toLang($request->server("REQUEST_URI"), array(), false));
    }
});

/**
 * Redirect filter to https.
 */
Route::filter("redirect_https", function($route, $request)
{
   /**
     * There are some environment don't need to use https.
     * I have to set up a useHttps var in https configuration file.
     */
    $allowHttps = Config::get("https.useHttps");

    $httpsSever = $request->server("HTTPS");
    $xhttpsServer = $request->server("HTTP_X_FORWARDED_HTTPS");

    if ( empty($httpsSever) && empty($xhttpsServer) && $allowHttps )
    {
        return Redirect::to(URL::toLang($request->server("REQUEST_URI"), array(), true));
    }
});

/**
 * Redirect filter to http.
 */
Route::filter("redirect_ph", function($route, $request)
{
    if(preg_match("/\.com\.ph/", URL::current())){
        $url = preg_replace("/\.com\.ph/", ".ph", URL::current());

        return Redirect::to($url);
    }
});

/*
  |--------------------------------------------------------------------------
  | Laravel Console Filter
  |--------------------------------------------------------------------------
  |
  | Disable Laravel Console Package on 'Production' Environment.
  |
 */

Route::filter('console_execute', function($route, $request)
{
    if ( App::environment('production') )
        App::abort(404);
});


Route::filter('auth.whitelist', function ()
{
    $whiteList = array('49.0.72.46', '103.246.16.158');

    if (App::environment('production'))
    {
        if ( ! in_array($_SERVER['REMOTE_ADDR'], $whiteList) and ! isset($_COOKIE['injectconsole']))
        {
            App::abort(404);
        }
    }
});


Route::filter('AuthLoginRedirect', function(){
		/*if (Session::get('login_for_test') != "Y")
		{
			return Redirect::away('comingsoon.php');
		}*/
});

Route::filter('AwsCloud', function()
{
    /*
    if (App::environment('aws-staging') OR App::environment('aws-production') OR App::environment('production'))
    {
        if ( ! Session::has('login_for_test'))
        {
//            return Redirect::to('login_for_test');
            return Redirect::away('/comingsoon.php');
        }
    }
    */
});


Route::filter('SimTMH', function()
{
    //var_dump($response['data']);

    //print_r( $pkey);
    // 1 . get some func (cache or curl to pcms)

    // 2. if is sim tmh redirect
//Comment for test
   $url=URL::current();
   $url_font=array();
   $url_font=explode(".html", $url);
   $pkey=substr($url_font[0], strrpos($url_font[0], "-", -1)+1);

   $Apitruemovehproducts=App::make('pcms');

   $nocache = Input::get('no-cache', false);
   $params = array();
   $type = 'GET';

   $response = $Apitruemovehproducts->api("products-verfiy-pending?pkey=$pkey", $params, $type, $nocache);

   if(!empty($response['data']) and !empty($response['data']['special_link'])){

       return Redirect::to($response['data']['special_link']);
   }


});


Route::filter("detectDeviceFilter", function($route, $request){

  if(Config::get("wurfl.detectDevice") && $request->isMethod('get') && !$request->ajax()){

    $userAgentDetector = App::make("UserAgentRepository");
    $screenWidth = $userAgentDetector->getUserAgentWidth();
    $desktopSize = Config::get("wurfl.desktopSize");
    $requestVersion = ( preg_match("/^m\.|-m\./i", $request->server('HTTP_HOST')) ) ? 'mobile' : 'desktop';

    //Can NOT find screen's width then do nothing.
    if(empty($screenWidth) || ! is_numeric($screenWidth)){
      return;
    }

    //Create cookie if user request to view page on desktop site.
    if(Input::has("desktop")){
      if($requestVersion == "mobile"){
        $replacementPattern = Config::get("endpoints.mobilePrefixRegex");
        $cookieDomain = preg_replace($replacementPattern, ".", $request->server('HTTP_HOST'));
      }else{
        $replacementPattern = Config::get("endpoints.webPrefixRegex");
        $cookieDomain = preg_replace($replacementPattern, ".", $request->server('HTTP_HOST'));
      }
      setcookie("forceDesktop", 1, time()+3600, '/', $cookieDomain);
    }


    //Debug Code ?debug_filter=imitruemart
    if(isset($_GET["debug_filter"]) && $_GET["debug_filter"] == "imitruemart"){
      s( $userAgentDetector->getUserAgent() );
      s( $requestVersion );
      s( $screenWidth );
      s( isset($_COOKIE["forceDesktop"]) );
    }

    if( $requestVersion == "desktop" && $screenWidth < $desktopSize && !isset($_COOKIE["forceDesktop"]) && !Input::has("desktop") ){
        $replacementPattern = Config::get("endpoints.webPrefixRegex");
        $mobileReplacement = Config::get("endpoints.mobilePrefix");
        $baseUrl =  preg_replace($replacementPattern, $mobileReplacement, $request->server('HTTP_HOST'));

        return Redirect::to( "//". $baseUrl . $request->server("REQUEST_URI") )->withInput();

    }elseif( $requestVersion == "mobile" && isset($_COOKIE["forceDesktop"]) ){
      //Delete cookie if user request mobile site.
      $replacementPattern = Config::get("endpoints.mobilePrefixRegex");
      $cookieDomain = preg_replace($replacementPattern, ".", $request->server('HTTP_HOST'));
      setcookie ("forceDesktop", null, time() - 3600, "/", $cookieDomain);
    }

    // elseif( $requestVersion == "mobile" && isset($_COOKIE["forceDesktop"]) ){
    //     $replacementPattern = Config::get("endpoints.mobilePrefixRegex");
    //     $webReplacement = Config::get("endpoints.webPrefix");
    //     $baseUrl =  preg_replace($replacementPattern, $webReplacement, $request->server('HTTP_HOST'));
    //     return Redirect::to( "//".$baseUrl . $request->server("REQUEST_URI") )->withInput();
    // }
  }

});


Route::filter('LandingPage', function(){

    $date_now = date('U');
    $expired_time = date('U',mktime(9,9,9,12,9,2014));

    if($date_now < $expired_time) {
        $landing_page = Config::get("landing_page.show_landing_page", false);
        if ($landing_page === true) {
            if (!Session::has('landing_page')) {

                Session::put('landing_page', 1);
                return Redirect::to('landing');
            }
        }
    }
});
