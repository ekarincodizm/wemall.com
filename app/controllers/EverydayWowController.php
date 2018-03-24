<?php

class EverydayWowController extends FrontBaseController
{
    /**
     * @var int
     */
    private $cache_time = 2;

    /**
     * @var bool
     */
    private $is_debug = false;

    /**
     * @var boolean
     */
    private $noCache;

    /**
     * @var string
     */
    protected $lang;

    /**
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $limit;


    /**
     * @var string { asc, desc }
     */
    protected $order;

    /**
     * @var string { discount_start, price, discount }
     */
    protected $orderby;

    /**
     * @var string
     */
    protected $category_slug;

    /**
     * @var EverydaywowRepository
     */
    protected $everydayWowRepository;

    /**
     * @param EverydaywowRepositoryInterface $everydayWowRepository
     */
    public function __construct(EverydaywowRepositoryInterface $everydayWowRepository)
    {
        parent::__construct();

        // defined variable
        $this->lang = Lang::locale();
        $this->page = (int) Input::get('page', 1);
        $this->sortby = Input::get('sortby', 'published_at');
        $this->orderby = Input::get('orderby', 'desc');
        $this->response = Input::get('response', '');
        $this->limit = (int) Input::get('limit',6);
        $this->everydayWowRepository = $everydayWowRepository;

        $no_cache = Input::get('no-cache',false);
        $this->noCache = !empty($no_cache);

        $this->is_debug = Input::has('debug-cache');
    }

    /**
     * if request is not ajax
     * then
     *  - render html
     *  - everyday wow top
     *  - category list
     *  - banner top
     *  - everyday wow list (page = 1)
     *  - banner bottom
     * else
     *  - everyday wow list (page = :page)
     *
     * @param string $category_slug
     * @return \Illuminate\Http\JsonResponse
     * @return mixed
     */
    public function getIndex($category_slug = null)
    {
        $this->category_slug = !empty($category_slug) ? $category_slug : 'all';

        $options['lang'] = $this->lang;
        $options['filter'] = $this->category_slug;
        $options['sortby'] = $this->sortby;
        $options['orderby'] = $this->orderby;
        $options['response'] = $this->response;
        $options['page'] = $this->page;
        $options['limit'] = $this->limit;

        $cache_arr = $options;
        $cache_arr['isAjax'] = $this->isAjax();
        $cache_arr['isMobile'] = $this->isMobile();

        $cache_key = "wowViewCache_".http_build_query($cache_arr);

        if($this->noCache === false){
            $cache_response = ElastiCache::getResult($cache_key,null);
            if(!empty($cache_response)){
                if($this->is_debug){
                    echo 'cache';
                }
                return $cache_response;
            }
        }

        $response = $this->everydayWowRepository->getData($options);

        if ($this->isAjax()) {
            $content =  Response::json($response, 200);
        }
        else {
            $redirectPage = false;
            $product_data = array_get($response, 'data.product_data', false);

            if(empty($product_data)){
                if(!empty($category_slug)){
                    $redirectPage = true;
                }
            }

            if($redirectPage == true){
                $re_url = 'everyday-wow';
                $lang = App::getLocale();
                return Redirect::to($lang.'/'.$re_url);
            }

            // defined variable to use in view
            $view_data['category_slug'] = $this->category_slug;
            $view_data['category'] = array_get($response, 'data.category_data', array());
            $view_data['products'] = array_get($response, 'data.product_data', array());
            $view_data['pagination'] = array_get($response, 'data.page_data', array());
            $view_data['params'] = array_get($response, 'data.params',array('sortby'=>'published_at','orderby'=>'desc'));

            $content = $this->renderHtmlTemplate($view_data);
        }

        ElastiCache::save($cache_key, $content, null, $this->cache_time);

        if ($this->is_debug) {
            echo 'no cache';
        }

        return $content;
    }

    /**
     * @param $view_data
     * @return mixed
     */
    protected function renderHtmlTemplate($view_data)
    {
        // jquery.waypoint -- use to detect scroll direction, scroll to position
        // and check is scroll already scrolled to specific DOM element
        $this->theme->asset()->container('footer')->usePath()->add('waypoint', 'js/lib/jquery.waypoints.min.js');

        // mobile must load before.
        if ($this->isMobile()) {
            $this->theme->asset()->container('footer')->usePath()->add('lazyload', 'js/lib/jquery.lazyload.min.js');
        }

        // module to use on lazy load content
        $this->theme->asset()->container('footer')->usePath()->add("lazy-content", "js/lazy-content.js", array());
        $this->theme->asset()->container('footer')->usePath()->add("everyday-wow", "js/everyday-wow.js", array());

        if ($this->isMobile()) {
            $this->theme = Theme::uses('mobile');

            /** required by mobile */
            $this->theme->asset()->usePath()->add("superdeal-product", "css/mobile-everyday-wow_edit.css",array());
            $this->theme->asset()->usePath()->add("swipe-styles", "css/idangerous.swiper.css",array());

            $this->theme->asset()->container('footer')->usePath()->add("countdown", "js/jquery.countdown.min.js", array());
            $this->theme->asset()->container('footer')->usePath()->add("swiper", "js/idangerous.swiper-2.1.min.js", array());
            $this->theme->asset()->container('footer')->usePath()->add("superdeal", "js/superdeal.js", array());
        } else {
            $this->theme->layout('everyday-wow');
            $this->theme->asset()->usePath()->add("everyday-wow", "css/everyday-wow.css",array());
            $this->theme->asset()->usePath()->add("everyday-wow-edit", "css/everyday-wow_edit.css",array());
        }

        $this->theme->setTitle(__('seo_title_wow'));
        $this->theme->setMetadescription(__('seo_description_wow'));
        $this->theme->setMetakeywords(__('seo_keyword_wow'));
        $this->theme->partialComposer('meta_og', function($view) {
            $view->with('meta_title', __('seo_title_wow'));
            $view->with('meta_image', 'http://'.Request::server ("SERVER_NAME").'/themes/itruemart/assets/images/meta-og/everydaywow-24-oct-2014.jpg');
            $view->with('meta_url', 'http://'.Request::server ("SERVER_NAME").'/everyday-wow');
            $view->with('meta_description', __('seo_description_wow'));
            $view->with('meta_type', 'website');
        });

        return $this->theme->scope('everyday-wow/index', $view_data)->render();
    }

    /**
     * @return bool
     */
    protected function isAjax()
    {
        return Request::ajax() || Input::get('force-ajax', false);
    }
}