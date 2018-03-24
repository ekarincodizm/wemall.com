<?php

$paths = array(

	/*
	|--------------------------------------------------------------------------
	| Application Path
	|--------------------------------------------------------------------------
	|
	| Here we just defined the path to the application directory. Most likely
	| you will never need to change this value as the default setup should
	| work perfectly fine for the vast majority of all our applications.
	|
	*/

	'app' => __DIR__.'/../app',

	/*
	|--------------------------------------------------------------------------
	| Public Path
	|--------------------------------------------------------------------------
	|
	| The public path contains the assets for your web application, such as
	| your JavaScript and CSS files, and also contains the primary entry
	| point for web requests into these applications from the outside.
	|
	*/

	'public' => __DIR__.'/../public',

	/*
	|--------------------------------------------------------------------------
	| Base Path
	|--------------------------------------------------------------------------
	|
	| The base path is the root of the Laravel installation. Most likely you
	| will not need to change this value. But, if for some wild reason it
	| is necessary you will do so here, just proceed with some caution.
	|
	*/

	'base' => __DIR__.'/..',

	/*
	|--------------------------------------------------------------------------
	| Storage Path
	|--------------------------------------------------------------------------
	|
	| The storage path is used by Laravel to store cached Blade views, logs
	| and other pieces of information. You may modify the path here when
	| you want to change the location of this directory for your apps.
	|
	*/

	'storage' => __DIR__.'/../app/storage/local',

);
//var_dump($app->)
switch ($app->environment())
{
	case 'alpha'      : $paths['storage'] = '/data/product/itruemart/2014/apps/storage'; break;
	case 'beta'		  :
    //case 'staging' : $paths['storage'] = '/data/projects/itruemart/Cd/Cached/itruemart/app/storage'; break;
    case 'production' :
    case 'aws-staging' :
    case 'aws-alpha' :
        $paths['storage'] = __DIR__.'/../app/storage/nfs';
        break;
    default :
        $paths['storage'] = __DIR__.'/../app/storage/local';
        break;
}
return $paths;