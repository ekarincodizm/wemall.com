<?php

class SolrSearchController extends FrontBaseController
{

    const BEST_MATCH = "best_match";
    const EN = "en";
    private $pcms;
    private $cache_time = 2;
    private $noCache;
    private $solrSearchRepo;
    private $lang;


    public function __construct(SolrSearchRepositoryInterface $solrSearchRepo)
    {
        parent::__construct();

        $this->theme->layout('angular-template');
        $this->pcms = App::make('pcms');
        $no_cache = Input::get('no-cache', false);
        $this->noCache = !empty($no_cache);
        $this->solrSearchRepo = $solrSearchRepo;
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
                $filters['cat_lv1_th'] = $categoryName;
            } else {
                $filters['cat_lv1_en'] = $categoryName;
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
        $filters["per_page"] = intval(Input::get("per_page", 21));

        return $filters;
    }

    private function cleanParameter($keyword)
    {
        $keyword = trim($keyword);
        $keyword = strip_tags(urldecode($keyword));

        return $keyword;
    }

    private function validateParameters($filters)
    {
        $validationRules = array(
            "priceMax" => "numeric",
            "priceMin" => "numeric",
            "order" => "in:asc,desc",
            "payment_ccw" => "in:1,0",
            "payment_installment" => "in:1,0",
            "payment_bank_transfer" => "in:1,0",
            "payment_atm" => "in:1,0",
            "payment_cs" => "in:1,0",
            "payment_cod" => "in:1,0",
            "payment_internet_banking" => "in:1,0",
            "payment_over_the_counter" => "in:1,0",
            "page" => "integer|min:1",
            "per_page" => "integer|min:1"
        );

        return Validator::make($filters, $validationRules);
    }

    public function getIndex()
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

        $this->theme->setTitle("Search " . $filters['q']);
        $this->theme->setMetadescription(__('seo_description_home'));
        $this->theme->setMetakeywords(__('seo_keyword_home'));
        $content = $this->theme->scope('products.level-c-solr')->render();
        ElastiCache::save($cachedKey, $content, null, $this->cache_time);

        return $content;
    }

    public function getAutoSuggestion ()
    {
        $q = Input::get('q', '');
        $q = trim($q);

        // create cache key
        $cache_key = $this->getCacheKey($q);

        // check cache
        if ($this->noCache===false) {
            $cache_response = ElastiCache::getResult($cache_key, null);

            if (!empty($cache_response)) {
                return Response::json($cache_response, 200);
            }
        }

        // get auto suggestion data
        $response = $this->solrSearchRepo->getAutoSuggestion($q);

        // save cache
        ElastiCache::save($cache_key, $response, null, $this->cache_time);

        return Response::json($response, 200);
    }

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

    public function getSearch()
    {
        try {
            $filters = $this->getFilters();

            $keyword = array_get($filters, "q", "");
            if (is_html($keyword)) {
                throw new Exception("Input Error: HTML Tags are not allowed.", 400);
            }

            $filters["q"] = $this->cleanParameter(array_get($filters, "q", ""));
            $validator = $this->validateParameters($filters);

            if ($validator->fails()) {
                $messages = $validator->messages()->first();
                throw new Exception($messages, 400);
            }

            $uniqueCacheKey = http_build_query($filters);
            $cachedKey = $this->getCacheKey($uniqueCacheKey);

            if ($this->noCache === false) {
                $cachedResponse = ElastiCache::getResult($cachedKey, null);

                if (!empty($cachedResponse)) {
                    $cachedResponse = json_decode($cachedResponse, true);

                    return Response::json($cachedResponse);
                }

            }

            $response = $this->pcms->apiV5('search', $filters, 'get');

            if (isset($response["code"]) && $response["code"] == 200) {
                ElastiCache::save($cachedKey, json_encode($response), null, $this->cache_time);

                return Response::json($response);
            } else {
                $ref_id = isset($response["ref_id"]) ? $response["ref_id"] : "-";
                throw new Exception("Exception: PCMS status is not 200 (ref_id: {$ref_id})", 500);
            }

        } catch (Exception $e) {
            $response = array(
                "code" => $e->getCode() ?: 500,
                "message" => $e->getMessage() ?: "Exception: Internal Logic Error"
            );

            return Response::json($response);
        }
    }

}

