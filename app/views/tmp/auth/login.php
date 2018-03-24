<div class="content-home sub">
    <div id="wrapper_content">
        <div id="login_regist_wrapper">
            <div class="col-login">
                <div class="title_login"><?php echo __('login') ?></div>
                <div class="detail_wrapper">
                    <div id="login">
                        <div class="float-left">
                            <div class="label"><?php echo __('True ID') ?>:</div>
                            <div class="label"><?php echo __('password') ?>:</div>
                        </div>
                        <div id="login_form">

                            <?php echo Form::open(array('url' => null, 'name' => 'formLogin', 'id' => 'formLogin', 'autocomplete' => 'off')); ?>
                                <span class="watermark_container" style="display: inline-block; position: relative;"><span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: rgb(153, 153, 153); left: 9px; top: 0px; height: 27px; line-height: 27px; text-align: left; pointer-events: none; opacity: 1;"><?php echo __('email mobile truecard number'); ?></span><input type="text" name="username" id="login_username" class="jq_watermark field" data-jq-watermark="processed"></span>
                                <span class="watermark_container" style="display: inline-block; position: relative;"><span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: rgb(153, 153, 153); left: 9px; top: 0px; height: 27px; line-height: 27px; text-align: left; pointer-events: none;"><?php echo __('password');?></span><input type="password" name="password" id="login_password" class="jq_watermark field" value="" data-jq-watermark="processed"></span>
                                <input type="checkbox" name="remember_me" id="login_remember" value="1">
                                <label for="login_remember" style="font-size:13px;color:#999;font-weight:normal;"><?php echo __('remember me') ?></label>
                                <input type="hidden" name="process" id="process" value="login">
                                <input type="hidden" name="continue" id="redirect" value="<?php echo $continue; ?>">
                                <?php echo Form::token() ?>
                                <div id="login_desc" class="float-left">
                                    <div id="form" class="float-left">
                                        <input type="submit" id="btn_login" name="btn_login" value="<?php echo __('login');?>">
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            <?php echo Form::close(); ?>
                        </div>
                        <div class="clear"></div>
                        <div id="login_loading" style="padding-left:80px; display:none;">
                            <div style="float:left;"></div>
                            <div style="color:#CCC; font-size:10px; padding-left:5px; padding-top:5px; float:left;">Loading...</div>
                        </div>
                    </div>

                    <?php if ($errors->count()) : ?>
                    <div class="error_msg"><?php echo $errors->first(); ?></div>
                    <?php endif; ?>

                    <div id="login_error_msg" class="error_msg"></div>
                    <div id="login_remark">
                        <div id="remark">
                            <?php __('ทรูไอดี คือ อีเมลล์/เบอร์มือถือ/เบอร์ทรูการ์ด ที่ได้ลงทะเบียนไว้กับ iservice.truelife.com, truelife.com, true-u.com, weloveshopping.com, iTrueMart.com และ TrueStore'); ?>
                        </div>
                        <div id="login_pass" class="float-left">
                            <p>
                                <a href="javascript:forgetPassword();" name="forgot_password"><?php echo __('forgot password');?></a>
                            </p>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="col-login">
                <div class="title_login"><?php echo __('new user'); ?></div>
                <div class="detail_wrapper regist-panel">
                    <p align="center" class="">
                        <?php echo Form::button(__('register'), array('class' => 'btn_guest', 'onclick' => 'location.href="/users/register"')); ?>
                    </p>
                    <p align="center"><?php echo __('Or only one step You can order from itruemart easy fast');?></p>
                    <div align="center">
                        <input type="button" value="<?php echo __('click for buy now');?>" class="btn_guest" onclick="location.href = '<?php echo URL::toLang('checkout'); ?>'">
                    </div>
                </div>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>
</div>