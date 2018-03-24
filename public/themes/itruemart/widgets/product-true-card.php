<?php foreach ($product['variants'] as $variant) { ?>
    <?php if ( !empty($variant['active_trueyou_discount']) ) { ?>
        <div class="truecard-box container-trueyou" id="trueyou-<?php echo $variant['inventory_id'] ?>" <?php if ($product['has_variants'] == 1) { echo ' style="display:none;"'; } ?>>
            <div class="truecard-msg">
                สมาชิก True Card
                <?php if ( !empty($variant['active_trueyou_discount']['black']) ) { ?>
                    <?php $black = $variant['active_trueyou_discount']['black']; ?>
                    <img src="http://www.itruemart.com/assets/itruemart_new/global/images/icon_black-card.jpg">
                    รับส่วนลดเพิ่ม
                    <?php if ($black['discount_type'] == 'percent') { ?>
                        <span class="text-red"><?php echo $black['discount'] ?>%</span>
                    <?php } else { ?>
                        <span class="text-red"><?php echo $black['discount'] ?> บาท</span>
                    <?php } ?>
                <?php } ?>

                <?php if ( !empty($variant['active_trueyou_discount']['red']) ) { ?>
                    <?php $red = $variant['active_trueyou_discount']['red']; ?>
                    <img src="http://www.itruemart.com/assets/itruemart_new/global/images/icon_red-card.jpg">
                    รับส่วนลดเพิ่ม
                    <?php if ($red['discount_type'] == 'percent') { ?>
                        <span class="text-red"><?php echo $red['discount'] ?>%</span>
                    <?php } else { ?>
                        <span class="text-red"><?php echo $red['discount'] ?> บาท</span>
                    <?php } ?>
                <?php } ?>

            </div>
            <?php if (ACL::isLoggedIn() == true) : ?>
            <div>
                <p>คลิก <a href="<?php echo URL::to('member/profile'); ?>" style="text-decoration:underline">ตรวจสอบสิทธิ์</a> รับส่วนลดเพิ่ม</p>
            </div>
            <?php endif; ?>
        </div>
    <?php } ?>
<?php } ?>