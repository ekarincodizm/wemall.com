<?php //dd($data); ?>
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
                <span class="main-text-info text-red-2">คุณทำรายการเสร็จสมบูรณ์</span><br class="hidden-xs">
                <span class="sub-text-info hidden-xs"><span class="text-red-2">ขอบคุณที่ใช้บริการ</span> iTrueMart.com</span>
            </div>

        </div>

        <div class="row">
            <!-- Start Menu Right -->
            <div class="col-xs-12 col-sm-3 col-sm-push-9">
                <div class="text-center menu-right">
                    <div class="box-submit hidden-xs">
                        <input type="button" value="ช้อปปิ้งต่อ" class="btn btn-continue" onclick="window.location.href = 'http://<?php echo Request::server ("SERVER_NAME"); ?>/';">
                    </div>
                    <p class="text-left payment-header">
                        <strong>คุณชำระเงินผ่านทาง</strong>
                    </p>
                    <div class="well total-price total-price-complete">

                        <?php if(array_get($data,'data.payment_method_code') === 'atm'): ?>
                        <div class="row">
                            <div class="col-xs-3 col-sm-5 text-center">
                                <img src="<?php echo Theme::asset()->url('images/icon-bank-atm.jpg'); ?>">
                            </div>
                            <div class="col-xs-9 col-sm-7 text-left">
                                <?php echo array_get($data, 'data.payment_method_name'); ?>
                            </div>
                        </div>

                        <?php elseif(array_get($data,'data.payment_method_code') === 'cod'): ?>
                        <div class="row">
                            <div class="col-xs-3 col-sm-5 text-center">
                                <img src="<?php echo Theme::asset()->url('images/icn/channel/icon-cod.png');?>">
                            </div>
                            <div class="col-xs-9 col-sm-7 text-left">
                                <?php echo array_get($data, 'data.payment_method_name'); ?>
                            </div>
                        </div>

                        <?php elseif(array_get($data,'data.payment_method_code') === 'banktrans'): ?>
                        <div class="row">
                            <div class="col-xs-3 col-sm-5 text-center">
                                <img src="<?php echo Theme::asset()->url('images/icn/channel/icon-payment-counter.jpg');?>">
                            </div>
                            <div class="col-xs-9 col-sm-7 text-left">
                                <?php echo array_get($data, 'data.payment_method_name'); ?>
                            </div>
                        </div>

                        <?php elseif(array_get($data,'data.payment_method_code') === 'cs'): ?>

                        <div class="row">
                            <div class="col-xs-3 col-sm-5 text-center">
                                <img src="<?php echo Theme::asset()->url('images/icn/channel/icon-counter-service.jpg');?>">
                            </div>
                            <div class="col-xs-9 col-sm-7 text-left">
                                <?php echo array_get($data, 'data.payment_method_name'); ?>
                            </div>
                        </div>

                        <?php elseif(array_get($data,'data.payment_method_code') === 'ibank'): ?>
                        <div class="row">
                            <div class="col-xs-3 col-sm-5 text-center">
                                <img src="<?php echo Theme::asset()->url('images/icn/channel/icon-ibanking.jpg');?>">
                            </div>
                            <div class="col-xs-9 col-sm-7 text-left">
                                <?php echo array_get($data, 'data.payment_method_name'); ?>
                            </div>
                        </div>

                        <?php elseif(array_get($data,'data.payment_method_code') === 'ccinstm'): ?>
                        <div class="row">
                            <div class="col-xs-3 col-sm-5 text-center">
                                <img src="<?php echo Theme::asset()->url('images/icn/channel/icon-instalment.png');?>">
                            </div>
                            <div class="col-xs-9 col-sm-7 text-left">
                                <?php echo array_get($data, 'data.payment_method_name'); ?>
                            </div>
                        </div>

                        <?php elseif(array_get($data,'data.payment_method_code') === 'ccw'): ?>
                        <div class="row">
                            <div class="col-xs-3 col-sm-5 text-center">
                                <img src="<?php echo Theme::asset()->url('images/icn/channel/icon-credit-card.png');?>">
                            </div>
                            <div class="col-xs-9 col-sm-7 text-left">
                                <?php echo array_get($data, 'data.payment_method_name'); ?>
                            </div>
                        </div>

                        <?php elseif(array_get($data,'data.payment_method_code') === 'ew'): ?>
                        <div class="row">
                            <div class="col-xs-3 col-sm-5 text-center">
                                <img src="<?php echo Theme::asset()->url('images/icn/channel/icon-ivr.png');?>">
                            </div>
                            <div class="col-xs-9 col-sm-7 text-left">
                                <?php echo array_get($data, 'data.payment_method_name'); ?>
                            </div>
                        </div>

                        <?php endif; ?>

                        <p class="divider"></p>
                        <div class="tag-price text-center">
                            เป็นจำนวนเงิน <strong><?php echo price_format(array_get($data, 'data.sub_total'),'PHP'); ?></strong>
                        </div>

                    </div>
                    <div class="row text-left status-container hidden-xs">
                        <div class="col-xs-6 col-sm-6 text-left status-text">สถานะ</div>
                        <div class="col-xs-6 col-sm-6 text-right status-name text-red-2">
                            <?php
                                if(array_get($data, 'data.payment_channel') === 'offline')
                                {
                                    if(array_get($data, 'data.payment_status') === 'reconcile')
                                    {
                                        echo __('payment-reconcile');
                                    }
                                    else
                                    {
                                        echo __('payment-waiting');
                                    }
                                }
                                else if(array_get($data, 'data.payment_channel') === 'online')
                                {
                                    if(array_get($data, 'data.payment_status') === 'reconcile')
                                    {
                                        echo __('payment-reconcile');
                                    }
                                    else
                                    {
                                        echo __('payment-success');
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Menu Right -->

            <div id="cart_detail" class="col-xs-12 visible-xs">
                <ul id="cart_steppayment" class="list-unstyled">
                    <li class="cart_actived">
                        <span class="step_no">1</span>
                        <span class="step_name">ตรวจสอบสินค้า<br>และวิธีการจัดส่ง</span>
                    </li>
                    <li class="cart_actived">
                        <span class="step_no">2</span>
                        <span class="step_name">ยืนยันการ<br>สั่งซื้อและชำระเงิน</span>
                    </li>
                </ul>
                <div class="clearfix"></div>

                <div class="chekout-info-mobile text-center">
                    <span class="thankyou-text"><span class="text-red-1">ขอบคุณที่ใช้บริการ</span><br>iTrueMart.com</span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-9 col-sm-pull-3 checkout-detail">
                <div class="col-sm-6">
                    <div class="order-detail">
                        <div class="well well-sm text-center">รายละเอียดการสั่งซื้อ</div>
                        <div class="col-sm-12">
                            <ul class="list-unstyled">
                                <li>No. Order : <?php echo array_get($data,'data.payment_order_id'); ?>(<?php echo array_get($data,'data.order_id'); ?>)</li>
                                <li>วันที่ <?php echo array_get($data, 'data.ordered_date.date'); ?></li>
                                <li>คุณ <?php echo array_get($data,'data.customer_name'); ?></li>

                                <?php if (array_get($data,'data.payment_method_code') !== 'cod'): ?>
                                <li><span class="text-red-2">Ref No.1 : </span><?php echo array_get($data,'data.ref1');?></li>
                                <li><span class="text-red-2">Ref No.2 : </span><?php echo array_get($data,'data.ref2');?></li>
                                <?php endif ?>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="addr-detail">
                        <div class="well well-sm text-center"><?php echo __('Shipping address');?></div>
                        <div class="col-sm-12">
                            <ul class="list-unstyled">
                                <li>คุณ <?php echo array_get($data,'data.customer_name');?></li>
                                <li>
                                    <?php echo array_get($data,'data.customer_address');?> 
                                    <?php echo array_get($data,'data.customer_district');?>
                                    <?php echo array_get($data,'data.customer_city');?>
                                    <?php echo array_get($data,'data.customer_province');?> 
                                    <?php echo array_get($data,'data.customer_postcode');?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <!-- Start Comment -->

            <!-- ATM -->
            <?php if(array_get($data,'data.payment_method_code') === 'atm'): ?>
            <div class="col-sm-12">
                <span class="payment-remark">หมายเหตุสำหรับท่านที่ชำระเงินทาง ATM</span>
                <div class="panel payment-remark-desc text-red-1">
                    <div class="panel-body">
                        <p>ลูกค้าต้องชำระเงินภายในวันที่ <?php echo array_get($data,'data.order_expired.date');?> มิฉะนั้นลูกค้าอาจไม่ได้รับสินค้าตามการสั่งซื้อ</p>
                        <ul class="pm-rm-notice">
                            <li>
                                การชำระเงินผ่านตู้ ATM ในกรุงเทพฯและปริมณทล จะเสียค่าธรรมเนียมประมาณ 20-25 บาท 
                                <span style="color: red">*</span>
                            </li>
                            <li>
                                การชำระเงินผ่านตู้ ATM ต่างจังหวัด จะเสียค่าธรรมเนีมประมาณ 35-40 บาท 
                                <span style="color: red">*</span></li>
                            <li><span style="color: red">*</span>อัตราค่าธรรมเนียมขึ้นอยู่กับธนาคารที่รับชำระ</li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php elseif(array_get($data,'data.payment_method_code') === 'cod'): ?>

            <!-- COD -->
            <div class="col-sm-12">
                <span class="payment-remark">หมายเหตุสำหรับท่านที่ชำระเงินทาง COD</span>
                <div class="panel payment-remark-desc text-red-1">
                    <div class="panel-body">
                        <ul class="pm-rm-notice">
                            <li>พนักงานจัดส่งสินค้า จะทำการโทรนัดหมายวันเวลา พร้อมแจ้งยอดชำระสินค้าให้ท่านทราบ ก่อนทำการจัดส่งสินค้า</li>
                            <li>กรุณาเตรียมเงินสดให้พอดีกับค่าสินค้า และชำระกับพนักงานจัดส่งสินค้า เมื่อท่านได้รับสินค้าเรียบร้อยแล้ว</li>
                        </ul>
                        <p><span class="text-red-1">หมายเหตุ</span> ระยะเวลาในการจัดส่งสินค้าจะใช้เวลาจัดส่ง 1-3 วัน</p>
                    </div>
                </div>
            </div>
            <?php elseif(array_get($data,'data.payment_method_code') === 'banktrans'): ?>
            <!-- counter bank -->
            <div class="col-sm-12">
                <span class="payment-remark">หมายเหตุสำหรับท่านที่ชำระเงินทางเคาร์เตอร์ธนาคาร (Payment
                    Counter)</span>
                <div class="panel payment-remark-desc text-red-1">
                    <div class="panel-body">
                        <p>
                            ลูกค้าต้องชำระเงินภายในวันที่ <?php echo array_get($data,'data.order_expired.date');?> มิฉะนั้นลูกค้าอาจไม่ได้รับสินค้าตามการสั่งซื้อ</p>
                        <ul class="pm-rm-notice">
                            <li>การโอนเงินในกรุงเทพฯและปริมณทล จะเสียค่าธรรมเนียมประมาณ 20-25 บาท<span style="color: red">*</span></li>
                            <li>การโอนเงินต่างจังหวัด จะเสียค่าธรรมเนีมประมาณ 35-40 บาท <span style="color: red">
                                    *</span></li>
                            <li><span style="color: red">*</span>อัตราค่าธรรมเนียมขึ้นอยู่กับธนาคารที่รับชำระ</li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php elseif(array_get($data,'data.payment_method_code') === 'cs'): ?>
            <!-- counter service -->
            <div class="col-sm-12">
                <span class="payment-remark">หมายเหตุสำหรับท่านที่ชำระเงินทางเคาร์เตอร์เซอร์วิส (Counter
                    Service)</span>
                <div class="panel payment-remark-desc text-red-1">
                    <div class="panel-body">
                        <p>
                            ลูกค้าต้องชำระเงินภายในวันที่ <?php echo array_get($data,'data.order_expired.date');?> มิฉะนั้นลูกค้าอาจไม่ได้รับสินค้าตามการสั่งซื้อ</p>
                        <ul class="pm-rm-notice">
                            <li>การชำระสินค้าผ่าน เคาน์เตอร์เซอร์วิส ใบชำระเงินมีอายุ 4 วัน นับจากเวลาที่ทำรายการ
                                และควรชำระภายในวัน เวลาดังกล่าว ไม่เช่นนั้น รายการของท่านจะโดนยกเลิกโดยอัตโนมัติ<span style="color: red">*</span></li>
                            <li><span style="color: red">*</span>การชำระเงินผ่านเคาน์เตอร์เซอร์วิส มีค่าธรรมเนียมการชำระเงิน
                                15 บาท</li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php elseif(array_get($data,'data.payment_method_code') === 'ibank'): ?>
            <!-- i banking -->
            <div class="col-sm-12">
                <span class="payment-remark">หมายเหตุสำหรับท่านที่ชำระเงินทาง iBanking</span>
                <div class="panel payment-remark-desc text-red-1">
                    <div class="panel-body">
                        <p>
                            ลูกค้าต้องชำระเงินภายในวันที่ <?php echo array_get($data,'data.order_expired.date');?> มิฉะนั้นลูกค้าอาจไม่ได้รับสินค้าตามการสั่งซื้อ</p>
                        <ul class="pm-rm-notice">
                            <li>สามารถตรวจสอบวิธีการชำระผ่าน iBanking service ของธนาคารกสิกรไทย,ธนาคารไทยพาณิชย์
                                และธนาคารกรุงเทพ ได้จากหน้ายืนยันการสั่งซื้อและชำระเงิน</li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php elseif(array_get($data,'data.payment_method_code') === 'ccinstm'):?>
            <!-- installment -->
            <div class="col-sm-12">
                <span class="payment-remark">หมายเหตุสำหรับท่านที่ชำระเงินแบบผ่อนชำระ (Instalment)</span>
                <div class="panel payment-remark-desc text-red-1">
                    <div class="panel-body">
                        <ul class="pm-rm-notice">
                            <li>การผ่อนชำระ จะได้กับบัตรเครดิตที่เป็นธนาคารกสิกรไทยเท่านั้น</li>
                            <li>ค่าธรรมเนียม (Fee) และดอกเบี้ย (interest) จากการผ่อนชำระสินค้าทาง iTrueMart.com จะเป็นผู้รับผิดชอบค่าใช้จ่ายในส่วนนี้ให้กับท่าน</li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <!-- End Comment -->

            <div class="col-sm-12 text-right hidden-xs">
                <input type="button" onclick="javascript:window.print();" value="พิมพ์หน้านี้" class="btn btn-print">
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="row">

            <!-- ATM -->
            <?php if(array_get($data,'data.payment_method_code') === 'atm') : ?>
            <div class="col-sm-12">
                <ul class="nav nav-tabs how-to">
                    <li class="active">
                        <a href="#"><img src="<?php echo Theme::asset()->url('images/icon-kbank.png');?>" class="icon-bank">ธนาคากสิกรไทย</a>
                    </li>
                    <li>
                        <a href="#"><img src="<?php echo Theme::asset()->url('images/icn/channel/icon-scb.jpg');?>" class="icon-bank">ธนาคารไทยพาณิชย์</a>
                    </li>
                    <li>
                        <a href="#"><img src="<?php echo Theme::asset()->url('images/icn/channel/icon-bangkok.png');?>" class="icon-bank">ธนาคารกรุงเทพ</a>
                    </li>
                </ul>
                <div class="panel panel-body-no-top">
                    <div class="panel-body">
                        <div class="row">
                            <div id="kbank" class="how-to-desc" style="display: block">
                                <div class="col-sm-3 text-center">
                                    <img src="<?php echo Theme::asset()->url('images/logo_kbank.jpg');?>">
                                </div>
                                <div class="col-sm-9">
                                    <dl>
                                        <dt>ขั้นตอนการใช้งาน</dt>
                                        <dd>
                                            <ol>
                                                <li>สอดบัตร ATM ของธนาคารกสิกรไทยที่ตู้ ATM ธนาคารกสิกรไทย</li>
                                                <li>ใส่รหัสบัตร ATM 4 หลัก</li>
                                                <li>กดปุ่ม "ซื้อและชำระเงิน"</li>
                                                <li>กดปุ่ม "อื่นๆ/ระบุรหัสบริษัท"</li>
                                                <li>กดปุ่มเลือกชำระเงินจาก บัญชีออมทรัพย์ หรือ กระแสรายวัน</li>
                                                <li>ใส่รหัสบริษัท 5 หลัก หมายเลข "35002" แล้วกดปุ่ม "รหัสบริษัทถูกต้อง"</li>
                                                <li>กด หมายเลขอ้างอิง 1 (Customer No.) จำนวน 8 หลัก ตามที่ปรากฏในใบสรุปการสั่งซื่อ แล้วกดปุ่ม "หมายเลขถูกต้อง"</li>
                                                <li>กด หมายเลขอ้างอิง 2 (Ref No.2 ) จำนวน 12 หลักตามที่ปรากฏในใบสรุปการสั่งซื่อ แล้วกดปุ่ม "หมายเลขถูกต้อง"</li>
                                            </ol>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div id="scb" class="how-to-desc">
                                <div class="col-sm-3 text-center">
                                    <img src="<?php echo Theme::asset()->url('images/logo/logo_scb.jpg');?>">
                                </div>
                                <div class="col-sm-9">
                                    <dl>
                                        <dt>ขั้นตอนการใช้งาน</dt>
                                        <dd>
                                            <ol>
                                                <li>สอดบัตร ATM ของธนาคารไทยพาณิชย์ที่ตู้ ATM ธนาคารไทยพาณิชย์</li>
                                                <li>ใส่รหัสบัตร ATM 4 หลัก</li>
                                                <li>กดปุ่ม " อื่นๆ "</li>
                                                <li>เลือก "ชำระค่าสินค้า/บริการ"</li>
                                                <li>เลือก "ชำระเงินเข้าบริษัทอื่นๆ"</li>
                                                <li>เลือกชำระเงินจากบัญชีออมทรัพย์</li>
                                                <li>ใส่รหัสบริษัท (Comp Code) หมายเลข "0546" แล้วกดปุ่ม "ถูกต้อง"</li>
                                                <li>กดจำนวนเงินที่ต้องการชำระ</li>
                                                <li>กด หมายเลขอ้างอิง 1 (Customer No.) จำนวน 8 หลักตามที่ปรากฏในใบสรุปการสั่งซื้อ</li>
                                                <li>กด หมายเลขอ้างอิง 2 (Reference No.) จำนวน 12 หลักตามที่ปรากฏในใบสรุปการสั่งซื้อ</li>
                                                <li>ตรวจสอบความถูกต้องว่าเป็นบัญชีเป็นชื่อ บริษัท TRUE MONEY แล้วเลือก "ยืนยัน" เพื่อชำระค่า</li>
                                            </ol>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div id="bangkok" class="how-to-desc">
                                <div class="col-sm-3 text-center">
                                    <img src="<?php echo Theme::asset()->url('images/logo/logo_bangkok.jpg');?>">
                                </div>
                                <div class="col-sm-9">
                                    <dl>
                                        <dt>ขั้นตอนการใช้งาน</dt>
                                        <dd>
                                            <ol>
                                                <li>สอดบัตร ATM ของธนาคารกรุงเทพที่ตู้ ATM ธนาคารธนาคารกรุงเทพ พร้อมใส่รหัสบัตร 4 หลัก</li>
                                                <li>เลือก อื่นๆ &gt; ชำระเงินด้วย Comp Code &gt; บัญชีสะสมทรัพย์</li>
                                                <li>ใส่รหัสบริษัท (Comp Code) หมายเลข "60000" แล้วกดปุ่มถูกต้อง</li>
                                                <li>ใส่หมายเลขอ้างอิง 1 (Customer No.) จำนวน 8 หลัก และ หมายเลขอ้างอิง 2 (Reference
                                                    No.) จำนวน 12 หลักตามที่ปรากฎในใบสรุปการสั่งซื้อ</li>
                                                <li>กดจำนวนเงินที่ต้องการชำระ</li>
                                                <li>ตรวจสอบความถูกต้องว่าเป็นบัญชีชื่อบริษัท TRUE MONEY แล้วกด "ยืนยัน" เพื่อชำระค่าสินค้า</li>
                                                <li>รอรับสลิปไว้เป็นหลักฐาน</li>
                                            </ol>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
                    var msViewportStyle = document.createElement("style");
                    msViewportStyle.appendChild(document.createTextNode("@-ms-viewport{width:auto!important}"));
                    document.getElementsByTagName("head")[0].appendChild(msViewportStyle);
                }

            </script>
            
            <!-- COD -->

            <?php elseif(array_get($data,'data.payment_method_code') === 'banktrans'): ?>
            <!-- Counter Bank -->
            <div class="col-sm-12">
                <ul class="nav nav-tabs how-to">
                    <li class="active"><a href="javascript:;">การชำระเงินผ่านเคาร์เตอร์ธนาคาร</a></li>
                </ul>
                <div class="panel panel-body-no-top">
                    <div class="panel-body">
                        <div id="payment-counter">
                            <div class="row">
                                <div class="col-sm-3 text-center">
                                    <img src="<?php echo Theme::asset()->url('images/logo_kbank.jpg');?>">
                                    <img src="<?php echo Theme::asset()->url('images/logo_scb.jpg');?>">
                                    <img src="<?php echo Theme::asset()->url('images/logo_bangkok.jpg');?>">
                                </div>
                                <div class="col-sm-9">
                                    <p>
                                        <strong>ขั้นตอนการจ่ายเงินผ่านเคาร์เตอร์ของธนาคาร</strong></p>
                                    <p class="text-indent-30">
                                        ท่านสามารถทำการชำระเงินค่าสินค้าด้วยการดาวน์โหลด และพิมพ์แบบฟอร์มตามที่ปรากฏในหน้าสรุปรายการสั่งซื้อ
                                        แล้วนำไปชำระเงินผ่าน <strong>ธนาคารไทยพาณิชย์, ธนาคารกสิกรไทย, ธนาคารกรุงเทพ</strong>
                                        (ทุกสาขาทั่วประเทศ ธนาคารจะขอเรียกเก็บค่าธรรมเนียมการชำระเงินตรงจากท่าน)</p>
                                    <p class="hidden-xs">
                                        ดาวน์โหลด และพิมพ์แบบฟอร์มสำหรับชำระเงิน <a href="#">&gt;&gt; คลิกที่นี่ &lt;&lt;</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php elseif(array_get($data,'data.payment_method_code') === 'cs'): ?>
            <!-- Counter service -->
            <div class="col-sm-12">
                <ul class="nav nav-tabs how-to">
                    <li class="active"><a href="javascript:;">การชำระเงินผ่านเคาร์เตอร์เซอร์วิส</a></li>
                </ul>
                <div class="panel panel-body-no-top">
                    <div class="panel-body">
                        <div id="counter-service">
                            <div class="row">
                                <div class="col-sm-3 text-center">
                                    <img src="<?php echo Theme::asset()->url('images/logo_counter_service.jpg');?>">
                                </div>
                                <div class="col-sm-9">
                                    <p>
                                        <strong>ท่านสามารถชำระเงินผ่านทางเคาร์เตอร์เซอร์วิส ได้อย่างสะดวกตามขั้นตอนต่อไปนี้</strong></p>
                                    <ol>
                                        <li>พิมพ์หน้าชำระเงินที่มีรายการสรุปสินค้า ราคา และแถบบาร์โค้ด</li>
                                        <li>นำหน้าชำระเงินเสร์จสมบูร์ที่มีแถบบาร์โค้ดทางด้านล่าง ไปชำระเงินได้ที่เคาร์เตอร์เซอร์วิสทุกสาขา</li>
                                    </ol>
                                    <p>
                                        <strong>ท่านสามารถตรวจสอบสถานะสินค้าได้ที่</strong></p>
                                    <p class="text-indent-30">
                                        <a href="http://<?php echo Request::server ("SERVER_NAME"); ?>/member/order_tracking" target="_blank">http://<?php echo Request::server ("SERVER_NAME"); ?>/member/order_tracking</a></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-center barcode">
                                    <img src="<?php echo Theme::asset()->url('images/logo_7eleven.jpg');?>"><img src="<?php echo Theme::asset()->url('images/logo_counter_service.jpg');?>">
                                    <p>
                                        ชำระเงินที่ Counter Service ในร้าน 7-Eleven ทุกสาขาทั่วประเทศ (ไม่ต้องแจ้งผลการชำระเงิน)</p>
                                    <?php if (!empty(array_get($data,'data.barcode'))) : ?>
                                        <img src="<?php echo array_get($data,'data.barcode');?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php elseif(array_get($data,'data.payment_method_code') === 'ibank'): ?>
            <!-- i Banking -->
            <div class="col-sm-12">
                <ul class="nav nav-tabs how-to">
                    <li class="active"><a href="#"><img src="<?php echo Theme::asset()->url('images/icon-kbank.png');?>" class="icon-bank">ธนาคากสิกรไทย</a></li>
                    <li><a href="#"><img src="<?php echo Theme::asset()->url('images/icon-scb.jpg');?>" class="icon-bank"> ธนาคารไทยพาณิชย์</a></li>
                    <li><a href="#"><img src="<?php echo Theme::asset()->url('images/icon-bangkok.png');?>" class="icon-bank">ธนาคารกรุงเทพ</a></li>
                </ul>
                <div class="panel panel-body-no-top">
                    <div class="panel-body">
                        <div class="row">
                            <div id="kbank" class="how-to-desc" style="display: block">
                                <div class="col-sm-3 text-center">
                                    <img src="<?php echo Theme::asset()->url('images/logo_kbank.jpg');?>">
                                </div>
                                <div class="col-sm-9">
                                    <dl>
                                        <dt>ขั้นตอนการใช้งาน</dt>
                                        <dd>
                                            <ol>
                                                <li>เข้าไปที่เว็บไซต์ www.kasikornbank.com</li>
                                                <li>เลือกบริการออนไลน์ที่ต้องการเป็น "K Cyber-Banking"</li>
                                                <li>Login เข้าสู่ระบบโดยใช้ username และ password ที่ได้รับจากทางธนาคาร</li>
                                                <li>เลือก "ชำระค่าสินค้าและบริการ" แล้วเลือก "แบบฟอร์มการชำระเงิน"</li>
                                                <li>กดปุ่ม "สร้างแบบฟอร์มการชำระเงิน"</li>
                                                <li>ในขั้นตอนที่ 1 เลือกประเภทบริการเป็น "อินเทอร์เน็ต"</li>
                                                <li>ในช่อง "บริษัท " เลือกชื่อบริษัท เป็น "ทีเพย์ - weloveshopping"</li>
                                                <li>เลือก "จากบัญชี เป็นเลขที่บัญชีที่สมัครกับทางธนาคาร</li>
                                                <li>ใส่ "เลขที่อ้างอิง1 (Ref No.1)" และ"เลขที่อ้างอิง 2 (Ref No.2)" ตามที่ปรากฎในหน้าสรุปรายการสั่งซื้อ
                                                    และใส่ ยอดเงินค่าสินค้าลงใน ช่อง "จำนวนเงิน(บาท)"</li>
                                                <li>กดปุ่ม "ชำระเงิน" (ด้านล่าง)</li>
                                                <li>ตรวจสอบรายการที่ชำระอีกครั้ง พร้อมกด "ยืนยัน"</li>
                                                <li>กดปุ่ม "พิมพ์ เพื่อพิมพ์ฐานการชำระเงิน เก็บเอาไว้เป็นหลักฐาน</li>
                                            </ol>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div id="scb" class="how-to-desc">
                                <div class="col-sm-3 text-center">
                                    <img src="<?php echo Theme::asset()->url('images/logo/logo_scb.jpg');?>">
                                </div>
                                <div class="col-sm-9">
                                    <dl>
                                        <dt>ขั้นตอนการใช้งาน</dt>
                                        <dd>
                                            <ol>
                                                <li>เข้าไปที่เว็บไซต์ www.scbeasy.com</li>
                                                <li>Login เข้าสู่ระบบโดยใช้ Username และ Password ที่ได้รับจากทางธนาคาร</li>
                                                <li>กดปุ่ม "My Page" เพื่อทำรายการต่อ</li>
                                                <li>เลือก "ชำระเงิน และ e-Bill"</li>
                                                <li>กดปุ่ม "สร้างแบบฟอร์มการชำระเงิน"</li>
                                                <li>เลือก บัญชีผู้ให้บริการ (Biller) เป็น "บริษัททรูมันนี่จำกัด :หมายเลข comp code 0546"
                                                    <p>
                                                        กรณีที่ไม่มีบัญชี "บริษัทรูมันนี่จำกัด :หมายเลข comp code 0546" อยู่ในรายชื่อ</p>
                                                    <ol>
                                                        <li>เลือก "เพิ่มรายชื่อผู้รับชำระ" แล้วกดปุ่ม "Add from Bill Group"</li>
                                                        <li>เลือก Billing Group เป็น "ค่าบริการอินเตอร์เน็ต" แล้วกด "Search"</li>
                                                        <li>กดปุ่มเครื่องหมาย "+" ตรง บริษัททรูมันนี่จำกัด Comp Code 0546</li>
                                                        <li>กดปุ่ม "Add" เพื่อยืนยันการเพิ่มชื่อผู้ให้บริการ</li>
                                                    </ol>
                                                </li>
                                                <li>กรอกข้อมูลลูกค้า "ชื่อ-นามสกุล" และใส่ "เลขที่อ้างอิง 1 (Ref No.1)" และ "เลขที่อ้างอิง
                                                    2 (Ref No.2)" ตามที่ปรากฏในหน้าสรุปรายการสั่งซื้อ และใส่ยอดเงินค่่าสินค้าลงในช่อง
                                                    "จำนวนเงิน"</li>
                                                <li>กดปุ่ม "Next"</li>
                                                <li>ตรวจสอบรายการที่ชำระอีกครั้ง พร้อมกด "Confirm"</li>
                                                <li>กดปุ่ม "พิมพ์" เพื่อพิมพ์หลักฐานการชำระเงิน เก็บเอาไว้เป็นหลักฐาน</li>
                                                <li>ตรวจสอบความถูกต้องว่าเป็นบัญชีเป็นชื่อ บริษัท TRUE MONEY แล้วเลือก "ยืนยัน" เพื่อชำระค่า</li>
                                            </ol>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div id="bangkok" class="how-to-desc">
                                <div class="col-sm-3 text-center">
                                    <img src="<?php echo Theme::asset()->url('images/logo_bangkok.jpg');?>">
                                </div>
                                <div class="col-sm-9">
                                    <dl>
                                        <dt>ขั้นตอนการใช้งาน</dt>
                                        <dd>
                                            <ol>
                                                <li>เข้าไปที่เว็บไซต์ www.bangkokbank.com เลือกบริการ Bualuang iBaning แล้วกดเข้าสู่ระบบ</li>
                                                <li>Login เข้าสู่ระบบโดยใช้ Username และ Password ที่ได้รับจากทางธนาคาร</li>
                                                <li>เลือก Payments &gt; new bill payment</li>
                                                <li>ในช่อง Pay to เลือก TMNWLS กรณีที่ยังไม่มี TMNWLS อยู่ในรายชื่อ
                                                    <ul>
                                                        <li>เลือก เพิ่มรายชื่อผู้รับชำระ &gt; Add Payee &gt; type of business เป็น "Goods/Services"</li>
                                                        <li>เลือก TMNWLS * True Money Company Limited</li>
                                                        <li>ตั้งชื่อ Payee Nickname และกรอกเบอร์โทรศัพท์มือถือในช่อง Customer No. (Ref 1) แล้วกด
                                                            OK</li>
                                                    </ul>
                                                </li>
                                                <li>เลือกบัญชีธนาคารของท่านที่ต้องการจะชำระเงินในช่อง From</li>
                                                <li>ใส่เลขที่อ้างอิง 1 (Ref No.1) และเลขที่อ้างอิง 2 (Ref No.2) ตามที่ปรากฏในหน้าสรุปรายการสั่งซื้อ
                                                    และใส่ยอดเงินค่าสินค้าลงในช่องจำนวนเงิน กดปุ่ม Next</li>
                                                <li>ตรวจสอบรายการที่ต้องการชำระอีกครั้ง พร้อมกด Confirm กดปุ่ม "พิมพ์" เพื่อพิมพ์หลักฐานการชำระงิน
                                                    เก็บเอาไว้เป็นหลักฐาน</li>
                                            </ol>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <!-- installment -->
        </div>
        <!-- End Content -->
	</div>
</div>
<?php if (App::environment() === 'office' && strtoupper(array_get($data, 'analytics_status')) === 'N'): ?>
<?php Theme::asset()->container('footer')->write('analytic-goal', '
    var google_conversion_id = 994251981;
    var google_conversion_label = "UKprCPPq3w0QzamM2gM";
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    
    var _gaq = _gaq || [];
        _gaq.push(["_setAccount", "UA-38234774-1"]);
        _gaq.push(["_trackPageview"]);
    
    // transaction details
    _gaq.push(["_addTrans",
       "'.array_get($order,'data.order.order_id').'", // transaction ID - required
       "'.array_get($order,'data.order.shop_name').'", // affiliation or store name
       "'.array_get($order,'data.order.sub_total').'",          // total - required
       "0",           // tax
       "'.array_get($order,'data.order.shipping_fee').'",          // shipping
       "'.array_get($order,'data.order.customer_city').'",       // city
       "'.array_get($order,'data.order.customer_province').'",     // state or province
       "'.array_get($order,'data.order.country').'"             // country
    ]);
');
/*
    // items
    // Start Loop
    <?php if ( ! empty($order['data']['order_item'])){?>
        <?php for($i = 0; $i < count($order['data']['order_item']); $i++){?>
        _gaq.push(['_addItem',
           '<?php echo array_get($order['data']['order_item'][$i],'order_id'); ?>',           // transaction ID - necessary to associate item with transaction
           '<?php echo array_get($order['data']['order_item'][$i],'sku_code'); ?>',           // SKU/code - required
           '<?php echo array_get($order['data']['order_item'][$i],'name'); ?>',        // product name
           '<?php echo array_get($order['data']['order_item'][$i],'category'); ?>',   // category or variation
           '<?php echo array_get($order['data']['order_item'][$i],'price_per_unit'); ?>',          // unit price - required
           '<?php echo array_get($order['data']['order_item'][$i],'quantity'); ?>',               // quantity - required
           '<?php echo array_get($order['data']['order_item'][$i],'brand'); ?>'              // brand name - required
        ]);
        <?php }?>
    <?php }?>
    // End Loop
    
    // track transaction
    _gaq.push(['_trackTrans']);
    <?php }?>
    
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
*/
?>
<?php endif; ?>