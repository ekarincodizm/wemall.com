<?php

class TestController extends BaseController {

	protected $pcmsClient;

	public function __construct()
	{
		if (strtolower(App::environment()) === 'production')
		{
			return Redirect::route('home');
		}

		$this->pcmsClient = App::make('pcms');
	}

	public function getTum()
	{
		echo "<img src='http://itruemart-true.igetapp.com/themes/itruemart/assets/images/itruemart-logo.jpg' height='66'>";
	}

	function getPrevPkey($key, $hash = array())
	{

	    $keys = array_keys($hash);

	    $found_index = array_search($key, $keys);

	    if ($found_index === false || $found_index === 0)
	        return 'prev';
	    return $keys[$found_index-1];
	}

	public function anyGoon()
	{
		s('Hello! Rainy Day');
		// $code = ActivateCode::generate('siyingui@gmail.com');
	}

	public function getUser()
	{
		sd(ACL::getUser());
	}

    public function getSetNewUser()
    {
        $cookie = Session::forget('profile');
        return Redirect::to('/');
    }

	public function getSso($accessToken)
	{
		$sso = App::make('sso');
		sd($sso->getUserByAccessToken($accessToken));
	}

	public function getSsoSearch()
	{
		$sso = App::make('sso');
		sd($sso->search());
	}

	public function getEmailActivate()
	{
		$memberRepo = App::make('MemberRepository');
		$memberRepo->sendEmailActivate('siyingui@gmail.com', 18560770, 'Meiting Narak');
	}

	public function getApi()
	{
		echo '<h1>=============== Products API ===============</h1>';
		$pkey = 29913836247921;
		$title = 'Get Product by pkey ($pkey = ' . $pkey . ')';
		$rs = $this->pcmsClient->api("products/{$pkey}");
		extract($rs);
		d($title, $status, $message, $data);

		$inventory_id = 8584;
		$title = 'Check Stock Remaining by inventory_id ($inventory_id = '.$inventory_id.')';
		$rs = $this->pcmsClient->api("inventories/{$inventory_id}/remaining");
		extract($rs);
		d($title, $status, $message, $data);

		$pkey = 3781387446972;
		$title = 'Get Best Seller Product API ($pkey = ' . $pkey . ')';
		$rs = $this->pcmsClient->api("products/search");
		extract($rs);
		d($title, $status, $message, $data);

		$title = 'Search Product API';
		$rs = $this->pcmsClient->api("products/search");
		extract($rs);
		d($title, $status, $message, $data);

		echo '<h1>=============== Brands API ===============</h1>';
		$title = 'Get Brands';
		$rs = $this->pcmsClient->api("brands");
		extract($rs);
		d($title, $status, $message, $data);

		$pkey = 61171376468634;
		$title = 'Get Brand by pkey ($pkey = ' . $pkey . ')';
		$rs = $this->pcmsClient->api("brands/{$pkey}");
		extract($rs);
		d($title, $status, $message, $data);

		$title = 'Get Flash-Sale Brands';
		$rs = $this->pcmsClient->api("brands/flash-sale");
		extract($rs);
		d($title, $status, $message, $data);

		/*
		$title = 'Get iTruemart TV Brands';
		$rs = $this->pcmsClient->api("brands/itruemart-tv");
		extract($rs);
		d($title, $status, $message, $data);

		$title = 'Get Discount Brands';
		$rs = $this->pcmsClient->api("brands/discount");
		extract($rs);
		d($title, $status, $message, $data);

		$title = 'Get Trueyou Brands';
		$rs = $this->pcmsClient->api("brands/trueyou");
		extract($rs);
		d($title, $status, $message, $data);
		*/

		echo '<h1>=============== Collections API ===============</h1>';
		$title = 'Get Collections';
		$rs = $this->pcmsClient->api("collections");
		extract($rs);
		d($title, $status, $message, $data);

		$pkey = 3781387446972;
		$title = 'Get Collection by pkey ($pkey = ' . $pkey . ')';
		$rs = $this->pcmsClient->api("collections/{$pkey}");
		extract($rs);
		d($title, $status, $message, $data);

		$title = 'Get Collections Brands ($pkey = ' . $pkey . ')';
		$rs = $this->pcmsClient->api("collections/{$pkey}/brands");
		extract($rs);
		d($title, $status, $message, $data);

		$title = 'Collection API';
	}

	public function anyStartDebug()
	{
		Session::put('safe-debug', 'debugging');
	}

	public function anyStopDebug()
	{
		Session::forget('safe-debug');
	}

	public function getIP()
	{
		sd(Request::getClientIp());
	}

}