<?php

$configApp = array(

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => true,

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => array(

        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        'Illuminate\Cache\CacheServiceProvider',
        'Illuminate\Session\CommandsServiceProvider',
        'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
        'Illuminate\Routing\ControllerServiceProvider',
        'Illuminate\Cookie\CookieServiceProvider',
        'Illuminate\Database\DatabaseServiceProvider',
        'Illuminate\Encryption\EncryptionServiceProvider',
        'Illuminate\Filesystem\FilesystemServiceProvider',
        'Illuminate\Hashing\HashServiceProvider',
        'Illuminate\Html\HtmlServiceProvider',
        'Illuminate\Log\LogServiceProvider',
        'Illuminate\Mail\MailServiceProvider',
        'Illuminate\Database\MigrationServiceProvider',
        'Illuminate\Pagination\PaginationServiceProvider',
        'Illuminate\Queue\QueueServiceProvider',
        'Illuminate\Redis\RedisServiceProvider',
        'Illuminate\Remote\RemoteServiceProvider',
        'Illuminate\Auth\Reminders\ReminderServiceProvider',
        'Illuminate\Database\SeedServiceProvider',
        'Illuminate\Session\SessionServiceProvider',
        'Illuminate\Translation\TranslationServiceProvider',
        'Illuminate\Validation\ValidationServiceProvider',
        'Illuminate\View\ViewServiceProvider',
        'Illuminate\Workbench\WorkbenchServiceProvider',

        'Teepluss\Theme\ThemeServiceProvider',
        'Teepluss\Api\ApiServiceProvider',

        'Enhance\EnhanceServiceProvider',
        'Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider',

        // Extend translation
        'Extend\Translation\TranslationServiceProvider',

        // Laravel 4 User Agent
        'Jenssegers\Agent\AgentServiceProvider',

        'Acl\AclServiceProvider'
    ),
);


if (isset($_COOKIE['injectconsole']))
{
    // Debugger bar
    $configApp['providers'][] = 'Barryvdh\Debugbar\ServiceProvider';

    $configApp['providers'][] = 'Darsain\Console\ConsoleServiceProvider';
    $configApp['providers'][] = 'Sebklaus\Profiler\Providers\ProfilerServiceProvider';
    $configApp['providers'][] = 'Kmd\Logviewer\LogviewerServiceProvider';
}

return $configApp;