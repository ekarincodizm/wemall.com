<?php

class ShowroomRepository implements ShowroomRepositoryInterface
{

    /**
     * @var PcmsClient
     */
    protected $pcmsClient;

    /**
     * @var mixed
     */
    protected $response;

    public function __construct()
    {
        $this->pcmsClient = App::make('pcms');
    }

    public function getTotalPage()
    {
        return array_get($this->response, 'data.total_page', 1);
    }

    /**
     * getData get data from PCMS showroom api
     * and parse data into usable JSON
     *
     * @param  integer $page  
     * @param  integer $limit 
     * @return array code, status, message, data
     */
    public function getData($page = 1, $limit = 2)
    {
        $return_data = array(
            'code' => 200,
            'status' => 'success',
            'message' => 'success',
        );

        $params = array(
            'page' => $page,
            'limit' => $limit,
        );

        try {
            $this->response = $this->pcmsClient->apiv2("showroom", $params, 'GET', TRUE);

            $response_code = array_get($this->response, 'code', false);
            if ($response_code != 200) {
                throw new Exception('Not has code or code not equal 200 in showroom api', 401);
            }

            $response_data = array_get($this->response, 'data', false);
            if (empty($response_data)) {
                throw new Exception('Not has data node in showroom api', 402);
            }

            $parse_data['total_page'] = array_get($this->response, 'data.total_page', 1);
            $parse_data['showroom'] = $this->parseData();

            array_set($return_data, 'data', $parse_data);
        }
        catch (Exception $e) {
            array_set($return_data, 'code', $e->getCode());
            array_set($return_data, 'status', 'error');
            array_set($return_data, 'message', $e->getMessage());
        }

        return $return_data;
    }

    /**
     * parseData from response
     * and return usable JSON format
     *
     * @return array { page, total_page, showroom: [ { showroom_title, showroom_url, layout_id, layout_pattern, banner, brand, product } ] }
     * @throws Exception
     */
    public function parseData() {
        $parsed_data = array();

        $showroom = array_get($this->response, 'data.showroom', false);
        if (empty($showroom)) {
            throw new Exception('Showroom data not found.', 401);
        }

        foreach ($showroom as $key => $showroom_item) {
            // clean data
            $showroom_data = array();

            $layout_pattern = array_get($showroom_item, 'layout_pattern', false);

            $showroom_url = array_get($showroom_item, 'url', false);
            $showroom_title = array_get($showroom_item, 'name', false);

            if (empty($showroom_url)){
                $showroom_url = URL::toLang('search?collection=0&q=' . urlencode($showroom_title));
            }

            // showroom default data
            array_set($showroom_data, 'showroom_id', array_get($showroom_item, 'id', false));
            array_set($showroom_data, 'showroom_title', $showroom_title);
            array_set($showroom_data, 'showroom_link', $showroom_url);
            array_set($showroom_data, 'layout_id', array_get($showroom_item, 'layout_id', false));
            array_set($showroom_data, 'layout_pattern', $layout_pattern);

            array_set($showroom_data, 'banner', array());
            array_set($showroom_data, 'brand', array());
            array_set($showroom_data, 'product', array());

            // defined showroom product
            $showroom_product = array();

            // defined showroom banner
            $banner = array_get($showroom_item, 'banner', false);
            if ( ! empty($banner)) {
                foreach ($banner as $banner_key => $banner_item) {
                    $banner_position = array_get($banner_item, 'position_name', false);
                    $banner_link = array_get($banner_item, 'link_url');
                    $box_id = array_get($layout_pattern, $banner_position);

                    // check box_id
                    if (empty($box_id) && $banner_position!='B1') {
                        continue;
                    }

                    $banner_data = array();

                    array_set( $banner_data, 'id', array_get($banner_item, 'id') );
                    array_set( $banner_data, 'thumbnail.desktop', array_get($banner_item, 'img_path') . '?q=' . md5($banner_link) );
                    array_set( $banner_data, 'thumbnail.mobile', false ); // we only display banner on P1 - P
                    array_set( $banner_data, 'position', $banner_position );
                    array_set( $banner_data, 'box', $box_id );
                    array_set( $banner_data, 'type', 'banner' );
                    array_set( $banner_data, 'link', $banner_link );

                    if ($banner_position === 'B1') {
                        array_set($showroom_data, 'banner', $banner_data);
                    }
                    else {
                        $showroom_product[] = $banner_data;
                    }
                }
            }

            // defined showroom brand
            $brand = $this->getShowroomBrand($showroom_item);
            if ( ! empty($brand)) {
                array_set($showroom_data, 'brand', $brand);
            }

            // update showroom product
            $product = array_get($showroom_item, 'products', false);

            if ( ! empty($product)) {
                foreach ($product as $product_key => $product_item) {
                    $product_type = array_get($product_item, 'type');
                    $banner_position = array_get($product_item, 'position_name');

                    $box_id = array_get($layout_pattern, $banner_position);
                    if (empty($box_id)) {
                        continue;
                    }

                    $product_data = array(
                        'position' => $banner_position,
                        'box' => $box_id,
                        'type' => $product_type,
                    );

                    if ($product_type === 'banner') {
                        $banner_link = array_get($product_item, 'banner_link');
                        array_set($product_data, 'thumbnail.desktop', array_get($product_item, 'banner_web_path') . '?q=' . md5($banner_link));
                        array_set($product_data, 'thumbnail.mobile', array_get($product_item, 'banner_mobile_path') . '?q=' . md5($banner_link));
                        array_set($product_data, 'link', $banner_link);
                    }
                    elseif ($product_type === 'product') {
                        $recommend_size = array_get($product_item, 'recommend_size', 'square');
                        $product_slug = array_get($product_item, 'slug');
                        $product_pkey = array_get($product_item, 'pkey');
                        $product_link = levelDUrl($product_slug, $product_pkey);

                        $product_title = array_get($product_item, 'translate.title');
                        if(Lang::getLocale()!='th'){
                            if(empty($product_title))
                                $product_title = array_get($product_item, 'title');
                        } else {
                            $product_title = array_get($product_item, 'title');
                        }
//                        $product_title = Lang::getLocale()=='th'
//                                ? array_get($product_item, 'title')
//                                : array_get($product_item, 'translate.title');

                        array_set($product_data, 'thumbnail.desktop', array_get($product_item, 'image_cover.thumbnails.' . $recommend_size) . '?q=' . md5($product_link));
                        array_set($product_data, 'thumbnail.mobile', array_get($product_item, 'image_cover.thumbnails.square') . '?q=' . md5($product_link));
                        array_set($product_data, 'link', $product_link);
                        array_set($product_data, 'pkey', $product_pkey);
                        array_set($product_data, 'id', $product_pkey);
                        array_set($product_data, 'title', $product_title);

                        array_set($product_data, 'price.discount', $this->setPercentFormat($product_item, 'percent_discount'));
                        array_set($product_data, 'price.special', $this->setPriceFormat($product_item, 'special_price_range'));
                        array_set($product_data, 'price.normal', $this->setPriceFormat($product_item, 'price_range'));
                        array_set($product_data, 'price.net', $this->setPriceFormat($product_item, 'net_price_range'));
                    }

                    $showroom_product[] = $product_data;
                }
            }

            array_set($showroom_data, 'product', $showroom_product);

            // push array
            $parsed_data[] = $showroom_data;
        }

        return $parsed_data;
    }

    protected function setPercentFormat($product, $key)
    {
        $price_data = array_get($product, $key, array());
        if (array_sum($price_data)<=0) {
            return false;
        }

        foreach ($price_data as $index => $value) {
            array_set($price_data, $index, floor($value));
        }
        return $price_data;
    }

    protected function setPriceFormat($product, $key)
    {
        $price_data = array_get($product, $key, array());
        if (array_sum($price_data)<=0) {
            return false;
        }

        foreach ($price_data as $index => $value) {
            array_set($price_data, $index, price_format($value));
        }
        return $price_data;
    }

    /**
     * exact showroom brand
     *
     * @param array $showroom_data
     * @return mixed
     */
    protected function getShowroomBrand($showroom_data)
    {
        $brand_data = array();

        $brand = array_get($showroom_data, 'brand', false);
        if (empty($brand)) {
            return $brand_data;
        }

        foreach ($brand as $brand_key => $brand_item) {
            $brand_slug = array_get($brand_item, 'slug');
            $brand_pkey = array_get($brand_item, 'pkey');
            $brand_link = URL::toLang('brand/' . $brand_slug . '-' . $brand_pkey . '.html');

            $brand_data[] = array(
                'id' => $brand_pkey,
                'name' => array_get($brand_item, 'name'),
                'slug' => $brand_slug,
                'thumbnail' => array_get($brand_item, 'thumb.0') . '?q=' . md5($brand_link),
                'link' => $brand_link
            );
        }

        return $brand_data;
    }

    /**
     * @param $page
     * @return string
     */
    public function getShowroomCacheKey($page = ""){
        $cacheKey = array(
            Request::server("SERVER_NAME"),
            "showroomajax_cachekey_unique",
            Lang::locale(),
            $page
        );
        return  implode('_', $cacheKey);
    }


    /**
     * delete All Showroom Data.
     * return void
     */
    public function deleteAllShowroomCache(){
        $allKeys = ElastiCache::getAllKeys();

        if(!empty($allKeys)){
            $cPattern = "#".$this->getShowroomCacheKey()."#";
            foreach($allKeys as $cKey){
                if(preg_match($cPattern, $cKey)){
                    ElastiCache::remove($cKey);
                }
            }
        }
    }
}
