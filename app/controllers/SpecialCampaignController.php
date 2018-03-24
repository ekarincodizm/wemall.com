<?php

class SpecialCampaignController extends FrontBaseController
{

    public $lucky;

    public function __construct(SpecialCampaignRepositoryInterface $lucky)
    {
        parent::__construct();
        $this->lucky = $lucky;
    }
	
    public function getIndex()
    {
		//echo 'หน้ารับประกันสินค้า';
		$this->theme->setTitle('iTruemart Lucky Draw Campaign');
		$views['content'] = '';
        return $this->theme->scope('campaign.luckydraw_detail', $views)->render();
    }
	
	public function getPrivilege()
	{
		$user = ACL::getUser();
		if ($user['group'] == 'guest') return Redirect::to(URL::toLang('/auth/login?continue='.URL::current()));
		
		//$user['ssoId'] = '141721';
		$coupon_use_count = 0;
		
		$privilege = $this->lucky->getPrivilegeData($user['ssoId']);
		$orders = $this->lucky->getOrderListData($user['ssoId']);
		//alert($orders);
		
		if (isset($privilege['code']))
		{
			foreach ($privilege['code'] as $coupon)
			{
				if ($coupon['used'] == 'N') $coupon_use_count = $coupon_use_count+1;
			}
		}
		
		$views['coupon_use_count'] = $coupon_use_count;
		$views['privilege'] = $privilege;
		$views['orders'] = $orders;
		$this->theme->setTitle('iTruemart Lucky Draw Campaign');
		$this->theme->asset()->container('footer')->usePath()->add('fancyboxjs', 'js/fancybox/source/jquery.fancybox.js?v=2.1.5');
		$this->theme->asset()->usePath()->add('fancyboxcss', 'js/fancybox/source/jquery.fancybox.css');
		$this->theme->asset()->usePath()->add('add2', 'css/luckydraw/add2.css');
        return $this->theme->scope('campaign.luckydraw_mcheck', $views)->render();
	}
	
	public function getPrivilegeMember()
	{
		$views['user'] = ACL::getUser();
		if ($views['user']['group'] == 'guest') return Redirect::to(URL::toLang('/auth/login?continue='.URL::current()));
		
		$pcms = App::make('pcms');
		$lastlogin = $pcms->api('lastlogin/'.$views['user']['ssoId']);
        if (empty($lastlogin['data']))
            $views['lastlogin'] = '';
        else
            $views['lastlogin'] = $lastlogin['data'][0]['login_at'];
		
		//$user['ssoId'] = '141721';
		$coupon_use_count = 0;
		
		$privilege = $this->lucky->getPrivilegeData($views['user']['ssoId']);
		$orders = $this->lucky->getOrderListData($views['user']['ssoId']);
		
		if (isset($privilege['code']))
		{
			foreach ($privilege['code'] as $coupon)
			{
				if ($coupon['used'] == 'N') $coupon_use_count = $coupon_use_count+1;
			}
		}
		
		$views['coupon_use_count'] = $coupon_use_count;
		$views['privilege'] = $privilege;
		$views['orders'] = $orders;
		$this->theme->setTitle('iTruemart Lucky Draw Campaign');
		$this->theme->asset()->container('footer')->usePath()->add('fancyboxjs', 'js/fancybox/source/jquery.fancybox.js?v=2.1.5');
		$this->theme->asset()->usePath()->add('fancyboxcss', 'js/fancybox/source/jquery.fancybox.css');
		$this->theme->asset()->usePath()->add('add2', 'css/luckydraw/add2.css');
        return $this->theme->scope('member.lucky_privilege', $views)->render();
	}

    
}
