<?php

class NewsController extends FrontBaseController {
    
    public $news;
	public $banner;
	
	public function __construct(NewsRepositoryInterface $news , BannerRepositoryInterface $banner)
    {
        parent::__construct();
        $this->news = $news;
		$this->banner = $banner; 
		// Included JS
		$this->theme->asset()->container('footer')->usePath()->add('news-js', 'js/news.js');
	}

	public function getIndex()
	{
		$views = array();
		
		### News Hilight Banner ###
		$new_banner = $this->banner->getByPosition(10);
		$views['banner_list'] = isset($new_banner['position_10']) ? $new_banner['position_10']['group_list'] : array();
		
		### Main list News ###		
		$column_data = array();
		$column_data[] = $this->news->getAllInsight(1); //left
		$column_data[] = $this->news->getAllInsight(3); //right
		$column_data[] = $this->news->getAllInsight(2); //center
		
		$views['main_list_news'] = $column_data;
		
		$this->theme->breadcrumb()->add(__('news'), URL::current('/'));
		
		// Included CSS
        $this->theme->asset()->usePath()->add('bxslider-css', 'css/jquery.bxslider.css');
		
		// Included JS
		// $this->theme->asset()->container('footer')->usePath()->add('news-js', 'js/news.js');
		
		return $this->theme->scope('news.index', $views)->render();
	}
	
	public function getCategory($categorySlug = NULL, $categoryId = NULL) 
	{
		$data = array();
		
		if ($categoryId == 0)
		{
			$args = array(
				'cat_id' => 0,
				'page' => Input::get('page'),
				'limit' => 3,
				'condition' => 'all'
			);
		}
		else
		{
			$args = array(
				'cat_id' => $categoryId,
				'page' => Input::get('page'),
				'limit' => 3,
				'condition' => 'category'
			);
		}
		$data['news'] = $this->news->getNewsList($args);		

		$data['category_id'] = $categoryId; 
		$data['category_slug'] = $categorySlug;

		$this->theme->breadcrumb()->add('News', URL::toLang('news'));
		return $this->theme->scope('news.cate-list', $data)->render();
	}

	public function getDetail($newsSlug = NULL )
	{
		$data = array();
		
		if(! empty($newsSlug))
		{
			$tmp = explode('-', $newsSlug);
			$count = count($tmp);
			if($count > 1)
			{
				$id = $tmp[$count-1];
				unset($tmp[$count-1]);
				$slug = implode('-', $tmp);

			}
		}
		
		//--- Level D ---//
		if(!empty($id))
		{
			$data['data'] = $this->news->getDetail($id);
		}
                
		return $this->theme->scope('news.detail', $data)->render();
	}



}