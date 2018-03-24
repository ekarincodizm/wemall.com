<?php

class SuperDealRepository implements SuperDealRepositoryInterface
{

    protected $pcmsClient;

    public function __construct()
    {
        $this->pcmsClient = App::make('pcms');

    }

    public function getAnyProduct($data)
    {
        try{  
            $rules = array(
                "campaign" => "in:all,today_special,flash_sale,itruemart_tv,on_sale",
                "page" => "integer",
                "limit" => "integer",
                "orderBy" => "in:published_at,price,discount,discount_ended,discount_started",
                "order" => "in:asc,desc"
            );

            // $rules = array(
            //     "filter" => "array",
            //     "page" => "integer",
            //     "sortby" => "array",
            //     "orderby" => "in:asc,desc",
            //     "response" => "array"
            // );
          
            $validator = Validator::make($data, $rules);

            if($validator->fails()){
                throw new Exception($validator->messages()->first(), 400);
            }
            
            // if(empty($data['filter'])){
            //     throw new Exception( 'input not found filter', 400);
            // }
            
            $nocache = Input::get('no-cache', false);

            // $sortBy[] = 'published_at';

            // $data['sortby'] = array_get($data, 'sortby', $sortBy);

            // $data['orderby'] = array_get($data, 'orderby', 'desc');
            
            $res = $this->pcmsClient->apiv2("discount-campaigns/list-product", $data, 'GET', $nocache);

            if(isset($res['code']) && $res['code'] == 200){
                $res['data'] = $this->parseData($res['data']);
                return $res;
            }else{
                throw new Exception("Not found data.", 400);
            }

        }catch(Exception $e){
            return array(
                "code" => $e->getCode(),
                "status" => "error",
                "message" => $e->getMessage()
            );
        }
    }

    public function getDiscountToday($params)
    {
        return $this->getDiscountProduct($params);
    }

    public function getDiscountIncoming($params)
    {
        return $this->getDiscountProduct($params);
    }

	public function getDiscountProduct($params)
	{
		try{
            $rules = array(
                "campaign" => "in:all,today_special,flash_sale,itruemart_tv,on_sale",
                "date" => "required",
                "date_rule" => "in:all,current,incoming,ended",
            );

            $validator = Validator::make($params, $rules);

            if($validator->fails()){
                throw new Exception($validator->messages()->first(), 400);
            }

            $nocache = Input::get('no-cache', false);
            $res = $this->pcmsClient->apiv2("discount-campaigns/single-product", $params, 'GET', $nocache);

            if(isset($res['code']) && $res['code'] == 200){
                return $res;
            }else{
                throw new Exception("Not found data.", 400);
            }

        }catch(Exception $e){
            return array(
                "code" => $e->getCode(),
                "status" => "error",
                "message" => $e->getMessage()
            );
        }
	}

    public function parseData($productsWow){
        
        if(empty($productsWow)){
            return array();
        }

        $newProducstWow = array();

        foreach ($productsWow['products'] as $key => $product) {
            $newProducstWow['products'][$key]['pkey'] = array_get($product,'pkey');
            $newProducstWow['products'][$key]['title'] = array_get($product,'title');
//            if(empty($newProducstWow['products'][$key]['title'])) {
//                $newProducstWow['products'][$key]['title'] = array_get($product,'translate.title');
//            }

            $newProducstWow['products'][$key]['slug'] = array_get($product,'slug');
            $newProducstWow['products'][$key]['translate']['title'] = array_get($product,'translate.title');
            if(empty($newProducstWow['products'][$key]['translate']['title'])) {
                $newProducstWow['products'][$key]['translate']['title'] = array_get($product,'title');
            }

            $newProducstWow['products'][$key]['price_range'] = array_get($product,'price_range');
            $newProducstWow['products'][$key]['net_price_range'] = array_get($product,'net_price_range');
            $newProducstWow['products'][$key]['percent_discount'] = array_get($product,'percent_discount');
            $newProducstWow['products'][$key]['discount_ended'] = array_get($product,'discount_ended');
            $newProducstWow['products'][$key]['variants'] = $this->getVariants($product['variants']);
        }

        return $newProducstWow;
    }

    public function getVariants($variants){
        $newVariants = array();
        foreach ($variants as $key => $variant) {
            $newVariants[$key]['active_special_discount'] = array_get($variant,'active_special_discount');
        }
        return $newVariants;
    }

}
