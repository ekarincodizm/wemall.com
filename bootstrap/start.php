<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application;

/*
|--------------------------------------------------------------------------
| Detect The Application Environment
|--------------------------------------------------------------------------
|
| Laravel takes a dead simple approach to your application environments
| so you can just specify a machine name for the host that matches a
| given environment, then we will automatically detect it for you.
|
*/

$env = $app->detectEnvironment(function()
{
    $environments = array(
        /* Local Develop */
        'local'          => array('*.loc', '*.dev'),

        /* Local  Vendors typeidea */
        'typeidea'       => array('www.typeidea.itruemart.loc','m.typeidea.itruemart.loc'),

        /* Alpha MTG (Old Alpha) */
        'alpha'          => array('alpha.itruemart.ph', 'm.alpha.itruemart.ph', '*.alpha.itruemart.ph', '10.98.34.25', '192.168.225.11'),

        /* AWS Alpha */
        'aws-alpha'      => array('alpha-www.itruemart-dev.ph','alpha-m.itruemart-dev.ph','alpha-www.itruemart-dev.com.ph','alpha-m.itruemart-dev.com.ph'),

        /* AWS Staging */
        'aws-staging'    => array('www.itruemart-dev.ph', 'itruemart-dev.ph', 'm.itruemart-dev.ph','www.itruemart-dev.com.ph','itruemart-dev.com.ph','m.itruemart-dev.com.ph'),

        /* AWS Production */
        'production'     => array('www.itruemart.ph', 'itruemart.ph', 'm.itruemart.ph','www.itruemart.com.ph', 'itruemart.com.ph','m.itruemart.com.ph'),

    );

    $domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;

    $hostname = gethostname();

    foreach ($environments as $environment => $hosts)
    {
        // To determine the current environment, we'll simply iterate through the possible
        // environments and look for the host that matches the host for this request we
        // are currently processing here, then return back these environment's names.
        foreach ((array) $hosts as $host)
        {
            if (str_is($host, $domain) || ($host == $hostname)) return $environment;
        }
    }

    return 'testing';
});

/*
|--------------------------------------------------------------------------
| Bind Paths
|--------------------------------------------------------------------------
|
| Here we are binding the paths configured in paths.php to the app. You
| should not be changing these here. If you need to change these you
| may do so within the paths.php file and they will be bound here.
|
*/

$app->bindInstallPaths(require __DIR__.'/paths.php');

/*
|--------------------------------------------------------------------------
| Load The Application
|--------------------------------------------------------------------------
|
| Here we will load this Illuminate application. We will keep this in a
| separate location so we can isolate the creation of an application
| from the actual running of the application with a given request.
|
*/

$framework = $app['path.base'].'/vendor/laravel/framework/src';

require $framework.'/Illuminate/Foundation/start.php';

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
