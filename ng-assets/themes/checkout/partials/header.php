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
<div id="header">    
    <div class="sub-content <?php echo (!empty($step)) ? $step : "step"; ?>">
        <div class="logo left">
            <a href="<?php echo URL::toLang("/", array(), false); ?>"><img src="<?php echo Theme::asset()->usePath()->url('images/logo.png?q=102014'); ?>" width="215" /></a>
        </div>
<!--        <div class="right top-head-box">-->
<!--            <div class="right top-lang" >--><?php //echo __("header-language"); ?><!-- : -->
<!--                --><?php //if ( LANG == 'th' ) : ?>
<!--                    <a href="#" data-toggle="dropdown">-->
<!--                        <img src="--><?php //echo Theme::asset()->usePath()->url('images/th.png'); ?><!--" width="16" height="11" /> <span class="caret clr-4"></span>-->
<!--                    </a>-->
<!--                --><?php //else : ?>
<!--                    <a href="#" data-toggle="dropdown">-->
<!--                        <img src="--><?php //echo Theme::asset()->usePath()->url('images/en.jpg'); ?><!--" width="16" height="11" /><span class="caret clr-4"></span>-->
<!--                    </a>-->
<!--                --><?php //endif; ?>
<!--                --><?php
//                $isThankyou = preg_match("/thank-you/", Request::server('REQUEST_URI')) ? 'Y' : 'N';
//                if ( $isThankyou == 'Y' )
//                {
//                    if ( Request::server('QUERY_STRING') != "" )
//                    {
//                        $queryString = preg_replace("/\&thank=y/", "", Request::server('QUERY_STRING'));
//                        $redirectUrl = preg_replace("/^\/(en|th)/", "", Request::server('REDIRECT_URL')) . "?" . $queryString . "&thank=y";
//                    }
//                    else
//                    {
//                        $redirectUrl = preg_replace("/^\/(en|th)/", "", Request::server('REDIRECT_URL')) . "?thank=y";
//                    }
//                }
//                else
//                {
//                    if ( Request::server('QUERY_STRING') != "" )
//                    {
//                        $redirectUrl = preg_replace("/^\/(en|th)/", "", Request::server('REDIRECT_URL')) . "?" . Request::server('QUERY_STRING');
//                    }
//                    else
//                    {
//                        $redirectUrl = preg_replace("/^\/(en|th)/", "", Request::server('REDIRECT_URL'));
//                    }
//                }
//                ?>
<!--                <ul class="dropdown-menu" role="menu">-->
<!--                    <li><a href="--><?php //echo url($redirectUrl, array(), $open_https); ?><!--"><img src="--><?php //echo Theme::asset()->usePath()->url('images/th.png'); ?><!--" width="16" height="11" /></a></li>-->
<!--                    <li><a href="--><?php //echo url("en" . $redirectUrl, array(), $open_https); ?><!--"><img src="--><?php //echo Theme::asset()->usePath()->url('images/en.jpg'); ?><!--" width="16" height="11" /></a></li>-->
<!--                </ul>-->

<!--            </div>-->
            <div class="right top-lang">
                <?php echo __("header-currency"); ?> :<a href="#" data-toggle="dropdown" class="alert"> PHP <span class="caret clr-4"></span></a>
                <?php /**
                  <ul class="dropdown-menu" role="menu">
                  <li><a href="#">PHP</a></li>
                  <li><a href="#">USD</a></li>
                  </ul>
                 * */ ?>
            </div>
            <div class="clear"></div>
            <div class="on-profile">
                <div class="on-login">
                    <?php $user = ACL::getUser(); ?>
                    <?php if ( $user['group'] == "user" ) : ?>
                        <div class="pic-profile"></div>
                        <div class="name-profile">
                            <a href="#" data-toggle="dropdown"> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo URL::toLang('member/profile', array(), $open_https); ?>"><?php echo __('My Profile'); ?></a></li>
                                <li><a href="<?php echo URL::toLang('member/orders', array(), $open_https); ?>"><?php echo __('Check my order'); ?></a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo url('auth/logout', array(), $open_https); ?>"><?php echo __('logout'); ?></a></li>
                            </ul>
                        </div>
                    <?php else : ?>
                        <div class="name-profile">
                            GUEST
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="step-on">
            <ul>
                <li><a href="<?php echo URL::toLang('checkout/step1', array(), $open_https); ?>"><?php echo __('nav-step1'); ?></a></li>
                <li><a href="<?php echo URL::toLang('checkout/step2', array(), false); ?>"><?php echo __('nav-step2'); ?></a></li>
                <li><a href="<?php echo URL::toLang('checkout/step3', array(), $open_https); ?>"><?php echo __('nav-step3'); ?></a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
