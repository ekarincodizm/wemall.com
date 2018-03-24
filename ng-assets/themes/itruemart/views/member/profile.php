<div class="content-home sub">
    <div id="wrapper_content">
        <div id="container">
            <!--Start container-->
            <div id="block_checkout">
                <div id="checkout_main">
                    <div id="checkout_center">
                        <!--[S] memberProfileMenus-->
                        <?php $card = isset($card) ? $card : null; ?>
                        <?php echo Theme::partial('memberProfileMenus', array('user'      => $user, 'lastlogin' => $lastlogin, 'card'      => $card)); ?>
                        <!-- [E] memberProfileMenus -->

                        <div id="checkout_detail">
                            <div class="headline_maincheckout" style="width:320px;"><?php echo __('My Profile'); ?></div>
                            <div class="clear"></div>
                            <div class="line_mainbar_checkout"></div>

                            <!--- Container -->

                            <div id="checkout_detail2">
                                <div id="detail" class="brd-btm">
                                    <div class="col-left topic-box"><?php echo __('order-tracking-description'); ?></div>
                                    <div class="col-right">
                                    </div>
                                    <br class="clearfix">
                                    <div id="detail-form">
                                        <label><?php echo __('username'); ?> : </label>
                                        <span class="text-red"><?php echo $user['display_name']; ?></span>
                                        <label><?php echo __('fullname'); ?> : </label>
                                        <span class="text-red"><?php echo $user['display_name']; ?></span>
                                        <label><?php echo __('email'); ?> : </label>
                                        <span class="text-red"><?php echo $user['email']; ?></span>
                                    </div>
                                </div>

                                <div id="id-card">

                                    <?php //sd(Session::all()); ?>
                                    <div id="id-card-confirm" style="display:none;">
                                        <p id="your_id_card_number">xxxxxxxxxxx</p>
                                        <p><?php echo __('are-you-sure-to-verify-this-id-card'); ?></p>
                                        <img src="http://www.itruemart.com/assets/itruemart_new/global/images/trueyou/ajax-loader.gif" alt="Loading" class="verify-loading">
                                        <input type="button" name="confirm-button" id="confirm-button" value="<?php echo __('confirm'); ?>"> &nbsp;&nbsp;
                                        <input type="button" name="cancel-button" id="cancel-button" value="<?php echo __('cancel'); ?>">
                                    </div>

                                    <?php if ( $checked == 0 ) : ?>
                                        <form name="myForm" id="myForm" action="<?php echo URL::route('member.check'); ?>" method="post" accept-charset="utf-8">
                                            <div id="id-card-form">
                                                <p><?php echo __('Customer True You Enter your ID card for receive special offer'); ?></p>
                                                <p><?php echo __('id-card-13-digit'); ?> :
                                                    <input type="text" name="id_card" id="id_card" placeholder="<?php echo __('id-card-number'); ?>" value="" title="<?php echo __('id-card-13-digit'); ?>" maxlength="13" />
                                                </p>
                                                <input type="button" class="btn-id-card"  value="<?php echo __('check'); ?>">
                                            </div>
                                        </form>
                                    <?php endif; ?>

                                    <?php if ( $checked == 1 ) : ?>
                                        <div id="id-card-verified">
                                            <img src="<?php echo Theme::asset()->url('images/true' . $user['trueyou'] . 'card.jpg'); ?>" class="middle img_card_type">
                                            &nbsp; <em style="font-style:normal;"><?php echo __('thai-id'); ?></em>
                                            <span class="id_card_number"><?php echo $user['thai_id']; ?></span>
                                        </div>
                                    <?php endif; ?>

                                </div>
                                <div class="brd-btm mrg-btm2"></div>
                                <div class="col-left topic-box"><?php echo __('Shipping address'); ?></div>
                                <form action="<?php echo URL::to('member/profile'); ?>" method="post" accept-charset="utf-8" id="address-form">    <div class="col-left addr-list-box">
                                        <select name="shipping_address_list" id="shipping_address_list" autocomplete="off">
                                            <option value=""> ------- <?php echo __('add address'); ?> ------ </option>
                                            <?php foreach ( $addresses['data'] as $address ): ?>
                                                <option value="<?php echo $address['id']; ?>"><?php echo $address['text'] ?></option>
                                            <?php endforeach; ?>
                                        </select><br>
                                    </div>
                                    <br class="clearfix">
                                    <div id="addr-detail" class="brd-btm">
                                        <div id="addr-form">
                                            <label>
                                                <?php echo __('Name'); ?> : 
                                            </label>
                                            <input type="text" name="name" value="" id="shipping_fullname"><br>

                                            <label>
                                                <?php echo __('step2-province'); ?> : 
                                            </label>
                                            <?php echo Form::select('province_id', $provinceOptions, null, array('id' => 'shipping_province_code')); ?><br>

                                            <label>
                                                <?php echo __('Sub-City'); ?> : 
                                            </label>
                                            <?php echo Form::select('city_id', $cityOptions, null, array('id' => 'shipping_city_code')); ?><br>

                                            <label>
                                                <?php echo __('Sub-District'); ?> : 
                                            </label>
                                            <?php echo Form::select('district_id', $districtOptions, null, array('id' => 'shipping_district_code')); ?><br>

                                            <label>
                                                <?php echo __('step3-address'); ?> : 
                                            </label>
                                            <input type="text" name="address" value="" id="shipping_address"><br>

                                            <label>
                                                <?php echo __('zip code'); ?> : 
                                            </label>
                                            <input type="text" name="postcode" value="" id="shipping_postcode" maxlength="100" size="50"><br>

                                            <label>
                                                <?php echo __('step3-phone'); ?> : 
                                            </label>
                                            <input type="text" name="phone" value="" id="shipping_phone"><br>
                                            <label>
                                                <?php echo __('email'); ?> : 
                                            </label>
                                            <input type="text" name="email" value="" data-default="<?php echo $user['email']; ?>" id="shipping_email"><br>
                                            <div class="submit-pnl">
                                                <input type="button" id="submit_addr" class="btn-id-card" value="<?php echo __('save-data'); ?>">
                                            </div>
                                            <input type="hidden" name="is_save" value="Y">

                                        </div>
                                    </div>
                                </form>                     

                            </div>
                        </div>
                        <!--- Container --->
                        <div class="clear"></div>
                    </div>
                </div>                  

            </div>
            <div class="clear"></div>
        </div>

        <!--end checkout_main -->
        <div class="clear"></div>
        <div style="margin-top:10px;"></div>
    </div>


</div>

<div id="profile-dialog" class="reveal-modal">
    <div class="font2 msg-header">ไม่สามารถนำสินค้าชิ้นนี้ใส่ตะกร้าได้</div>
    <div id="popup_content">
        <div id="popup_message">
            <dl class="detail-cart">
                <dt>สินค้า</dt>
            </dl>
            <div class="clearfix"></div>
        </div>
        <div id="popup_panel">
            <input type="button" class="popup_ok btn cart-installment-button cart-installment-button_cancel" value="ยกเลิก">
        </div>
    </div>
</div>

<div id="alert-dialog" class="reveal-modal">
    <div class="font2 msg-header text-center alert-title"></div>
    <div id="popup_message" class="alert-message"></div>
    <div id="popup_panel">
        <input type="button" class="popup_ok btn btn-success" value="ตกลง">
    </div>
</div>

<script>

    var Member = Member || {};
    Member.addresses = eval(<?php echo json_encode($addresses) ?>);

</script>
