<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

    app_path().'/libraries',
    app_path().'/core',
    app_path().'/repositories',
	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',
    app_path().'/exceptions'

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a rotating log file setup which creates a new file each day.
|
*/

$logFile = 'log-'.php_sapi_name().'.txt';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);


/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Illuminate\Session\TokenMismatchException $exception, $code)
{
	return Response::make('Bad Request', 400);
});

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

App::missing(function($exception)
{
    $route = Route::getCurrentRoute();

    // Having existing controller.
    if ( ! is_null($route))
    {
        return Redirect::route('home');
    }
    else
    {
        // This is fucking logic for support TRUE security, I told them this will not work for SEO,
        // but cannot change their decided.
        //return Redirect::route('404');


        $uses = (preg_match("/^m\.|-m\./i", Request::server('HTTP_HOST'))) ? 'itruemart-mobile' : 'itruemart';

        $theme = Theme::uses($uses)->layout('default');

        if ($uses == "itruemart-mobile")
        {
            //return Redirect::to(route('home'), 301);
            $theme->asset()->usePath()->add('css-main', 'css/main.css');
            $theme->asset()->usePath()->add('css-addon', 'css/addon.css');
        }
        return $theme->scope('errors.404')->render(404);
    }
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

/*
|--------------------------------------------------------------------------
| Application Logic Container
|--------------------------------------------------------------------------
|
| All about application logic.
|
*/

require app_path().'/container/start.php';
