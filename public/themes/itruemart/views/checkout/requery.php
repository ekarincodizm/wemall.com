<div class="content-home checkout">
    <div id="wrapper_content">
        <!-- Start Content -->
        <div class="row">
            <div class="col-sm-12 payment-title"><?php echo __('Make Payment'); ?></div>
        </div>
        <div class="row tab-navi tab-navi-03 hidden-xs">
            <div class="col-sm-6 text-center">
                <strong>1. <?php echo __('Payment Status and Delivery'); ?></strong>
            </div>
            <div class="col-sm-6 text-center">
                <strong>2. <?php echo __('Confirm  order and payment'); ?></strong>
            </div>
        </div>
        <div class="row">

            <div class="col-sm-12 text-center chekout-info-complete">
                
                <?php if (array_get($data, 'data.payment_status') === 'waiting' || array_get($data, 'data.payment_status') === 'failed') : ?>
                <span class="main-text-info text-red-2">คุณทำรายการไม่สำเร็จ</span><br class="hidden-xs">
                <a href="<?php echo URL::route('checkout.requery');?>?order_id=<?php echo array_get($data,'data.order_id'); ?>" class="btn btn-primary re-checkout">คลิกเพื่อทำรายการอีกครั้ง</a>
                
                <?php elseif (array_get($data, 'data.payment_status') === 'cancel' ) : ?>
                <span class="main-text-info text-red-2">คุณทำรายการไม่สำเร็จ</span><br class="hidden-xs">
                <span class="sub-text-info hidden-xs"><span class="text-red-2"><?php echo __('Thank you');?></span> iTrueMart.com</span>

                <?php elseif (array_get($data, 'data.payment_status') === 'expired'): ?>
                <span class="main-text-info text-red-2">รายการนี้หมดอายุแล้ว</span><br class="hidden-xs">
                <span class="sub-text-info hidden-xs"><span class="text-red-2"><?php echo __('Thank you');?></span> iTrueMart.com</span>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>