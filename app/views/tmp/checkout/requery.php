<div class="content-home checkout">
    <div id="wrapper_content">
        <!-- Start Content -->
        <div class="row">
            <div class="col-sm-12 payment-title">สินค้ารอการชำระเงิน</div>
        </div>
        <div class="row tab-navi tab-navi-03 hidden-xs">
            <div class="col-sm-6 text-center">
                <strong>1. ตรวจสอบสินค้า และวิธีการจัดส่ง</strong>
            </div>
            <div class="col-sm-6 text-center">
                <strong>2. ยืนยันการสั่งซื้อ และชำระเงิน</strong>
            </div>
        </div>
        <div class="row">

            <div class="col-sm-12 text-center chekout-info-complete">
                
                <?php if (array_get($data, 'data.payment_status') === 'waiting' || array_get($data, 'data.payment_status') === 'failed') : ?>
                <span class="main-text-info text-red-2">คุณทำรายการไม่สำเร็จ</span><br class="hidden-xs">
                <a href="<?php echo URL::route('checkout.requery');?>?order_id=<?php echo array_get($data,'data.order_id'); ?>" class="btn btn-primary re-checkout">คลิกเพื่อทำรายการอีกครั้ง</a>
                
                <?php else if (array_get($data, 'data.payment_status') === 'cancel' || array_get($data, 'data.payment_status') === 'expired') : ?>
                <span class="main-text-info text-red-2">คุณทำรายการไม่สำเร็จ</span><br class="hidden-xs">
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>