<?php
header('Access-Control-Allow-Origin: http://' . $_SERVER['HTTP_HOST']);
$date = date_create();
$datetime = date_timestamp_get($date);
?>
<html>
<head>
    <script type="text/javascript" src="javascripts/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="http://service<?php echo str_replace("www","",$_SERVER['HTTP_HOST']) ?>/luckyegg/javascripts/inc.js?a=<?php echo $datetime ?>"></script>
    <title>Lucky Egg</title>
</head>
<body>
</body>
</html>