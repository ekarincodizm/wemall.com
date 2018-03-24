<?php

class BrandsController extends FrontBaseController {

    protected $brand, $collection;
    private $cache_time = 60;
    private $noCache = false;

    public function __construct(BrandRepositoryInterface $brand, CollectionRepositoryInterface $collection)
    {
        parent::__construct();

        $this->brand = $brand;
        $this->collection = $collection;

        // Set title.
        $this->theme->setTitle(__("html-title-itruemart") . " : " . __("html-title-brands-title"));
        $this->theme->breadcrumb()->add(__('shop_by_brand'), URL::toLang('shopbybrand'));

        /**
         * A Params is use for Cache Logic
         */
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
    }

    // Shop By Brand
    public function getIndex()
    {

        $inputParams = Input::except(array("no-cache","set-cache-exp","chk-page-exp"));
        $inputParams = implode("_", $inputParams);
        $ckey =Request::server("SERVER_NAME") . Request::server('PATH_INFO') . 'shopbybrand' . Lang::locale().'_'. $inputParams;

        if ($this->noCache === false)
        {
            if ($response = CachePage::getResult($ckey, null))
            {
                if (!empty($response['page']))
                {
                    if (Input::has('chk-page-exp'))
                    {
                        echo 'Page will Expired at :' . ($response['expired_at']);
                    }

                    //d($cache_response['expired_at']);
                    return $response['page'];
                }
            }
        }

        $depth = 2;
        $rawBrands = $this->brand->getAll();
        $collections = $this->collection->getAll($depth);

        $view['brands'] = $this->brand->rearrange($rawBrands);
        $view['collections'] = $collections;
        $view['currentPkey'] = '';


        $this->theme->set('canonical_url', URL::route('shopbybrand.index'));

/*        $content = $this->theme->scope('brands.index', $view)->render()->getContent();

        CachePage::save($ckey, $content, null, 5);

        return Response::make($content, 200, array('Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate'));*/
        // $content is array that store in cache.
        $expired_at = mktime(date('H'), date('i') + $this->cache_time, date('s'));
        $view['expired_at'] = date('Y-m-d H:i:s', $expired_at);
        $content['page'] =  $this->theme->scope('brands.index', $view)->render()->getContent();
        $content['expired_at'] = date('Y-m-d H:i:s', $expired_at);

        CachePage::save($ckey, $content, null, $this->cache_time);

        if (Input::has('chk-page-exp'))
        {
            echo "Page will Expired at :" . $content['expired_at'];
        }

        return $content['page'];
    }

    public function getCollectionBrands($collectionKey = null)
    {
        if ($collectionKey == null)
        {
            return App::abort('404');
        }


        $inputParams = Input::except(array("no-cache","set-cache-exp","chk-page-exp"));
        $inputParams = implode("_", $inputParams);
        $ckey =Request::server("SERVER_NAME") . Request::server('PATH_INFO') . $inputParams;

        if ($this->noCache === false)
        {
            if ($response = CachePage::getResult($ckey, null))
            {
                if (!empty($response['page']))
                {
                    if (Input::has('chk-page-exp'))
                    {
                        echo 'Page will Expired at :' . ($response['expired_at']);
                    }

                    //d($cache_response['expired_at']);
                    return $response['page'];
                }
            }
        }

        $depth = 2;
        $rawBrands = $this->collection->getBrands($collectionKey);
        $collections = $this->collection->getAll($depth);

        $view['brands'] = $this->brand->rearrange($rawBrands);
        $view['collections'] = $collections;
        $view['currentPkey'] = $collectionKey;

        $collectionRepo = App::make("CollectionRepositoryInterface");
        $collectionDetail = $collectionRepo->getByPkey($collectionKey);

        // $canonicalUrl = URL::route('shopbybrand.collection', $collectionKey);
        $canonicalUrl = get_permalink('shopbybrand/category', $collectionDetail);

        if ( URL::current() != $canonicalUrl)
        {
            return Redirect::to($canonicalUrl, 301);
        }

        $view['collectionDetail'] = $collectionDetail;

        $this->theme->set('canonical_url', $canonicalUrl);
        // $this->theme->breadcrumb()->add(__($collectionDetail['name']), get_permalink('shopbybrand/category', $collectionDetail));

        //return $this->theme->scope('brands.index', $view)->render();

        $expired_at = mktime(date('H'), date('i') + $this->cache_time, date('s'));
        $view['expired_at'] = date('Y-m-d H:i:s', $expired_at);
        $content['page'] =  $this->theme->scope('brands.index', $view)->render();
        $content['expired_at'] = date('Y-m-d H:i:s', $expired_at);

        CachePage::save($ckey, $content, null, $this->cache_time);

        if (Input::has('chk-page-exp'))
        {
            echo "Page will Expired at :" . $content['expired_at'];
        }

        return $content['page'];
    }

}
