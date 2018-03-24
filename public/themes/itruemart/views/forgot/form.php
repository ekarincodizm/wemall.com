<div class="content-home sub">
    <div id="wrapper_content">
        <div id="login_regist_wrapper">
            <div class="title_login"><?php echo "Forgot password"; ?></div>
            <div class="detail_wrapper" style="padding-bottom: 0px;">
                <div id="register_main" align="center" width="100%;">
                    <div id="forget_success" style="font-size: 16px;padding-top: 100px;display: none;" ></div>
                    <div id="register_main_left" width="100%;">
                        <?php if(isset($success_message)){
                            echo $success_message;
                        } else{
                        ?>
                        <form name="formForgot" id="formForgot" method="post" autocomplete="off" action="<?php echo URL::route('forgot.checkmail') ?>">
                            <div id="register_main_left_c">
                                <div class="register_email">
                                    <table align="center">
                                        <tbody><tr>
                                            <td style="padding: 20px 10px 20px 20px" valign="top" class="register_label"><?php echo __('true-id'); ?> : <span style="color:red">*</span></td>
                                            <td style="padding: 20px 20px 20px 10px">
                                                <span class="watermark_container" style="display: inline-block; position: relative;">
                                                    <span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;"><?php echo __('email'); ?></span>
                                                    <input type="text" name="email_username" id="email_username" size="35" maxlength="60" class="jq_watermark register_field" data-jq-watermark="processed" value="<?php echo (!empty($email)) ? $email : ''; ?>">
                                                </span><br>
                                                <div id="forgotpassword_validate_text" style="color:red; font-size:10px; line-height: 15px;"><? echo (!empty($validate_text) ? $validate_text : "") ?></div>
<!--                                                <div class="register_validate text-right"><a href="javascript:registerCheckEmail(document.getElementById('email_username'))" name="velify_email">--><?php //echo __('check-email'); ?><!--</a></div>-->
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <input type="button" id="btn_forgot_submit" value="Continue">
                            </div>
                            <div class="clear"></div>
                        </form>
                        <?php } ?>
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