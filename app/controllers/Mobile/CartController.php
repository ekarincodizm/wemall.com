<?php

namespace Mobile;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use \ACL;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Session;
use Request;
use Redirect;

class CartController extends \MobileBaseController {

    private $pcms;

    public function __construct()
    {
        parent::__construct();

        $this->pcms = App::make('pcms');
    }

    public function getIndex()
    {
        // Redirect Back to HTTP not HTTPS
        if (Request::secure())
        {
            return Redirect::to(Request::server("REQUEST_URI",'cart'), 302, array(),false);
        }

        $this->theme->layout('default');

        $view = array();

        $this->theme->asset()->usePath()->add('cart', 'css/cart.css', array('core'));
        $this->theme->asset()->container('footer')->usePath()->add('cart', 'js/cart.js', array('jquery'));

        return $this->theme->scope('cart.index', $view)->render();
    }

    public function getContent()
    {
        $this->theme->layout('blank');

        $checkout = $this->pcms->getCheckoutV2();
        $checkout = isset($checkout['data']) ? $checkout['data'] : array();

        $hasItems = ( ! empty($checkout['shipments'])) ? "1" : "0";



        $ref = Input::get('ref');
        if (strpos($ref, '/cart') !== false)
        {
            $ref = URL::toLang('/');
        }

        $sessionRef = Session::get('cart-ref');
        if (strpos($ref, '/cart') === false && $ref != URL::toLang('/'))
        {
            if ($ref != $sessionRef)
            {
                Session::put('cart-ref', $ref);
            }
        }

        // came from checkout/step2 show shipping methods
        $showSelectShippingMethod = preg_match('#checkout/step2#', Input::get('ref'));

        $continueButtonUrl = '';
        $items_count = isset($checkout['items_count']) ? $checkout['items_count'] : 0;
        if ($items_count > 0) // has items
        {
            if (Input::has('continue')) // callback url passed
            {
                $continueButtonUrl = Input::get('continue');
            }
            else // go to checkout
            {
                $continueButtonUrl = URL::toLang('checkout/step1');
            }
        }
        else // no items
        {
            $sessionRef = Session::get('cart-ref');
            $continueButtonUrl = $sessionRef ?: $ref; // referer url
        }
        $continueButtonText = ($items_count > 0) ? __('inst-next') : __('thankyou-goto-home');


        $backButtonUrl = $ref; // referer url
        $backButtonText = __('thankyou-goto-home');

        $limitQuantity = getLimitQuantityFromCheckout($checkout);

        $view = compact('limitQuantity', 'hasItems', 'checkout', 'showSelectShippingMethod', 'continueButtonUrl', 'continueButtonText', 'backButtonUrl', 'backButtonText');

        return $this->theme->scope('cart.content', $view)->render();
    }

    public function postAddItem()
    {
        $user = ACL::getUser();

        $_params['customer_ref_id'] = $user['user_id'];
        $_params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $_params['inventory_id'] = Input::get('inventory_id');
        $_params['qty'] = Input::get('qty', 1);
        $_params['type'] = Input::get('type', 'normal');

        $response = $this->pcms->apiv2('cart/add-item', $_params, 'POST', false, 6, 2);

        return Response::json($response, 200);
    }

    public function postUpdateItem()
    {
        $user = ACL::getUser();

        $_params['customer_ref_id'] = $user['user_id'];
        $_params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $_params['items'] = array(Input::get('inventory_id') => Input::get('qty'));

        $response = $this->pcms->api('checkout/update-items', $_params, 'POST');

        return Response::json($response, 200);
    }

    public function postRemoveItem()
    {
        $user = ACL::getUser();

        $_params['customer_ref_id'] = $user['user_id'];
        $_params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $_params['inventory_id'] = Input::get('inventory_id');

        $response = $this->pcms->api('checkout/remove-item', $_params, 'POST');

        return Response::json($response, 200);
    }

    public function postSelectShippingMethods()
    {
        $user = ACL::getUser();

        $_params['customer_ref_id'] = $user['user_id'];
        $_params['customer_type'] = ACL::isLoggedIn() ? 'user' : 'non-user';
        $_params['shipments'] = array(Input::get('shipment_key') => Input::get('pkey'));

        $response = $this->pcms->api('checkout/select-shipment-methods', $_params, 'POST');

        return Response::json($response, 200);
    }

    public function getMiniCart()
    {
        $this->theme->layout('blank');

        $cart = $this->pcms->getCart();
        $cart = $cart['data'];

        $view = compact('cart');

        $content = $this->theme->scope('cart.mini-cart', $view)->render()->getContent();
        return Response::make($content, 200, array('Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate'));
    }

//    public function getWowInCart()
//    {
//        $cart = $this->pcms->getCart();
//        $discount_campaigns = array_get($cart, 'data.discountCampaignData') ?: array();
//
//        $wow_inventory_id_in_cart = array();
//
//        foreach($discount_campaigns as $discount_campaign)
//        {
//            $discount_inventory_id_array = $discount_campaign['inventory_id'];
//            foreach($discount_inventory_id_array as $discount_inventory_id)
//            {
//                $wow_inventory_id_in_cart[$discount_inventory_id] = $discount_campaign['type'];
//            }
//        }
//
//        return $wow_inventory_id_in_cart;
//    }

}

