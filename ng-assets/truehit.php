<html>
    <head></head>
    <body>
        <?php
            $pagename = isset($_GET["pagename"])? htmlentities($_GET["pagename"]) : "";
            echo '<script type="text/javascript">__th_page="' . $pagename . '";</script>
                <script type="text/javascript" src="http://hits.truehits.in.th/data/t0030923.js"> </script> 
                <noscript> 
                <a target="_blank" href="http://truehits.net/stat.php?id=t0030923">
                <img src="http://hits.truehits.in.th/noscript.php?id=t0030923" alt="Thailand Web Stat" border="0" width="14" height="17" />
                </a> 
                <a target="_blank" href="http://truehits.net/">Truehits.net</a> 
                </noscript>';
        ?>
    </body>
</html>
