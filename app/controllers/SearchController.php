<?php

class SearchController extends FrontBaseController {

    protected $product;

    public function __construct(ProductRepositoryInterface $product)
    {
        parent::__construct();

        $this->product = $product;


        $criteo_script = '<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>';
        $this->theme->append('criteo_tag', $criteo_script);
    }

    public function getIndex()
    {
        setSeoMeta('search');

        $keyword = Input::get('q');

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
            $filters['order'] = (Input::has('order')) ? Input::get('order') : 'desc' ;
        }
        else
        {
             $filters['orderBy'] = 'published_at';
             $filters['order'] = 'desc' ;
        }

        if (Input::has('per_page'))
        {
            $filters['per_page'] = Input::get('per_page');
        }

        if (Input::has('page'))
        {
            $filters['page'] = Input::get('page');
        }

        $data = $this->product->search($filters);

        $view['data'] = $data;
        $view['data']['collection_name'] = !empty($keyword)?$keyword : '';

        $view['type'] = 'search';

        // $this->theme->breadcrumb()->add(__('สินค้าแฟขั่น'), URL::toLang('/xxxx'));

        // $this->theme->breadcrumb()->add(array(
        //     array(
        //         'label' => 'label1',
        //         'url'   => 'http://...'
        //     ),
        //     array(
        //         'label' => 'label2',
        //         'url'   => 'http://...'
        //     )
        // ));

        $this->theme->setTitle("Search ".$keyword);
        $this->theme->setMetadescription(__('seo_description_home'));
        $this->theme->setMetakeywords(__('seo_keyword_home'));

        return $this->theme->scope('products.level-c', $view)->render();
    }

}

