<?php

namespace Mobile;


use MobileBaseController;
use NewsRepositoryInterface;

class NewsController extends MobileBaseController {

    public $news;

	public function __construct(NewsRepositoryInterface $news )
    {
        parent::__construct();
        $this->news = $news;
		// Included JS
	}



	public function getDetail($newsSlug = NULL )
	{
		$data = null;

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
			$data = $this->news->getDetail($id);
		}

        $view = compact('data');

        return $this->theme->scope('news.news-content', $view)->render();
	}



}