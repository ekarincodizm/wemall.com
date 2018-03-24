<?php

class PolicyController extends FrontBaseController {

	public function getView($ptype = null)
	{
		$this->theme->asset()->container('after_itruemart')->usePath()->style("itruemart.policy", "css/itruemart.policy.css", array('itruemart'));

		if(strtolower($ptype) == "returnpolicy")
		{
			setSeoMeta('policy.returnpolicy');
			return $this->theme->scope('policy.return_policy')->render();
		}
		else if(strtolower($ptype) == 'moneyback')
		{
			setSeoMeta('policy.moneyback');
			return $this->theme->scope('policy.money_back')->render();
		}
		else if(strtolower($ptype) == 'freedelivery')
		{
			setSeoMeta('policy.freedelivery');
			return $this->theme->scope('policy.free_delivery')->render();
		}
		else if(strtolower($ptype) == 'fastdelivery')
		{
			return $this->theme->scope('policy.fast_delivery')->render();
		}
		else
		{
			return Redirect::to('/');
		}
	}

}