<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetProductsPromotion extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'products-promotion';

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
        'product' => array(),
        "installable" => false
    );

    /**
     * Code to start this widget.
     *
     * @return void
     */
    public function init(Theme $theme)
    {
        // Initialize widget.

        //$theme->asset()->usePath()->add('widget-name', 'js/widget-execute.js', array('jquery', 'jqueryui'));
        //$this->setAttribute('user', User::find($this->getAttribute('userId')));
    }

    private function getPrice($product)
    {
        $price = $product['price_range']['max'];
        $net_price = $product['net_price_range']['max'];

        if ($price < $net_price)
        {
            $price = $net_price;
        }

        return $price;
    }

    private function getSpecialPrice($product)
    {
        return $product['special_price_range']['min'];
    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        $language = Lang::locale();
        $product = $this->getAttribute('product');
        $installable = $this->getAttribute("installable");


        /**
         * To Checkout that product installment available.
         */
        if(!empty($product["payment_methods"])){
            foreach($product["payment_methods"] as $payment_method){
                if($payment_method["pkey"] == "156813837979402"){
                    $installable = true;
                }
            }
        }

        $group_count = 0;
        $group_periods = array();

        if(!empty($product['bank_installments']))
        {
            foreach($product['bank_installments'] as $key => $row)
            {
                if(!empty($row['periods']))
                {
                    foreach($row['periods'] as $pe_key => $pe_row)
                    {
                        if(! in_array($pe_row, $group_periods))
                        {
                            $group_periods[] = $pe_row;
                        }
                    }
                }
            }
        }
        else
        {
            $product['bank_installments'] = array();
        }

        $data_periods = array();

        if(!empty($group_periods))
        {
            rsort($group_periods);
            foreach($group_periods as $gp_key => $gp_row)
            {
               foreach($product['bank_installments'] as $bi_key => $bi_row)
               {
                   if(!empty($bi_row['periods']))
                   {
                       foreach($bi_row['periods'] as $bp_key => $bp_row)
                       {
                           if($bp_row == $gp_row)
                           {
                               $data_periods[$gp_key]['month'] = $gp_row;
                               $data_periods[$gp_key]['bank'][] = $bi_row;
                           }
                       }
                   }
               }

            }
        }

        $attrs  =   array(
                        'group_count' => count($group_periods),
                        'group_periods' => $group_periods,
                        'data_periods' => $data_periods,
                        "installable" => $installable
                    );
        return $attrs;
    }
}
