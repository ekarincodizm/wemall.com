<?php
date_default_timezone_set("Asia/Bangkok");

$path = __DIR__ . '/../../../../app/config/a-develop/gearman.php';
$gearman = include_once($path);
$gw = new  GearmanWorker();
$gw->addServer($gearman['host'], $gearman['port']);
$gw->addFunction("log_entries", "run_worker");


while ($gw->work()) {
    if ($gw->returnCode() != GEARMAN_SUCCESS) {
        print(chr(10)."return_code: " . $gw->returnCode() .chr(10)) ;
        break;
    }
}

function run_worker($job)
{
    echo "<p>==== Begin Worker ====</p>";
    $info_json = $job->workload();
    #$info_data = json_decode($info_json, 1);
    #var_dump($info_data);

    $logentries_path = __DIR__.'/../../logentries.php';
    require($logentries_path);



    $log->Info($info_json);

    echo "<p>==== End Worker ====</p>";

}
