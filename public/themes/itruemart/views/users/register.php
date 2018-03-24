<div class="content-home sub">
    <div id="wrapper_content">
        <div id="login_regist_wrapper">
            <div class="title_login"><?php echo __('register-true-id'); ?></div>
            <div class="detail_wrapper" style="padding-bottom: 30px;">
                <div id="register_main">
                    <div id="register_main_left" class="float-left">

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
                                                <td valign="top"  class="register_label"><?php echo __('display_name'); ?> : <span style="color:red">*</span></td>
                                                <td>
                                                    <span class="watermark_container" style="display: inline-block; position: relative;"><span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;"><?php echo __('Name'); ?></span><input type="text" name="email_display_name" id="email_display_name" size="35" maxlength="20" class="jq_watermark register_field" data-jq-watermark="processed"></span>
                                                    <div class="register_help_text">
                                                        Display name must be 2-20 characters
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top"  class="register_label"><?php echo __('password'); ?> : <span style="color:red">*</span></td>
                                                <td>
                                                    <span class="watermark_container" style="display: inline-block; position: relative;"><span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;"><?php echo __('password'); ?></span><input type="password" name="email_password" id="email_password" size="35" maxlength="25" class="jq_watermark register_field" data-jq-watermark="processed"></span>
                                                    <div class="register_help_text">
                                                        Password must be between 8-25 characters with 1 special character, letters, and at least 1 number.
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top"  class="register_label"><?php echo __('confirm-password'); ?> : <span style="color:red">*</span></td>
                                                <td>
                                                    <span class="watermark_container" style="display: inline-block; position: relative;"><span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;"><?php echo __('confirm-password'); ?></span><input type="password" name="email_password_confirmation" id="email_confirm_password" size="35" maxlength="25" class="jq_watermark register_field" data-jq-watermark="processed"></span>
                                                    <div class="register_help_text">
                                                        This field must match password field
                                                    </div>
                                                </td>
                                            </tr>
<!--                                            <tr>-->
<!--                                                <td class="register_label">--><?php //echo __('thai-id'); ?><!--</td>-->
<!--                                                <td>-->
<!--                                                    <span class="watermark_container" style="display: inline-block; position: relative;"><span class="watermark" style="position: absolute; display: block; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(153, 153, 153); left: 4px; top: 0px; height: 24px; line-height: 24px; text-align: left; pointer-events: none;">--><?php //echo __('thai-id'); ?><!--</span><input type="text" name="email_thai_id" id="email_idcard" class="jq_watermark register_field is_numeric" maxlength="13" size="35" data-jq-watermark="processed"></span>-->
<!--                                                </td>-->
<!--                                            </tr>-->
<!--                                            <tr>-->
<!--                                                <td class="register_label" colspan="2">-->
<!--                                                    <span style="color:red; font-size:11spx; width:50px;">2222ลูกค้า True You กรอกบัตรประชาชน เพื่อรับสิทธิ์พิเศษ</span>-->
<!--                                                </td>-->
<!--                                            </tr>-->
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
                                <img src="<?php echo Theme::asset()->url('images/profile/btn_register_en1.png'); ?>" alt="" width="86" height="41">

                            </a>
                        </form>
                    </div>
                    <div id="register_main_right" class="float-left">
                        <div class="register_main_title"><?php echo __('term-condition'); ?></div>
                        <div id="register_main_right_c">
                            <p><strong>Conditions of Use</strong></p>

                            <p>&nbsp;Welcome to the iTrueMart Philippines website. By using the website and its corresponding services products, and software, you agree to be bound by these terms (Conditions of Use). You also agree to these conditions of use when you sign up for an account, use the site as a guest, or sign in to your account. We may make changes to these conditions. It is your responsibility to review these changes. If you do not agree with these conditions, you should not use the site.</p>

                            <p>&nbsp;1. Purchase of product</p>

                            <ol>
                                <p> - Product descriptions &ndash; while we endeavor to provide accurate descriptions, Ascend warrants that the current description is accurate or free from error. If the product you receive is fundamentally different from the product description at the time of purchase, you may return the product, subject to the terms and conditions of the returns process.</p>
                                <p> - Placing orders &ndash; after selecting your items, you may confirm your order by clicking on the &ldquo;Place Order&rdquo; on the platform. No other form of order is permitted or accepted. You are responsible for ensuring the accuracy of your order.</p>
                                <p> - Termination of order due to pricing error &ndash; Ascend reserves the right to terminate an order, in the event that a product has been mispriced on the platform. Ascend has the right to terminate the order whether the products have been in dispatched and are in transit, whether payment has been charged to you. In case of payment, Ascend will refund the payment charged.</p>
                                <p> - Order confirmation &ndash; our order confirmation does not signify our acceptance of your order, nor does it constitute confirmation of our offer to sell. At any time after we receive your order, we may accept, decline, or place quantity or other limits on your order for any reason. If we reject, limit, or otherwise modify your order, we will endeavor to notify you with the contact information you have provided us. In cases of cancellation, we will refund you the full amount of the cancelled portion of your order.</p>
                            </ol>

                            <p>&nbsp;2. Delivery of product</p>

                            <ol>
                                <p> - Delivery address - Confirmed orders will be delivered to the address provided. Delivery and packaging charges are set out as part of the order.</p>
                                <p> - Timeframe &ndash; You acknowledge that delivery of the product is subject to availability. Ascend will make every effort to deliver the product within the specified timeframe. You acknowledge that while stock information on the platform is regularly updated, there can be instances wherein product is unavailable. All delivery timeframes are estimates only and subject to delays. In case of delay, Ascend will contact you accordingly. Your product will be dispatched as soon as it becomes available.</p>
                                <p> - Accepting a delivery via representative &ndash; If you are not available to accept a delivery, you may choose to have a representative accept the delivery on your behalf. You must provide the following documents:
                                    <ul>
                                        <p>- Authorization letter</p>
                                        <p>- Copy of ID of customer</p>
                                        <p>- Copy of ID of representative</p>
                                    </ul>
                                </p>
                            </ol>

                            <p>&nbsp;3. Prices of product</p>

                            <ol>
                                <p>- Listing price &ndash; the price on the platform is the payable price. All taxes, unless otherwise stated, are included in the listing price.</p>
                                <p>- Delivery charges, packaging charges, handling fees, and other fees are not included in the list price.</p>
                                <p>- Ascend reserves the right to change the list price without prior notice.</p>
                            </ol>

                            <p>&nbsp;4. Payment</p>

                            <ol>
                                <p>- You may use any of the payment methods offered on the platform. Charges will be incurred only upon confirmation of your order. All payments will be made to Ascend. You acknowledge that Ascend and its third party affiliates are entitled to collect payment on your behalf.</p>
                                <p>- You agree that you are subject to the applicable user agreements of your payment method. You may not claim against Ascend or any of its agents for any failure, disruption, or error in connection with your chosen payment method. Ascend reserves the right to modify, discontinue temporarily or permanently, any payment method without notice or reason.</p>
                                <p>- Failure to pay &ndash; if the customer fails to make a payment pursuant to the terms and conditions of the selected payment method, or if payment is cancelled, Ascend reserves the right to suspend the delivery until payment is made.</p>
                            </ol>

                            <p>&nbsp;5. Refunds &ndash; All valid refunds shall be made via the original payment method, with the exception of cash on delivery. For cash on delivery items, refunds shall be processed via bank transfer into the individual customer&rsquo;s bank account, provided that complete and accurate bank details are provided.</p>

                            <ol>
                                <p>5.1 Processing of refunds are subject to the processing time of the corresponding payment method. Ascend makes no commitment as to the timeliness of the refund.</p>
                                <p>5.2 All costs associated with the processing of the refund shall be borne by Ascend, unless otherwise stated.</p>
                                <p>5.3 All refunds are conditional to our acceptance of a valid return of the product.</p>
                                <p>5.4 We reserve the right to modify the mechanism of the processing of refunds without notice</p>
                                <p>5.5 For bank transfers:
                                    <ol>
                                        <p>5.5.1 All bank transfers shall be deposited into the account of the customer only.</p>
                                        <p>5.5.2 Bank accounts for deposit should be able to accept check payments</p>
                                        <p>5.5.3 No cash refunds shall be allowed.</p>
                                    </ol>
                                </p>
                            </ol>

                            <p>&nbsp;6. Returns/Repairs</p>

                            <ol>
                                <p>6.1 These are the following valid reasons for returns:
                                    <ol>
                                        <p>6.1.1 Customer change of mind</p>
                                        <p>6.1.2 Factory defect</p>
                                        <p>6.1.3 Wrong item delivered</p>
                                        <p>6.1.4 Damaged Packaging</p>
                                        <p>6.1.5 Outright Rejection</p>
                                    </ol>
                                </p>
                                <p>6.2 Damaged packaging and outright rejection will only be accepted as valid reason for return upon delivery. Once you have signed off on the delivery receipt, these reasons will no longer be accepted.</p>
                                <p>6.3 Returns period is valid for 30 days</p>
                                <p>6.4 You are required to submit the following documents upon return of item
                                    <ol>
                                        <p>6.4.1 Original invoice</p>
                                        <p>6.4.2 Item return form</p>
                                        <p>6.4.3 Item, with complete accessories, chargers, manuals, and packaging</p>
                                        <p>6.4.4 Free bundled items or other promos that accompany the item.</p>
                                    </ol>
                                </p>
                                <p>6.5 Customer Change of Mind
                                    <ol>
                                        <p>6.5.1 You have a window of 30 days from date of delivery to change your mind and return a product.</p>
                                        <p>6.5.2If your return due to change of mind is valid, you will be refunded in full. Refund terms and conditions apply</p>
                                    </ol>
                                </p>
                                <p>6.6 Factory defect
                                    <ol>
                                        <p>6.6.1 You have a period of 30 days from date of delivery to report any factory defects to Ascend.</p>
                                        <p>6.6.2 Upon report of factory defect, you may send the item back to Ascend for replacement</p>
                                        <p>6.6.3 Ascend inspect the item and determine if defect is valid or due to customer mishandling or misuse.</p>
                                        <p>6.6.4 Only items deemed to be damaged due to factory defect will be accepted. Items found to be damaged due to customer misuse or mishandling shall not be accepted as a valid return</p>
                                        <p>6.6.5 For items accepted as factory defect, a replacement unit will be sent to customer.</p>
                                        <p>6.6.6 For items within the 30 day period, Ascend will shoulder the cost of returning the item</p>
                                        <p>6.6.7 For items with factory defect beyond 30 days, our customer service team will be more than happy to assist you to locate the nearest service center. Individual product warranty will apply.</p>
                                    </ol>
                                </p>
                                <p>6.7 Wrong item delivered
                                    <ol>
                                        <p>6.7.1 Wrong item delivered applies to the following scenarios:
                                            <ol>
                                                <p>6.7.1.1 Wrong color from what was indicated on invoice</p>
                                                <p>6.7.1.2 Wrong model from what was indicated on invoice</p>
                                                <p>6.7.1.3 Wrong size from what was indicated on invoice</p>
                                                <p>6.7.1.4 Item delivered is not item on invoice</p>
                                            </ol>
                                        </p>
                                        <p>6.7.2 For items that fall under wrong item delivered, you may contact Ascend and request for a replacement.</p>
                                    </ol>
                                </p>
                            </ol>

                            <p>&nbsp;7. Termination</p>

                            <ol>
                                <p>7.1 Customer cancellation of order &ndash; you may cancel an order by contacting Ascend. Please see contact us page for more information on how to reach us. If product has already been shipped, you may no longer cancel the order, but choose to reject delivery. Terms and conditions may apply.</p>
                                <p>7.2 Ascend cancellation of order &ndash; Ascend reserves the right to cancel an order at any time if the product the customer ordered is unavailable for any reason</p>
                            </ol>

                            <br>
                            <p>PRIVACY POLICY</p>
                            <ol>
                                <li> What information is collected
                                    <ul>
                                        <p>a. Information you give us
                                            <p class="need-tab">We collect and store information you provide us from our website or any other way. This information may&nbsp;include</p>
                                            <ul>
                                                <p>- Your name</p>
                                                <p>- Your mailing address</p>
                                                <p>- Your email address</p>
                                                <p>- Your phone number</p>
                                                <p>- Your mobile number</p>
                                                <p>- Your credit card information or other payment details</p>
                                            </ul>
                                            <p class="need-tab">You may choose to limit the information you provide us, but this may reduce the quality of your shopping experience with us. The information you provide may be used to communicate with you, improve your shopping experience, customize your future shopping experience, and improving our overall store.</p>
                                        </p>
                                        <p>b. Automatic information &ndash; Cookies
                                            <p class="need-tab">We collect information related to your interactions with our websites and apps to create a superior shopping experience. This information may include your ip address, browser and device characteristics, referring URLs, and browsing behavior. This type of information is collected and stored using cookies. Cookies also allow us to provide you with a more personalized shopping experience.</p>
                                            <p class="need-tab">We may also permit web analytics and other service providers to collect information. This helps us better understand and improve our interaction with you, providing you with the best shopping experience.</p>
                                        </p>
                                    </ul>
                                </li>
                                <br>
                                <li> What do we do with this information
                                    <p class="need-tab">The information we gather may be used to fulfill the following:</p>
                                    <p class="need-tab">- Fulfilling requests for information on products and services</p>
                                    <p class="need-tab">- Tracking and confirming orders</p>
                                    <p class="need-tab">- Delivering orders</p>
                                    <p class="need-tab">- Marketing and advertising products</p>
                                    <p class="need-tab">- Conducting research and analysis</p>
                                    <p class="need-tab">- Establishing and managing your account with us</p>
                                    <p class="need-tab">- Communicating special promotions, events, or sales</p>
                                    <p class="need-tab">- Operating, evaluating, and continuously improving our business</p>
                                    <p class="need-tab">- In extreme cases, we may need to disclose personal information, should we deem it necessary to prevent a threat to life and health, for law enforcement purposes, or fulfillment of regulatory or legal requirements and requests</p>
                                </li>
                                <br>
                                <li> Who do we share this information with
                                    <p class="need-tab">We do not sell, trade, or rent your information with third parties. Any information you share with Ascend Ecommerce Philippines, Inc may be shared or combined with other affiliates, subsidiaries, parent companies or future entities, both locally and abroad.</p>

                                    <p class="need-tab">We may share information with third parties to perform services on our behalf. We may also share information in response to a regulation, court order, subpoena, or to comply with existing laws. We may also share information to respond to government requests or when we believe disclosure is necessary to protect the rights, safety, and well-being of our company, our customers, or the general public. We may also share information to prevent harm or loss or in connection with suspected or actual unlawful activity.</p>

                                    <p class="need-tab">Your information may also be shared in in the event of a corporate sale, merger, acquisition or similar event. You will be informed of any change of ownership as well as any options you have regarding your personal information.</p>

                                    <p class="need-tab">In sharing your information with them, we endeavor to ensure that the third parties and affiliates keep your information secure from unauthorized access, collection, use, disclosure, or similar risks to your personal information.</p>
                                </li>
                                <br>
                                <li> Your choices with regards to your information
                                    <p class="need-tab">You may choose to limit or remove any personal information we have collected. These actions include:</p>
                                    <p class="need-tab">- Stop receiving marketing materials, emails, phone calls, and other forms of communication</p>
                                    <p class="need-tab">- Update your personal information</p>
                                    <p class="need-tab">- Deactivate your account</p>
                                    <p class="need-tab">- Request the removal of any personal information posted by you from our website or other platforms.</p>
                                </li>
                                <br>
                                <li> Children&rsquo;s privacy</li>
                                <p class="need-tab">Ascend does not sell products to anyone below the age of 18. If you are below 18 years of age, you agree to use our website only with the involvement of a parent or guardian.</p>
                                <br>
                                <li> Privacy Policy Changes</li>
                                <p>Ascend reserves the right to modify or change the contents of this policy. Any changes made to the policy shall be published on this platform.</p>
                                <br/>
                            </ol>
                            <p>&nbsp;</p>
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