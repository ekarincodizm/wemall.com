<div class="itm">
<div class="row margin-top-20 footer">
    <div class="col-xs-12 bottom">
        <div class="row">
            <div class="col-xs-12"><h3><?php echo __("Our Services"); ?></h3></div>
            <div class="col-xs-6">
                <ul>
                    <li><a href="<?php echo URL::toLang("member/profile"); ?>"
                           target="_blank"><?php echo __("Profile"); ?></a></li>
                    <!-- <li><a href="#"><?php echo __("Live Agent"); ?></a></li> -->
                    <li><a href="<?php echo URL::toLang("contact_us"); ?>"
                           target="_blank"><?php echo __("footer_contact_us_title"); ?></a></li>
                </ul>
            </div>
            <div class="col-xs-6">
                <ul>
                    <li><a href="<?php echo URL::toLang("order_tracking"); ?>"
                           target="_blank"><?php echo __("Check my order"); ?></a></li>
                    <li><a href="<?php echo URL::toLang("policy/returnpolicy"); ?>"
                           target="_blank"><?php echo __("Return Policy"); ?></a></li>
                    <li><a href="<?php echo URL::toLang("policy/freedelivery"); ?>"
                           target="_blank"><?php echo __("Delivery Policy"); ?></a></li>
                    <li><a href="<?php echo URL::toLang("policy/moneyback"); ?>"
                           target="_blank"><?php echo __("Refund Policy"); ?></a></li>
                    <li>
                        <a href="<?php echo (Config::get("endpoints.support_itruemart.url", false)) ? Config::get("endpoints.support_itruemart.url", "") . "/726087-%E0%B8%82%E0%B8%99%E0%B8%95%E0%B8%AD%E0%B8%99%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%81%E0%B8%A3%E0%B8%AD%E0%B8%81%E0%B8%84%E0%B8%9B%E0%B8%AD%E0%B8%87%E0%B9%83%E0%B8%AA%E0%B8%A5%E0%B8%94%E0%B9%83%E0%B8%99%E0%B8%A1%E0%B8%AD%E0%B8%96%E0%B8%AD?r=1": "#" ; ?>"
                           target="_blank">
                            <?php echo __("HowToPromotionCode"); ?>
                        </a>
                    </li>
                </ul>
            </div>
<!--            <div class="col-xs-12 text-center margin-top-20">-->
<!--                <a href="--><?php //echo URL::switchLang('en'); ?><!--">-->
<!--                    <img src="--><?php //echo Theme::asset()->usePath()->url('img/flag_us.png'); ?><!--" alt="English">-->
<!--                </a>-->
<!--                &nbsp;&nbsp;-->
<!--                <a href="--><?php //echo URL::switchLang('th'); ?><!--">-->
<!--                    <img src="--><?php //echo Theme::asset()->usePath()->url('img/flag_th.png'); ?><!--" alt="Thai">-->
<!--                </a>-->
<!--            </div>-->
            <?php
            //prepair url to desktop.
            $replacementPattern = Config::get("endpoints.mobilePrefixRegex");
            $webReplacement = Config::get("endpoints.webPrefix");
            $desktopUrl = preg_replace($replacementPattern, $webReplacement, URL::current());
            ?>
            <div class="col-xs-12 text-center margin-top-20"><a href="<?php echo $desktopUrl . '?desktop=1'; ?>">Desktop
                    Site</a></div>
            <div class="col-xs-12 text-center link-grey">Copyright Notice 2014 - itruemart.com</div>
        </div>
    </div>
</div>
</div>