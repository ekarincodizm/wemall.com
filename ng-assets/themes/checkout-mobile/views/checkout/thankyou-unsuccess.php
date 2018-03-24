<div class="row">
          <div class="col-sm-12 text-center chekout-info-complete">
                  <?php if (array_get($data, 'data.payment_status') === 'waiting' || array_get($data, 'data.payment_status') === 'failed') : ?>
                    <span class="main-text-info text-red-2">คุณทำรายการไม่สำเร็จ</span><br class="hidden-xs">
                    <a href="<?php echo URL::route('checkout.requery'); ?>?order_id=<?php echo array_get($data, 'data.order_id'); ?>" class="btn btn-primary re-checkout">
                        คลิกเพื่อทำรายการอีกครั้ง
                    </a>

                <?php elseif (array_get($data, 'data.payment_status') === 'cancel') : ?>
                    <span class="main-text-info text-red-2">คุณทำรายการไม่สำเร็จ</span><br class="hidden-xs">
                    <span class="sub-text-info hidden-xs"><span class="text-red-2"><?php echo __('Thank you'); ?></span><img class="logo" src="<?php echo Theme::asset()->usePath()->url('images/logo/logo_itruemart.png'); ?>" alt="" /></span>

                <?php elseif (array_get($data, 'data.payment_status') === 'expired'): ?>
                    <span class="main-text-info text-red-2">รายการนี้หมดอายุแล้ว</span><br class="hidden-xs">
                    <span class="sub-text-info hidden-xs"><span class="text-red-2"><?php echo __('Thank you'); ?></span><img class="logo" src="<?php echo Theme::asset()->usePath()->url('images/logo/logo_itruemart.png'); ?>" alt="" /></span>
                <?php endif; ?>
                </div>
</div>