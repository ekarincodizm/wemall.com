<div class="content-home checkout">
    <div id="wrapper_content">
        <!-- Start Content -->

        <div class="row">
            <div class="col-sm-12 payment-title">
                <?php echo __('Make Payment'); ?>
            </div>
        </div>

        <div class="row tab-navi tab-navi-02 hidden-xs">
            <div class="col-sm-6 text-center">
                <strong>1. <?php echo __('Payment Status and Delivery');?></strong>
            </div>

            <div class="col-sm-6 text-center">
                <strong>2. <?php echo __('Confirm  order and payment');?></strong>
            </div>
        </div>

        <div class="row hidden-xs">
            <div class="col-sm-12 text-center chekout-info">
                <strong>ตรวจสอบสินค้าในตะกร้าของท่าน และเลือกวิธีการจัดส่ง แต่ละร้านค้าอาจมีวิธี และค่าใช้จ่ายในการจัดส่งแตกต่างกันออกไป</strong>
            </div>
        </div><?php /*
                <div class="row hidden-xs">
                    <div class="col-sm-12 text-center newyear_msg">
                        เนื่องในเทศกาลวันหยุดปีใหม่ สินค้าในกลุ่มโทรศัพท์มือถือและแท็บเล็ตจะเริ่มจัดส่งได้ในวันที่ 3 มกราคม 2557 <br>
                        และสำหรับสินค้ากลุ่มอื่นๆ อาจมีการจัดส่งล่าช้า เนื่องจากผู้ให้บริการหยุดทำการ ทั้งนี้ ลูกค้าทุกท่านสามารถตรวจสอบสถานะการจัดส่งได้ที่ Call Center 0-2900-9999 ค่ะ<br>
                        iTrueMart ขอขอบพระคุณลูกค้าทุกท่าน และขออภัยในความไม่สะดวกด้วยนะคะ          </div>
                </div>
                 *
                 */?>

        <?php if ($errors->first('message')): ?>
        <div class="alert alert-danger"><p><?php echo $errors->first('message'); ?></p></div>
        <?php endif; ?>

        <div class="row profile-container">
            <!-- Start Menu Right -->

            <div class="col-xs-12 col-sm-3 col-sm-push-9">
                <div class="text-center menu-right">
                    <div class="box-submit">
                        <input class="btn btn-paid" type="button" value="<?php echo __('payment');?>">
                    </div>

                    <div class="well total-product">
                        <strong><?php echo __('all products');?> <span class="text-red-1"><?php echo $checkout['items_count']; ?></span> <?php echo __plural('item',$checkout['items_count']);?></strong>
                    </div>

                    <div class="well total-price">
                        <dl class="dl-horizontal">
                            <dt><?php echo __('Total Amount');?> :</dt>

                            <dd class="text-right"><?php echo price_format($checkout['total_price']); ?></dd>

                            <dt><?php echo __('Shipping Cost is included'); ?> :</dt>

                            <dd class="text-right"><?php echo price_format($checkout['total_shipping_fee']); ?></dd>

                            <dt><?php echo __('all discount');?> :</dt>

                            <dd class="text-right"><span style="color:red;"><?php echo price_format($checkout['discount'] + $checkout['total_discount'],null,null,true); ?></span></dd>

                            <?php /*
                            <dt>คูปองเงินสด :</dt>

                            <dd class="text-right"><span style="color:red;"><?php echo price_format(0); ?></span></dd>
                             *
                             */
                            ?>
                            <dt><?php echo __('vouchers');?> :</dt>

                            <dd class="text-right"><span style="color:red;"><?php echo price_format($checkout['cash_voucher'],null,null,true); ?></span></dd>
                        </dl>

                        <div class="tag-price text-center">
                            <?php echo __('Total price to be paid'); ?> <strong><?php echo price_format($checkout['sub_total']); ?></strong>
                        </div>
                    </div>

                    <?php if ($isLoggedin && $checkout['type'] == 'normal' && $is_line != true): ?>
                    <form action="<?php echo URL::toLang('/checkout/apply-coupon'); ?>" method="post" id="form-coupon">

                        <div class="well text-center voucher">
                            <p>
                                <strong style="color: red;">
                                    กรอกคูปองเงินสด หรือโปรโมชั่นโค้ด<br class="hidden-xs">
                                    (Cash voucher / Promotion Code)
                                </strong>
                            </p>
                            <p>
                                <input type="text" name="code" id="vcode" placeholder="รหัสคูปองเงินสด" style="text-transform: uppercase;" class="form-control input-sm">
                            </p>

                            <?php foreach ($checkout['promotions'] as $promotion): ?>
                            <?php if (empty($promotion['code'])) continue; ?>
                            <div class="coupon-information text-center">
                                <?php echo $promotion['name']; ?>
                                <i class="remove-coupon" data-code="<?php echo $promotion['code']; ?>">x</i>
                            </div>
                            <?php endforeach; ?>
                            <input type="submit" class="btn btn-coupon" value="ใช้คูปองเงินสด">

                        </div>

                    </form>
                    <?php endif; ?>

                    <div id="payment-channel" class="well text-left list-payment-channel">

                        <?php $key = '156813837979402'; ?>
                        <?php if (array_key_exists($key, $checkout['available_payment_methods'])): ?>
                        <div class="payment-channel">
                            <input id="instalment" name="payment_channel" value="<?php echo $key; ?>" type="radio"> <label for="instalment"><img align="left" class="icon-payment" src="/themes/itruemart/assets/images/icn/channel/icon-instalment.png"><span class="payment-name">ผ่อนชำระ<br class="hidden-xs">
                                    (Instalment)</span></label>

                            <div class="divider-menu">
                                <div class="add-remark">
                                    <ul class="list-unstyled">
                                        <li>ระยะเวลาการผ่อนชำระ</li>

                                        <?php foreach ($checkout['available_payment_methods'][$key]['periods'] as $v): ?>
                                        <li><input id="ins-<?php echo $v; ?>" name="installment" type="radio" value="<?php echo $v; ?>"> <label for="ins-<?php echo $v; ?>"><?php echo $v; ?> เดือน</label></li>
                                        <?php endforeach; ?>
                                    </ul>

                                    <p>การผ่อนชำระ จะได้กับบัตรเครดิตที่เป็นธนาคารกสิกรไทยเท่านั้น</p>

                                    <p>ค่าธรรมเนียม (Fee) และดอกเบี้ย (interest) จากการผ่อนชำระสินค้าทาง iTrueMart.com จะเป็นผู้รับผิดชอบค่าใช้จ่ายในส่วนนี้ให้กับท่าน</p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php $key = '155413837979192'; ?>
                        <?php if (array_key_exists($key, $checkout['available_payment_methods'])): ?>
                        <div class="payment-channel">
                            <input id="credit-card" name="payment_channel" value="<?php echo $key; ?>" type="radio"> <label for="credit-card"><img align="left" class="icon-payment" src="/themes/itruemart/assets/images/icn/channel/icon-credit-card.png"><span class="payment-name">บัตรเครดิต<br class="hidden-xs">
                                    (Credit card)</span></label>

                            <div class="divider-menu divider-menu-active">
                                <div class="add-remark" style="display: block">
                                    <p>ยินดีรับชำระด้วย<strong style="color: #000">บัตรเครดิตทุกธนาคาร</strong> ผ่านทาง KBank Payment Gateway</p>

                                    <p>ไม่เสียค่าธรรมเนียม (Charge) จากการใช้บัตรเครดิต โดยทางบริษัทฯจะเป็นผู้ชำระค่าใช้จ่ายในส่วนนี้แทน</p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php $key = '152313837979681'; ?>
                        <?php if (array_key_exists($key, $checkout['available_payment_methods'])): ?>
                        <div class="payment-channel">
                            <input id="payment-counter" name="payment_channel" value="<?php echo $key; ?>" type="radio"> <label for="payment-counter"><img align="left" class="icon-payment" src="/themes/itruemart/assets/images/icn/channel/icon-payment-counter.png"> <span class="payment-name">เคาน์เตอร์ธนาคาร<br class="hidden-xs">
                                    (Payment Counter)</span></label>

                            <div class="divider-menu">
                                <div class="add-remark">
                                    <p>การโอนเงินในกรุงเทพฯและปริมณทล จะเสียค่าธรรมเนียมประมาณ 20-25 บาท<span style="color: red">*</span></p>

                                    <p>การโอนเงินต่างจังหวัด จะเสียค่าธรรมเนีมประมาณ 35-40 บาท <span style="color: red">*</span></p>

                                    <p><span style="color: red">*</span>อัตราค่าธรรมเนียมขึ้นอยู่กับธนาคารที่รับชำระ</p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php $key = '156513837979495'; ?>
                        <?php if (array_key_exists($key, $checkout['available_payment_methods'])): ?>
                        <div class="payment-channel">
                            <input id="atm" name="payment_channel" value="<?php echo $key; ?>" type="radio"> <label for="atm"><img align="left" class="icon-payment" src="/themes/itruemart/assets/images/icn/channel/icon-bank-atm.png"><span class="payment-name">ตู้ ATM<br class="hidden-xs">
                                    (Bank ATM)</span></label>

                            <div class="divider-menu">
                                <div class="add-remark">
                                    <p>การชำระเงินผ่านตู้ ATM ในกรุงเทพฯและปริมณทล จะเสียค่าธรรมเนียมประมาณ 20-25 บาท <span style="color: red">*</span></p>

                                    <p>การชำระเงินผ่านตู้ ATM ต่างจังหวัด จะเสียค่าธรรมเนีมประมาณ 35-40 บาท <span style="color: red">*</span></p>

                                    <p><span style="color: red">*</span>อัตราค่าธรรมเนียมขึ้นอยู่กับธนาคารที่รับชำระ</p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php $key = '158913837979603'; ?>
                        <?php if (array_key_exists($key, $checkout['available_payment_methods'])): ?>
                        <div class="payment-channel">
                            <input id="ibanking" name="payment_channel" value="<?php echo $key; ?>" type="radio"> <label for="ibanking"><img align="left" class="icon-payment" src="/themes/itruemart/assets/images/icn/channel/icon-ibanking.png"><span class="payment-name">iBanking<br class="hidden-xs">
                                    (Internet Banking)</span></label>

                            <div class="divider-menu">
                                <div class="add-remark">
                                    <p>สามารถตรวจสอบวิธีการชำระผ่าน iBanking service ของธนาคารกสิกรไทย,ธนาคารไทยพาณิชย์ และธนาคารกรุงเทพ ได้จากหน้ายืนยันการสั่งซื้อและชำระเงิน</p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php $key = '153211444223894'; ?>
                        <?php if (array_key_exists($key, $checkout['available_payment_methods'])): ?>
                        <div class="payment-channel">
                            <input id="counter-service" name="payment_channel" value="<?php echo $key; ?>" type="radio"> <label for="counter-service"><img align="left" class="icon-payment" src="/themes/itruemart/assets/images/icn/channel/icon-counter-service.png"><span class="payment-name">เคาน์เตอร์เซอร์วิส<br class="hidden-xs">
                                    (Counter Service)</span></label>

                            <div class="divider-menu">
                                <div class="add-remark">
                                    <p>การชำระสินค้าผ่าน เคาน์เตอร์เซอร์วิส ใบชำระเงินมีอายุ 4 วัน นับจากเวลาที่ทำรายการ และควรชำระภายในวัน เวลาดังกล่าว ไม่เช่นนั้น รายการของท่านจะโดนยกเลิกโดยอัตโนมัติ <span style="color: red">*</span></p>

                                    <p><span style="color: red">*</span> การชำระเงินผ่านเคาน์เตอร์เซอร์วิส มีค่าธรรมเนียมการชำระเงิน 15 บาท</p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php $key = '155613837979771'; ?>
                        <?php if (array_key_exists($key, $checkout['available_payment_methods'])): ?>
                        <div class="payment-channel">
                            <input id="cod" name="payment_channel" value="<?php echo $key; ?>" type="radio"> <label for="cod"><img align="left" class="icon-payment-no-text" src="/themes/itruemart/assets/images/icn/channel/icon-cod.png"><span class="payment-name"><br class="hidden-xs"></span></label>

                            <div class="divider-menu">
                                <div class="add-remark">
                                    <p>พนักงานจัดส่งสินค้า จะทำการโทรนัดหมายวันเวลา พร้อมแจ้งยอดชำระสินค้าให้ท่านทราบ ก่อนทำการจัดส่งสินค้า</p>

                                    <p>กรุณาเตรียมเงินสดให้พอดีกับค่าสินค้า และชำระกับพนักงานจัดส่งสินค้า เมื่อท่านได้รับสินค้าเรียบร้อยแล้ว</p>

                                    <p><strong class="text-red-1">หมายเหตุ</strong> ระยะเวลาในการจัดส่งสินค้าจะใช้เวลาจัดส่ง 1-3 วัน</p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php $key = ''; ?>
                        <?php if (array_key_exists($key, $checkout['available_payment_methods'])): ?>
                        <div class="payment-channel">
                            <input id="ivr" name="payment_channel" value="<?php echo $key; ?>" type="radio"> <label for="ivr"><img align="left" class="icon-payment" src="/themes/itruemart/assets/images/icn/channel/icon-ivr.png"><span class="payment-name">ระบบตอบรับอัตโนมัติ<br class="hidden-xs">
                                    (IVR)</span></label>

                            <div class="divider-menu">
                                <div class="add-remark"></div>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div><!-- End Menu Right -->

            <div class="col-xs-12 visible-xs" id="cart_detail">
                <h2><?php echo __('My Cart');?></h2>

                <ul class="list-unstyled" id="cart_steppayment">
                    <li class="cart_default"><span class="step_no">1</span> <span class="step_name">ตรวจสอบสินค้า<br>
                            และวิธีการจัดส่ง</span></li>

                    <li class="cart_actived"><span class="step_no">2</span> <span class="step_name">ยืนยันการ<br>
                            สั่งซื้อและชำระเงิน</span></li>
                </ul>

                <div class="clearfix"></div>

                <div class="chekout-info-mobile text-center">
                    ตรวจสอบสินค้าในตะกร้าของท่าน และเลือกวิธีการจัดส่ง<br>
                    แต่ละร้านค้าอาจมีวิธี และค่าใช้จ่ายในการจัดส่งแตกต่างกันออกไป
                </div>

                <div class="text-center" id="newyear_msg">
                    เนื่องในเทศกาลวันหยุดปีใหม่ สินค้าในกลุ่มโทรศัพท์มือถือและแท็บเล็ตจะเริ่มจัดส่งได้ในวันที่ 3 มกราคม 2557 และสำหรับสินค้ากลุ่มอื่นๆ อาจมีการจัดส่งล่าช้า เนื่องจากผู้ให้บริการหยุดทำการ ทั้งนี้ ลูกค้าทุกท่านสามารถตรวจสอบสถานะการจัดส่งได้ที่ Call Center 0-2900-9999 ค่ะ iTrueMart ขอขอบพระคุณลูกค้าทุกท่าน และขออภัยในความไม่สะดวกด้วยนะคะ
                </div>
            </div>

            <div class="col-xs-12 col-sm-9 col-sm-pull-3">
                <div class="form-horizontal delivery-container">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo __('Shipping address');?> :</label>

                        <div class="col-sm-9">
                            <div class="well form-control-static delivery-addr">
                                <div class="row">
                                    <p class="col-sm-12"><?php echo $checkout['customer_name']; ?></p>

                                    <p class="col-sm-6"><?php echo $checkout['customer_address'].' '.$checkout['customer_district'].' '.$checkout['customer_city'].' '.$checkout['customer_province'].' '.$checkout['customer_postcode']; ?></p>

                                    <p class="col-sm-1"></p>

                                    <p class="col-sm-5">โทร <?php echo $checkout['customer_tel']; ?><br>
                                        <?php echo $checkout['customer_email']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- Group Vendor -->

                <?php foreach ($checkout['shipments'] as $key => $shipment): ?>

                <div class="product-list product-list-first">
                    <div class="row col-xs-white">
                        <div class="col-sm-12 vender-name">
                            <strong><?php echo __('Cart shop');?>: <span class="vender-product-amount"><span class="text-red-1"><?php echo $shipment['shop_name']; ?></span> (<?php echo $shipment['vendor_name'] ?>) (<?php echo $shipment['items_count']; ?> <?php echo __plural('pc', $checkout['items_count']);?>)</span></strong>
                        </div>
                    </div>

                    <div class="row hidden-xs product-detail-head">
                        <div class="col-sm-7">
                            <?php echo __('items'); ?>
                        </div>

                        <div class="col-sm-2 text-center">
                            <?php echo __('price per piece');?>
                        </div>

                        <div class="col-sm-1 text-center">
                            <?php echo __('Quantity'); ?>
                        </div>

                        <div class="col-sm-2 text-center">
                            <?php echo __('Total amount'); ?>
                        </div>
                    </div>

                    <div class="row hidden-xs">
                        <div class="col-sm-12 divider"></div>
                    </div>

                    <?php foreach ($shipment['items'] as $item): ?>
                    <div class="row col-xs-white">
                        <div class="col-xs-12 col-sm-7 product-info">
                            <img alt="<?php echo $item['name']; ?>" class="product-image" src="<?php echo $item['thumbnail']; ?>" style="class: product-image">

                            <p class="product-description"><?php echo $item['name']; ?></p>
                        </div>

                        <div class="col-xs-6 col-sm-2 text-center product-unitprice">
                            <div class="visible-xs pr-un-text col-xs-6">
                                <?php echo __('Price per piece'); ?>
                            </div>

                            <div class="pr-un-number col-sm-12 col-xs-6">
                                <?php echo price_format($item['price']); ?>
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-1 text-center product-amount">
                            <div class="visible-xs pr-am-text col-xs-6">
                                <?php echo __('Quantity'); ?>
                            </div>

                            <div class="col-sm-12 col-xs-6">
                                <input class="form-control input-sm text-center" disabled type="text" value="<?php echo $item['quantity']; ?>">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-2 text-center product-total">
                            <div class="visible-xs pr-to-text col-xs-8">
                                <?php echo __('Total amount'); ?>
                            </div>

                            <div class="text-red-1 pr-to-number col-sm-12 col-xs-4">

                                <span <?php if($item['total_discount']>0):?>style="text-decoration: line-through;color:black;"<?php endif; ?>>
                                    <?php echo price_format($item['total_price']); ?>
                                </span>
                                <br>
                                <span><?php if($item['total_discount']>0){ echo price_format($item['total_price']-$item['total_discount'],null,null,false); }?></span>
                                <p><?php //d($item); ?></p>

                            </div>
                        </div>
                    </div>

                    <div class="row col-xs-white">
                        <div class="col-sm-12 divider"></div>
                    </div>

                    <?php endforeach; ?>

                    <div class="row payment-method col-xs-white">
                        <div class="panel col-xs-12 col-sm-5">
                            <div class="panel-body delivery-desc">
                                <dl>
                                    <dt><?php echo __('Select Shipping Method'); ?></dt>
                                    <?php $shipping_method = $shipment['shipping_method']; ?>
                                    <dd><?php echo $shipment['available_shipping_methods'][$shipping_method]['name'].' ('.$shipment['available_shipping_methods'][$shipping_method]['description'].')'; ?></dd>
                                </dl>
                            </div>
                        </div>

                        <div class="panel col-xs-12 col-sm-7">
                            <div class="panel-body">
                                <div class="delivery-type-box clearfix">
                                    <div class="col-xs-8 col-sm-8 text-right type-discount">
                                        <?php echo $shipment['available_shipping_methods'][$shipping_method]['name'].' ('.$shipment['available_shipping_methods'][$shipping_method]['description'].')'; ?>
                                    </div>

                                    <div class="col-xs-4 col-sm-4 text-right">
                                        <?php echo price_format($shipment['shipping_fee']); ?>
                                    </div>
                                </div>

                                <div class="discount-price-box clearfix">
                                    <div class="col-xs-8 col-sm-8 text-right">
                                        <?php echo __('discount'); ?>
                                    </div>

                                    <div class="col-xs-4 col-sm-4 text-right">
                                        <span class="text-right text-red-1"><?php echo price_format($shipment['total_discount'],null,null,true); ?></span>
                                    </div>
                                </div>

                                <div class="total-price-box clearfix">
                                    <div class="col-xs-8 col-sm-8 text-right">
                                        <?php echo __('Cart shop');?> : <span class="text-red-1"><?php echo $shipment['vendor_name']; ?></span> (<?php echo $shipment['items_count']; ?> <?php echo __plural('pc', $shipment['items_count']);?>)
                                    </div>

                                    <div class="col-xs-4 col-sm-4 text-right">
                                        <span class="text-right"><?php echo price_format($shipment['sub_total']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <?php endforeach; ?>

            </div>
        </div>

        <div class="row step-container">
            <div class="col-xs-6 col-sm-4 text-left">
                <input class="btn btn-previous" onclick="window.location.href = '<?php echo URL::toLang('checkout'); ?>';" type="button" value="<?php echo __('Back');?>">
            </div>

            <div class="col-xs-6 col-sm-8 text-right">
                <p class="payment-channel-selected"><span>คุณเลือกชำระเงินด้วย<br>
                        <a href="#payment-channel">คลิกเพื่อเปลี่ยนวิธีการชำระเงิน</a></span> <span id="payment-select-show"><img align="left" class="icon-payment" src="http://www.itruemart.com/assets/itruemart_responsive/global/images/icon-credit-card.jpg"> <span class="payment-name">บัตรเครดิต<br class="hidden-xs">
                            (Credit Card)</span></span></p><input class="btn btn-paid" type="button" value="<?php echo __('payment');?>">
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 text-center">
                <input class="btn btn-view-desktop visible-xs" type="button" value="View Desktop Version">
            </div>
        </div><!-- End Content -->
    </div>
</div>

<div id="cart-alert" class="reveal-modal">
    <div class="font2 msg-header text-center alert-title"></div>
    <div id="popup_message" class="alert-message"></div>
    <div id="popup_panel">
        <input type="button" class="popup_ok btn btn-success" value="ตกลง">
    </div>
</div>

<script>
    var Checkout = Checkout || {};
    Checkout.data = eval(<?php echo json_encode($checkout); ?>);
</script>
