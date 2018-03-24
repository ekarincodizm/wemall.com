<div class="payment-channel">
    <input type="radio" name="payment_channel" value="cod" id="cod"/>
    <label for="cod">
        <img src="<?php echo Theme::asset()->usePath()->url("img/ico-cod.png"); ?>" class="ico_payment_channel" alt="cash on delivery"/>
        <span class="payment-name">[จ่ายเต็ม] เก็บเงินปลายทาง<br/><small>Cash on Delivery</small></span>
    </label>

    <div class="divider-menu" id="box-cod">
        <!-- Duplicate this div-class to apply another warning message box kub -->
        <div class="warning-message-box">
            <img src="<?php echo Theme::asset()->usePath()->url("img/icon_error.png"); ?>" alt="warning icon">

            <p>มีสินค้าในตะกร้าที่ไม่สามารถชำระแบบ ”เก็บเงินปลายทาง” ได้</p>

            <p>กรุณาเลือกช่องทางการชำระเงินอื่น หรือหากคุณต้องการชำระด้วยวิธีนี้</p>

            <p>กรุณาลบสินค้าที่ไม่สามารถชำระได้ออกก่อนค่ะ</p>
            <a href="javascript:void(0);" class="blue-link show-manageitempayment-btn">ลบสินค้าในตะกร้า <span
                    style="text-decoration: underline;">กดที่นี่</span></a>
        </div>
        <div class="add-remark">
            <h3>คุณสามารถชำระเงินสดให้กับพนักงานจัดส่งสินค้าของเราเมื่อคุณได้รับสินค้าที่บ้าน</h3>
            <ol>
                <li>พนักงานโทรนัดเวลา จัดส่งสินค้า</li>
                <li>เมื่อสินค้าถึงบ้านตรวจสอบสินค้าให้เรียบร้อย</li>
                <li>ลงลายมือชื่อเพื่อตอบรับสินค้า</li>
                <li>ชำระเงินกับพนักงานส่งสินค้า</li>
            </ol>
        </div>
    </div>
</div>