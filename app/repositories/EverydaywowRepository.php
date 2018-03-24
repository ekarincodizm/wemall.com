<?php

class EverydaywowRepository implements EverydaywowRepositoryInterface
{

    /**
     * @var int
     */
    protected $page;

    /**
     * @var string { asc, desc }
     */
    protected $sortby;

    /**
     * @var string { discount_start, price, discount }
     */
    protected $orderby;

    /**
     * @var string
     */
    protected $filter;

    /**
     * @var array
     */
    protected $response;

    /**
     * @var pcmsClient
     */
    protected $pcmsClient;

    /**
     * @var bool
     */
    protected $nocache;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var string
     */
    protected $lang;

    /**
     * Website: 6
     * Mobile: 4
     *
     * @var int
     */
    protected $limit = 6;

    protected $order;

    protected $orderBy;

    public function __construct()
    {
        $this->pcmsClient = App::make('pcms');
    }

    /**
     * @param array $options
     * @return array
     */
    public function getData($options = array())
    {
        
        $this->lang         = array_get($options, 'lang', 'th');
        $this->nocache      = array_get($options, 'nocache', false);
        $this->page         = array_get($options, 'page', 1);
        $this->limit        = array_get($options, 'limit', 6);
        $this->filter       = array_get($options, 'filter', 'all');
        $this->sortby       = array_get($options, 'sortby', 'published_at');
        $this->orderby      = array_get($options, 'orderby', 'desc');
        $this->response     = array_get($options, 'response', '');
        
        try {
            $this->validateParams();

            $response = $this->pcmsClient->apiV5('everyday-wow/list-product', $this->getParams(), 'GET', $this->nocache);

            $response_code = array_get($response, 'code', false);

            if ($response_code!=200) {
                throw new Exception("Not found data.", 400);
            }
            
            return $this->parseData($response);
        } catch (Exception $e) {
            return array(
                "code" => $e->getCode(),
                "status" => "error",
                "message" => $e->getMessage()
            );
        }
    }

    protected function validateParams()
    {
        $rules = array(
            "lang" => "required",
            "page" => "required|min:1",
            "limit" => "required",
            "sortby" => "required|in:published_at,price,discount",
            "orderby" => "required|in:asc,desc",
            // "response" => "required|string",
        );

        $validator = Validator::make($this->getParams(), $rules);

        if($validator->fails()){
            throw new Exception($validator->messages()->first(), 400);
        }
      
    }

    /**
     * @return array
     */
    protected function getParams()
    {
        return array(
            'lang'      => $this->lang,
            'page'      => $this->page,
            'limit'     => $this->limit,
            'filter'    => $this->filter,
            'sortby'    => $this->sortby,
            'orderby'   => $this->orderby,
            'response'  => $this->response,
        );
    }

    /**
     * @param $raw_data
     * @return array
     */
    private function parseData($raw_data)
    {
        if(empty($raw_data)){
            return array();
        }
        foreach ($raw_data['data']['product_data'] as $key => $product) {
            
            $raw_data['data']['product_data'][$key]['tagIcon'] = empty($product['discount_title']) ? 'label-red-1.png' : 'label-red-2.png';
            $raw_data['data']['product_data'][$key]['discount_icon'] = array_get($product, 'discount_icon', 'none');
            
            switch ($raw_data['data']['product_data'][$key]['discount_icon']) {
                case 'none':
                    $raw_data['data']['product_data'][$key]['tagCls'] = 'label-red';
                    $raw_data['data']['product_data'][$key]['isLineCampaign'] = false;
                    break;
                case 'tmvh':
                    $raw_data['data']['product_data'][$key]['tagCls'] = 'label-green';
                    $raw_data['data']['product_data'][$key]['isLineCampaign'] = true;
                    $raw_data['data']['product_data'][$key]['tagIcon'] = 'label-green-1.png';
                    $raw_data['data']['product_data'][$key]['logo'] = 'line-truemove.png';
                    $raw_data['data']['product_data'][$key]['descriptionLogo'] = 'iTruemart line truemove';
                    break;
                case 'trueu':
                    $raw_data['data']['product_data'][$key]['tagCls'] = 'label-green';
                    $raw_data['data']['product_data'][$key]['isLineCampaign'] = true;
                    $raw_data['data']['product_data'][$key]['tagIcon'] = 'label-green-1.png';
                    $raw_data['data']['product_data'][$key]['logo'] = 'line-trueyou.png';
                    $raw_data['data']['product_data'][$key]['descriptionLogo'] = 'iTruemart line trueyou';
                    break;
                default:
                    $raw_data['data']['product_data'][$key]['tagCls'] = 'label-red';
                    $raw_data['data']['product_data'][$key]['isLineCampaign'] = false;
                    break;
            }

            $normal_price = array_get($product,'normal_price', 0);
            $special_price = array_get($product,'special_price', 0);

            $raw_data['data']['product_data'][$key]['normal_price'] = number_format($normal_price);
            $raw_data['data']['product_data'][$key]['special_price'] = number_format($special_price);

            $raw_data['data']['product_data'][$key]['title'] = array_get($product,'product_title','');
            $raw_data['data']['product_data'][$key]['pkey'] = array_get($product,'product_pkey','');
            $raw_data['data']['product_data'][$key]['slug'] = array_get($product, 'product_slug','');
            $raw_data['data']['product_data'][$key]['mobile_image'] = array_get($product,'default_image.xl','');
            $raw_data['data']['product_data'][$key]['web_image'] = array_get($product,'default_image.l','');
            $raw_data['data']['product_data'][$key]['product_url'] = get_permalink('products',$raw_data['data']['product_data'][$key]);
        }

        $raw_data['data']['params']['sortby'] = $this->sortby;
        $raw_data['data']['params']['orderby'] = $this->orderby;

        return $raw_data;
    }

}