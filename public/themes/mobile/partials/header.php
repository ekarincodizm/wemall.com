<?php
if (Request::is('/') || Request::path() === 'en') {
    ?>
    <div class="page_main_subject">
        <h1 class="h1_home"><?php echo __('seo_h1_home'); ?></h1>
    </div>
    <?php
}
?>
<div class="itm">
    <div class="row header-section">
        <div class="col-xs-6 ui-logo" id="logo">
            <a href="<?php echo URL::toLang('/', array(), false); ?>"><img
                    src="<?php echo URL::to(Theme::asset()->url('img/logo_ph.png?q=102014')); ?>"
                    alt="<?php echo __('seo_title_home'); ?>"></a>

        </div>
        <div class="col-xs-6">
            <div class="actionContainer">
<!--                --><?php
//                if (App::getLocale() == 'en') {
//                    $url_lang = URL::switchLang('th');
//                    $label = 'TH';
//                } else {
//                    $url_lang = URL::switchLang('en');
//                    $label = 'EN';
//                }
//                ?>
<!--                <a href='--><?php //echo $url_lang ?><!--' class="iconLanguage" data-id="switch-language-icon">-->
<!--                    <span>-->
<!--                        --><?php ////echo $label ?>
<!--                    </span>-->
<!--                </a>-->
                <a href="#" class="iconOrderStatus" data-id="order-tracking-icon" data-user-detail="">
                    <img src="<?php echo URL::to(Theme::asset()->url('img/order-status.png')); ?>" alt=""/>
                </a>
                <?php if (!$showCartIcon): ?>
                    <div class="ajax-widget no-icon" data-method="get"
                         data-url="<?php echo URL::toLang('cart/mini-cart'); ?>"
                         data-done_trigger="doneGetMiniCart"></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
    /*if(Request::path() != 'auth/login' and Request::path() != 'users/register') {
        ?>
        <div id="userContainer" class="userContainer">
            <?php
            $user = ACL::getUser();
            if ($user['group'] == 'user') {
                ?>
                <span id="userName" data-toggle="modal" data-target="#userProfile"><?php echo __('hello'); ?>
                    , <?php echo $user['display_name']; ?></span>
            <?php
            } else {
                ?>
                <a href="<?php echo URL::toLang("auth/login") . '?continue=' . (URL::current() == URL::toLang("auth/login") ? URL::toLang('/') : URL::current()); ?>"
                   alt="login">
                    <?php echo __('login'); ?>
                </a>
            <?php
            }
            ?>
        </div>
    <?php
    }*/
    ?>
</div>
<?php $guest_url = URL::toLang('auth/login') . '?continue=' . URL::toLang('member/orders');
$user_url = URL::toLang('member/orders');
?>

<?php

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
                        var url_login = '" . $guest_url . "';
                    }
                    else {
                        var url_login = '" . $user_url . "';
                        var user_name = r.display_name;
                    }
                    $('.iconOrderStatus').attr('href',url_login);
                    $('.iconOrderStatus').attr('data-user-detail',user_name);
                }
            });
        });", array('jquery'));
?>

<?php
/*$user = ACL::getUser();
if($user['group'] == 'user'){
?>
<!-- Modal -->
<div id="userProfile" class="modal fade modalUserProfile in">
    <div class="modal-dialog" style="top: 253px;">
        <div class="modal-content">
            <div class="modal-header">
                <button data-dismiss="modal" aria-label="Close" type="button" class="close"><span>×</span></button>
                <h5 class="modal-title"></h5></div>
            <div class="modal-body"><p class="mainMessage"><?php echo __('you_are_logged_in'); ?> :  <br><?php echo $user['display_name']; ?></p>

                <p class="subMessage"><?php echo __('if_you_wanna_to_logout'); ?></p></div>
            <div class="modal-footer"><a data-dismiss="modal" aria-label="Close" class="btn btn-cancel"><?php echo __('cancel'); ?></a><a
                    href="<?php echo URL::toLang("auth/logout"); ?>" class="btn btn-logout"><?php echo __('confirm'); ?></a></div>
        </div>
    </div>
</div>
<?php
}*/
?>