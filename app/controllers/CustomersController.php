<?php

class CustomersController extends FrontBaseController {

    private $pcms;
    private $customerAddress;

    public function __construct(CustomerAddressRepositoryInterface $customerAddress)
    {
        parent::__construct();

        $this->pcms = App::make('pcms');
        $this->customerAddress = $customerAddress;
    }

    public function getAddress()
    {
        if (Input::get('province_id') == '' && Input::get('city_id') == '' && Input::get("district_id") == "") return Response::json(null, 200);
        
        $province_id = Input::get('province_id');
        
        $response = $this->pcms->api('cities', array('province_id' => $province_id));
        $cities = $response['data'];
        
        $city_id = Input::get('city_id')?: (!empty($cities[key($cities)]['id'])? $cities[key($cities)]['id'] : "");
        
        $response = $this->pcms->api('districts', array('city_id' => $city_id));
        $districts = $response['data'];
        
        $district_id = Input::get("district_id")?: $districts[key($districts)]['id'];
        $response = $this->pcms->api('zipcodes', array('district_id' => $district_id));
        $zip_code = $response['data'];
        
        $response = compact('cities', 'districts', 'zip_code');

        return Response::json($response, 200);
    }
    
    public function postAddress()
    {
        $user = ACL::getUser();
        
        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn()?'user':'non-user';
        
        $params['id'] = Input::get('id', 0);
        $params['name'] = Input::get('name');
        $params['email'] = Input::get('email');
        $params['address'] = isset($_REQUEST['address'])?$_REQUEST['address']:"";
        $params['province_id'] = Input::get('province_id');
        $params['city_id'] = Input::get('city_id');
        $params['district_id'] = Input::get('district_id');
        $params['postcode'] = Input::get('postcode');
        $params['phone'] = Input::get('phone');
        
        $this->pcms->api('customers/address', $params, 'POST');
    }

    public function postSaveShipAddr()
    {
        $user = ACL::getUser();

        $args['customer_ref_id'] = $user['user_id'];
        $args['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';

        $email = Input::get("email", "");
        if( !empty($email) ){
            $args['email'] = $email;
        } elseif ($args['customer_type'] == 'user') {
            $args['email'] = $user['email'];
        }
        $args['name'] = Input::get('name');

        $args['address'] = isset($_REQUEST['address'])?$_REQUEST['address']:"";
        $args['province_id'] = Input::get('province_id');
        $args['city_id'] = Input::get('city_id');
        $args['district_id'] = Input::get('district_id');
        $args['postcode'] = Input::get('postcode');
        $args['phone'] = Input::get('phone');

        $args['id'] = Input::get('address_id');
        if (empty($args['id']))
        {
            $response = $this->pcms->api('customerAddresses/create', $args, 'POST');            
            if ( ! empty($response['data']['address_id']))
            {
                $address_id = $response['data']['address_id'];
            }
            else
            {
                $address_id = NULL; 
            }
        }
        else
        {
            $response = $this->pcms->api('customerAddresses/update', $args, 'post');
            $address_id = Input::get('address_id');
        }
        #return $response; 
        

        $response['data']['deleteUrl'] = ( ! empty($address_id)) ? URL::toLang('ajax/customers/delete-ship-addr?id='.$address_id) : NULL;
        $response['data']['editUrl'] = ( ! empty($address_id)) ? URL::toLang('ajax/customers/edit-ship-addr?id='.$address_id) : NULL;


        return Response::json($response, 200); 
    }


    /** 
     *  @author  Preme W. <preme_won@truecorp.co.th>
     *  @description   Delete shipping address 
     *  @since   May 15, 2014
     */

    public function postDeleteShipAddr()
    {
        $user = ACL::getUser();


        if (Input::has('id'))
        {
            $address_id = Input::get('id');
            $response = $this->customerAddress->deleteAddress($address_id);

            $json = array();
            if ($response['code'] == 200)
            {
                $json['code'] = $response['code'];
                $json['message'] = __('step2-delete-success');
                $json['return_id'] = Input::get('id');
            }

            return Response::json($json);
        }

        else
        {
            $json = array(
                'code' => 404,
                'message' => 'Not found id in database',
            );
            return Response::json($json);
        }
    }

    public function getEditShipAddr()
    {
        $user = ACL::getUser();
        
        $args['customer_ref_id'] = $user['user_id'];
        #$params['customer_type'] = ACL::isLoggedIn()?'user':'non-user';
        $args['address_id'] = Input::get('id');


        $detail = $this->pcms->api('customerAddresses/detail', $args, 'get');

        if ( empty($detail['data']['id']) )
        {
            $json = array(
                'message' => 'Not found this id in database.'
            );
            return Response::json($json, 404);
        }

        //auto save email to customer_address table in PCMS.
        if(empty($detail['data']['email'])  && !empty($user["email"]) && !preg_match("/\@truelife.com$/", $user["email"])){
            $detail = $this->_saveEmailToCustomerAddress($detail);
            if ( empty($detail['data']['id']) )
            {
                $json = array(
                    'message' => 'Not found this id in database.'
                );
                return Response::json($json, 404);
            }
        }

        $province_id = $detail['data']['province_id'];
        $city_id = $detail['data']['city_id'];
        $district_id = $detail['data']['district_id']; 

        $city = $this->pcms->apiv2('cities', array('province_id' => $province_id), "GET", false, 1440);
        $district = $this->pcms->apiv2('districts', array('city_id' => $city_id), "GET", false, 1440);
        $zip_code = $this->pcms->apiv2('zipcodes', array('district_id' => $district_id), "GET", false, 1440);

		$cityArray = array();
		if ( ! empty($city['data']))
		{			
			foreach ($city['data'] as $c_key => $c_value)
			{
				$cityArray[] = array(
					'opt_value' => $c_value['id'],
					'opt_text' => $c_value['name']
				);
			}
			
			$detail['data']['cities'] = $cityArray; 
		}
		else
		{
			$detail['data']['cities'] = NULL; 
		}

		if ( ! empty($district['data']))
		{
			$districtArray = array();
			foreach ($district['data'] as $d_key => $d_value)
			{
				$districtArray[] = array(
					'opt_value' => $d_value['id'],
					'opt_text' => $d_value['name']
				);
			}

			$detail['data']['districts'] = $districtArray; 
		}
		else
		{
	        $detail['data']['districts'] = NULL;
		}

		if ( ! empty($zip_code['data']))
		{
			$zipcodeArray = array();

			foreach ($zip_code['data'] as $z_key => $z_value)
			{
				$zipcodeArray[] = array(
					'opt_value' => $z_value['zipcode'],
					'opt_text' => $z_value['zipcode']
				);
			}

			$detail['data']['zip_code'] = $zipcodeArray;
		}
		else
		{
			$detail['data']['zip_code'] = NULL; 
		}

        return Response::json($detail['data']); //json_encode($detail['data'], TRUE);

    }

    /**
    public function postEditShipAddr()
    {
        $args['name'] = Input::get('name');
        $args['address'] = Input::get('address');
        $args['province_id'] = Input::get('province_id');
        $args['city_id'] = Input::get('city_id');
        $args['district_id'] = Input::get('district_id');
        $args['postcode'] = Input::get('postcode');
        $args['phone'] = Input::get('phone');

        $response = $this->pcms->api('customerAddresses/update', $args, 'post');
        return Response::json($response, 200);
    }
    **/

    /**
     *  @author : Preme W. <preme_won@Truecorp.co.th> 
     *  @description  Get Address by ajax 
     *  @since    May 27, 2014 
     *
     */
    public function postAddr()
    {
        if (Input::has('mode'))
        {
            /***
            $province_id = Input::get('province_id');
        
        $response = $this->pcms->api('cities', array('province_id' => $province_id));
        $cities = $response['data'];

        $city_id = Input::get('city_id')?: (!empty($cities[key($cities)]['id'])? $cities[key($cities)]['id'] : "");
        
        $response = $this->pcms->api('districts', array('city_id' => $city_id));
        $districts = $response['data'];
        
        $district_id = Input::get("district_id")?: $districts[key($districts)]['id'];
        $response = $this->pcms->api('zipcodes', array('district_id' => $district_id));
        $zip_code = $response['data'];
            **/
            switch (Input::get('mode'))
            {
                case 'province' : 
                    $province_id = Input::get('province_id');
                    $addrs = $this->pcms->api('cities', array('province_id' => $province_id)); 
                    if ( ! empty($addrs) && $addrs['code'] == 200)
                    {
                        $json = array();
                        foreach ($addrs['data'] as $key => $value)
                        {
                            $json[] = array(
                                'opt_value'    => $value['id'],
                                'opt_text'     => $value['name']
                            );
                        }
                    }
                    break; 

                case 'city' : 
                    $city_id = Input::get('city_id');
                    $addrs = $this->pcms->api('districts', array('city_id' => $city_id));
                    if ( ! empty($addrs) && $addrs['code'] == 200)
                    {
                        $json = array();
                        foreach ($addrs['data'] as $key => $value)
                        {
                            $json[] = array(
                                'opt_value'    => $value['id'],
                                'opt_text'     => $value['name']
                            );
                        }
                    }
                    break; 

                case 'district' :  
                    $district_id = Input::get('district_id');
                    $addrs = $this->pcms->api('zipcodes', array('district_id' => $district_id));
                    if ( ! empty($addrs) && $addrs['code'] == 200)
                    {
                        $json = array();
                        foreach ($addrs['data'] as $key => $value)
                        {
                            $json[] = array(
                                'opt_value'      => $value['zipcode'],
                                'opt_text'     => $value['zipcode']
                            );
                        }
                    }
                    break; 

                default : 
                    break;
            }

            return Response::json($json, 200);
        }
    }


    
	
    /** 
     *  @author  Autsatapon W. <autsatapon_wil@truecorp.co.th>
     *  @description   save address by ajax
     *  @since   May 16, 2014
     */	
	public function postSaveAddr()
	{
		if (Input::has('id'))
        {
            $customer_address_id = Input::get('id');
			
			$user = ACL::getUser();
			
			$customer_ref_id = $user['ssoId'];
			
            $response = $this->customerAddress->getAddress($customer_ref_id);

			$params = array();
            $json = array();
            if ($response['code'] == 200)
            {
				//alertd($response['data']);
				if(!empty($response['data']))
				{
					foreach($response['data'] as $customer)
					{
						if($customer['customer_addresses_id'] == $customer_address_id)
						{
							$params['customer_ref_id'] = $user['user_id'];
							$params['customer_type'] = ACL::isLoggedIn()?'user':'non-user';
							$params['customer_name'] = $customer['customer_name'];
							$params['customer_address'] = $customer['address'];
							$params['customer_province_id'] = $customer['province_id'];
							$params['customer_city_id'] = $customer['city_id'];
							$params['customer_district_id'] = $customer['district_id'];
							$params['customer_postcode'] = $customer['postcode'];
							$params['customer_tel'] = $customer['phone'];								
							$params['customer_address_id'] = $customer_address_id;
                            $params['customer_email'] = $customer['email'];
							break;
						}
					}
				}
            }

            
			
			$setinforesponse = array();
			
			if(!empty($params))
			{
				$setinforesponse = $this->pcms->api('checkout/set-customer-info', $params, 'POST');
			}
            #alert($setinforesponse, 'red', 'setinforesponse');
            #exit;

            // [B] Save shipping method to cart
            $cart = $this->pcms->getCheckout();
            #alert($cart, 'red', 'cart');
            $shipments = array(); 
            if ( ! empty($cart['data']['shipments']))
            {
                
                foreach ($cart['data']['shipments'] as $ship_key => $ship_value)
                {
                    if (empty($ship_value['shipping_method']))
                    {
                        if ( ! empty($ship_value['available_shipping_methods']))   
                        {
                            $i = 0;
                            foreach ($ship_value['available_shipping_methods'] as $ship_avai_key => $ship_avai_value)
                            {
                                if ($i > 0)
                                {
                                    break;
                                }
                                $shipments[$ship_key] = $ship_avai_key;
                                $i++;
                            }
                        }
                    } //  End empty($shipping method )
                }
            }

            $user = ACL::getUser();

            $args['customer_ref_id'] = $user['user_id'];
            $args['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
            $args['shipments'] = $shipments;

            #alert($args, 'red');

            $this->pcms->api('checkout/select-shipment-methods', $args, 'POST');


            // [E] Save shipping method to cart 
			
			if(!empty($setinforesponse))
			{
				if ($setinforesponse['code'] == 200)
				{
					$CustomerAddressRepository = New CustomerAddressRepository;
					$CustomerAddressRepository->saveStage('step2');
					
					$json['code'] = $response['code'];
					$json['message'] = trans('step2.save_success');
					
//					if (App::environment('production') || App::environment('beta') )
//					{
//						// The environment is production
//						$open_https = true;
//					}
//					else
//					{
//						$open_https = false;
//					}
					$open_https = Config::get("https.useHttps");
					$json['return_step'] = URL::toLang('checkout/step3', array(), $open_https);
				}
				return Response::json($json);
			}
			else
			{
				$json = array(
					'code' => 404,
					'message' => 'Save Fail',
				);
				return Response::json($json);		
			}
        }

        else
        {
            $json = array(
                'code' => 404,
                'message' => 'Not found id in database',
            );
            return Response::json($json);
        }		
	}

    private function _saveEmailToCustomerAddress($detail){

        $user = ACL::getUser();
        $params = array(
            "customer_ref_id" => $user['user_id'],
            "customer_type" => ACL::isLoggedIn() ? 'user' : 'non-user',
            "email" => $user["email"],
            "id" => $detail['data']['id'],
            'name' => $detail["data"]['name'],
            'address' => $detail['data']['address'],
            'province_id' => $detail['data']['province_id'],
            'city_id' => $detail['data']['city_id'],
            'district_id' => $detail['data']['district_id'],
            'postcode' => $detail['data']['postcode'],
            'phone' => $detail['data']['phone']
        );
        $response = $this->pcms->api('customerAddresses/update', $params, 'post');

        $params = array(
            'customer_ref_id' => $user['user_id'],
            'address_id' => $detail['data']['id']
        );
        return $this->pcms->api('customerAddresses/detail', $params, 'get');
    }
}

