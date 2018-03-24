<?php
date_default_timezone_set("Asia/Bangkok");
$meta = array(
    'clicked:check_stock',
    'clicked:add_to_cart'
);
#de($meta, true);

$fields = array(
    'UserIPAddress' => $_SERVER['REMOTE_ADDR'],
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
    'Meta' => $meta
);



$gc = new GearmanClient();

try {
    $gc->addServer("alpha-gearman.itruemart-dev.ph", 4730);
    $data = json_encode($fields, true);
    var_dump($data);
    $gc->doBackground('log_entries', $data);
}
catch (GearmanException $e)
{
    echo "error";

}
