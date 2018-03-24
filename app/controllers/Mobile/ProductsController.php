<?php

namespace Mobile;


use Illuminate\Support\Facades\App;
use \ProductRepositoryInterface;
use Illuminate\Support\Facades\Lang;
use Input;
use Response;
use Url;
use CachePage;
use ElastiCache;
use Redirect;
use Request;
use CollectionRepository;
use \ACL;



class ProductsController extends \MobileBaseController {

    private $pcms;
    private $product;

    private $cache_ttl = 1; // min
    private $cache_time = 5; // sec
    private $noCache = false;


    public function __construct(ProductRepositoryInterface $product)
    {
        parent::__construct();


        $this->pcms = App::make('pcms');
        $this->product = $product;

        /**
         * cache_time have assigns value form $_GET['set-cache-exp'];
         */
        $no_cache = Input::get('no-cache', false);
        $this->noCache = !empty($no_cache);

        if (Input::has('set-cache-exp'))
        {
            $cache_exp_at = Input::get('set-cache-exp');
            $cache_exp_at = preg_replace('/hr/', '', $cache_exp_at);
            $this->cache_time = ((int)$cache_exp_at) * 60;
            $this->noCache = true;

        }
    }

    public function getCategoryProducts($pkey = null)
    {
        if (empty($pkey))
        {
            // return Redirect::route('home');
            return App::abort('404');
        }



        //$ckey = Route::getCurrentRoute()->getActionName() . Lang::locale() . $pkey;


        $inputParams = Input::except(array("no-cache","set-cache-exp","chk-page-exp"));
        $inputParams = implode("_",$inputParams);
        $ckey = Request::url() . Request::path() . Lang::locale() . $pkey . "_" . $inputParams;

        if ($this->noCache===false)
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
        /**
        if ($response = CachePage::getResult($ckey, null))
        {
            return $response;
        }
        **/

        // Get Collection Detail.
        $collectionRepo = new CollectionRepository;

        ### Don't use brand list ###
        #$view['brandLists'] = $collectionRepo->getBrands($pkey);
        $view['brandLists'] = array();

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
        #$view['collectionKey'] = $pkey;
        if (Input::has('brand'))
        {
            $params['brandKey'] = Input::get('brand');
        }

        $data = $this->getProductsList($params);

        #alert($data);
        #return '<textarea cols="100" rows="45">'.print_r($data, TRUE).'</textarea>';

        #alertd($data);

        $view['type'] = 'categories';
        $view['data'] = $data;

        #$view['bestSeller'] = $this->product->getBestSeller($pkey);

        $depth = 3;
        // CollectionRepository has an instance already.
        // $collectionRepo = new CollectionRepository;

        /***
         * category menu don't use now
         * $view['collections'] = $collectionRepo->getAll($depth);
         */
        $view['currentPkey'] = $pkey;

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
                if(App::getLocale() == 'en')
                {
                    $ParentCollectName = isset($parent['translate']['name']) ? $parent['translate']['name'] : $parent['name'] ;
                }
                $this->theme->breadcrumb()->add(__($ParentCollectName), get_permalink('category', $parent));

            }
        }
        // $this->theme->breadcrumb()->add(__($view['collectionDetail']['name']), URL::toLang('/category/' . $view['collectionDetail']['pkey']));
        $CollectionName = $view['collectionDetail']['name'];

        ### For marketing tag ###
        $itma_product_category = $CollectionName;
        $marketing_script = '
            var itma_product_category = "'.$itma_product_category.'";'.'
            var itma_cat_id = "'.$pkey.'";
        ';
        $this->theme->append('marketing_tag', $marketing_script);
        ### End For marketing tag ###

        if(App::getLocale() == 'en')
        {
            $CollectionName = isset($view['collectionDetail']['translate']['name'])? $view['collectionDetail']['translate']['name'] : $view['collectionDetail']['name'] ;
        }

        $this->theme->breadcrumb()->add(__($CollectionName), get_permalink('category', $view['collectionDetail']));

        $this->theme->set('canonical_url', $canonicalUrl);
        $this->theme->asset()->usePath()->add('css-style', 'css/search.css');
        $this->theme->asset()->usePath()->add('css-custom', 'css/custom.css');
        #http://m.dev.itruemart.com/everyday-wow
        $this->theme->asset()->container('footer')->usePath()->add('js-jscroll', 'vendors/jscroll/jquery.jscroll.min.js');
        $this->theme->asset()->container('footer')->usePath()->add('js-search', 'js/search.js');

        #alertd($view['data'], 'red');
        $view['currentKey'] = $pkey;
        $view['orderBy'] = Input::get('orderBy', 'published_at');
        $view['order'] = Input::get('order', 'desc');
        $view['viewBy'] = Input::get('viewBy', 'default');
        $view['page'] = Input::get('page', 1);

        $meta_title = __('seo_title_home').' | iTruemart.ph';
        $this->theme->setTitle($meta_title);
        $this->theme->setMetadescription(__('seo_description_home'));
        $this->theme->setMetakeywords(__('seo_keyword_home'));
        $this->theme->setCanonical('http://'.Request::server ("SERVER_NAME").'/'.Request::path());


        #return $this->theme->scope('products.level-c', $view)->render();

        $expired_at = mktime(date('H'), date('i') + $this->cache_time, date('s'));
        $view['expired_at'] = $this->cache_time;
        $content['page'] = $this->theme->scope('products.level-c', $view)->render();
        $content['expired_at'] = date('Y-m-d H:i:s',$expired_at);

        CachePage::save($ckey, $content, null, $this->cache_time);

        if (Input::has('chk-page-exp'))
        {
            echo "Page will Expired at :" . $content['expired_at'];
        }

        return $content['page'];
    }

    /**
     * @author  Preme W. <preme_won@truecorp.co.th
     * @description Generate content for viewBy and sorting
     * @since Aug 5, 2014
     * @access Public by ajax
     * @method POST
     */
    public function categoryProductsView()
    {
        if(Input::has('pe'))
        {
            $this->cache_time = (int) Input::get('pe');
        }

        $inputParams = Input::except(array("no-cache","set-cache-exp","chk-page-exp"));
        $inputParams = implode("_",$inputParams);
        $ckey = Request::url() . Request::path() . Lang::locale() . "_" . $inputParams;

        if ($this->noCache===false)
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

        $data = array();
        $args = array();
        $this->theme->uses('mobile')->layout('blank');
        $viewBy = Input::get('viewBy', 'default');
        $args['collectionKey'] = Input::get('collectionKey');

        $data['data'] = $this->getProductsList($args);
        $data['currentKey'] = Input::get('collectionKey');

        $CollectionRepo = App::make('CollectionRepository');


        $collectionName = '';
        if(!empty($data['currentKey'])){
            $collectionData = $CollectionRepo->getByPkey($data['currentKey']);
        }

        $locale = \App::getLocale();

        if(!empty($collectionData)){
            if($locale == 'th'){
                $collectionName = array_get($collectionData, 'name');
            }
            else{
                $collectionName = array_get($collectionData, 'translate.name');
                if(!empty($collectionName)){
                    $collectionName = array_get($collectionData, 'name');
                }
            }
        }

        $data['data']['collection_name'] = $collectionName;

        $data['orderBy'] = Input::get('orderBy', 'published_at');
        $data['order'] =  Input::get('order', 'desc');
        $data['viewBy'] = Input::get('viewBy', 'default');
        $data['page'] = Input::get('page', 1);


        #    echo "viewBy = ".$viewBy;
        //return Response::json($_POST);
        #return "test";
        $meta_title = __('seo_title_home').' | iTruemart.ph' ;
        $this->theme->setTitle($meta_title);
        $this->theme->setMetadescription(__('seo_description_home'));
        $this->theme->setMetakeywords(__('seo_keyword_home'));
        $this->theme->setCanonical('http://'.Request::server ("SERVER_NAME").'/'.Request::path());

        // START Criteo tag
        $product_list = array();
        foreach ($data['data']['products'] as $key => $item) {
            $product_list[] = $item['pkey'];
        }
        $this->theme->append('criteo_tag', criteoTagLevelCMobile($product_list, $collectionName));
        // END Criteo tag

       /* $content = $this->theme->scope('products.level-c-'.$viewBy.'-view', $data)->render()->getContent();
        return $content;*/


        $expired_at = mktime(date('H'), date('i') + $this->cache_time, date('s'));
        $data['expired_at'] = $this->cache_time;
        $content['page'] = $this->theme->scope('products.level-c-'.$viewBy.'-view', $data)->render()->getContent();
        $content['expired_at'] = date('Y-m-d H:i:s',$expired_at);

        CachePage::save($ckey, $content, null, $this->cache_time);

        if (Input::has('chk-page-exp'))
        {
            echo "Page will Expired at :" . $content['expired_at'];
        }

        return $content['page'];
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
        $params['per_page'] = 20;
        #alertd($params, 'red');

        $data = $this->product->search($params);

        return $data;
    }

    public function getLevelD($pkey = null)
    {
        if (empty($pkey))
        {
            return App::abort(404);
        }

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

        $view = compact('pkey');
        $this->theme->setCanonical('http://'.Request::server ("SERVER_NAME").'/'.Request::path());
        $this->theme->asset()->usePath()->add('swiper', 'css/idangerous.swiper.css', array('core'));
        $this->theme->asset()->usePath()->add('level-d', 'css/detail.css', array('core'));
        $this->theme->asset()->container('footer')->usePath()->add('countdown', 'js/jquery.countdown.min.js', array('jquery'));
        $this->theme->asset()->container('footer')->usePath()->add('swiper', 'js/idangerous.swiper-2.1.min.js', array('jquery'));
        $this->theme->asset()->container('footer')->usePath()->add('level-d', 'js/level-d.js?_=20141216', array('jquery'));
        $this->theme->asset()->container('footer')->usePath()->add('level-d-stock', 'js/level-d-stock.js?r=20141212', array('jquery', 'level-d'));
        $this->theme->asset()->container('footer')->usePath()->add('level-d-share', 'js/social_share.js', array('jquery'));


        $pTitle = !empty($product['title'])? $product['title'] : "";
        /* typeidea script */
        $pBrand = !empty($product['brand']['name'])? $product['brand']['name'] : "";
        /* //typeidea script */
        $maxSpecialPrice = (!empty($product["special_price_range"]["min"]) && $product["special_price_range"]["min"] > 0)? $product["special_price_range"]["min"] : $product["price_range"]["min"];
        $this->embedGAMarketingTag($pkey, $pTitle, $maxSpecialPrice);

        ### For marketing tag ###
        $itma_product_category = $this->getCategoryText($product);
        /* typeidea script */
        $marketing_script = '
            var itma_product_category = "'.$itma_product_category.'";'.'
            var itma_price = "'.(float)(str_replace(',', '', $maxSpecialPrice)).'";'.'
            var itma_product_id = "'.$pkey.'";'.'
            var itma_product_name = "'. htmlspecialchars($pTitle) .'";
            var itma_product_brand = "'. htmlspecialchars($pBrand) .'";
            var itma_product_name = "'. htmlspecialchars($pTitle) .'";
            ';
        /* //typeidea script */

        $this->theme->append('marketing_tag', $marketing_script);
        ### End For marketing tag ###

        // START Criteo tag
        $this->theme->append('criteo_tag', criteoTagLevelDMobile($pkey));
        // END Criteo tag

        $content = $this->theme->scope('products.level-d', $view)->render()->getContent();

        return Response::make($content, 200, array('Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate'));
    }

    public function getLevelDContent($pkey)
    {
        $this->theme->layout('blank');

        $product = $this->product->getByPkey($pkey);

//        $product = json_decode(file_get_contents(app_path('controllers/Mobile/product.json')), 1);

        $locale = langToLocale(Lang::getLocale());

        // get inventory list
        $inventoryIds = array();
        foreach (array_get($product, 'variants') ?: array() as $variant)
        {
            $inventoryIds[] = $variant['inventory_id'];
        }

        ### create product is wow or not?
        $is_wow = false;

        // check at discount campaign
        foreach (array_get($product, 'variants') ?: array() as $variant)
        {
            if(isset($variant['active_special_discount']['campaign_type'])
                && in_array($variant['active_special_discount']['campaign_type'], \Config::get('settings.limit-cart-item-quantity.discount-campaigns')))
            {
                $is_wow = true;
            }
        }

        // check with collection
        foreach (array_get($product, 'collections') as $collection)
        {
            if(in_array($collection['pkey'], \Config::get('settings.limit-cart-item-quantity.collections')))
            {
                $is_wow = true;
            }
        }
        ### end is wow

        ### check in cart has wow or not?
        $checkout = $this->pcms->getCheckoutV2();
        $checkout = isset($checkout['data']) ? $checkout['data'] : array();

        $limitQuantity = getLimitQuantityFromCheckout($checkout);

        $this_wow_product_in_cart = false;
        foreach (array_get($product, 'variants') ?: array() as $variant)
        {
            if(isset($limitQuantity[$variant['inventory_id']]))
            {
                $this_wow_product_in_cart = true;
            }
        }
        ### end check cart has wow

        $stocks = $this->pcms->api('inventories/'.implode(',', $inventoryIds).'/remaining');
        $stocks = $stocks['data']['remaining'];

        $policies = array();

        foreach ($product['policies'] as $policy)
        {

            switch ($policy['type_id'])
            {
                //free delivery policy
                case '3':
                    if ($locale == 'th_TH')
                    {
                        $policies['shipping']['title'] = $policy['title'];
                        $policies['shipping']['description'] = $policy['description'];

                    }
                    else
                    {
                        if(isset($policy['translates'][$locale]))
                            $policies['shipping'] = $policy['translates'][$locale];
                        else
                        {
                            $policies['shipping']['title'] = $policy['title'];
                            $policies['shipping']['description'] = $policy['description'];
                        }

                    }
                    $policies['shipping']['type'] = $policy['type'][$locale];
                    break;
                //money back policy
                case '2':
                    if ($locale == 'th_TH')
                    {
                        $policies['refund']['title'] = $policy['title'];
                        $policies['refund']['description'] = $policy['description'];
                        // $policies['type'] = $policy['type'][$locale];
                    }
                    else
                    {
                        if(isset($policy['translates'][$locale]))
                            $policies['refund'] = $policy['translates'][$locale];
                        else
                        {
                            $policies['refund']['title'] = $policy['title'];
                            $policies['refund']['description'] = $policy['description'];
                        }

                    }
                    $policies['refund']['type'] = $policy['type'][$locale];
                    break;
                //return policy
                case '1':
                    if ($locale == 'th_TH')
                    {
                        $policies['returnItem']['title'] = $policy['title'];
                        $policies['returnItem']['description'] = $policy['description'];
                        // $policies['type'] = $policy['type'][$locale];
                    }
                    else
                    {
                        if(isset($policy['translates'][$locale]))
                            $policies['returnItem'] = $policy['translates'][$locale];
                        else
                        {
                            $policies['returnItem']['title'] = $policy['title'];
                            $policies['returnItem']['description'] = $policy['description'];
                        }

                    }
                    $policies['returnItem']['type'] = $policy['type'][$locale];
                    break;
            }


        }

        $relateds = array();

        // first 3 from cat
        $byCollections = array();
        $collectionKey = $product['collections'][0]['pkey'];
        $params = array(
            'collectionKey' => $collectionKey,
            'per_page'      => 3,
            'relate'        => 1
        );
        $byCollections = $this->product->search($params);
       # $byCollections = array();

        // another 2 from tag, byCollections contains atleast 1
        $byTags = array();
        if (count($byCollections['products']) > 0)
        {
            $q = $product['tag'];
            #if ( ! empty($product['tag']))
            #{
                $params = array(
                    'q'        => $q,
                    'per_page' => 16,
                    'relate' => 1
                );

                #alert($params, 'red');

                $byTags = $this->product->search($params);
                #echo sizeof($byTags);
                #exit;

            #}
        }

        $byTags['products']             = !empty($byTags['products'] )? $byTags['products'] : array();
        $byCollections['products']      = !empty($byCollections['products'] )? $byCollections['products'] : array();

        #echo sizeof($byCollections['products']);
        #echo sizeof($byTags['products']);
        $relateds = array_merge($byCollections['products'], $byTags['products']);

        //echo count($relateds);gg
        //exit;

        $relateds = $this->buildProductsArray($relateds, $pkey);

        $styleOptionAvaliable = $this->getStyleOptionAvaliable($product);
        $inventoryImage = $this->getInventoryImage($product);

        $view = compact('is_wow', 'this_wow_product_in_cart', 'product', 'stocks', 'policies', 'relateds', 'styleOptionAvaliable', 'inventoryImage');

        $content = $this->theme->scope('products.level-d-content', $view)->render()->getContent();

        return Response::make($content, 200, array('Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate'));
    }

    private function buildProductsArray($product, $pkey = NULL)
    {
        $pkeys = array();
        $products = array();
        #alert($product, 'red', 'product');

        if ( ! empty($product))
        {
            $i = 0;

            foreach ($product as $key => $value)
            {
                //test that pkey is not already in list and not itself
                if($i <= 4 && ! in_array($value['pkey'], $pkeys) && $value['pkey'] != $pkey)
                {
                    array_push($products, $value);
                    $pkeys[$i++] = $value['pkey'];
                }
            }
        }

        #alert($products, 'red', 'products');
        #echo sizeof($products);

        return $products;
    }

    protected function getStyleOptionAvaliable($product)
    {
        // if ($product['style_types'])
        // {
        //     uasort($product['style_types'], function($a1, $a2) { return strcasecmp(array_get($a1, 'pkey'), array_get($a2, 'pkey')) ? -1 : 1; });
        // }

        // create style option avaliable
        $styleOptionAvaliable = array();

        $styleTypes = array_get($product, 'style_types') ?: array();

        // is it really exists?
        $styles_exists = false;

        $styleTypeTotal = count($styleTypes);

        // loop in variants
        foreach(array_get($product, 'variants') ?: array() as $variant)
        {
            $variantStyleOptions = array_get($variant, 'style_options');

            // create style option pkey container
            $styleOptionPkey = array();

            // loop in style type for rearrange style option
            foreach ($styleTypes ?: array() as $key => $styleType)
            {
                $styles_exists = $styles_exists || array_get($styleType, 'options', array());

                // get pkey of style type for compare
                $pkey = array_get($styleType, 'pkey');

                // look up in style option
                if(count($variantStyleOptions) > 0 && is_array($variantStyleOptions))
                {
                    foreach ($variantStyleOptions as $key => $variantStyleOption)
                    {
                        if (array_get($variantStyleOption, 'style') == $pkey)
                        {
                            // it match so add in pkey container
                            $styleOptionPkey[] = array_get($variantStyleOption, 'option');
                        }
                    }
                }
            }

            // styleOptionPkey must equal style type amount
            if (count($styleOptionPkey) == $styleTypeTotal || !$styles_exists)
            {
                $data = array(
                    'inventory_id' => array_get($variant, 'inventory_id'),
                    'price' => number_format(array_get($variant, 'price')),
                    'net_price' => number_format(array_get($variant, 'net_price'))
                );
                array_set($styleOptionAvaliable, implode('.', $styleOptionPkey) ?: '0', $data);
            }
        }

        return $styleOptionAvaliable;
    }

    protected function getInventoryImage($product)
    {
        // get style type media set
        $styleTypeMediaSet = '';
        foreach (array_get($product, 'style_types') ?: array() as $key => $styleType)
        {
            if (array_get($styleType, 'media_set') == true)
            {
                $styleTypeMediaSet = $styleType;
            }
        }

        // no style type that has media set so return blank array
        if (! $styleTypeMediaSet)
        {
            return array();
        }

        // get image
        $variants = array_get($product, 'variants');
        $images = array();
        foreach ($variants as $key => $variant)
        {
            $inventoryId = array_get($variant, 'inventory_id');
            $styleOptions = array_get($variant, 'style_options');
            if(count($styleOptions) > 0 && is_array($styleOptions)) {
                foreach ($styleOptions as $key => $styleOption) {
                    if (array_get($styleOption, 'style') != array_get($styleTypeMediaSet, 'pkey')) {
                        continue;
                    }

                    $filter = function ($item) use ($styleOption) {
                        if (array_get($item, 'pkey') == array_get($styleOption, 'option')) {
                            return true;
                        }

                        return false;
                    };

                    $styleOptionMediaSet = array_filter(array_get($styleTypeMediaSet, 'options'), $filter);

                    // sd($styleOptionMediaSet);
                    // $styleType = array_get($product, 'style_types.')
                    if (count($styleOptionMediaSet) > 0) {
                        if (isset($images[$inventoryId])) {
                            $images[$inventoryId] = array();
                        }
                        foreach (array_get(current($styleOptionMediaSet), 'media_contents') ?: array() as $key => $mediaContent) {
                            # code...
                            $images[$inventoryId][] = array_get($mediaContent, 'thumb.thumbnails.large');
                        }

                    }
                }
            }

        }

        return $images;
    }

    private function genStockCacheKey($pkey, $inventoryIds, $product_promotion)
    {
        return 'mobilestockbyvariant_' . $pkey . '_'
            . (!empty($inventoryIds) ? implode('-', is_array($inventoryIds) ? $inventoryIds : (array)$inventoryIds) : '0')
            . '-' . $product_promotion;
    }

    private function buildMobileStock($pkey, $inventoryIds, $product_promotion)
    {
        $cache_key = $this->genStockCacheKey($pkey, $inventoryIds, $product_promotion);

        $params = array(
            'check_quota' => 'Y'
        );

        /*** For old function ***/
        if($product_promotion != 'itruemart_tv') {
            //return Response::json(array(), 200);
            $stocks = $this->pcms->api('inventories/'.implode(',', $inventoryIds).'/remaining');
            $stocks = array_get($stocks, 'data.remaining');
        }
        else {
            $params = array(
                'check_quota' => 'Y'
            );

            /*** For Check Quota ***/
            $product = $this->product->getByPkey($pkey, $params);

            $full_quota = array();
            $not_full_quota = array();

            if(!empty($product)) {
                $totalVariant = count($product['variants']);
                $variant_out_of_quota = !empty($product['out_of_quota'])?$product['out_of_quota']:array();

                if($totalVariant > 1) {
                    foreach($inventoryIds as $inven_key => $inven_row) {
                        if ( !in_array($inven_row, $variant_out_of_quota)) {
                            $not_full_quota[] = $inven_row;
                        }
                        else {
                            $full_quota[$inven_row] = 0;
                        }
                    }
                }
                else {
                    foreach($inventoryIds as $inven_key => $inven_row) {
                        $not_full_quota[] = $inven_row;
                    }
                }

            }

            $stocks = array();
            if(!empty($not_full_quota))
            {
                $stocks = $this->pcms->api('inventories/'.implode(',', $not_full_quota).'/remaining');

                $stocks = array_get($stocks, 'data.remaining');
            }

            if(!empty($full_quota))
            {
                $stocks = array_merge($stocks, $full_quota);
            }
        }

        $stocks['expired_at'] = strtotime('+' . $this->cache_ttl . 'min');
        ElastiCache::save($cache_key, $stocks, null, $this->cache_ttl);

        return $stocks;
    }

    public function anyRebuildMobileStock($inventoryIds)
    {
        $inventoryIds = explode(",", $inventoryIds);
        $inventoryIds = array_filter($inventoryIds, function($item) {
            return is_numeric($item) ? $item : false;
        });
        $inventoryIds = array_values($inventoryIds);

        $pkey = Input::get('pkey');

        $product_promotion = Input::get('product_promotion');

        $buildResult = $this->buildMobileStock($pkey, $inventoryIds, $product_promotion);

        if (Input::has('debugger')) {
            sd( $buildResult );
        }
    }

    public function getStocks($inventoryIds)
    {

        $inventoryIds = explode(",", $inventoryIds);
        $inventoryIds = array_filter($inventoryIds, function($item) {
            return $item ? $item : false;
        });
        $inventoryIds = array_values($inventoryIds);

        $pkey = Input::get('pkey');

        $product_promotion = Input::get('product_promotion');

        $cache_key = $this->genStockCacheKey($pkey, $inventoryIds, $product_promotion);

        // get cache data
        $cache_data = ElastiCache::getResult($cache_key, null);
        $cache_expired_at = array_get($cache_data, 'expired_at');
        $cache_inprogress = array_get($cache_data, 'inprogress', false);

        // if cache exist ==> return cache data
        if (!empty($cache_data)) {
            // if expired < 0.05min => curl:rebuild
            $current_time = time();

            if (Input::has('debugger')) {
                echo $cache_expired_at . ' - ' . $current_time . ' = ' . ($cache_expired_at - $current_time);
                echo "\n";
            }

            if ( $cache_expired_at - $current_time <= $this->cache_time && !$cache_inprogress) {
                $cache_data['inprogress'] = true;
                ElastiCache::save($cache_key, $cache_data, null, $this->cache_ttl);

                $ch = curl_init();
                $post['pkey'] = $pkey;
                $post['product_promotion'] = $product_promotion;
                $url = URL::to('products/rebuild-mobile-stocks/' . (is_array($inventoryIds) ? implode(',', $inventoryIds) : $inventoryIds)) . '?' . http_build_query($post);

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

                if (Input::has('debugger')) {
                    sd( curl_getinfo($ch) );
                }

                curl_close($ch);
            }

            // return cache data
            $cache_data['from'] = 'cache';
            return Response::json($cache_data);
        }

        $json = $this->buildMobileStock($pkey, $inventoryIds, $product_promotion);
        $json['from'] = 'api';

        return Response::json($json);

    }

    public function getLevelDDetail($pkey = null)
    {
        if (empty($pkey))
        {
            return App::abort(404);
        }

        $view = compact('pkey');

        return $this->theme->scope('products.level-d-detail', $view)->render();
    }

    public function getLevelDDetailContent($pkey)
    {
        $this->theme->layout('blank');

        $product = $this->product->getByPkey($pkey);

//        $product = json_decode(file_get_contents(app_path('controllers/Mobile/product.json')), 1);

        $view = compact('product');

        return $this->theme->scope('products.level-d-detail-content', $view)->render();
    }

    private function embedGAMarketingTag($pkey, $pname, $price){

        if (App::environment('production') || App::environment('beta') || App::environment("alpha")){
            $this->theme->asset()->writeContent('GA-marketing-tag-leveld', '
                <script type="text/javascript">
                    dataLayer = [];
                    dataLayer.push({
                      "dynx_itemid": "'.$pkey.'",
                      "dynx_itemid2" : '. json_encode($pname) .',
                      "dynx_pagetype" : "product",
                      "dynx_totalvalue" : '.$price.'
                    });
                </script>
            ', array());
        }
    }

    private function getCategoryText($product = array())
    {
        $parentsCollection = array();

        $collectionRepo = new CollectionRepository;

        foreach ($product['collections'] as $val)
        {
            if (array_get($val, 'is_category', 1) != 1)
            {
                continue;
            }

            $collection = $collectionRepo->getByPkey($val['pkey']);

            $current_parent = array_get($collection, 'parents', array());
            if ( count($parentsCollection) < count($current_parent) ) {
                $parentsCollection = $collection['parents'];
                $parentsCollection[] = $collection;
            }
        }

        $itma_category_arr = array();

        if (!empty($parentsCollection))
        {

            foreach ($parentsCollection as $key => $parent)
            {
                $itma_category_arr[] = $parent['name'];
            }
        }
        else
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
            }
        }

        ### For marketing tag ###
        $itma_product_category = '';
        if(!empty($itma_category_arr))
        {
            foreach($itma_category_arr as $c_key => $c_row)
            {
                if($c_key == 0)
                {
                    $itma_product_category .= $c_row;
                }
                else
                {
                    $itma_product_category .= ' > '.$c_row;
                }
            }
        }

        return $itma_product_category;
    }

}
