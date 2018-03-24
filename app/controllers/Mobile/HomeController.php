<?php namespace Mobile;

use Illuminate\Support\Facades\Response;
use Request;
use Input;
use MobileBaseController;
use BannerRepositoryInterface;
use CampaignRepositoryInterface;
use ElastiCache;
use Illuminate\Support\Facades\Lang;
use Url;
use CachePage;
use ShowroomRepositoryInterface;

class HomeController extends MobileBaseController {

    private $cache_time = 7;
    public $banner;
    public $campaign;
    protected $showroomRepo;
    private $_showroomPerPage = 1;
    private $_showroomPage = 1;

    public function __construct(BannerRepositoryInterface $banner, ShowroomRepositoryInterface $showroomRepo)
    {
        parent::__construct();

        $no_cache = Input::get('no-cache', false);

        $this->noCache = !empty($no_cache);

        if(Input::has('set-cache-exp'))
        {
            $cache_exp_at = Input::get('set-cache-exp');
            $cache_exp_at = preg_replace('/hr/','',$cache_exp_at);
            $this->cache_time = ((int) $cache_exp_at) * 60;
            $this->noCache = TRUE;
        }

        $this->banner = $banner;
        $this->showroomRepo = $showroomRepo;
    }

	public function getIndex()
	{

		$banner_position_id = "2";
        $banners = $this->banner->getByPosition($banner_position_id);
        $viewData = compact('banners');
        $meta_title = __('seo_title_home');
        $this->theme->setTitle($meta_title);
        $this->theme->setMetadescription(__('seo_description_home').' | iTrueMart.ph' );
        $this->theme->setMetakeywords(__('seo_keyword_home'));
        $this->theme->setCanonical('http://'.Request::server ("SERVER_NAME").Request::path());

        $this->theme->asset()->container('footer')->add("_underscorejs", "assets/vendor/underscore-min.js", array());
        $this->theme->asset()->container('footer')->add('waypoint', 'themes/itruemart/assets/js/lib/jquery.waypoints.min.js',array());
        $this->theme->asset()->container('footer')->add("lazy-content", "themes/itruemart/assets/js/lazy-content.js", array());
        $this->theme->asset()->container('footer')->add("jquery-lazyload", "themes/itruemart/assets/js/lib/jquery.lazyload.min.js", array());
        $this->theme->asset()->container('footer')->usePath()->add('countdowm', 'js/jquery.countdown.min.js', array('jquery'));
        $this->theme->asset()->container('footer')->add('jquery-getQueryString', 'assets/js/jquery.getQueryString.js', array('jquery'));
        $this->theme->asset()->container('footer')->usePath()->add('showroom', 'js/showroom.js', array('jquery', 'custom'));
        $this->theme->partialComposer('meta_og', function($view)
        {
            $view->with('meta_title', __('seo_title_home'));
            $view->with('meta_image', 'http://m.itruemart.com/themes/itruemart/assets/images/meta-og/logo-itruemart.jpg');
            $view->with('meta_url', 'http://m.itruemart.ph');
            $view->with('meta_description', __('seo_description_home'));
            $view->with('meta_type', 'mobile');
        });

        // START Criteo tag
        $this->theme->append('criteo_tag', criteoTagHomeMobile());
        // END Criteo tag

        // create cache key for home page
        $cache_key = Request::url() . Request::path() . Lang::locale() . "_homepage";
        // check cache result
        if ($this->noCache===false) {
            $cache_response = ElastiCache::getResult($cache_key, null);

            if (!empty($cache_response['page']))
            {
                if(Input::has('chk-page-exp'))
                {
                    echo 'Page will Expired at :'.($cache_response['expired_at']);
                }
                //d($cache_response['expired_at']);
                return $cache_response['page'];
            }
        }

        //Delete all showroom's caches.
        if($this->noCache === true){
            $this->showroomRepo->deleteAllShowroomCache();
        }


        $this->showroomRepo->getData($this->_showroomPage, $this->_showroomPerPage);
        $totalShowroom = $this->showroomRepo->getTotalPage();
        $viewData["totalShowroom"] = $totalShowroom;

        $expired_at = mktime(date('H'),date('i')+$this->cache_time,date('s'));

        $viewData['page_exp'] = $this->cache_time;
        $content['page'] = $this->theme->scope('home.index', $viewData)->render()->getContent();
        $content['expired_at']=date('Y-m-d H:i:s',$expired_at);


        ElastiCache::save($cache_key, $content, null, $this->cache_time);

        if(Input::has('chk-page-exp'))
        {
            echo "Page will Expired at :".$content['expired_at'];
        }
        return $content['page'];
    }

    /**
     * getHomeAjax
     * return HTML on page 1
     * return JSON on AJAX
     *
     * @return HTML/JSON
     */
    public function getHomeAjax()
    {
        /**
         * pe = page expired in minis
         */
        if(Input::has('pe'))
        {
            $this->cache_time = (int) Input::get('pe');
        }

        // input
        $page = Input::get('page', 1);
        $nocache = Input::get('no-cache');

        // defined
        $response = array();
        $ckey = $this->showroomRepo->getShowroomCacheKey($page).'-'.$this->cache_time;

        // check cache
        if ( ! $nocache ) {
            $response = ElastiCache::getResult($ckey, NULL);
            if (!empty($response)) {
                return $response;
            }
        }

        $attrs = array(
            'page' => $page,
            'limit' => $this->_showroomPerPage,
            'no-cache' => $nocache,
        );

        $view = $this->theme->widget("homeShowroom", $attrs);

        $response['status'] = "success";
        $response['page'] = $view->getAttribute('page');
        $response['data'] = $view->render();
        $expired_at = mktime(date('H'),date('i')+$this->cache_time,date('s'));
        $response['expired_at']=date('Y-m-d H:i:s',$expired_at);

        ElastiCache::save($ckey, $response, null, 7);

        // JSON ja
        return Response::json($response, 200);
    }
}
