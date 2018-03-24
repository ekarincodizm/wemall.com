<?php


class SuperDealController extends FrontBaseController {

    protected $superdeal;

    public function __construct(SuperDealRepositoryInterface $superdeal)
    {
        parent::__construct();

        $this->superdeal = $superdeal;
    }

    public function getIndex(){
        $this->theme->setTitle('Everyday Wow | iTruemart.ph');
        $this->theme->setMetadescription(__('seo_description_home'));
        $this->theme->setMetakeywords(__('seo_keyword_home'));


        $this->theme->partialComposer('meta_og', function($view)
        {
            $view->with('meta_title', 'Everyday Wow | iTruemart.ph');
            $view->with('meta_image', 'http://'.Request::server ("SERVER_NAME").'/themes/itruemart/assets/images/meta-og/everydaywow-24-oct-2014.jpg');
            $view->with('meta_url', 'http://'.Request::server ("SERVER_NAME").'/everyday-wow');
            $view->with('meta_description', __('seo_description_home'));
            $view->with('meta_type', 'website');
        });

        $this->theme->asset()->usePath()->add("superdeal-product", "js/superdeal-product.js", array());
        $respone = $this->theme->scope('super-deal/index', array())->render();
        return $respone;
    }

    /**
     * @type API get any product for super-deal page.
     * @params {int} offset number of start product.
     * @params {int} limit  number of product per request.
     * @params {string} filter Options: lastest, price, discount
     * @params {string} order_by Options: asc, desc
     * @return {JSON}
     */
    public function getAnyProduct(){
        $data = Input::all();
        $products = $this->superdeal->getAnyProduct($data);
        if(isset($products['data']['products']) && count($products['data']['products']) > 0)
        {
            $products_temp = $products['data']['products'];
            $products_new = array();
            foreach($products_temp as $key => $p_val)
            {
                $slug = (isset($p_val['slug']) && !empty($p_val['slug'])) ? $p_val['slug']  : url_title($p_val['title']);
                $products_new[$key] = $p_val;
                $products_new[$key]['slug'] = $slug;
            }
            $products['data']['products'] = $products_new;
        }
        return Response::json($products, 200);
    }
}
