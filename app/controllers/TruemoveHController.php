<?php

class TruemoveHController extends FrontBaseController
{
    const BEST_MATCH = "best_match";
    const EN = "en";
    private $pcms;
    private $cache_time = 2;
    private $noCache;
    private $lang;
    private $mobile = false;
    public $banner;

    public function __construct(BannerRepositoryInterface $banner)
    {
        parent::__construct();

        // /* Mobile checking */
        // dd($this->mobileSiteChecking(Request::url()));
        // // $url_match = $this->mobileSiteChecking(Request::url())

        // /* Setup parameter */
        // if($url_match){
        //     $no_cache = Input::get('no-cache', false);
        //     $this->noCache = !empty($no_cache);
        //     $this->banner = $banner;
        //     $this->mobile = true;
        //     // $this->theme->layout('truemoveh-template');
        //     $this->theme->layout('angular-template');
        // }else{
            $this->mobile = false;
            $this->theme->layout('angular-template');
        // }

        $this->pcms = App::make('pcms');
        $no_cache = Input::get('no-cache', false);
        $this->noCache = !empty($no_cache);
        $this->lang = Lang::getLocale();

        $criteo_script = '<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>';
        $this->theme->append('criteo_tag', $criteo_script);
    }

    private function mobileSiteChecking($url_current)
    {
        dd('wtf');
        $url_current = Request::url();
        $url_check = explode('://', $url_current);
        $url = count($url_check) > 1 ? $url_check[1] : $url_current;
        preg_match("/^m\.|-m\./i", $url, $url_match);
        return $url_match;
    }

    private function getFilters()
    {
    }

    private function cleanParameter($keyword)
    {
        $keyword = trim($keyword);
        $keyword = strip_tags(urldecode($keyword));

        return $keyword;
    }

    private function validateParameters($filters)
    {
    }

    // *********************************************************************************
    //  PAGES
    // *********************************************************************************
    public function getIndex()
    {
        if($this->mobile)
        {
            // $banner_position_id = "2";
            // $banners = $this->banner->getByPosition($banner_position_id);
            // $viewData = compact('banners');
            // $meta_title = __('seo_title_home');
            // $this->theme->setTitle($meta_title);
            // $this->theme->setMetadescription(__('seo_description_home').' | iTrueMart.com' );
            // $this->theme->setMetakeywords(__('seo_keyword_home'));
            // $this->theme->setCanonical('http://www.itruemart.com'.Request::path());

            // $this->theme->asset()->container('footer')->add("_underscorejs", "assets/vendor/underscore-min.js", array());
            // $this->theme->asset()->container('footer')->add('waypoint', 'themes/itruemart/assets/js/lib/jquery.waypoints.min.js',array());
            // $this->theme->asset()->container('footer')->add("lazy-content", "themes/itruemart/assets/js/lazy-content.js", array());
            // $this->theme->asset()->container('footer')->add("jquery-lazyload", "themes/itruemart/assets/js/lib/jquery.lazyload.min.js", array());
            // $this->theme->asset()->container('footer')->usePath()->add('countdowm', 'js/jquery.countdown.min.js', array('jquery'));
            // $this->theme->asset()->container('footer')->add('jquery-getQueryString', 'assets/js/jquery.getQueryString.js', array('jquery'));
            // $this->theme->asset()->container('footer')->usePath()->add('showroom', 'js/showroom.js', array('jquery', 'custom'));
            // $this->theme->partialComposer('meta_og', function($view)
            // {
            //     $view->with('meta_title', __('seo_title_home'));
            //     $view->with('meta_image', 'http://m.itruemart.com/themes/itruemart/assets/images/meta-og/logo-itruemart.jpg');
            //     $view->with('meta_url', 'http://m.itruemart.com');
            //     $view->with('meta_description', __('seo_description_home'));
            //     $view->with('meta_type', 'mobile');
            // });

            // // START Criteo tag
            // $this->theme->append('criteo_tag', criteoTagHomeMobile());
            // // END Criteo tag

        }

        setSeoMeta('truemove-h');
        $filters = $this->getFilters();

        $keyword = array_get($filters, "q", "");
        if (is_html($keyword)) {
            App::abort(404);
        }

        // $filters['q'] = $this->cleanParameter(array_get($filters, "q", ""));
        // $uniqueCacheKey = http_build_query($filters);
        // $cachedKey = $this->getCacheKey($uniqueCacheKey);

        // if ($this->noCache === false) {
        //     $cachedResponse = ElastiCache::getResult($cachedKey, null);

        //     if (!empty($cachedResponse)) {

        //         return $cachedResponse;
        //     }

        // }

        /* Setup Meta and SEO Tag */
        $this->theme->setTitle("เบอร์เทพ | iTruemart.com" . $filters['q']);
        $this->theme->setMetadescription(__('seo_description_home'));
        $this->theme->setMetakeywords(__('seo_keyword_home'));

        /* Rendered site */
        $view['mobile'] = $this->mobile;
        // if ($this->mobile) {
            // $content = $this->theme->scope('truemove-h.landing-mobile', $view)->render();
        // } else {
            $content = $this->theme->scope('truemove-h.landing', $view)->render();
        // }

        /* Elastic content caching data */
        // ElastiCache::save($cachedKey, $content, null, $this->cache_time);

        /* View return */
        return $content;
    }

    public function getForecasts()
    {
        setSeoMeta('search');
        $filters = $this->getFilters();

        $keyword = array_get($filters, "q", "");
        if (is_html($keyword)) {
            App::abort(404);
        }

        $filters['q'] = $this->cleanParameter(array_get($filters, "q", ""));
        $uniqueCacheKey = http_build_query($filters);
        $cachedKey = $this->getCacheKey($uniqueCacheKey);

        if ($this->noCache === false) {
            $cachedResponse = ElastiCache::getResult($cachedKey, null);

            if (!empty($cachedResponse)) {

                return $cachedResponse;
            }

        }

        $this->theme->setTitle("เบอร์เทพ | iTruemart.com" . $filters['q']);
        $this->theme->setMetadescription(__('seo_description_home'));
        $this->theme->setMetakeywords(__('seo_keyword_home'));

        $view['mobile'] = $this->mobile;

        // if ($this->mobile) {
        //     $content = $this->theme->scope('truemove-h.forecasts-mobile')->render();
        // } else {
            $content = $this->theme->scope('truemove-h.forecasts')->render();
        // }

        ElastiCache::save($cachedKey, $content, null, $this->cache_time);

        return $content;
    }

    public function getRegister()
    {
        setSeoMeta('search');
        $filters = $this->getFilters();

        $keyword = array_get($filters, "q", "");
        if (is_html($keyword)) {
            App::abort(404);
        }

        $filters['q'] = $this->cleanParameter(array_get($filters, "q", ""));
        $uniqueCacheKey = http_build_query($filters);
        $cachedKey = $this->getCacheKey($uniqueCacheKey);

        if ($this->noCache === false) {
            $cachedResponse = ElastiCache::getResult($cachedKey, null);

            if (!empty($cachedResponse)) {

                return $cachedResponse;
            }

        }

        $this->theme->setTitle("เบอร์เทพ | iTruemart.com" . $filters['q']);
        $this->theme->setMetadescription(__('seo_description_home'));
        $this->theme->setMetakeywords(__('seo_keyword_home'));

        $view['mobile'] = $this->mobile;

        // if ($this->mobile) {
        //     $content = $this->theme->scope('truemove-h.registration-mobile')->render();
        // } else {
            $content = $this->theme->scope('truemove-h.registration')->render();
        // }

        ElastiCache::save($cachedKey, $content, null, $this->cache_time);

        return $content;
    }

    // *********************************************************************************
    //  API
    // *********************************************************************************
    public function getCheckIdCard()
    {

        $response = $this->pcms->api('truemoveh-id-card/check-id-card', Input::all(), 'get');

        return $response;
    }

    public function getHoro()
    {
        $response = $this->pcms->api('truemoveh-horos', Input::all(), 'get');

        return $response;
    }

    public function getPromotion()
    {

        $response = $this->pcms->api('truemoveh/promotion',  Input::all(), 'get');

        return $response;
    }

    /**
     * แสดงรายชื่อจังหวัดที่ผูกกับโซนทั้งหมด
     * @return [type] [description]
     */
    public function getZoneMapAllProvinceInZone()
    {

        $response = $this->pcms->api('truemoveh-zone-maps/all-province-in-zone',  Input::all(), 'get');

        return $response;
    }

    public function getAddressProvince()
    {

        $response = $this->pcms->api('truemoveh/address/province',  Input::all(), 'get');

        return $response;
    }

    public function getMobilePatterns()
    {

        $response = $this->pcms->api('truemoveh-mobile-pattherns',  Input::all(), 'get');

        return $response;
    }

    public function getAllMobile()
    {

        $response = $this->pcms->api('truemoveh/mobile/all-mobile', Input::all(), 'get');

        return $response;
    }

    public function getPromotionByMobile()
    {

        $response = $this->pcms->api('truemoveh/mobile/promotion-by-mobile', Input::all(), 'get');

        return $response;
    }

    public function getAddressDistrict()
    {

        $response = $this->pcms->api('truemoveh/address/district', Input::all(), 'get');

        return $response;
    }

    public function getAddressSubDistrict()
    {

        $response = $this->pcms->api('truemoveh/address/sub-district', Input::all(), 'get');

        return $response;
    }

    public function getAddressPostcode()
    {

        $response = $this->pcms->api('truemoveh/address/postcode', Input::all(), 'get');

        return $response;
    }

    public function getZoneByProvince()
    {

        $response = $this->pcms->api('truemoveh-zone-maps/zone-by-province', Input::all(), 'get');

        return $response;
    }

    public function getZoneMapAllProvinceInPhone()
    {

        $response = $this->pcms->api('truemoveh-zone-maps/all-province-in-phone', Input::all(), 'get');

        return $response;
    }

    public function getDeviceAllDevice()
    {

        $response = $this->pcms->api('truemoveh-device/all-device', Input::all(), 'get');

        return $response;
    }

    public function getDeviceSubDevice()
    {

        $response = $this->pcms->api('truemoveh-device/sub-device', Input::all(), 'get');

        return $response;
    }

    public function getPolicy()
    {

        $response = $this->pcms->api('truemoveh/t-and-c', Input::all(), 'get');

        return $response;
    }

    public function postUploadFileUpload()
    {
        $idcard = Input::get('idcard');

        $config = Config::get('endpoints');

        $file = Input::file('file');

        $cfile = '';

        if (Input::hasFile('file')) {
            if(class_exists('CurlFile', false)){
                $cfile = new CURLFile($file->getRealPath(), $file->getMimeType(), $file->getClientOriginalName());
            }else{
                $cfile = "@".$file->getRealPath();
            }
        }

        $post = array(
            'idcard' => $idcard,
            'file'=>$cfile,
            'mimeType'         => $file->getClientMimeType(),
            'fileType'         => $file->getClientOriginalExtension(),
            'fileOriginalName' => $file->getClientOriginalName(),
        );

        $url = $config['pcms']['url'].'/'.$config['pcms']['appKey'].'/truemoveh/uploadfile/upload';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_exec($ch);
    }

    public function postRegisterInfoSave()
    {
        $datas = Input::all();

        $response = $this->pcms->api('truemoveh/registerinfo/save', $datas, 'post');

        return $response;
    }


    public function postVerifyRecaptcha()
    {
        $secret = "6Ldw6wgTAAAAAPKPOzyQ5S2QpPq1x3Cs92Ku5moV";
        $remoteIp = $_SERVER["REMOTE_ADDR"];
        $datas = Input::all();
        $gRecaptchaResponse = $datas['recaptcha_response_field'];

        // $recaptcha = new \ReCaptcha\ReCaptcha($secret);
        // $resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp);

        // if ($resp->isSuccess()) {
        //     // verified!
        //     $ret = array('status'=> 200, 'validate_status'=> 'success');
        //     return json_encode($ret);
        // } else {
        //     $errors = $resp->getErrorCodes();
        //     $data = array(
        //         'status'          => 200,
        //         'validate_status' => 'fail',
        //         'message'         => $errors
        //     );
        //     return json_encode($data);
        // }

        $google_url="https://www.google.com/recaptcha/api/siteverify";
        $url=$google_url."?secret=".$secret."&response=".$gRecaptchaResponse."&remoteip=".$remoteIp;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
        $results = curl_exec($curl);
        curl_close($curl);

        $res= json_decode($results, true);
        if($res['success'])
        {
            $ret = array('status'=> 200, 'validate_status'=> 'success');
            return json_encode($ret);
        }
        else
        {
            $ret = array(
                'status'          => 200,
                'validate_status' => 'fail',
                'message'         => $res["error-codes"]
            );
            return json_encode($ret);
        }
    }

    public function getBanner()
    {
        $banner = App::make('BannerRepositoryInterface');
        $response = $banner->getByPosition(Input::all());

        return $response;
    }

    // *********************************************************************************
    // HELPER
    // *********************************************************************************
    /**
     * @todo move to helper function
     * @param $key = $q
     * @return string
     */
    public function getCacheKey($key = ""){
        $cacheKey = array(
            Request::server("SERVER_NAME"),
            Request::server("PATH_INFO"),
            Request::server("REQUEST_METHOD"),
            "solrsearch_cachekey_unique",
            Lang::locale(),
            $key
        );
        return  implode('_', $cacheKey);
    }
}

