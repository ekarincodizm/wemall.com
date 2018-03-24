<div class="content-home checkout">
    <div id="wrapper_content">
        <!-- Start Content -->
        <div class="row">
            <div class="col-sm-12 payment-title"></div>
        </div>
        <div class="row tab-navi hidden-xs" style="background-color: #CCDB64; padding-left: 20px;">
            <div class="col-sm-6 text-left">
                <strong>ยืนยันการลงทะเบียน</strong>
            </div>
        </div>
        <div class="row">
            <?php if ($success == true): ?>
            <div class="col-sm-12 text-center chekout-info-complete">
                <p></p> 
                <span class="main-text-info text-red-2">ยืนยันการลงทะเบียนเรียบร้อยแล้วค่ะ</span><br class="hidden-xs">
            </div>
            <?php else: ?>
            <div class="col-sm-12 text-center chekout-info-complete" style="background-position: center bottom; min-height: 130px;">
                <p></p>
                <span class="main-text-info text-red-2">ไม่สามารถยืนยันการลงทะเบียนได้</span><br class="hidden-xs">
                <a href="<?php echo URL::route('member.resendEmailActivate', array('email' => $email)) ?>" class="btn btn-primary re-checkout">คลิกที่นี่เพื่อส่งอีเมลอีกครั้ง</a>
            </div>
            <?php endif ?>
        </div>
    </div>
</div>
<?php

Theme::asset()->usePath()->add('css-checkout', 'css/itruemart.checkout.css');
Theme::asset()->usePath()->add('css-checkout-resp', 'css/itruemart.checkout.resp.css');

?>