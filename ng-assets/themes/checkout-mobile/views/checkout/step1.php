<style>
.icon-success {
	left: 559px;
	position : absolute;
	top: 10px;
}
</style>
<?php if ( ! empty($cart['data']['customer_email'])) : ?>
	<?php
	/*<script type="text/javascript">
		$(function(){
			$('#form-checkout').find('input, select, textarea').each(function(){
				elemId = $(this).attr('name');
				console.log(elemId);
	            if (elemId == "username")
	            {
	                $(this).valid();
	            }
			});
		});
	</script>*/
	?>
<?php endif; ?>
<div id="inc-panel-login-cont">
	<div id="inc-panel-login-type">
		<h2><?php echo __('email-login'); ?></h2>
		<ul>
			<li><input <?php if($type == 'guest'){ echo 'checked'; } ?>
				id="guest" name="logintype"
				data-href="<?php echo URL::toLang('checkout/step1', array(), Config::get("https.useHttps") ); ?>" type="radio"
				value="guest" autocomplete="off"> <label for="guest" class="control-desc"><?php echo __('continue-without-password');?></label>
			</li>
			<li><input <?php if($type == 'user'){ echo 'checked'; } ?> id="user1"
				name="logintype"
				data-href="<?php echo URL::toLang('auth/login', array(), Config::get("https.useHttps")); ?>"
				type="radio" value="user" autocomplete="off"> <label for="user1" class="control-desc"><?php echo __('already-have-account');?></label>
			</li>
		</ul>
	</div>
	<div id="profile">
		<form action="" method="post" id="form-checkout">
			<div id="inc-panel-login">
				<div id="profile_detail">
					<p>
						<label for="email" style="display: none;"><?php echo __('Enter your email address');?>: </label><br>
						<input autocomplete="off" class="input-box form-control" id="username" name="username"
							type="text" placeholder="email@mail.com"
							value="<?php echo !empty($cart['data']['customer_email'])? $cart['data']['customer_email'] : '';?>">
					</p>
					<p>
						<label for="password"><?php echo __('password');?> : </label><br>
						<input class="input-box form-control" maxlength="15" id="password"
							name="password" type="password"
							placeholder="<?php echo __('Enter your password');?>">
					</p>

				</div>
				<div id="forgetpassword_helper">
					<p>
						<a href="<?php echo Url::Route('forgot'); ?>" class="clr-6"><?php echo __('forgot password');?></a>
					</p>
				</div>
			</div>
			<div id="inc-action-box">
				<input type="hidden" name="process" id="process" value="login"> <input
					type="hidden" name="continue" id="redirect"
					value="<?php echo $continue; ?>">
				<?php echo Form::token()?>
				<?php if ($errors->count()) : ?>
					<div class="error_msg red"><?php echo $errors->first(); ?></div>
				<?php endif; ?>
				 <!-- <button class="inc-btn" ><?php echo __('Continue');?></button> -->
				<input class="inc-btn"  id="btnNext" name="" type="submit"
					value="<?php echo __('Continue');?>">
			</div>
		</form>
	</div>
</div>
<div id="inc-action-prev">
	<a href="#"><?php echo __("Back"); ?></a>
</div>
<form name="formRegister" id="formRegister" method="post" autocomplete="off" action="<?php echo URL::toLang('users/register', array(), Config::get("https.useHttps")); ?>">
	<div id="register" class="main_box">
		<input type="hidden" name="register_channel" id="register_channel" value="email">
        <input type="hidden" name="continue" value="<?php echo $continue; ?>">
		<h2 style="cursor:pointer;" id="inc-regist-member"><?php echo __("step1-create-account-title"); ?></h2>
		<div id="inc-panel-register">
			<div class="clear"></div>
			<!-- Register Email -->
			<div id="register_byEmail" class="register_info actived">
				<p> <br> <input type="text" name="email_username" id="email_username" maxlength="60" placeholder="<?php echo trans('register.email'); ?>"></p>
				<div id="checkemail" name="velify_email" onclick="javascript:registerCheckEmail(document.getElementById('email_username'));return false;"><?php echo __("check-email"); ?></div>
				<div id="register_email_error_msg" class="error_msg"></div>
				<div id="register_loading" style="display: none;">
					<div style="float: left;"></div>
					<div style="color: #CCC; text-align: center;">Loading...</div>
				</div>
				<p> <br> <input type="text" name="email_display_name" id="email_display_name" maxlength="20" placeholder="<?php echo trans('register.displayname'); ?>"></p>
				<p> <br> <input type="password" name="email_password" id="email_password" maxlength="25" placeholder="<?php echo trans('register.password'); ?>"></p>
				<p> <br> <input type="password" name="email_password_confirmation" id="email_confirm_password" maxlength="25" placeholder="<?php echo trans('register.password'); ?>">
<!--				<p><br> <input type="text" name="email_thai_id" id="email_thai_id" maxlength="13" placeholder="--><?php //echo trans('register.thaiid'); ?><!--">-->
				</p>
			</div>
            <div id="conditions">
            <span><?php echo __("step1-terms-and-condition-title"); ?></span>
	            <div class="line_head">
	            		<img src="<?php echo Theme::asset()->usePath()->url('images/bg_conditions_top.jpg'); ?>">
	             </div>
	             <div id="conditions_container" >
                                        <div id="conditions_desc">
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
                       </div>
				<div class="line_bottom">
                       <img src="<?php echo Theme::asset()->usePath()->url('images/bg_conditions_bottom.jpg'); ?>">
                </div>
                <div id="accept_conditions">
                      <input id="email_accept" name="accept" type="checkbox" value="1" /> <?php echo __("step1-accept-term-condition"); ?>
                </div>
            </div>
            <div id="error" class="all_error">
                        <div class="error-box">
                            <div id="register_error_msg" class="error_msg all_register_error_msg" style="color:red; text-align:center;"></div>
                        </div>
            </div>
            <div id="inc-action-box">
                  <button class="inc-btn m_regis" name="btn_register" id="btnNext"><?php echo __('Continue');?></button>
            </div>
		</div>
	</div>
</form>
<div id="register-alert" class="reveal-modal">
    <div class="alert-title" style="background-color: #C00C00;color: #FFFFFF;padding: 3px;font-size: 12px !important ;text-align: center;"></div>
    <div id="popup_message"  style="margin: 10px;text-align: left;font-size: 12px !important ;"class="alert-message"></div>
    <div id="popup_panel">
        <input type="button" class="popup_ok btn btn-success"  style="font-size: 12px !important ;" value="<?php echo __('ok'); ?>">
    </div>
</div>
