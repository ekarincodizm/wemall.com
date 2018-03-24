<?php

use Coreproc\Dragonpay\DragonpayApi as Dragonpay;
//use Coreproc\Dragonpay\Checkout;
use Coreproc\Dragonpay\DragonpayClient;

class NewCheckoutController extends CheckoutBaseController
{

    private $pcms;
    protected $customerAddress;
    protected $product;
    protected $apiEventLog;

    public function __construct(
        ProductRepositoryInterface $product,
        CustomerAddressRepositoryInterface $customerAddress,
        ApiEventLogs $apiEventLog)
    {
        parent::__construct();

        $this->pcms = App::make('pcms');
        $this->product = $product;
        $this->customerAddress = $customerAddress;
        $this->apiEventLog = $apiEventLog;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getStep1()
    {
        TimeLogger::snap('start get::checkout/step1');

        if ($this->isMobile()) {
            $this->theme->asset()->usePath()->add('reset-css', 'css/reset.css');
            $this->theme->asset()->usePath()->add('bootstrap-css', 'css/bootstrap.min.css');
            $this->theme->asset()->usePath()->add('mobile_b-css', 'css/mobile_b.css');
            $this->theme->asset()->usePath()->add('addon-css', 'css/addon.css');
            $this->theme->asset()->usePath()->add('addon-ui', 'css/addon-ui.css');
            $this->theme->asset()->usePath()->add('reveal-css', 'css/reveal.css');
            $this->theme->asset()->usePath()->add('style-css', 'css/style.css');
            $this->theme->asset()->usePath()->add('login-css', 'css/login.css');
            $this->theme->asset()->usePath()->add('ex-login-2014-css', 'css/ex-login-2014.css');
            $this->theme->asset()->usePath()->add('ex-login-2014-step1', 'js/ex-login-2014.js', array('jquery'));
            $this->theme->asset()->container('footer')->usePath()->add('checkout1-validate', 'js/checkout-step1.js', array('jquery'));
        } else {
            $this->theme->asset()->usePath()->add('checkout1-css', 'css/checkout1.css');
            $this->theme->asset()->container('footer')->usePath()->add('checkout1-validate', 'js/checkout-step1.js', array('jquery'));
            $this->theme->asset()->usePath()->add('validate', 'js/jquery.validate.min.js', array('jquery'));
            $this->theme->asset()->usePath()->add('checkout-step1', 'js/checkout-step1.js', array('jquery'));
            $this->theme->asset()->container('footer')->usePath()->add('step1', 'js/step1.js', array('jquery'));
        }


        $continue = Input::get('continue');
        $type = Input::get('type');

        $user = ACL::getUser(); // un use
        $isLoggedin = ACL::isLoggedIn();
        if ($isLoggedin) {
            //--- Save stage ---//
            $response = $this->customerAddress->saveStage('step1'); // un use
            return Redirect::route('checkout.step2');
        }

        $cart = $this->pcms->getCheckoutV2();

        $view = array();

        $view['cart'] = !empty($cart) ? $cart : '';
        $view['continue'] = !empty($continue) ? $continue : Url::route('checkout.step2');
        $view['type'] = !empty($type) ? $type : 'guest';

        // Get Criteo Tags
        $this->getCriteoBasketTags();

        TimeLogger::snap('end get::checkout/step1');

        $meta = array(
            'browse:checkout1'
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
                'tag:add_to_cart',
                'tag:checkout1'
            ),
            'EventID' => 'checkout1',
            'Meta' => $meta
        );

        $gearmanRepo = App::make('GearmanRepository');
        $gearmanRepo->addQueue($log_datas);

        return $this->theme->scope('checkout.step1', $view)->render();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStep1()
    {
        TimeLogger::snap('start post::checkout/step1');

        $this->validateStep1();

        $user = ACL::getUser();
        $_params = array();
        $_params['customer_ref_id'] = $user['user_id'];
        $_params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $_params['customer_email'] = Input::get('username', "");

        $cart = $this->pcms->api('cart/apply-email', $_params, 'POST'); // un use

        //--- Save stage ---//
        $response = $this->customerAddress->saveStage('step1'); // un use

        TimeLogger::snap('end post::checkout/step1');

        return Redirect::to("http:" . url_no_protocal("checkout/step2"));
    }

    private function validateStep1()
    {
        TimeLogger::snap('start validateStep1');

        $validator = Validator::make(
            Input::all(),
            array('username' => 'required')
        );

        TimeLogger::snap('end validateStep1');

        if ($validator->fails()) {
            echo "fail";
            exit;
        }
    }

    private function addFBMarketingTagStep2($cart)
    {
        $total_price = isset($cart['data']['sub_total']) ? number_format($cart['data']['sub_total'], 2) : "0.00";
        $this->theme->asset()->container()->writeContent('FB-Remarketing-step2', '
				<!-- Facebook Re-Marketing -->
				<!-- TypeIdea Facebook Agency -->
				<!-- Facebook Add to Cart -->
				<script type="text/javascript">
				var fb_param = {};
				fb_param.pixel_id = "6014863536932";
				fb_param.value = ' . str_replace(',', '', $total_price) . ';
				fb_param.currency = "PHP";
				(function(){
				  var fpw = document.createElement("script");
				  fpw.async = true;
				  fpw.src = "//connect.facebook.net/en_US/fp.js";
				  var ref = document.getElementsByTagName("script")[0];
				  ref.parentNode.insertBefore(fpw, ref);
				})();
				</script>
				<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6014863536932&amp;value=0&amp;currency=PHP" /></noscript>
			', array());

        return;
    }

    public function getStep2()
    {
        TimeLogger::snap('start get::checkout/step2');

        $data = array();
        $user = ACL::getUser();
        $new_addr = Input::get('new', 0);

        if (ACL::isLoggedIn()) {
            $data['addressList'] = Theme::widget('shippingAddress', array('user' => $user, 'new_addr' => $new_addr))->render();
        } else {
            $data['addressList'] = NULL;
        }
//todo next time change to v2
        $response = $this->pcms->apiv2('provinces', array(), "GET", false, 1440);
//        $response = $this->pcms->api('provinces');

        if (intval($response['code']) == 200 && !empty($response['data'])) {
            $data['provincesList'] = $response['data'];
        }

        if (!empty($this->checkout['customer_province_id'])) {
            $city = $this->pcms->apiv2('cities', array('province_id' => $this->checkout['customer_province_id']), "GET", false, 1440);
            $data['city'] = $city['data'];
        }

        if (!empty($this->checkout['customer_city_id'])) {
            $district = $this->pcms->apiv2('districts', array('city_id' => $this->checkout['customer_city_id']), "GET", false, 1440);
            $data['district'] = $district['data'];
        }

//        if (!empty($this->checkout['customer_district_id'])) {
//            $zip_code = $this->pcms->apiv2('zipcodes', array('district_id' => $this->checkout['customer_district_id']), "GET", false, 1440);
//            $data['zip_code'] = $zip_code['data'];
//        }

        $cart = $this->pcms->getCheckoutV2();

        $data['cart'] = !empty($cart) ? $cart : '';
        $data['user'] = $user;
        $data['isLoggedin'] = ACL::isLoggedIn();
        $data['checkout'] = $this->checkout;
        $data['address'] = (!empty($this->checkout)) ? $this->checkout : NULL;
        $data['address']["customer_email"] = cleanCustomerEmail($data['address']["customer_email"]);

        if (App::environment('production', 'beta', 'testing')) {
            $this->addFBMarketingTagStep2($cart);
        }

        // Get Criteo Tags
        $this->getCriteoBasketTags();

        TimeLogger::snap('end get::checkout/step2');

        $meta = array(
            'browse:checkout2'
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
                'tag:add_to_cart',
                'tag:checkout1',
                'tag:checkout2'
            ),
            'EventID' => 'checkout2',
            'Meta' => $meta
        );

        $gearmanRepo = App::make('GearmanRepository');
        $gearmanRepo->addQueue($log_datas);

        $this->theme->asset()->usePath()->add('main-member-step2-js', 'js/main.js', array('jquery'));

        if (ACL::isLoggedIn() && $this->isMobile() && empty($data['addressList'])) {
            return Redirect::to(URL::toLang('customers/create-shipping-address?continue='.URL::toLang("checkout/step2?new=1")));
        } elseif (ACL::isLoggedIn() && $this->isMobile()) {
            $this->theme->asset()->usePath()->add('checkout-member-step2-js', 'js/checkout-member-step2.js', array('jquery'));
            return $this->theme->scope('checkout.member-step2', $data)->render();
        } else {
            $this->theme->asset()->add("js-geolocation", "assets/js/geolocation/geolocation.js", array());
            $this->theme->asset()->usePath()->add('checkout-step2-js', 'js/checkout-step2.js', array('jquery'));

            return $this->theme->scope('checkout.step2', $data)->render();
        }

    }

    public function postStep2()
    {
        TimeLogger::snap('start post::checkout/step2');

        //--- Save stage ---//
        $this->customerAddress->saveStage('step2');
        $cart = $this->pcms->getCheckoutV2();
        $customerData = $cart['data'];

        $rules = array(
            //Rule which accept all Thai characters ก-ฮ และ สระทั้งหมด
            //and some specific symbol . , - and _
            'customer_name' => 'required|Regex:/^[ก-ํA-z\.\s,-_\(\)]*$/u'
        );
        $validator = Validator::make($customerData, $rules);

        if ($validator->fails()) {
            return Redirect::route('checkout.step2')->withErrors($validator);
        }

        $shipments = array();

        if (!empty($cart['data']['shipments'])) {
            foreach ($cart['data']['shipments'] as $ship_key => $ship_value) {
                if (empty($ship_value['shipping_method'])) {
                    if (!empty($ship_value['available_shipping_methods'])) {
                        $i = 0;
                        foreach ($ship_value['available_shipping_methods'] as $ship_avai_key => $ship_avai_value) {
                            if ($i > 0) {
                                break;
                            }
                            $shipments[$ship_key] = $ship_avai_key;
                            $i++;
                        }
                    }
                }
            }
        }

        $user = ACL::getUser();

        $args['customer_ref_id'] = $user['user_id'];
        $args['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $args['shipments'] = $shipments;

        $this->pcms->api('checkout/select-shipment-methods', $args, 'POST');

        TimeLogger::snap('end post::checkout/step2');

        return Redirect::to(URL::toLang('checkout/step3', array(), Config::get("https.useHttps")));
    }

    /**
     * @return mixed
     */
    public function getStep3()
    {
        TimeLogger::snap('start get::checkout/step3');

        $data = array();
        $cart = $this->pcms->getCheckoutV2();
        $products = array();
        if (!empty($cart['data'])) {
            // Installment
            $cart_type = $cart['data']['type'];
            if (strtolower($cart_type) == "installment") {
                if (!empty($cart['data']['shipments'])) {
                    foreach ($cart['data']['shipments'] as $ship_key => $ship_value) {
                        if (!empty($ship_value['items'])) {
                            foreach ($ship_value['items'] as $i_key => $i_value) {
                                $products[] = $this->product->getByPkey($i_value['product_pkey']);
                            }
                        }
                    }
                }
            }
        }

        $monthly_installment = array();
        if (!empty($products)) {
            foreach ($products as $p_key => $p_value) {
                if (!empty($p_value['installment']['periods'])) {
                    foreach ($p_value['installment']['periods'] as $inst_key => $inst_value) {
                        $monthly_installment[] = $inst_value;
                    }
                }
            }
        }

        $data['monthly_installment'] = $monthly_installment;
        $data['cart'] = $cart;
        $data['checkout'] = $this->checkout;

        if (Input::get('debug') == "checkout_var") {
            alert($data['checkout'], 'red', 'checkout');
            if (!Input::has('continue')) {
                exit;
            }
        }

        if (Input::get('debug') == "user") {
            $user = ACL::getUser();
            alert($user, 'red', 'user');
            if (!Input::has('continue')) {
                exit;
            }
        }

        $this->theme->asset()->usePath()->add("js-geolocation", "js/geolocation.js", array());
        $this->theme->asset()->usePath()->add('checkout-step3', 'js/checkout-step3.js?' . rand(1, 10000), array('jquery'));
        $this->theme->asset()->add("js-geolocation", "assets/js/geolocation/geolocation.js", array());
        $this->theme->asset()->container('footer')->usePath()->add('step3-installment', 'js/step3-installment.js?' . rand(1, 10000), array('jquery'));

        if ($this->isMobile()) {
            $this->theme->asset()->container('footer')->usePath()->add('custom-step3', 'js/custom-step3.js', array('jquery'));
            $this->theme->asset()->container('footer')->usePath()->add('payment-errormsg', 'js/step3-errormsg.js', array('jquery'));
        }

        // Get Criteo Tags
        $this->getCriteoBasketTags();

        TimeLogger::snap('end get::checkout/step3');

        $meta = array(
            'browse:checkout3'
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
                'tag:add_to_cart',
                'tag:checkout1',
                'tag:checkout2',
                'tag:checkout3'
            ),
            'EventID' => 'checkout3',
            'Meta' => $meta
        );

        $gearmanRepo = App::make('GearmanRepository');
        $gearmanRepo->addQueue($log_datas);

        if($data['cart']['data']['bill_province_id'] == null || $data['cart']['data']['bill_province_id'] == ""){
            $data['cart']['data']['bill_province_id'] = 1;
        }
        return $this->theme->scope('checkout.step3', $data)->render();
    }

    protected function getInventoryIds($shipment_data)
    {
        $allInventoryIds = array();

        if (empty($shipment_data)) {
            return $allInventoryIds;
        }

        foreach ($shipment_data as $shipment) {
            foreach ($shipment["items"] as $item) {
                $allInventoryIds[] = $item["inventory_id"];
            }
        }

        return $allInventoryIds;
    }

    protected function getInstallment($shipment_data)
    {
        $bankInstallment = array();

        if (empty($shipment_data)) {
            return $bankInstallment;
        }

        foreach ($shipment_data as $shipment) {
            foreach ($shipment["items"] as $item) {
                if (empty($item["bank_installments"])) {
                    continue;
                }

                foreach ($item["bank_installments"] as $instBank) {
                    if (!isset($bankInstallment[$instBank["id"]])) {
                        $bankInstallment[$instBank["id"]] = array();
                    }

                    foreach ($instBank["periods"] as $period) {
                        if (!isset($bankInstallment[$instBank["id"]][$period])) {
                            $bankInstallment[$instBank["id"]][$period] = array();
                        }

                        $bankInstallment[$instBank["id"]][$period][] = $item["inventory_id"];
                    }
                }
            }
        }

        return $bankInstallment;
    }

    public function postStep3()
    {
        TimeLogger::snap('start post::checkout/step3');

        $user = ACL::getUser();
        $cart = $this->pcms->getCheckoutV2();

        // save customer email to cart if not exist.
        if (empty($cart['data']['customer_email']) && !empty($user['email'])) {
            $this->_saveCartEmail($user);
        }

        // no payment method => redirect
        $payment_method_code = array_get($cart, 'data.payment_method_code');
        if (empty($payment_method_code)) {
            return Redirect::to('checkout/step3?place=3');
        }

        /**
         * [S] Check Valid payment method
         */

        // get all inventory in cart
        $allInventoryIds = $this->getInventoryIds($cart["data"]["shipments"]);

        // get bank installment in cart
        $bankInstallment = $this->getInstallment($cart["data"]["shipments"]);

        // prepare data
        $is_installment = $payment_method_code == "CCinstM";
        $all_payment_methods = array_get($cart, 'data.all_payment_methods');
        $payment_method_index = array_get($cart, 'data.payment_method');

        // validation on payment (not installment)
        if (!$is_installment && !empty($all_payment_methods) && !empty($payment_method_index)) {
            $cart_inventory_ids = array_get($all_payment_methods, $payment_method_index . '.inventory_ids');

            if (empty($cart_inventory_ids)) {
                return Redirect::to('checkout/step3?place=5');
            }

            if (count(array_diff($allInventoryIds, $cart_inventory_ids)) > 0) {
                return Redirect::to('checkout/step3?place=4');
            }
        }

        // validation on installment
//        if ($is_installment) {
//            $bankId = array_get($cart, 'data.bank_id');
//            $period = array_get($cart, 'data.installment.period');
//
//            if (empty($bankId) || empty($period)) {
//                return Redirect::to('checkout/step3?place=8');
//            }
//
//            if (empty($bankInstallment[$bankId][$period])) {
//                return Redirect::to('checkout/step3?place=6');
//            }
//
//            if (count(array_diff($allInventoryIds, $bankInstallment[$bankId][$period])) > 0) {
//                return Redirect::to('checkout/step3?place=7');
//            }
//        }

        $customer_ref_id = $user['user_id'];
        $customer_type = ACL::isLoggedIn() ? 'user' : 'non-user';

        $add_invoice = Input::get('add_invoice');
        $is_new_ccw = Input::get('is_new_ccw');
        $save_ccw = Input::get('save_ccw');

        $creditname = Input::get('creditname');
        $creditnum = Input::get('creditnum');  // Credit Card No.
        $expiremonth = Input::get('expiremonth');
        $expireyear = Input::get('expireyear');
        $ccv = Input::get('ccv'); // เลขหลังบัตร (TMN เรียก CVN)

        $creditno = Input::get('creditno');  // Card token

        ### สร้าง params เบื้องต้น ###
        $params = array(
            'customer_ref_id' => $customer_ref_id,
            'customer_type' => $customer_type
        );

        ### สร้าง rules สำหรับ validate ###
        $rules = array(
            'customer_ref_id' => 'required',
            'customer_type' => 'required',
        );

        ### เก็บ lang เพื่อ return หน้า ให้ถูกภาษา ###
        $params['lang'] = App::getLocale();

        if (strtolower($payment_method_code) == 'ccw') {
//            $params['is_new_ccw'] = !empty($is_new_ccw) ? $is_new_ccw : 'Y'; ### ถ้าไม่มีค่า จะบังคับให้เป็น Y ###
//            $params['save_ccw'] = !empty($save_ccw) ? $save_ccw : 'N'; ### ถ้าไม่มีค่า จะบังคับให้เป็น N ###
//
//            // $params['card_num'] = substr($creditnum, 0, 6);
//            $params['card_type'] = Input::get('card_type');
//            $params['card_name'] = Input::get('card_name');
//
//            if ($params['is_new_ccw'] == 'N') {
//                ### ถ้าใช้บัตรเครดิตที่มีอยู่ใน list ต้องส่งค่า card token ###
//                $params['card_token'] = $creditno;
//                $rules['card_token'] = 'required';
//            } else {
//                ### ถ้าใช้บัตรเครดิตใหม่ ###
//                $params['creditname'] = $creditname;
//                //add rule for card holder's name to accept only cap letter and some symbol
//                $rules['creditname'] = 'required|Regex:/^[A-Z\.\s,-_]*$/u';
//
//                $params['expiremonth'] = $expiremonth;
//                $rules['expiremonth'] = 'required';
//
//                $params['expireyear'] = $expireyear;
//                $rules['expireyear'] = 'required|integer';
//
//                $params['ccv'] = $ccv;
//                $rules['ccv'] = 'required';
//            }
        }

        if (empty($add_invoice)) {
            ### ถ้าใช้ที่อยู่ในการออก bill ไม่เหมือนกับที่อยู่การจัดส่ง ต้อง validate ค่า bill ###
            $bill_name = Input::get('bill_name');
            $bill_province_id = Input::get('bill_province_id');
            $bill_city_id = Input::get('bill_city_id');
            $bill_district_id = Input::get('bill_district_id');
            $bill_postcode = Input::get('bill_postcode');
            $bill_address = isset($_REQUEST['bill_address'])?$_REQUEST['bill_address']:"";

            $bill_param = array(
                'bill_name' => $bill_name,
                'bill_province_id' => $bill_province_id,
                'bill_city_id' => $bill_city_id,
                'bill_district_id' => $bill_district_id,
                'bill_postcode' => $bill_postcode,
                'bill_address' => $bill_address,
            );

            $params = array_merge($bill_param, $params);

            $rules['bill_name'] = 'required';
            $rules['bill_province_id'] = 'required';
            $rules['bill_city_id'] = 'required';
            $rules['bill_district_id'] = 'required';
//            $rules['bill_postcode'] = 'required';
            $rules['bill_address'] = 'required';
        } else {
            ### ถ้าใช้ที่อยู่ในการออก bill เหมือนกับที่อยู่ shipping จะ convert ที่อยู่ใน  bill ให้เหมือนกับ shipping ###
            $this->pcms->api('cart/convert-shipping-to-bill', $params, 'POST');
        }

        $validator = Validator::make($params, $rules);

        if ($validator->fails()) {
            // The given data did not pass validation
            return Redirect::to('checkout/step3')->withErrors($validator);
        }

        $this->pcms->api('cart/save-bill-address', $params, 'POST');
        $params['form'] = 1;

        $params['lang_code'] = App::getLocale();

        // Set Curl Option SET CURLOPT_TIMEOUT to 30 min.
        $curl_opts_input = array(
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 180,
            CURLOPT_USERAGENT => 'pcms-0.1',
            CURLOPT_FOLLOWLOCATION => 0,
            CURLOPT_ENCODING => ''
        );

        /**
         * DELETE STAGE.
         */
        $this->customerAddress->deleteStage();

        $created_time = date('Y-m-d H:i:s');
        if(strtolower($payment_method_code) == 'cod') {
            $response = $this->pcms->api('checkout/create-order', $params, 'POST', false, $curl_opts_input);

            $paramTmp = $params;
            $paramTmp = array_only($paramTmp, array("customer_ref_id", "customer_type", "lang"));
            if ($response['code'] != 200) {
                $log_api = $this->apiEventLog;
                $log_api->event_name = 'Checkout 3 Create Order';
                $log_api->summary = 'ไม่สามารถสร้าง Order ได้';
                $log_api->log_request = 'checkout/create-order?' . http_build_query($paramTmp, null, '&');
                if (is_array($response)) {
                    $response = json_encode($response, TRUE);
                }
                $log_api->log_response = $response;
                $log_api->created_at = $created_time;
                $log_api->updated_at = date('Y-m-d H:i:s');
                $log_api->save();

                $this->theme->layout("thankyou");
                return $this->theme->scope('checkout.error', array('response' => $response))->render();
            }
            $return_html = $response['data']['html'];

            TimeLogger::snap('end post::checkout/step3');

            return $return_html;

        } else {
            $response = $this->pcms->api('checkout/new-create-order', $params, 'POST', false, $curl_opts_input);
            if ($response['code'] != 200) {
                $paramTmp = $params;
                $paramTmp = array_only($paramTmp, array("customer_ref_id", "customer_type", "lang"));
                $log_api = $this->apiEventLog;
                $log_api->event_name = 'Checkout 3 Create Order';
                $log_api->summary = 'ไม่สามารถสร้าง Order ได้';
                $log_api->log_request = 'checkout/create-order?' . http_build_query($paramTmp, null, '&');
                if (is_array($response)) {
                    $response = json_encode($response, TRUE);
                }
                $log_api->log_response = $response;
                $log_api->created_at = $created_time;
                $log_api->updated_at = date('Y-m-d H:i:s');
                $log_api->save();

                $this->theme->layout("thankyou");
                return $this->theme->scope('checkout.error', array('response' => $response))->render();
            }

            // IF pay with zero PHP
            if($response['data']!=null && !empty($response['data']['html'])){
                $return_html = $response['data']['html'];
                return $return_html;
            } else {
                return Redirect::to($response['message']);
            }
        }
        // End


        /**
         * [S] Save Log ในกรณี
         */
//        $beforeSubmit = $this->apiEventLog;
//        $beforeSubmit->event_name = 'Checkout 3 Create Order';
//        $beforeSubmit->summary = 'log-before-submit-paymentform';
//        $beforeSubmit->log_request = 'checkout/create-order?' . http_build_query($paramTmp, null, '&');
//        $logText = "";
//        if (is_array($response)) {
//            $logText = json_encode($response, TRUE);
//        }
//        $beforeSubmit->log_response = $logText;
//        $beforeSubmit->created_at = $created_time;
//        $beforeSubmit->updated_at = date('Y-m-d H:i:s');
//        $beforeSubmit->save();
        /**
         * [E] Save Log
         */

//        $return_html = $response['data']['html'];

//        $config = array(
//            'merchantId'        => 'TRUEMONEY',
//            'merchantPassword'  => 'B4dPuYW2',
//            'testing'           => true
//        );
//        $params = array(
//            'transactionId' => $response['data']['id'],
//            'amount'        => number_format($response['data']['total_price'], 2, '.', ''), // 2 digit after .
//            'currency'      => 'PHP',
//            'description'   => 'order='.$response['data']['id'],
//            'email'         => $response['data']['customer_email']
//        );

//        $dragon = new Dragonpay($response['message']);



//        $filter = 'online_banking';
//        $filter = 'otc_banking_atm';
//        $filter = 'otc_non_bank';
//        $filter = 'paypal';  // not work now will integate
//        $filter = 'credit_card'; // not work now will integate
//        $filter = 'mobile';
//        $filter = 'international_otc'; // not work now will integate
//        $filter = 'gcash_direct';
//        $filter = 'credit_card_direct';
//        $filter = 'paypal_direct';

//
//        if (strtolower($payment_method_code) == 'ccw') {
//            $filter = 'online_banking';
//            $url = $dragon->getUrl($params, $filter);
//        } else if (strtolower($payment_method_code) == 'atm') {
//            $filter = 'otc_banking_atm';
//            $url = $dragon->getUrl($params, $filter);
//        }  else if (strtolower($payment_method_code) == 'ccw') {
//            $filter = 'online_banking';
//            $url = $dragon->getUrl($params, $filter);
//        }  else if (strtolower($payment_method_code) == 'ccw') {
//            $filter = 'online_banking';
//            $url = $dragon->getUrl($params, $filter);
//        } else {
//            $url = $dragon->getUrl($params);
//        }


//        return Redirect::to($response['message']);
//        TimeLogger::snap('end post::checkout/step3');

//        return $response = $this->pcms->api('checkout/new-create-order', $params, 'POST', false, $curl_opts_input);;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function anyThankyou()
    {
        // Hook asynchronize request here to call Inqyure API in PCMS
        // and don't keep or show any response

        $params = array(
            'order_id'=>Input::get('order_id', ""),
            'refno' =>Input::get('refno', "-")
        );

        $res = $this->pcms->api('payment/inquire', $params, 'GET', false);

        TimeLogger::snap('start any::checkout/thankyou');

        $this->theme = Theme::uses('checkout');
        $this->theme->layout("thankyou");

        $orderId = Input::get('order_id', "");
        if (empty($orderId)) {
            return Redirect::route('home');
        }

        $user = ACL::getUser();
        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $params['inventory_id'] = Input::get('inventory_id');
        $params['sso_id'] = $user['ssoId'];
        $params['order_id'] = $orderId;
        $params['lang'] = App::getLocale();
        $url = URL::current();
        $section = parse_url($url);
        $params['base_url'] = $section['scheme'] . '://' . $section['host'];
        $params['code'] = Input::get('code', '');

//        if($params['customer_type']!='user') {
//            sd($params);
//        }


        $response = $this->pcms->api('payment/detail', $params);

        if (!isset($response['data']) || empty($response['data'])) {
            Theme::uses('itruemart')->layout('default');
            return $this->theme->scope('errors.404')->render(404);
        }

        $ecommerce = $this->pcms->api('payment/item', $params);

        // --- Is not switch language from thank you page ----//
        if (!Input::has('thank')) {
            if (!empty($response['data']['lang_code'])) {
                if ($response['data']['lang_code'] != App::getLocale()) {
                    if ($response['data']['lang_code'] != "th") {
                        $urlRedirect = "http://" . Request::server('HTTP_HOST') . '/' . $response['data']['lang_code'] . Request::server('REQUEST_URI');
                    } else {
                        $urlRedirect = "http://" . Request::server('HTTP_HOST') . Request::server('REQUEST_URI');
                    }
                    return Redirect::to($urlRedirect);
                }
            }
        }

        $view = array();
        $view['data'] = (!empty($response['data'])) ? $response['data'] : array();
        $view['ecommerce'] = (!empty($ecommerce['data'])) ? $ecommerce['data'] : array();

        $email = !empty($view['data']['customer_email']) ? $view['data']['customer_email'] : "";
        $params = array();
        if (is_numeric($email)) {
            $params['phone'] = $email;
        } else {
            $params['email'] = $email;
        }
        $isMember = $this->pcms->api('members/check', $params);
        $registerable = ((!empty($isMember['code']) && $isMember['code'] == 200) || (empty($params['email']))) ? false : true;

        $data = $view['data'];
        Theme::partialComposer('registerLightbox', function ($view_partial) use ($email, $registerable, $data) {
            $view_partial->with('email', $email);
            $view_partial->with('show', $registerable);
            $view_partial->with('data', $data);
        });

        $log_items = array();
        if ( ! empty($ecommerce['data']['order_item']))
        {
            foreach ($ecommerce['data']['order_item'] as $e_key => $e_value)
            {
                $log_items[] = 'product_name:'.$e_value['name'];
            }
        }
        $meta = array(
            'browse:thankyou',
            'payment_status:'.array_get($response, 'data.payment_status'),
            'sub_total:'.array_get($response, 'data.sub_total'),
            'items' => $log_items
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
                'tag:add_to_cart',
                'tag:checkout1',
                'tag:checkout2',
                'tag:checkout3',
                'tag:thankyou'
            ),
            'EventID' => 'thankyou',
            'Meta' => $meta
        );

        $gearmanRepo = App::make('GearmanRepository');
        $gearmanRepo->addQueue($log_datas);

        TimeLogger::snap('end any::checkout/thankyou');

        if (strtolower(array_get($response, 'data.payment_channel')) === 'offline' || strtolower(array_get($response, 'data.payment_channel')) === 'online') {
            //Criteo Conversion Tags
            $this->getCriteoConversionTags($view);

            $method = Input::get('method', '');
            $refno = Input::get('refno', '');

            if('COD' == $method || !empty($refno)){
                $this->getShopBack($view);
            }

            return $this->theme->scope('checkout.thankyou-success', $view)->render();
        } else {
            return Redirect::route('home');
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSaveMember()
    {
        TimeLogger::snap('start post::checkout/save-member');

        $orderId = Input::get('order_id', NULL);

        $data = array(
            'flag' => true,
            'username' => Input::get('email_username', NULL),
            'password' => Input::get('email_password', NULL),
            'password_confirmation' => Input::get('email_password', NULL),
            'display_name' => Input::get('email_display_name', NULL),
//            'thai_id' => Input::get('thai_id', NULL),
//            'trueyou' => Input::get('true_card', NULL)
        );

        $rules = array(
            'username' => 'required',
            'display_name' => 'required|between:2,20',
            'password' => 'required|between:8,25|confirmed',
            'password_confirmation' => 'required',
        );

        $validator = Validator::make($data, $rules);


        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        try {
            $MemberRepository = App::make("MemberRepositoryInterface");
            $res = $MemberRepository->checkEmailSso($data);

        } catch (\ValidateException $e) {
            $errors = $e->getMessages();

            return Redirect::back()->withInput()->withErrors($errors);
        } catch (\Exception $e) {
            sd($e);
        }

        if (!empty($res)) {
            $order_params = array(
                'order_id' => $orderId,
                'customer_ref_id' => $res['ssoId']
            );

            $convert_status = $this->pcms->api('orders/guest-to-member', $order_params, 'post');
            $convert = (!empty($convert_status['code']) && $convert_status['code'] == 200) ? true : false;

            $save_customers_addr = $this->pcms->api('customerAddresses/create-address-by-orderid', $order_params, 'post');
            $save_status = (!empty($save_customers_addr['code']) && $save_customers_addr['code'] == 200) ? true : false;
        }

        TimeLogger::snap('end post::checkout/save-member');

        if ($convert && $save_status) {
            return Redirect::route('checkout.thankyou.newexperience', array('order_id' => $orderId,'thank'=>'y'));
        }
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function getPaymentWidgetCod()
    {
        TimeLogger::snap('start get::checkout/payment-widget-cod');

        $return = array();
        $return['menu'] = '<li class="hservice">
								<h2>
									<a href="#channel-cod" data-toggle="tab">
										<span class="payment-title">เก็บเงินปลายทาง</span><br/>
										<span>Cash on Delivery</span>
									</a>
								</h2>
							</li>';
        $return['content'] = Theme::widget('payCod', array())->render();

        TimeLogger::snap('end get::checkout/payment-widget-cod');

        return Response::make($return, 200);
    }

    /**
     * @return mixed
     */
    public function getNoItem()
    {
        TimeLogger::snap('start get::checkout/no-item');

        if ($this->isMobile()) {
            $this->theme->asset()->usePath()->add('reset-css', 'css/reset.css');
            $this->theme->asset()->usePath()->add('bootstrap.min-css', 'css/bootstrap.min.css');
            $this->theme->asset()->usePath()->add('itruemart.checkout-css', 'css/itruemart.checkout.css');
            $this->theme->asset()->usePath()->add('itruemart.checkout.resp-css', 'css/itruemart.checkout.resp.css');
            $this->theme->asset()->usePath()->add('addon-css', 'css/addon.css');
            $this->theme->asset()->usePath()->add('addon-ui', 'css/addon-ui.css');
            $this->theme->asset()->usePath()->add('reveal-css', 'css/reveal.css');
            $this->theme->asset()->usePath()->add('ex-2014-css', 'css/ex-2014.css');
        }

        TimeLogger::snap('end get::checkout/no-item');

        return $this->theme->scope('checkout.noitems', array())->render();
    }

    /**
     * @return mixed
     */
    public function postSetAnalyticsStatus()
    {
        TimeLogger::snap('start post::checkout/set-analyticsStatus');

        $user = ACL::getUser();
        $_params = array();
        $_params['customer_ref_id'] = $user['user_id'];
        $_params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $_params['order_id'] = Input::get('order_id', "");
        $_params['analytics_status'] = Input::get('analytics_status', "");

        $res = $this->pcms->api('payment/set-analytics-status', $_params, 'POST');

        TimeLogger::snap('end post::checkout/set-analyticsStatus');

        return $res;
    }

    /**
     * @return mixed
     */
    public function getAutoShipment()
    {
        TimeLogger::snap('start get::checkout/auto-shipment');

        $shipments = array();

        $cart = $this->pcms->getCheckoutV2();

        if (!empty($cart['data']['shipments'])) {
            foreach ($cart['data']['shipments'] as $ship_key => $ship_value) {
                if (!empty($ship_value['available_shipping_methods'])) {
                    foreach ($ship_value['available_shipping_methods'] as $ship_avai_key => $ship_avai_value) {
                        if ($cart['data']['payment_method'] == '155613837979771') {
                            if ($ship_avai_key == '14456917914435') {
                                $shipments[$ship_key] = $ship_avai_key;
                                break;
                            }
                        } else {
                            $shipments[$ship_key] = $ship_avai_key;
                            break;
                        }
                    }
                }
            }
        }

        $user = ACL::getUser();

        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $params['shipments'] = $shipments;

        $response = $this->pcms->api('checkout/select-shipment-methods', $params, 'POST');

        if (!empty($response['code'])) {
            if ($response['code'] == 200) {
                ### return shipment only ###
                $data = $response['data'];
                $return_data['payment_method_code'] = !empty($data['payment_method_code']) ? $data['payment_method_code'] : '';
                $return_data['shipments'] = !empty($data['shipments']) ? $data['shipments'] : '';
                $response['data'] = $return_data;
            }
        } else {
            $response['code'] = 404;
        }

        TimeLogger::snap('end get::checkout/auto-shipment');

        return $response;
    }

    /**
     * @param $user
     * @return bool|null
     */
    private function _saveCartEmail($user)
    {
        if (!$user) {
            $user = ACL::getUser();
        }

        $_params = array();
        $_params['customer_ref_id'] = $user['user_id'];
        $_params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $_params['customer_email'] = $user['email'];

        $response = $this->pcms->api('checkout/set-customer-info', $_params, 'post');

        if (intval($response['code']) == 200) {
            return true;
        }

        return null;
    }

    public function getCriteoBasketTags()
    {
        // [START] Criteo tags
        $product = array();
        $product_pkey = "";
        $product_price = "";
        $product_qty = "";
        if (!empty($this->checkout['shipments'])) {
            foreach ($this->checkout['shipments'] as $key => $shipment) {
                foreach ($shipment['items'] as $item => $value) {
                    if (isset($product[$value['product_pkey']])) {
                        $product[$value['product_pkey']]['qty'] = $product[$value['product_pkey']]['qty'] + $value['quantity'];
                    } else {
                        $product[$value['product_pkey']]['price'] = $value['price'];
                        $product[$value['product_pkey']]['qty'] = $value['quantity'];
                    }
                }
            }

            if (!empty($product)) {
                $n = 1;
                foreach ($product as $key => $value) {
                    $str = "";
                    if ($n < count($product)) {
                        $str = "|";
                    }
                    $product_pkey .= $key . $str;
                    $product_price .= $value['price'] . $str;
                    $product_qty .= $value['qty'] . $str;
                    $n++;
                }
            }
        }

        $criteo_script = '
        <script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
        <script type="text/javascript" >
            <!-- Criteo : Basket tag // Checkout -->
            var allproductids = "' . $product_pkey . '";
            var allprices = "' . $product_price . '";
            var allquantities = "' . $product_qty . '";
            var delimiter = "|";

            var productlist = [];
            var quantities = allquantities.split(delimiter);
            var products = allproductids.split(delimiter);
            var prices = allprices.split(delimiter);

            for (var i=0;i<products.length;i++)
            {
                productlist[i] = {id:products[i], price:prices[i],quantity:quantities[i]};
            }

            window.criteo_q = window.criteo_q || [];
            window.criteo_q.push(
                    { event: "setAccount", account: 26653 },
                    { event: "setHashedEmail", email: "' . criteoGetHashEmail() . '" },
                    { event: "setSiteType", type: "' . criteoGetContentType() . '" },
                    { event: "viewBasket" , item: productlist }
            );
        </script>';

        $this->theme->append('criteo_tag', $criteo_script);
        // [END] Criteo tags
    }

    public function getCriteoConversionTags($checkout = array())
    {
        if ($checkout['data']['analytics_status'] == "N" && (App::environment('production') || App::environment('aws-alpha') || App::environment('aws-staging')) && ($checkout['data']['payment_status'] != 'failed' || $checkout['data']['payment_status'] != 'expired')) {
            $product = array();
            $product_pkey = "";
            $product_price = "";
            $product_qty = "";
            if (isset($checkout['ecommerce']['shipments']) && $checkout['ecommerce']['shipments']) {
                foreach ($checkout['ecommerce']['shipments'] as $key => $shipment) {
                    foreach ($shipment['items'] as $item => $value) {
                        if (isset($product[$value['product_pkey']])) {
                            $product[$value['product_pkey']]['qty'] = $product[$value['product_pkey']]['qty'] + $value['quantity'];
                        } else {
                            $product[$value['product_pkey']]['price'] = $value['price'];
                            $product[$value['product_pkey']]['qty'] = $value['quantity'];
                        }
                    }
                }

                if (!empty($product)) {
                    $n = 1;
                    foreach ($product as $key => $value) {
                        $str = "";
                        if ($n < count($product)) {
                            $str = "|";
                        }
                        $product_pkey .= $key . $str;
                        $product_price .= $value['price'] . $str;
                        $product_qty .= $value['qty'] . $str;
                        $n++;
                    }
                }
            }

            $criteo_script = '
            <!-- Criteo : Conversion tag // Thankyou -->
            <script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
            <script type="text/javascript">
                var allproductids = "' . $product_pkey . '";
                var allprices = "' . $product_price . '";
                var allquantities = "' . $product_qty . '";
                var delimiter = "|";

                var productlist = [];
                var quantities = allquantities.split(delimiter);
                var products = allproductids.split(delimiter);
                var prices = allprices.split(delimiter);

                for (var i=0;i<products.length;i++)
                {
                    productlist[i] = {id:products[i], price:prices[i],quantity:quantities[i]};
                }

                window.criteo_q = window.criteo_q || [];
                criteo_q.push(
                    {event: "setAccount", account: 26653 },
                    {event: "setHashedEmail", email: "' . criteoGetHashEmail() . '" },
                    {event: "setSiteType", type: "' . criteoGetContentType() . '"},
                    {event: "trackTransaction",
                        id: "' . (!empty($checkout['data']['order_id']) ? $checkout['data']['order_id'] : "") . '",
                        item: productlist
                    });
            </script>';

            $this->theme->append('criteo_tag', $criteo_script);
        }
    }

    public function anyDragonPayComplete()
    {
        // Hook asynchronize request here to call Inqyure API in PCMS
        // and don't keep or show any response
        $response = Input::all();
        $params = array(
            'order_id'=>$response['txnid'],
            'refno' =>$response['refno']
            );
        $res = $this->pcms->api('payment/inquire', $params, 'GET', false);
//        if($response['status'] == 'S') {
//            return Redirect::to('./checkout/thank-you?order_id=881118&thank=y');
//        } else if($response['status'] == 'F') {
//            return Redirect::to('./checkout/thank-you?order_id=881118&thank=y');
//        } else {
//            return Redirect::to('./checkout/thank-you?order_id=881118&thank=y');
//        }

        $user = ACL::getUser();

        $customer_type = ACL::isLoggedIn() ? 'user' : 'non-user';
        if($customer_type == "user") {
            return Redirect::to('./checkout/thank-you?order_id='.$response['txnid'].'&thank=y&refno='.$response['refno']);
        } else {
            $code = $user['user_id'];
//            $secret_key = 'itruemart-top-secret';
//            $encryption = App::make('Encrypter', array($secret_key));
            $code_text = hash('sha256', $response['txnid'].$code);//$encryption->encode($code);
//            sd($encryption->encode($code));
            return Redirect::to('./checkout/thank-you?order_id='.$response['txnid'].'&thank=y&refno='.$response['refno'].'&code='.$code_text);
        }
    }

    public function getShopBack($data){
        $order_id = $data['data']['order_id'];
        $sub_total = $data['data']['sub_total'];

        /****************************************/
        /*   Code by Clovis, Shopback bypass    */
        /****************************************/

        //Set the link
//        $url = "https://shopback.go2cloud.org/aff_l?offer_id=561&adv_sub=".$order_id."&amount=".$sub_total;
//
//        //Dev mode?
//        $devmode = 1;
//
//        //Generate options
//        $options = array(
//            CURLOPT_RETURNTRANSFER => true,     // return web page
//            CURLOPT_HEADER         => false,    // don't return headers
//            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
//            CURLOPT_ENCODING       => "",       // handle all encodings
//            CURLOPT_USERAGENT      => "Itruemart | Shopback", // who am i
//            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
//            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
//            CURLOPT_TIMEOUT        => 120,      // timeout on response
//            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
//            CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
//        );
//
//        //push it
//        $ch      = curl_init( $url );
//        curl_setopt_array( $ch, $options );
//        $content = curl_exec( $ch );
//        $err     = curl_errno( $ch );
//        $errmsg  = curl_error( $ch );
//        $header  = curl_getinfo( $ch );
//        curl_close( $ch );
//
//        $header['errno']   = $err;
//        $header['errmsg']  = $errmsg;
//        $header['content'] = $content;
//
//        if($devmode == 1){
//            print_r($header);
//            print $sub_total;
//            print $order_id;
//        }
        /**************************/
        /* End shopback injection */
        /**************************/


        $shop_back = '<!-- Offer Conversion: iTrueMart PH --><img src="https://shopback.go2cloud.org/aff_l?offer_id=561&adv_sub='.$order_id.'&amount='.$sub_total.'" width="1" height="1" /><!-- // End Offer Conversion -->';
//        $shop_back = '<!-- Offer Conversion: iTrueMart PH --><img src="http://www.itruemart.loc/test&adv_sub='.$order_id.'&amount='.$sub_total.'" width="1" height="1" /><!-- // End Offer Conversion -->';
//
//<!-- Offer Conversion: iTrueMart PH -->
//<img src="https://shopback.go2cloud.org/aff_l?offer_id=561&adv_sub=SUB_ID&amount=AMOUNT" width="1" height="1" />
//<!-- // End Offer Conversion -->

        $this->theme->append('shop_back', $shop_back);
    }

}
