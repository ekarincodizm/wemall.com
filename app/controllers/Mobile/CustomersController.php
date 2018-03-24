<?php

namespace Mobile;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use \ACL;
use Illuminate\Support\Facades\Response;
use Theme;

/**
 * Class CustomersController
 *
 * @package Mobile
 */
class CustomersController extends \MobileBaseController {

    /**
     * @var \PcmsClient
     */
    private $pcms;

    public function __construct(\CustomerAddressRepositoryInterface $customerAddress)
    {
        parent::__construct();

        $this->customerAddress = $customerAddress;
        $this->pcms = App::make('pcms');
        $this->theme = Theme::uses('checkout-mobile-2014');
    }

    /**
     * @return mixed
     */
    public function getShippingAddressForm()
    {
        $continue = Input::get('continue', false);
        $shipping_address_id = Input::get('id');

        $address = array();
        $user = ACL::getUser();

        if ($user['group']=='guest') {
            return App::abort('404');
        }

        if (!empty($shipping_address_id)) {
            $address = $this->customerAddress->getAddressDetail($user['user_id'], $shipping_address_id);

            if (!is_array($address) || empty($address)) {
                return App::abort('404');
            }
        }

        $view = array(
            'continue' => $continue,
            'shipping_address_id' => $shipping_address_id,
            'address' => array_get($address, 'data', array()),
            'email' => cleanCustomerEmail(array_get($user, "email", "")),
            'phone' => array_get($user, "phone", "")
        );

        $response = $this->pcms->apiv2('provinces', array(), "GET", false, 1440);
        if (intval($response['code']) == 200 && !empty($response['data'])) {
            $view['provincesList'] = $response['data'];
        }

        if (!empty($address['data']['province_id'])) {
            $city = $this->pcms->apiv2('cities', array('province_id' => $address['data']['province_id']), "GET", false, 1440);
            $view['city'] = $city['data'];
        }

        if (!empty($address['data']['city_id'])) {
            $district = $this->pcms->apiv2('districts', array('city_id' => $address['data']['city_id']), "GET", false, 1440);
            $view['district'] = $district['data'];
        }

        if (!empty($address['data']['district_id'])) {
            $zip_code = $this->pcms->apiv2('zipcodes', array('district_id' => $address['data']['district_id']), "GET", false, 1440);
            $view['zip_code'] = $zip_code['data'];
        }

        $this->theme->asset()->add("js-geolocation", "assets/js/geolocation/geolocation.js", array());
        $this->theme->asset()->add('customer-shipping-address-js', 'assets/js/customer-shipping-address.js', array('jquery'));

        return $this->theme->scope('checkout.shipping_address_form', $view)->render();
    }

    public function postSaveShipAddress()
    {
        $user = ACL::getUser();

        if (!ACL::isLoggedIn()) {
            $response['success'] = false;
            $response['status'] = 'error';
            $response['code'] = '503';
            return Response::json($response, 200);
        }

        $args['customer_ref_id'] = $user['user_id'];
        $args['customer_type'] = 'user';

        $email = Input::get("email", "");
        $args['email'] = !empty($email) ? $email : $user['email'];
        $args['name'] = Input::get('name');
        $args['address'] = isset($_REQUEST['address'])?$_REQUEST['address']:"";//Input::get('address');
        $args['province_id'] = Input::get('province_id');
        $args['city_id'] = Input::get('city_id');
        $args['district_id'] = Input::get('district_id');
        $args['postcode'] = Input::get('postcode');
        $args['phone'] = Input::get('phone', $user['phone']);
        $args['id'] = Input::get('address_id');

        if (empty($args['id'])) {
            $response = $this->customerAddress->createAddress($args);
        } else {
            $response = $this->customerAddress->updateAddress($args);
        }

        return Response::json($response, 200);
    }

    public function postDeleteShipAddress()
    {
        if (!ACL::isLoggedIn()) {
            $response['success'] = false;
            $response['status'] = 'error';
            $response['code'] = '503';
            return Response::json($response, 200);
        }

        if (Input::has('id')) {
            $address_id = Input::get('id');
            $response = $this->customerAddress->deleteAddress($address_id);

            $json = array();
            if ($response['code'] == 200) {
                $json['code'] = $response['code'];
                $json['message'] = __('step2-delete-success');
                $json['return_id'] = Input::get('id');
            }

            return Response::json($json);
        } else {
            $json = array(
                'code' => 404,
                'message' => 'Not found id in database',
            );

            return Response::json($json);
        }
    }

}

