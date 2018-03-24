<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetMiniCart extends Widget
{

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'mini-cart';

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
        'editQty' => false,
        'showShippingMethod' => true,
        'editShippingMethod' => false,
        'showDiscount' => true,
        'showTrueyou' => false,
        'showCoupon' => true,
        'maxQty' => 5,
        'user' => array(),
        'trueyouDiscount' => 0,
        'isTUAvailablePage' => false
    );

    /**
     * Code to start this widget.
     *
     * @return void
     */
    public function init(Theme $theme)
    {
        // Initialize widget.

        $platform = ( preg_match("/^m\.|-m\./i", Request::server('HTTP_HOST')) ) ? 'mobile' : 'desktop';
        /**
         * No Loading on checkout/step1 of mobile theme. Because step1 is not a new design 2014.
         * If checkout step1 is changed to new design. You should delete if(){} block
         * To load scripts all page.
         */
        if( ! ( $platform == "mobile" && preg_match("/checkout\/(step1)/i", Request::path()) ) ){
            $theme->asset()->container('footer')->usePath()->add('minicartWidget', 'js/minicartWidget.js');
            $theme->asset()->container('footer')->usePath()->add('minicartFormValidate', 'js/minicartFormValidate.js');
        }

    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        $battrs = $this->getAttributes('showTrueyou');

        $checkout = $this->getAttribute('checkout');
		
		#alert($checkout);

        $user = $this->getAttribute('user');
        /**
         * if there is not user information. I will load it.
         */
        if (empty($user))
        {
            $user = ACL::getUser();
            $this->setAttribute('user', $user);
        }

        $trueyouDiscount = 0;
        $hasCoupon = false;
        if (!empty($checkout['promotions']))
        {
            $promotions = $checkout['promotions'];
            foreach ($promotions as $promotion)
            {
                //check coupon in cart. if $hasCoupon is true. Cart will not show trueyou.
                if(!empty($promotion['type']) && $promotion['type'] == 'coupon_code'){
                    $hasCoupon = true;
                }
                
                if (!empty($promotion['type']) && $promotion['type'] == 'trueyou')
                {
                    $trueyouDiscount += $promotion['totalDiscount'];
                }
            }
        }
        $this->setAttribute('trueyouDiscount', $trueyouDiscount);
        
        if(!empty($checkout['isTrueyouable']) && $checkout['isTrueyouable'] == true && $hasCoupon == false){
            $this->setAttribute('showTrueyou', true);
        }else{
            $this->setAttribute('showTrueyou', false);
        }
		
        /**
         * if this cart is installment cart
         */	
        if (!empty($checkout['type']))
        {
            if($checkout['type'] == 'installment')
            {
                //$this->setAttribute('showCoupon', false);
                $this->setAttribute('showTrueyou', false);
            }
        }		 
		 	
        $attrs = $this->getAttributes();
        return $attrs;
    }

}