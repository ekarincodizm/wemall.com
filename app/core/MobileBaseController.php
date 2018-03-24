<?php
class MobileBaseController extends Controller {


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



    public function __construct()
    {
        $this->theme = Theme::uses('mobile');

        // default title
        $this->theme->setTitle('iTrueMart');

        // Kuae Debug;
        //$this->theme = Theme::uses('itruemart-mobile');

        // Localize.
        //$this->locale = App::getLocale();
        if ( ! defined("LANG"))
        {
            define("LANG", App::getLocale());
        }

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
        $this->theme->asset()->container('footer')->script('delay-bind', 'assets/vendor/jquery.bindWithDelay.js');
        $this->theme->asset()->container('footer')->script('text-blink', 'assets/js/jquery.textBlink.js');
        $this->theme->asset()->container('footer')->add("auto-suggest", "assets/js/auto-suggest.js", array('_underscorejs'));
        $this->googleAnalytic();
        /** [E] load javascript language file */

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

    public function link_to_action()
    {
        $query = Input::all();
        $url_query = '';
        if (count($query) > 0)
        {
            $url_query = '?' . http_build_query($query, '', '&amp;');
        }

        return $url_query;
    }

}