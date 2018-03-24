<div class="review" style="background-color:#f2f2f2;">
  <div style="padding:0 10px 20px 10px;">
    <div class="all-banner"  style=" border-bottom:1px solid #CCC; background-color:#FFF; 	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;">
     <div style="border-bottom:1px solid #f2f2f2; padding:10px 10px 10px 10px; color:#093;">
      <div style="float:left;"><img src="<?php echo Theme::asset()->usePath()->url('images/login.png'); ?>" width="40" height="40" /></div>
        <div  style="float:left; padding:8px 0px 0px 5px;">
          <h3 style="color: #666;"><?php echo trans('auth.login'); ?></h3>
        </div>
        <div class="clear"></div>
      </div>
      <?php echo Form::open(array('url' => null, 'name' => 'formLogin', 'id' => 'formLogin', 'autocomplete' => 'off')); ?>
      <div class="form-login">
        <div class="forms-st">
          <input name="username" id="username" type="text" placeholder="<?php echo trans('auth.username'); ?>" />
          <input name="password" id="password" type="password" placeholder="<?php echo trans('auth.password'); ?>" />
        </div>
        <div style=" position:relative;">
          <button class="btn-blue-l" style="width:100%; margin:0; padding:0; float:none;"><?php echo trans('auth.signin'); ?></button>
        </div>
        <input type="hidden" name="process" id="process" value="login">
        <input type="hidden" name="continue" id="redirect" value="<?php echo ( ! empty($continue)) ? $continue : ""; ?>">
        <?php echo Form::token() ?>
        <div class="clear"></div>
        <?php if ($errors->count()) : ?>             
        <div id="error" style="display:block;">
          <div class="error-box">
            <div id="register_error_msg" class="error_msg" ><?php echo $errors->first(); ?></div>
          </div>
        </div>

        <?php endif; ?>
        <div style="padding:10px 0px 10px 0px; margin-top:15px;">
          <div style="width:235px; margin-left:auto; margin-right:auto; padding:10px; border:1px solid #f2f2f2; -webkit-border-radius: 4px;
	           -moz-border-radius: 4px;">
            <div style="float:left; width:104px; padding:5px; text-align:center;">
              <input   name="remember_me" id="remember_me" type="checkbox" value="1" />
              <?php echo trans('auth.remember_password'); ?>
            </div>

            <div style="float:left; width:104px; padding:8px 5px 5px 5px; border-left:1px dotted #CCCCCC; text-align:center;">
              <a href="#" onclick="javascript:forgetPassword();" name="forgot_password"><?php echo trans('auth.forgot_password'); ?></a>
            </div>

            <div class="clear"></div>
          </div>
        </div>
        <div style="padding:10px 0px 10px 0px; font-size:13px; text-align:center;"><?php echo trans('auth.what_is_trueid'); ?></div>
      </div>
      <?php echo Form::close(); ?>
    </div>

    <div class="clear"></div>
    <div class="all-banner"  style="border-bottom:1px solid #CCC; background-color:#FFF; margin-top:15px; 	-webkit-border-radius: 4px;
	     -moz-border-radius: 4px;">
      <div style="border-bottom:1px solid #f2f2f2; padding:10px 10px 10px 10px; color:#093;">
        <div style="float:left;">
          <img src="<?php echo Theme::asset()->usePath()->url('images/register.png'); ?>" width="40" height="40" />
        </div>
        <div style="float:left; padding:8px 0px 0px 5px;">
          <h3 style="color: #666;"><?php echo trans('auth.new_customer'); ?></h3>
        </div>
        <div class="clear"></div>
      </div>
      <div class="form-login">
        <div style=" padding:20px 0px 10px 0px;">
          <button class="btn-orange-l signup" data-href="<?php echo URL::toLang('users/register'); ?>" style="width:100%; margin:0; padding:0; float:none;"><?php echo trans('auth.signup'); ?></button>
        </div>
        <div class="clear"></div>
        <div style="padding:10px 0px 10px 0px; margin-top:25px; border-top:1px dotted #CCCCCC; position:relative;">
          <div style="position: absolute; color: #666; font-weight:bold; font-style:italic; padding:5px; background-color:#FFF; left: 40%; top: -16px;"> <?php echo trans('auth.or'); ?> </div>
        </div>
        <div class="clear"></div>
        <div style="padding:10px 0px 10px 0px; font-size:13px; text-align:center;"><?php echo trans('auth.only_one_step'); ?></div>
        <div style=" padding:5px 0px 10px 0px;">
          <button class="btn-blue-l buy_now" data-href="<?php echo URL::toLang('checkout1'); ?>" style="width:100%; margin:0; padding:0; float:none;"><?php echo trans('auth.buy_now'); ?></button>
        </div>
      </div>
    </div>
  </div>
</div>