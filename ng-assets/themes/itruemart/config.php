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
            // Set title.
            $theme->setTitle('iTrueMart');

            // Breadcrumb template.
            // $theme->breadcrumb()->setTemplate('
            //     @foreach ($crumbs as $i => $crumb)
            //         &gt; <a class="map" href="{{ $crumb["url"] }}">{{ $crumb["label"] }}</a>
            //     @endforeach
            // ');
            $theme->breadcrumb()->setTemplate('
                @foreach ($crumbs as $i => $crumb)
                    <li><a href="{{ $crumb["url"] }}">{{ $crumb["label"] }}</a>
                    </li>
                @endforeach
            ');
        },

        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function($theme)
        {
            $ln = Lang::getLocale();

            $theme->asset()->container('footer')->script('locale-js', 'assets/vendor/locale-js/lang/'.$ln.'.js');
            $theme->asset()->container('footer')->script('i18n-js', 'assets/vendor/locale-js/i18n.js', 'locale-js');
            $theme->asset()->container('footer')->script('execute', 'assets/js/execute.js', 'i18n-js');

            $js = <<<JS
                var LANG = '$ln';
                locale.init('th');
                locale.add('$ln', i18n_$ln);
                locale.to('$ln');
                __ = locale.__;
JS;
            $theme->asset()->container('footer')->writeScript('ln', $js, array('locale-js','i18n-js'));

            // $theme->asset()->writeScript('sessionphp', '
            //     var currentSession = "'.md5(Session::getId()).'";

            //     var currentLoggedIn = '.(ACL::isLoggedIn() ? "true" : "false").';
            // ');

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
                        $theme->setMetadescription($escapeAttribute($description).' | iTruemart.com');
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
                $theme->asset()->usePath()->add('nprogress', 'css/nprogress.css');
                $theme->asset()->container('footer')->usePath()->add('nprogress', 'js/nprogress.js', array('js-jquery'));
                $theme->asset()->container('footer')->usePath()->add('nprogress-handler', 'js/nprogress-handler.js', array('js-jquery', 'nprogress'));
            },

            'blank' => function($theme)
            {
                $theme->asset()->usePath()->add('nprogress', 'css/nprogress.css');
                $theme->asset()->container('footer')->usePath()->add('nprogress', 'js/nprogress.js', array('js-jquery'));
                $theme->asset()->container('footer')->usePath()->add('nprogress-handler', 'js/nprogress-handler.js', array('js-jquery', 'nprogress'));
            }

        )

    )

);