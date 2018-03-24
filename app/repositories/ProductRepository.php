<?php

class ProductRepository implements ProductRepositoryInterface {

    protected $pcmsClient;

    public function __construct()
    {
        $this->pcmsClient = App::make('pcms');
    }

    public function getByPkey($pkey, $other_params = array())
    {
        $nocache = Input::get('no-cache', false);
        $params = array();
        $type = 'GET';

        if(!empty($other_params['check_quota']))
        {
            $params['check_quota'] = 'Y';
        }

        if(!empty($other_params['nocache']))
        {
            $nocache = true;
        }

        $response = $this->pcmsClient->api("products/{$pkey}", $params, $type, $nocache);
        $product = $response['data'];

        return $product;
    }

    public function getBestSeller($collectionKey)
    {
        // Get all Best Seller product in collection via PCMS API
        $params = array();
        $response = $this->pcmsClient->api("collections/{$collectionKey}/bestseller", $params, 'GET');

        if ($response['status'] != 'success')
        {
            // return array('hits' => 0, 'results' => array());
            return FALSE;
        }

        return $response['data'];
    }

    public function search($params = array())
    {

        if (! empty($params['q']))
        {
            $params['q'] = preg_replace('#[^A-Za-z0-9ก-๙ ]+#u', '', $params['q']);
        }

        $qstrArr = $this->setParams($params);

        // Build Query String
        $qstr = "?" . http_build_query($qstrArr);

        $response = $this->pcmsClient->apiv2("products/search" . $qstr, array(), 'GET');

        if ($response['status'] != 'success')
        {
            return array('hits' => 0, 'results' => array());
        }

        return $response['data'];
    }

    private function setParams($params)
    {
        $perPage = (!empty($params['per_page']) && $params['per_page'] > 0) ? $params['per_page'] : 21 ;
        $page = (!empty($params['page']) && $params['page'] > 0) ? $params['page'] : 1 ;

        $limit = $perPage;
        $offset = ($page - 1) * $perPage;

        $qstrArr = array(
            'limit'         => $limit,
            'offset'        => $offset
        );

        if ( ! empty($params['q']))
        {
            $qstrArr['q'] = $params['q'];
        }

        if ( ! empty($params['collectionKey']))
        {
            $qstrArr['collectionKey'] = $params['collectionKey'];
        }

        if ( ! empty($params['brandKey']))
        {
            $qstrArr['brandKey'] = $params['brandKey'];
        }

        if ( ! empty($params['priceMax']))
        {
            $qstrArr['priceMax'] = $params['priceMax'];
        }

        if ( ! empty($params['priceMin']))
        {
            $qstrArr['priceMin'] = $params['priceMin'];
        }

        if ( ! empty($params['orderBy']))
        {
            $qstrArr['orderBy'] = $params['orderBy'];
        }

        if ( ! empty($params['order']))
        {
            $qstrArr['order'] = $params['order'];
        }

        if ( ! empty($params['campaign']))
        {
            $qstrArr['campaign'] = $params['campaign'];
        }

        if ( ! empty($params['trueyou']))
        {
            $qstrArr['trueyou'] = $params['trueyou'];
        }

        // This for help cache page ignoring.
        if ( ! empty($params['relate']))
        {
            $qstrArr['relate'] = 1; //$params['trueyou'];
        }

        return $qstrArr;
    }

    public function checkRemaining($inventory_id)
    {
        $response = $this->pcmsClient->api("inventories/{$inventory_id}/remaining");

        $remaining = array_get($response, 'data.remaining', false);

        if($remaining == false)
            return false;

        return $remaining;
    }

    public function getRemaining($inventory_id)
    {
        if ( empty($inventory_id) ) {
            return false;
        }

        $response = $this->pcmsClient->api("inventories/{$inventory_id}/remaining");
        if ( ! empty($response['data']['remaining'][$inventory_id]))
        {
            return $response['data']['remaining'][$inventory_id];
        }

        return FALSE;
    }

    public function solrSearch($params = array())
    {

//        if (! empty($params['q']))
//        {
//            $params['q'] = preg_replace('#[^A-Za-z0-9ก-๙ ]+#u', '', $params['q']);
//        }

        $qstrArr = $this->setParams($params);

        // Build Query String
        $qstr = "?" . http_build_query($qstrArr);

        $response = $this->pcmsClient->apiV5('search', $params, 'get');

        if ($response['message'] != 'success')
        {
            return array('hits' => 0, 'results' => array());
        }

        return $response;
    }
}