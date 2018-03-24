<?php

class CartController extends FrontBaseController {

    private $pcms;

    public function __construct(ProductRepositoryInterface $product)
    {
        parent::__construct();
        $this->product = $product;

        $this->pcms = App::make('pcms');
    }

    public function getIndex()
    {
        $response = $this->pcms->getCart();


        return Response::json(array('status' => $response['status'], 'data' => $response['data']), 200);
    }

    public function postAddItem()
    {
        $user = ACL::getUser();

        $data = array(
            'customer_ref_id' => $user['user_id'],
            'customer_type' => (ACL::isLoggedIn()) ? 'user' : 'non-user',
            'inventory_id' => Input::get('inventory_id'),
            'qty' => Input::get('qty'),
            'type' => Input::get('type', 'normal')
        );

        $response = $this->pcms->api('cart/add-item', $data, 'POST');

        $message = (stripos(@$response['message'], "No Stock Remaining.") !== false) ? "No Stock Remaining." : @$response['message'];

        $message = (stripos(@$response['message'], "item-already-in-cart-limit-1-item") !== false) ? @$response['message'] : @$response['message'];

        $meta = array(
            'browse:level_d',
            'clicked:add_to_cart'
        );
        $user = ACL::getUser();
        $transaction_id = Session::get('transaction_id');


        $log_datas = array(
            'UserIPAddress' => Request::server('HTTP_X_FORWARDED_FOR'),
            'ServerIPAddress' => Request::server('SERVER_ADDR'),
            'UserCookieId' => $transaction_id,
            'UserId' => $user['user_id'],
            'Email' => $user['email'],
            'ExecutionTime' => date("Y-m-d H:i:s"),
            'Tags' => array(
                'tag:level_d',
                'tag:check_variant',
                'tag:check_stock',
                'tag:add_to_cart'
            ),
            'EventID' => 'add_to_cart',
            'Meta' => $meta
        );
        #alert($log_datas, 'red');
        #exit;
        $gearmanRepo = App::make('GearmanRepository');
        $gearmanRepo->addQueue($log_datas);

        return Response::json(array('status' => $response['status'], 'data' => $response['data'], 'message' => $message), 200);
    }

    public function postAddItemV2()
    {
        $user = ACL::getUser();

        $data = array(
            'customer_ref_id' => $user['user_id'],
            'customer_type' => (ACL::isLoggedIn()) ? 'user' : 'non-user',
            'inventory_id' => Input::get('inventory_id'),
            'qty' => Input::get('qty'),
            'type' => Input::get('type', 'normal')
        );

        $response = $this->pcms->apiv2('cart/add-item', $data, 'POST', true, 0, 2);


        // $message = (stripos(@$response['message'], "No Stock Remaining.") !== false) ? "No Stock Remaining." : @$response['message'];
        if (@$response['message'] == 'out_of_quota_wow')
        {
            $message = __("out_of_quota_wow");
        }
        else if (strpos(@$response['message'], "No Stock Remaining.") !== FALSE)
        {
            $message = __("out_of_stock");
        }
        else{
            $message = @$response['message'];
        }

        $meta = array(
            'browse:level_d',
            'clicked:add_to_cart'
        );
        $user = ACL::getUser();
        $transaction_id = Session::get('transaction_id');


        $log_datas = array(
            'UserIPAddress' => Request::server('HTTP_X_FORWARDED_FOR'),
            'ServerIPAddress' => Request::server('SERVER_ADDR'),
            'UserCookieId' => $transaction_id,
            'UserId' => $user['user_id'],
            'Email' => $user['email'],
            'ExecutionTime' => date("Y-m-d H:i:s"),
            'Tags' => array(
                'tag:level_d',
                'tag:check_variant',
                'tag:check_stock',
                'tag:add_to_cart'
            ),
            'EventID' => 'add_to_cart',
            'Meta' => $meta
        );
        #alert($log_datas, 'red');
        #exit;
        $gearmanRepo = App::make('GearmanRepository');
        $gearmanRepo->addQueue($log_datas);

        return Response::json(array('status' => $response['status'], 'data' => $response['data'], 'message' => $message), 200);
    }

    public function postRemoveItem()
    {
        $user = ACL::getUser();

        $data = array(
            'customer_ref_id' => $user['user_id'],
            'customer_type' => (ACL::isLoggedIn()) ? 'user' : 'non-user',
            'inventory_id' => Input::get('inventory_id')
        );

        $response = $this->pcms->api('cart/remove-item', $data, 'POST');

        return Response::json(array('status' => $response['status'], 'data' => $response['data']), 200);
    }

    public function postRemoveItems(){
        $user = ACL::getUser();

        $data = array(
            'customer_ref_id' => $user['user_id'],
            'customer_type' => (ACL::isLoggedIn()) ? 'user' : 'non-user',
            'inventory_ids' => trim(Input::get('inventory_ids', ""), ",")
        );
        $response = $this->pcms->apiv2('cart/remove-items', $data, 'POST', true, 0, 2);

        return Response::json(array("code"=> $response["code"], 'status' => $response['status'], 'data' => $response['data']), 200);
    }

    public function postAddCoupon()
    {
        $code = Input::get('code');
        $lang = Lang::getLocale();
        if (!$code)
        {    
            $response['status'] = "fail";
            if($lang == 'en'){
                $response['data'] = "Please enter voucher.";
            }
            else{
                $response['data'] = "กรุณาพิมพ์รหัสคูปองพิเศษ";
            }
            return Response::json(array(
                'status' => $response['status'], 
                'data' => $response['data'],
                'code' => '4001'
            ), 200);
        }

        $response = $this->pcms->postApplyCoupon($code);
       
        if ($response['status'] == 'success')
        {

            return Response::json(array(
                'code' => '200',
                'status' => 'success',
                'data' => '' 
            ), 200);
        } else
        {
            $errorCode = array_get($response, 'data.errorCode');
            switch ($errorCode) {

                case '4001':
                    $errorMessage = array(
                        'en' =>  'Please enter voucher.',
                        'th' =>  'กรุณาพิมพ์รหัสคูปองพิเศษ'
                        );
                    break;

                case '4101':
                    $errorMessage = array(
                        'en' =>  'Voucher is expired.',
                        'th' =>  'รหัสคูปองพิเศษหมดอายุแล้ว'
                        );
                    break;

                case '4102':
                    $errorMessage = array(
                        'en' =>  'Voucher is incorrect.',
                        'th' =>  'รหัสคูปองพิเศษไม่ถูกต้อง'
                        );
                    break;

                case '4111':
                    $errorMessage = array(
                        'en' =>  'Vouchers are out of stock.',
                        'th' =>  'รหัสคูปองพิเศษถูกใช้หมดแล้ว'
                        );
                    break;

                case '4112':
                    $errorMessage = array(
                        'en' =>  'Voucher cannot be used with your order',
                        'th' =>  'คูปองพิเศษไม่สามารถใช้ร่วมกับสินค้าที่คุณสั่งซื้อ'
                        );
                    break;

                case '4113':
                    $errorMessage = array(
                        'en' => 'Voucher is already used.',
                        'th' => 'รหัสคูปองพิเศษนี้ถูกใช้ไปแล้ว'
                        );
                    break;

                case '4114':
                    // $originalErrorMessage = array_get($response, 'data.errorMessage');
                    // preg_match("#\(([0-9]+)\)#", $originalErrorMessage, $matches);
                    // $minimumPrice = number_format(array_get($matches, 1, 0));
                    // $errorMessage = array(
                    //     'en' => "Voucher cannot be used. Minimum order must have at least {$minimumPrice} baht.",
                    //     'th' => "รหัสคูปองพิเศษนี้ไม่สามารถใช้ได้ ยอดสั่งซื้อขั้นต่ำต้องไม่น้อยกว่า {$minimumPrice} บาท"
                    //     );
                    $errorMessage = array(
                        'en' => 'Cannot use voucher because these coupon is not accepted under the conditions.',
                        'th' => 'คุณไม่สามารถใช้รหัสคูปองได้ เนื่องจากยอดรวมทั้งตะกร้าหรือมูลค่าสินค้าขั้นต่ำ ไม่ตรงตามเงื่อนไขการใช้คูปอง'
                        );
                    break;
                case '4115':
                    $errorMessage = array(
                        'en' => 'Cannot use coupon because these coupon is not accepted under the conditions.',
                        'th' => 'คุณไม่สามารถใช้รหัสคูปองได้ เนื่องจากบัตรเครดิตไม่ตรงตามเงื่อนไขการใช้คูปอง'
                    );
                    break;
                default:
                    $errorMessage = array(
                        'en' =>  'Vouchers cannot be used for temporarily',
                        'th' =>  'ไม่สามารถใช้รหัสคูปองพิเศษได้ชั่วคราว'
                        );
                    break;
            }
            return Response::json(array(
                'status' => 'fail', 
                'data' => $errorMessage[$lang],
                'code' => $errorCode
            ), 200);
        }
    }

    public function postRemoveCoupon()
    {
        $user = ACL::getUser();

        $data = array(
            'customer_ref_id' => $user['user_id'],
            'customer_type' => (ACL::isLoggedIn()) ? 'user' : 'non-user',
            'code' => Input::get('code')
        );

        $response = $this->pcms->api('cart/remove-coupon', $data, 'POST');

        return Response::json(array(
            'status' => $response['status'], 
            'data' => $response['data']
        ), 200);
    }

    public function postApplyTrueyou(){
        try{
           $rule = array('thai_id' => 'required|numeric|digits_between:13,13');
           $validator = Validator::make(Input::all(), $rule);
           if ($validator->fails()){
                throw new Exception($validator->messages()->first(), 400);
            }

            $user = ACL::getUser();
            $id_card = Input::get('thai_id');

            $data = array(
                'customer_ref_id' => $user['user_id'],
                'customer_type' => (ACL::isLoggedIn()) ? 'user' : 'non-user',
                'thai_id' => $id_card
            );

            $trueyou_result = $this->pcms->getCheckTrueyouByIdCard($id_card);
            $card = array_get($trueyou_result, 'data.card');

            if (!empty($card))
            {
                if(\ACL::isLoggedIn()){
                    //store trueyou to member
                    $apply_result = $this->pcms->postApplyTrueyouCard($id_card);

                    //run apply trueyou for discount
                    //$apply_result = $this->pcms->applyTrueyouToCart($id_card);
                }else{
                    $apply_result = $this->pcms->applyTrueyouToCart($id_card);
                }
                Session::put('profile.thai_id', $id_card);
                Session::put('profile.trueyou', $card);

                if($apply_result['code'] == 200){
                    return Response::json(array('code' => $apply_result['code'], 'status' => $apply_result['status'], 'data' => $apply_result['data']), 200);
                }else{
                    return Response::json(array('code' => $apply_result['code'], 'status' => $apply_result['status'], 'message' => $apply_result['message']), 200);
                }

            }else{
                throw new Exception('หมายเลขบัตรไม่ถูกต้อง', 400);
            }

        }catch(Exception $e){
            return Response::json(array(
                'status' => $e->getCode(),
                'message'=>$e->getMessage(),
                'data' => array()), 200);
        }
    }

    public function postSetCartType(){
        $user = ACL::getUser();

        $data = array(
            'customer_ref_id' => $user['user_id'],
            'customer_type' => (ACL::isLoggedIn()) ? 'user' : 'non-user',
            'type' => Input::get('type', "")
        );

        $response = $this->pcms->apiv2('checkout/set-type', $data, 'POST', true, 0, 2);

        return Response::json(array(
            "code"=> $response["code"],
            'status' => $response['status'],
            'data' => $response['data']), 200);
    }

    /**
     * Point of this function is genarating an array that contains inventory id of variant of current product and
     * inventory id of variant of item in cart. This return array have key is inventory_id and value is number.
     * Let value of non-wow variants are 0, value of wow variants (out of cart) are sequential digit 1 to 99 and
     * value of wow variants (picked in cart) are 100, 200, ... (wow variant in same product have a same value).
     *
     * Call this function by ajax that is used in _getCart of cartLightboxWidget.js
     * 
     * @return array
     */
    
    
    public function getWowInventories()
    {
        $pcms = App::make('pcms');
        $cart = $pcms->getCartV2();

        $discount_campaigns = array_get($cart, 'data.discountCampaignData') ?: array();

        // get discount campaign of items in cart
        $wow_inventory_id_in_cart = array();
        $inventory_id_in_cart = array();


        foreach($discount_campaigns as $discount_campaign)
        {
            $discount_inventory_id_array = $discount_campaign['inventory_id'];
            foreach($discount_inventory_id_array as $discount_inventory_id)
            {
                $wow_inventory_id_in_cart[$discount_inventory_id] = $discount_campaign['type'];
            }
        }

        // get all inventory id of items and assign value to wow item
        $cart_details = array_get($cart, 'data.cart_details') ?: array();

        $index_product_in_cart = 1;
        $config_setting = Config::get('settings.limit-cart-item-quantity');
        $config_setting = !empty($config_setting)? $config_setting : array("collections"=>array(),'discount-campaigns' => array());
        
        foreach($cart_details as $cart_detail)
        {   
            $inventory_id_in_cart[$cart_detail['inventory_id']] = 0;
        
            // check discount campaign    
            if(isset($wow_inventory_id_in_cart[$cart_detail['inventory_id']])
                && in_array($wow_inventory_id_in_cart[$cart_detail['inventory_id']], $config_setting['discount-campaigns']))
            {
                $inventory_id_in_cart[$cart_detail['inventory_id']] = 100*$index_product_in_cart;
                $index_product_in_cart = $index_product_in_cart + 1;
            }
            
            // check 1 piece collection.
            foreach($cart_detail['collections'] as $collection_cart)
            {
                if(in_array($collection_cart['pkey'], $config_setting['collections']))
                {
                    $inventory_id_in_cart[$cart_detail['inventory_id']] = 100*$index_product_in_cart;
                    $index_product_in_cart = $index_product_in_cart + 1;
                }
            }
        }

        // get all inventory id of variant of product
        if (Input::get('product_pkey'))
        {
            $products = $this->product->getByPkey(Input::get('product_pkey'));
            
            if($products)
            {
                //Check each varaint of product was wow and was picked in cart.
                $this->getIsWow($products);
                $isWow = $this->getIsWow($products);
                $index_product = 0;
                
                foreach($products['variants'] as $variant)
                {

                    if($isWow[$variant['inventory_id']])
                    {
                        $index_product = $index_product_in_cart;
                        
                        // variant product in cart and assign value same in cart.
                        foreach($inventory_id_in_cart as $key=>$value)
                        {
                            
                            if($variant['inventory_id'] == $key)
                            {
                                $index_product = $value;

                                break 2;

                            }
                        }
                    }                   
                }
                
                // Assign value to all variant of product
                foreach($products['variants'] as $variant)
                {
                    $inventory_id_in_cart[$variant['inventory_id']] = $index_product;
                }
            }
        }
        
        return $inventory_id_in_cart;      
    }

    /**
     * setCardData check card information from 6 digit of card number 
     *
     * @return JSON
     */
    public function setCardData()
    {
        $user = ACL::getUser();
 
        $credit_num = Input::get('creditnum', NULL);
        
        $response['code'] = '404';
        $response['data'] = false;

        $params['creditnum']       = ! empty($credit_num) ? substr($credit_num, 0, 6) : "";
        $params['customer_ref_id']  = $user['user_id'];
        $params['command']          = 'set';
        $api_response = $this->pcms->apiv2('cart/set-card', $params, 'POST', false, 6, 2);

        $response = $api_response;

        if ($response['code']=='200') {
            $response['data'] = array(
                'card_issuer'      => array_get($api_response, 'data.issuer'),
                'card_network'     => array_get($api_response, 'data.network'),
                'card_description' => array_get($api_response, 'data.description'),
                'card_ref_id'      => array_get($api_response, 'data.card_ref_id'),
                'promotion_ccw'      => array_get($api_response, 'data.promotion_ccw'),
            );
        }

        return Response::json($response, 200);
    }
    
    public function getIsWow($product)
    {
        $isWow = array();
        
        foreach($product['variants'] as $variant)
        {
            $isWow[$variant['inventory_id']] = false;

            if(!empty($variant['active_special_discount']))
            {
                if(in_array($variant['active_special_discount']['campaign_type'], Config::get('settings.limit-cart-item-quantity.discount-campaigns', array()))
                        && time() < strtotime($variant['active_special_discount']['ended_at']))
                {
                    $isWow[$variant['inventory_id']] = true;
                }
            }
        }
        
        foreach($product['collections'] as $collection)
        {
            if(in_array($collection['pkey'], Config::get('settings.limit-cart-item-quantity.collections', array())))
            {
                 foreach($product['variants'] as $variant)
                {
                    $isWow[$variant['inventory_id']] = true;
                }
            }
        }

        return $isWow;
    }
}

