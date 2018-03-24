<div class="content-home checkout">
    <div id="wrapper_content">
        <div class="row">
            <div class="col-sm-12 payment-title">
                <?php echo __('Make Payment');?>
            </div>
        </div>

        <div class="row tab-navi tab-navi-01 hidden-xs">
            <div class="col-sm-6 text-center">
                <strong>1. <?php echo __('Payment Status and Delivery');?></strong>
            </div><!--
                            <div class="col-sm-4 text-center">
                                    <strong>2. ที่อยู่ในการจัดส่งสินค้า</strong>
                            </div>
            -->

            <div class="col-sm-6 text-center in-active">
                <strong>2.<?php echo __('Confirm  order and payment');?></strong>
            </div>
        </div>

        <div class="row hidden-xs">
            <div class="col-sm-12 text-center chekout-info">
                <strong>ตรวจสอบสินค้าในตะกร้าของท่าน และเลือกวิธีการจัดส่ง แต่ละร้านค้าอาจมีวิธี และค่าใช้จ่ายในการจัดส่งแตกต่างกันออกไป</strong>
            </div>
        </div>

        <?php /*
        <div class="row hidden-xs">
            <div class="col-sm-12 text-center newyear_msg">
                เนื่องในเทศกาลวันหยุดปีใหม่ สินค้าในกลุ่มโทรศัพท์มือถือและแท็บเล็ตจะเริ่มจัดส่งได้ในวันที่ 3 มกราคม 2557<br>
                และสำหรับสินค้ากลุ่มอื่นๆ อาจมีการจัดส่งล่าช้า เนื่องจากผู้ให้บริการหยุดทำการ ทั้งนี้ ลูกค้าทุกท่านสามารถตรวจสอบสถานะการจัดส่งได้ที่ Call Center 0-2900-9999 ค่ะ<br>
                iTrueMart ขอขอบพระคุณลูกค้าทุกท่าน และขออภัยในความไม่สะดวกด้วยนะคะ
            </div>
        </div>
         */
        ?>

        <form accept-charset="utf-8" class="form-horizontal form_search" id="frm_submit" method="post" name="area_search">
            <div class="row product-container">
                <div class="col-xs-12 col-sm-3 col-sm-push-9">
                    <div class="text-center menu-right">
                        <div class="box-submit">
                            <input class="btn btn-continue bttn_nextstep_green" type="button" value="<?php echo __('Continue');?>">
                        </div>

                        <div class="well total-product">
                            <strong><?php echo __('all products');?> <span class="text-red-1"><?php echo $checkout['items_count']; ?></span> <?php echo __plural('item',$checkout['items_count']);?></strong>
                        </div>

                        <div class="well total-price">
                            <dl class="dl-horizontal">
                                <dt><?php echo __('Total Amount');?> :</dt>

                                <dd class="text-right"><?php echo price_format($checkout['total_price']); ?></dd>

                                <dt><?php echo __('Shipping Cost is included');?></dt>

                                <dd class="text-right" id="total_shipping_fee"><?php echo price_format($checkout['total_shipping_fee']); ?></dd>

                                <dt><?php echo __('all discount');?> :</dt>

                                <dd class="text-right"><span style="color:red;"><?php echo price_format($checkout['discount'] + $checkout['total_discount'],null,null,true); ?></span></dd>

                                <dt><?php echo __('vouchers');?> :</dt>

                                <dd class="text-right"><span style="color:red;"><?php echo price_format($checkout['cash_voucher'],null,null,true); ?></span></dd>
                            </dl>

                            <div class="tag-price text-center">
                                <?php echo __('Total price to be paid'); ?> <strong><?php echo price_format($checkout['sub_total']); ?></strong>
                            </div>
                        </div>

                        <?php if ($isLoggedin): ?>
                            <?php if (is_null($user['trueyou'])): ?>
                            <div id="checkout_menu">
                                <!--start checkout_menu-->

                                <div class="bigheadline" style="font-weight: bold">
                                    <?php echo __('new user'); ?>
                                </div>

                                <div class="bottom_line"></div>
                            </div><!-- True You -->

                            <div class="text-left verify-itruemart">
                                <a class="icon-true-card" href="http://www.itruemart.com/member/profile"></a>

                                <p>สมาชิก <span class="text-red-1">True Card</span><br>
                                    คลิก <?php echo HTML::link('member/profile/', 'ตรวจสอบสิทธิ์'); ?> รับส่วนลดเพิ่ม</p>
                            </div>
                            <?php else: ?>
                            <!-- WELCOME USER -->
                            <?php //s($user); ?>
                            <div class="welcome"><strong>ยินดีต้อนรับ คุณ</strong><br>
                                <?php echo $user['display_name']; ?>
                            </div>
                            <div id="cardtype">
                                <?php if ($user['trueyou'] == 'red'): ?>
                                <img src="/themes/itruemart/assets/images/trueredcard.jpg" alt="True Red Card" class="middle">
                                Red Card Privilege
                                <?php else: ?>
                                <img src="/themes/itruemart/assets/images/trueblackcard.jpg" alt="True Black Card" class="middle">
                                Black Card Privilege
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

            <?php /*
            <div class="col-xs-12 visible-xs" id="cart_detail">
                <h2>ข้อมูลสินค้าในตะกร้า</h2>

                <ul class="list-unstyled" id="cart_steppayment">
                    <li class="cart_actived"><span class="step_no">1</span> <span class="step_name">ตรวจสอบสินค้า<br>
                    และวิธีการจัดส่ง</span></li>

                    <li class="cart_default"><span class="step_no">2</span> <span class="step_name">ยืนยันการ<br>
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
            */
            ?>

                <div class="col-xs-12 col-sm-9 col-sm-pull-3">
                    <div class="profile">
                        <?php if ($isLoggedin): ?>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="list-addr"><?php echo __('Shipping address');?> :</label>

                                <div class="col-sm-7">
                                    <?php echo Form::select('shipping_address_list', $addressOptions, $checkout['customer_address_id'], array('class' => 'form-control', 'id' => 'shipping_address_list')); ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="clearfix"></div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="fullname"><?php echo __('Name');?><span class="text-red-1">*</span> :</label>

                                <div class="col-sm-7">
                                    <input class="form-control" id="shipping_fullname" name="shipping_fullname" placeholder="<?php echo __('Name');?>" type="text" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="province"><?php echo __('province');?><span class="text-red-1">*</span> :</label>

                                <div class="col-sm-7">
                                    <?php echo Form::select('shipping_province_code', $provinceOptions, null, array('id' => 'shipping_province_code', 'class' => 'form-control')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="district"><?php echo __('district');?><span class="text-red-1">*</span> :</label>

                                <div class="col-sm-7">
                                    <?php echo Form::select('shipping_city_code', $cityOptions, null, array('id' => 'shipping_city_code', 'class' => 'form-control')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="sub-district"><?php echo __('Sub-District');?><span class="text-red-1">*</span> :</label>

                                <div class="col-sm-7">
                                    <?php echo Form::select('shipping_district_code', $districtOptions, null, array('id' => 'shipping_district_code', 'class' => 'form-control')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="zip-code"><?php echo __('zip code');?><span class="text-red-1">*</span> :</label>

                                <div class="col-sm-7">
                                    <input class="form-control" id="shipping_postcode" maxlength="100" name="shipping_postcode" placeholder="<?php echo __('zip code');?>" size="50" type="text" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="phone"><?php echo __('Telephone');?> <span class="text-red-1">*</span> :</label>

                                <div class="col-sm-7">
                                    <input class="form-control" id="shipping_phone" name="shipping_phone" placeholder="<?php echo __('Telephone');?>" type="text" value="">
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="addr"><?php echo __('Address');?><span class="text-red-1">*</span> :</label>

                                <div class="col-sm-7">
                                    <textarea class="form-control" maxlength="150" cols="40" id="shipping_address" name="shipping_address" placeholder="<?php echo __('Village Soi Road');?>" rows="10"></textarea>
                                    <div style="color: #000000;font-size: 10px;padding: 5px 5px 0;">*Max. 150 characters</div>
                                    <div class="saving" style="margin-top: 10px; color: gray; display: none;">กำลังบันทึก...</div>
                                </div>
                            </div>

                            <?php if ($showEmailInput): ?>
                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="email"><?php echo __('email');?> <span class="text-red-1">*</span> :</label>

                                <div class="col-sm-7">
                                    <input class="form-control" id="shipping_email" name="shipping_email" placeholder="email@example.com" type="text" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="email_confirmation"><?php echo __('confirm-email');?> <span class="text-red-1">*</span> :</label>

                                <div class="col-sm-7">
                                    <input class="form-control" id="shipping_email_confirmation" name="shipping_email_confirmation" placeholder="" type="text" value="">
                                </div>
                            </div>
                            <?php endif; ?>

                            <!--<div class="clearfix mar-top-80 hidden-xs"></div>-->
                        </div>

                        <div class="clearfix"></div>

                        <?php if ($isLoggedin): ?>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-xs-5 col-sm-5 control-label" for="">
                                    จัดเก็บที่อยู่ในการจัดส่ง<span class="text-red-1">*</span> :
                                </label>
                                <div class="col-xs-7 col-sm-7 form-inline collect-addr">
                                    <div class="col-xs-6 radio">
                                        <input type="radio" name="save_shipping" class="save_shipping" value="1" id="save_shipping">
                                        <label for="save_shipping">
                                            <?php echo __('Save');?>								</label>
                                    </div>
                                    <div class="col-xs-6 radio">
                                        <input type="radio" name="save_shipping" class="save_shipping" value="0" checked="checked" id="nosave_shipping">
                                        <label for="nosave_shipping">
                                            <?php echo __('No Save');?>								</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <?php endif; ?>
                    </div>

                <?php foreach ($checkout['shipments'] as $key => $shipment): ?>
                    <div class="group_cart product-list product-list-first" style="margin-top: 10px;">
                        <div class="row col-xs-white" style="margin-bottom: 10px;">
                            <div class="col-sm-6 vender-name">
                                <strong><?php echo __('Cart shop');?>: <span class="vender-product-amount"><span class="text-red-1"><?php echo $shipment['shop_name']; ?></span> (<?php echo $shipment['vendor_name'] ?>) (<?php echo $shipment['items_count']; ?> <?php echo __plural('pc', $checkout['items_count']);?>)</span></strong>
                            </div>

                            <div class="col-sm-6 box-refresh">
                                <button class="btn btn-refresh update_cart" type="submit"><?php echo __('Re-Calculate');?></button>
                            </div>
                        </div>

                        <div class="row hidden-xs product-detail-head">
                            <div class="col-sm-6">
                                <?php echo __('item');?>
                            </div>

                            <div class="col-sm-2 text-center">
                                <?php echo __('price per piece');?>
                            </div>

                            <div class="col-sm-1 text-center">
                                <?php echo __('Quantity');?>
                            </div>

                            <div class="col-sm-2 text-center">
                                <?php echo __('Total Amount');?>
                            </div>

                            <div class="col-sm-1 text-center">
                                <?php echo __('delete');?>
                            </div>
                        </div>

                        <div class="row hidden-xs">
                            <div class="col-sm-12 divider"></div>
                        </div>

                        <div class="row col-xs-white">
                            <div class="col-sm-12 divider"></div>
                        </div>

                    <?php foreach ($shipment['items'] as $item): ?>
                        <?php //$item['discount'] = 2; ?>
                        <div class="row col-xs-white inventory-<?php echo $item['inventory_id']; ?>">
                            <div class="col-xs-12 col-sm-6 product-info">
                                <a href="<?php echo URL::toLang('products/'.$item['product_pkey']); ?>">
                                    <img alt="<?php echo $item['name']; ?>" class="product-image" src="<?php echo $item['thumbnail']; ?>" style="class: product-image">

                                    <p class="product-description"><?php echo $item['name']; ?></p>
                                </a>
                            </div>

                            <div class="col-xs-6 col-sm-2 text-center product-unitprice">
                                <div class="row">
                                    <div class="visible-xs pr-un-text col-xs-6">
                                        <?php echo __('price per piece');?>
                                    </div>

                                    <div class="pr-un-number col-sm-12 col-xs-6">
                                            <?php
                                                if($item['discount'] == 0 || $item['discount'] == null):
                                                    echo '<span class="special-price">' . price_format($item['price']) . '</span>';
                                                else:

                                                    echo '<span class="text-cancel">' . price_format($item['price']) . '</span><br>';
                                                    echo '<span class="special-price">' . price_format($item['price']-$item['discount']) . '</span>';

                                                endif;
                                            ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-1 text-center product-amount">
                                <div class="row">
                                    <div class="visible-xs pr-am-text col-xs-6">
                                        <?php echo __('items');?>
                                    </div>

                                    <div class="col-sm-12 col-xs-6">
                                        <input class="qty form-control input-sm" min="1" type="number" name="items[<?php echo $item['inventory_id']; ?>]" value="<?php echo $item['quantity']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-2 text-center product-total">
                                <div class="row">
                                    <div class="visible-xs pr-to-text col-xs-6">
                                        <?php echo __('Total Amount');?>
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

                            <div class="col-xs-6 col-sm-1 text-center product-del">
                                <span class="visible-xs"><?php echo __('delete');?></span> <input class="btn btn-delete" data-inventory_id="<?php echo $item['inventory_id']; ?>" type="button" value="">
                            </div>
                        </div>
                    <?php endforeach; ?>

                        <div class="row col-xs-white">
                            <div class="col-sm-12 divider"></div>
                        </div>

                        <div class="row text-right payment-method col-xs-white">
                            <strong><?php echo __('Select Shipping Method');?></strong>
                            <select class="shipping select-shipping-method " name="shipments[<?php echo $key; ?>]" data-shipment="<?php echo $key; ?>">
                                <option value="0">
                                    กรุณากรอกที่อยู่ให้ครบถ้วน
                                </option>
                            </select>
                        </div>
                    </div>

                <?php endforeach; ?>

                <?php //  <input id="promo_code" name="promo_code" type="hidden" value=""> <input id="check_next" name="submit_type" type="hidden" value=""> ?>
                </div>
            </div>
        </form>




        <?php /*
        <div class="row coupon-promotion coupon-information">
            <div class="clearfix">
                <div class="col-xs-12 col-sm-4 text-right pagination">
                    <strong>กรุณากรอกรหัสคูปองส่วนลด</strong>
                </div>

                <div class="col-xs-12 col-sm-4 text-center coupon-container">
                    <input class="form-control input-sm" id="coupon-no" name="code" onblur="this.placeholder = 'รหัสคูปองส่วนลด'" onfocus="this.placeholder = ''" placeholder="รหัสคูปองส่วนลด" type="text" value=""> <input name="type_of_code" type="hidden" value="coupon">
                </div>

                <div class="col-xs-12 col-sm-4 text-left pagination">
                    <input class="coupon_submit_btn btn btn-coupon" id="coupon-btn" type="button" value="ใช้คูปอง">
                </div>
            </div>
        </div>
         */
        ?>

        <div class="row">
            <?php foreach ($trueyouDiscount as $key => $discount): ?>
                <div class="col-sm-12 text-center">
                    คุณได้รับส่วนลด :
                    <span class="text-red-1">
                        <?php echo array_get($discount, 'name'); ?>
                        ( <?php echo ucfirst(array_get($discount, 'card')); ?> Card ลด
                        <?php
                            if (array_get($discount, 'type') == 'percent')
                            {
                                echo array_get($discount, 'percent').' %';
                            }
                            else
                            {
                                echo array_get($discount, 'price').' บาท';
                            }
                        ?> )
                        เป็นจำนวนเงิน
                        <?php echo number_format(array_get($discount, 'discount'), 2); ?>
                        บาท
                    </span>
                </div>
            <?php endforeach; ?>
        </div>


        <div class="row step-container">
            <div class="col-xs-6 col-sm-6 text-left">
                <input class="btn btn-shopping" type="button" value="<?php echo __('select product more');?>" />
            </div>
            <div class="col-xs-6 col-sm-6 text-right">
                <input class="btn btn-next bttn_nextstep_green" type="button" value="<?php echo __('Continue');?>">
            </div>
        </div>
    </div>
</div>

<div id="cart-alert" class="reveal-modal">
    <div class="font2 msg-header text-center alert-title"></div>
    <div id="popup_message" class="alert-message"></div>
    <div id="popup_panel">
        <input type="button" class="popup_ok btn btn-success" value="<?php echo __('ok');?>">
    </div>
</div>

<script>
    var provinces = eval(<?php echo json_encode($provinces); ?>);
    var Checkout = Checkout || {};
    Checkout.data = eval(<?php echo json_encode($checkout); ?>);
    var Customer = Customer || {};
    Customer.addresses = eval(<?php echo json_encode($addresses); ?>);
    var error = '<?php echo $errors->first(); ?>';
</script>