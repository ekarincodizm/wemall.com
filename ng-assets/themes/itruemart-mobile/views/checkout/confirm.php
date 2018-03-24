<div class="main_checkout" style="background-color:#f2f2f2;">

    <!-----------  alltotal ------------>
    <div class="alltotal">
        <?php if ($errors->first('message')): ?>
            <div class="alert alert-danger"><p style="color:red;"><?php echo $errors->first('message'); ?></p></div>
        <?php endif; ?>
            
        <div class="title">
            <h3><span style="background:url(<?php echo Theme::asset()->url("images/shoppingcart.png"); ?>) no-repeat ; padding:0px 0px 0px 30px;"><?php echo __('Make Payment'); ?></span></h3>
        </div>
        <div class="total_oncart">
            <h5><?php echo __('all products'); ?>	 <span class="num_oncart"><?php echo isset($checkout['items_count'])? $checkout['items_count']: "0"; ?></span>	<?php echo HTML::entities(__plural('pc', isset($checkout['items_count']) ? $checkout['items_count'] : 0)); ?></h5>
        </div>
        <div class="list_total">
            <ul class="list">
                <li>
                    <div class="listleft"><?php echo __('Total Amount'); ?> :</div>
                    <div class="listright"><?php echo HTML::entities(price_format(isset($checkout['total_price'])? $checkout['total_price']: 0, null, 2)); ?></div>
                    <div class="clear"></div>
                </li>
                <li>
                    <div class="listleft"><?php echo __('Shipping Cost is included'); ?> </div>
                    <div class="listright"><?php echo HTML::entities(price_format(isset($checkout['total_shipping_fee'])? $checkout['total_shipping_fee']: 0, null, 2)); ?></div>
                    <div class="clear"></div>
                </li>
                <?php 
                    //คำนวณ discount และ voucher.
                    $sumDiscount = 0;
                    $sumVoucher = 0;
                    if(isset($checkout['promotions']) && count($checkout['promotions']) > 0){
                        foreach($checkout['promotions'] as $promotion){
                            if(isset($promotion["type"]) && $promotion["type"] == 'cash_voucher'){
                                $sumVoucher += $promotion['totalDiscount'];
                            }elseif(isset($promotion["type"])){
                                $sumDiscount += $promotion['totalDiscount'];
                            }
                        }
                    }
                ?>
                <li>
                    <div class="listleft"><?php echo __('all discount'); ?> :</div>
                    <div class="listright"><span class="redfont"><?php echo HTML::entities(price_format($sumDiscount , null, 2, true)); ?></span></div>
                    <div class="clear"></div>
                </li>
                <li>
                    <div class="listleft"><?php echo __('vouchers'); ?> :</div>
                    <div class="listright"><span class="redfont"><?php echo HTML::entities(price_format($sumVoucher , null, 2, true)); ?></span></div>
                    <div class="clear"></div>
                </li>
            </ul>
        </div>

        <!----------- Price ------------>
        <div style="position:relative;"><div style="position:absolute; right:25%; top:-5px;">
                <img src="<?php echo Theme::asset()->url("images/arrowup.png"); ?>" width="18" height="6" />
            </div>
            <div class="priceall">
                <div class="price_left"><h6><?php echo __('Total price to be paid'); ?></h6></div>
                <div class="price_right"><h1><?php echo HTML::entities(price_format(isset($checkout['sub_total'])? $checkout['sub_total'] : 0, null, 2)); ?></h1></div>
                <div class="clear"></div>
            </div>
            <!-----------  End Price ------------>

        </div>    
    </div> <!------------ End alltotal------------>


    <div class="payment_area">
        <div class="whitebox">
            <ul class="payment_choice">
                <?php $key = '155413837979192'; ?>
                <?php if (isset($checkout['available_payment_methods']) && array_key_exists($key, $checkout['available_payment_methods'])): ?>
                    <li><div class="choice">
                            <input id="credit-card"  name="payment_channel" type="radio" value="<?php echo $key; ?>" checked="checked"  class="radiopayment"/>
                            <label for="credit-card" >
                                <div class="paymentico"><img src="<?php echo Theme::asset()->url("images/visamaster.jpg"); ?>" width="101" /></div>
                                <div  class="paymentlabel">
                                    <div class="plabel">บัตรเครดิต</div>
                                    <div class="greyfont_s"> (Credit card)</div>
                                    <div class="clear"></div>
                                </div>
                            </label>
                            <div class="clear"></div>
                        </div>
                        <div class="explainpayment active">
                            <div class="greybox">
                                <h7><p>ยินดีรับชำระด้วย <strong style="color: #000">บัตรเครดิตทุกธนาคาร</strong> ผ่านทาง
                                        KBank Payment Gateway</p>
                                    <p>ไม่เสียค่าธรรมเนียม (Charge) จากการใช้บัตรเครดิต โดยทางบริษัทฯจะเป็นผู้ชำระค่าใช้จ่ายในส่วนนี้แทน</p></h7>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </li>
                <?php endif; ?>
                <?php $key = '156513837979495'; ?>
                <?php if (isset($checkout['available_payment_methods']) && array_key_exists($key, $checkout['available_payment_methods'])): ?>
                    <li><div class="choice">
                            <input id="atm"  name="payment_channel" type="radio" value="<?php echo $key; ?>" class="radiopayment"/>
                            <label for="atm" >
                                <div class="paymentico"><img src="http://www.itruemart.com/assets/itruemart_responsive/global/images/icon-bank-atm.jpg" /></div>
                                <div  class="paymentlabel">
                                    <div class="plabel">ตู้ ATM </div>
                                    <div class="greyfont_s"> (Bank ATM) </div>
                                    <div class="clear"></div>
                                </div>
                            </label>
                            <div class="clear"></div>
                        </div>
                        <div class="explainpayment">
                            <div class="greybox">
                                <h7>
                                    <p>การชำระเงินผ่านตู้ ATM ในกรุงเทพฯและปริมณทล จะเสียค่าธรรมเนียมประมาณ 20-25 บาท <span style="color: red">*</span></p>
                                    <p>การชำระเงินผ่านตู้ ATM ต่างจังหวัด จะเสียค่าธรรมเนีมประมาณ 35-40 บาท <span style="color: red">
                                            *</span></p>
                                    <p><span style="color: red">*</span>อัตราค่าธรรมเนียมขึ้นอยู่กับธนาคารที่รับชำระ</p>
                                </h7>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
                <?php $key = '158913837979603'; ?>
                <?php if (isset($checkout['available_payment_methods']) && array_key_exists($key, $checkout['available_payment_methods'])): ?>
                    <li>
                        <div class="choice">
                            <input id="ibanking"  name="payment_channel" type="radio" value="<?php echo $key; ?>" class="radiopayment"/>
                            <label for="ibanking" >
                                <div class="paymentico"><img src="http://www.itruemart.com/assets/itruemart_responsive/global/images/icon-ibanking.jpg" /></div>
                                <div  class="paymentlabel">
                                    <div class="plabel">iBanking</div>
                                    <div class="greyfont_s">(Internet Banking)</div>
                                    <div class="clear"></div>
                                </div>
                            </label>
                            <div class="clear"></div>
                        </div>
                        <div class="explainpayment">
                            <div class="greybox">
                                <h7>
                                    <p>
                                        สามารถตรวจสอบวิธีการชำระผ่าน iBanking service ของธนาคารกสิกรไทย,ธนาคารไทยพาณิชย์
                                        และธนาคารกรุงเทพ ได้จากหน้ายืนยันการสั่งซื้อและชำระเงิน</p>
                                </h7>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
                <?php $key = '152313837979681'; ?>
                <?php if (isset($checkout['available_payment_methods']) && array_key_exists($key, $checkout['available_payment_methods'])): ?>
                    <li>
                        <div class="choice">
                            <input id="payment-counter"  name="payment_channel" type="radio" value="<?php echo $key; ?>" class="radiopayment"/>
                            <label for="payment-counter" >
                                <div class="paymentico"><img src="<?php echo Theme::asset()->url("images/counter.jpg"); ?>" width="93"/></div>
                                <div  class="paymentlabel">
                                    <div class="plabel">เคาร์เตอร์ธนาคาร</div>
                                    <div class="greyfont_s">(Payment Counter)</div>
                                    <div class="clear"></div>
                                </div>
                            </label>
                            <div class="clear"></div>
                        </div>
                        <div class="explainpayment">
                            <div class="greybox">
                                <h7>
                                    <p>การโอนเงินในกรุงเทพฯและปริมณทล จะเสียค่าธรรมเนียมประมาณ 20-25 บาท<span style="color: red">*</span></p>
                                    <p>การโอนเงินต่างจังหวัด จะเสียค่าธรรมเนีมประมาณ 35-40 บาท <span style="color: red">*</span></p>
                                    <p><span style="color: red">*</span>อัตราค่าธรรมเนียมขึ้นอยู่กับธนาคารที่รับชำระ</p>
                                </h7>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
                <?php $key = '153213837979857'; ?>
                <?php if (isset($checkout['available_payment_methods']) && array_key_exists($key, $checkout['available_payment_methods'])): ?>
                    <li>
                        <div class="choice">
                            <input id="counter-service"  name="payment_channel" type="radio" value="<?php echo $key; ?>" class="radiopayment"/>
                            <label for="counter-service" >
                                <div class="paymentico"><img src="<?php echo Theme::asset()->url("images/counterservice.jpg"); ?>" width="46" /></div>
                                <div  class="paymentlabel">
                                    <div class="plabel">เคาร์เตอร์เซอวิส</div>
                                    <div class="greyfont_s">(Counter Service)</div>
                                    <div class="clear"></div>
                                </div>
                            </label>
                            <div class="clear"></div>
                        </div>
                        <div class="explainpayment">
                            <div class="greybox">
                                <h7>
                                    <p>การชำระสินค้าผ่าน เคาน์เตอร์เซอร์วิส ใบชำระเงินมีอายุ 4 วัน นับจากเวลาที่ทำรายการ
                                        และควรชำระภายในวัน เวลาดังกล่าว ไม่เช่นนั้น รายการของท่านจะโดนยกเลิกโดยอัตโนมัติ
                                        <span style="color: red">*</span></p>
                                    <p><span style="color: red">*</span> การชำระเงินผ่านเคาน์เตอร์เซอร์วิส มีค่าธรรมเนียมการชำระเงิน
                                        15 บาท</p>
                                </h7>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
                <?php $key = '156813837979402'; ?>
                <?php if (isset($checkout['available_payment_methods']) && array_key_exists($key, $checkout['available_payment_methods'])): ?>
                    <li>
                        <div class="choice">
                            <input id="instalment" name="payment_channel" type="radio" value="<?php echo $key; ?>" class="radiopayment"/>
                            <label for="instalment" >
                                <div class="paymentico"><img src="http://www.itruemart.com/assets/itruemart_responsive/global/images/icon-kbank.png" /></div>
                                <div  class="paymentlabel">
                                    <div class="plabel">ผ่อนชำระ</div>
                                    <div class="greyfont_s">(Instalment)</div>
                                    <div class="clear"></div>
                                </div>
                            </label>
                            <div class="clear"></div>
                        </div>
                        <div class="explainpayment">
                            <div class="greybox">
                                <h7>
                                    <ul class="list-unstyled">
                                        <li>ระยะเวลาการผ่อนชำระ</li>
                                        <?php foreach ($checkout['available_payment_methods'][$key]['periods'] as $v): ?>
                                            <li>
                                                <input type="radio" value="<?php echo $v; ?>" id="ins-<?php echo $v; ?>" name="installment" checked="checked">
                                                <label for="ins-<?php echo $v; ?>">
                                                    <?php echo $v; ?> เดือน
                                                </label>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <p>
                                        การผ่อนชำระ จะได้กับบัตรเครดิตที่เป็นธนาคารกสิกรไทยเท่านั้น</p>
                                    <p>
                                        ค่าธรรมเนียม (Fee) และดอกเบี้ย (interest) จากการผ่อนชำระสินค้าทาง iTrueMart.com
                                        จะเป็นผู้รับผิดชอบค่าใช้จ่ายในส่วนนี้ให้กับท่าน</p>
                                </h7>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
                <?php $key = '155613837979771'; ?>
                <?php if (isset($checkout['available_payment_methods']) && array_key_exists($key, $checkout['available_payment_methods'])): ?>
                    <li>
                        <div class="choice">
                            <input id="cod" name="payment_channel" type="radio" value="<?php echo $key; ?>" class="radiopayment"/>
                            <label for="cod" >
                                <div class="paymentico"><i>COD</i></div>
                                <div  class="paymentlabel">
                                    <div class="plabel">จ่ายเงินเมื่อได้รับสินค้า</div>
                                    <div class="greyfont_s">(Cash on delivery)</div>
                                    <div class="clear"></div>
                                </div>
                            </label>
                            <div class="clear"></div>
                        </div>
                        <div class="explainpayment">
                            <div class="greybox">
                                <h7>
                                    <p>
                                        พนักงานจัดส่งสินค้า จะทำการโทรนัดหมายวันเวลา พร้อมแจ้งยอดชำระสินค้าให้ท่านทราบ ก่อนทำการจัดส่งสินค้า</p>
                                    <p>
                                        กรุณาเตรียมเงินสดให้พอดีกับค่าสินค้า และชำระกับพนักงานจัดส่งสินค้า เมื่อท่านได้รับสินค้าเรียบร้อยแล้ว</p>
                                    <p><strong class="text-red-1">หมายเหตุ</strong> ระยะเวลาในการจัดส่งสินค้าจะใช้เวลาจัดส่ง 1-3 วัน</p>
                                </h7>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    
    <?php //if ($isLoggedin && isset($checkout['type']) && $checkout['type'] == 'normal'): ?>
<!--        <div class="payment_area">
            <div class="whitebox">
                <form action="/checkout/apply-coupon" method="post" id="form-coupon">
                    <div class="well text-center voucher">
                        <p>
                            <strong style="color: red;">
                                กรอกคูปองเงินสด หรือโปรโมชั่นโค้ด<br class="hidden-xs">
                                (Cash voucher / Promotion Code)
                            </strong>
                        </p>
                        <p>
                            <input type="text" name="code" id="vcode" placeholder="รหัสคูปองเงินสด" class="form-control input-sm">
                        </p>
                        <?php //foreach ($checkout['promotions'] as $promotion): ?>
                            <?php //if (empty($promotion['code'])) continue; ?>
                            <div class="coupon-information text-center">
                                <?php //echo $promotion['name']; ?>
                                <i class="remove-coupon" data-code="<?php //echo $promotion['code']; ?>">x</i>
                            </div>
                        <?php //endforeach; ?>
                        <input type="submit" class="btn btn-coupon" value="ใช้คูปองเงินสด">
                    </div>
                </form>
            </div>
        </div>-->
    <?php //endif; ?>

    <div class="adressform_area">
        <div class="whitebox">
            <h3><span class="redfont"><?php echo __('Make Payment'); ?></span></h3>
            <h7><span class="redfont">**</span>ตรวจสอบสินค้าในตะกร้าของท่าน และเลือกวิธีการจัดส่ง แต่ละร้านค้าอาจมีวิธี
                และค่าใช้จ่ายในการจัดส่งแต่กต่างกันออกไป</h7>
            <div class="detail_confirm">
                <h8><?php echo __('Shipping address'); ?> :</h8>
                <div >
                    <div class="detail"><?php echo HTML::entities(isset($checkout['customer_name'])? $checkout['customer_name']: ""); ?></div>
                    <div class="detail">
                        <?php
                            $custAddr = "";
                            $custAddr .= (isset($checkout['customer_address'])? htmlentities($checkout['customer_address']) . " ": "");
                            $custAddr .= (isset($checkout['customer_district'])? $checkout['customer_district'] . " ": "");
                            $custAddr .= (isset($checkout['customer_city'])? $checkout['customer_city'] . " ": ""); 
                            $custAddr .= (isset($checkout['customer_province'])? $checkout['customer_province'] . " ": "");
                            $custAddr .= (isset($checkout['customer_postcode'])? $checkout['customer_postcode']: "");
                            echo HTML::entities($custAddr); 
                            ?>
                    </div>
                    <div class="detail">โทร. <?php echo HTML::entities(isset($checkout['customer_tel'])? $checkout['customer_tel']: ""); ?></div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="product_area">
        <div class="title"><h3>ข้อมูลสินค้าในตะกร้า</h3></div>
        <?php if (isset($checkout['shipments'])): ?>
            <?php foreach ($checkout['shipments'] as $key => $shipment): ?>
                <div class="productincart">
                    <div class="box">
                        <h8><span class="block">สินค้าของร้าน : <span class="redfont"><?php echo HTML::entities(isset($shipment['vendor_name'])? $shipment['vendor_name']: ""); ?></span></span></h8>
                        <h7><span class="block"><?php echo HTML::entities(isset($shipment['items_count'])? $shipment['items_count'] : ""); ?> <?php echo HTML::entities(__plural('pc', isset($shipment['items_count']) ? $shipment['items_count'] : 0)); ?></span></h7>
                    </div>
                    <?php foreach ($shipment['items'] as $item): ?>
                        <div class="box">
                            <div class="product_info">
                                <div class="product">
                                    <div class="product_pic">
                                        <img alt="<?php echo HTML::entities($item['name']); ?>" src="<?php echo $item['thumbnail']; ?>" width="136" height="136" border="0" />
                                    </div>
                                    <div class="product_name"><?php echo HTML::entities($item['name']); ?></div>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="box" style=" border-top:1px dotted #d8d8d8; border-bottom:1px dotted #d8d8d8;">
                            <div class="productprice" style="width:40%; float:left; ">
                                <h8><?php echo __('price per piece'); ?></h8>
                                <?php if($item['discount'] == 0 || is_null($item['discount'])): ?>
                                    <div class="pricep"><?php echo HTML::entities(price_format($item['price'], null, 2)); ?></div>
                                <?php else: ?>
                                    <div class="pricep">
                                        <sup> <?php echo HTML::entities(price_format($item['price'], null, 2)); ?></sup>
                                        <?php echo HTML::entities(price_format($item['price'] - $item['discount'], null, 2)); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="sum" style="width:45%; float:right;">
                                <h8><?php echo __('Quantity'); ?></h8>
                                <div class="forms-sum left" ><input name="User" type="text"  value="<?php echo $item['quantity']; ?>" disabled="disabled" style="background:#CCC"/></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="greybox" style="border-bottom:1px solid #d8d8d8; padding:0px 10px 0px 10px;">
                            <div class="list_total">
                                <ul class="list" style="font-size:0.8em;">
                                    <li style="padding-right:10px;">
                                        <div class="listleft " style="text-align:left; width:50%;"><h8><?php echo __('Total Amount'); ?></h8></div>
                                        <div class="listright" style="width:50%">
                                            <h8><?php echo HTML::entities(price_format($item['total_price'] - $item['total_discount'], null, 2)); ?></h8>
                                        </div>
                                        <div class="clear"></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="numofproduct total_area">
                        <div class="totalprice" style="float:none;">
                            <div class="totalprice_shipping">
                                <h8>
                                    <?php $shipping_method = $shipment['shipping_method']; ?>
                                    <?php echo $shipment['available_shipping_methods'][$shipping_method]['name'] . ' (' . $shipment['available_shipping_methods'][$shipping_method]['description'] . ')'; ?>
                                </h8>
                            </div>
                            <div class="totalprice_shipping_con"><h8><?php echo HTML::entities(price_format($shipment['shipping_fee'], null, 2)); ?></h8></div>
                            <div class="clear"></div>
                            <div class="totalprice_dis"><h8><?php echo __('discount'); ?></h8></div>
                            <div class="totalprice_dis_con"><h8><?php echo HTML::entities(price_format($shipment['total_discount'], null, 2, true)); ?></h8></div>
                            <div class="clear"></div>
                            <div class="totalprice_shop"><h8>ราคารวมร้าน</h8>
                                <div><span class="redfont"><?php echo HTML::entities(isset($shipment['vendor_name'])? $shipment['vendor_name'] : ""); ?></span></div>
                            </div>
                            <div class="totalprice_con"><?php echo HTML::entities(price_format($shipment['sub_total'], null, 2)); ?></div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div style=" padding:20px 0px 10px 0px;">
            <div style="width:50%; float:left;"><div style="padding-right:5px;"><button class=" btn-orange-l" style="width:100%; margin:0; padding:0; float:none;" onclick="location.href = '<?php echo route("checkout1"); ?>';"><?php echo __('Back'); ?></button></div></div>
            <div style="width:50%; float:left;"><div style="padding-left:5px;"><button class="btn-blue-l btn-paid" style="width:100%; margin:0; padding:0; float:none;">ดำเนินการต่อ</button></div></div>
            <div class="clear"></div>
        </div>

    </div>

</div>

<script>
    var Checkout = Checkout || {};
    var siteUrl = "<?php echo route("home"); ?>";
    Checkout.data = eval(<?php echo json_encode(isset($checkout)? $checkout: "{}"); ?>);
</script>
