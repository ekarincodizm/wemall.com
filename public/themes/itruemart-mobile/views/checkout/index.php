<div class="main_checkout" style="background-color:#f2f2f2;">
    <?php if ($errors->first('message')): ?>
        <div id="coupon_error" class="all_error">
            <div class="error-box">
                <div id="register_error_msg" class="error_msg all_register_error_msg" style="color:red; text-align: center;">
                    <?php echo $errors->first('message'); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!--alltotal-->
    <div class="alltotal">
        <div class="title">
            <h3>
                <span style="background:url('<?php echo Theme::asset()->usePath()->url('images/shoppingcart.png') ?>') no-repeat ; padding:0px 0px 0px 30px;">
                    <?php echo __('Make Payment'); ?>
                </span>
            </h3>
        </div>
        <div class="total_oncart">
            <h5><?php echo __('all products'); ?>       <span
                    class="num_oncart"><?php echo HTML::entities($checkout['items_count']); ?></span>    <?php echo HTML::entities(__plural('item', $checkout['items_count'])); ?>
            </h5>
        </div>
        <div class="list_total">
            <ul class="list">
                <li>
                    <div class="listleft"><?php echo __('Total Amount'); ?> :</div>
                    <div class="listright"><?php echo HTML::entities(price_format($checkout['total_price'], null, 2)); ?></div>
                    <div class="clear"></div>
                </li>
                <li>
                    <div class="listleft"><?php echo __('Shipping Cost is included'); ?> </div>
                    <div
                        class="listright"><?php echo HTML::entities(price_format($checkout['total_shipping_fee'], null, 2)); ?></div>
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
                    <div class="listright"><span
                            class="redfont"><?php echo HTML::entities(price_format($sumDiscount, null, 2, true)); ?></span>
                    </div>
                    <div class="clear"></div>
                </li>
                <li>
                    <div class="listleft"><?php echo __('vouchers'); ?> :</div>
                    <div class="listright"><span class="redfont"><?php echo HTML::entities(price_format($sumVoucher, null, 2, true)); ?></span>
                    </div>
                    <div class="clear"></div>
                </li>
            </ul>
        </div>

        <!--Price-->
        <div style="position:relative;">
            <div style="position:absolute; right:25%; top:-5px;"><img
                    src="<?php echo Theme::asset()->usePath()->url('images/arrowup.png') ?>" width="18" height="6"/></div>
            <div class="priceall">
                <div class="price_left"><h6><?php echo __('Total price to be paid'); ?></h6></div>
                <div class="price_right"><h1><?php echo HTML::entities(price_format($checkout['sub_total'])); ?></h1></div>
                <div class="clear"></div>
            </div>
            <!--End Price-->

            <?php if ($isLoggedin && is_null($user['trueyou'])): ?>
                <!--True card-->
                <div class="truecard">
                    <div style="float:left; padding:12px 10px 0px 0px ;">
                        <a href="http://www.itruemart.com/member/profile">
                            <img src="<?php echo Theme::asset()->usePath()->url('images/truecard.png') ?>" width="65" border="0"/>
                        </a>
                    </div>
                    <div style="float:left; color:#373737; ">สมาชิก <span class="redfont">True Card</span><br/>
                        คลิก <a style="text-decoration:underline;padding: 0;" href="http://www.itruemart.com/member/profile">ตรวจสอบสิทธิ์</a> รับส่วนลดเพิ่ม
                    </div>

                </div>
                <div class="clear"></div>
                <!--End True card-->
            <?php endif; ?>
        </div>
    </div>
    <!---->

    <!--End alltotal-->

    <div class="adressform_area">
        <div class="whitebox">
            <h3><span class="redfont"><?php echo __('Make Payment'); ?></span></h3>
            <h7><span class="redfont">**</span>ตรวจสอบสินค้าในตะกร้าของท่าน และเลือกวิธีการจัดส่ง แต่ละร้านค้าอาจมีวิธี
                และค่าใช้จ่ายในการจัดส่งแตกต่างกันออกไป
            </h7>
            <form class="adress">
                <ul class="adress-inner">
                    <li>
                        <div id="address_error" class="all_error" style="display:none;">
                            <div class="error-box">
                                <div id="register_error_msg" class="error_msg all_register_error_msg"  style="color:red; text-align: center;"></div>
                            </div>
                        </div>
                    </li>
                    <?php if ($isLoggedin): ?>
                        <li>
                            <p><?php echo __('Shipping address'); ?> :</p>
                            <div class="forms-st">
                                <?php echo Form::select('shipping_address_list', $addressOptions, null, array('class' => 'form-control', 'id' => 'shipping_address_list')); ?>
                            </div>
                        </li>
                    <?php endif; ?>

                    <li>
                        <p><?php echo __('Name'); ?><span class="redfont">*</span> :</p>

                        <div class="forms-st">
                            <input class="form-control" id="shipping_fullname" name="shipping_fullname"
                                   placeholder="<?php echo __('Name'); ?>" type="text" value="">
                        </div>
                    </li>
                    <li>
                        <p><?php echo __('Address'); ?><span class="redfont">*</span> :</p>

                        <div class="forms-st">
                            <textarea maxlength="150" class="form-control" cols="40" id="shipping_address" name="shipping_address"
                                      placeholder="<?php echo __('Village Soi Road'); ?>" rows="10"></textarea>
                            <div style="color: #000000;font-size: 10px;padding: 5px 5px 0;">*Max. 150 characters</div>
                            <div class="saving" style="margin-top: 10px; color: gray; display: none;">กำลังบันทึก...</div>
                        </div>
                    </li>
                    <li>
                        <p><?php echo __('province'); ?><span class="redfont">*</span> :</p>

                        <div class="forms-st">

                            <?php echo Form::select('shipping_province_code', $provinceOptions, null, array('id' => 'shipping_province_code', 'class' => 'form-control')); ?>

                        </div>
                    </li>
                    <li>
                        <p><?php echo __('district'); ?><span class="redfont">*</span> :</p>

                        <div class="forms-st">

                            <?php echo Form::select('shipping_city_code', $cityOptions, null, array('id' => 'shipping_city_code', 'class' => 'form-control')); ?>

                        </div>
                    </li>
                    <li>
                        <p><?php echo __('Sub-District'); ?><span class="redfont">*</span> :</p>

                        <div class="forms-st">

                            <?php echo Form::select('shipping_district_code', $districtOptions, null, array('id' => 'shipping_district_code', 'class' => 'form-control')); ?>

                        </div>
                    </li>
                    <li>
                        <p><?php echo __('zip code'); ?><span class="redfont">*</span> :</p>

                        <div class="forms-st">
                            <input class="form-control" id="shipping_postcode" maxlength="100" name="shipping_postcode"
                                   placeholder="<?php echo __('zip code'); ?>" size="50" type="text" value="">
                        </div>
                    </li>
                    <li>
                        <p><?php echo __('Telephone'); ?><span class="redfont">*</span> :</p>

                        <div class="forms-st">
                            <input class="form-control" id="shipping_phone" name="shipping_phone"
                                   placeholder="<?php echo __('Telephone'); ?>" type="text" value="">
                        </div>
                    </li>
                    <?php if ($isLoggedin): ?>
                        <li>
                            <p>จัดเก็บที่อยู่ในการจัดส่ง<span class="redfont">*</span> :</p>

                            <div style="padding:5px 10px 0px 10px;">
                                <div class="radioleft">
                                    <input type="radio" name="save_shipping" class="save_shipping" value="1"
                                           id="save_shipping">
                                    <label for="radio1" class="radiolabel"><?php echo __('Save'); ?></label></div>
                                <div class="radioright">
                                    <input type="radio" name="save_shipping" class="save_shipping" value="0"
                                           checked="checked" id="nosave_shipping">
                                    <label for="radio2" class="radiolabel"><?php echo __('No Save'); ?></label>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </form>
        </div>
    </div>

    <div class="product_area">
        <div class="title"><h3><?php echo __('Cart shop'); ?></h3></div>
        <form id="" accept-charset="utf-8" action="<?php echo route("checkout.index.post");  ?>" method="POST" >
            <?php foreach ($checkout['shipments'] as $key => $shipment): ?>
                <div class="productincart">
                    <div class="box">
                        <h8><span class="block">สินค้าของร้าน : <span class="redfont"><?php echo HTML::entities($shipment['vendor_name']); ?></span></span></h8>
                        <h7><span class="block"><?php echo HTML::entities($shipment['items_count']); ?> <?php echo HTML::entities(__plural('pc', $shipment['items_count'])); ?></span></h7>
                        <div class="clear"></div>
                    </div>
                    <?php foreach ($shipment['items'] as $item): ?>
                        <div class="box inventory-<?php echo $item['inventory_id']; ?>">
                            <div class="product_info">
                                <div class="product">
                                    <div class="product_pic">
                                        <img alt="<?php echo HTML::entities($item['name']); ?>" src="<?php echo $item['thumbnail']; ?>" border="0" />
                                    </div>
                                    <div class="product_name"><?php echo HTML::entities($item['name']); ?></div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="deleteproduct">
                                <a href="javascript:void(0);" class="btn-delete"  data-inventory_id="<?php echo $item['inventory_id']; ?>" >
                                    <img src="<?php echo Theme::asset()->usePath()->url('images/icodelete.png') ?>" width="16" style="padding:0px 5px 0px 0px;" border="0"/>
                                    ลบรายการ
                                </a>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="numofproduct inventory-<?php echo $item['inventory_id']; ?>">
                            <div class="productprice">
                                <h8><?php echo __('price per piece'); ?></h8>
                                <?php
                                if ($item['discount'] == 0 || $item['discount'] == null):
                                    echo '<div class="pricep text-red">' . HTML::entities(price_format($item['price'], null, 2)) . '</div>';
                                else:
                                    echo '<div class="pricep text-red"><sup>' . HTML::entities(price_format($item['price'], null, 2)) . '</sup>'
                                    . HTML::entities(price_format($item['price'] - $item['discount'], null, 2)) . '</div>';
                                endif;
                                ?>
                                <div class="clear"></div>
                            </div>
                            <div class="sum">
                                <h8><?php echo __('items'); ?></h8>
                                <div class="qty forms-sum left"><input name="items[<?php echo $item['inventory_id']; ?>]" type="text" value="<?php echo $item['quantity']; ?>"/></div>
                                <div class="clear"></div>
                            </div>
                            <div class="cal">
                                <button class="btn-gray-l" type="submit" style="width:90%; margin-left:10px; text-align:center; padding:0; float:none;">
                                    <?php echo __('Re-Calculate'); ?>
                                </button>
                            </div>
                            <div class="clear"></div>
                        </div>
                    <?php endforeach; ?>

                    <div class="box">
                        <div class="totalprice">
                            <?php if ($shipment['discount'] == 0 || is_null($shipment['discount'])): ?>
                                <div class="totalprice_pos"><?php echo HTML::entities(price_format($shipment['total_price'], null, 2)); ?></div>
                            <?php else: ?>
                                <div class="totalprice_pos">
                                    <sup><?php echo HTML::entities(price_format($shipment['total_price'], null, 2)); ?></sup>
                                    <?php echo HTML::entities(price_format($shipment['sub_total'], null, 2)); ?>
                                </div>
                            <?php endif; ?>
                            <div class="totalprice_txt">
                                <h8><?php echo __('Total Amount'); ?></h8>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <p><?php echo __('Select Shipping Method'); ?> :</p>
                        <div class="forms-st">
                            <select class="select-shipping-method" name="shipments[<?php echo $key; ?>]" data-shipment="<?php echo $key; ?>">
                                <option value="0">กรุณากรอกที่อยู่ให้ครบถ้วน</option>
                            </select>

                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </form>


        <?php if ($isLoggedin && isset($checkout['type']) && $checkout['type'] == 'normal' && $is_line != true): ?>
            <div class="coupon">
                <div class="whitebox">
                    <p>ใช้คูปองส่วนลด หรือคูปองเงินสด (Cash voucher) :</p>
                    <form action="<?php echo route("checkout.apply-coupon"); ?>" method="post" id="form-coupon">
                        <div class="forms-st">
                            <div style=" width:59%; float:left;">
                                <input type="text" name="code" id="vcode" placeholder="รหัสคูปองส่วนลด หรือคูปองเงินสด"/>
                            </div>
                            <div style="width:38%; float:left;">
                                <!--<button class="btn-gray-l" style="width:100%; margin-left:10px; text-align:center; padding:0; float:none;">ใช้คูปอง</button>-->
                                <input type="submit" class="btn-gray-l" style="width:100%; margin-left:10px; text-align:center; padding:0; float:none;" value="ใช้คูปอง">
                            </div>
                            <div class="clear"></div>
                        </div>
                    </form>
                    <div id="coupon_error" class="all_error" style="display:none;">
                        <div class="error-box">
                            <div id="register_error_msg" class="error_msg all_register_error_msg" style="color:red; text-align: center;"></div>
                        </div>
                    </div>
                    <?php foreach ($checkout['promotions'] as $promotion): ?>
                        <?php if (empty($promotion['code'])) continue; ?>
                        <div class="coupon-msg">
                            <span class="close-box remove-coupon" data-code="<?php echo $promotion['code']; ?>">x</span>
                            <?php echo HTML::entities($promotion['name']); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        <div style=" padding:20px 0px 10px 0px;">
            <div style="width:50%; float:left;">
                <div style="padding-right:5px;">
                    <button class=" btn-orange-l" style="width:100%; margin:0; padding:0; float:none;"
                            onclick="location.href = '<?php echo route("home"); ?>';">เลือกสินค้าเพิ่ม
                    </button>
                </div>
            </div>
            <div style="width:50%; float:left;">
                <div style="padding-left:5px;">
                    <button class="btn-blue-l btn-next" style="width:100%; margin:0; padding:0; float:none;">
                        ดำเนินการต่อ
                    </button>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>

</div>

<script>
    var provinces = eval(<?php echo json_encode($provinces); ?>);
    var Checkout = Checkout || {};
    Checkout.data = eval(<?php echo json_encode($checkout); ?>);
    var Customer = Customer || {};
    Customer.addresses = eval(<?php echo json_encode($addresses); ?>);
    var siteUrl = "<?php echo route("home"); ?>"
</script>
