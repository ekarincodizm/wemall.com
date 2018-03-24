<div id="checkout_menu">
    <!--start checkout_menu-->
    <div class="bigheadline"><b><?php echo __("member-profile-myprofile"); ?></b></div>
    <div class="bottom_line"></div>
    <div class="g_info"><div class="headline"></div></div>
    <div class="welcome"><b><?php echo __("member-profile-welcome"); ?></b><br>
        <?php echo $user['display_name']; ?>
    </div>
    <div id="cardtype">
        <?php if ( isset($card) ) : ?>
            <img src="<?php echo Theme::asset()->url('images/true' . $card . 'card.jpg'); ?>" class="middle img_card_type">
            <?php echo ucfirst($card); ?> Card Previlage
        <?php endif; ?>
    </div>
    <div class="topic headline"><?php echo __("member-profile-last-log-in"); ?> : </div>

    <div>
        <?php
            echo (!empty($lastlogin))? $lastlogin : "";
        ?>
    </div>


    <div class="liststep">
        <!--start liststep-->
        <div class="bottom_line"></div>
        <div id="ic_checkout_here" <?php if ( preg_match('/member\/profile/i', Request::server("REQUEST_URI")) )
        {
            echo "class='active'";
        } ?>>
            <div class="headline_light">
                <a href="<?php echo URL::toLang('member/profile'); ?>" title="<?php echo __("member-profile-myprofile-1"); ?>"><?php echo __("member-profile-myprofile-1"); ?></a>
            </div>
        </div>

        <div class="bottom_line"></div>
        <div id="ic_checkout_here" <?php if ( preg_match('/checkout\/step1/i', Request::server("REQUEST_URI")) )
        {
            echo "class='active'";
        } ?>>
            <div class="headline_light">
                <a href="<?php echo URL::toLang('checkout/step1'); ?>" title="<?php echo __("member-profile-checkout-order"); ?>"><?php echo __("member-profile-checkout-order"); ?></a>
            </div>
        </div>
        <div class="bottom_line"></div>

        <div id="ic_ordertrack" <?php if ( preg_match('/member\/orders/i', Request::server("REQUEST_URI")) )
        {
            echo "class='active'";
        } ?>>
            <div class="headline_light">
                <a href="<?php echo URL::toLang('member/orders'); ?>" title="<?php echo __("member-profile-order-tracking"); ?>"><?php echo __("member-profile-order-tracking"); ?></a>
            </div>
        </div>
        <div class="bottom_line"></div>
		
		 <div id="ic_checkout_here" <?php if ( preg_match('/member\/lucky-privilege/i', Request::server("REQUEST_URI")) )
        {
            echo "class='active'";
        } ?>>
<!--            <div class="headline_light">-->
<!--                <a href="--><?php //echo URL::toLang('member/lucky-privilege'); ?><!--" title="รายการสิทธิพิเศษ">รายการสิทธิพิเศษ</a>-->
<!--            </div>-->
        </div>
		
        <div id="ic_creditcard" <?php if ( preg_match('/member\/manage-credit-card/i', Request::server("REQUEST_URI")) )
        {
            echo "class='active'";
        } ?>>
            <?php /*
            <div class="headline_light">
                <a href="<?php echo URL::toLang("member/manage-credit-card") ?>" title="<?php echo __("member-profile-manage-credit"); ?>"><?php echo __("member-profile-manage-credit"); ?></a>
            </div>
            */ ?>
        </div>
        <?php /*
        <div class="bottom_line"></div>
        */ ?>
    </div>

</div>