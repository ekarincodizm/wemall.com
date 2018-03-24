<?php

use Illuminate\Support\MessageBag;

class CreditRepository implements CreditRepositoryInterface {

    protected $pcmsClient;
    protected $locale;

    public function __construct()
    {
        $this->pcmsClient = App::make('pcms');
    }
	
	public function getCreditCard($ssoId = null)
	{
		$return = array();
		
		$creditCardData = $this->pcmsClient->api('credit-card/card-list?ssoId='.$ssoId);
		
		if( !empty($creditCardData['status']) && !empty($creditCardData['code']) )
		{
			if( $creditCardData['status'] == 'success' && $creditCardData['code'] == 200 )
			{
				if(!empty($creditCardData['data']))
				{
					$return = $creditCardData['data'];
				}
			}
		}
		
		return $return;
	}
	
}