<?php

class NewsRepository implements NewsRepositoryInterface
{

    protected $pcmsClient;

    public function __construct()
    {
        $this->itruemart = App::make('itruemart');
    }

    public function getNewsList($params = NULL)
    {
        $params['condition'] = (!empty($params['condition'])) ? $params['condition'] : 'all';
        $params['order_by']  = (!empty($params['order_by'])) ? $params['order_by'] : "create_date desc";
        $params['format']    = (!empty($params['format'])) ? $params['format'] : 'json';
        $params['cat_id']    = (!empty($params['cat_id'])) ? $params['cat_id'] : 0;

        try
        {
            $responseData = $this->itruemart->api('news/listing', $params, 'get');
        }
        catch ( Exception $e )
        {
            throw new Exception($e->getMessage());
        }

        return $responseData->getRawResponse();
    }

    public function getNewsGroup($params = NULL)
    {
        $params['condition'] = (!empty($params['condition'])) ? $params['condition'] : 'group';
        $params['format']    = (!empty($params['format'])) ? $params['format'] : 'json';
        $params['cat_id']    = (!empty($params['cat_id'])) ? $params['cat_id'] : 0;

        try
        {
            $responseData = $this->itruemart->api('news/listing', $params, 'get');
        }
        catch ( Exception $e )
        {
            throw new Exception($e->getMessage());
        }

        return $responseData->getRawResponse();
    }

    public function getByCategory($categoryId = NULL)
    {
        $params = array(
            'condition' => 'category',
            'order_by'  => 'create_date desc',
            'format'    => 'json',
            'cat_id'    => $categoryId
        );

        $responseData = $this->itruemart->api('news', $params);

        return $responseData;
    }

    public function getInsight($limit = 3, $order_by = 'create_date desc')
    {
        $return = array();
        $params = array(
            'cat_name'  => 'announcement',
            'cat_id'    => 0,
            'page'      => 1,
            'limit'     => $limit,
            'condition' => 'all',
            'order_by'  => $order_by,
            'format'    => 'json'
        );

        $url_news  = Config::get('url_manager.url_news');
        $curl_data = $this->itruemart->execCurl($url_news, $params, 'get');

        if ( !empty($curl_data) )
        {
            $data = json_decode($curl_data, true);
            if ( !empty($data['data_response']) )
            {
                $return = $data['data_response'];
            }
        }

        return $return;
    }

    public function getAllInsight($cat_id = 0)
    {
        $return = array();
        $params = array(
            'cat_id'    => $cat_id,
            'page'      => 1,
            'limit'     => 2,
            'condition' => 'category',
            'order_by'  => 'create_date desc',
            'format'    => 'json'
        );

        $url_news  = Config::get('url_manager.url_news');
        $curl_data = $this->itruemart->execCurl($url_news, $params, 'get');
        
        if ( !empty($curl_data) )
        {
            $data = json_decode($curl_data, true);
            if ( !empty($data['data_response']) )
            {
                $return = $data['data_response'];
            }
        }

        return $return;
    }

    public function getDetail($news_id = '')
    {
        $return = array();
        $params = array(
            'news_id' => $news_id,
            'format'  => 'json'
        );

        $url_news  = Config::get('endpoints.itruemart.endpointUrl') . '/news/detail';
        $curl_data = $this->itruemart->execCurl($url_news, $params, 'get');
        
        if ( !empty($curl_data) )
        {
            $data = json_decode($curl_data, true);
            if ( !empty($data['data_response']) )
            {
                $return = $data['data_response'];
            }
        }

        return $return;
    }

}