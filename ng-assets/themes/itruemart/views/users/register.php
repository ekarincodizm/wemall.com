<div class="content-home sub">
    <div id="wrapper_content">
        <div id="login_regist_wrapper">
            <div class="title_login"><?php echo __('register-true-id'); ?></div>
            <div class="detail_wrapper" style="padding-bottom: 30px;">
                <div id="register_main">
                    <div id="register_main_left" class="float-left">
                        <div id="register_tab_wrapper" class="float-left">

                            <div class="registmail<?php echo (App::getLocale()=='en') ? '_en' : ''  ?> active"></div>
                            <a rel="register_email" class="registmail<?php echo (App::getLocale()=='en') ? '_en' : ''  ?>" style="cursor:pointer; display:none;"></a>
                            <!--<div class="registmobile<?php /*echo (App::getLocale()=='en') ? '_en' : ''  */?> active" style="display:none;"></div>
                            <a rel="register_mobile" class="registmobile<?php /*echo (App::getLocale()=='en') ? '_en' : ''  */?>" style="cursor:pointer;"></a>-->

                        </div>
                        <form name="formRegister" id="formRegister" method="post" autocomplete="off" action="<?php echo URL::route('users.register') ?>">

                            <input type="hidden" name="register_channel" id="register_channel" value="email">
                            <input type="hidden" name="continue" value="<?php echo $continue; ?>">
                            <div id="register_main_left_c" class="float-left">
                                <div class="register_email">
                                    <table>
                                        <tbody><tr>
                                                <td valign="top" class="register_label"><?php echo __('true-id'); ?> : <span style="color:red">*</span></td>
                                                <td> <span class="watermark_container" style="display: inline-block; position: relative;"><span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;"><?php echo __('email'); ?></span><input type="text" name="email_username" id="email_username" size="35" maxlength="60" class="jq_watermark register_field" data-jq-watermark="processed"></span><br><div class="register_validate text-right"><a href="javascript:registerCheckEmail(document.getElementById('email_username'))" name="velify_email"><?php echo __('check-email'); ?></a></div></td>
                                            </tr>
                                            <tr>
                                                <td class="register_label"><?php echo __('display_name'); ?> : <span style="color:red">*</span></td>
                                                <td><span class="watermark_container" style="display: inline-block; position: relative;"><span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;"><?php echo __('Name'); ?></span><input type="text" name="email_display_name" id="email_display_name" size="35" maxlength="20" class="jq_watermark register_field" data-jq-watermark="processed"></span></td>
                                            </tr>
                                            <tr>
                                                <td class="register_label"><?php echo __('password'); ?> : <span style="color:red">*</span></td>
                                                <td><span class="watermark_container" style="display: inline-block; position: relative;"><span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;"><?php echo __('password'); ?></span><input type="password" name="email_password" id="email_password" size="35" maxlength="16" class="jq_watermark register_field" data-jq-watermark="processed"></span></td>
                                            </tr>
                                            <tr>
                                                <td class="register_label"><?php echo __('confirm-password'); ?> : <span style="color:red">*</span></td>
                                                <td><span class="watermark_container" style="display: inline-block; position: relative;"><span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;"><?php echo __('confirm-password'); ?></span><input type="password" name="email_password_confirmation" id="email_confirm_password" size="35" maxlength="16" class="jq_watermark register_field" data-jq-watermark="processed"></span></td>
                                            </tr>
                                            <tr>
<!--                                                <td class="register_label">--><?php //echo __('thai-id'); ?><!--</td>-->
<!--                                                <td>-->
<!--                                                    <span class="watermark_container" style="display: inline-block; position: relative;"><span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;">--><?php //echo __('thai-id'); ?><!--</span><input type="text" name="email_thai_id" id="email_idcard" class="jq_watermark register_field is_numeric" maxlength="13" size="35" data-jq-watermark="processed"></span>-->
<!--                                                </td>-->
                                            </tr>
                                            <tr>
                                                <td class="register_label" colspan="2">
                                                    <span style="color:red; font-size:11spx; width:50px;">ลูกค้า True You กรอกบัตรประชาชน เพื่อรับสิทธิ์พิเศษ</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="register_mobile" style="display:none;">
                                    <table id="mobile_step1" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td class="register_label"><?php echo __('true-id'); ?> : <span style="color:red">*</span></td>
                                                <td id="mobile1"><span class="watermark_container" style="display: inline-block; position: relative;"><span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;"><?php echo __('mobile-number'); ?></span><input type="text" name="mobile_username" id="mobile_username" class="jq_watermark register_field is_numeric" maxlength="10" size="35" data-jq-watermark="processed"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="register_label">&nbsp;</td>
                                                <td><a href="javascript:registerRequestOtp(document.getElementById('mobile_username'))" name="get_otp_password" class="regist_otp"><?php echo __('please-request-otp-via'); ?></a></td>
                                            </tr>
                                            <tr>
                                                <td class="register_label">&nbsp;</td>
                                                <td><span class="watermark_container" style="display: inline-block; position: relative;"><span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;"><?php echo __('please-request-otp-via'); ?></span><input type="text" name="mobile_otp_password" id="mobile_otp_password" size="35" maxlength="5" class="jq_watermark register_field" data-jq-watermark="processed"></span></td>
                                            </tr>
                                            <tr>
                                                <td class="register_label">&nbsp;</td>
                                                <td><a href="javascript:registerValidateOtp(document.getElementById('mobile_username'), document.getElementById('mobile_otp_password'))" name="confirm_otp" class="regist_otp"><?php echo __('confirm'); ?></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table id="mobile_step2" cellspacing="0" cellpadding="0" style="display:none;">
                                        <tbody>
                                            <tr>
                                                <td class="register_label"><?php echo __('email'); ?> : <span style="color:red">*</span></td>
                                                <td><span id="show_mobile_number"></span></td>
                                            </tr>
                                            <tr>
                                                <td class="register_label"><?php echo __('thai-id'); ?> </td>
                                                <td><span class="watermark_container" style="display: inline-block; position: relative;"><span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;"><?php echo __('thai-id'); ?></span><input type="text" name="mobile_thai_id" id="mobile_idcard" class="jq_watermark register_field is_numeric" maxlength="13" size="35" data-jq-watermark="processed"></span></td>
                                            </tr>
                                            <tr>
                                                <td class="register_label"><?php echo __('password'); ?> : <span style="color:red">*</span></td>
                                                <td><span class="watermark_container" style="display: inline-block; position: relative;"><span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;"><?php echo __('password'); ?></span><input type="password" name="mobile_password" id="mobile_password" class="jq_watermark register_field is_numeric" maxlength="16" size="35" data-jq-watermark="processed"></span></td>
                                            </tr>
                                            <tr>
                                                <td class="register_label"><?php echo __('confirm-password'); ?> : <span style="color:red">*</span></td>
                                                <td><span class="watermark_container" style="display: inline-block; position: relative;"><span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;"><?php echo __('confirm-password'); ?></span><input type="password" name="mobile_password_confirmation" id="mobile_confirm_password" class="jq_watermark register_field is_numeric" maxlength="16" size="35" data-jq-watermark="processed"></span></td>
                                            </tr>
                                            <tr>
                                                <td class="register_label">&nbsp;</td>
                                                <td><input name="mobile_subscribe" type="checkbox" id="mobile_enews" value="Y"> <?php echo __('subscibe_e_new');?> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <?php echo Form::token() ?>
                                <input type="submit" style="display:none;">
                            </div>
                            <div class="clear"></div>
                            <a href="#!" name="btn_register" class="btn_regist float-right" style="display:none">
                                
                                <?php if ( App::getLocale() == 'th' ) : ?>
                                    <img src="<?php echo Theme::asset()->url('images/profile/btn_register_th.png'); ?>" alt="" width="160" height="41">
                                <?php else: ?>
                                    <img src="<?php echo Theme::asset()->url('images/profile/btn_register_en.png'); ?>" alt="" width="160" height="41">
                                <?php endif; ?>

                            </a>
                        </form>
                    </div>
                    <div id="register_main_right" class="float-left">
                        <div class="register_main_title"><?php echo __('term-condition'); ?></div>
                        <div id="register_main_right_c">
                            <p>บริษัท ทรู ดิจิตอล คอนเท้นท์ แอนด์ มีเดีย จำกัด ("บริษัท") ยินดีต้อนรับท่านเข้าสู่บริการต่างๆ ในเว็บไซต์ TrueLife ซึ่งได้แก่ สร้างบ้านในฝัน (miniHOME) บริการดูข่าวสาร ข้อมูลต่างๆ บริการแสดงความคิดเห็นในกระทู้ และบริการอื่นๆ เพื่อบริการแก่สมาชิก (ต่อไปนี้จะรวมเรียกว่า "บริการ") <br>
                                หากท่านประสงค์จะใช้บริการใดๆ ของ TrueLife โปรดกดปุ่ม "ตกลง" หลังจากท่านกดปุ่ม "ตกลง" หากท่านประสงค์จะใช้บริการใดๆ ในเว็บไซต์ TrueLife ท่านตกลงจะปฏิบัติตามข้อกำหนดและเงื่อนไขทั่วไป ดังนี้<br>
                            </p>
                            <ul>
                                <li>การสมัครสมาชิก<br>
                                    หากท่านประสงค์จะใช้บริการใดๆ ใน TrueLife ท่านจะต้องสมัครเป็นสมาชิกโดยกดปุ่ม "สมัครสมาชิก" และกรอกข้อมูลต่างๆ ของท่านลงในใบสมัคร ท่านไม่ต้องเสียค่าธรรมเนียมหรือค่าแรกเข้าแต่อย่างใดทั้งสิ้น หลังจากบริษัทรับใบสมัครที่ท่านกรอกข้อความครบถ้วนแล้ว บริษัทจะส่ง e-mail ไปยังท่าน ท่านสามารถใช้บริการใดๆ ตามประสงค์ของท่านใน TrueLife หลังจากบริษัทได้รับการตอบรับยืนยันจากท่านในการเป็นสมาชิก โดยทาง e-mail (ต่อไปในข้อกำหนดและเงื่อนไขนี้จะเรียกท่านว่า "สมาชิก")</li>
                                <li>ระยะเวลาการเป็นสมาชิก<br>
                                    สมาชิกมีสิทธิใช้บริการใดๆ ใน TrueLife นับแต่วันที่ท่านเป็นสมาชิกตามข้อ 1. และสถานะการเป็นสมาชิกมีผลอยู่ตลอดไปจนกว่าท่านบอกเลิกการเป็นสมาชิก โดยการกดปุ่ม "ยกเลิก" หรือบริษัทยกเลิกการเป็นสมาชิกอันเนื่องจากสมาชิกไม่ปฏิบัติหรือปฏิบัติผิดข้อกำหนดหรือเงื่อนไขข้อใดข้อหนึ่งที่กำหนดไว้ใน "ข้อกำหนดและเงื่อนไขทั่วไป"</li>
                                <li>    การชำระค่าบริการ<br>
                                    สมาชิกจะชำระบริการตามอัตราที่บริษัทกำหนดหรือที่จะมีการเปลี่ยนแปลงโดยบริษัทจะแจ้งให้สามารถผ่านเว็บไซต์ TrueLife สมาชิกสามารถชำระค่าบริการผ่านระบบที่บริษัทจัดหาให้<br>
                                </li>
                                <li>คำรับรองของสมาชิก<br>
                                    สมาชิกให้คำรับรอง ดังนี้
                                    <ul>
                                        <li> สมาชิกรับทราบว่าการให้ข้อมูลตามที่ระบุไว้ในใบสมัครเพื่อประโยชน์ที่จะได้รับสิทธิพิเศษต่างๆ ตามที่บริษัทจะแจ้งให้ทราบเป็นคราวๆ ไป ข้อมูลใดๆ ที่ได้ให้แก่บริษัทตามที่ระบุไว้ในสมัครสมาชิกเป็นจริงทุกประการ สมาชิกยินยอมให้บริษัทตรวจสอบความเป็นจริงและถูกต้องของข้อมูลได้ หากการตรวจสอบพบว่าข้อมูลที่ให้ไม่ตรงกับความจริง บริษัทมีสิทธิยกเลิกสมาชิกภาพและ/หรือการให้บริการ TrueLife ได้    </li>
                                        <li>สมาชิกจะใช้บริการ TrueLife ด้วยตนเองและจะรักษารหัสประจำตัว (ID) และรหัสผ่าน (password) ที่ได้รับจากบริษัทเพื่อการใช้บริการใน TrueLife ไว้เป็นความลับ สมาชิกจะไม่เปิดเผยหรือให้บุคคลใดใช้ ID และ password ของสมาชิกเพื่อใช้บริการ TrueLife สมาชิกตกลงรับผิดชอบชำระค่าบริการหากมีบุคคลใดล่วงรู้หรือใช้ ID และ password ของสมาชิกเพื่อใช้บริการ TrueLife ไม่ว่าสมาชิกจะให้หรือไม่ให้ความยินยอมก็ตาม</li>
                                        <li>ที่สมาชิกจะส่ง แสดง หรือเปิดเผยผ่านการใช้บริการใด ใน TrueLife ต้องไม่มีลักษณะดังนี้
                                            <ul>
                                                <li>ห้ามส่งข้อความหรือเนื้อหา ที่เป็นการวิพากษ์วิจารณ์ หรือ พาดพิงสถาบันพระมหากษัตริย์ ราชวงศ์ ศาสนา ตลอดจนถึงความมั่นคงของชาติ เป็นอันขาด</li>
                                                <li>หยาบ เสียดสี ไม่สุภาพ หรือไม่เหมาะสมด้วยประการใดๆ หรือเป็นเท็จ หรือส่อนัยทางเพศ หรืออาจก่อให้เกิดความขัดแย้ง</li>
                                                <li>อาจสร้างความเสื่อมเสียหรือเสียหายต่อบริษัท หรือสมาชิกอื่น และ/หรือบุคคลอื่นๆ</li>
                                                <li>อาจก่อให้เกิดความเดือดร้อนรำคาญแก่สมาชิกอื่น</li>
                                                <li>ละเมิดลิขสิทธิ์ ทรัพย์สินทางปัญญาอื่นๆ และ/หรือสิทธิของบริษัท และ/หรือบุคคลใด</li>
                                                <li>มีการกระทำการใดๆ อันเป็นการละเมิดสิทธิส่วนบุคคลของสมาชิกรายอื่นหรือบุคคลอื่น</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="accept_condition_box">
                            <input id="accept" value="checkbox" type="checkbox" name="accept"> <?php echo __('accept-term'); ?>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div id="register_loading" style="padding-left:450px; display:none;">
                    <div style="float:left;"></div>
                    <div style="color:#CCC; font-size:10px; padding-left:5px; padding-top:5px; float:left;">Loading...</div>
                </div>
                <div id="register_error_msg" style="font-size: 12px;" class="error_msg"></div>
            </div>
        </div>
    </div>
</div>

<div id="register-alert" class="reveal-modal">
    <div class="font2 msg-header text-center alert-title"></div>
    <div id="popup_message" class="alert-message"></div>
    <div id="popup_panel">
        <input type="button" class="popup_ok btn btn-success" value="<?php echo __('ok'); ?>">
    </div>
</div>




<!-- <div class="content-home sub">
    <div id="wrapper_content">
        <h1><?php echo __('Register via Email'); ?></h1>
        <?php echo Form::open(array('url' => URL::route('users.register', array('type' => 'email')))); ?>
            <p>Email: <?php echo Form::text('email'); ?></p>
            <p>Name: <?php echo Form::text('display_name'); ?></p>
            <p>Password: <?php echo Form::text('password'); ?></p>
            <p>Confirm Password: <?php echo Form::text('password_confirmation'); ?></p>
            <p>Thai ID: <?php echo Form::text('thai_id'); ?></p>
            <p><?php echo Form::submit(); ?>
        <?php echo Form::close(); ?>
        </p>

        <hr />

        <h1><?php echo __('Register via Mobile'); ?></h1>
        <?php echo Form::open(array('url' => URL::route('users.register', array('type' => 'mobile')))); ?>

            <?php if ( ! Session::get('otp-passes')) : ?>
            <div id="register-step-1">
                <p>Mobile: <?php echo Form::text('mobile', null, array('id' => 'mobile')); ?></p>
                <a href="javascript:registerRequestOtp(document.getElementById('mobile'));">Request otp</a>
                <p>OTP: <?php echo Form::text('otp', null, array('id' => 'otp')); ?></p>
                <a href="javascript:registerValidateOtp(document.getElementById('mobile'), document.getElementById('otp'));">Confirm</a>
            </div>
            <?php endif; ?>


            <div id="register-step-2" style="display:<?php echo Session::get('otp-passes') ? 'block' : 'none'; ?>">
                <p>
                    Mobile: <span id="mobile-display"><?php echo Session::get('otp-passes'); ?></span>
                </p>
                <p>
                    Thai ID: <?php echo Form::text('thai_id'); ?></p>
                </p>
                <p>Password: <?php echo Form::text('password'); ?></p>
                <p>
                    <p>Confirm Password: <?php echo Form::text('password_confirmation'); ?></p>
                </p>
                <p><?php echo Form::submit(); ?>
            </div>

        <?php echo Form::close(); ?>
        </p>
    </div>

</div> -->