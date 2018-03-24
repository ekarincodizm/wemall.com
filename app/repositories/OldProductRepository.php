<?php

class OldProductRepository implements ProductRepositoryInterface {

    protected $pcmsClient;

    public function __construct()
    {
        $this->pcmsClient = App::make('pcms');
    }

    /*
    public function getByProductPkey($pkey)
    {
        $cacheKey = "product_{$pkey}";
        $timeout = 1;

        $product = Cache::remember($cacheKey, $timeout, function() use($pkey) {
            // echo 'No Cache, Get Product Data from PCMS API';
            $response = PCMSApi::get("products/{$pkey}");
            return $response['data'];
        });

        return $product;
    }
    */

    public function getByCollectionPkey($collectionKey, $page = 1, $limit = 20)
    {
        /*
        // ดึงจาก Cache ให้ได้ก่อน .... ถ้าไม่ได้ ค่อยส่ง Request ไป
        $cacheKey = "collection_products_page{$page}_limit{$limit}";
        if (Cache::has($cacheKey))
        {
            $responseData = Cache::get($cacheKey);
            return $responseData;
        }
        */

        // Parameter (Paginate)
        $params = array(
            'page'  => $page,
            'limit' => $limit
        );

        // ดึง product ใน collection
        // $response = PCMSApi::get("collections/{$collectionKey}/products", $params);
        $response = $this->pcmsClient->api("collections/{$collectionKey}/products", $params, 'GET');
        $responseData = $response['data'];

        /*
        // Cache ผลลัพท์ ก่อนที่จะ Return ด้วย
        if (!empty($responseData))
        {
            $timeout = 5;
            Cache::add($cacheKey, $responseData, $timeout);
        }
        */

        return $responseData;
    }

    public function getByBrandPkey($brandKey, $page = 1, $limit = 20)
    {
        // Parameter (Paginate)
        $params = array(
            'page'  => $page,
            'limit' => $limit
        );

        // ดึง product ใน brand
        $response = $this->pcmsClient->api("brands/{$brandKey}/products", $params, 'GET');
        $responseData = $response['data'];

        return $responseData;
    }

    /*
    public function checkRemaining($inventory_id)
    {
        $cacheKey = "remaining{$inventory_id}";
        if(Cache::has($cacheKey))
            return Cache::get($cacheKey);


        $response = PCMSApi::get("inventories/{$inventory_id}/remaining");
        $remaining = array_get($response, 'data.remaining', false);

        if($remaining == false)
            return false;

        Cache::put($cacheKey, 10, $remaining);
        return $remaining;
    }
    */

    public function search($params = array())
    {
        // $params = array(
        //     'q'             => '',
        //     'per_page'      => '',
        //     'page'          => '',
        //     'collectionKey' => '',
        //     'brandKey'      => '',
        // );

        if (empty($params['q']))
        {
            return array('hits' => 0, 'results' => array());
        }

        $perPage = (!empty($params['per_page']) && $params['per_page'] > 0) ? $params['per_page'] : 20 ;
        $page = (!empty($params['page']) && $params['page'] > 0) ? $params['page'] : 1 ;

        $limit = $perPage;
        $offset = ($page - 1) * $perPage;

        $qstrArr = array(
            'q'             => $params['q'],
            'limit'         => $limit,
            'offset'        => $offset
        );

        if (!empty($params['collectionKey']))
        {
            $qstrArr['collectionKey'] = $params['collectionKey'];
        }

        if (!empty($params['brandKey']))
        {
            $qstrArr['brandKey'] = $params['brandKey'];
        }

        // Build Query String
        $qstr = "?" . http_build_query($qstrArr);

        // Request to API Search Product at PCMS.
        // $response = PCMSApi::get("products/search" . $qstr);
        $response = $this->pcmsClient->api("products/search" . $qstr);

        if ($response['status'] != 'success')
        {
            return array('hits' => 0, 'results' => array());
        }

        return $response['data'];
    }

}