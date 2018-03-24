<?php

class KuaeTestController extends FrontBaseController {
    private $pcms;
    public $product;

    public function __construct(ProductRepositoryInterface $product)
    {
        parent::__construct();

        $this->pcms    = App::make('pcms');
        $this->product = $product;
        Theme::uses('itruemart-mobile');
    }

	public function getContent()
	{
		$data = array(); 
		$slug = null;
		$pkey = null;

        Theme::uses('itruemart-mobile')->layout('nothing');

        $slugpkey = Input::get('slugpkey');

		if ($slugpkey != null)
        {
            $explode_val = explode('-', $slugpkey);

            if (isset($explode_val[1]))
            {
                $pkey = $explode_val[count($explode_val)-1];
            }

            if( ! empty($pkey))
            {
                $slug = preg_replace('/-'.$pkey.'/','',$slugpkey);
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

		if ( ! empty($no_cache)) 
		{
			Cache::forget($data_cache_key);
        }
        $that = $this;

        $product = Cache::remember($data_cache_key, 60, function() use ($that, $pkey)
        {
            return $that->product->getByPkey($pkey);
        });

        if (empty($product))
        {
            //return Redirect::away(URL::toLang('/'));

            echo 'no data';
            print_r($product);
            die;
        }

        $data['product'] = $product;
        $data['product_pkey'] = $pkey;

        $arrInvId = array();
        $data['is_timeout'] = "N";
        if (!empty($data['product']['variants'])) {
            $isFlashSale = TRUE;
            $isTimeOut = FALSE;
            $isPromotionMatch = TRUE;

            foreach ($data['product']['variants'] as $key => $value) {
                $arrInvId[] = $value['inventory_id'];
            }
            foreach ($data['product']['variants'] as $key => $value) {
                #alert($value, 'red');
                if (!empty($value['active_special_discount']['campaign_type'])) {
                    if ($value['active_special_discount']['campaign_type'] == "flash_sale") {
                        $started_at = $value['active_special_discount']['started_at'];
                        $ended_at = $value['active_special_discount']['ended_at'];
                        #$ended_at = "2013-01-01 11:11:11";
                        $now = date("Y-m-d H:i:s");

                        #echo '<p>now = '.$now.' started_at = '.$started_at.' , ended_at = '.$ended_at.'</p>';
                        if ($now < $started_at OR $now > $ended_at) {

                            if ($data['is_timeout'] == "N") {
                                #echo "<p>===</p>";
                                $data['is_timeout'] = "Y";
                            }
                        }

                        if (!empty($old_started_at) && !empty($old_ended_at)) {
                            if ($started_at != $old_started_at OR $ended_at != $old_ended_at) {
                                $isPromotionMatch = FALSE;
                                break;
                            }
                        }

                        $old_started_at = $started_at;
                        $old_ended_at = $ended_at;
                    } else {
                        $isFlashSale = FALSE;
                        break;
                    }
                } else {
                    $isFlashSale = FALSE;
                    break;
                }
            }

            if ($isFlashSale === FALSE) {
                //return Redirect::away(URL::toLang('/'));
                echo 'not flash sales';
                print_r($product);die;
            }
            if ($isPromotionMatch == FALSE) {
                // return Redirect::away(levelDUrl($slug, $pkey));
                echo 'no promotion';
                print_r($product);die;
            }
        }

        #d($arrInvId);

        if (!empty($arrInvId)) {
            $data['str_inv_id'] = implode(",", $arrInvId);
        } else {
            $data['str_inv_id'] = "";
        }

		
        $this->theme->asset()->container('footer')->usePath()->add('js-reveal', 'js/reveal.js');
        $this->theme->asset()->container('footer')->usePath()->add('js-login', 'js/login.js');
        $this->theme->asset()->container('footer')->usePath()->add('js-bx-slider', 'js/jquery.bxslider.js');
        $this->theme->asset()->container('footer')->usePath()->add('js-main', 'js/main.js');
		$this->theme->asset()->container('footer')->usePath()->add('js-product', 'js/product.js');


		return $this->theme->scope('products-line.content', $data)->render();
	}

    public function getShowroom()
    {
        $c = new Curl();

        echo $c->simple_get('http://pcms.alpha.itruemart.com/api/45311375168544/showroom');
    }

    public function getEnv()
    {
        alert($_SERVER);
        echo($value = Request::server('SERVER_NAME'));
    }

    public function getSaveapilog()
    {
        $params['form'] = 1;
        $params['lang_code'] = App::getLocale();

        $response            = $this->pcms->api('checkout/create-order', $params, 'POST');


        $log_api = new ApiEventLogs();
        $log_api->event_name = 'Checkout 3 Create Order';
        $log_api->summary = 'ไม่สามารถสร้าง Order ได้';
        $log_api->log_request = 'checkout/create-order?'.http_build_query($params, null, '&');
        $log_api->log_response = $response;
        $log_api->created_at = date('Y-m-d H:i:s');
        $log_api->updated_at = date('Y-m-d H:i:s');
        $log_api->save();
    }

    public function getLog()
    {
        $id = Input::get('id');
        if(!empty($id))
        {
            $log = ApiEventLogs::find($id);
            echo $log->log_response;
        }else{
            echo 'No Id';
        }
    }

    public function getMaxTime()
    {
        $time_start = microtime(true);
        for($i=0;$i<80;$i++) {
            sleep(2);
            $time_end = microtime(true);
            $time = $time_end - $time_start;
            echo '    i:' . $i;
            echo "   -> It took $time seconds<br/>\n";

        }
        phpinfo();
    }
}
