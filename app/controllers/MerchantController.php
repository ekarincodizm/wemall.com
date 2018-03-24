<?php

class MerchantController extends FrontBaseController
{
    public $campaign;
    private $cache_time = 1440;

    public function __construct(CampaignRepositoryInterface $campaign)
    {
        parent::__construct();
        $this->campaign = $campaign;
    }

    public  function landingPage($prefix = null){

        $previews = Input::get('previews', '');
        $no_cache = Input::get('no-cache', false);

        if(empty($prefix)){
            return Redirect::to('/404.html');
        }

        $cache_key = "EdmCampaign-merchant-" . $prefix;
        $cache_data = ElastiCache::getResult($cache_key);

        $page_content = array_get($cache_data, 'content', false);
        $page_active = array_get($cache_data, 'active', false);
        if (!empty($cache_data) && !$no_cache && $previews != 'LS2') {
            return $page_active!='Y' ? Redirect::to('/404.html') : $page_content;
        }

        $data = $this->campaign->getMerchantLandingPage($prefix, $previews, $no_cache);
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

        $views = $data['data'];
        $this->theme->setTitle($views['campaign_name']);
        $render = $this->theme->scope('merchant.landingpage', $views)->render();

        // cache content data
        $data_cache['content'] = $render;
        ElastiCache::save($cache_key, $data_cache, $this->cache_time);

        return $render;

    }

}