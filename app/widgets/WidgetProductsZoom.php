<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetProductsZoom extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'products-zoom';

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
        'image_cover' => array(),
        'media_contents' => array()
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
        $attrs = array();

        $this->setAttribute('image_cover', $this->getImageCover());
        $this->setAttribute('media_contents', $this->getMediaContents());

		$attrs['price'] = $this->getPrice();

        return $attrs;
    }

    private function getMediaContents()
    {
        $media_contents = array();
        $product = $this->getAttribute('product');
        $contents = $product['media_contents'];

        $i = 0;
        foreach ($contents as $thumbnail) {
            if($thumbnail['mode'] == "image")
            {
                $media_contents[$i++] = array('small' => $thumbnail['thumb']['thumbnails']['small'],
                    'zoom' => $thumbnail['thumb']['thumbnails']['zoom']
                    );
            }
        }

        return $media_contents;
    }

    private function getImageCover()
    {
        $product = $this->getAttribute('product');
        // dd($product);
        //sd($product);

        $img_cover = "";
        if (array_key_exists('image_cover', $product))
        {
            $img_cover = $product['image_cover']['thumbnails']['zoom'];
        }

        return $img_cover;
    }

	private function getPrice()
    {
        $product = $this->getAttribute('product');
		$price = array();

		$price['price_range'] 			= !empty($product['price_range'])? $product['price_range']: array();
		$price['net_price_range'] 		= !empty($product['net_price_range'])? $product['net_price_range']: array();
		$price['special_price_range'] 	= !empty($product['special_price_range'])? $product['special_price_range']: array();
		$price['percent_discount'] 		= !empty($product['percent_discount'])? $product['percent_discount']: array();
        $price["product_name"] = !empty($product["title"])? $product["title"] : "";

        return $price;
    }

}
