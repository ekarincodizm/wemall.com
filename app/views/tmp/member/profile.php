<div class="content-home sub">
    <div id="wrapper_content">
        <div id="container">
            <!--Start container-->
            <div id="block_checkout">
                <div id="checkout_main">

                        <!--start checkout_main-->
                        <div id="checkout_center">
                            <div id="checkout_menu">
                                <!--start checkout_menu-->
                                <div class="bigheadline"><b>ข้อมูลส่วนตัว</b></div>
                                <div class="bottom_line"></div>
                                <div class="g_info"><div class="headline"></div></div>
                                <div class="welcome"><b>ยินดีต้อนรับ คุณ</b><br>
                                <?php  echo $user['display_name']; ?>
                                </div>
                                <div id="cardtype">
                                    <?php if (isset($card)) : ?>
                                    <img src="<?php echo Theme::asset()->url('images/true'.$card.'card.jpg'); ?>" class="middle img_card_type">
                                    Red Card Previlage
                                    <?php endif; ?>
                                </div>
                                <div class="topic headline">เข้าใช้งานล่าสุด : </div>

                                <div>
                                    <?php   
                                            echo $lastlogin; 
                                    ?>
                                 </div>

                                <div class="liststep">
                                    <!--start liststep-->
                                    <div class="bottom_line"></div>
                                    <div id="ic_checkout_here_current">
                                        <div class="headline">
                                            <a href="<?php echo URL::to('member/profile'); ?>" title="ข้อมูลส่วนตัว">ข้อมูลส่วนตัว</a>
                                        </div>
                                    </div>

                                    <div class="bottom_line"></div>
                                    <div id="ic_checkout_here">
                                        <div class="headline_light">
                                            <a href="<?php echo URL::to('checkout'); ?>" title="Checkotu Order">สินค้ารอการชำระเงิน</a>
                                        </div>
                                    </div>
                                    <div class="bottom_line"></div>

                                    <div id="ic_ordertrack">
                                        <div class="headline_light">
                                            <a href="<?php echo URL::to('member/orders'); ?>" title="ตรวจสอบสถานะการจัดส่ง">ตรวจสอบสถานะการชำระเงิน และการจัดส่ง</a>
                                        </div>
                                    </div>
                                    
                                    <div class="bottom_line"></div>
                                </div>
                                <!--end checkout_menu-->

                            </div>

                                <div id="checkout_detail">
                                    <div class="headline_maincheckout" style="width:320px;">ข้อมูลส่วนตัว</div>
                                    <div class="clear"></div>
                                    <div class="line_mainbar_checkout"></div>

                                    <!--- Container -->
    
                                    <div id="checkout_detail2">
                                        <div id="detail" class="brd-btm">
                                            <div class="col-left topic-box">รายละเอียด</div>
                                            <div class="col-right">
                                            </div>
                                            <br class="clearfix">
                                            <div id="detail-form">
                                                <label>ชื่อผู้ใช้งาน : </label>
                                                <span class="text-red"><?php echo $user['display_name']; ?></span>
                                                <label>ชื่อเต็ม : </label>
                                                <span class="text-red"><?php echo $user['display_name']; ?></span>
                                                <label>อีเมล์ : </label>
                                                <span class="text-red"><?php echo $user['email']; ?></span>
                                            </div>
                                        </div>

                                        <div id="id-card">
                                            
                                            <?php //sd(Session::all()); ?>
                                            <div id="id-card-confirm" style="display:none;">
                                                <p id="your_id_card_number">xxxxxxxxxxx</p>
                                                <p>คุณต้องการใช้เลขที่บัตรประชาชนนี้รับสิทธิ ใช่หรือไม่คะ ?</p>
                                                <img src="http://www.itruemart.com/assets/itruemart_new/global/images/trueyou/ajax-loader.gif" alt="Loading" class="verify-loading">
                                                <input type="button" name="confirm-button" id="confirm-button" value="ยืนยัน"> &nbsp;&nbsp;
                                                <input type="button" name="cancel-button" id="cancel-button" value="ยกเลิก">
                                            </div>

                                            <?php if ($checked == 0) : ?>
                                            <form name="myForm" id="myForm" action="<?php echo URL::to('/member/check-id-card'); ?>" method="post" accept-charset="utf-8">
                                            <div id="id-card-form">
                                                <p>ลูกค้า <span class="text-red">True You</span>
                                                กรอกเลขที่บัตรประชาชนเพื่อรับสิทธิพิเศษ</p>
                                                <p>เลขที่บัตรประชาชน (13 หลัก) :
                                                    <input type="text" name="id_card" id="id_card" placeholder="เลขที่บัตรประชาชน" value="" title="กรุณากรอกเลขที่บัตรประชาชนค่ะ" maxlength="13" />
                                                </p>
                                                    <input type="button" class="btn-id-card"  value="ตรวจสอบสิทธิ">
                                            </div>
                                            </form>
                                            <?php endif; ?>
                                            
                                            <?php if ($checked == 1) : ?>
                                            <div id="id-card-verified">
                                            <img src="<?php echo Theme::asset()->url('images/true'.$user['trueyou'].'card.jpg'); ?>" class="middle img_card_type">
                                                &nbsp; <em style="font-style:normal;">เลขที่บัตรประชาชน</em>
                                                <span class="id_card_number"><?php echo $user['thai_id']; ?></span>
                                            </div>
                                            <?php endif; ?>

                                        </div>
                                        <div class="brd-btm mrg-btm2"></div>
                                        <div class="col-left topic-box">ที่อยู่ในการจัดส่ง</div>
                                        <form action="<?php echo URL::to('member/profile'); ?>" method="post" accept-charset="utf-8" id="address-form">    <div class="col-left addr-list-box">
                                                <select name="shipping_address_list" id="shipping_address_list" autocomplete="off">
                                                    <option value=""> ------- เพิ่มที่อยู่ใหม่ ------ </option>
                                                    <?php foreach ($addresses['data'] as $address): ?>
                                                    <option value="<?php echo $address['id']; ?>"><?php echo $address['text']?></option>
                                                    <?php endforeach; ?>
                                                </select><br>
                                            </div>
                                            <br class="clearfix">
                                            <div id="addr-detail" class="brd-btm">
                                                <div id="addr-form">
                                                    <label>
                                                        ชื่อ : 
                                                    </label>
                                                    <input type="text" name="name" value="" id="shipping_fullname"><br>

                                                    <label>
                                                        จังหวัด : 
                                                    </label>
                                                    <?php echo Form::select('province_id', $provinceOptions, null, array('id' => 'shipping_province_code')); ?><br>

                                                    <label>
                                                        เขต/อำเภอ : 
                                                    </label>
                                                    <?php echo Form::select('city_id', $cityOptions, null, array('id' => 'shipping_city_code')); ?><br>

                                                    <label>
                                                        แขวง/ตำบล : 
                                                    </label>
                                                    <?php echo Form::select('district_id', $districtOptions, null, array('id' => 'shipping_district_code')); ?><br>

                                                    <label>
                                                        ที่อยู่ : 
                                                    </label>
                                                    <input type="text" name="address" value="" id="shipping_address"><br>

                                                    <label>
                                                        รหัสไปรษณีย์ : 
                                                    </label>
                                                    <input type="text" name="postcode" value="" id="shipping_postcode" maxlength="100" size="50"><br>

                                                    <label>
                                                        เบอร์โทร : 
                                                    </label>
                                                    <input type="text" name="phone" value="" id="shipping_phone"><br>
                                                    <label>
                                                        Email : 
                                                    </label>
                                                    <input type="text" name="email" value="" id="shipping_email"><br>
                                                    <div class="submit-pnl">
                                                        <input type="button" id="submit_addr" class="btn-id-card" value="บันทึกข้อมูล">
                                                    </div>
                                                    <input type="hidden" name="is_save" value="Y">

                                                </div>
                                            </div>
                                        </form>                     

                                    </div>
                                </div>
                                <!--- Container --->
                                <div class="clear"></div>
                            </div>                  

                        </div>
                        <div class="clear"></div>
                    </div>

                    <!--end checkout_main -->
                    <div class="clear"></div>
                    <div style="margin-top:10px;"></div>
                </div>


                        </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div id="profile-dialog" class="reveal-modal">
    <div class="font2 msg-header">ไม่สามารถนำสินค้าชิ้นนี้ใส่ตะกร้าได้</div>
    <div id="popup_content">
        <div id="popup_message">
            <dl class="detail-cart">
                <dt>สินค้า</dt>
            </dl>
            <div class="clearfix"></div>
        </div>
        <div id="popup_panel">
            <input type="button" class="popup_ok btn cart-installment-button cart-installment-button_cancel" value="ยกเลิก">
        </div>
    </div>
</div>

<div id="alert-dialog" class="reveal-modal">
    <div class="font2 msg-header text-center alert-title"></div>
    <div id="popup_message" class="alert-message"></div>
    <div id="popup_panel">
        <input type="button" class="popup_ok btn btn-success" value="ตกลง">
    </div>
</div>

<script>

    var Member = Member || {};
    Member.addresses = eval(<?php echo json_encode($addresses)?>);

</script>
