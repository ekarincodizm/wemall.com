<div class="content-home sub">
    <div id="wrapper_content">
        <div id="login_regist_wrapper">
            <div class="title_login"><?php echo "Reset Password"; ?></div>
            <div class="detail_wrapper" style="padding-bottom: 30px;">
                <div id="register_main" align="center" width="100%;">
                    <div id="register_main_left">
                        <form name="formResetpassword" id="formResetpassword" method="post" autocomplete="off" action="<?php echo URL::route('forgot.reset-password') ?>">
                            <input type="hidden" name="forgot_hash" value="<?php echo $forgot_hash ?>" />
                            <div id="register_main_left_c">
                                <div class="register_email">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td valign="top"  class="register_label"><?php echo 'New '.__('password'); ?> : <span style="color:red">*</span></td>
                                            <td>
                                                <span class="watermark_container" style="display: inline-block; position: relative;">
                                                    <span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;">
                                                        <?php echo __('password'); ?>
                                                    </span>
                                                    <input type="password" name="email_password" id="email_password" size="35" maxlength="25" class="jq_watermark register_field" data-jq-watermark="processed">
                                                </span>
                                                <div class="register_help_text">
                                                    Password must be between 8-25 characters with 1 special character, letters, and at least 1 number.
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top"  class="register_label"><?php echo __('confirm-password'); ?> : <span style="color:red">*</span></td>
                                            <td>
                                                <span class="watermark_container" style="display: inline-block; position: relative;">
                                                    <span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;">
                                                        <?php echo __('confirm-password'); ?>
                                                    </span>
                                                    <input type="password" name="email_password_confirmation" id="email_confirm_password" size="35" maxlength="25" class="jq_watermark register_field" data-jq-watermark="processed">
                                                </span>
                                                <div class="register_help_text">
                                                    This field must match password field
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <input type="button" id="btn_confirm_resetpassword" value="Confirm">
                            </div>
                            <div class="clear"></div>
                        </form>
                    </div>
                    <div class="clear"></div>
                </div>
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
<div id="popup-reset-success" class="reveal-modal">
    <div class="font2 msg-header text-center alert-title"></div>
    <div id="popup_message" class="alert-message"></div>
    <div id="popup_panel">
        <input type="button" id="btn-popup-reset-success" class="popup_ok btn btn-success" value="<?php echo __('ok'); ?>">
    </div>
</div>