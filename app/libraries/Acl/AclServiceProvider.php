<?php namespace Acl;

use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function register()
    {
        $this->app['acl'] = $this->app->share(function($app)
        {
            return new ACL;
        });
    }
}