<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetProductsPriceBox extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'products-price-box';

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
        'has_variants' => array(),
        'variants' => array(),
        'netprice_range' => array(),
        'specialprice_range' => array(),
        'variants_color' => array(),
        'variants_size' => array()
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

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        $product = $this->getAttribute('product');

        $this->setAttribute('is_wow', $this->getIsWow($product));

        $this->setAttribute('netprice_range', $this->getNetPriceRange());
        $this->setAttribute('specialprice_range', $this->getSpecialPriceRange());


        $hasVariants = $product['has_variants'];
        $this->setAttribute('has_variants', $hasVariants);
        $variantsArray = array();
        if($hasVariants == '1')
        {
            $this->setAttribute('variants_color', $this->getVariantsColor());
            $this->setAttribute('variants_size', $this->getVariantsSize());
            // read all variants data
            // $i = 0;
            // $styleTypes = $product['style_types'];

            // foreach ($styleTypes as $type) {
            //     $typeName = $type['name'];
            //     $j = 0;
            //     $variantsArray['typeName'][$i] = array($typeName);
            //     // dd($variantsArray);
            //     foreach ($type['options'] as $option) {
            //         $optionName = $option['text'];
            //         $optionType = $option['meta']['type'];
            //         $optionValue = $option['meta']['value'];

            //         d($optionName);
            //         d($optionType);
            //         d($optionValue);
            //         $variantsArray['typeName'][$i]['options'][$j] = array(
            //             'type' => $optionType,
            //             'value' => $optionValue
            //         );
            //         $j++;

            //     }
            //     $i++;
            // }
            // dd($variantsArray);
            // $tm = $this->getAttributes('has_variants');
            // dd($tm);
            // dd('end');
        }
        else
        {
            // read data
        }

        $attrs = array();


        ### For marketing tag ###
        $itma_price = 0;
        $pkey = !empty($product['pkey'])? $product['pkey']: 'null';

        $productName = !empty($product['title'])? $product['title']:'null'; 
        /* typeidea script */
        $productBrand = !empty($product['brand']['name'])? $product['brand']['name']:'null';
        /* //typeidea script */

        if(!empty($product['price_range']['min']))
        {
            $itma_price = $product['price_range']['min'];
        }
        /* typeidea script */
        $marketing_script = '
            var itma_price = "'.(float)(str_replace(',', '', $itma_price)).'";'.'
            var itma_product_id = "'.$pkey.'";'.'
            var itma_product_name = "' . htmlspecialchars($productName) . '";
            var itma_product_brand = "' . htmlspecialchars($productBrand) . '";
            ';
        /* //typeidea script */

        $this->theme->append('marketing_tag', $marketing_script);
        ### End For marketing tag ###

        // START Criteo tag
        $this->theme->append('criteo_tag', criteoTagLevelD($pkey));
        // END Criteo tag

        return $attrs;
    }

    private function getNetPriceRange()
    {
        $product = $this->getAttribute('product');

        $netpricemin = number_format($product['net_price_range']['min'], 0);
        $netpricemax = number_format($product['net_price_range']['max'], 0);

        $netprice = array('min' => $netpricemin, 'max' => $netpricemax);

        return $netprice;
    }

    private function getSpecialPriceRange()
    {
        $product = $this->getAttribute('product');

        $specialpricemin = number_format($product['special_price_range']['min'], 0);
        $specialpricemax = number_format($product['special_price_range']['max'], 0);

        if ($specialpricemin == 0 && $specialpricemax != 0) {
            $specialpricemin = number_format($product['price_range']['min'], 0);
            $specialpricemax = number_format($product['price_range']['max'], 0);
        }

        if ($specialpricemin == $product['net_price_range']['min'] && $specialpricemax == $product['net_price_range']['max']) {
            $specialpricemin = 0;
            $specialpricemax = 0;
        }

        $specialprice = array('min' => $specialpricemin, 'max' => $specialpricemax);

        return $specialprice;
    }

    private function getVariantsColor()
    {
        $product = $this->getAttribute('product');
        $styleTypes = $product['style_types'];
        $variants = array();
        $i = 0;
        foreach ($styleTypes as $type)
        {
            // if($type['name'] == 'สี')
            if($type['pkey'] == '101')
            {
                foreach ($type['options'] as $color)
                {
                    $colorvariants[$i] = array(
                        'media_type' => $color['meta']['type'],
                        'colorText' => $color['text'],
                        'color_meta_type' => $color['meta']['type'],
                        'color_meta_value' => $color['meta']['value'],
                        'pkey' => $color['pkey']
                        );
                    $i++;
                }
                $variants = array('media_set' => $type['media_set'], 'color_variants' => $colorvariants);
            }
        }
        // dd($variants);
        return $variants;
    }

    private function getVariantsSize()
    {
        $product = $this->getAttribute('product');
        $styleTypes = $product['style_types'];
        $variants = array();
        $i = 0;
        foreach ($styleTypes as $type)
        {
            // if($type['name'] == 'ขนาด')
            if($type['pkey'] == '202')
            {
                foreach ($type['options'] as $size)
                {
                    $sizevariants[$i] = array(
                        'media_type' => $size['meta']['type'],
                        'sizeText' => $size['text'],
                        'size_meta_type' => $size['meta']['type'],
                        'size_meta_value' => $size['meta']['value'],
                        'pkey' => $size['pkey']
                        );
                    $i++;
                }
                $variants = array('media_set' => $type['media_set'], 'size_variants' => $sizevariants);
            }
        }
        // dd($variants);
        return $variants;
    }

    public function getIsWow($product)
    {
        $isWow = array();
        $config_setting = Config::get('settings.limit-cart-item-quantity');
        $config_setting = !empty($config_setting)? $config_setting : array("collections"=>array(), 'discount-campaigns'=> array());
        foreach($product['variants'] as $variant)
        {
            $isWow[$variant['inventory_id']] = false;

            if(!empty($variant['active_special_discount']))
            {
                if(in_array($variant['active_special_discount']['campaign_type'], Config::get('settings.limit-cart-item-quantity.discount-campaigns', array()))
                        && time() < strtotime($variant['active_special_discount']['ended_at']))
                {
                    $isWow[$variant['inventory_id']] = true;
                }
            }
        }

        foreach($product['collections'] as $collection)
        {
            if(in_array($collection['pkey'], $config_setting['collections']))
            {
                 foreach($product['variants'] as $variant)
                {
                    $isWow[$variant['inventory_id']] = true;
                }
            }
        }

        return $isWow;
    }




    /**
     * Point of this function is genarating an array that contains inventory id of variant of current product and
     * inventory id of variant of item in cart. This return array have key is inventory_id and value is number.
     * Let value of non-wow variants are 0, value of wow variants (out of cart) are sequential digit 1 to 99 and
     * value of wow variants (picked in cart) are 100, 200, ... (wow variant in same product have a same value).
     *
     * @return array
     */
//     private function getWowInventoriesInCart()
//     {
//         $pcms = App::make('pcms');
//         $cart = $pcms->getCart();

//         $discount_campaigns = array_get($cart, 'data.discountCampaignData') ?: array();

//         $wow_inventory_id_in_cart = array();

//         foreach($discount_campaigns as $discount_campaign)
//         {
//             $discount_inventory_id_array = $discount_campaign['inventory_id'];
//             foreach($discount_inventory_id_array as $discount_inventory_id)
//             {
//                 $wow_inventory_id_in_cart[$discount_inventory_id] = $discount_campaign['type'];
//             }
//         }

//         $cart_details = array_get($cart, 'data.cart_details') ?: array();

//         $index_product_in_cart = 1;

//         foreach($cart_details as $cart_detail)
//         {
//             if(!isset($wow_inventory_id_in_cart[$cart_detail['inventory_id']]))
//             {
//                 $inventory_id_in_cart[$cart_detail['inventory_id']] = 0;
//             }
//             else
//             {
//                 $inventory_id_in_cart[$cart_detail['inventory_id']] = 100*$index_product_in_cart;
//                 $index_product_in_cart = $index_product_in_cart + 1;
//             }

//         }

//         $products = $this->getAttribute('product');


//         $index_product = $index_product_in_cart;

//         foreach($products['variants'] as $variant)
//         {
//             if(isset($inventory_id_in_cart[$variant['inventory_id']]))
//             {
//                 $index_product = $inventory_id_in_cart[$variant['inventory_id']];
//             }
//         }

//         foreach($products['variants'] as $variant)
//         {
//             $inventory_id_in_cart[$variant['inventory_id']] = $index_product;
//         }


// //sd($inventory_id_in_cart);
//         return $inventory_id_in_cart;
//     }
}
