<?php

class PaymentManualController extends FrontBaseController {

	public function getIndex()
	{
        $this->theme->asset()->usePath()->add('itruemart-manual', 'css/itruemart.manual.css');
        $this->theme->asset()->usePath()->add('itruemart-manual-js', 'js/payment_manual.js');

		return $this->theme->scope('payment.manual')->render();
	}

}