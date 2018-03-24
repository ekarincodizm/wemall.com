<?php
class PaymentCreditCardController extends FrontBaseController{
    public function getCreditCardInfo(){
        s($_REQUEST);
        $data['testkey'] = 'test value';
        //$this->theme->asset()->usePath()->add('itruemart-manual', 'css/itruemart.manual.css');
        return $this->theme->scope('payment.creditcard', $data)->render();
    }
}