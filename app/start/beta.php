<?php

if (\Config::get('app.debug') and isset($_GET['no-cache']))
{
    Log::getMonoLog()->pushHandler(new Monolog\Handler\BrowserConsoleHandler);

    Event::listen('api.request.*', function($method, $url, $args, $info)
    {
        // $apiLog = new ApiLog;

        // $apiLog->method = $method;
        // $apiLog->url    = $url;
        // $apiLog->args   = $args;
        // $apiLog->info   = $info;

        // $apiLog->save();

        Log::info(Event::firing(), func_get_args());
    });
}
