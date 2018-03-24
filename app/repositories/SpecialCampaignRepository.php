<?php

class SpecialCampaignRepository implements SpecialCampaignRepositoryInterface
{
    protected $pcmsClient;

    public function __construct()
    {
        $this->pcmsClient = App::make('pcms');
    }
	
	public function getPrivilegeData($sso_id=NULL)
	{
		$params = array('sso'=>$sso_id);
		$data = array();
		$response = $this->pcmsClient->api('luckydraw/privilege', $params, 'GET');
		
		if(isset($response['code']) and $response['code'] == 200)
		{
			$data = $response['data'];
		}
		return $data;
	}
	
	public function getOrderListData($sso_id=NULL)
	{
		$params = array('sso'=>$sso_id);
		$data = array();
		$response = $this->pcmsClient->api('luckydraw/order-list', $params, 'GET');
		
		if(isset($response['code']) and $response['code'] == 200)
		{
			$data = $response['data'];
		}
		return $data;
	}

}
