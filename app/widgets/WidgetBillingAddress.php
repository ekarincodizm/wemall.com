<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetBillingAddress extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'billing-address-form';

    /**
     * Watching widget tpl on everywhere.
     *
     * @var boolean
     */
    public $watch = false;

    /**
     * Arrtibutes pass from a widget.
     *
     * @var array
     */
    public $attributes = array();

    /**
     * Code to start this widget.
     *
     * @return void
     */
    public function init(Theme $theme)
    {
        // Initialize widget.

        $platform = ( preg_match("/^m\.|-m\./i", Request::server('HTTP_HOST')) ) ? 'mobile' : 'desktop';
        // Load on checkout/step3 only. Because step1,2 is not a new design 2014.
        if( $platform=="mobile" && preg_match("/checkout\/(step3)/i", Request::path())){
            $theme->asset()->container("footer")->usePath()->add('billing-address', 'js/billing-address-form.js', array('jquery'));
        }

        //$theme->asset()->usePath()->add('widget-name', 'js/widget-execute.js', array('jquery', 'jqueryui'));
        //$this->setAttribute('user', User::find($this->getAttribute('userId')));
    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        $attrs = $this->getAttributes();
		$pcms = App::make('pcms');
		
		// fix wait for billing address from cart
#		alert($attrs, 'red', 'attr first');

		$address = array(
			'customer_province_id' 	=> !empty($attrs['cart']['data']['bill_province_id'])? $attrs['cart']['data']['bill_province_id']:0 ,
			'customer_city_id' 		=> !empty($attrs['cart']['data']['bill_city_id'])? $attrs['cart']['data']['bill_city_id']:0,
			'customer_district_id' 	=> !empty($attrs['cart']['data']['bill_district_id'])? $attrs['cart']['data']['bill_district_id']:0,
			'customer_postcode' 	=> !empty($attrs['cart']['data']['bill_postcode'])? $attrs['cart']['data']['bill_postcode']:0,
		);
		
		$attrs = array(
			'provincesList' => array(),
			'city' => array(),
			'district' => array(),
			'zip_code' => array()
		);
		
		$response = $pcms->apiv2('provinces', array(), "GET", false, 1440);
        
		if(intval($response['code']) == 200 && !empty($response['data'])){
            $attrs['provincesList'] = $response['data'];
        }

        if ( ! empty($address['customer_province_id']))
        {
            $city = $pcms->apiv2('cities', array('province_id' => $address['customer_province_id']), "GET", false, 1440);
            $attrs['city'] = $city['data'];
        }
        if ( ! empty($address['customer_city_id']))
        {
            $district = $pcms->apiv2('districts', array('city_id' => $address['customer_city_id']), "GET", false, 1440);
            $attrs['district'] = $district['data'];
        }
        if ( ! empty($address['customer_district_id']))
        {
            $zip_code = $pcms->apiv2('zipcodes', array('district_id' => $address['customer_district_id']), "GET", false, 1440);
            $attrs['zip_code'] = $zip_code['data'];
        } 

		
		$attrs['address'] = $address;
        return $attrs;
    }
}