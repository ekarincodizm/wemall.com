<?php
    $text = '';
    $has_error1 = '';
    $has_error2 = '';

    if ($errors->count()) {
        $text = $errors->first();
        preg_match('#\((.*?)\)#', $text, $match);
        $error_code = array_get($match, 1);

        $txt_error_group1 = '';
        $txt_error_group2 = '';

        $group1 = array('3009', '1012');
        if (in_array($error_code, $group1)) {
            $txt_error_group1 = $text;
            $has_error1 = 'has-error';
        }
        else {
            $txt_error_group2 = $text;
            $has_error2 = 'has-error';
        }
    }
?>

<div id="content">
    <div class="row">
      	<div class="col-xs-12 userForm">
        	<h4 class="mainTitle">
                <?php echo __('login-to-track-order');?>
        	</h4>
            <?php echo Form::open(array('url' => URL::toLang('auth/login', array(), Config::get("https.useHttps")).'#no-back', 'name' => 'formLogin', 'id' => 'formLogin', 'autocomplete' => 'off')); ?>
          		<div class="form-group  <?php echo $has_error1;?>">
            		<input type="text" name="username" class="form-control" id="username" data-id="username" placeholder="<?php echo __('email-or-trueid'); ?>" value="<?php echo Input::old('username'); ?>">
            		<?php if(!empty($txt_error_group1)): ?>
                        <p data-id="email-error-message" class="help-block error"><span class="icon-error">!</span><?php echo $txt_error_group1;?></p>
                    <?php endif;?>
          		</div>
          		<div class="form-group <?php echo $has_error2;?>">
            		<input type="password" name="password" class="form-control" id="password" data-id="password" placeholder="<?php echo __('pls-enter-password'); ?>" >
                    <?php if(!empty($txt_error_group2)): ?>
                        <p data-id="password-error-message" class="help-block error"><span class="icon-error">!</span><?php echo $txt_error_group2;?></p>
                    <?php endif;?>
              </div>
          		<div class="form-group">
            		<p class="help-block"><a href="<?php echo Url::Route('forgot'); ?>" class="link"><?php echo __('forgot password');?></a></p>
          		</div>
          		<div class="form-group">
            		<button type="submit" data-id="login-submit" class="btn btn-login btn-lg"><?php echo __('Continue');?> <span class="iconBtnContinue"><img src="<?php echo Theme::asset()->usePath()->url('img/continue.png'); ?>" alt=""/></span></button>
          		</div>
                <input type="hidden" name="process" id="process" value="login">
                <input type="hidden" name="continue" id="redirect" value="<?php echo $continue; ?>">
            <?php echo Form::close(); ?>

            <div id="new_account_description">
                <a href="<?php echo URL::toLang('users/register');?>" data-id="signup-link" id="new_account_link"><?php echo __('mobile-register-link-txt');?></a>
                <div id="message">
                    <?php echo __('mobile-register-txt');?>
                <div>
            </div>

          </div>
      	</div>
    </div>
</div>