<!-- Register -->
<div id="popup-regis" class="box-popup-regis modal fade" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="title">
        <div class="left">
            <h1>สร้างบัญชีฟรีเพื่อจัดการสินค้า</h1>
        </div>
        <div class="right"><img class="close-modal" src="<?php echo Theme::asset()->usePath()->url('/images/close.png'); ?>" width="27" height="27" /></div>
        <div class="clear"></div>
    </div>
    <div class="in-form">
        <div class="regis-pop">

            <ul>
                <li class="regis-bullet">ติดตามการสั่งซื้อสินค้าได้ตลอดเวลา</li>
                <li class="regis-bullet">สามารถสั่งซื้อได้เร็วขึ้น</li>
                <li class="regis-bullet">รับโปรโมชั่นสุดพิเศษจาก iTruemart.com</li>
            </ul>
            <div class="regis-title"><h1>สมัครง่ายๆเพียงเพิ่มรหัสผ่าน</h1></div>
            <div class="regis-id">
                <h3>ทรูไอดีของคุณคือ <span class="clr-7"><?php echo (!empty($email))? $email : ""; ?></span></h3>
            </div>
            <div class="regis-form-control"><input class="input-box active-success text-center" maxlength="15" name="email" type="password" placeholder="รหัสผ่านของคุณ" ></div>
            <div class="clear"></div>
            <div class="clear"></div>
            <div class="clear"></div>
            <div class="clear"></div>
            <div class="regis-box-control">
                <input class="form-bot" name="" type="button" value="สมัคร" />
            </div>

        </div>

    </div>
    <div class="box-footer regis-btm">
        <p>ไม่สมัครขอบคุณ</p>
        <div class="clear"></div>
    </div>

    <div class="clear"></div>

</div>
<!-- /Register -->