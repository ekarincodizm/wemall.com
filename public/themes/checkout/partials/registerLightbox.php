<!-- Register -->
<div id="popup-regis" class="modal fade" data-show="<?php echo (!empty($show) && $show===true)? 'true' : 'false'; ?>" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div  class="modal-dialog" >
		<div  class="box-popup-regis" >
			<div class="title">
				<div class="left">
					<h1><?php echo __("thankyou-register-lightbox-title"); ?></h1>
				</div>
				<div class="right"><img class="close-modal" src="<?php echo Theme::asset()->usePath()->url('/images/close.png'); ?>" width="27" height="27" /></div>
				<div class="clear"></div>
			</div>
			<div class="in-form">
				<div class="regis-pop">

					<ul>
						<li class="regis-bullet"><?php echo __("thankyou-register-lightbox-desc1"); ?></li>
						<li class="regis-bullet"><?php echo __("thankyou-register-lightbox-desc2"); ?></li>
						<li class="regis-bullet"><?php echo __("thankyou-register-lightbox-desc3"); ?></li>
					</ul>
<!--					<div class="regis-title"><h1>--><?php //echo __("thankyou-register-lightbox-desc4"); ?><!--</h1></div>-->
					<div class="regis-id">
						<h3><?php echo __("thankyou-your-trueid-is"); ?> <span class="clr-7"><?php echo (!empty($email))? $email : ""; ?></span></h3>
					</div>
						<?php //alert($data); ?>
					<form id="thankyou-register-lightbox" action="<?php echo Url::route('thankyou.savemember'); ?>" method="post">
						<input type="hidden" name="register_channel" value="email" />
						<input type="hidden" name="email_username" value="<?php echo (!empty($email))? $email : ""; ?>" />
						<input type="hidden" name="continue" value="<?php echo !empty($continue)? $continue : '/'; ?>" />
<!--						<input type="hidden" name="email_display_name" value="--><?php //echo (!empty($email))? $email : ""; ?><!--" />-->
						<input type="hidden" name="order_id" value="<?php if(isset($data['order_id'])){ echo (!empty($data['order_id']))? $data['order_id'] : ""; } ?>" />
						<input type="hidden" name="true_card" value="<?php
							if(isset($data['order_trueyou'])) :
								if(isset($data['order_trueyou']['card']))
								{
									echo (!empty($data['order_trueyou']['card']))? $data['order_trueyou']['card'] : "";
								}
							endif;
						?>" />
						<input type="hidden" name="thai_id" value="<?php
							if(isset($data['order_trueyou'])) :
								if(isset($data['order_trueyou']['thai_id']))
								{
									echo (!empty($data['order_trueyou']['thai_id']))? $data['order_trueyou']['thai_id'] : "";
								}
							endif;
						?>" />
                        <div class="regis-form-control">
                            <input class="input-box active-success text-center" maxlength="20" name="email_display_name" type="text" placeholder="<?php echo __("register_enter_display_name"); ?>" >
                            <?php if ($errors->count()) : ?>
                                <div class="active-alert-text"><?php echo $errors->first(); ?></div>
                            <?php endif; ?>
                        </div>
						<div class="regis-form-control">
							<input class="input-box active-success text-center" maxlength="25" name="email_password" type="password" placeholder="<?php echo __("thankyou-register-lightbox-placeholder"); ?>" >
							<?php if ($errors->count()) : ?>
								<div class="active-alert-text"><?php echo $errors->first(); ?></div>
							<?php endif; ?>
						</div>
						<div class="clear"></div>
						<div class="clear"></div>
						<div class="clear"></div>
						<div class="clear"></div>
						<div class="regis-box-control">
							<input class="form-bot" type="submit" value="<?php echo __("thankyou-register-lightbox-btn"); ?>" />
						</div>
					</form>
				</div>

			</div>
			<div class="box-footer regis-btm">
				<p><?php echo __("thankyou-register-loghtbox-close"); ?></p>
				<div class="clear"></div>
			</div>

			<div class="clear"></div>

		</div>
	</div>
</div>
<!-- /Register -->