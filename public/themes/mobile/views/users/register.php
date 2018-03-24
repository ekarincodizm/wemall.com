<style>
    .require-grey{
        color: #959595;
    }
</style>
<div class="row">
    <div class="col-xs-12 userForm">
        <a href="<?php echo URL::toLang('auth/login'); ?>" class="linkBack">
            <img src="<?php echo URL::asset('themes/mobile/assets/img/icon/prev.png'); ?>" alt=""/>
            <?php echo __('Back'); ?>
        </a>
        <h4 class="mainTitle">
            <?php echo __('register_create_free_account'); ?>
        </h4>

        <form name="formRegister" id="formRegister" method="post" autocomplete="off" action="<?php echo URL::route('users.register') ?>">
            <input type="hidden" name="register_channel" id="register_channel" value="email">
            <input type="hidden" name="continue" value="<?php echo URL::toLang('members/profile'); ?>">
            <div class="form-group">
                <label for="username" data-id="username"><?php echo __('register_identify_email'); ?> <span class="require-grey">*</span></label>
                <input type="text" class="form-control" data-id="username" name="email_username" id="email_username" placeholder="email@mail.com">
            </div>
            <div class="form-group">
                <label for="email_display_name"><?php echo __('display_name'); ?> <span class="require-grey">*</span></label>
                <input type="text" class="form-control" data-id="name" name="email_display_name" id="email_display_name" placeholder="<?php echo __('Name');?>" maxlength="20">
            </div>
            <div class="form-group">
                <label for="email_password"><?php echo __('password'); ?> <span class="require-grey">*</span></label>
                <input type="password" class="form-control" data-id="password" name="email_password" id="email_password" placeholder="<?php echo __('password');?>" maxlength="25">
            </div>
            <div class="form-group">
                <label for="email_confirm_password"><?php echo __('confirm-password'); ?> <span class="require-grey">*</span></label>
                <input type="password" class="form-control" data-id="confirm-password" name="email_password_confirmation" id="email_confirm_password" placeholder="<?php echo __('confirm-password'); ?>" maxlength="25">
            </div>
            <div class="form-group">
                <label><?php echo __('register_term_condition'); ?></label>
                <div class="termsAndCondition">
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
                    <br>
                    <p>PRIVACY POLICY</p>
                    <ol>
                        <li> What information is collected
                                <p>a. Information you give us
                                <p class="need-tab">&nbsp;&nbsp;&nbsp;&nbsp;We collect and store information you provide us from our website or any other way. This information may&nbsp;include</p>

                                    <p>- Your name</p>
                                    <p>- Your mailing address</p>
                                    <p>- Your email address</p>
                                    <p>- Your phone number</p>
                                    <p>- Your mobile number</p>
                                    <p>- Your credit card information or other payment details</p>

                                <p class="need-tab">&nbsp;&nbsp;&nbsp;&nbsp;You may choose to limit the information you provide us, but this may reduce the quality of your shopping experience with us. The information you provide may be used to communicate with you, improve your shopping experience, customize your future shopping experience, and improving our overall store.</p>
                                </p>
                                <p>b. Automatic information &ndash; Cookies
                                <p class="need-tab">&nbsp;&nbsp;&nbsp;&nbsp;We collect information related to your interactions with our websites and apps to create a superior shopping experience. This information may include your ip address, browser and device characteristics, referring URLs, and browsing behavior. This type of information is collected and stored using cookies. Cookies also allow us to provide you with a more personalized shopping experience.</p>
                                <p class="need-tab">We may also permit web analytics and other service providers to collect information. This helps us better understand and improve our interaction with you, providing you with the best shopping experience.</p>
                                </p>
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
                            <p class="need-tab">&nbsp;&nbsp;&nbsp;&nbsp;We do not sell, trade, or rent your information with third parties. Any information you share with Ascend Ecommerce Philippines, Inc may be shared or combined with other affiliates, subsidiaries, parent companies or future entities, both locally and abroad.</p>

                            <p class="need-tab">&nbsp;&nbsp;&nbsp;&nbsp;We may share information with third parties to perform services on our behalf. We may also share information in response to a regulation, court order, subpoena, or to comply with existing laws. We may also share information to respond to government requests or when we believe disclosure is necessary to protect the rights, safety, and well-being of our company, our customers, or the general public. We may also share information to prevent harm or loss or in connection with suspected or actual unlawful activity.</p>

                            <p class="need-tab">&nbsp;&nbsp;&nbsp;&nbsp;Your information may also be shared in in the event of a corporate sale, merger, acquisition or similar event. You will be informed of any change of ownership as well as any options you have regarding your personal information.</p>

                            <p class="need-tab">&nbsp;&nbsp;&nbsp;&nbsp;In sharing your information with them, we endeavor to ensure that the third parties and affiliates keep your information secure from unauthorized access, collection, use, disclosure, or similar risks to your personal information.</p>
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
            </div>
            <div class="form-group">
                <label for="termsAndCondition" class="labelTermsAndCondition">
                    <input type="checkbox" name="accept" id="termsAndCondition" class="imgCheckboxReal" value="ac"><img
                        src="<?php echo URL::asset('themes/mobile/assets/img/checkbox-default.png'); ?>"
                        class="imgCheckboxFake" alt=""/> <span><?php echo __('register_accept_term_condition'); ?></span>
                </label>
            </div>
            <div class="form-group">
                <button type="submit" id="submit_register" class="btn btn-login btn-lg" disabled="disabled" style="background-color: #c4c4c4;"><?php echo __('Continue'); ?> <span
                        class="iconBtnContinue"><img
                        src="<?php echo URL::asset('themes/mobile/assets/img/icon/continue.png'); ?>"
                        alt=""/></span></button>
            </div>
        <?php Form::close();?>
    </div>
</div>
