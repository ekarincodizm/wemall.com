<?php
date_default_timezone_set("Asia/Bangkok");

$HOST = $_SERVER['HTTP_HOST'];



if (preg_match("/(.*)\.loc/", $HOST))
{
    $env = "local";
}
elseif (preg_match("/alpha-www\.itruemart\-dev\.com/", $HOST))
{
    $env = "aws-alpha";
}
elseif (preg_match("/www\.itruemart\-dev\.com/", $HOST))
{
    $env = "aws-staging";
}
elseif (preg_match("/www\.itruemart\.com/", $HOST))
{
    $env = "production";
}
else
{
    $env = "local";
}
$path = __DIR__ . '/../../../app/config/'.$env.'/gearman.php';
require($path);





#var_dump($gearman);
$gw = new  GearmanWorker();
#var_dump($gearman);
#exit;
$gw->addServer("alpha-gearman.itruemart-dev.ph", $gearman['port']);
$gw->addFunction("log_entries", "run_worker");


while ($gw->work()) {
    if ($gw->returnCode() != GEARMAN_SUCCESS) {
        print(chr(10)."return_code: " . $gw->returnCode() .chr(10)) ;
        break;
    }
}

#var_dump($gc);



#$gc->addServer($gearman['host'], $gearman['port']);
#$gc->doBackground("log_entries", $pack_data['']);
//var_dump($g);


function run_worker($job)
{
    echo "<p>==== Begin Worker ====</p>";
//    if(isset($_GET['force_q']))
//    {
//        return true;
//    }
    $info_json = $job->workload();
    #$info_data = json_decode($info_json, 1);
    #var_dump($info_data);

    $logentries_path = __DIR__.'/../logentries.php';
    require($logentries_path);



    $log->Info($info_json);
    #$f = fopen("test.txt", "a+");
    #$data = fread($f, 30000);
    #fputs($f, $data);
    #fclose($f);
    echo "<p>==== End Worker ====</p>";

}
// $json = array(
// 	'EventId' => 'add_to_cart',
// 	'Title' => 'หยิบสินค้า iPhone 6 เข้าตะกร้า',
// 	'Tags' => 'checkout|add_to_cart|level_d|search'
// );
// $log->Info(json_encode($json, true));
// $log->Warn("I'm a warning message");

#$worker_log_entries = new GearmanWorker();
#$worker_log_entries->addServer($gearman_conf['host'], $gearman_conf['port']);
#$worker_log_entries->addFunction("log_orders_2", "run_worker");


//print (chr(10)."log_orders_2 :: Waiting for job...".chr(10));
//while ($worker_log_orders_2->work()) {
//if ($worker_log_orders_2->returnCode() != GEARMAN_SUCCESS) {
//print(chr(10)."return_code: " . $worker_log_orders_2->returnCode() .chr(10)) ;
//break;
//}
//print('run log_orders_2 work success'.chr(10));
//}