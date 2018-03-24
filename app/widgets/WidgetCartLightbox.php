<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetCartLightbox extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'cartLightbox';

    /**
     * Watching widget tpl on everywhere.
     *
     * @var boolean
     */
    public $watch = true;

    /**
     * Arrtibutes pass from a widget.
     *
     * @var array
     */
    public $attributes = array(
        'editQty' => true,
        'showShippingMethod' => false,
        'editShippingMethod' => false,
        'maxQty' => 5,
        'itemCount' => 0,
        'showCloseBtn' => false,
        'forceShowRemoveBtn' => false,
        'nextBtnOperation' => 'Close', //Options: "GoCheckout" or "Close"
        'showImage' => true,
        'inventory_wow' => array()
    );

    /**
     * Code to start this widget.
     *
     * @return void
     */
    public function init(Theme $theme)
    {
        // Initialize widget.
        $theme->asset()->container("footer")->add('cartLightbox-css', 'assets/widget/css/cart.css', array());
        $theme->asset()->container("footer")->add('cartLightbox-js', 'assets/widget/js/cartLightboxWidget.js', array());
        //$this->setAttribute('user', User::find($this->getAttribute('userId')));
    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        //$label = $this->getAttribute('label');
        //$this->setAttribute('label', 'changed');
        
        $checkout = $this->getAttribute('checkout');
        $itemCount = 0;
        
        $inventory_wow = $this->getItemIsWow();
        $this->setAttribute('inventory_wow', $inventory_wow);
        
        if(!empty($checkout['shipments'])){
            foreach($checkout['shipments'] as $key=>$shipment){
                foreach ($shipment['items'] as $ikey => $item){
                    $itemCount++;
                }
            }
        }
        $this->setAttribute('itemCount', $itemCount);

        $attrs = $this->getAttributes();
        return $attrs;
    }
    
    private function getItemIsWow()
    {
        $pcms = App::make('pcms');
        $cart = $pcms->getCheckoutV2();

        $discount_campaigns = array_get($cart, 'data.discount_campaigns', array()); // !empty($cart['data']['discount_campaigns'])?$cart['data']['discount_campaigns'] :array();

        $inventory_wow = array();

        $config_setting = Config::get('settings.limit-cart-item-quantity');
        $config_setting = !empty($config_setting)? $config_setting : array("collections"=>array(), 'discount-campaigns'=> array());

        // check discount campaign
        foreach($discount_campaigns as $discount_campaign)
        {
            if(in_array($discount_campaign['type'], $config_setting['discount-campaigns']))
            {
                foreach($discount_campaign['inventory_id'] as $variant_inventory_id)
                {
                    $inventory_wow[$variant_inventory_id] = true;
                }
            }
        }
        
        // check 1 piece collection.

        $cart = array_get($cart,'data.shipments',NULL);

        if($cart){
            foreach($cart as $shipment)
            {   
                foreach($shipment['items'] as $item)
                {   
                    if($item['collections']==NULL)
                    {
                        foreach($item['collections'] as $collection)
                        {
                            if(in_array($collection['pkey'], $config_setting['collections']))
                            {
                                $inventory_wow[$item['inventory_id']] = true;
                            }
                        }
                    }
                }
            }
        }
        return $inventory_wow;
    }

}