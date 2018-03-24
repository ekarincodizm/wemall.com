<div class="review" style="background-color:#f2f2f2;">
    <div style="padding:0 10px 20px 10px;">
        <div class="all-banner"  style=" border-bottom:1px solid #CCC; background-color:#FFF; -webkit-border-radius: 4px; -moz-border-radius: 4px;">
            <div class="menu-regis">
                <ul>
                    <li id="emailtab" class="active-left"><div><a href="#" onclick="$('#st-email').show();$('#st-detail').hide();$('#st-mobile').hide();$('#mobiletab').removeClass();$('#emailtab').addClass('active-right');$('#register_channel').val('email');$('.all_error').hide();">สมัครด้วยอีเมล์</a></div></li>
                    <li id="mobiletab"><div><a href="#" onclick="($('#st-mobile').length > 0)?$('#st-mobile').show():$('#st-detail').show();$('#st-email').hide();$('#emailtab').removeClass();$('#mobiletab').addClass('active-right');$('#register_channel').val('mobile');$('.all_error').hide();">สมัครด้วยเบอร์มือถือ</a></div></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>

            <form name="formRegister" id="formRegister" method="post" autocomplete="off" action="<?php echo URL::route('users.register') ?>">
                <input type="hidden" name="register_channel" id="register_channel" value="email">
                <input type="hidden" name="continue" value="<?php echo $continue; ?>">			

                <!-- [S] Register by E-mail -->
                <div class="form-login" id="st-email">
                    <div class="forms-st">
                        <p><?php echo trans('register.username'); ?> <span class="red-mark">*</span> :</p>
                        <input type="text" name="email_username" id="email_username" maxlength="60" placeholder="<?php echo trans('register.email'); ?>">
                        <p><?php echo trans('register.displayname'); ?> <span class="red-mark">*</span> :</p>
                        <input type="text" name="email_display_name" id="email_display_name" maxlength="20" placeholder="<?php echo trans('register.displayname'); ?>">
                        <p><?php echo trans('register.password'); ?> <span class="red-mark">*</span> :</p>
                        <input type="password" name="email_password" id="email_password" maxlength="16" placeholder="<?php echo trans('register.password'); ?>">
                        <p><?php echo trans('register.confirm_password'); ?> <span class="red-mark">*</span> :</p>
                        <input type="password" name="email_password_confirmation" id="email_confirm_password" maxlength="16" placeholder="<?php echo trans('register.password'); ?>">
                        <p><?php echo trans('register.thaiid'); ?> :</p>
<!--                        <input type="text" name="email_thai_id" id="email_thai_id" maxlength="13" placeholder="--><?php //echo trans('register.thaiid'); ?><!--">-->
                    </div>

                    <div style="padding:10px 0px 10px 0px;">
                        <div style="width:100%; margin-left:auto; margin-right:auto; padding:10px 0px; border:1px solid #f2f2f2; -webkit-border-radius: 4px;-moz-border-radius: 4px;">
                            <div style="float:left; padding:5px 10px;">
                                <input id="email_accept" value="1" type="checkbox" name="accept">ยอมรับเงือนไข
                                <a class="regis-notice" style="text-decoration:underline;" href="javascript:;">ข้อตกลงการให้บริการ</a>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>

                    <div id="error" class="all_error">
                        <div class="error-box">
                            <div id="register_error_msg" class="error_msg all_register_error_msg" style="color:red; text-align:center;"></div>
                        </div>
                    </div>

                    <div style=" padding:15px 0px;">
                        <button name="btn_register" class="btn-blue-l" style="width:100%; margin:0; padding:0; float:none;">สมัครทรูไอดี</button>
                    </div>

                    <div class="clear"></div>         
                </div>
                <!-- [E] Register by E-mail -->

                <!-- [S] Register by Mobile -->
                <div class="form-login" id="st-mobile" style="display:none;">
                    <div class="forms-st">
                        <p>ทรูไอดี (Username) <span class="red-mark">*</span> :</p>
                        <input name="mobile_username" id="mobile_username" type="text" placeholder="เบอร์มือถือ (ทรูมูฟ/ทรูมูฟเอช)"  />
                        <div style=" padding:20px 0px 10px 0px;">
                            <button class="btn-gray-l" onclick="javascript:registerRequestOtp(document.getElementById('mobile_username')); return false;" style="width:100%; margin:0; padding:0; float:none;">ขอรหัสผ่านจาก SMS</button>
                        </div>

                        <p>OTP <span class="red-mark">*</span> :</p>
                        <input name="mobile_otp_password" id="mobile_otp_password" type="text" placeholder="รหัสผ่านจาก SMS"  />
                        <div style=" padding:20px 0px 10px 0px;">
                            <button class="btn-gray-l" style="width:100%; margin:0; padding:0; float:none;" onclick="javascript:registerValidateOtp(document.getElementById('mobile_username'), document.getElementById('mobile_otp_password')); return false;">
                                ยืนยัน
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-login" id="st-detail">
                    <div class="forms-st">
                        <p>ทรูไอดี (Username) :</p>
                        <input name="mobile_username" id="show_mobile_number" type="text" value="" disabled="disabled" class="disabled"  />
                        <p>ชื่อที่ใช้ในการแสดง <span class="red-mark">*</span>:</p>
                        <input name="mobile_display_name" type="text" maxlength="20" placeholder="<?php echo trans('register.displayname'); ?>" />
                        <p>รหัสผ่าน <span class="red-mark">*</span>:</p>
                        <input name="mobile_password" type="password" maxlength="16"  placeholder="<?php echo trans('register.password'); ?>" />
                        <p>ยืนยันรหัสผ่าน <span class="red-mark">*</span> :</p>
                        <input name="mobile_password_confirmation" type="password" maxlength="16"  placeholder="<?php echo trans('register.password'); ?>" />
                        <p>หมายเลขบัตรประชาชน :</p>
                        <input name="mobile_thai_id" type="text" maxlength="13" placeholder="<?php echo trans('register.thaiid'); ?>"/>
                    </div>
                    <div style="padding:10px 0px 10px 0px;">
                        <div style="width:100%; margin-left:auto; margin-right:auto; padding:10px 0px; border:1px solid #f2f2f2; -webkit-border-radius: 4px;-moz-border-radius: 4px;">
                            <div style="float:left; padding:5px 10px;">
                                <input id="mobile_accept" name="accept" type="checkbox" value="1" />ยอมรับเงือนไข 
                                <a class="regis-notice notice" style="text-decoration:underline;" href="javascript:;">ข้อตกลงการให้บริการ</a></div>
                            <div class="clear"></div>
                        </div>
                    </div>   
                    <div id="error" class="all_error">
                        <div class="error-box">
                            <div id="register_error_msg" class="error_msg all_register_error_msg" style="color:red; text-align:center;"></div>
                        </div>
                    </div>
                    <div style=" padding:15px 0px;">
                        <button name="btn_register" class="btn-blue-l" style="width:100%; margin:0; padding:0; float:none;">สมัครทรูไอดี</button>
                    </div>
                    <div class="clear"></div>
                </div>
                <!-- [E] Register by Mobile -->
            </form>					
        </div>
        <div class="clear"></div>
    </div>
</div>

<div id="register_main_right_c" style="display: none;">
    <p>บริษัท ทรู ดิจิตอล คอนเท้นท์ แอนด์ มีเดีย จำกัด ("บริษัท") ยินดีต้อนรับท่านเข้าสู่บริการต่างๆ ในเว็บไซต์ TrueLife ซึ่งได้แก่ สร้างบ้านในฝัน (miniHOME) บริการดูข่าวสาร ข้อมูลต่างๆ บริการแสดงความคิดเห็นในกระทู้ และบริการอื่นๆ เพื่อบริการแก่สมาชิก (ต่อไปนี้จะรวมเรียกว่า "บริการ") <br/>
        หากท่านประสงค์จะใช้บริการใดๆ ของ TrueLife โปรดกดปุ่ม "ตกลง" หลังจากท่านกดปุ่ม "ตกลง" หากท่านประสงค์จะใช้บริการใดๆ ในเว็บไซต์ TrueLife ท่านตกลงจะปฏิบัติตามข้อกำหนดและเงื่อนไขทั่วไป ดังนี้<br/>
    </p>
    <ul>
        <li>การสมัครสมาชิก<br/>
            หากท่านประสงค์จะใช้บริการใดๆ ใน TrueLife ท่านจะต้องสมัครเป็นสมาชิกโดยกดปุ่ม "สมัครสมาชิก" และกรอกข้อมูลต่างๆ ของท่านลงในใบสมัคร ท่านไม่ต้องเสียค่าธรรมเนียมหรือค่าแรกเข้าแต่อย่างใดทั้งสิ้น หลังจากบริษัทรับใบสมัครที่ท่านกรอกข้อความครบถ้วนแล้ว บริษัทจะส่ง e-mail ไปยังท่าน ท่านสามารถใช้บริการใดๆ ตามประสงค์ของท่านใน TrueLife หลังจากบริษัทได้รับการตอบรับยืนยันจากท่านในการเป็นสมาชิก โดยทาง e-mail (ต่อไปในข้อกำหนดและเงื่อนไขนี้จะเรียกท่านว่า "สมาชิก")</li>
        <li>ระยะเวลาการเป็นสมาชิก<br/>
            สมาชิกมีสิทธิใช้บริการใดๆ ใน TrueLife นับแต่วันที่ท่านเป็นสมาชิกตามข้อ 1. และสถานะการเป็นสมาชิกมีผลอยู่ตลอดไปจนกว่าท่านบอกเลิกการเป็นสมาชิก โดยการกดปุ่ม "ยกเลิก" หรือบริษัทยกเลิกการเป็นสมาชิกอันเนื่องจากสมาชิกไม่ปฏิบัติหรือปฏิบัติผิดข้อกำหนดหรือเงื่อนไขข้อใดข้อหนึ่งที่กำหนดไว้ใน "ข้อกำหนดและเงื่อนไขทั่วไป"</li>
        <li>    การชำระค่าบริการ<br/>
            สมาชิกจะชำระบริการตามอัตราที่บริษัทกำหนดหรือที่จะมีการเปลี่ยนแปลงโดยบริษัทจะแจ้งให้สามารถผ่านเว็บไซต์ TrueLife สมาชิกสามารถชำระค่าบริการผ่านระบบที่บริษัทจัดหาให้<br/>
        </li>
        <li>คำรับรองของสมาชิก<br/>
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