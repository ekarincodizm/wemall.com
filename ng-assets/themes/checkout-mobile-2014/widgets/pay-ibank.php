<div class="payment-channel">
    <input type="radio" name="payment_channel" value="ibanking" id="ibanking"/>
    <label for="ibanking">
        <img src="<?php echo Theme::asset()->usePath()->url("img/ico-ibanking.png"); ?>" class="ico_payment_channel"/>
        <span class="payment-name">[จ่ายเต็ม] ไอแบงก์กิ้ง<br/><small>Internet Banking</small></span>
    </label>

    <div class="divider-menu" id="box-ibanking">
        <div class="add-remark">
            <h3>ชำระเงินผ่าน iBanking ของธนาคาร </h3>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#ib-kbank-tab" role="tab" data-toggle="tab"><img
                            src="<?php echo Theme::asset()->usePath()->url("img/icon_kbank.png"); ?>" alt="kasikorn bank" /><br>กสิกรไทย</a></li>
                <li><a href="#ib-scb-tab" role="tab" data-toggle="tab"><img src="<?php echo Theme::asset()->usePath()->url("img/icon_scb.png"); ?>" alt="scb bank" /><br>ไทยพาณิชย์</a>
                </li>
                <li><a href="#ib-bkkb-tab" role="tab" data-toggle="tab"><img src="<?php echo Theme::asset()->usePath()->url("img/icon_bkkb.png"); ?>" alt="bangkok bank" /><br>กรุงเทพ</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="ib-kbank-tab">
                    <ol>
                        <li>เข้าไปที่เว็บไซด์ www.kasikornbank.com</li>
                        <li>เลือกบริการออนไลน์ที่ต้องการเป็น K Cyber-Banking</li>
                        <li>Login เข้าสู่ระบบโดยใช้ username และ password ที่ได้รับจากทางธนาคาร</li>
                        <li>เลือก "ชำระค่าสินค้าและบริการ" แล้วเลือก "แบบฟอร์มการชำระเงิน"</li>
                        <li>กดปุ่ม "สร้างแบบฟอร์มการชำระเงิน"</li>
                        <li>ในขั้นตอนที่ 1 เลือกประเภทบริการเป็น "อินเตอร์เน็ต"</li>
                        <li>ในช่อง "บริษัท" เลือกชื่อบริษัทเป็น "ทีเพย์ - weloveshopping"</li>
                        <li>เลือก "จากบัญชี เป็นเลขที่บัญชีที่สมัครกับทางธนาคาร</li>
                        <li>กดปุ่ม "ชำระเงิน"</li>
                        <li>ตรวจสอบรายการที่ชำระอีกครั้งพร้อมกด "ยืนยัน"</li>
                        <li>กดปุ่ม "พิมพ์" เพื่อเป็นหลักฐานการชำระเงิน</li>
                    </ol>
                </div>
                <div class="tab-pane" id="ib-scb-tab">
                    <ol>
                        <li>Login เข้าสู่ระบบโดยใช้ username และ password ที่ได้รับจากทางธนาคาร</li>
                        <li>เลือก "ชำระค่าสินค้าและบริการ" แล้วเลือก "แบบฟอร์มการชำระเงิน"</li>
                        <li>กดปุ่ม "สร้างแบบฟอร์มการชำระเงิน"</li>
                        <li>ตรวจสอบรายการที่ชำระอีกครั้งพร้อมกด "ยืนยัน"</li>
                        <li>กดปุ่ม "พิมพ์" เพื่อเป็นหลักฐานการชำระเงิน</li>
                        <li>ในขั้นตอนที่ 1 เลือกประเภทบริการเป็น "อินเตอร์เน็ต"</li>
                        <li>ในช่อง "บริษัท" เลือกชื่อบริษัทเป็น "ทีเพย์ - weloveshopping"</li>
                        <li>เลือก "จากบัญชี เป็นเลขที่บัญชีที่สมัครกับทางธนาคาร</li>
                        <li>กดปุ่ม "ชำระเงิน"</li>
                        <li>เข้าไปที่เว็บไซด์ www.kasikornbank.com</li>
                        <li>เลือกบริการออนไลน์ที่ต้องการเป็น K Cyber-Banking</li>
                    </ol>
                </div>
                <div class="tab-pane" id="ib-bkkb-tab">
                    <ol>
                        <li>ในขั้นตอนที่ 1 เลือกประเภทบริการเป็น "อินเตอร์เน็ต"</li>
                        <li>ในช่อง "บริษัท" เลือกชื่อบริษัทเป็น "ทีเพย์ - weloveshopping"</li>
                        <li>เลือก "จากบัญชี เป็นเลขที่บัญชีที่สมัครกับทางธนาคาร</li>
                        <li>กดปุ่ม "ชำระเงิน"</li>
                        <li>เข้าไปที่เว็บไซด์ www.kasikornbank.com</li>
                        <li>เลือกบริการออนไลน์ที่ต้องการเป็น K Cyber-Banking</li>
                        <li>Login เข้าสู่ระบบโดยใช้ username และ password ที่ได้รับจากทางธนาคาร</li>
                        <li>เลือก "ชำระค่าสินค้าและบริการ" แล้วเลือก "แบบฟอร์มการชำระเงิน"</li>
                        <li>กดปุ่ม "สร้างแบบฟอร์มการชำระเงิน"</li>
                        <li>ตรวจสอบรายการที่ชำระอีกครั้งพร้อมกด "ยืนยัน"</li>
                        <li>กดปุ่ม "พิมพ์" เพื่อเป็นหลักฐานการชำระเงิน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>