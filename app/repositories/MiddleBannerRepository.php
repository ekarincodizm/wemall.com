<?php
/**
 *  @author  Peerapat S.
 *  @since   Jul 21, 2014
 *  @version   1.0.0
 *
 */
class MiddleBannerRepository implements MiddleBannerRepositoryInterface {

    protected $pcmsClient;

    public function __construct()
    {
        $this->pcmsClient = App::make('pcms');
    }

    public function getMiddleBanner()
    {
        //$params = array();
        //$response = $this->pcmsClient->api("banners", 11, 'GET');
        //dd($response);

        //$responseData = $response['data'];

        //return $responseData;
        $response = array('title' => 'Test Middle Banners Accordian');
        return $response;
    }
}