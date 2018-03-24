<?php
/**
 *	@author  Preme W. <preme_won@truecorp.co.th
 *	@since   
 *
 */
class BestSellerRepository implements BestSellerRepositoryInterface {

	protected $pcmsClient;

    public function __construct()
    {
        $this->pcmsClient = App::make('pcms');

    }

	public function getByCollection($pkey = NULL)
	{
		$params = array(); 
		$response = $this->pcmsClient->api("collections/{$pkey}/bestseller", $params, 'GET');
		#alert($response, 'red');

		if ($response['code'] == 200)
		{
			return $response['data'];
		}
		else
		{
			return NULL; 
		}
	}
}