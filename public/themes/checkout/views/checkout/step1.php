<?php if ( ! empty($cart['data']['customer_email'])) : ?>
	<script type="text/javascript">
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
	</script>
<?php endif; ?>
<div class="title">
    <h1><?php echo __('email-login'); ?></h1>
</div>
<div class="in-form">
	<form action="" method="post" id="form-checkout">		
		<div>
			<div class=" form-max">
				<p>
					<input <?php if($type == 'guest'){ echo 'checked'; } ?> id="guest" name="logintype" data-href="<?php echo URL::toLang('checkout/step1', array(), Config::get("https.useHttps") ); ?>" type="radio" value="guest">
					<label for="guest" class="control-desc"><?php echo __('continue-without-password');?></label></p>
			</div>
		</div>
		<div class="clear"></div>
		<div>
			<div class=" form-max">
				<p>					
					<input <?php if($type == 'user'){ echo 'checked'; } ?> id="user1" name="logintype" data-href="<?php echo URL::toLang('auth/login', array(), Config::get("https.useHttps")); ?>" type="radio" value="user">
					<label for="user1" class="control-desc"><?php echo __('already-have-account');?></label></p>
			</div>
		</div>
		<div class="clear"></div>
		<div>
			<p class="control-label left">
				<label for="email"><?php echo __('Enter your email address');?>: </label>
			</p>
			<div class=" form-max">
				<input autocomplete="off" id="step1-username" class="input-box" name="username" type="text" placeholder="<?php echo __("email-placeholder-username"); ?>" value="<?php echo !empty($cart['data']['customer_email'])? $cart['data']['customer_email'] : '';?>">
			</div>
		</div>
		<div class="clear"></div>

		<div id="pwd-box" style="display: none;">
			<div>
				<p class="control-label left">
					<label for="password"><?php echo __('password');?> : </label>
				</p>
				<div class=" form-max">
					<input class="input-box" maxlength="15" id="password" name="password" type="password" placeholder="<?php echo __('Enter your password');?>" autocomplete="off" >
				</div>
			</div>
			<div class="clear"></div>
			<div>
				<div class=" form-max">
					<p><a href="<?php echo Url::Route('forgot'); ?>" class="clr-6"><?php echo __('forgot password');?></a></p>
				</div>
			</div>
		</div>
		<div class="clear"></div>
		<div>
			<div class=" form-max">
				<input type="hidden" name="process" id="process" value="login">
				<input type="hidden" name="continue" id="redirect" value="<?php echo $continue; ?>">
				<?php echo Form::token() ?>
				<?php if ($errors->count()) { ?>
					<div class="error_msg red" style="color:red;"><?php echo __("username-pass-invalid"); //echo $errors->first(); ?></div>
                <?php }elseif(Input::has("errors")) { ?>
                    <div class="error_msg red" style="color:red;"><?php echo __("username-pass-invalid"); //echo Input::get("errors"); ?></div>
                <?php }; ?>
				<input class="form-bot" name="" id="btnNext" type="submit" value="<?php echo __('Continue');?>" >
			</div>
		</div>
	</form>
</div>

