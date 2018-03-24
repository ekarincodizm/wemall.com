<?php
/**
 *	@author  Preme W. <preme_won@truecorp.co.th
 *	@since
 *
 */
class AngPaoRepository implements AngPaoRepositoryInterface {

    protected $pcmsClient;

    public function __construct()
    {
        $this->pcmsClient = App::make('pcms');

    }



    public function callapi($data){

        $ssoid = $data['ssoid'];
        $event = $data['event'];
        $params = array('sso'=> $ssoid,'event'=>$event);
        $response = $this->pcmsClient->api('angpao/angpao', $params, 'GET');
        empty($response['data']) ? array() : $response['data'];
        return $response;

    }


    public function angpaocheck($ssoid){
        $params = array('ssoid'=> $ssoid);
        $response = $this->pcmsClient->api('angpao/angpaocheckdata', $params, 'GET');
        empty($response['data']) ? array() : $response['data'] ;
        return $response;
    }





}