<?php

class LabsController extends FrontBaseController {

    /**
     * Example call iTruemart api.
     *
     * @return void
     */
    public function getApiItruemart()
    {
        $itruemart = App::make('itruemart');

        $res = $itruemart->subscribe(array(
            'email' => 'teepluss@gmail.com'
        ));

        sd($res->getResponse());
    }

    /**
     * Example call sso api.
     *
     * @return void
     */
    public function getApiSso()
    {
        $sso = App::make('sso');
    }

    /**
     * Example language helper.
     *
     * @return void
     */
    public function getLang()
    {
        echo __('test', array('name' => 'Tee'));
    }

    /**
     * Example excel reader.
     *
     * @return void
     */
    public function getExcel()
    {
        ini_set('display_errors', 'on');
        ini_set('memory_limit', -1);
        error_reporting(E_ALL);

        $rows = new SpreadsheetReader(public_path('data/products.xls'));
        //$rows = new SpreadsheetReader(public_path('data/products.xlsx'));

        foreach ($rows as $row)
        {
            s($row);
        }
    }

    public function getTrueu()
    {
        $trueCard = App::make('truecard');

        $res = $trueCard->getInfoByThaiId('5300799036049')->check();

        s($res);

        $hasCard = $trueCard->getInfoByThaiId('5300799036049')->hasCard();

        s($hasCard);

        $isRed = $trueCard->getInfoByThaiId('5300799036049')->isRed();

        s($isRed);

        $isBlack = $trueCard->getInfoByThaiId('5300799036049')->isBlack();

        s($isBlack);

    }

    public function getUser()
    {
        $sso = App::make('sso');

        $accessToken = Input::get('access_token', "1|1.7bcf75f69e19f2d8928443__3600.1391574357-18802312|f3c111cbaea0e2b9e6f893a3864");

        $res = $sso->getUserByAccessToken($accessToken);

        s($accessToken);
        sd($res);
    }

    public function getAddress()
    {
        $pcms = App::make('pcms');

        $response = $pcms->api('cities', array('province_id' => Input::get('province_id', 1)));

        sd($response);
    }

    public function getCache()
    {
        s(Config::get('cache.driver'));

        Cache::tags('people', 'authors')->put('John', 'John', 5);

        Cache::tags('people', 'authors')->put('Anne', 'Anne', 5);
    }

    public function getCacheView()
    {
        s(Cache::tags('people', 'authors')->get('John'), Cache::tags('people', 'authors')->get('Anne'));
    }

    public function getCacheFlush()
    {
        Cache::tags('people')->flush();
        //Cache::tags('people', 'authors')->forget('John');
    }
    
    public function getUserAgent(){
        $userAgentRepo = App::make("UserAgentRepository");
        s($userAgentRepo->getUserAgent());
        sd($userAgentRepo->getUserAgentWidth());

    }

    public function getSetCustomerInfo(){

        $start = microtime(true);
        $pcms = App::make("pcms");

        $user = ACL::getUser();
        $_params = array();
        $_params['customer_ref_id'] = $user['user_id'];
        $_params['customer_type']   = ACL::isLoggedIn() ? 'user' : 'non-user';
        $_params['customer_email']  = "inthra.onsap@gmail.com";
        $response = $pcms->api('checkout/set-customer-info', $_params, 'post');

        $end = microtime(true);
        echo "start : " . $start * 1000 . "<br/>";
        echo "end : " . $end * 1000 . "<br/>";
        echo "total : ";
        return ($end - $start) * 1000; //milisecond

    }
    public function getCustomerInfo(){
        $start = microtime(true);

        $pcms = App::make("pcms");
        $pcms->getCheckout();

        $end = microtime(true);
        echo "start : " . $start * 1000 . "<br/>";
        echo "end : " . $end * 1000 . "<br/>";
        echo "total : ";
        return ($end - $start) * 1000; //milisecond
    }

    public function getSetCustomerCache(){
        $start = microtime(true);

        ElastiCache::save(__METHOD__."lab-customer-info", '{"status":"success","code":200,"message":"200 OK","data":{"order_ref":null,"app_id":"1","ref1":null,"ref2":null,"ref3":null,"customer_ref_id":"993902199677d9ce31033b81339040c5","customer_address_id":null,"customer_name":null,"customer_address":null,"customer_district_id":null,"customer_city_id":null,"customer_province_id":null,"customer_district":null,"customer_city":null,"customer_province":null,"customer_postcode":null,"customer_tel":null,"customer_email":"inthra.onsap@gmail.comtest","bill_name":null,"bill_address":null,"bill_province_id":null,"bill_city_id":null,"bill_dristrict_id":null,"bill_district_id":null,"bill_postcode":null,"save_ccw":"N","is_new_ccw":"N","thai_id":null,"payment_channel":null,"payment_method":null,"payment_method_code":null,"type":"normal","installment":null,"transaction_time":null,"total_price":0,"total_discount":0,"total_shipping_fee":0,"discount":0,"discount_text":null,"sub_total":0,"order_status":"draft","payment_status":"waiting","customer_status":null,"items_count":0,"variants_count":0,"promotions":[],"discount_campaigns":[],"cash_voucher":0,"confirm_checkout":"0","bill_same_shipping":"Y","bank_id":null,"bank_name":null,"isTrueyouable":false,"order_ccw":{"save_ccw":"N","is_new_ccw":"N","card_token":null,"card_label":null},"billing":{"name":null,"province_id":null,"province_name":null,"city_id":null,"city_name":null,"district_id":null,"district_name":null,"address":null,"postcode":null},"shipments":[]}}', Request::path());

        $end = microtime(true);
        echo "start : " . $start * 1000 . "<br/>";
        echo "end : " . $end * 1000 . "<br/>";
        echo "total : ";
        return ($end - $start) * 1000; //milisecond
    }

    public function getCustomerCache(){
        $start = microtime(true);

        ElastiCache::getResult(__METHOD__."lab-customer-info");

        $end = microtime(true);
        echo "start : " . $start * 1000 . "<br/>";
        echo "end : " . $end * 1000 . "<br/>";
        echo "total : ";
        return ($end - $start) * 1000; //milisecond
    }

}