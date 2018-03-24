<?php
if (Request::is('/') || Request::path()==='en')
{
?>
<div class="page_main_subject">
    <h1 class="h1_home"><?php echo __('seo_h1_home'); ?></h1>
</div>
<?php
}
?>

<div class="header__bg_login">
    <div class="header__inner_wrapper">
        <div class="header__bar_login">
            <div class="header__contact">
                <span><?php echo __('topbar_contact'); ?></span>
            </div>
            <div class="header__box_login">
                <div class="header__box_misc">
<!--                    <span style="display:none">--><?php ////echo __('language'); ?><!-- </span>-->
<!--                    <button class="dropdown-toggle" data-toggle="dropdown" id="language" style="display:none">-->
<!---->
<!--                        --><?php //if (App::getLocale() == 'en') : ?>
<!--                            <img src="--><?php //echo Theme::asset()->usePath()->url('images/icn/flag/en.jpg'); ?><!--" />-->
<!--                        --><?php //else: ?>
<!--                            <img src="--><?php //echo Theme::asset()->usePath()->url('images/icn/flag/th.jpg'); ?><!--" />-->
<!--                        --><?php //endif; ?>
<!---->
<!--                        <span class="caret"></span>-->
<!--                    </button>-->
                    <ul class="dropdown-menu" role="menu" aria-labelledby="language">
                        <li>
                            <a href="<?php echo URL::switchLang('th'); ?>">
                                <img src="<?php echo Theme::asset()->usePath()->url('images/icn/flag/th.jpg'); ?>" />
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo URL::switchLang('en'); ?>">
                                <img src="<?php echo Theme::asset()->usePath()->url('images/icn/flag/en.jpg'); ?>" />
                            </a>
                        </li>
                    </ul>
                </div>

                <?php //$user = ACL::getUser(); ?>
                <?php //if ($user['group'] == "user") : ?>
                <!-- User -->
                <div class="header__box_misc auth-loggedin" style="display: none;">
                    <a href="#" id="user" class="dropdown-toggle" data-toggle="dropdown"><?php echo '{display_name}';//isset($user['display_name']) ? $user['display_name'] : '{display_name}'; ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="user">
                        <li><a href="<?php echo URL::toLang('member/profile'); ?>"><?php echo __('My Profile'); ?></a></li>
                        <li><a href="<?php echo URL::toLang('member/orders'); ?>"><?php echo __('Check my order'); ?></a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo url('auth/logout'); ?>"><?php echo __('logout'); ?></a></li>
                    </ul>
                </div>

                <!-- /User -->
                <?php // else : ?>
                <!-- Login -->
                <div class="header__box_misc auth-not-loggedin" style="display: none;">
                    <a href="<?php echo URL::toLang('users/register'); ?>" alt="register" >
                        <?php echo __('register_true_id'); ?>
                    </a>
                </div>
                <div class="header__box_misc auth-not-loggedin" style="display: none;">
                    <a href="<?php echo URL::toLang("auth/login") . '?continue=' . (URL::current() == URL::toLang("auth/login") ? URL::toLang('/') : URL::current()); ?>" alt="login" >
                        <?php echo __('login'); ?>
                    </a>
                </div>

                <!-- /Login -->
                <?php //endif; ?>
                <?php
                /*
                 * users/ajax-get-user
                */
                Theme::asset()->container('footer')->writeScript('auth-ajax', "
                    $(function() {
                        $.ajax({
                            async: true,
                            type : 'GET',
                            url : '/users/ajax-get-user',
                            data : {},
                            success: function(r) {
                                $(document).trigger('criteo-load', [ r ]);
                                if (r.group == 'guest') {
                                    $('.auth-not-loggedin').show();
                                }
                                else {
                                    var html = $('.auth-loggedin').html().replace('{display_name}', r.display_name);
                                    $('.auth-loggedin').html(html);
                                    $('.auth-loggedin').show();
                                }
                            }
                        });
                    });", array('jquery'));
                ?>
            </div>
        </div>
    </div>
</div>

<div class="header__bg_search">
    <div class="header__inner_wrapper">
        <div class="header__bar_search">
            <div class="header__logo">
                <a href="<?php echo URL::toLang(''); ?>" title="iTruemart" >
                    <img src="<?php echo Theme::asset()->usePath()->url('images/logo/Logo_itm_PH.png?q=102014'); ?>" />
                </a>
            </div>

            <?php /* Widget Search */ ?>
            <?php echo Theme::widget('search')->render(); ?>

            <?php echo Theme::widget('minicartSuperDeal', array())->render(); ?>

        </div>
    </div>
</div>
