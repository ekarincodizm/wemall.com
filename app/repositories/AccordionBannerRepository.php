<?php
/**
 *  @author  Peerapat S.
 *  @since   Jul 21, 2014
 *  @version   1.0.0
 *
 */
class AccordionBannerRepository implements AccordionBannerRepositoryInterface {

    protected $pcmsClient;

    public function __construct()
    {
        $this->pcmsClient = App::make('pcms');
    }

    public function getBanners()
    {
        // get accordions banner at position 41 //
        $params = array(
            'position' => 41
        );
        $out = $this->pcmsClient->apiv2("banners", $params, 'GET');

        // use banner list from group 0
        $banner_list = array_get($out, 'data.0.group_list.0.banner_list', NULL);
        $banners = array();
        $count = 1;

        foreach ($banner_list ?: array() as $item)
        {
            $banner = array(
                'img_path' => $item['img_path'],
                'url_link' => $item['url_link'],
            );

            $banners = array_add($banners, 'acc_banner' . $count, $banner);
            $count += 1;
        }

        return $banners;
    }
}