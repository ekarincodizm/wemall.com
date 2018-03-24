<?php
class GearmanRepository implements GearmanRepositoryInterface {

    public function addQueue($data = null)
    {
//        if (empty($data['UserCookieId']))
//        {
//            return null;
//        }
        if (empty($data['Tags']))
        {
            return null;
        }
        if (empty($data['EventID']))
        {
            return null;
        }
        if (empty($data['ExecutionTime']))
        {
            $data['ExecutionTime'] = date("Y-m-d H:i:s");
        }
        if (empty($data['ServerIPAddress']))
        {
            $data['ServerIPAddress'] = Request::getClientIp();
        }
        if (empty($data['UserIPAddress']))
        {
            $data['UserIPAddress'] = Request::getClientIp();
        }

        #alert($data, 'red', 'data');




//        if (empty($data['']))
//        {
//            $data[''] =
//        }



        /***
         * 'UserIPAddress' => $_SERVER['REMOTE_ADDR'],
        'ServerIPAddress' => $_SERVER['SERVER_ADDR'],
        'UserCookieId' => 'test',
        'UserId' => null,
        'Email' => 'my.email@gmail.com',
        'ExecutionTime' => date("Y-m-d H:i:s"),
        'Tags' => array(
        'tag:level_d',
        'tag:check_variant',
        'tag:check_stock',
        'tag:add_to_cart',
        'tag:checkout1',
        'tag:checkout2',
        'tag:checkout3'
        ),
        'EventID' => 'thankyou',
        // - check_variant
        // - check_stock
        // - add_to_cart,
        // - checkout1
        // - checkout2
        // - checkout3
        // - thankyou
        'Meta' => $json_meta
         */
        #echo Config::get('gearman.host');
        #echo Config::get('gearman.port');
        #exit;
        $gc = new GearmanClient();
        $gc->addServer(Config::get('gearman.host'), Config::get('gearman.port'));
        $json_encode = json_encode($data, true);
        $gc->doBackground('log_entries', $json_encode);

    }
}