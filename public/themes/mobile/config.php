<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    |
    | Set up inherit from another if the file is not exists,
    | this is work with "layouts", "partials", "views" and "widgets"
    |
    | [Notice] assets cannot inherit.
    |
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these event can be override by package config.
    |
    */

    'events' => array(

        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb template or anything
        // you want inheriting.
        'before' => function($theme)
        {
            // You can remove this line anytime.
            $theme->setTitle('Copyright ©  2015 - iTruemart.ph');

            // Breadcrumb template.
            // $theme->breadcrumb()->setTemplate('
            //     <ul class="breadcrumb">
            //     @foreach ($crumbs as $i => $crumb)
            //         @if ($i != (count($crumbs) - 1))
            //         <li><a href="{{ $crumb["url"] }}">{{ $crumb["label"] }}</a><span class="divider">/</span></li>
            //         @else
            //         <li class="active">{{ $crumb["label"] }}</li>
            //         @endif
            //     @endforeach
            //     </ul>
            // ');
        },

        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function($theme)
        {
            #$theme->asset()->usePath()->add('bootstrap-css', 'css/bootstrap.min.css');
            #$theme->asset()->usePath()->add('style-css', 'css/style.css');
            #$theme->asset()->usePath()->add('custom-css', 'css/custom.css');
            $theme->partialComposer('header', function($view)
            {
                $view->with('showCartIcon', Route::getCurrentRoute()->getName() == 'cart.index');
            });

## SEO
            ## SEO
            $route = Route::getCurrentRoute();

            $contentPkey = null;

            if ( ! is_null($route))
            {
                $contentPkey = $route->getParameter('collectionPkey')
                        ?: $route->getParameter('brandPkey')
                        ?: $route->getParameter('productPkey')
                        ?: null;
            }


            if ($contentPkey )
            {
                if(App::getLocale() == 'en')
                    {
                        $lang = 'en';
                    }
                    else{
                        $lang = 'th';
                    }

                $params = array('pkey' => $contentPkey,'lang' => $lang);
                
                $response = App::make('pcms')->api("seo", $params, 'GET');
                
                if (! empty($response['data']))
                {
                    switch ($contentPkey)
                    {
                        case $route->getParameter('collectionPkey'):
                            $pkeyType = 'collection';
                            break;

                        case $route->getParameter('brandPkey'):
                            $pkeyType = 'brand';
                            break;

                        case $route->getParameter('productPkey'):
                            $pkeyType = 'product';
                            break;
                    }

                    $compileSeo = function(Array $data, $template = null)
                    {
                         
                        if (empty($template))
                        {
                            return '';
                        }

                        if (is_callable($template))
                        {
                            return $template($data);
                        }
                        elseif (is_string($template))
                        {
                            return preg_replace_callback('/:([a-z0-9]+)/', function($bind) use ($data)
                                {
                                    return isset($data[$bind[1]]) ? $data[$bind[1]] : $bind[0];
                                }
                                , $template);
                        }

                        return '';
                    };

                    $escapeAttribute = function($string)
                    {
                        return addcslashes($string, '"');
                    };
                    
                    $title = $compileSeo($response['data'], Config::get("seo.${pkeyType}.${lang}.title"));
                    
                    if ($title)
                    {
                        $theme->setTitle($title);
                    }

                    $description = $compileSeo($response['data'], Config::get("seo.{$pkeyType}.${lang}.description"));

                    if ($description)
                    {
                        $theme->setMetadescription($escapeAttribute($description).' | iTruemart.ph');
                    }

                    $keywords = $compileSeo($response['data'], Config::get("seo.{$pkeyType}.${lang}.keywords"));
                    if ($keywords)
                    {
                        $theme->setMetakeywords($escapeAttribute($keywords));
                    }
                }
            }
        },

        // Listen on event before render a layout,
        // this should call to assign style, script for a layout.
        'beforeRenderLayout' => array(

            'default' => function($theme)
            {
                // $theme->asset()->usePath()->add('ipad', 'css/layouts/ipad.css');


            }

        )

    )

);