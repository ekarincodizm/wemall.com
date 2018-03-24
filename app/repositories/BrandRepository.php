<?php

class BrandRepository implements BrandRepositoryInterface {

    protected $pcmsClient;

    public function __construct()
    {
        $this->pcmsClient = App::make('pcms');
    }

    // Get Brand Detail by Pkey
    public function getByPkey($pkey)
    {
        // Get all brands via PCMS API
        $params = array();
        $response = $this->pcmsClient->apiv2("brands/{$pkey}", $params, 'GET');
        $responseData = empty($response['data']) ? array() : $response['data'] ;

        return $responseData;
    }

    // Get all Brands
    public function getAll()
    {
        // Get all brands via PCMS API
        $params = array();
        $response = $this->pcmsClient->apiv2("brands", $params, 'GET');
        $responseData = empty($response['data']) ? array() : $response['data'] ;

        return $responseData;
    }

    // Get Brands that have flash sale
    public function getFlashsaleBrands()
    {
        // Get via PCMS API
        $params = array();
        $response = $this->pcmsClient->api("brands/flash-sale", $params, 'GET');
        $responseData = empty($response['data']) ? array() : $response['data'] ;

        return $responseData;
    }

    // Get Brands that have itruemart TV Campaign
    public function getItuemartTvBrands()
    {
        // Get via PCMS API
        $params = array();
        $response = $this->pcmsClient->api("brands/itruemart-tv", $params, 'GET');
        $responseData = empty($response['data']) ? array() : $response['data'] ;

        return $responseData;
    }

    // Get Brands that have Discount
    public function getDiscountBrands()
    {
        // Get via PCMS API
        $params = array();
        $response = $this->pcmsClient->api("brands/discount", $params, 'GET');
        $responseData = empty($response['data']) ? array() : $response['data'] ;

        return $responseData;
    }

    // Get Brands that have Trueyou Discount
    public function getTrueyouBrands()
    {
        // Get via PCMS API
        $params = array();
        $response = $this->pcmsClient->api("brands/trueyou", $params, 'GET');
        $responseData = empty($response['data']) ? array() : $response['data'] ;

        return $responseData;
    }

    public function rearrange( $rawBrands )
    {
        $brands = array();

        foreach ($rawBrands as $brand)
        {
            if (preg_match('!^[ก-์]!', $brand['name']))
            {
                $firstAlphabet = mb_substr($brand['name'], 0, 1);
                $brands[$firstAlphabet][] = $brand;
            }
            else if (preg_match('!^[A-Za-z]!', $brand['name']))
            {
                $firstAlphabet = strtolower(substr($brand['name'], 0, 1));
                $brands[$firstAlphabet][] = $brand;
            }
            else
            {
                $brands['others'][] = $brand;
            }
        }

        return $brands;
    }

}