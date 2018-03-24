<?php

class ProductsController extends FrontBaseController
{

    /**
     * @var ProductRepository
     */
    protected $product;

    private $cache_ttl = 1; // min
    private $cache_time = 5; // sec
    private $noCache = false;

    public function __construct(ProductRepositoryInterface $product)
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

        $this->product = $product;
    }

    public function getIndex()
    {
    }

    public function remaining($inventoryId)
    {
        $inventoryIds = explode(',', $inventoryId);
        $count = count($inventoryIds);

        if ($count === 1)
        {
            $remaining = $this->product->checkRemaining($inventoryId);

            if ($remaining === false)
            {
                return array(
                    'status' => 500,
                    'stock' => false,
                    'remaining' => -1
                );
            }

            return array(
                'status' => 200,
                'stock' => array_get($remaining, $inventoryId, 0) > 0 ? 'in' : 'out',
            );
        } else
        {
            $remainings = $this->product->checkRemaining($inventoryId);

            $stocks = array();
            foreach ($remainings as $id => $remaining)
            {
                $stocks[$id] = intval($remaining) > 0 ? 'in' : 'out';
            }

            return array(
                'status' => 200,
                'stocks' => $stocks,
            );
        }
    }

    public function getCategoryProducts($pkey = null)
    {
        if (empty($pkey))
        {
            // return Redirect::route('home');
            return App::abort('404');
        }

        $inputParams = Input::except(array("no-cache", "set-cache-exp", "chk-page-exp"));
        $inputParams = implode("_", $inputParams);
        $ckey = Request::url() . Request::path() . Lang::locale() . $pkey . "_" . $inputParams;

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
        // Get Collection Detail.
        $collectionRepo = new CollectionRepository;
        $view['brandLists'] = $collectionRepo->getBrands($pkey);
        $view['collectionDetail'] = $collectionRepo->getByPkey($pkey);

        //        sd($collectionRepo->getByPkey('3441387446408'));

        // Get Canonical URL
        $canonicalUrl = get_permalink('category', $view['collectionDetail']);

        // If Current URL != Canonical URL, Redirect to Canonical URL
        if (URL::current() != $canonicalUrl)
        {
            return Redirect::to($canonicalUrl, 301);
        }

        $params['collectionKey'] = $pkey;
        if (Input::has('brand'))
        {
            $params['brandKey'] = Input::get('brand');
        }

        $data = $this->getProductsList($params);

        $view['type'] = 'categories';
        $view['data'] = $data;

        // Get product pkey and product name for remarketing Feed File for Dynamic Ad
        $embed_pkey = array();
        $embed_name = array();
        if (!empty($data['products']))
        {
            foreach ($data['products'] as $key => $value)
            {
                $embed_pkey[] = array_get($value, 'pkey', "");
                $embed_name[] = array_get($value, 'title', "");
            }
        }

        $view['bestSeller'] = $this->product->getBestSeller($pkey);

        $depth = 3;
        // CollectionRepository has an instance already.
        // $collectionRepo = new CollectionRepository;
        $view['collections'] = $collectionRepo->getAll($depth);
        $view['currentPkey'] = $pkey;

        if (Input::get('debug-collection'))
        {
            alert($view['collections'], 'red', 'collections');
            if (Input::get('die'))
            {
                die;
            }
        }

        if (empty($view['collectionDetail']))
        {
            return App::abort('404');
        }

        // d($view['collectionDetail']); die();

        if (!empty($view['collectionDetail']['parents']))
        {
            foreach ($view['collectionDetail']['parents'] as $key => $parent)
            {
                // $this->theme->breadcrumb()->add(__($parent['name']), URL::toLang('/category/' . $parent['pkey']));
                $ParentCollectName = $parent['name'];
                if (App::getLocale() == 'en')
                {
                    $ParentCollectName = isset($parent['translate']['name']) ? $parent['translate']['name'] : $parent['name'];
                }
                $this->theme->breadcrumb()->add(__($ParentCollectName), get_permalink('category', $parent));

            }
        }
        // $this->theme->breadcrumb()->add(__($view['collectionDetail']['name']), URL::toLang('/category/' . $view['collectionDetail']['pkey']));
        $CollectionName = $view['collectionDetail']['name'];
        $view['data']['collection_name'] = $CollectionName;

        ### For marketing tag ###
        $itma_product_category = $CollectionName;
        $marketing_script = '
            var itma_product_category = "' . $itma_product_category . '";' . '
            var itma_cat_id = "' . $pkey . '";
        ';
        $this->theme->append('marketing_tag', $marketing_script);
        ### End For marketing tag ###

        if (App::getLocale() == 'en')
        {
            $CollectionName = isset($view['collectionDetail']['translate']['name']) ? $view['collectionDetail']['translate']['name'] : $view['collectionDetail']['name'];
        }

        $this->theme->breadcrumb()->add(__($CollectionName), get_permalink('category', $view['collectionDetail']));

        $this->theme->set('canonical_url', $canonicalUrl);

        $this->embedGAMarketingTag($embed_pkey, $embed_name, 0, "category");

        // $content is array that store in cache.
        $expired_at = mktime(date('H'), date('i') + $this->cache_time, date('s'));
        $view['expired_at'] = date('Y-m-d H:i:s', $expired_at);
        $content['page'] = $this->theme->scope('products.level-c', $view)->render()->getContent();
        $content['expired_at'] = date('Y-m-d H:i:s', $expired_at);

        CachePage::save($ckey, $content, null, $this->cache_time);

        if (Input::has('chk-page-exp'))
        {
            echo "Page will Expired at :" . $content['expired_at'];
        }

        return $content['page'];
    }

    public function getBrandProducts($pkey = null)
    {
        if (empty($pkey))
        {
            return Redirect::route('home');
        }

        // $ckey = Route::getCurrentRoute()->getActionName() . Lang::locale() . $pkey;
        // $ckey = URL::full() . Lang::locale() . $pkey;

        $inputParams = Input::except(array("no-cache", "set-cache-exp", "chk-page-exp"));
        $inputParams = implode("_", $inputParams);
        $ckey = URL::full() . Lang::locale() . $pkey . '_' . $inputParams;

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

        // Get Brand Detail.
        $brandRepo = new BrandRepository;
        $view['brandLists'] = $brandRepo->getAll();
        $view['brandDetail'] = $brandRepo->getByPkey($pkey);

        $arrPkeys = array_fetch($view['brandLists'], 'pkey');

        //d($arrPkeys);

        $found_index = array_search($view['brandDetail']['pkey'], $arrPkeys);

        $totalPkey = count($arrPkeys);

        $prevIndex = $found_index != 0 ? $found_index - 1 : $totalPkey - 1;
        $nextIndex = ($totalPkey - $found_index) > 1 ? $found_index + 1 : 0;
        $view['pkeyPrev'] = $arrPkeys[$prevIndex];
        $view['pkeyNext'] = $arrPkeys[$nextIndex];

        // Get Canonical URL.
        $canonicalUrl = get_permalink('brand', $view['brandDetail']);

        // If Current URL != Canonical URL, Redirect to Canonical URL
        if (URL::current() != $canonicalUrl)
        {
            return Redirect::to($canonicalUrl, 301);
        }

        $params['brandKey'] = $pkey;

        $data = $this->getProductsList($params);

        $view['type'] = 'brands';
        $view['data'] = $data;

        // $view['bestSeller'] = $this->product->getBestSeller($pkey);
        $view['bestSeller'] = array();

        // Set title.
        $this->theme->setTitle(__($view['brandDetail']['name']) . ' | ' . __("html-title-itruemart"));
        // $this->theme->breadcrumb()->add(__($view['brandDetail']['name']), URL::current('/brand/' . $view['brandDetail']['pkey']));
        $this->theme->breadcrumb()->add(__("breadcrum-brands-lbl"),
            URL::toLang('shopbybrand'))->add(__($view['brandDetail']['name']),
            get_permalink('brand', $view['brandDetail']));

        $this->theme->set('canonical_url', $canonicalUrl);

        $this->theme->asset()->usePath()->add('jquery-bxslider', 'css/jquery.bxslider.css');
        // $this->theme->asset()->container('footer')->usePath()->add('jquery-bxslider', 'js/jquery.bxslider.js', array('jquery'));

        $view['data']['collection_name'] = !empty($view['brandDetail']['name']) ? $view['brandDetail']['name'] : '';

        ### For marketing tag ###
        $marketing_script = '
            var itma_product_category = "' . $view['brandDetail']['name'] . '";' . '
            var itma_cat_id = "' . $pkey . '";
        ';
        $this->theme->append('marketing_tag', $marketing_script);
        ### End For marketing tag ###

        //CachePage::save($ckey, $content, null, 5);
        //return $content;


        // $content is array that store in cache.
        $expired_at = mktime(date('H'), date('i') + $this->cache_time, date('s'));
        $view['expired_at'] = date('Y-m-d H:i:s', $expired_at);
        $content['page'] = $this->theme->scope('products.level-b', $view)->render()->getContent();
        $content['expired_at'] = date('Y-m-d H:i:s', $expired_at);

        CachePage::save($ckey, $content, null, $this->cache_time);

        if (Input::has('chk-page-exp'))
        {
            echo "Page will Expired at :" . $content['expired_at'];
        }

        return $content['page'];

    }

    public function getFlashsaleProducts($brandOrCategoryPkey = '')
    {
        setSeoMeta('flashsale');

        $currentRouteName = Route::currentRouteName();
        $pkey = $brandOrCategoryPkey;

        $params['campaign'] = 'flash_sale';
        $view['currentPkey'] = '';

        $brandRepo = new BrandRepository;
        $collectionRepo = new CollectionRepository;

        if ($currentRouteName == 'flashsale.productsByBrand' && !empty($pkey))
        {
            $params['brandKey'] = $pkey;

            // get brand detail.
            $brandDetail = $brandRepo->getByPkey($pkey);

            // Get Canonical URL.
            $canonicalUrl = get_permalink('flash-sale/brand', $brandDetail);
        } elseif ($currentRouteName == 'flashsale.productsByCategory' && !empty($pkey))
        {
            $params['collectionKey'] = $pkey;
            $view['currentPkey'] = $pkey;

            // get collection detail.
            $collectionDetail = $collectionRepo->getByPkey($pkey);

            // Get Canonical URL.
            $canonicalUrl = get_permalink('flash-sale/category', $collectionDetail);
        } else
        {
            $canonicalUrl = URL::route('flashsale.products');
        }

        // If Current URL != Canonical URL, Redirect to Canonical URL
        if (URL::current() != $canonicalUrl)
        {
            return Redirect::to($canonicalUrl, 301);
        }

        $data = $this->getProductsList($params);

        $view['type'] = 'flashsale';
        $view['data'] = $data;

        $view['brandLists'] = $brandRepo->getFlashsaleBrands();
        $view['collections'] = $collectionRepo->getFlashsaleCollections();

        $this->theme->breadcrumb()->add(__('flashsale'), URL::current());
        $this->theme->set('canonical_url', $canonicalUrl);

        return $this->theme->scope('products.flashsale', $view)->render();
    }

    public function getItruemartTvProducts($brandOrCategoryPkey = '')
    {
        setSeoMeta('itruemart-tv');

        $currentRouteName = Route::currentRouteName();
        $pkey = $brandOrCategoryPkey;

        $params['campaign'] = 'itruemart_tv';
        $view['currentPkey'] = '';

        $brandRepo = new BrandRepository;
        $collectionRepo = new CollectionRepository;

        if ($currentRouteName == 'itruemart-tv.productsByBrand' && !empty($pkey))
        {
            $params['brandKey'] = $pkey;

            // get brand detail.
            $brandDetail = $brandRepo->getByPkey($pkey);

            // Get Canonical URL.
            $canonicalUrl = get_permalink('itruemart-tv/brand', $brandDetail);
        } elseif ($currentRouteName == 'itruemart-tv.productsByCategory' && !empty($pkey))
        {
            $params['collectionKey'] = $pkey;
            $view['currentPkey'] = $pkey;

            // get collection detail.
            $collectionDetail = $collectionRepo->getByPkey($pkey);

            // Get Canonical URL.
            $canonicalUrl = get_permalink('itruemart-tv/category', $collectionDetail);
        } else
        {
            $canonicalUrl = URL::route('itruemart-tv.products');
        }

        // If Current URL != Canonical URL, Redirect to Canonical URL
        if (URL::current() != $canonicalUrl)
        {
            return Redirect::to($canonicalUrl, 301);
        }

        $data = $this->getProductsList($params);

        $view['type'] = 'itruemart-tv';
        $view['data'] = $data;

        $view['brandLists'] = $brandRepo->getItuemartTvBrands();
        $view['collections'] = $collectionRepo->getItruemartTvCollections();

        $this->theme->breadcrumb()->add(__('itruemart-tv'), URL::current());
        $this->theme->set('canonical_url', $canonicalUrl);

        return $this->theme->scope('products.itruemart-tv', $view)->render();
    }

    public function getDiscountProducts($brandOrCategoryPkey = '')
    {
        setSeoMeta('discount');

        $ckey = URL::full() . Lang::locale() . $brandOrCategoryPkey;

        if ($response = CachePage::getResult($ckey, null))
        {
            return $response;
        }

        $currentRouteName = Route::currentRouteName();
        $pkey = $brandOrCategoryPkey;

        $params['campaign'] = 'discount';
        $view['currentPkey'] = '';

        $brandRepo = new BrandRepository;
        $collectionRepo = new CollectionRepository;

        if ($currentRouteName == 'discount.productsByBrand' && !empty($pkey))
        {
            $params['brandKey'] = $pkey;

            // get brand detail.
            $brandDetail = $brandRepo->getByPkey($pkey);

            // Get Canonical URL.
            $canonicalUrl = get_permalink('discount-products/brand', $brandDetail);
        } elseif ($currentRouteName == 'discount.productsByCategory' && !empty($pkey))
        {
            $params['collectionKey'] = $pkey;
            $view['currentPkey'] = $pkey;

            // get collection detail.
            $collectionDetail = $collectionRepo->getByPkey($pkey);

            // Get Canonical URL.
            $canonicalUrl = get_permalink('discount-products/category', $collectionDetail);
        } else
        {
            $canonicalUrl = URL::route('discount.products');
        }

        // If Current URL != Canonical URL, Redirect to Canonical URL
        if (URL::current() != $canonicalUrl)
        {
            return Redirect::to($canonicalUrl, 301);
        }

        $data = $this->getProductsList($params);

        $view['type'] = 'discount';
        $view['data'] = $data;

        $view['brandLists'] = $brandRepo->getDiscountBrands();
        $view['collections'] = $collectionRepo->getDiscountCollections();

        $this->theme->breadcrumb()->add(__('discount_products'), URL::current());

        $this->theme->set('canonical_url', $canonicalUrl);
        $this->theme->partialComposer('meta_og', function($view) {
            $view->with('meta_title', __('og_title_discount'));
            $view->with('meta_image','http://'.Request::server ("SERVER_NAME").'/themes/itruemart/assets/images/meta-og/logo-itruemart.jpg');
            $view->with('meta_url', 'http://'.Request::server ("SERVER_NAME").'/discount-products');
            $view->with('meta_description', __('og_description_discount'));
            $view->with('meta_type', 'website');
        });
        $content = $this->theme->scope('products.discount', $view)->render()->getContent();

        CachePage::save($ckey, $content, null, 5);

        return $content;
    }

    public function getTrueyouProducts($brandOrCategoryPkey = '')
    {

        setSeoMeta('trueyou');

        // Set title
        // Theme::setTitle('aa');

        $currentRouteName = Route::currentRouteName();
        $pkey = $brandOrCategoryPkey;

        $view['currentPkey'] = '';

        $brandRepo = new BrandRepository;
        $collectionRepo = new CollectionRepository;

        if ($currentRouteName == 'trueyou.productsByBrand' && !empty($pkey))
        {
            $params['brandKey'] = $pkey;

            // get brand detail.
            $brandDetail = $brandRepo->getByPkey($pkey);

            // Get Canonical URL.
            $canonicalUrl = get_permalink('trueyou/brand', $brandDetail);
        } elseif ($currentRouteName == 'trueyou.productsByCategory' && !empty($pkey))
        {
            $params['collectionKey'] = $pkey;
            $view['currentPkey'] = $pkey;

            // get collection detail.
            $collectionDetail = $collectionRepo->getByPkey($pkey);

            // Get Canonical URL.
            $canonicalUrl = get_permalink('trueyou/category', $collectionDetail);
        } else
        {
            $canonicalUrl = URL::route('trueyou.products');
        }

        // If Current URL != Canonical URL, Redirect to Canonical URL
        if (URL::current() != $canonicalUrl)
        {
            return Redirect::to($canonicalUrl, 301);
        }

        $params['trueyou'] = 1;

        $data = $this->getProductsList($params);

        // $view['type'] = 'discount';
        $view['type'] = 'trueyou';
        $view['data'] = $data;

        $view['brandLists'] = $brandRepo->getTrueyouBrands();
        $view['collections'] = $collectionRepo->getTrueyouCollections();

        $this->theme->breadcrumb()->add(__('Trueyou'), URL::current());

        $this->theme->set('canonical_url', $canonicalUrl);

        return $this->theme->scope('products.trueyou', $view)->render();
    }

    private function getProductsList($params = array())
    {
        $params['page'] = Input::get('page', 1);

        if (Input::has('priceMax'))
        {
            $params['priceMax'] = Input::get('priceMax');
        }

        if (Input::has('priceMin'))
        {
            $params['priceMin'] = Input::get('priceMin');
        }

        if (Input::has('orderBy'))
        {
            $params['orderBy'] = Input::get('orderBy');
            $params['order'] = (Input::has('order')) ? Input::get('order') : 'asc';
        } else
        {
            // $params['orderBy'] = 'updated_at';
            $params['orderBy'] = 'published_at';
            $params['order'] = 'desc';
        }

        if (Input::has('per_page'))
        {
            $params['per_page'] = Input::get('per_page');
        }

        $data = $this->product->search($params);

        return $data;
    }

    // level D
    public function getDetail($pkey = null)
    {

        $data = array();

        // should not exists
        if (empty($pkey))
        {
            return App::abort(404);
        }

        $meta = array(
            'browse:level_d'
        );

        $user = ACL::getUser();
        if ( ! Session::has('transaction_id'))
        {
            Session::put('transaction_id', $user['user_id']);
        }
        $log_datas = array(
            'UserIPAddress' => Request::server('HTTP_X_FORWARDED_FOR'),
            'ServerIPAddress' => Request::server('SERVER_ADDR'),
            'UserCookieId' => $user['user_id'],
            'UserId' => $user['user_id'],
            'Email' => $user['email'],
            'ExecutionTime' => date("Y-m-d H:i:s"),
            'Tags' => array(
                'tag:level_d'
            ),
            'EventID' => 'browse_level_d',
            'Meta' => $meta
        );

        $gearmanRepo = App::make('GearmanRepository');
        $gearmanRepo->addQueue($log_datas);


        $ckey = Request::server("SERVER_NAME") . Request::server('PATH_INFO') . Lang::locale() . $pkey ;


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

        // route bind is much better
        $product = $this->product->getByPkey($pkey);

        $canonicalUrl = get_permalink('products', $product);

        if (empty($product))
        {
            return App::abort(404);
        }

        // If Current URL != Canonical URL, Redirect to Canonical URL
        if (URL::current() != $canonicalUrl)
        {
            return Redirect::to($canonicalUrl, 301);
        }

        /// go to everyday-wow, if end campaign ///
//        if (!$this->isInCampaign($product))
//        {
//            return Redirect::to('/everyday-wow?show_msg=1');
//        }

        $data['product'] = $product;

        $data['styleTypeArray'] = array();
        $data['allVariantList'] = array();

        $this->theme->asset()->usePath()->usePath()->add('css-bxslider', 'css/jquery.bxslider.css');
        $this->theme->asset()->container('footer')->usePath()->add('js-underscore-min', 'js/underscore-min.js');
        $this->theme->asset()->container('footer')->usePath()->add('js-backbone-min', 'js/backbone-min.js');
        $this->theme->asset()->container('footer')->usePath()->add('product-level-d', 'js/level-d.js?q=' . time(),
            array('jquery'));
        $this->theme->asset()->container('footer')->usePath()->add('product-level-d-zoom', 'js/jquery.zoom.js',
            array('jquery'));

        if ($this->isMobile())
        {

        } else
        {

            $this->theme->asset()->container('footer')->usePath()->add('product-checkstock',
                'js/product-checkstock.js');
            $this->theme->asset()->container('footer')->add('jquery-jqzoom-core-pack',
                'assets/vendor/jquery.jqzoom-core-pack.js', array('jquery'));
            $this->theme->asset()->container('footer')->add('jquery-360', 'themes/itruemart/assets/js/360degree.js',
                array('jquery'));

        }

        /* Breadcrumb ...... very very very hard code = =;  */
        $parentsCollection = array();

        $collectionRepo = new CollectionRepository;

        foreach ($product['collections'] as $val)
        {
            if (array_get($val, 'is_category', 1) != 1)
            {
                continue;
            }

            $collection = $collectionRepo->getByPkey($val['pkey']);

            $current_parents = array_get($collection, 'parents', array());
            if (count($parentsCollection) < count($current_parents))
            {
                $parentsCollection = $collection['parents'];
                $parentsCollection[] = $collection;
            }
        }

        $itma_category_arr = array();

        if (!empty($parentsCollection))
        {

            foreach ($parentsCollection as $key => $parent)
            {

                // Set 2 lang
                if (App::getLocale() == 'th')
                {
                    $itma_category_arr[] = $parent['name'];
                    $this->theme->breadcrumb()->add(__($parent['name']), get_permalink('category', $parent));
                } else
                {
                    if (array_get($parent, 'translate') != null)
                    {
                        $this->theme->breadcrumb()->add(__($parent['translate']['name']),
                            get_permalink('category', $parent));
                    } else
                    {
                        $this->theme->breadcrumb()->add(__($parent['name']), get_permalink('category', $parent));
                    }
                }
            }
        } else
        {
            // get first category
            $category = array();
            foreach ($product['collections'] as $collection)
            {
                if (array_get($collection, 'is_category', 1) == 1)
                {
                    $category = $collection;
                    break;
                }
            }

            if (isset($category['name']))
            {
                $itma_category_arr[] = $category['name'];
                $this->theme->breadcrumb()->add(__($category['name']), get_permalink('category', $category));
            }
        }

        ### For marketing tag ###
        $itma_product_category = '';
        if (!empty($itma_category_arr))
        {
            foreach ($itma_category_arr as $c_key => $c_row)
            {
                if ($c_key == 0)
                {
                    $itma_product_category .= $c_row;
                } else
                {
                    $itma_product_category .= ' > ' . $c_row;
                }
            }
        }
        $marketing_script = '
            var itma_product_category = "' . $itma_product_category . '";';
        $this->theme->append('marketing_tag', $marketing_script);
        ### End For marketing tag ###


        if (App::getLocale() == 'th')
        {
            $this->theme->breadcrumb()->add(__($data['product']['title']), get_permalink('products', $data['product']));
        } else
        {
            if (array_get($product, 'translate') != null)
            {
                $this->theme->breadcrumb()->add(__($data['product']['translate']['title']),
                    get_permalink('products', $data['product']));
            } else
            {
                $this->theme->breadcrumb()->add(__($data['product']['title']),
                    get_permalink('products', $data['product']));
            }
        }

        /* END - Breadcrumb ...... very very very hard code = =;  */

        // Data passing to meta:og title, image, url.
        $this->theme->partialComposer('meta_og', function ($view) use ($product, $canonicalUrl)
        {
            $view->with('meta_title', $product['title']);

            if (!empty($product['media_contents'][0]['thumb']['thumbnails']['zoom'])):
                $http_protocol = 'http:';
                if (Request::secure())
                {
                    $http_protocol = 'https:';
                }

                $meta_image = '';
                if (isset($product['media_contents'][0]['thumb']['thumbnails']['zoom']) && !empty($product['media_contents'][0]['thumb']['thumbnails']['zoom']))
                {
                    $meta_image = $http_protocol . $product['media_contents'][0]['thumb']['thumbnails']['zoom'];
                }

                $view->with('meta_image', $meta_image);
            endif;

            $view->with('meta_url', $canonicalUrl);
            $view->with('meta_description',
                strip_tags(str_replace("\n", "", str_replace("\r", "", $product['key_feature']))));
            $view->with('meta_type', 'website');
        });

        $this->theme->set('canonical_url', $canonicalUrl);

        if (!empty($product['title']))
        {
            if (App::getLocale() == 'th')
            {
                $this->theme->set('title', $product['title']);
            } else
            {
                if (array_get($product, 'translate') != null)
                {
                    $this->theme->set('title', $product['translate']['title']);
                } else
                {
                    $this->theme->set('title', $product['title']);
                }
            }

        }

        $pTitle = !empty($product['title']) ? $product['title'] : "";
        $maxSpecialPrice = (!empty($product["special_price_range"]["min"]) && $product["special_price_range"]["min"] > 0) ? $product["special_price_range"]["min"] : $product["price_range"]["min"];
        $this->embedGAMarketingTag($pkey, $pTitle, $maxSpecialPrice);



        // $content is array that store in cache.
        $expired_at = mktime(date('H'), date('i') + $this->cache_time, date('s'));
        $data['expired_at'] = date('Y-m-d H:i:s', $expired_at);
        $content['page'] = $this->theme->scope('products.level-d', $data)->render()->getContent();
        $content['expired_at'] = date('Y-m-d H:i:s', $expired_at);

        CachePage::save($ckey, $content, null, $this->cache_time);

        if (Input::has('chk-page-exp'))
        {
            echo "Page will Expired at :" . $content['expired_at'];
        }

        return Response::make($content['page'], 200,
            array('Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate'));

    }

    private function embedGAMarketingTag($pkey, $pname, $price, $type = "product")
    {
        if (App::environment('production') || App::environment('beta') || App::environment("alpha"))
        {
            //clean data.
            $pkey = json_encode($pkey);
            $pname = json_encode($pname);

            $this->theme->asset()->writeContent('GA-marketing-tag-leveld', '
            <script type="text/javascript">
                dataLayer = [];
                dataLayer.push({
                  "dynx_itemid":  ' . $pkey . ',
                  "dynx_itemid2" : ' . $pname . ',
                  "dynx_pagetype" : "' . $type . '",
                  "dynx_totalvalue" : ' . (float)$price . '
                });
            </script>
            ', array());
        }
    }

    private function isInCampaign($product)
    {
        if (!array_key_exists('discount_ended', $product))
        {
            return true;
        }

        /// get discount end ///
        $discount_ended = $product['discount_ended'];
        $now = date(DATE_ATOM);

        /// check campaign timeout or not ///
        if (strtotime($now) >= strtotime($discount_ended))
        {
            return false;
        } else
        {
            return true;
        }
    }

    /**
     * URL: /ajax/product/check-stock-by-variant
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyCheckStockByVariant()
    {
        $product_pkey = Input::get('product_pkey');
        $option_pkey = Input::get('option_pkey');
        $cache_key = $this->genStockCacheKey($product_pkey, $option_pkey);

        // get cache data
        $cache_data = ElastiCache::getResult($cache_key, null);
        $cache_expired_at = array_get($cache_data, 'expired_at');
        $cache_inprogress = array_get($cache_data, 'inprogress', false);

        // if cache exist ==> return cache data
        if (!empty($cache_data))
        {
            // if expired < 0.05min => curl:rebuild
            $current_time = time();

            if (Input::has('debugger'))
            {
                echo $cache_expired_at . ' - ' . $current_time . ' = ' . ($cache_expired_at - $current_time);
                echo "\n";
            }

            if ($cache_expired_at - $current_time <= $this->cache_time && !$cache_inprogress)
            {
                $cache_data['inprogress'] = true;
                ElastiCache::save($cache_key, $cache_data, null, $this->cache_ttl);

                $ch = curl_init();
                $post['product_pkey'] = $product_pkey;
                $post['option_pkey'] = $option_pkey;
                $url = URL::to('product/rebuild-stock') . '?' . http_build_query($post);

                curl_setopt($ch, CURLOPT_URL, $url);
                // curl_setopt($ch, CURLOPT_POST, TRUE);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

                curl_setopt($ch, CURLOPT_TIMEOUT, 1);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
                curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
                curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 10);

                curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);

                $result = curl_exec($ch);

                if (Input::has('debugger'))
                {
                    sd(curl_getinfo($ch));
                }

                curl_close($ch);
            }

            // return cache data
            $cache_data['from'] = 'cache';

            return Response::json($cache_data);
        }

        $json = $this->buildStockByVariant($product_pkey, $option_pkey);
        $json['from'] = 'api';

        $meta = array(
            'browse:level_d',
            'clicked:check_variant',
            'clicked:check_stock'
        );
        $user = ACL::getUser();



        $transaction_id = Session::get('transaction_id');
        #echo "transaction_id = ".$transaction_id;



        $log_datas = array(
            'UserIPAddress' => Request::server('HTTP_X_FORWARDED_FOR'),
            'ServerIPAddress' => Request::server('SERVER_ADDR'),
            'UserCookieId' => $transaction_id,
            'UserId' => $user['user_id'],
            'Email' => $user['email'],
            'ExecutionTime' => date("Y-m-d H:i:s"),
            'Tags' => array(
                'tag:level_d',
                'tag:check_variant',
                'tag:check_stock'
            ),
            'EventID' => 'check_stock',
            'Meta' => $meta
        );
        #alert($log_datas);
        $gearmanRepo = App::make('GearmanRepository');
        $gearmanRepo->addQueue($log_datas);

        return Response::json($json);
    }

    //--- postCheckStockByVariant ---//

    private function genStockCacheKey($product_pkey, $option_pkey)
    {
        return 'stockbyvariant_' . $product_pkey . '_' . (!empty($option_pkey) ? implode('-',
            is_array($option_pkey) ? $option_pkey : (array)$option_pkey) : '0');
    }

    private function buildStockByVariant($product_pkey, $option_pkey)
    {
        $online_price = array();
        $args['check_quota'] = 1;
        $product = $this->product->getByPkey($product_pkey, $args);

        // define cache key
        $cache_key = $this->genStockCacheKey($product_pkey, $option_pkey);

        if (!empty($product))
        {
            $variant_out_of_quota = (!empty($product['out_of_quota'])) ? $product['out_of_quota'] : array();
            $variants = array();
            if (!empty($product['variants']))
            {
                foreach ($product['variants'] as $v_key => $v_value)
                {
                    $style_options = array();
                    if (!empty($v_value['style_options']))
                    {
                        foreach ($v_value['style_options'] as $so_key => $so_value)
                        {
                            $style_options[] = $so_value['option'];
                        }
                    }

                    if (!empty($style_options))
                    {
                        if (!empty($v_value['special_price']))
                        {
                            $online_price = $v_value['net_price'];
                            $sell_price = $v_value['price'];
                        } else
                        {
                            $online_price = $v_value['price'];
                            $sell_price = $v_value['price'];
                        }
                        $variants[implode("_", $style_options)] = array(
                            'pkey' => $v_value['pkey'],
                            'inventory_id' => $v_value['inventory_id'],
                            'net_price' => $online_price,
                            'sell_price' => $sell_price
                        );
                    }
                }
            }

            if (count($option_pkey) > 0)
            {
                $option_pkey = implode("_", $option_pkey);
            }

            if (!empty($variants))
            {
                $inventory_id = "";
                foreach ($variants as $v_key => $v_value)
                {
                    if ($v_key == $option_pkey)
                    {
                        $inventory_id = $v_value['inventory_id'];
                        $net_price = $v_value['net_price'];
                        $sell_price = $v_value['sell_price'];
                        break;
                    }
                }

                if (!in_array($inventory_id, $variant_out_of_quota))
                {
                    // not exist ==> get data from pcms
                    $remaining = intval($this->product->getRemaining($inventory_id), 10);

                    if ($remaining === false)
                    {
                        $json['code'] = 500;
                        $json['stock'] = false;
                        $json['remaining'] = -1;

                        return $json;
                    }

                    $json['code'] = 200;
                    $json['stock'] = $remaining > 0 ? 'in' : 'out';
                } else
                {
                    $json['code'] = 200;
                    $json['stock'] = 'out';
                    $json['scm'] = false;
                }

                $json['net_price'] = (!empty($net_price)) ? number_format($net_price, 0) : "";
                $json['sell_price'] = (!empty($sell_price)) ? number_format($sell_price, 0) : "";

                $json['inventory_id'] = $inventory_id;
                $json['expired_at'] = strtotime('+' . $this->cache_ttl . 'min');

                // save cache data
                ElastiCache::save($cache_key, $json, null, $this->cache_ttl);

                return $json;
            }
        }
    }

    public function anyRebuildStock()
    {
        $product_pkey = Input::get('product_pkey');
        $option_pkey = Input::get('option_pkey');

        $buildResult = $this->buildStockByVariant($product_pkey, $option_pkey);

        if (Input::has('debugger'))
        {
            sd($buildResult);
        }
    }

    public function anyRebuildStockNoVariant()
    {
        $inventoryId = Input::get('data_inv_id');
        $product_pkey = Input::get('product_pkey');

        $buildResult = $this->buildStockNoVariant($product_pkey, $inventoryId);

        if (Input::has('debugger'))
        {
            sd($buildResult);
        }
    }

    private function buildStockNoVariant($product_pkey, $inventoryId)
    {
        $cache_key = $this->genStockCacheKey($product_pkey, $inventoryId);

        $product = $this->product->getByPkey($product_pkey);

        //---- Check Stock ----//
        $inventoryIds = explode(',', $inventoryId);
        $count = count($inventoryIds);

        $checkStocks = array();

        $variant_out_of_quota = !empty($product['out_of_quota']) ? $product['out_of_quota'] : array();
        $checkScm = true;

        if ($count === 1)
        {
            #$inventoryId = intval($inventoryId);

            $remaining = intval($this->product->getRemaining($inventoryId), 10);
            $checkStocks[$inventoryId] = $remaining > 0 ? 'in' : 'out';
        } else
        {
            #alertd($inventoryId, 'red', 'inventoryId');
            $remainings = $this->product->checkRemaining($inventoryId);

            #alertd($remainings, 'red');
            if (Input::has('debug'))
            {
                alert($remainings);
            }
            $stocks = array();
            foreach ($remainings as $id => $remaining)
            {
                #echo intval($remaining);
                $checkStocks[$id] = intval($remaining) > 0 ? 'in' : 'out';
            }
        }

        //---- End Check Stock ---//

        if (!empty($product))
        {
            $variants = array();
            $online_price = array();

            if (!empty($product['variants']))
            {
                foreach ($product['variants'] as $v_key => $v_value)
                {
                    //--- Check Promotion ---//


                    $style_options = array();
                    $style_options_pkey = array();

                    if (!empty($v_value['style_options']))
                    {
                        foreach ($v_value['style_options'] as $so_key => $so_value)
                        {
                            $style_options[] = $so_value['option'];
                            $style_options_pkey[$so_value['style']] = $so_value['option'];
                        }
                    } else
                    {
                        $inventory_id = $v_value['inventory_id'];
                        break;
                    }

                    if (!empty($style_options))
                    {

                        if (!empty($v_value['special_price']))
                        {
                            $online_price = $v_value['net_price'];
                            $sell_price = $v_value['price'];
                        } else
                        {
                            $sell_price = $v_value['price'];
                        }
                        $variants[implode("_", $style_options)] = array(
                            'pkey' => $v_value['pkey'],
                            'inventory_id' => $v_value['inventory_id'],
                            'net_price' => $online_price,
                            'sell_price' => $sell_price
                        );
                    }
                }
            }


            if (!empty($variants))
            {
                $inventory_id = "";
                foreach ($checkStocks as $s_key => $s_value)
                {
                    if (strtolower($s_value) == 'in')
                    {
                        $inventory_id = $s_key;
                        break;
                    }
                }
                foreach ($variants as $v_key => $v_value)
                {
                    if ($v_value['inventory_id'] == $inventory_id)
                    {
                        $variant_pkey = $v_key;
                        $inventory_id = $v_value['inventory_id'];
                        $net_price = $v_value['net_price'];
                        $sell_price = $v_value['sell_price'];
                        break;
                    }
                }

                #alertd($variant_pkey, 'red', 'variant_key');

                if (!empty($variant_pkey))
                {
                    if (preg_match("/_/", $variant_pkey))
                    {
                        $pkey_variants = explode("_", $variant_pkey);
                    } else
                    {
                        $pkey_variants = array($variant_pkey);
                    }
                }
                $json['status'] = 200;
                $json['pkey_variants'] = (!empty($pkey_variants)) ? $pkey_variants : "";
                $json['stock'] = (!empty($pkey_variants)) ? 'in' : 'out';
                $json['inventory_id'] = $inventory_id;
                $json['net_price'] = (!empty($net_price)) ? $net_price : "";
                $json['sell_price'] = (!empty($sell_price)) ? $sell_price : "";
                $json['checkScm'] = ($checkScm == true) ? true : false;
            } //--- No Style types
            else
            {
                $json['status'] = 200;
                $json['inventory_id'] = $inventoryId;
                $json['stock'] = $checkStocks[$inventoryId];
                $json['checkScm'] = ($checkScm == true) ? true : false;
            }

            $json['expired_at'] = strtotime('+' . $this->cache_ttl . 'min');

            ElastiCache::save($cache_key, $json, null, $this->cache_ttl);

            return $json;
        }
    }

    public function anyCheckStock()
    {
        $data_inv_id = Input::get('data_inv_id');
        $product_pkey = Input::get('product_pkey');

        $cache_key = $this->genStockCacheKey($product_pkey, $data_inv_id);
        $cache_data = ElastiCache::getResult($cache_key, null);
        $cache_expired_at = array_get($cache_data, 'expired_at');
        $cache_inprogress = array_get($cache_data, 'inprogress', false);

        // if cache exist ==> return cache data
        if (!empty($cache_data))
        {
            // if expired < 0.05min => curl:rebuild
            $current_time = time();

            if (Input::has('debugger'))
            {
                echo $cache_expired_at . ' - ' . $current_time . ' = ' . ($cache_expired_at - $current_time);
                echo "\n";
            }

            if ($cache_expired_at - $current_time <= $this->cache_time && !$cache_inprogress)
            {
                $cache_data['inprogress'] = true;
                ElastiCache::save($cache_key, $cache_data, null, $this->cache_ttl);

                $ch = curl_init();
                $post['product_pkey'] = $product_pkey;
                $post['data_inv_id'] = $data_inv_id;
                $url = URL::to('product/rebuild-stock-no-variant') . '?' . http_build_query($post);

                curl_setopt($ch, CURLOPT_URL, $url);
                // curl_setopt($ch, CURLOPT_POST, TRUE);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

                curl_setopt($ch, CURLOPT_TIMEOUT, 1);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
                curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
                curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 10);

                curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);

                $result = curl_exec($ch);

                if (Input::has('debugger'))
                {
                    sd(curl_getinfo($ch));
                }

                curl_close($ch);
            }

            // return cache data
            $cache_data['from'] = 'cache';

            return Response::json($cache_data);
        }

        $json = $this->buildStockNoVariant($product_pkey, $data_inv_id);
        $json['from'] = 'raw';

        $meta = array(
            'browse:level_d',
            'clicked:check_variant',
            'clicked:check_stock'
        );
        $user = ACL::getUser();
        $transaction_id = Session::get('transaction_id');
        $log_datas = array(
            'UserIPAddress' => Request::server('HTTP_X_FORWARDED_FOR'),
            'ServerIPAddress' => Request::server('SERVER_ADDR'),
            'UserCookieId' => $transaction_id,
            'UserId' => $user['user_id'],
            'Email' => $user['email'],
            'ExecutionTime' => date("Y-m-d H:i:s"),
            'Tags' => array(
                'tag:level_d',
                'tag:check_variant',
                'tag:check_stock'
            ),
            'EventID' => 'check_stock',
            'Meta' => $meta
        );
        #alert($log_datas, 'red');
        #exit;
        $gearmanRepo = App::make('GearmanRepository');
        $gearmanRepo->addQueue($log_datas);

        return Response::json($json);
    }

    //--- postCheckStock ---//

    public function postGetImage()
    {
        #alertd($_POST, 'red', 'POST');
        #if ( Input::has('isAjax') )
        #{
        #alertd($_POST, 'red');
        $media_set_pkey = Input::get('media_set_pkey');
        $product_pkey = Input::get('product_pkey');
        if (empty($product_pkey) OR empty($media_set_pkey))
        {
            $json['status'] = 500;
            $json['message'] = "Missing arguments";

            //echo json_encode($json);
            return Response::json($json);
            exit;
        }

        $product = $this->product->getByPkey($product_pkey);
        #$images = array();
        if (!empty($product['style_types']))
        {
            foreach ($product['style_types'] as $st_key => $st_value)
            {

                if ($st_value['media_set'] == true)
                {
                    if (!empty($st_value['options']))
                    {
                        foreach ($st_value['options'] as $o_key => $o_value)
                        {
                            if ($o_value['pkey'] == $media_set_pkey)
                            {
                                if (!empty($o_value['media_contents']))
                                {
                                    $images = array();
                                    foreach ($o_value['media_contents'] as $m_key => $m_value)
                                    {
                                        $images[] = array(
                                            'small' => $m_value['thumb']['thumbnails']['small'],
                                            #'medium' => $m_value['thumb']['thumbnails']['medium'],
                                            #'square' => $m_value['thumb']['thumbnails']['square'],
                                            'large' => $m_value['thumb']['thumbnails']['large'],
                                            'zoom' => $m_value['thumb']['thumbnails']['zoom']
                                        );
                                    }
                                    //--- End foreach $o_value['media_contents'] ---//
                                }
                            }
                        }
                        //--- End foreach $st_value['options'] ---//
                    }
                }

                $meta = array(
                    'browse:level_d',
                    'clicked:check_variant'
                );
                $user = ACL::getUser();

                $transaction_id = Session::get('transaction_id');


                $log_datas = array(
                    'UserIPAddress' => Request::server('HTTP_X_FORWARDED_FOR'),
                    'ServerIPAddress' => Request::server('SERVER_ADDR'),
                    'UserCookieId' => $transaction_id,
                    'UserId' => $user['user_id'],
                    'Email' => $user['email'],
                    'ExecutionTime' => date("Y-m-d H:i:s"),
                    'Tags' => array(
                        'tag:level_d',
                        'tag:check_variant'
                    ),
                    'EventID' => 'check_variant',
                    'Meta' => $meta
                );
                #alert($log_datas, 'red');
                #exit;
                $gearmanRepo = App::make('GearmanRepository');
                $gearmanRepo->addQueue($log_datas);
                //echo json_encode($images);
                return Response::json($images);
                //---- End Foreach $product['style_types'] ----//

            }

            //echo json_encode($images);
            return Response::json($images);
            //---- End Foreach $product['style_types'] ----//
        }
        #}
    }

    function getCheckImg()
    {
        $p_id = Input::get('p_id');
        $color_id = Input::get('color_id');

        $product = $this->product->getByPkey($p_id);

        $product_gallery = array();

        if (!empty($product['style_types']))
        {
            foreach ($product['style_types'] as $key => $row)
            {
                if (!empty($row['options']))
                {
                    foreach ($row['options'] as $o_key => $o_row)
                    {
                        if (!empty($o_row['media_contents']))
                        {
                            foreach ($o_row['media_contents'] as $m_key => $m_row)
                            {
                                if ($m_row['mode'] == 'image' && $o_row['pkey'] == $color_id)
                                {
                                    $tmp2 = array(
                                        'color_id' => $o_row['pkey'],
                                        'path' => $m_row['thumb']['normal']
                                    );
                                    $product_gallery[] = $tmp2;
                                }
                            }
                        }
                    }
                }
            }
        }

        if (!empty($product_gallery))
        {
            header('Content-Type: application/json');
            echo json_encode($product_gallery);
        }
    }

}
