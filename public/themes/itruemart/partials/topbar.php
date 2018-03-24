<!-- <div class="topbar">
    <img src="http://cdn.itruemart.com/files/banner/1/5.jpg" alt=""/>
</div>
 -->
<!-- /.topbar -->

<div class="loginbar no_print">
    <div class="login-container">
        <span>
            WORLD ONLINE SHOPPING CENTER
        </span>
        <div class="login-panel">
            <div class="input-group list-select">
                <span><?php echo __('currency'); ?></span>
                <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">PHP <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="#">PHP</a></li>
                  <!--   <li><a href="#">HKD</a></li>
                    <li><a href="#">JYP</a></li>
 -->                </ul>
            </div>
            <div class="input-group list-select">
                <span><?php echo __('language'); ?></span>
                <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
                <img src="/themes/itruemart/assets/images/icn/flag/<?php echo App::getLocale(); ?>.jpg"/> <?php echo Str::upper(App::getLocale()); ?> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo URL::switchLang('th'); ?>"><img src="/themes/itruemart/assets/images/icn/flag/th.jpg" alt="TH"/> TH</a></li>
                    <li><a href="<?php echo URL::switchLang('en'); ?>"><img src="/themes/itruemart/assets/images/icn/flag/en.jpg" alt="EN"/> EN</a></li>
                </ul>
            </div>
            <div class="form-inline dropdown" id="login">

                <?php // if (ACL::isLoggedIn() == true) : $user = ACL::getUser(); ?>

                <div class="auth-loggedin" style="display: none;">
                    <a href="<?php echo URL::toLang('member/profile'); ?>" class="auth-display_name">
                        <img src="http://image.platform.truelife.com/{ssoid}/avatar?key=1&amp;w=27&amp;h27" class="avatar" alt=""/>{display_name}
                    </a>
                    / <a href="<?php echo URL::to("auth/logout"); ?>"><?php echo __('logout'); ?></a>
                    </div>
                <?php // else : ?>
                <div class="auth-not-loggedin" style="display: none;">
                    <a href="<?php echo URL::to("auth/login"). '?continue='. (URL::current()==URL::to("auth/login")?URL::to('/'):URL::current()); ?>"><?php echo __('login'); ?></a>
                    / <a href="<?php echo URL::to('users/register'); ?>"><?php echo __('register'); ?></a>
                </div>
                <?php // endif; ?>
                
            </div>
        </div>
    </div>
</div><!-- /.loginbar -->

<?php 

Theme::asset()->container('footer')->writeScript('auth-ajax', "
$(function() {
    $.ajax({
        async: true,
        type : 'GET',
        url : '/users/ajax-get-user',
        data : {},
        success: function(r) {

            if (r.group == 'guest')
            {
                $('.auth-not-loggedin').show();
            }
            else
            {
                var html = $('.auth-loggedin').html()
                            .replace('{ssoid}', r.ssoId)
                            .replace('{display_name}', r.display_name);

                $('.auth-loggedin').html(html);

                $('.auth-loggedin').show();
            }

        }
    });

});

", array('jquery'));

?>