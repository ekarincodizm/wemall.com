<?php foreach ($product['variants'] as $key => $variant) { ?>
    <?php if (!empty($variant['active_trueyou_discount'])) { ?>
        <?php if ($key > 0) {
            break;
        } ?>
        <div class="trueyou_container">
            <p><?php echo __("leveld-truecard-register"); ?></p>
            <ul class="trueyou_validate" id="trueyou-<?php echo $variant['inventory_id'] ?>" >
        <?php if (!empty($variant['active_trueyou_discount']['black'])) { ?>
            <?php $black = $variant['active_trueyou_discount']['black']; ?>
                    <li>
                        <img src="<?php echo Theme::asset()->usePath()->url('images/icn/black_card.png'); ?>" />
                        <p><?php echo __("leveld-truecard-more-discount"); ?><br/>
                            <?php if ($black['discount_type'] == 'percent') { ?>
                                <span><?php echo $black['discount'] ?>%</span>
                            <?php } else { ?>
                                <span><?php echo $black['discount'] ?> <?php echo __("Baht"); ?></span>
                    <?php } ?>
                        </p>
                    </li>
                <?php } ?>
        <?php if (!empty($variant['active_trueyou_discount']['red'])) { ?>
            <?php $red = $variant['active_trueyou_discount']['red']; ?>
                    <li>
                        <img src="<?php echo Theme::asset()->usePath()->url('images/icn/red_card.png'); ?>" />
                        <p><?php echo __("leveld-truecard-more-discount"); ?><br/>
                            <?php if ($red['discount_type'] == 'percent') { ?>
                                <span><?php echo $red['discount'] ?>%</span>
                            <?php } else { ?>
                                <span><?php echo $red['discount'] ?> <?php echo __("Baht"); ?></span>
                    <?php } ?>
                        </p>
                    </li>
                <?php } ?>

                <?php
                $check_privilege = true;
                if (ACL::isLoggedIn() == false) {
                    $check_privilege = false;
                }
                if (!empty($user['trueyou'])) {
                    $check_privilege = false;
                }
                ?>
        <?php if ($check_privilege == true): ?>
                    <li>
                        <button class="btn_trueyou_valid" data-url="<?php echo URL::toLang('member/profile'); ?>">
                            <?php echo __("leveld-truecard-check-privillege"); ?>
                        </button>
                    </li>
        <?php endif; ?>
            </ul>
        </div>
    <?php } ?>
<?php } ?>