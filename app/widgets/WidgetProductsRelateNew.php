<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetProductsRelateNew extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'products-related-new';

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
        'relatedProduct' => array()
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

    private function getProductsByTag($tqg, $limit)
    {
        $q = $tqg;

        $params = array(
            'q'        => $q,
            'per_page' => 16,
            'relate' => 1
        );

        #alert($params,'red');

        $repos = new ProductRepository();
        #alert($params, 'red', 'params');
        $items = $repos->search($params);

        #alert($items, 'red', 'items');
        #exit;
        #echo sizeof($items);

        $rawProducts = array();

        foreach($items['products'] as $item)
        {
            array_push($rawProducts, $item);
            if (sizeof($rawProducts) == $limit)
            {
                break;
            }
        }
        #echo "count rawProducts = " . count($rawProducts);
        return $rawProducts;
    }

    private function getProductsByCollection($collectionKey, $limit)
    {
        $params = array(
            'collectionKey' => $collectionKey,
            'per_page'      => 3,
            'relate'        => 1,
            //'limit' => $limit,
        );

        $repos = new ProductRepository();
        $items = $repos->search($params);

        $rawProducts = array();

        foreach($items['products'] as $item)
        {
            array_push($rawProducts, $item);
            if (sizeof($rawProducts) == $limit)
            {
                break;
            }
        }

        return $rawProducts;
    }

    private function buildProductsArray($rawProducts, $currentProduct)
    {
        $products = array();
        $pkeys = array();

        $i = 0;
        foreach($rawProducts as $rawProduct)
        {
            $product = $this->buildProduct($rawProduct);
            //test that pkey is not already in list and not itself
            if(!in_array($rawProduct['pkey'], $pkeys) && $rawProduct['pkey'] != $currentProduct['pkey'])
            {
                array_push($products, $product);
                $pkeys[$i++] = $rawProduct['pkey'];
            }
            else{
                // d($rawProduct['pkey']);
                // d($pkeys);
            }

        }
        return $products;
    }

    private function buildProduct($product)
    {
        /// get level-d url ///
/*        if(is_null($product['slug']))
            $leveld_url = levelDUrl('item', $product['pkey']);
        else
            $leveld_url = levelDUrl($product['slug'], $product['pkey']);*/

        $slug = (isset($product['slug']) && !empty($product['slug'])) ? $product['slug']  : url_title($product['title']);
        $leveld_url =  levelDUrl($slug, $product['pkey']);

        $image_url = "";
        if (array_key_exists('image_cover', $product))
        {
            $image_url = $product['image_cover']['thumbnails']['square'];
        }

        $percent_discount = 0;
        if (array_key_exists('percent_discount', $product))
        {
            $percent_discount = intval($product['percent_discount']['max']);
        }

        /// get product details ///
        /* typeidea script */
        $pkey = $product['pkey'];
        $brand = $product['brand']['name'];
        $collections = $product['collections'][0]['name'];
        /* //typeidea script */
        $title = $product['title'];
        $translate_title = $product['translate']['title'];
        $net_price = $product['net_price_range']['max'];
        $special_price = $product['special_price_range']['min'];

        /// build array to return ///
        $product = array(
            /* typeidea script */
            'pkey' => $pkey,
            'brand' => $brand,
            'collections' => $collections,
            /* //typeidea script */
            'leveld_url' => $leveld_url,
            'image_url' => $image_url,
            'percent_discount' => $percent_discount,
            'title' => $title,
            'translate_title' => $translate_title,
            'net_price' => $net_price,
            'special_price' => $special_price,
        );

        return $product;
    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        $product = $this->getAttribute('product');

        /// get 2 products from the same category ///
        $catProducts = array();
        if (array_key_exists('collections', $product))
        {
            $collection = $product['collections'][0];
            $catProducts = $this->getProductsByCollection($collection['pkey'], 3);
        }

       #alert($product, 'blue', 'product');

        // dd($catProducts[0]['pkey']);
        /// get 5 products from the same tag ///



        #if ( ! empty($product['tag']))
        #{
            $tagProducts = $this->getProductsByTag($product['tag'], 7);
            /// merg    e to products array ///
            // alertd(sizeof($catProducts)." ".sizeof($tagProducts));
            $rawProducts = array_merge($catProducts, $tagProducts);
        #}
        #else
        #{
            #$rawProducts = $catProducts;
        #}
        /// build array of related products ///
        $products = $this->buildProductsArray($rawProducts, $product);

        $attrs = array(
            'products' => $products,
        );

        return $attrs;
    }

}
