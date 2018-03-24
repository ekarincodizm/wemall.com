<div class="payment-channel">
    <input type="radio" name="payment_channel" value="bank-counter" id="bank-counter"/>
    <label for="bank-counter">
        <img src="<?php echo Theme::asset()->usePath()->url("img/ico-counterbank.png"); ?>" class="ico_payment_channel" alt="bank counter"/>
        <span class="payment-name">Bank Counter</span>
    </label>

    <div class="divider-menu" id="box-bank-counter">
        <div class="add-remark">
            <h3>ชำระเงินผ่านเคาน์เตอร์ธนาคาร</h3>
            <img height="55px" src="<?php echo Theme::asset()->usePath()->url("img/bank_banner.png"); ?>" alt="bank"/>

            <p>
                สามารถชำระเงินค่าสินค้าโดยการดาวน์โหลดและพิมพ์แบบฟอร์มชำระเงินตามที่ปรากฎในหน้าสรุปรายการสั่งซื้อหรืออีเมล์ของคุณ
                แล้วนำไปชำระเงินผ่าน ธนาคารไทยพาณิชย์ ธนาคารกรุงเทพ หรือ ธนาคารกสิกรไทยทุกสาขาทั่วประเทศ
                โดยธนาคารจะขอเรียกเก็บค่าธรรมเนียมการชำระเงิน<span class="red">*</span> จากคุณ</p>

            <p><span class="red">*</span> อัตราค่าธรรมเนียมขึ้นอยู่กับแต่ละธนาคาร (20-40 บาท) </p>
        </div>
    </div>
</div>