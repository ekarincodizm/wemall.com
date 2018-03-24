<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetShippingAddress extends Widget
{

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'shipping-address-list';

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
    public $attributes = array(
        'user' => array(),
        'currentAddress' => 0
    );

    /**
     * Code to start this widget.
     *
     * @return void
     */
    public function init(Theme $theme)
    {
        // Initialize widget.

    }

    private $customerAddressRepo;
    private $pcms;

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        $user = $this->getAttribute('user');
        $new_addr = $this->getAttribute('new_addr');

        $this->customerAddressRepo = App::make("CustomerAddressRepositoryInterface");
        $this->pcms = App::make("pcms");

        $customerAddress = $this->customerAddressRepo->getAddress($user['ssoId']);

        $cart = $this->pcms->getCheckoutV2();
        $this->setAttribute("currentAddress", $this->getCurrentAddress($cart));

        if (!isset($customerAddress["data"])) {
            $customerAddress = array();
        } else {
            $customerAddress["data"] = $this->setNodes($customerAddress["data"]);
            if ($new_addr != 0) {
                $this->setAttribute("currentAddress", $this->getCurrentAddress($customerAddress["data"][0]));
            }
        }

        $this->setAttribute('shipping_address', $customerAddress);

        return $this->getAttributes();
    }

    private function getCurrentAddress($cart){
        return !empty($cart["data"]["customer_address_id"]) ? htmlentities($cart["data"]["customer_address_id"]) : 0;
    }

    private function setNodes($data)
    {
        foreach ($data as $key => $value) {
            $tmpAddress = "";
            if (!empty($value["address"])) {
                $tmpAddress .= $value["address"];
            }

            if (!empty($value["district_name"])) {
                $tmpAddress .= " " . $value["district_name"];
            }

            if (!empty($value["city_name"])) {
                $tmpAddress .= " " . $value["city_name"];
            }

            if (!empty($value["province_name"])) {
                $tmpAddress .= " " . $value["province_name"];
            }

            if (!empty($value["postcode"])) {
                $tmpAddress .= " " . $value["postcode"];
            }

            $data[$key]["full_address"] = $tmpAddress;

            if (empty($value["customer_name"])) {
                $data[$key]["customer_name"] = "";
            }

            if (empty($value["customer_addresses_id"])) {
                $data[$key]["customer_addresses_id"] = "";
            }

            $backUrl = URL::toLang("checkout/step2");
            $data[$key]["edit_url"] = URL::toLang("customers/edit-shipping-address?id=" . $value["customer_addresses_id"] . "&continue=" . $backUrl);

        }

        return $data;
    }
}