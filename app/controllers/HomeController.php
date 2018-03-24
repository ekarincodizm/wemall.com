<?php

class HomeController extends FrontBaseController
{

    private $cache_time = 7;
    protected $showroomRepo;
    private $_showroomPerPage = 1;
    private $_showroomPage = 1;

    public function __construct(ShowroomRepositoryInterface $showroomRepo)
    {
        parent::__construct();
        $no_cache = Input::get('no-cache', false);
        $this->noCache = !empty($no_cache);

        if (Input::has('set-cache-exp'))
        {
            $cache_exp_at = Input::get('set-cache-exp');
            $cache_exp_at = preg_replace('/hr/', '', $cache_exp_at);
            if((int) $cache_exp_at < 6 && (int) $cache_exp_at >0)
            {
                $this->cache_time = ((int)$cache_exp_at) * 60;
                $this->noCache = true;
            }
        }
        $this->showroomRepo = $showroomRepo;
    }

    public function getIndex()
    {
        // START Criteo tag
        $this->theme->append('criteo_tag', criteoTagHome());
        // END Criteo tag

        //show HighlightBanner.
        parent::showHighlightBanner();

        $this->theme->asset()->container('footer')->usePath()->add('waypoint', 'js/lib/jquery.waypoints.min.js');
        $this->theme->asset()->container('footer')->usePath()->add("lazy-content", "js/lazy-content.js", array());
        $this->theme->setTitle(__('seo_title_home'));
        $this->theme->setMetadescription(__('seo_description_home'));
        $this->theme->setMetakeywords(__('seo_keyword_home'));
        $this->theme->partialComposer('meta_og', function ($view)
        {
            $view->with('meta_title', __('seo_title_home'));
            $view->with('meta_image',
                'http://'.Request::server ("SERVER_NAME").'/themes/itruemart/assets/images/meta-og/logo-itruemart.jpg');
            $view->with('meta_url', 'http://'.Request::server ("SERVER_NAME"));
            $view->with('meta_description', __('seo_description_home'));
            $view->with('meta_type', 'website');
        });

        // create cache key for home page
        $cache_key = Request::url() . Request::path() . Lang::locale() . "_homepage";

        // check cache result
        if ($this->noCache === false)
        {
            $cache_response = ElastiCache::getResult($cache_key, null);

            if (!empty($cache_response['page']))
            {
                if (Input::has('chk-page-exp'))
                {
                    echo 'Page will Expired at :' . ($cache_response['expired_at']);
                }

                //d($cache_response['expired_at']);
                return $cache_response['page'];
            }
        }

        $data = array(
            'noCache' => $this->noCache,
        );

        // render first and second showroom by php
        $result = $this->showroomRepo->getData($this->_showroomPage, $this->_showroomPerPage);
        $totalShowroom = $this->showroomRepo->getTotalPage();
        $data["totalShowroom"] = $totalShowroom;

        // Home Page Expired and showroom expired ar
        $expired_at = mktime(date('H'), date('i') + $this->cache_time, date('s'));

        $data['page_exp'] = $this->cache_time;
        // $data["showroom"] = array_get($result, 'data.showroom', array());
        $content['page'] = $this->theme->scope('home.index', $data)->render()->getContent();
        $content['expired_at'] = date('Y-m-d H:i:s', $expired_at);

        //Delete all showroom's caches.
        if ($this->noCache === true)
        {
            $this->showroomRepo->deleteAllShowroomCache();
        }

        ElastiCache::save($cache_key, $content, null, $this->cache_time);
        if (Input::has('chk-page-exp'))
        {
            echo "Page will Expired at :" . $content['expired_at'];
        }

        return $content['page'];
    }

    /**
     * getShowroom get show room data as AJAX
     * @return JSON
     */
    public function getShowroom()
    {
        if (Input::has('pe'))
        {
            $this->cache_time = (int)Input::get('pe');
        }

        $attribute['noCache'] = $this->noCache;
        $attribute['page'] = (int)Input::get('page', 1);
        if ($attribute['page'] <= 0)
        {
            $attribute['page'] = 1;
        }

        // create cache key
        $cache_key = $this->showroomRepo->getShowroomCacheKey($attribute['page']) . '-' . $this->cache_time;

        // check cache
        if ($this->noCache === false)
        {
            $cache_response = ElastiCache::getResult($cache_key, null);

            if (!empty($cache_response))
            {
                return Response::json($cache_response, 200);
            }
        } else
        {
            $attribute['no-cache'] = 1;
        }

        // get showroom data
        $showroom = Theme::widget("homeShowroom", $attribute);

        $response['status'] = 'success';
        $response['page'] = $showroom->getAttribute('page');
        $response['data'] = $showroom->run();
        $expired_at = mktime(date('H'), date('i') + $this->cache_time, date('s'));
        $response['expired_at'] = date('Y-m-d H:i:s', $expired_at);

        ElastiCache::save($cache_key, $response, null, $this->cache_time);

        return Response::json($response, 200);
    }

}
