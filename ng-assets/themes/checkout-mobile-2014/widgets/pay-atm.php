<div class="payment-channel">
    <input type="radio" name="payment_channel" value="atm" id="atm"/>
    <label for="atm">
        <img src="<?php echo Theme::asset()->usePath()->url("img/ico-atm.png"); ?>" class="ico_payment_channel"/>
        <span class="payment-name">[จ่ายเต็ม] ตู้เอทีเอ็ม<br/><small>ATM</small></span>
    </label>

    <div class="divider-menu" id="box-atm">
        <div class="add-remark">
            <h3>ชำระเงินผ่านตู้เอทีเอ็มของธนาคาร</h3>
            <img height="55px" src="<?php echo Theme::asset()->usePath()->url("img/bank_banner.png"); ?>" alt="kasikorn bank"/>

            <p>สามารถชำระเงินค่าสินค้าผ่านตู้เอทีเอ็มของ ธนาคารไทยพาณิชย์ ธนาคารกรุงเทพ หรือ ธนาคารกสิกรไทย
                ทุกสาขาทั่วประเทศ ตลอด 24 ชั่วโมง โดยธนาคารจะขอเรียกเก็บค่าธรรมเนียมการชำระเงิน<span
                    class="red">*</span> จากคุณ</p>

            <p><span class="red">*</span> อัตราค่าธรรมเนียมขึ้นอยู่กับแต่ละธนาคาร (20-40 บาท)</p>
        </div>
    </div>
</div>