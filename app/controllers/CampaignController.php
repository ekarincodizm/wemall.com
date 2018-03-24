<?php

class CampaignController extends FrontBaseController
{
    /**
     * @var CampaignRepository
     */
    public $campaign;
    private $cache_time = 1440;

    public function __construct(CampaignRepositoryInterface $campaign)
    {
        parent::__construct();
        $this->campaign = $campaign;
    }

    public function getLineCampaign()
    {
        // get data
        $id = Input::get('campaign', false);
        $previews = Input::get('previews', false);
        $no_cache = Input::get('no-cache', false);

        // validate data
        if (empty($id)) {
            return Redirect::to('/404.html');
        }

        // define cache
        $cache_key = 'campaign-line-' . $id;
        $cache_data = ElastiCache::getResult($cache_key);

        $page_content = array_get($cache_data, 'content', false);
        $page_active = array_get($cache_data, 'active', false);
        if (!empty($cache_data) && !$no_cache && $previews != 'LS2') {
            return $page_active!='Y' ? Redirect::to('/404.html') : $page_content;
        }

        // set template
        $this->theme->uses('itruemart-mobile');
        $this->theme->asset()->container('footer')->usePath()->add('itruemart-login-js', 'js/login.js');
        $this->theme->asset()->container('footer')->usePath()->add('sso-js', 'js/sso.js');
        $this->theme->asset()->usePath()->add('jquery.bxslider.css', 'css/jquery.bxslider.css');
        $this->theme->setTitle('iTruemart Line Campaign');
        $this->theme->setSubfooter($this->theme->scope("campaign.campaign_footer", array())->content());

        // set view data
        $views['id'] = $id;
        $views['previews'] = $previews;
        $views['no_cache'] = $no_cache;

        // set campaign data
        $data = $this->campaign->getLineCampaign($id, $previews, $no_cache);
        $status = array_get($data,'status',false);
        $code = array_get($data,'code',false);

        // cache active data
        $data_cache['active'] = array_get($data, 'data.status', 'N');

        if($status != "success" || $code != 200){
            if ($code == 404) {
                ElastiCache::save($cache_key, $data_cache, $this->cache_time);
            }
            return Redirect::to('/404.html');
        }

        // save cache
        $views['campaign_data'] = $data;
        $render = $this->theme->scope('campaign.line_campaign', $views)->render();

        // cache content data
        $data_cache['content'] = $render;
        ElastiCache::save($cache_key, $data_cache, $this->cache_time);

        return $render;
    }

    public function getContent()
    {
        $views = array();
        $views['content'] = '';
        #ex. campaign=45&previews=y
        $id = Input::get('id', '');
        $previews = Input::get('previews', '');
        $title = Input::get('title', 'iTruemart Line Campaign');
        $no_cache = Input::get('no_cache', '');
        $debug = Input::get('debug', '');

        if (!empty($id)) {

            $data_cache_key = 'front_line_campaign_data_' . $id . '_' . $previews;
            $that = $this;

            if (!empty($no_cache)) {
                Cache::forget($data_cache_key);
            }
            $data_line = Cache::remember($data_cache_key, 60, function () use ($that, $id, $previews) {
                return $that->campaign->getLineCampaign($id, $previews);
            });

            if (!empty($debug)) {
                alert($data_line);
            }

            if (isset($data_line['data']['content'])) {
                if (($previews == 'LS2' && $data_line['data']['status'] == 'N')) {
                    $views['content'] = $data_line['data']['content'];
                }

                if($data_line['data']['status'] == 'Y')
                {
                    $views['content'] = $data_line['data']['content'];
                }
            }
        }
        $views['id'] = $id;
        $views['previews'] = $previews;
        $views['title'] = $title;
        $views['no_cache'] = $no_cache;

        return View::make('campaign.line_campaign_content')->with($views);
    }

    public function getEverydayWow()
    {
        $view = array();
        $views['content'] = '';
        #ex. campaign=45&previews=y
        $id = Input::get('id', 43);
        $previews = Input::get('previews', '');
        $title = Input::get('title', 'Everyday Wow');
        $no_cache = Input::get('no-cache', '');
        $debug = Input::get('debug', '');

        $data_cache_key = 'front_super_deal_page_data_' . $id . '_' . $previews;

        $that = $this;

        if (!empty($no_cache)) {
            Cache::forget($data_cache_key);
        }
        $data_line = Cache::remember($data_cache_key, 60, function () use ($that, $id, $previews) {
            return $that->campaign->getLineCampaign($id, $previews);
        });

        if (!empty($debug)) {
            alert($data_cache_key);
            alert($data_line);
        }

        if (isset($data_line['data']['content'])) {
            if (($previews == 'LS2' && $data_line['data']['status'] == 'N')) {
                $views['content'] = $data_line['data']['content'];
                $title = $data_line['data']['campaign_name'];
            }
            if($data_line['data']['status'] == 'Y')
            {
                $views['content'] = $data_line['data']['content'];
            }
        }

        $this->theme->setTitle($title);
		$this->theme->asset()->usePath()->add('main-css', 'css/main.css');
		$this->theme->asset()->container('footer')->usePath()->add('countdown-js', 'js/super_deal/lib/jquery.countdown.min.js');
		$this->theme->asset()->container('footer')->usePath()->add('lazyload-js', 'js/super_deal/lib/jquery.lazyload.min.js');
		$this->theme->asset()->container('footer')->usePath()->add('superdeal-js', 'js/super_deal/superdeal.js');
		
        return $this->theme->scope('campaign.everydaywow', $views)->render();
    }
}
