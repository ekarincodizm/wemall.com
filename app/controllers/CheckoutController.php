<?php
use  Illuminate\Support\MessageBag as MessageBag;

class CheckoutController extends FrontBaseController
{

    private $pcms;

    public function __construct()
    {
        parent::__construct();

        $this->pcms = App::make('pcms');
    }


    public function getIndex()
    {
        if (ACL::isLoggedin()) {
            return Redirect::route('checkout.checkout1');
        }

        return Redirect::route('auth.login', array('continue' => URL::route('checkout.checkout1')));
    }

    public function anyTmnComplete()
    {
        $paymentId = Input::get('payment_id');
        $all_input = Input::all();

        if (empty($paymentId)) {
            return Redirect::route('home');
        }

        $response = $this->_saveCCWPaymentDetail($paymentId, $all_input);

        if (!empty($response['data']['foreground_url'])) {
            return Redirect::to($response['data']['foreground_url']);
        } else {
            sleep(3);
            $response = $this->_saveCCWPaymentDetail($paymentId, $all_input);
            if (!empty($response['data']['foreground_url'])) {
                return Redirect::to($response['data']['foreground_url']);
            } elseif (Input::has("nohtml")) {
                return $this->theme->scope('errors.404')->render(404);
            } else {
                return View::make("payment.form", array("payment_id" => $paymentId));
            }
        }
    }

    private function _saveCCWPaymentDetail($paymentId, $all_input = array())
    {

        $params = array(
            'payment_id' => $paymentId
        );
        $response = $this->pcms->api('credit-card-payment/pull-order-details', $params, 'POST');

        if (!empty($response['status']) && $response['status'] === 'success') {

            $data = $response['data'];
            $params = array(
                'ref1' => $data['ref1'],
                'ref2' => $data['ref2'],
                'ref3' => $data['ref3'],
                'orderid' => $data['payment_order_id'],
                'barcode' => $data['barcode']
            );
            $response = $this->pcms->api('orders/save-foreground', $params, 'POST');
            $log_api = new ApiEventLogs();
            $log_api->event_name = 'Raw response from save-foreground method from PCMS';
            $log_api->summary = 'Save FAIL Logs From Payment TMN (PCMS Response : orders/save-foreground)';
            $log_api->log_request = is_array($params) ? json_encode($params) : $params;
            $log_api->log_response = is_array($response) ? json_encode($response) : $response;
            $log_api->created_at = date('Y-m-d H:i:s');
            $log_api->save();

            if ($response['status'] !== 'success') {
                $log_api = new ApiEventLogs();
                $log_api->event_name = 'รับข้อมูลจาก FG จาก Payment Gatway';
                $log_api->summary = 'Save FAIL Logs From Payment TMN (PCMS Response : orders/save-foreground)';
                $log_api->log_request = is_array($params) ? json_encode($params) : $params;
                $log_api->log_response = is_array($response) ? json_encode($response) : $response;
                $log_api->created_at = date('Y-m-d H:i:s');
                $log_api->save();
            }

            $log_api = new ApiEventLogs();
            $log_api->event_name = 'รับข้อมูลจาก FG จาก Payment Gatway';
            $log_api->summary = 'log-after-submit-paymentform';
            $log_api->log_request = is_array($params) ? json_encode($params) : $params;
            $log_api->log_response = is_array($response) ? json_encode($response) : $response;
            $log_api->created_at = date('Y-m-d H:i:s');
            $log_api->save();

        } else {
            $log_api = new ApiEventLogs();
            $log_api->event_name = 'รับข้อมูลจาก FG จาก Payment Gatway (Exception)';
            $log_api->summary = 'Save FAIL Logs From Payment TMN (PCMS Response : credit-card-payment/pull-order-details)';
            $log_api->log_request = is_array($params) ? json_encode($params) : $params;
            $log_api->log_response = is_array($response) ? json_encode($response) : $response;
            $log_api->created_at = date('Y-m-d H:i:s');
            $log_api->save();
        }

        return $response;
    }

    public function getCheckout1()
    {
        $user = ACL::getUser();
        $isLoggedin = ACL::isLoggedIn();

        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL) || preg_match('/^m[0-9]+/', $user['email'])) {
            $showEmailInput = true;
        } else {
            $showEmailInput = false;
        }

        $response = $this->pcms->getCheckout();

        if ($response['status'] != 'success') {
            throw new Exception($response['message']);
        }

        $checkout = $response['data'];

        $response = $this->pcms->getCustomerAddresses();
        $addresses = array();
        foreach ($response['data'] as $data) {
            $addresses[$data['id']] = $data;
        }

        $addressOptions = array(
            '0' => '------- ' . __('add address') . ' -------'
        );
        foreach ($addresses as $id => $address) {
            $addressOptions[$id] = $address['text'];
        }

        $response = $this->pcms->api('provinces');
        $provinces = array();
        $provinces['0'] = '------ ' . __('select') . ' ------';
        foreach ($response['data'] as $p) {
            $provinces[$p['id']] = $p['name'];
        }
        $provinceOptions = $provinces;
        $cityOptions = array('0' => '------ ' . __('select') . ' ------');
        $districtOptions = array('0' => '------ ' . __('select') . ' ------');
        $is_line = CheckoutController::anyCheckLine($checkout['discount_campaigns']);

        // create trueyou discount
        $trueyouDiscount = array();
        foreach (array_get($checkout, 'promotions') as $key => $promotion) {
            if (array_get($promotion, 'type') != 'trueyou') {
                continue;
            }

            $truecard = array_get($promotion, 'card');

            $discountItems = array_get($promotion, 'discount.items');

            $discountType = array_get($promotion, 'discountType');
            $discountPercent = array_get($promotion, 'discountPercent');
            $discountBaht = array_get($promotion, 'discountBaht');

            foreach ($discountItems as $inventoryId => $discount) {

                $trueyouDiscountItem = false;

                // find shipment item that has same inventory id
                foreach (array_get($checkout, 'shipments') as $shipment) {
                    $shipmentItems = array_get($shipment, 'items');
                    foreach ($shipmentItems as $shipmentItem) {
                        if (array_get($shipmentItem, 'inventory_id') == $inventoryId) {
                            $trueyouDiscountItem = $shipmentItem;
                        }
                    }
                }

                if ($trueyouDiscountItem) {
                    $trueyouDiscount[] = array(
                        'name' => array_get($trueyouDiscountItem, 'name'),
                        'card' => $truecard,
                        'discount' => $discount,
                        'type' => $discountType,
                        'percent' => $discountPercent,
                        'baht' => $discountBaht
                    );
                }
            }


        }

        $view = compact('user', 'isLoggedin', 'showEmailInput', 'checkout', 'addresses', 'addressOptions', 'provinces', 'provinceOptions', 'cityOptions', 'districtOptions', 'is_line', 'trueyouDiscount');
        $this->theme->setTitle('My Account:Checkout.Step1 - Order Information');

        if ($this->isMobile()) {
            $this->theme->asset()->container('footer')->usePath()->add('checkout', 'js/checkout-index.js', array(
                'jquery'
            ));
            $this->theme->setSubfooter($this->theme->scope("campaign.campaign_footer", array())->content());
        } else {
            $this->theme->asset()->usePath()->add('jquery-reveal', 'css/reveal.css');
            $this->theme->asset()->container('footer')->add('jquery-reveal', 'assets/vendor/jquery.reveal.js', array('jquery'));
            $this->theme->asset()->container('footer')->add('jquery.fs.stepper.js', 'assets/vendor/jquery.fs.stepper.js', array('jquery'));
            $this->theme->asset()->container('footer')->usePath()->add('checkout', 'js/checkout-index.js', array('jquery'));
            $this->theme->asset()->add('jquery.fs.stepper.css', 'assets/vendor/jquery.fs.stepper.css');
            $this->theme->asset()->usePath()->add('checkout', 'css/itruemart.checkout.css');
            $this->theme->asset()->usePath()->add('checkout.resp', 'css/itruemart.checkout.resp.css');
        }

        if ($checkout['items_count'] == 0 && $this->isMobile()) {
            return $this->theme->scope("checkout.noitems")->render();
        } else if ($checkout['items_count'] == 0) {
            return $this->theme->scope('checkout.noitems', array())->render();
        }

        return $this->theme->scope('checkout.index', $view)->render();
    }


    public function postCheckout1()
    {
        $user = ACL::getUser();

        $errors = array();

        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';

        $_params = $params;
        $_params['items'] = Input::get('items', array());
        $updateItems = $this->pcms->api('checkout/update-items', $_params, 'POST');

        if ($updateItems['code'] != 200) {
            $errors[] = __('สินค้า<br/><strong>:title</strong><br/>คงเหลือใน stock ไม่เพียงพอ', array('title' => $updateItems['data']['variant']['title']));
        }

        $_params = $params;
        $_params['shipments'] = Input::get('shipments', array());
        $this->pcms->api('checkout/select-shipment-methods', $_params, 'POST');

        return Redirect::back()->withErrors($errors);
    }


    public function postCheckoutData()
    {
        $response = $this->pcms->getCheckout();
        return Response::json($response, 200);
    }

    public function postCheckoutDataV2()
    {
        $response = $this->pcms->getCheckoutV2();
        return Response::json($response, 200);
    }

    public function postUpdateItem()
    {
        $user = ACL::getUser();
        $_params['customer_ref_id'] = $user['user_id'];
        $_params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $_params['lang'] = Lang::getLocale();
        $_params['items'] = Input::get('items', array());
        $response = $this->pcms->api('checkout/update-items', $_params, 'POST');

        return Response::json($response, 200);
    }

    public function postUpdateItemV2()
    {
        $user = ACL::getUser();
        $_params['customer_ref_id'] = $user['user_id'];
        $_params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $_params['lang'] = Lang::getLocale();
        $_params['items'] = Input::get('items', array());
        $response = $this->pcms->apiv2('checkout/update-items', $_params, 'POST', true, 0, 2);

        return Response::json($response, 200);
    }

    public function getConfirm()
    {

        $this->postApplyCoupon();

        $isLoggedin = ACL::isLoggedIn();

        $response = $this->pcms->getCheckout();
        $checkout = $response['data'];
        $is_line = CheckoutController::anyCheckLine($checkout['discount_campaigns']);
        $rules = array(
            'customer_name' => 'required',
            'customer_address' => 'required',
            'customer_district_id' => 'required',
            'customer_city_id' => 'required',
            'customer_province_id' => 'required',
            'customer_district' => 'required',
            'customer_city' => 'required',
            'customer_province' => 'required',
            'customer_postcode' => 'required',
            'customer_tel' => 'required',
            'customer_email' => 'required|email',
            'items_count' => 'required|min:1',
            'confirm_checkout' => 'required|in:1'
        );

        $validator = Validator::make($checkout, $rules);

        if ($validator->fails()) {
            return Redirect::route('checkout.index');
        }

        foreach ($checkout['shipments'] as $key => $shipment) {
            if (empty($shipment['shipping_method'])) {
                return Redirect::route('checkout.index');
            }
        }

        $view = compact('isLoggedin', 'checkout', 'is_line');

        $this->theme->setTitle('My Account:Checkout.Step2 - Checkout Payment');

        if ($this->isMobile()) {

            $this->theme->asset()->container("footer")->usePath()->add("payment_channel_effect", 'js/payment_channel.js', array('jquery'));
            $this->theme->asset()->container("footer")->usePath()->add("checkout", 'js/checkout-confirm.js', array('jquery'));
            $this->theme->setSubfooter($this->theme->scope("campaign.campaign_footer", array())->content());
        } else {

            $this->theme->asset()->usePath()->add('jquery-reveal', 'css/reveal.css');
            $this->theme->asset()->container('footer')->add('jquery-reveal', 'assets/vendor/jquery.reveal.js', array('jquery'));
            $this->theme->asset()->usePath()->add('checkout', 'css/itruemart.checkout.css');
            $this->theme->asset()->usePath()->add('checkout.resp', 'css/itruemart.checkout.resp.css');
            $this->theme->asset()->container('footer')->usePath()->add('checkout', 'js/checkout-confirm.js', array('jquery'));
        }
        return $this->theme->scope('checkout.confirm', $view)->render();
    }

    /**
     * Process WeTrust foreground.
     *
     * @return html
     */
    public function anyComplete()
    {
        $temp = @fopen("php://input", 'r');
        $fg_response_raw = urldecode(stream_get_contents($temp));
        $fg_response_xml = str_replace('xmlRes=', '', $fg_response_raw);

        $fg_response = json_decode(json_encode((array)simplexml_load_string($fg_response_xml)), 1);

        // Save Log
        $log_api = new ApiEventLogs();
        $log_api->event_name = 'รับข้อมูลจาก FG จาก Payment Gatway';
        $log_api->summary = 'Save Logs From Payment Wetrust';
        $log_api->log_request = '';
        if (is_array($fg_response)) {
            $fg_response_save = json_encode($fg_response, TRUE);
        }
        $log_api->log_response = $fg_response_save;
        $log_api->created_at = date('Y-m-d H:i:s');
        $log_api->updated_at = date('Y-m-d H:i:s');
        $log_api->save();


        $params = array(
            'ref1' => (!empty($fg_response['ref1'])) ? $fg_response['ref1'] : NULL,
            'ref2' => (!empty($fg_response['ref2'])) ? $fg_response['ref2'] : NULL,
            'ref3' => (!empty($fg_response['ref3'])) ? $fg_response['ref3'] : NULL,
            'orderid' => $fg_response['orderid']
        );

        if ($barcode = array_get($fg_response, 'barcode')) {
            $params['barcode'] = $barcode;
        }

        $response = $this->pcms->api('orders/save-foreground', $params, 'POST');

        return Redirect::to($response['data']['foreground_url']);
    }

    /**
     * postApplyCoupon
     *
     * - Apply Promotion code / Voucher for checkout step 3
     *
     * @param request method is AJAX
     * @param code
     *
     * @return json data
     */
    public function postApplyCoupon()
    {
        $code = Input::get('code');
        $is_ajax = Request::ajax();
        $return = array();
        $lang = Lang::getLocale();
        $errorCodeDefault = 400;
        $errorMessage = array(
            'en' => 'Vouchers cannot be used for temporarily',
            'th' => 'ไม่สามารถใช้รหัสคูปองพิเศษได้ชั่วคราว'
        );

        $errorMessageInvalidAjax = array(
            'en' => 'Method require ajax request.',
            'th' => 'Method require ajax request.'
        );
        $errorMessageInvalidPromotionCode = array(
            'en' => 'Please enter voucher.',
            'th' => 'กรุณาพิมพ์รหัสคูปองพิเศษ'
        );

        if (!$is_ajax) {
            $return = array(
                'status' => 'error',
                'code' => $errorCodeDefault,
                'description' => $errorMessageInvalidAjax[$lang]
            );

            return Response::json($return);
        }

        if (!$code) {
            $return = array(
                'status' => 'error',
                'code' => $errorCodeDefault,
                'description' => $errorMessageInvalidPromotionCode[$lang]
            );

            return Response::json($return);

        }

        $response = $this->pcms->postApplyCoupon($code);

        if ($response['status'] == 'success') {
            $return = array(
                'status' => 'success',
                'code' => 200,
                'description' => 'success'
            );
            return Response::json($return);

        } else {
            $errorCode = array_get($response, 'data.errorCode');
            switch ($errorCode) {

                case '4001':
                    $errorMessage = array(
                        'en' => 'Please enter voucher.',
                        'th' => 'กรุณาพิมพ์รหัสคูปองพิเศษ'
                    );
                    break;

                case '4101':
                    $errorMessage = array(
                        'en' => 'Voucher is expired.',
                        'th' => 'รหัสคูปองพิเศษหมดอายุแล้ว'
                    );
                    break;

                case '4102':
                    $errorMessage = array(
                        'en' => 'Voucher is incorrect.',
                        'th' => 'รหัสคูปองพิเศษไม่ถูกต้อง'
                    );
                    break;

                case '4111':
                    $errorMessage = array(
                        'en' => 'Vouchers are out of stock.',
                        'th' => 'รหัสคูปองพิเศษถูกใช้หมดแล้ว'
                    );
                    break;

                case '4112':
                    $errorMessage = array(
                        'en' => 'Voucher cannot be used with your order',
                        'th' => 'คูปองพิเศษไม่สามารถใช้ร่วมกับสินค้าที่คุณสั่งซื้อ'
                    );
                    break;

                case '4113':
                    $errorMessage = array(
                        'en' => 'Voucher is already used.',
                        'th' => 'รหัสคูปองพิเศษนี้ถูกใช้ไปแล้ว'
                    );
                    break;

                case '4114':
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
                case '5001':
                    $errorMessage = array(
                        'en' => 'Coupon code cannot be applied with some of the items you ordered.',
                        'th' => 'สินค้าบางชิ้นในตะกร้าไม่สามารถใช้รหัสคูปองได้'
                    );
                    break;
            }
        }

        $return = array(
            'status' => 'error',
            'code' => !empty($errorCode) ? $errorCode : $errorCodeDefault,
            'description' => $errorMessage[$lang]
        );
        return Response::json($return);
    }

    public function postSetCustomerInfo()
    {
        $user = ACL::getUser();

        $params = Input::only('bank_name',
            'installment',
            'customer_name',
            'customer_email',
//            'customer_address',
            'customer_province_id',
            'customer_city_id',
            'customer_district_id',
            'customer_postcode',
            'customer_tel',
            'customer_address_id',
            'payment_method',
            "bank_id"
        );

        $params['customer_address'] = isset($_REQUEST['customer_address'])?$_REQUEST['customer_address']:"";

        if (Input::get('installment') != "") {
            $params['installment'] = json_encode(array('period' => Input::get('installment')), TRUE);
        } else {
            $params['installment'] = NULL;
        }

        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';

        if ($params['customer_type'] == 'user' && !preg_match("/\@truelife.com$/", $user['email'])) {
            $params['customer_email'] = $user['email'];
        }

        $response = $this->pcms->api('checkout/set-customer-info', $params, 'POST');

        return Response::json($response, 200);
    }

    public function postSelectShipmentMethods()
    {
        $user = ACL::getUser();

        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $params['shipments'] = Input::get('shipments', array());

        $response = $this->pcms->api('checkout/select-shipment-methods', $params, 'POST');

        return Response::json($response, 200);
    }

    public function postSelectShipmentMethodsV2()
    {
        $user = ACL::getUser();

        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $params['shipments'] = Input::get('shipments', array());

        $response = $this->pcms->apiv2('checkout/select-shipment-methods', $params, 'POST', true, 0, 2);

        return Response::json($response, 200);
    }

    public function postSetPaymentInfo()
    {
        $user = ACL::getUser();

        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $params['payment_method'] = Input::get('payment_method');
        $params['installment'] = (Input::get('payment_method') == 3) ? Input::get('installment') : NULL;
        $response = $this->pcms->api('checkout/set-payment-info', $params, 'POST');

        return Response::json($response, 200);
    }

    public function postRemoveItem()
    {
        $user = ACL::getUser();

        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $params['lang'] = Lang::getLocale();
        $params['inventory_id'] = Input::get('inventory_id');

        $response = $this->pcms->api('checkout/remove-item', $params, 'POST');

        return Response::json($response, 200);
    }

    public function postRemoveItemV2()
    {
        $user = ACL::getUser();

        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $params['lang'] = Lang::getLocale();
        $params['inventory_id'] = Input::get('inventory_id');

        $response = $this->pcms->apiv2('checkout/remove-item', $params, 'POST', true, 0, 2);

        return Response::json($response, 200);
    }

    public function postConfirmCheckout()
    {
        $user = ACL::getUser();

        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';

        $response = $this->pcms->api('checkout/confirm', $params, 'POST');

        return Response::json($response, 200);
    }

    public function getProcess()
    {
        $user = ACL::getUser();

        $response = $this->pcms->getCheckout();
        $checkout = $response['data'];
        $rules = array(
            'customer_name' => 'required',
            'customer_address' => 'required',
            'customer_district_id' => 'required',
            'customer_city_id' => 'required',
            'customer_province_id' => 'required',
            'customer_district' => 'required',
            'customer_city' => 'required',
            'customer_province' => 'required',
            'customer_postcode' => 'required',
            'customer_tel' => 'required',
            'customer_email' => 'required|email',
            'items_count' => 'required|min:1',
            'confirm_checkout' => 'required|in:1'
        );

        $validator = Validator::make($checkout, $rules);

        if ($validator->fails()) {
            return Redirect::route('checkout.index');
        }

        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $params['form'] = 1;

        $response = $this->pcms->api('checkout/create-order', $params, 'POST');

        if ($response['code'] != 200) {
            return $this->theme->scope('checkout.error', array('response' => $response))->render();
        }

        return $response['data']['html'];
    }

    public function anyThankyou()
    {
        $orderId = Input::get('order_id');
        if (Input::get('order_id') == null)
            return Redirect::route('home');

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
        $response = $this->pcms->api('payment/detail', $params);
        $ecommerce = $this->pcms->api('payment/item', $params);

        if (array_get($response, 'code') != 200) {
            return Redirect::route('home')->withErrors('Invalid Order');
        }

        if ($this->isMobile()) {
            $this->theme->asset()->container('footer')->usePath()->add('payment_channel', 'js/payment_channel.js', array('jquery'));
        } else {
            $this->theme->asset()->usePath()->add('jquery-reveal', 'css/reveal.css');
            $this->theme->asset()->container('footer')->add('jquery-reveal', 'assets/vendor/jquery.reveal.js', array('jquery'));
            $this->theme->asset()->usePath()->add('checkout', 'css/itruemart.checkout.css');
            $this->theme->asset()->usePath()->add('checkout.resp', 'css/itruemart.checkout.resp.css');
            $this->theme->asset()->usePath()->add('style.print', 'css/print.style.css');
            $this->theme->asset()->container('footer')->usePath()->add('checkout', 'js/checkout-confirm.js', array('jquery'));

        }

        $view['data'] = $response;
        $view['ecommerce'] = $ecommerce;
        if (strtolower(array_get($response, 'data.payment_channel')) === 'offline') {
            if (strtolower(array_get($response, 'data.payment_status')) === 'expired') {
                return $this->theme->scope('checkout.requery', $view)->render();
            } else {
                return $this->theme->scope('checkout.thankyou', $view)->render();
            }
        } else if (strtolower(array_get($response, 'data.payment_channel')) === 'online') {
            if (strtolower(array_get($response, 'data.payment_status')) === 'expired' || strtolower(array_get($response, 'data.payment_status')) === 'failed' || strtolower(array_get($response, 'data.payment_status')) === 'cancel') {
                return $this->theme->scope('checkout.requery', $view)->render();
            } else if (strtolower(array_get($response, 'data.payment_status')) === 'reconcile') {
                return $this->theme->scope('checkout.thankyou', $view)->render();
            } else {
                return $this->theme->scope('checkout.thankyou', $view)->render();
            }
        } else {
            return Redirect::route('home');
        }
    }

    public function getRequery()
    {
        $orderId = Input::get('order_id');

        if (Input::get('order_id') == null) return Redirect::route('home');

        $params['order_id'] = $orderId;
        $user = ACL::getUser();
        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';

        $response = $this->pcms->api('payment/requery', $params, 'POST');

        return Redirect::to('checkout/thank-you?order_id=' . $orderId);
    }

    public function getPrintInternetBill()
    {
        $orderId = Input::get('order_id');
        if (Input::get('order_id') == null)
            return Redirect::route('home');

        $user = ACL::getUser();

        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $params['inventory_id'] = Input::get('inventory_id');
        $params['sso_id'] = $user['ssoId'];
        $params['order_id'] = $orderId;
        $params['lang'] = App::getLocale();

        $response = $this->pcms->api('payment/detail', $params);
        $view['data'] = $response;

        $theme = Theme::uses('itruemart')->layout('print');

        return $theme->scope('checkout.print', $view)->render();
    }

    public function getCheckoutManual()
    {
        $this->theme->asset()->usePath()->add('itruemart-manual', 'css/itruemart.manual.css');
        return $this->theme->scope('checkout.manual')->render();
    }

    public function anyCheckLine($data = array())
    {
        if (!empty($data)) {
            $codePromotion = array();
            $countFlashsale = 0;
            $countLine = 0;
            foreach ($data as $promotion) {
                if ($promotion['type'] == 'flash_sale') {
                    $countFlashsale++;
                    if (!empty($promotion['code'])) {
                        $promotion_code_list = explode('-', $promotion['code']);
                        if ($promotion_code_list[(count($promotion_code_list) - 1)] == 'line') {
                            $countLine++;
                        }
                    }
                }

            }
            if ($countLine > 0 && $countFlashsale > 0) {
                if ($countLine == $countFlashsale) {
                    return true;
                }
            }
            return false;
        }
        return false;

    }

    public function postSetCartInfo()
    {
        $user = ACL::getUser();

        $field = Input::get('field');
        $val = Input::get('val');

        if (!empty($field) && !empty($val)) {
            $params['field'] = $field;
            $params['value'] = $val;
            $params['customer_ref_id'] = $user['user_id'];
            $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        }

        $response = $this->pcms->api('cart/save-cart-info', $params, 'POST');

        return Response::json($response, 200);
    }

    public function postSetBillInfo()
    {
        $user = ACL::getUser();

        $params = Input::only('bill_name', 'bill_province_id', 'bill_city_id', 'bill_district_id', 'bill_address', 'bill_postcode', 'is_new_ccw', 'save_ccw', 'card_token', 'card_label');

        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';

        if ($params['customer_type'] == 'user') {
            $params['customer_email'] = $user['email'];
        }

        $response = $this->pcms->api('cart/save-bill-address', $params, 'POST');

        return Response::json($response, 200);
    }

    public function postCorvertShippingToBill()
    {
        $user = ACL::getUser();

        $params = Input::only('bill_name', 'bill_province_id', 'bill_city_id', 'bill_district_id', 'bill_address', 'bill_postcode');

        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';

        if ($params['customer_type'] == 'user') {
            $params['customer_email'] = $user['email'];
        }


        $response = $this->pcms->api('cart/convert-shipping-to-bill', $params, 'POST');

        return Response::json($response, 200);
    }

    /**
     * @description Check Shipping Available for shipping address
     * @since  May 29, 2014
     * @author  Preme W. <preme_won@truecorp.co.th>
     */
    public function checkShipping()
    {
        $cart = $this->pcms->getCheckout();

        $json = array();

        $json['code'] = 200;
        $json['message'] = __("step2-can-ship");


        if (!empty($cart['data']['shipments'])) {
            foreach ($cart['data']['shipments'] as $ship_key => $ship_value) {
                if (empty($ship_value['available_shipping_methods'])) {
                    $json['code'] = 500;
                    $json['message'] = __("step2-can-not-ship");
                    break;
                } else {
                    if (!empty($ship_value['available_shipping_methods'])) {
                        $available_shipping_methods = array();
                        foreach ($ship_value['available_shipping_methods'] as $av_key => $av_value) {
                            $available_shipping_methods[] = array(
                                'name' => $av_value['name'],
                                'fee' => $av_value['fee'],
                                'description' => $av_value['description']
                            );
                        }
                        $shipments = $available_shipping_methods;
                    }
                }

            }
        }
        $json['shipments'] = (!empty($shipments)) ? $shipments : NULL;
        return Response::json($json, 200);
    }

}
