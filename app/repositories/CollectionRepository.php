<?php

class CollectionRepository implements CollectionRepositoryInterface {

    protected $pcmsClient;

    public function __construct()
    {
        $this->pcmsClient = App::make('pcms');
    }

    public function getAll($depth = 0, $isCategory = 1)
    {
        // Get all collections via PCMS API
        $params = array(
            'depth'       => $depth,
            'is_category' => $isCategory
        );

        $response = $this->pcmsClient->api("collections", $params, 'GET');
        $responseData = $response['data'];

        return $responseData;
    }

    // Get Collection Detail by Pkey
    public function getByPkey($pkey)
    {
        $params = array();
        $response = $this->pcmsClient->api("collections/{$pkey}", $params, 'GET');

        $responseData = $response['data'];

        return $responseData;
    }

    // Get Brands in Collections
    public function getBrands($pkey)
    {
        // Get all brands in this collection via PCMS API
        $params = array();
        $response = $this->pcmsClient->api("collections/{$pkey}/brands", $params, 'GET');
        $responseData = $response['data'];

        return $responseData;
    }

    public function getFlashsaleCollections()
    {
        $params = array();
        $response = $this->pcmsClient->api("collections/flash-sale", $params, 'GET');
        $responseData = $response['data'];

        return $responseData;
    }

    public function getDiscountCollections()
    {
        $params = array();
        $response = $this->pcmsClient->api("collections/discount", $params, 'GET');
        $responseData = $response['data'];

        return $responseData;
    }

    public function getItruemartTvCollections()
    {
        $params = array();
        $response = $this->pcmsClient->api("collections/itruemart-tv", $params, 'GET');
        $responseData = $response['data'];

        return $responseData;
    }

    public function getTrueyouCollections()
    {
        $params = array();
        $response = $this->pcmsClient->api("collections/trueyou", $params, 'GET');
        $responseData = $response['data'];

        return $responseData;
    }

	/* Get App Category for Category Top Menu (Super Deal) */
    public function getAppCategoryTopMenu()
    {
        try {
            $category = Config::get('widget_params.category_top_menu');
            $url = Config::get('endpoints.pcms.url') . '/' . Config::get('endpoints.pcms.appKey') . '/app-categories?category_id='.$category;

            $curl = new Curl();
            $curl->create($url);
            $curl->option(CURLOPT_BUFFERSIZE, 51024);
            $curl->option(CURLOPT_TIMEOUT, 120);
            $response = $curl->execute();

            if ($response) {
                $res = json_decode($response, true);
            }

            if (isset($res['code']) && $res['code'] == 200) {
                return $res['data'];
            } else {
                throw new Exception("Not found data.", 400);
            }
        } catch (Exception $e) {
            $return = array(
                "code" => $e->getCode(),
                "status" => "error",
                "message" => $e->getMessage()
            );

            return $return;
        }
    }
}