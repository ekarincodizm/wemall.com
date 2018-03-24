<?php

abstract class FrontBaseController extends BaseController {

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
        $this->platform = ( preg_match("/^(m|m2|m-(a|b|b1|b2))\.|-m\./i", Request::server('HTTP_HOST')) ) ? 'mobile' : 'desktop' ;

        // Theme preparing.
        if ($this->platform == 'mobile')
        {
            #$this->theme = Theme::uses('itruemart-mobile');
			$this->theme = Theme::uses('itruemart');
        }
        else
        {
            $this->theme = Theme::uses('itruemart');
        }

        // default title
        $this->theme->setTitle('iTrueMart');

        // Localize.
        if ( ! defined("LANG"))
        {
            define("LANG", App::getLocale());
        }

        // The code below has been moved to "app/config/packages/teepluss/theme/config.php".
        /*
        // PCMS
        $this->PcmsClient = App::make('pcms');

        // iTrumart Client.
        $this->itruemartClient = App::make('itruemart');


        $that = $this;

        // Data passing to navbar.
        $this->theme->partialComposer('navbar', function($view) use ($that)
        {
            // navbar horizontal
            $typos = Config::get('typos');
            $navbar = $typos['navbar'][$that->locale];
            $view->with('navbar', $navbar);

            // navbar verical menu
            $brands = Config::get('brands');
            $shop_by_band = $brands[$that->locale];
            $view->with('shop_by_band', $shop_by_band);

            // vertical menu
            $response = $that->PcmsClient->getVertical();
            $view->with('vertical', $response);
        });

        // Data passing to footer.
        $this->theme->partialComposer('footer', function($view) use ($that)
        {
            $response = (array) $that->itruemartClient->getSeoEssay('levelA')->getResponse();

            $view->with('footer_seo_essay', array_get($response, 'data.seo'));

            $footerResponse = (array) $that->itruemartClient->getSeoFooter()->getResponse();
            $footerResponse = array_get($footerResponse, 'data');

            if (is_array($footerResponse) && count($footerResponse))
            {
                sort($footerResponse);
            }

            $view->with('footer_seo_link', $footerResponse);

            // Footer link product type
            $type_products = Config::get('typos.footer_link.type_products');
            $view->with('type_products', $type_products[$that->locale]);

            $promotions = Config::get('typos.footer_link.promotions');
            $view->with('promotions', $promotions[$that->locale]);

            $services = Config::get('typos.footer_link.services');
            $view->with('services', $services[$that->locale]);

            // Socials
            $socials = Config::get('socials');
            $view->with('footer_socials', $socials);

            // payments channel
            $payments = Config::get('typos.payments');
            $view->with('payments', $payments[$that->locale]);

            // ecommerce tracking
            if (Request::segment(2) == 'thank-you')
            {
                $user = ACL::getUser();
                $params['order_id'] = Input::get('order_id');
                $params['customer_ref_id'] = $user['user_id'];
                $params['customer_type']   = ACL::isLoggedIn() ? 'user' : 'non-user';
                $params['sso_id']          = $user['ssoId'];
                $response = $that->PcmsClient->api('payment/item', $params);
                $view->with('order', $response);
            }
        });
        */


        /** [S] load javascript language file */
        $ln = Lang::getLocale();
        $this->theme->asset()->script('locale-js', 'assets/vendor/locale-js/lang/'.$ln.'.js');
        $this->theme->asset()->script('i18n-js', 'assets/vendor/locale-js/i18n.js', array('locale-js'));
        $js = <<<JS
            var LANG = '$ln';
            locale.init('th');
            locale.add('$ln', i18n_$ln);
            locale.to('$ln');
            __ = locale.__;
JS;
        $this->theme->asset()->writeScript('ln', $js, array('locale-js','i18n-js'));
//        $this->theme->asset()->container('footer')->writeContent('picreel', '<script src="//assets.pcrl.co/js/jstracker.min.js"></script>', array());
        $this->theme->asset()->container('footer')->usePath()->add('js-underscore-min', 'js/underscore-min.js');
        $this->theme->asset()->container('footer')->script('delay-bind', 'assets/vendor/jquery.bindWithDelay.js');
        $this->theme->asset()->container('footer')->script('auto-suggest', 'assets/js/auto-suggest.js');
        $this->theme->asset()->container('footer')->script('text-blink', 'assets/js/jquery.textBlink.js');
        /** [E] load javascript language file */

        /**
         * load underscore.js if not exist. that use in cartLightbox.
         */
        $this->googleAnalytic();

        /** [S] Sending information to partial and widget. (Neng)*/
        $this->setupPartialInfo();
        /** [E] Sending information to partial and widget. */
    }

	private function googleAnalytic()
	{
            if(App::environment('production') || App::environment('typeidea') || App::environment("alpha") || App::environment("aws-staging") || App::environment("aws-alpha"))
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

                $this->theme->asset()->container("footer")->writeContent("TrueHit_tag", '<iframe src="'. url_no_protocal("/truehit.php?pagename=".Request::server("PATH_INFO"), array(),'NO-LANG') .'" height="0" width="0" style="display:none;visibility:hidden"></iframe>');
            }
	}

    protected function isMobile()
    {
        return $this->platform == 'mobile' ;
    }

    protected function setupPartialInfo(){
        /** [S] send checkout data to cartlightbox */
        Theme::partialComposer('cartLightbox',function($view_partial) {
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