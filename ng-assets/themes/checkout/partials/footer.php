<?php
//if ( App::environment('production') || App::environment("beta") )
//{
//    // The environment is production
//    $open_https = true;
//}
//else
//{
//    $open_https = false;
//}

$open_https = Config::get("https.useHttps");
?>
<div id="footer">
    <div class="sub-content">
<!--        <div class="left"><?php echo __("footer-call-center-txt"); ?> <br />
            เพื่อนบ้าน : <a target="_blank" href="<?php echo Config::get("endpoints.weloveshipping_url"); ?>">weloveshopping.com</a>, <a target="_blank" href="<?php echo Config::get("endpoints.truestore_url"); ?>">store.truecorp.cp.th</a>
       	</div>-->
        <div class="right">
            © Copyright 2013 <a href="<?php echo URL::toLang("/", array(), $open_https); ?>">www.itruemart.com</a> - All rights reserved
        </div>
    </div>
    <div class="clear"></div>
</div>