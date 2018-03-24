<?php
date_default_timezone_set("Asia/Bangkok");

$path = __DIR__ . '/../../../../app/config/local/gearman.php';

$gearman = include_once($path);
$logentries_path = __DIR__.'/logentries.php';
require($logentries_path);

$gw = new  GearmanWorker();


$gw->addServer($gearman['host'], $gearman['port']);
$gw->addFunction("log_entries", "run_worker");


print("<p>==== Begin Worker ====</p>".chr(10));
while ($gw->work()) {
    if ($gw->returnCode() != GEARMAN_SUCCESS) {
        print(chr(10)."return_code: " . $gw->returnCode() .chr(10)) ;
        break;
    }

    print("<p>==== End Worker Success ====</p>".chr(10));
}

function run_worker($job)
{
    $info_json = $job->workload();
    #$info_data = json_decode($info_json, 1);
    #var_dump($info_data);


    try {
        $log->Info($info_json);
    }
    catch (Exeception $e)
    {
        echo $e->getMessage();
    }


}
