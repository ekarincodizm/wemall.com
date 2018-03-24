<?php

class ProductLineController extends FrontBaseController
{

    public $product;

    public function __construct(ProductRepositoryInterface $product)
    {
        parent::__construct();

        $this->product = $product;
        $this->pcms = App::make('pcms');
        Theme::uses('itruemart-mobile');
    }

    public function getIndex($slugpkey = null)
    {
        // Clear Cart Before Add to Cart.
        $this->pcms->deleteCart();

        $slug = null;
        $pkey = null;

        #$this->theme->setTitle($data['product']['title']);
        #$this->theme->asset()->container('footer')->usePath()->add('js-level-d', 'js/level-d.js');

        $ckey = "front_level_d_line_campaign_view_" . Lang::locale() . "_" . $slugpkey;
        if ( Cache::has($ckey) and !Input::has('no-cache') )
        {
            return Cache::get($ckey);
        }

        $this->theme->asset()->container('footer')->writeScript('inline-script', '
			$(document).ready(function(){
                $.post(

				    "/campaign/product/content",
				    {
					   slugpkey: $(".slide-up").attr("data-slug-pkey"),
					   no_cache: $(".slide-up").attr("data-no-cache"),
                                           //debug: true
				    },
				    function(data){
						if (data == "no-flash-sale" || data == "expired")
						{
							window.location.href = "/products/" + $(".slide-up").attr("data-slug-pkey"); 
						}
						else if (data == "no-data")
						{
							window.location.href = "/";
						}
						else
						{
							$(".slide-up").siblings(".loading").remove();
							$(".slide-up").after(data);
						}
				    },
                    "html"
                );
			});
		', array());

        $data['slugpkey'] = $slugpkey;

        $data['no_cache'] = Input::get('no-cache', '');

        $this->theme->setTitle('iTruemart Line Campaign');
        $this->theme->asset()->usePath()->add('css-reveal', 'css/reveal/reveal.css');
        $this->theme->asset()->usePath()->add('css-reveal-addon', 'css/reveal/addon.css');
        $this->theme->asset()->usePath()->add('css-bxslider', 'css/jquery.bxslider.css');
        $this->theme->asset()->usePath()->add('css-main-line', 'css/main-line.css');
        $this->theme->asset()->usePath()->add('css-addon-line', 'css/addon-line.css');

        $content = $this->theme->scope('products-line.detail', $data)->render()->getContent();
        #$content = $this->theme->scope('products.level-d', $data)->render()->getContent();
        Cache::put($ckey, $content, 10);
        return $content;
    }

    public function postContent()
    {
        $data = array();
        $slug = null;
        $pkey = null;

        Theme::uses('itruemart-mobile')->layout('nothing');

        $slugpkey = Input::get('slugpkey');

        if ( $slugpkey != null )
        {
            $explode_val = explode('-', $slugpkey);

            if ( isset($explode_val[1]) )
            {
                $pkey = $explode_val[count($explode_val) - 1];
            }

            if ( !empty($pkey) )
            {
                $slug = preg_replace('/-' . $pkey . '/', '', $slugpkey);
            }
        }

        $data = array();

        $lang = App::getLocale();

        $data_cache_key = 'front_product_detail_campaign_data_' . $lang . '_' . $pkey;

        // if ($this->memcache->get($data_cache_key) == "" OR Input::has('nocache')) {
        //     if (Input::has('debug')) {
        //         echo '<p>Get Data from API</p>';
        //     }
        //     $product = $this->product->getByPkey($pkey);
        //     $this->memcache->set($data_cache_key, $product, $this->memcache_config['lifetime']['line_level_d_data']);
        // } else {
        //     if (Input::has('debug')) {
        //         echo '<p>Get Data from cache</p>';
        //     }
        //     $product = $this->memcache->get($data_cache_key);
        // }
        // if (Input::has('debug')) {
        //     die;
        // }

        $no_cache = Input::get('no_cache');

        if ( !empty($no_cache) )
        {
            Cache::forget($data_cache_key);
        }
        $that = $this;

        $product = Cache::remember($data_cache_key, 60, function() use ($that, $pkey)
                        {
                            return $that->product->getByPkey($pkey);
                        });
         
        #alert($product, 'red'); 

        if ( !isset($product['id']) )
        {
            #return Redirect::away(URL::toLang('/'));
            return "no-data";
        }

        $data['product']      = $product;
        $data['product_pkey'] = $pkey;

        $arrInvId = array();
        $data['is_timeout'] = "N";
        if ( !empty($data['product']['variants']) )
        {
            $isFlashSale      = TRUE;
            $isTimeOut        = FALSE;
            $isPromotionMatch = TRUE;

            foreach ( $data['product']['variants'] as $key => $value )
            {
                $arrInvId[] = $value['inventory_id'];
            }
            foreach ( $data['product']['variants'] as $key => $value )
            {
                #alert($value, 'red');
                if ( !empty($value['active_special_discount']['campaign_type']) )
                {
                    if ( $value['active_special_discount']['campaign_type'] == "flash_sale" )
                    {
                        $started_at = date("Y-m-d H:i:s", strtotime($value['active_special_discount']['started_at']));
                        $ended_at   = date("Y-m-d H:i:s", strtotime($value['active_special_discount']['ended_at']));
                        #$ended_at = "2013-01-01 11:11:11";
                        #echo "<p>started_at = ".$started_at.'</p>'; 
                        #echo "<p>ended_at = ".$ended_at.'</p>'; 

                        $now = date("Y-m-d H:i:s");

                        #echo '<p>now = '.$now.' started_at = '.$started_at.' , ended_at = '.$ended_at.'</p>';
                        if ( $now < $started_at OR $now > $ended_at )
                        {

                            if ( $data['is_timeout'] == "N" )
                            {
                                #echo "<p>===</p>";
                                $data['is_timeout'] = "Y";
                            }
                        }

                        if ( !empty($old_started_at) && !empty($old_ended_at) )
                        {
                            if ( $started_at != $old_started_at OR $ended_at != $old_ended_at )
                            {
                                $isPromotionMatch = FALSE;
                                break;
                            }
                        }

                        $old_started_at = $started_at;
                        $old_ended_at   = $ended_at;
                    }
                    else
                    {
                        $isFlashSale = FALSE;
                        break;
                    }
                }
                else
                {
                    $isFlashSale = FALSE;
                    break;
                }
            }

            if ( $isFlashSale === FALSE )
            {
                #return Redirect::away(URL::toLang('/'));
                return "no-flash-sale";
            }
            if ( $isPromotionMatch == FALSE )
            {
                #return Redirect::away(levelDUrl($slug, $pkey));
                return "expired";
            }
        }

        #d($arrInvId);

        if ( !empty($arrInvId) )
        {
            $data['str_inv_id'] = implode(",", $arrInvId);
        }
        else
        {
            $data['str_inv_id'] = "";
        }
        
        if(Input::get("debug")){
            alert($data);
        }

        $this->theme->asset()->container('footer')->usePath()->add('js-reveal', 'js/reveal.js');
        $this->theme->asset()->container('footer')->usePath()->add('js-login', 'js/login.js');
        $this->theme->asset()->container('footer')->usePath()->add('js-bx-slider', 'js/jquery.bxslider.js');
        $this->theme->asset()->container('footer')->usePath()->add('js-main', 'js/main.js');
        $this->theme->asset()->container('footer')->usePath()->add('js-product', 'js/product.js');


        return $this->theme->scope('products-line.content', $data)->render();
    }

    public function postCheckStock()
    {
        #alertd($_POST, 'red');
        if ( Input::has('isAjax') )
        {
            $inventoryId  = Input::get('data_inv_id');
            $product_pkey = Input::get('product_pkey');

            #alert($inventoryId, 'red', 'inventoryId');

            $product = $this->product->getByPkey($product_pkey);



            //---- Check Stock ----//
            $inventoryIds = explode(',', $inventoryId);
            $count        = count($inventoryIds);

            $checkStocks = array();

            if ( $count === 1 )
            {
                $inventoryId = intval($inventoryId);
                $remaining   = intval($this->product->getRemaining($inventoryId), 10);

                $checkStocks[$inventoryId] = $remaining > 0 ? 'in' : 'out';
            }
            else
            {
                #alertd($inventoryId, 'red', 'inventoryId');
                $remainings = $this->product->checkRemaining($inventoryId);

                #alertd($remainings, 'red');
                if ( Input::has('debug') )
                {
                    alert($remainings);
                }
                $stocks = array();
                foreach ( $remainings as $id => $remaining )
                {
                    #echo intval($remaining);
                    $checkStocks[$id] = intval($remaining) > 0 ? 'in' : 'out';
                }
            }

            #alertd($checkStocks, 'red');
            //---- End Check Stock ---//

            if ( !empty($product) )
            {
#				alert($product, 'red');
                //$style_types = array();
                //$options = array();
                
                $variants = array();
                
                if ( !empty($product['variants']) )
                {
                    foreach ( $product['variants'] as $v_key => $v_value )
                    {
                        //--- Check Promotion ---//


                        $style_options = array();
                        $style_options_pkey = array();

                        if ( !empty($v_value['style_options']) )
                        {
                            foreach ( $v_value['style_options'] as $so_key => $so_value )
                            {
                                $style_options[]                        = $so_value['option'];
                                $style_options_pkey[$so_value['style']] = $so_value['option'];
                            }
                        }
                        else
                        {
                            $inventory_id = $v_value['inventory_id'];
                            break;
                        }


                        #alertd($style_options_pkey, 'red');

                        if ( !empty($style_options) )
                        {
                            if ( !empty($v_value['special_price']) )
                            {
                                $online_price = $v_value['net_price'];
                                $sell_price   = $v_value['price'];
                            }
                            else
                            {
                                $sell_price                             = $v_value['price'];
                            }
                            $variants[implode("_", $style_options)] = array(
                                'pkey'         => $v_value['pkey'],
                                'inventory_id' => $v_value['inventory_id'],
                                'net_price'    => $online_price,
                                'sell_price'   => $sell_price
                            );
                        }
                    }
                }


                if ( !empty($variants) )
                {
                    $inventory_id = "";
                    foreach ( $checkStocks as $s_key => $s_value )
                    {
                        if ( strtolower($s_value) == 'in' )
                        {
                            $inventory_id = $s_key;
                            #$variant_pkey = $v_key;
                            #$inventory_id = $v_value['inventory_id'];
                            #$net_price = $v_value['net_price'];
                            #$sell_price = $v_value['sell_price'];
                            break;
                        }
                    }
                    foreach ( $variants as $v_key => $v_value )
                    {
                        if ( $v_value['inventory_id'] == $inventory_id )
                        {
                            $variant_pkey = $v_key;
                            $inventory_id = $v_value['inventory_id'];
                            $net_price    = $v_value['net_price'];
                            $sell_price   = $v_value['sell_price'];
                            break;
                        }
                    }

                    #alertd($variant_pkey, 'red', 'variant_key');

                    if ( !empty($variant_pkey) )
                    {
                        if ( preg_match("/_/", $variant_pkey) )
                        {
                            #list($color_pkey, $size_pkey) = explode("_", $variant_pkey);
                            $pkey_variants = explode("_", $variant_pkey);
                        }
                        else
                        {
                            $pkey_variants = array($variant_pkey);
                        }
                    }
                    $json['status']        = 200;
                    #$json['color_pkey'] = $color_pkey;
                    #$json['size_pkey'] = $size_pkey;
                    $json['pkey_variants'] = (!empty($pkey_variants)) ? $pkey_variants : "";
                    $json['stock']         = (!empty($pkey_variants)) ? 'in' : 'out';
                    $json['inventory_id']  = $inventory_id;
                    $json['net_price']     = (!empty($net_price)) ? $net_price : "";
                    $json['sell_price']    = (!empty($sell_price)) ? $sell_price : "";
                    #$json['color_name'] = ( ! empty($color_name)) ? $color_name : "";
                    #$json['size_name'] = ( ! empty($size_name)) ? $size_name  : "";
                    #alertd($style_options_pkey, 'red');


                    //echo json_encode($json, TRUE);
                    return Response::json($json);
                }
                //--- No Style types
                else
                {
                    $json['status']       = 200;
                    $json['inventory_id'] = $inventory_id;
                    $json['stock']        = $checkStocks[$inventory_id];
                    //echo json_encode($json, TRUE);
                    return Response::json($json);
                }

                
            }

           
        }
    }

    public function postCheckStockByVariant()
    {
        #alertd($_POST);
        
            #alertd($_POST, 'red');
            $product_pkey = Input::get('product_pkey');
            #$color_pkey = Input::get('color_pkey');
            #$size_pkey = Input::get('size_pkey');
            #alertd($_POST, 'red');
            $option_pkey  = Input::get('option_pkey');

            $product = $this->product->getByPkey($product_pkey);
            if ( !empty($product) )
            {
                $variants = array();
                if ( !empty($product['variants']) )
                {
                    foreach ( $product['variants'] as $v_key => $v_value )
                    {
                        $style_options = array();
                        if ( !empty($v_value['style_options']) )
                        {
                            foreach ( $v_value['style_options'] as $so_key => $so_value )
                            {
                                $style_options[] = $so_value['option'];
                            }
                        }

                        if ( !empty($style_options) )
                        {
                            if ( !empty($v_value['special_price']) )
                            {
                                $online_price = $v_value['net_price'];
                                $sell_price   = $v_value['price'];
                            }
                            else
                            {
                                $sell_price                             = $v_value['price'];
                            }
                            $variants[implode("_", $style_options)] = array(
                                'pkey'         => $v_value['pkey'],
                                'inventory_id' => $v_value['inventory_id'],
                                'net_price'    => $online_price,
                                'sell_price'   => $sell_price
                            );
                        }
                    }
                }

                #alert($variants, 'red', 'variants');
                #alertd($option_pkey, 'blue', 'option_pkey');

                if ( count($option_pkey) > 0 )
                {
                    $option_pkey = implode("_", $option_pkey);
                }

                if ( !empty($variants) )
                {
                    $inventory_id = "";
                    foreach ( $variants as $v_key => $v_value )
                    {
                        if ( $v_key == $option_pkey )
                        {
                            $inventory_id = $v_value['inventory_id'];
                            $net_price    = $v_value['net_price'];
                            $sell_price   = $v_value['sell_price'];
                            break;
                        }
                    }

                    $remaining = intval($this->product->getRemaining($inventory_id), 10);

                    #alert($remaining, 'red', 'remaining');
                    if ( $remaining === false )
                    {
                        /**
                          array(
                          'status' => 500,
                          'stock' => false,
                          'remaining' => -1
                          );
                         * */
                        $json['code']      = 500;
                        $json['stock']     = false;
                        $json['remaining'] = -1;
                        return Response::json($json);
//                        echo json_encode($json);
//                        exit;
                    }

                    $json['code']         = 200;
                    $json['stock']        = $remaining > 0 ? 'in' : 'out';
                    $json['net_price']    = $net_price;
                    $json['sell_price']   = $sell_price;
                    $json['inventory_id'] = $inventory_id;
                    #$json['c'] = $color_pkey;
                    #$json['s'] = $size_pkey;
                    //echo json_encode($json);

                    return Response::json($json);
                }

            }
        
    }

    public function postGetImage()
    {
        #alertd($_POST, 'red', 'POST');
        if ( Input::has('isAjax') )
        {
            #alertd($_POST, 'red');
            $media_set_pkey = Input::get('media_set_pkey');
            $product_pkey   = Input::get('product_pkey');
            if ( empty($product_pkey) OR empty($media_set_pkey) )
            {
                $json['status']  = 500;
                $json['message'] = "Missing arguments";
                //echo json_encode($json);
                return Response::json($json);
                exit;
            }

            $product = $this->product->getByPkey($product_pkey);
            #$images = array();
            if ( !empty($product['style_types']) )
            {
                foreach ( $product['style_types'] as $st_key => $st_value )
                {

                    if ( $st_value['media_set'] == TRUE )
                    {
                        if ( !empty($st_value['options']) )
                        {
                            foreach ( $st_value['options'] as $o_key => $o_value )
                            {
                                if ( $o_value['pkey'] == $media_set_pkey )
                                {
                                    if ( !empty($o_value['media_contents']) )
                                    {
                                        $images = array();
                                        foreach ( $o_value['media_contents'] as $m_key => $m_value )
                                        {
                                            $images[] = array(
                                                #'small' => $m_value['thumb']['thumbnails']['small'],
                                                #'medium' => $m_value['thumb']['thumbnails']['medium'],
                                                #'square' => $m_value['thumb']['thumbnails']['square'],
                                                'large' => $m_value['thumb']['thumbnails']['large']
                                                    #'zoom' => $m_value['thumb']['thumbnails']['zoom']
                                            );
                                        }
                                        //--- End foreach $o_value['media_contents'] ---//
                                    }
                                }
                            }
                            //--- End foreach $st_value['options'] ---//
                        }
                    }
                }

                //echo json_encode($images);
                return Response::json($images);
                //---- End Foreach $product['style_types'] ----//
            }
        }
    }

    public function postCheckLogin()
    {
        return "Post Check Login";
    }

}
