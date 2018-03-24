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
            © Copyright 2015 <a href="<?php echo URL::toLang("/", array(), $open_https); ?>">www.itruemart.ph</a> - All rights reserved
        </div>
    </div>
    <div class="clear"></div>
</div>
<script type="text/javascript">var $zoho= $zoho || {salesiq:{values:{},ready:function(){}}};var d=document;s=d.createElement("script");s.type="text/javascript";s.defer=true;s.src="https://salesiq.zoho.com/ascendph/float.ls?embedname=embed1.customerloyaltyteam";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);</script>