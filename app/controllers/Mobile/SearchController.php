<?php

namespace Mobile;

use Request;
use Input;
use Theme;
use Illuminate\Support\Facades\App;

class SearchController extends \MobileBaseController {

    protected $product;

    public function __construct(\ProductRepository $product)
    {
        parent::__construct();

        $this->product = $product;
    }


    public function getIndex()
    {

        setSeoMeta('search');

        $keyword = Input::get('q');
        $regex = '#[^-ก-๙a-zA-Z0-9 ]#i';
        $keyword = preg_replace($regex, '', $keyword);
        $keyword = str_replace(array("+", "&"), array(" ", " "), $keyword);

        // If keyword contents any HTML, go to 404.
        if (is_html($keyword))
        {
            App::abort(404);
        }

        $keyword = strip_tags($keyword);


        $filters = array(
            'q' => $keyword
        );

        if (Input::get('collection', 0) != 0)
        {
            $filters['collectionKey'] = Input::get('collection');
        }

        if (Input::has('priceMax'))
        {
            $filters['priceMax'] = Input::get('priceMax');
        }

        if (Input::has('priceMin'))
        {
            $filters['priceMin'] = Input::get('priceMin');
        }

        if (Input::has('orderBy'))
        {
            $view['orderBy'] = $filters['orderBy'] = Input::get('orderBy');
            $view['order'] = $filters['order'] = Input::get('order', 'desc');

        }
        else
        {
            $view['orderBy']  = 'published_at';
            $view['order'] = 'desc';
        }

        if (Input::has('per_page'))
        {
            $filters['per_page'] = Input::get('per_page');
        }
        else
        {
            $filters['per_page'] = 20;
        }

        if (Input::has('page'))
        {
            $filters['page'] = Input::get('page');
        }

        if (Input::has('debug-filter'))
        {
            alert($filters, 'red', 'filters');
            if (Input::has('die'))
            {
                die;
            }
        }
        $data = $this->product->search($filters);

        if (Input::has('debug-data'))
        {
            alert($data, 'red', 'data');
            if (Input::has('die'))
            {
                die;
            }
        }
        $view['data'] = $data;
        $view['type'] = 'search';

        $viewBy = Input::get('viewBy', 'default');

        $view['currentKey'] = $keyword;
        $view['per_page'] = $filters['per_page'];
        $view["collection"] = Input::get('collection', "");

        $this->theme->asset()->usePath()->add('css-style', 'css/search.css');
        $this->theme->asset()->container('footer')->usePath()->add('js-search', 'js/search2.js');
        $this->theme->asset()->usePath()->add('css-custom', 'css/custom.css');
        $this->theme->asset()->container('footer')->usePath()->add('js-jscroll', 'vendors/jscroll/jquery.jscroll.min.js');

        $this->theme->setTitle("Search ".$keyword.' | iTruemart.ph') ;
        $this->theme->setMetadescription(__('seo_description_home'));
        $this->theme->setMetakeywords(__('seo_keyword_home'));
        $this->theme->setCanonical('http://'.Request::server ("SERVER_NAME").'/'.Request::path().$this->link_to_action());

        return $this->theme->scope('search.search', $view)->render();

    }

    public function searchView()
    {
        $args = array();
        $keyword = Input::get('q');

//        if(empty($keyword))
//        {
//            $keyword = Input::get('collectionKey');
//        }
//
//        $regex = '#[^-ก-๙a-zA-Z0-9 ]#i';
//        $keyword = preg_replace($regex, '', $keyword);
//        $keyword = str_replace(array("+", "&"), array(" ", " "), $keyword);

//        if (Input::has('q'))
//        {
//            $args['q'] = Input::get('q');
//        }
//        if(Input::has("collectionKey"))
//        {
//            $args['collectionKey'] = Input::get("collectionKey");
//        }

        $view = array();

        $this->theme->layout('blank');
        $viewBy = Input::get('viewBy');

        $view['data'] = $this->getProductsList($args);
        $view['currentKey'] = $keyword;
        $view['currentKey'] = str_replace(' ', '+', $view['currentKey']);
        $view['orderBy'] = Input::get('orderBy', 'published_at');
        $view['order'] =  Input::get('order', 'desc');
        $view['viewBy'] = Input::get('viewBy', 'default');
        $view['page'] = Input::get('page', 1);
        $view['per_page'] = Input::get('per_page', 20);
        $view["collection"] = Input::get("collection", "");

        $view['data']['collection_name'] = strip_tags($keyword);

        $content = $this->theme->scope('search.search-'.$viewBy.'-view', $view)->render()->getContent();
        return $content;
    }

    private function getProductsList($params = array())
    {

        setSeoMeta('search');

        $keyword = Input::get('q');
        $regex = '#[^-ก-๙a-zA-Z0-9 ]#i';
        $keyword = preg_replace($regex, '', $keyword);
        $keyword = str_replace(array("+", "&"), array(" ", " "), $keyword);

        // If keyword contents any HTML, go to 404.
        if (is_html($keyword))
        {
            App::abort(404);
        }

        $keyword = strip_tags($keyword);


        $filters = array(
            'q' => $keyword
        );

        if (Input::get('collection', 0) != 0)
        {
            $filters['collectionKey'] = Input::get('collection');
        }

        if (Input::has('priceMax'))
        {
            $filters['priceMax'] = Input::get('priceMax');
        }

        if (Input::has('priceMin'))
        {
            $filters['priceMin'] = Input::get('priceMin');
        }
        if (Input::has('orderBy'))
        {
            $filters['orderBy'] = Input::get('orderBy');
            $filters['order'] = (Input::has('order')) ? Input::get('order') : 'asc' ;

        }


        if (Input::has('per_page'))
        {
            $filters['per_page'] = Input::get('per_page');
        }
        else
        {
            $filters['per_page'] = 20;
        }

        if (Input::has('page'))
        {
            $filters['page'] = Input::get('page');
        }

        $data = $this->product->search($filters);

        $view['data'] = $data;
        $view['type'] = 'search';

        return $data;
    }

}

