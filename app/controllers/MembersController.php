<?php

class MembersController extends FrontBaseController {

    protected $sso;

    /**
     * @var PcmsClient
     */
    protected $pcms;

    protected $lang;
    protected $payment_status = array(
        'th' => array(
            "payment_pending" => "Payment Pending",
            "success" => "Success",
            "cancelled" => "Cancelled",
            "expired" => "Expired",
            "failed" => "Failed",
            "refund_pending" => "Refund Pending",
            "refund_complete" => "Refund Complete",
            "refund_rejected" => "Refund Rejected",
        ),
        'en' => array(
            "payment_pending" => "Payment Pending",
            "success" => "Success",
            "cancelled" => "Cancelled",
            "expired" => "Expired",
            "failed" => "Failed",
            "refund_pending" => "Refund Pending",
            "refund_complete" => "Refund Complete",
            "refund_rejected" => "Refund Rejected",
        ),
    );
    protected $item_status = array(
        'th' => array(
            "new" => "-",
            "order_pending" => "Order Pending",
            "waiting_for_po" => "Waiting For PO",
            "po_created" => "PO Created",
            "received" => "Received",
            "pending_shipment" => "Pending Shipment",
            "shipped" => "Shipped",
            "customer_cancelled" => "Customer Cancelled",
            "failed_delivery" => "Failed Delivery",
            "delivered" => "Delivered",
            "return_pending" => "Return Pending",
            "return_rejected" => "Return Rejected",
            "return_completed" => "Return Completed",
            "shipped_for_return_rejected" => "Shipped for Return Rejected",
            "replacement_pending" => "Replacement Pending",
            "replacement_complete" => "Replacement Complete",
            "replacement_rejected" => "Replacement Rejected",
        ),
        'en' => array(
            "new" => "-",
            "order_pending" => "Order Pending",
            "waiting_for_po" => "Waiting For PO",
            "po_created" => "PO Created",
            "received" => "Received",
            "pending_shipment" => "Pending Shipment",
            "shipped" => "Shipped",
            "customer_cancelled" => "Customer Cancelled",
            "failed_delivery" => "Failed Delivery",
            "delivered" => "Delivered",
            "return_pending" => "Return Pending",
            "return_rejected" => "Return Rejected",
            "return_completed" => "Return Completed",
            "shipped_for_return_rejected" => "Shipped for Return Rejected",
            "replacement_pending" => "Replacement Pending",
            "replacement_complete" => "Replacement Complete",
            "replacement_rejected" => "Replacement Rejected",
        )
    );

    public function __construct()
    {
        parent::__construct();

        $this->lang = App::getLocale();
        $this->pcms = App::make('pcms');
    }

    public function ssoProfile() {
//        if ( App::environment('production') || App::environment("beta") )
//        {
//            // The environment is production
//            $open_https = true;
//        }
//        else
//        {
//            $open_https = false;
//        }
        $open_https = Config::get("https.useHttps");

        $this->sso = new TrueSSO(Config::get('endpoints.sso'));
        $accessToken = Input::get('accessToken');
        $user = $this->sso->getUserByAccessToken($accessToken);
        //alert($user, 'red');
        //exit;

        $requestUri = Request::server('REQUEST_URI');
        $html = '<div class="on-login">';
        if (preg_match("/(step1|step3)/", $requestUri)) {
            $html .= '<div class="pic-profile" style="background-image:url(http://image.platform.truelife.com/' . $user->result_data->uid . '/avatar?key=1&w=30&h=30);"></div>';
        }

        $html .= '<div class="name-profile">
                        <a data-toggle="dropdown" href="#">' . $user->result_data->display_name . '</a>
                        <span class="caret"></span>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="' . URL::toLang('member/profile', array(), $open_https) . '">' . __('My Profile') . '</a></li>
                            <li><a href="' . URL::toLang('member/orders', array(), $open_https) . '">' . __('Check my order') . '</a></li>
                            <li class="divider"></li>
                            <li><a href="' . url('auth/logout', array(), $open_https) . '">' . __('logout') . '</a></li>
                        </ul>
                    </div>
                </div>';

        return $html;
    }

    public function getProfile() {

        $user = ACL::getUser();
        if (@$user['group'] == 'guest') {
            return Redirect::to(URL::toLang('/auth/login?continue=' . URL::current()));
        }

        $pcms = App::make('pcms');

        // get user from cart
        $cart = $pcms->getCart();

        if (!empty($cart['data']['cart_trueyou'])) {
            $view['thai_id'] = $cart['data']['cart_trueyou']['thai_id'];
            $view['card'] = $cart['data']['cart_trueyou']['card'];
            $view['checked'] = 1;
        } else {
            $view['checked'] = 0;
        }

        //$dataUser = User::find($user['user_id']);

        $addresses = $pcms->getCustomerAddresses();

        $view['addresses'] = $addresses;

        $response = $pcms->api('provinces');
        $provinces = array();
        foreach ($response['data'] as $val) {
            $provinces[$val['id']] = $val['name'];
        }
        $provinceOptions = array('0' => '------ ' . __('select') . ' ------') + $provinces;
        $cityOptions = array('0' => '------ ' . __('select') . ' ------');
        $districtOptions = array('0' => '------ ' . __('select') . ' ------');

        $view['provinceOptions'] = $provinceOptions;
        $view['cityOptions'] = $cityOptions;
        $view['districtOptions'] = $districtOptions;

        $view['user'] = ACL::getUser();

        if ($view['user']['trueyou'] == null) {
            $view['checked'] = 0;
        } else {
            $view['checked'] = 1;
        }

        $lastlogin = $pcms->api('lastlogin/' . $view['user']['ssoId']);
        if (empty($lastlogin['data'])) {
            $view['lastlogin'] = '';
        } else {
            $view['lastlogin'] = $lastlogin['data'][0]['login_at'];
        }

        $this->theme->asset()->usePath()->add('jquery-reveal', 'css/reveal.css');
        $this->theme->asset()->container('footer')->add('jquery-reveal', 'assets/vendor/jquery.reveal.js', array('jquery'));
        $this->theme->asset()->usePath()->add('profile', 'css/itruemart.profile.css');
        $this->theme->asset()->container('footer')->usePath()->add('itruemart-profile', 'js/itruemart.profile.js', array('jquery'));
        $this->theme->asset()->container('footer')->usePath()->add('member-profile', 'js/member-profile.js', array('jquery'));

        return $this->theme->scope('member.profile', $view)->render();
    }

    public function postProfile() {
        $pcms = App::make('pcms');

        $user = ACL::getUser();

        $params['customer_ref_id'] = $user['user_id'];
        $params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';

        $params['id'] = Input::get('shipping_address_list', 0);

        $params['name'] = Input::get('name');
        $params['email'] = Input::get('email');
        $params['address'] = isset($_REQUEST['address'])?$_REQUEST['address']:"";
        $params['province_id'] = Input::get('province_id');
        $params['city_id'] = Input::get('city_id');
        $params['district_id'] = Input::get('district_id');
        $params['postcode'] = Input::get('postcode');
        $params['phone'] = Input::get('phone');

        $pcms->api('customers/address', $params, 'POST');

        return Redirect::back();
    }

    public function postCheckIdCard() {
        $pcms = App::make('pcms');

        $id_card = Input::get('id_card');
        // ย้ายไป pcmsClient
        $trueyou_result = $pcms->getCheckTrueyouByIdCard($id_card);
        // red or back card
        $card = array_get($trueyou_result, 'data.card');


        if ($card != false) {
            Session::put('profile.thai_id', $id_card);
            Session::put('profile.trueyou', $card);

            //store trueyou to member
            $pcms->postApplyTrueyouCard($id_card);
            //run apply trueyou for discount
            //$apply_result = $pcms->applyTrueyouToCart($id_card);
        }

        return Redirect::back();
    }

    protected function rewriteData($order){
        if (empty($order)) {
            return array();
        }

        foreach($order as $idx=>$o){
            $full_address = "";
            $count = 0;

            foreach($o["shipments"] as $shipment){
                $count += array_get($shipment, "items_count", 0);
            }

            $full_address .= (!empty($o['customer_address']))? $o['customer_address'] . " " : "";

            if(!empty($o['customer_province']) && !empty($o['customer_district'])){
                $full_address .= ($o['customer_province'] == 'กรุงเทพมหานคร')? __("step2-special-subdistrict") . " " :  __("step2-subdistrict") . " ";
            }
            $full_address .= (!empty($o['customer_district']))? $o['customer_district'] . " " : "";

            if(!empty($o['customer_province']) && !empty($o['customer_city'])){
                $full_address .= ($o['customer_province'] == 'กรุงเทพมหานคร')? __("step2-special-district") . " " : __("step2-district") . " ";
            }
            $full_address .= (!empty($o['customer_city']))? $o['customer_city'] . " " : '';
            $full_address .= (!empty($o['customer_province']) && $o['customer_province'] != 'กรุงเทพมหานคร' && $o['customer_province'] != 'BANGKOK')? __("step2-province") . " " : "";
            $full_address .= (!empty($o['customer_province']))? $o['customer_province'] . " " : "";
            $full_address .= (!empty($o['customer_postcode']))? $o['customer_postcode'] . " " : "";

            $order[$idx]["total_item"] = $count;
            $order[$idx]["customer_full_address"] = $full_address;
        }
        return $order;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */

    public function getOrder()
    {
        $user = ACL::getUser();
        $user_group = array_get($user, 'group', 'guest');
        if ($user_group === 'guest') {
            return Redirect::route('auth.login', array('continue' => URL::current()));
        }

        $user_sso_id = array_get($user, 'ssoId', null);

        // defined view data
        $view = array();
        $view["lang"] = $this->lang;
        $view['user'] = $user;
        $view['display_name'] = array_get($user, "display_name", "");
        $view['avatar'] = '/themes/itruemart/assets/images/icon_personal.png';
        $view["user_trueyou_card"] = array_get($user, "trueyou", "");
        $view['lastlogin'] = '';
        $view['order'] = array();
        $view['page'] = 1;
        $view['total_page'] = 1;

        $view['payment_status'] = $this->payment_status[$this->lang];
        $view['item_status'] = $this->item_status[$this->lang];

        $lastlogin = $this->pcms->api('lastlogin/' . $user_sso_id);
        if (!empty($lastlogin['data'])) {
            $view['lastlogin'] = array_get($lastlogin, 'data.0.login_at');
            $view['lastlogin'] = formatDate($view['lastlogin'], "d M y H:i:s", $this->lang);
        }

        $params['customer_ref_id'] = $user_sso_id;
        $params['page'] = Input::get('page', 1);
        $params['limit'] = 5;
        $params['lang'] = $this->lang;

        $orders = $this->pcms->api('customers/orders', $params, 'GET');
        $orders = array_get($orders, 'data', false);
        if ($orders) {
            $view['order'] = array_get($orders, 'orders', array());
            $view['order'] = $this->rewriteData($view['order']);
            $view['page'] = intval($params['page']);
            $view['total_page'] = ceil( array_get($orders, 'total', 1) / $params['limit'] );
        }

        $view["pagination"] = array(
            "page" => $view['page'],
            "total_page" => $view['total_page'],
            "link" => URL::toLang("member/orders")
        );

        $this->theme->breadcrumb()->add(__('breadcrumb-order-list'), URL::toLang('member/orders'));
        $this->theme->asset()->container('footer')->usePath()->add("main-tracking-css", "css/main-tracking.css");
        $this->theme->asset()->container("footer")->usePath()->add("main-tracking-js", "js/main-tracking.js", array());

        return $this->theme->scope('member.order_tracking', $view)->render();
    }

    public function getConfirmEmail() {
        $memberRepo = App::make('MemberRepository');

        $email = Input::get('email');
        $activateCode = Input::get('code');

        $success = false;

        if ($email != false && $activateCode != false) {
            if ($uid = ActivateCode::check($email, $activateCode)) {
                if ($memberRepo->memberConfirmed($email, $uid)) {
                    $success = true;
                }
            }
        }

        $view = compact('success', 'email');
        return $this->theme->scope('member.confirm_email', $view)->render();
    }

    public function getResentEmail() {
        $memberRepo = App::make('MemberRepository');

        $email = Input::get('email');
        $success = false;

        $lastActivateCode = ActivateCode::whereEmail($email)->get()->last();

        if ($lastActivateCode != false) {
            $memberRepo->sendEmailActivate($email, $lastActivateCode->code);
            $success = true;
        }

        $view = compact('success', 'email');
        return $this->theme->scope('member.resent_email', $view)->render();
    }

    public function getManageCCW() {
        $pcms = App::make('pcms');
        $view = array();

        $user = ACL::getUser();
        $view['user'] = $user;
        $lastlogin = $pcms->api('lastlogin/' . $view['user']['ssoId']);
        if (empty($lastlogin['data'])) {
            $view['lastlogin'] = '';
        } else {
            $view['lastlogin'] = $lastlogin['data'][0]['login_at'];
        }

        //get credit card list
        if (!empty($user['ssoId'])) {
            $_params = array();
            $_params['ssoId'] = $user['ssoId'];
            $res = $pcms->api("credit-card/card-list", $_params);

            if ($res['code'] == 200 && !empty($res['data'])) {
                $view['ccw_list'] = $res['data'];
            } else {
                $view['ccw_list'] = array();
            }
        }


        $this->theme->asset()->usePath()->add('member.manage-ccw', 'js/member.manage-ccw.js', array());
        return $this->theme->scope('member.manage_ccw', $view)->render();
    }

    public function postRemoveCCW() {
        try {
            $tokenId = Input::get("key", "");

            $validator = Validator::make(
                            array('tokenId' => $tokenId), array('tokenId' => 'required|numeric')
            );

            if ($validator->fails()) {
                throw new Exception($validator->messages()->first(), 400);
            }

            $pcms = App::make('pcms');
            $_params = array();
            $_params['tokenId'] = $tokenId;

            $res = $pcms->api("credit-card/remove-credit-card", $_params, "POST");

            if ($res['code'] != 200) {
                throw new Exception($res['message'], 400);
            }

            return API::createResponse($res['message'], 200);
        } catch (Exception $e) {
            return API::createResponse($e->getMessage(), 400);
        }
    }

    public function getTrackingData()
    {
        $tracking_no = Input::get('tracking_no', NULL);

        $response = array(
            'status' => '',
            'code' => 400,
            'data' => array()
        );

        // Check input data
        if (empty($tracking_no)) {
            $response['status'] = "Tracking number is null";
            return Response::json($response);
        }

        $pcms = App::make('pcms');
        $params = array(
            'tracking_number' => $tracking_no
        );

        // Get tracking data API
        $tracking_data = $pcms->api("order-tracking/delivery-data", $params, "GET");

        // Check data return from API
        if (!isset($tracking_data['data']) || empty($tracking_data['data'])) {
            $response['status'] = 'Data not found';
            $response['code'] = 400;
            return Response::json($response);
        }

        if (isset($tracking_data['data']['delivery_data'])) {
            foreach ($tracking_data['data']['delivery_data'] as $key => $value) {
                $date = date("Y-m-d", strtotime($value['date']));
                $tracking_data['data']['delivery_data'][$key]['datetime'] = formatDate($date." ".$value['time'], "d M Y H:i:s", $this->lang);
            }
        }

        $response['status'] = 'success';
        $response['code'] = 200;
        $response['data'] = $tracking_data['data'];

        return Response::json($response);
    }

}
