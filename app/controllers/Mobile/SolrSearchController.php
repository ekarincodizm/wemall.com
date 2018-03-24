<?php

namespace Mobile;

use Request;
use Input;
use Theme;
use Illuminate\Support\Facades\App;
use Lang;
use ElastiCache;

class SolrSearchController extends \MobileBaseController {

    const BEST_MATCH = "best_match";
    const EN = "en";
    protected $product;
    private $cache_time = 2;
    private $lang;

    public function __construct(\ProductRepository $product)
    {
        parent::__construct();
        $this->theme->layout('angular-template');
        $this->product = $product;
        $no_cache = Input::get('no-cache', false) ;
        $this->noCache = !empty($no_cache);
        $this->lang = Lang::getLocale();
    }

    private function getFilters()
    {
        $filters = array();

        if (Input::has("priceMax")) {
            $filters['priceMax'] = Input::get('priceMax');
        }

        if (Input::has("priceMin")) {
            $filters["priceMin"] = Input::get("priceMin");
        }

        if (Input::has("orderBy")) {
            $filters["orderBy"] = Input::get("orderBy");
        } else {
            $filters["orderBy"] = self::BEST_MATCH;
        }

        if (Input::has("order")) {
            $filters["order"] = Input::get("order");
        }

        if (Input::has('collection')) {
            $categoryName = Input::get('collection');

            if ($this->lang == self::EN) {
                $filters['cat_lv1_en'] = $categoryName;
            } else {
                $filters['cat_lv1_th'] = $categoryName;
            }

        }

        if (Input::has("color_en")) {
            $filters["color_en"] = Input::get("color_en");
        }

        if (Input::has("color_th")) {
            $filters["color_th"] = Input::get("color_th");
        }

        if (Input::has("size_th")) {
            $filters["size_th"] = Input::get("size_th");
        }

        if (Input::has("size_en")) {
            $filters["size_en"] = Input::get("size_en");
        }

        if (Input::has("brand_en")) {
            $filters["brand_en"] = Input::get("brand_en");
        }

        if (Input::has("brand_th")) {
            $filters["brand_th"] = Input::get("brand_th");
        }

        if (Input::has("payment_ccw")) {
            $filters["payment_ccw"] = Input::get("payment_ccw");
        }

        if (Input::has("payment_installment")) {
            $filters["payment_installment"] = Input::get("payment_installment");
        }

        if (Input::has("payment_bank_transfer")) {
            $filters["payment_bank_transfer"] = Input::get("payment_bank_transfer");
        }

        if (Input::has("payment_atm")) {
            $filters["payment_atm"] = Input::get("payment_atm");
        }

        if (Input::get("payment_cs")) {
            $filters["payment_cs"] = Input::get("payment_cs");
        }

        if (Input::get("payment_cod")) {
            $filters["payment_cod"] = Input::get("payment_cod");
        }

        if (Input::get("payment_internet_banking")) {
            $filters["payment_internet_banking"] = Input::get("payment_internet_banking");
        }

        if (Input::get("payment_over_the_counter")) {
            $filters["payment_over_the_counter"] = Input::get("payment_over_the_counter");
        }

        $filters["q"] = Input::get("q", "");
        $filters["page"] = intval(Input::get("page", 1));
        $filters["per_page"] = intval(Input::get("per_page", 20));
        if(empty($filters["per_page"])){
            $filters["per_page"] = 20;
        }

        return $filters;
    }

    private function cleanParameter($keyword)
    {
        $keyword = trim($keyword);
        $keyword = strip_tags(urldecode($keyword));

        return $keyword;
    }


    // public function getIndex()
    // {

    //     setSeoMeta('search');
    //     $filters = $this->getFilters();
    //     $keyword = array_get($filters, "q", "");

    //     // If keyword contents any HTML, go to 404.
    //     if (is_html($keyword))
    //     {
    //         App::abort(404);
    //     }
        
    //     $keyword = $this->cleanParameter($keyword);
    //     $filters['q'] = $keyword;

    //     $keyword = $this->cleanParameter($keyword);
    //     $filters['q'] = $keyword;

    //     if (Input::has('debug-filter'))
    //     {
    //         alert($filters, 'red', 'filters');
    //         if (Input::has('die'))
    //         {
    //             die;
    //         }
    //     }

    //     // create cache key for home page
    //     $cache_key = Request::url() . Lang::locale() .http_build_query($filters)."_SolrSearch";

    //     // check cache result
    //     if ($this->noCache===false) {

    //         $cache_response = ItmMemcached::getResult($cache_key, null);

    //         if (!empty($cache_response)){
    //             if(Input::has('debug-cache'))
    //             {
    //                 echo 'cache';
    //             }

    //             return $cache_response;
    //         }
    //     }


    //     $data = $this->product->solrSearch($filters);

    //     $view['data'] = $data;
    //     $view['type'] = 'search';
    //     $viewBy = Input::get('viewBy', 'default');

    //     $view['currentKey'] = rawurlencode($keyword);
    //     $view['per_page'] = $filters['per_page'];
    //     $view["collection"] = Input::get('collection', "");
    //     $view['orderBy'] = array_get($filters, "orderBy", self::BEST_MATCH);
    //     $view['order'] = array_get($filters, 'order', 'desc');

    //     $this->theme->asset()->usePath()->add('css-style', 'css/search.css');
    //     $this->theme->asset()->container('footer')->add('jquery-getQueryString', 'assets/js/jquery.getQueryString.js', array('jquery'));
    //     $this->theme->asset()->container('footer')->usePath()->add('js-search', 'js/search2.js');
    //     $this->theme->asset()->usePath()->add('css-custom', 'css/custom.css');
    //     $this->theme->asset()->container('footer')->usePath()->add('js-jscroll', 'vendors/jscroll/jquery.jscroll.min.js');

    //     $this->theme->setTitle("Search ".$keyword.' | iTrueMart.com') ;
    //     $this->theme->setMetadescription(__('seo_description_home'));
    //     $this->theme->setMetakeywords(__('seo_keyword_home'));
    //     $this->theme->setCanonical('http://www.itruemart.com'.'/'.Request::path().$this->link_to_action());


    //     $content = $this->theme->scope('solrsearch.search', $view)->render();
    //     ItmMemcached::save($cache_key, $content, null, $this->cache_time);
    //     if(Input::has('debug-cache'))
    //     {
    //         echo 'no cache';
    //     }
    //     return $content;

    // }
    
    public function getIndex()
    {
        setSeoMeta('search');
        $filters = $this->getFilters();
        $keyword = array_get($filters, "q", "");

        if (is_html($keyword))
        {
            App::abort(404);
        }
        
        $keyword = $this->cleanParameter($keyword);
        $filters['q'] = $keyword;

        $this->theme->setTitle("Search ".$keyword.' | iTruemart.ph') ;
        $this->theme->setMetadescription(__('seo_description_home'));
        $this->theme->setMetakeywords(__('seo_keyword_home'));
        $this->theme->setCanonical('http://'.Request::server ("SERVER_NAME").'/'.Request::path().$this->link_to_action());

        $content = $this->theme->scope('solrsearch.search', array())->render();
        return $content;

    }

    public function searchView()
    {
        $args = array();
        $keyword = Input::get('q');
        $keyword = trim($keyword);
        $keyword = strip_tags($keyword);

        $view = array();
        $this->theme->layout('blank');
        $viewBy = Input::get('viewBy');

        $view['data'] = $this->getProductsList($args);
        $view['currentKey'] = $keyword;
        $view['filters'] = $this->getFilters();
        $view['orderBy'] = Input::get('orderBy', self::BEST_MATCH);
        $view['order'] =  Input::get('order', 'desc');
        $view['viewBy'] = Input::get('viewBy', 'default');
        $view['page'] = Input::get('page', 1);
        $view['per_page'] = Input::get('per_page', 20);
        $view["collection"] = Input::get("collection", "");

        $filters = $this->getFilters();
        $filters["page"] = $filters["page"]+1;
        $filters["viewBy"] = $viewBy;
        $view["nextQueryUrl"] = http_build_query($filters);

        $view['data']['collection_name'] = strip_tags($keyword);
        $content = $this->theme->scope('solrsearch.search-'.$viewBy.'-view', $view)->render()->getContent();
        return $content;
    }

    private function getProductsList($params = array())
    {

        setSeoMeta('search');
        $filters = $this->getFilters();

        $keyword = array_get($filters, "q", "");

        // If keyword contents any HTML, go to 404.
        if (is_html($keyword))
        {
            App::abort(404);
        }

        $keyword = $this->cleanParameter($keyword);
        $filters['q'] = $keyword;

        // create cache key for home page
        $cache_key = Request::url() . Lang::locale() .http_build_query($filters)."_SolrSearchAjax";

        // check cache result
        if ($this->noCache===false) {

            $cache_response = ElastiCache::getResult($cache_key, null);

            if (!empty($cache_response)){
                if(Input::has('debug-cache'))
                {
                    echo 'cache';
                }
                return $cache_response;
            }
        }

        $data = $this->product->solrSearch($filters);

        $view['data'] = $data;
        $view['type'] = 'search';

        ElastiCache::save($cache_key, $data, null, $this->cache_time);

        if(Input::has('debug-cache'))
        {
            echo 'no-cache';
        }

        return $data;
    }

}

