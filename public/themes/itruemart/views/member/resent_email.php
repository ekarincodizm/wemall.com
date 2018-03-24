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
                <span class="main-text-info text-red-2">ระบบได้ส่งข้อมูลการยืนยันอีเมลไปที่ <?php echo $email ?> เรียบร้อยแล้วค่ะ</span><br class="hidden-xs">
            </div>
            <?php else: ?>
            <div class="col-sm-12 text-center chekout-info-complete" style="background-position: center bottom; min-height: 130px;">
                <p></p>
                <span class="main-text-info text-red-2">ไม่พบอีเมล <?php echo $email ?> ในระบบ</span><br class="hidden-xs">
            </div>
            <?php endif ?>
        </div>
    </div>
</div>
<?php

Theme::asset()->usePath()->add('css-checkout', 'css/itruemart.checkout.css');
Theme::asset()->usePath()->add('css-checkout-resp', 'css/itruemart.checkout.resp.css');

?>