<?php

    /**if (!isset($_SERVER['PHP_AUTH_USER']) && empty($_COOKIE["ossy_tool"])) {
        header('WWW-Authenticate: Basic realm="Ossy Tool"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'You cannot access Ossy Tool.';
        exit;
    }*/
    if( (!empty($_SERVER['PHP_AUTH_USER']) &&
        !empty($_SERVER['PHP_AUTH_PW']) &&
        $_SERVER['PHP_AUTH_USER'] == "ossyadmin" &&
        $_SERVER['PHP_AUTH_PW'] == "handsome") || !empty($_COOKIE["ossy_tool"])){

        setcookie("ossy_tool", "1", time()+3600*24);

    }else{
        header('WWW-Authenticate: Basic realm="Ossy Tool"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'You cannot access Ossy Tool.';
        exit;
    }

    include_once "Profiler1.php";
    include_once "ServiceProvider.php";
    $config = require_once "config.php";
    $serviceProvider = new ServiceProvider($config);

    if(isset($_GET["debug"])){
        echo "<pre>";
        print_r($config);
        echo "</pre>";
        die();
    }

    $sum = 0;
    $curlRequest = (!empty($_GET["count"]))? $_GET["count"] : $config["curlRequest"];
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>Ossy Tool</title>
        <link rel="stylesheet" href="<?php echo $config["itmUrl"]; ?>/ossytool/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $config["itmUrl"]; ?>/ossytool/assets/bootstrap/css/bootstrap-theme.min.css">
    </head>
    <body>
        <!-- [S] nav bar -->
        <nav id="myNavbar" class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="sr-only" style="color:#FFF;">Ossy Tools</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/lol" style="color:#FFF;">Ossy Tools</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
            </div>
        </nav>
        <!-- [E] nav bar -->


        <div class="container-fluid">
            <div class="jumbotron"></div>

            <div class="row">
                <div class="col-xs-6">
                    <form method="get" action="<?php echo !empty($config["itmUrl"])? $config["itmUrl"] : ""; ?>/ossytool" accept-charset="UTF-8" id="frm-send">
                        <input name="_token" type="hidden" value="fsiQ78rFnW7YBDkGzfDzLWMXbf88B08YsB40edH4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Pkey : </label>
                            <input type="text" name="pkey" class="form-control" rows="3" id="pkey" value="<?php echo (!empty($_GET["pkey"]))? $_GET["pkey"] : "" ?>" />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Inventory Id : </label>
                            <input type="text" name="inventory_id" class="form-control" rows="3" id="inventory_id" value="<?php echo (!empty($_GET["inventory_id"]))? $_GET["inventory_id"] : "" ?>" />
                        </div>
                        <input type="submit" class="btn btn-success btn-lg" id="btn-send" name="btn-send" value="Run" />
                    </form>
                    <br>
                    <div id="msg-alert" class="" role="alert"></div>
                </div>
            </div>

            <hr/>
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ServiceProvider</th>
                            <?php for($i = 1; $i <= $curlRequest; $i++): ?>
                                <th>curl #<?php echo $i; ?> (sec)</th>
                            <?php endfor; ?>
                            <th>Avg.</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>PCMS</td>
                                <?php $sum = 0; ?>
                                <?php for($i = 1; $i <= $curlRequest; $i++): ?>
                                    <td>
                                        <?php
                                            $time = $serviceProvider->callPCMSByPkey();
                                            echo $time;
                                            $sum += $time
                                        ?>
                                    </td>
                                <?php endfor; ?>
                                <td><?php echo $sum/$curlRequest; ?></td>
                            </tr>
                            <tr>
                                <td>SCM</td>
                                <?php $sum = 0; ?>
                                <?php for($i = 1; $i <= $curlRequest; $i++): ?>
                                    <td>
                                        <?php
                                        $time = $serviceProvider->callSCMbyInventoryId();
                                        echo $time;
                                        $sum += $time
                                        ?>
                                    </td>
                                <?php endfor; ?>
                                <td><?php echo $sum/$curlRequest; ?></td>
                            </tr>
                            <tr>
                                <td>Itruemart</td>
                                <?php $sum = 0; ?>
                                <?php for($i = 1; $i <= $curlRequest; $i++): ?>
                                    <td>
                                        <?php
                                        $time = $serviceProvider->callItmFront();
                                        echo $time;
                                        $sum += $time
                                        ?>
                                    </td>
                                <?php endfor; ?>
                                <td><?php echo $sum/$curlRequest; ?></td>
                            </tr>

<!--                            <tr>-->
<!--                                <td>Mysql Query (carts Table)</td>-->
                                    <?php ////$sum = 0; ?>
                                    <?php ////for($i = 1; $i <= $curlRequest; $i++): ?>
<!--                                    <td>-->
                                    <?php
                                        //$time = $serviceProvider->doQueryToDatabase();
                                        //echo $time;
                                        //$sum += $time
                                    ?>
<!--                                    </td>-->
                                        <?php ////endfor; ?>
<!--                                <td>--><?php ////echo $sum/$curlRequest; ?><!--</td>-->
<!--                            </tr>-->

                            <tr>
                                <td>Mysql Concurrent Connection</td>
                                <td style="text-align: center;" colspan="6">
                                    <?php
                                        $threadRows = $serviceProvider->getConcurrentUserOnDb();

                                        foreach($threadRows as $name=>$thread){
                                            if($name == "processlist_user_db"){
                                                echo "User : '" . $thread["user"] . "' DBname : '" . $thread["db"] . "' Number of request : " . $thread["numb"];
                                            }elseif($name == "processlist_all"){
                                                echo "All Connection : " . $thread["numb"];
                                            }elseif($name == "max_connection"){
                                                echo "Max Connection : " . $thread["Value"];
                                            }

                                            echo "<br/>";
                                        }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- [S] footer -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <footer>
                        <p>© Copyright 2014 iTruemart.com </p>
                    </footer>
                </div>
            </div>
        </div>
        <!-- [E] footer -->
    </body>
</html>