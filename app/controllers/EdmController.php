<?php

class EdmController extends FrontBaseController
{

    public $campaign;

    public function __construct(CampaignRepositoryInterface $campaign)
    {
        parent::__construct();
        $this->campaign = $campaign;
    }

    public function getEdm()
    {
        # force to use the only mobile layout for line campaign.
        $this->theme->uses('itruemart')->layout('edm');
        $views = array();
        #ex. campaign=45&previews=y

        $id = Input::get('id', '');
        $previews = Input::get('previews', '');
        $title = Input::get('title', 'iTruemart Email Marketing');
        $debug = Input::get('debug', '');

        $no_cache = Input::get('no-cache', '');

        $views['id'] = $id;
        $views['previews'] = $previews;
        $views['no_cache'] = $no_cache;

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
        $this->theme->setTitle('iTruemart Email Marketing');
        return $this->theme->scope('campaign.edm', $views)->render();
    }
}
