<?php

namespace Mobile;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Request;

//use \ProductRepositoryInterface;
//use Illuminate\Support\Facades\Lang;

class CategoriesController extends \MobileBaseController {

    private $pcms;
    private $category_id;

    public function __construct()
    {
        parent::__construct();

        $this->pcms = App::make('pcms');
        
        $this->category_id = Config::get('widget_params.category_top_menu');
    }

    public function getIndex()
    {
        $view = array();
        $meta_title = __('seo_title_home').' | iTrueMart.ph' ;
        $this->theme->setTitle($meta_title);
        $this->theme->setMetadescription(__('seo_description_home'));
        $this->theme->setMetakeywords(__('seo_keyword_home'));
        $this->theme->setCanonical('http://'.Request::server ("SERVER_NAME").'/shopbybrand');

        return $this->theme->scope('categories.index', $view)->render();
    }
    
    public function getContent()
    {
        $this->theme->layout('blank');
        
        $categories = $this->pcms->apiv2('app-categories?category_id='.$this->category_id);
        $categories = $categories['data'];
        
        $view = compact('categories');

        return $this->theme->scope('categories.content', $view)->render();
    }
    
    public function getSubCategory($pkey)
    {
        $view = compact('pkey');

        return $this->theme->scope('categories.sub-category', $view)->render();
    }
    
    public function getSubCategoryContent($pkey)
    {
        $this->theme->layout('blank');
        
        $categories = $this->pcms->apiv2('app-categories?category_id='.$this->category_id);
        $categories = $categories['data'];
        
        foreach ($categories['collections'] as $collection)
        {
            if ($collection['pkey'] == $pkey)
            {
                $category = $collection;
            }
        }
        
        $view = compact('category');
        
        return $this->theme->scope('categories.sub-category-content', $view)->render();
    }

}
