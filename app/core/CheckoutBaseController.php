<?php

abstract class CheckoutBaseController extends BaseController
{

    /**
     * Language locale.
     *
     * @var string
     */
    public $locale;

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
    protected $theme;
    protected $platform;
    protected $cart;
    protected $checkout;
    protected $useNewMThemeRegex = "/checkout\/(step2|step3|thank-you)/i";

    /**
     * Checkout base controller
     *
     * Preparing global data to use around the application
     * this can be re-using.
     *
     */
    public function __construct()
    {
        // Detect platform by subdomain.
        $this->platform = ( preg_match("/^(m|m2|m-(a|b|b1|b2))\.|-m\./i", Request::server('HTTP_HOST')) || isset($_COOKIE['force_mobile'])) ? 'mobile' : 'desktop' ;

        // Theme preparing.
        if ($this->platform == 'mobile') {
            if( preg_match( $this->useNewMThemeRegex, Request::path()) ){
                $this->theme = Theme::uses('checkout-mobile-2014');
            }else{
                $this->theme = Theme::uses('checkout-mobile');
            }
        } else {
            $this->theme = Theme::uses('checkout');
        }
        if (!defined("LANG")) {
            define("LANG", App::getLocale());
        }

        /**
         * get cart data (Note. you can use either $cart or $checkout. They are the same data.)
         */
        $this->PcmsClient = App::make('pcms');

        /**
         * get checkout data.
         */
        $response = array();
        $response['data'] = array();


        //[POST] checkout/step2 no need to do.
        if( $this->isRequiredCheckout() ){
            $response = $this->PcmsClient->getCheckoutV2();
            if (!empty($response['status']) && $response['status'] != 'success') {
                $response['data'] = array();
            }
            $this->checkout = isset($response['data']) ? $response['data'] : array();
        }

        /**
         * Add language to js.
         */
        $ln = Lang::getLocale();
        $this->theme->asset()->container('footer')->script('locale-js', 'assets/vendor/locale-js/lang/' . $ln . '.js?q=201410161430');
        $this->theme->asset()->container('footer')->script('i18n-js', 'assets/vendor/locale-js/i18n.js', array('locale-js'));
        $this->theme->asset()->container('footer')->script('delay-bind', 'assets/vendor/jquery.bindWithDelay.js');
        $this->theme->asset()->container('footer')->script('auto-suggest', 'assets/js/auto-suggest.js');
        $this->theme->asset()->container('footer')->script('text-blink', 'assets/js/jquery.textBlink.js');
        $js = <<<JS
            var LANG = '$ln';
            locale.init('th');
            locale.add('$ln', i18n_$ln);
            locale.to('$ln');
            __ = locale.__;
JS;
        $this->theme->asset()->container('footer')->writeScript('ln', $js, array('locale-js', 'i18n-js'));

        if (isset($_GET['debug']) && $_GET['debug'] == "imitruemart") {
            alert(ACL::getUser());
            alert($this->checkout);
            die();
        }

        $this->checkLogin();
        $this->googleAnalytic();
        //--- Detect checkout step for navigation ---//
        self::detectStep($this->checkout);

    }

	private function googleAnalytic()
	{
		if(App::environment('production') || App::environment('beta') || App::environment("alpha") || App::environment("aws-alpha"))
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

    private function checkLogin()
    {
        $dependencies = array();

        $user = ACL::getUser();

        if ($user['group'] == "user") {

            $this->theme->asset()->container('footer')->writeScript('inline-script', '
                $(document).ready(function(){
                    $.getJSON(
                        "//login.truelife.com/checkCentralizeCookies.php?jsoncallback=?"   ,
                        function(data){
                            console.log(JSON.stringify(data));
                            //console.log("JSON.stringify(data) = " + JSON.stringify(data));
                            if (data.jsonReturn != undefined)
                            {
                                if (data.jsonReturn.uid != "" && data.jsonReturn.uid != undefined)
                                {

                                    $.post(
                                        "/ajax/member/check-sso",
                                        {
                                            accessToken: data.jsonReturn.access_token
                                        },
                                        function(callback){
                                            $(".on-profile").html(callback);
                                        },
                                        "html"
                                    );


                                }
                            }   //   Check jsonReturn
                        }
                    );
                });


            ', $dependencies);
        }
    }

    private static function detectStep($checkoutData)
    {

        $requestUri = Request::server('REQUEST_URI');
        if (preg_match("/step1/", $requestUri)) {
            Theme::partialComposer('header', function ($view_partial)
                    {
                        $view_partial->with('step', 'step');
                    });

            /** [S] send checkout data to minicart */
            Theme::partialComposer('minicart', function($view_partial) use($checkoutData)
                    {
                        $view_partial->with('checkout', $checkoutData);
                        $view_partial->with('showShippingMethod', false);
                        $view_partial->with('showDiscount', true);
                        $view_partial->with('showCoupon', false);
                        $view_partial->with('isTUAvailablePage', false);
                    });
            /** [E] send checkout data to minicart */
            /** [S] send checkout data to cartlightbox */
            Theme::partialComposer('cartLightbox', function($view_partial) use($checkoutData)
                    {
                        $view_partial->with('checkout', array());
                        $view_partial->with('showShippingMethod', false);
                        $view_partial->with('editShippingMethod', false);
                        $view_partial->with('showImage', true);
                    });
            /** [E] send checkout data to cartlightbox */
            /** [S] Send cart data to mimiaddress. */
            Theme::partialComposer('miniaddress', function($view_partial) use($checkoutData)
                    {
                        $view_partial->with('checkout', $checkoutData);
                        $view_partial->with('show', false);
                    });
            /** [E] Send cart data to mimiaddress. */
        } elseif (preg_match("/step2/", $requestUri)) {
            Theme::partialComposer('header', function ($view_partial)
                    {
                        $view_partial->with('step', 'step-2');
                    });

            /** [S] send checkout data to minicart */
            Theme::partialComposer('minicart', function($view_partial) use($checkoutData)
                    {
                        $view_partial->with('checkout', $checkoutData);
                        $view_partial->with('showShippingMethod', true);
                        $view_partial->with('showDiscount', true);
                        $view_partial->with('showCoupon', false);
                        $view_partial->with('isTUAvailablePage', false);
                    });
            /** [E] send checkout data to minicart */
            /** [S] send checkout data to cartlightbox */
            Theme::partialComposer('cartLightbox', function($view_partial) use($checkoutData)
                    {
                        $view_partial->with('checkout', array());
                        $view_partial->with('showShippingMethod', false);
                        $view_partial->with('editShippingMethod', false);
                    });
            /** [E] send checkout data to cartlightbox */
            /** [S] Send cart data to mimiaddress. */
            Theme::partialComposer('miniaddress', function($view_partial) use($checkoutData)
                    {
                        $view_partial->with('checkout', $checkoutData);
                        $view_partial->with('show', false);
                    });
            /** [E] Send cart data to mimiaddress. */
        } elseif (preg_match("/step3/", $requestUri)) {
            Theme::partialComposer('header', function ($view_partial)
                    {
                        $view_partial->with('step', 'step-3');
                    });

            /** [S] send checkout data to minicart */
            Theme::partialComposer('minicart', function($view_partial) use($checkoutData)
                    {
                        $view_partial->with('checkout', $checkoutData);
                        $view_partial->with('showShippingMethod', true);
                        $view_partial->with('showDiscount', true);
                        $view_partial->with('showCoupon', true);
                        $view_partial->with('isTUAvailablePage', true);
                    });
            /** [E] send checkout data to minicart */
            /** [S] send checkout data to cartlightbox */
            Theme::partialComposer('cartLightbox', function($view_partial) use($checkoutData)
                    {
                        $view_partial->with('checkout', array());
                        $view_partial->with('showShippingMethod', true);
                        $view_partial->with('editShippingMethod', true);
                        $view_partial->with('showImage', true);
                    });
            /** [E] send checkout data to cartlightbox */
            /** [S] Send cart data to mimiaddress. */
            Theme::partialComposer('miniaddress', function($view_partial) use($checkoutData)
                    {
                        $view_partial->with('checkout', $checkoutData);
                        $view_partial->with('show', true);
                    });
            /** [E] Send cart data to mimiaddress. */
        } elseif (preg_match("/thank-you/", $requestUri)) {
            Theme::partialComposer('header', function ($view_partial)
                    {
                        $view_partial->with('step', 'step-4');
                    });
        }
		elseif(preg_match("/no-item/", $requestUri))
		{
			/** [S] send checkout data to minicart */
            Theme::partialComposer('minicart', function($view_partial) use($checkoutData)
                    {
                        $view_partial->with('checkout', array());
                        $view_partial->with('showShippingMethod', true);
                        $view_partial->with('showDiscount', true);
                        $view_partial->with('showCoupon', false);
                        $view_partial->with('isTUAvailablePage', false);
                    });
            /** [E] send checkout data to minicart */
		}
    }

    protected function isMobile()
    {
        return $this->platform == 'mobile';
    }

    /**
     * To check that current url need to use checkout data.
     * return boolean
     */
    private function isRequiredCheckout(){
        $isPostStep2 = (preg_match("/(checkout\/step1)/i", Request::path()) && Request::isMethod('post'));
        $isThankyou = (preg_match("/(checkout\/thank-you)/i", Request::path()));
        return ( ! $isPostStep2 && ! $isThankyou );
    }

}