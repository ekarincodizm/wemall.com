<?php

class SuperdealBaseController extends BaseController
{

    /**
     * Language locale.
     *
     * @var string
     */
    public $locale;

    /**
     * iTruemart API client.
     *
     * @var object
     */
    public $itruemartClient;

    /**
     * PCMS API client.
     *
     * @var object
     */
    public $PcmsClient;

    /**
     * Theme
     *
     * @var \Teepluss\Theme
     */
    public $theme;
    public $platform;

    /**
     * checkout data.
     */
    private $checkoutData;

    /**
     * Front base construct.
     *
     * Preparing global data to use around the application
     * this can be re-using.
     *
     */
    public function __construct()
    {

        // Detect platform by subdomain.
        $this->platform = ( preg_match("/^m\.|-m\./i", Request::server('HTTP_HOST')) ) ? 'mobile' : 'desktop' ;

        $this->theme = Theme::uses('super-deal');

        // default title
        $this->theme->setTitle('iTrueMart');

        if ( !defined("LANG") )
        {
            define("LANG", App::getLocale());
        }

        /** [S] load javascript language file */
        $ln = Lang::getLocale();
        $this->theme->asset()->script('locale-js', 'assets/vendor/locale-js/lang/' . $ln . '.js');
        $this->theme->asset()->script('i18n-js', 'assets/vendor/locale-js/i18n.js', array('locale-js'));
        $js = <<<JS
            var LANG = '$ln';
            locale.init('th');
            locale.add('$ln', i18n_$ln);
            locale.to('$ln');
            __ = locale.__;
JS;
        $this->theme->asset()->writeScript('ln', $js, array('locale-js', 'i18n-js'));
//        $this->theme->asset()->container('footer')->writeContent('picreel', '<script src="//assets.pcrl.co/js/jstracker.min.js"></script>', array());
        $this->theme->asset()->container('footer')->script('delay-bind', 'assets/vendor/jquery.bindWithDelay.js');
        $this->theme->asset()->container('footer')->script('auto-suggest', 'assets/js/auto-suggest.js');
        /** [E] load javascript language file */
        /**
         * load underscore.js if not exist. that use in cartLightbox.
         */

        /** [S] load ga marketing tag */
        $this->googleAnalytic();
        /** [E] load ga marketing tag */

        /** [S] Sending information to partial and widget. (Neng) */
        $this->setupPartialInfo();
        /** [E] Sending information to partial and widget. */
    }

    private function googleAnalytic()
    {
        if ( App::environment('production') || App::environment('beta')  || App::environment("alpha"))
        {
            /*
                $this->theme->asset()->container()->writeContent('FB-Remarketing', '
                    <!-- Facebook Remarketing -->
                    <!-- iTruemart -->
                    <script>(function() {
                        var _fbq = window._fbq || (window._fbq = []);
                        if (!_fbq.loaded) {
                            var fbds = document.createElement("script");
                            fbds.async = true;
                            fbds.src = "//connect.facebook.net/en_US/fbds.js";
                            var s = document.getElementsByTagName("script")[0];
                            s.parentNode.insertBefore(fbds, s);
                            _fbq.loaded = true;
                        }
                        _fbq.push(["addPixelId", "504530252986243"]);
                        })();
                        window._fbq = window._fbq || [];
                        window._fbq.push(["track", "PixelInitialized", {}]);
                    </script>
                    <noscript><img height="1" width="1" border="0" alt="" style="display:none" src="https://www.facebook.com/tr?id=504530252986243&amp;ev=NoScript" /></noscript>

                    <!-- Facebook Re-Marketing -->
                    <!-- TypeIdea Facebook Agency -->
                    <script>
                        (function() {
                            var _fbq = window._fbq || (window._fbq = []);
                            if (!_fbq.loaded) {
                                var fbds = document.createElement("script");
                                fbds.async = true;
                                fbds.src = "//connect.facebook.net/en_US/fbds.js";
                                var s = document.getElementsByTagName("script")[0];
                                s.parentNode.insertBefore(fbds, s);
                                _fbq.loaded = true;
                            }
                            _fbq.push(["addPixelId", "1505048066389707"]);
                        })();
                        window._fbq = window._fbq || [];
                        window._fbq.push(["track", "PixelInitialized", {}]);
                    </script>
                    <noscript><img height="1" width="1" border="0" alt="" style="display:none" src="https://www.facebook.com/tr?id=1505048066389707&amp;ev=NoScript" /></noscript>

               ', array());
           */

            if ( Request::segment(2) != 'thank-you' )
            {
                $this->theme->asset()->container('footer')->writeContent('Google-Tag-Manager', '
                    <!-- Google Tag Manager -->
                        <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-PNLTZQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
                        <script>
                            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({"gtm.start":
                            new Date().getTime(),event:"gtm.js"});var f=d.getElementsByTagName(s)[0],
                            j=d.createElement(s),dl=l!="dataLayer"?"&l="+l:"";j.async=true;j.src=
                            "//www.googletagmanager.com/gtm.js?id="+i+dl;f.parentNode.insertBefore(j,f);
                            })(window,document,"script","dataLayer","GTM-PNLTZQ");
                        </script>
                    <!-- End Google Tag Manager -->
				', array());
            }
        }
    }

    protected function isMobile()
    {
        return $this->platform == 'mobile';
    }

    protected function setupPartialInfo()
    {
        //$checkoutData = $this->checkoutData;

        /** [S] send checkout data to cartlightbox */
        Theme::partialComposer('cartLightbox', function($view_partial)
                {
                    $view_partial->with('checkout', array());
                    $view_partial->with('showShippingMethod', false);
                    $view_partial->with("showCloseBtn", true);
                    $view_partial->with("nextBtnOperation", "GoCheckout");
                    $view_partial->with("forceShowRemoveBtn", true);
                });
        /** [E] send checkout data to cartlightbox */
    }

    protected function showHighlightBanner(){
        Theme::partialComposer('homeBanner', function($view)
        {
            $view->with('showHighLight', true);
        });

    }

}