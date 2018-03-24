<div class="content-home sub">
    <div id="wrapper_content">
        <div id="container">
            <!--Start container-->
            <div id="block_checkout">
                <div id="checkout_main">
                    <!--start checkout_main-->
                    <div id="checkout_center">

                        <!--[S] memberProfileMenus-->
                        <?php $card = isset($card) ? $card : null; ?>
                        <?php echo Theme::partial('memberProfileMenus', array('user' => $user, 'lastlogin' => $lastlogin, 'card' => $card)); ?>
                        <!-- [E] memberProfileMenus -->


                        <div id="checkout_detail">
                            <div class="headline_maincheckout" style="width:320px;">ข้อมูลบัตรเคดิต</div>
                            <div class="clear"></div>
                            <div class="line_mainbar_checkout"></div>

                            <!--- Container --->
                            <div id="edit-card">
                                <?php if(!empty($ccw_list)): ?>
                                <?php foreach($ccw_list as $idx => $ccwInfo): ?>
                                    <div class="edit-box" id="<?php echo !empty($ccwInfo['payment_token'])? $ccwInfo['payment_token'] : ''; ?>">
                                        <ul>
<!--                                            <li>
                                                <span class="edit-label-info">ชื่อบนบัตร :</span>
                                                <span class="form-edit-info"> Shinnawat Tooteera </span>
                                            </li>-->
                                            <li>
                                                <span class="edit-label-info">ประเภทบัตร :</span>
                                                <span class="form-edit-info"> <?php echo !empty($ccwInfo['card_type'])? $ccwInfo['card_type'] : ''; ?> </span>
                                            </li>
                                            <li>
                                                <span class="edit-label-info">หมายเลขบัตร :</span>
                                                <span class="form-edit-info"> <?php echo !empty($ccwInfo['card_number'])? $ccwInfo['card_number'] : '' ; ?> </span>
                                            </li>
<!--                                            <li>
                                                <span class="edit-label-info">วันหมดอายุ :</span>
                                                <span class="form-edit-info"> 13/05 </span>
                                            </li>-->
                                        </ul>
                                        <div class="clear"></div>
                                        <div class="ad-dress">
                                            <div class="address-delete left"><a href="javascript:void(0);" class="remove-ccw-btn" data-key="<?php echo !empty($ccwInfo['payment_token'])? $ccwInfo['payment_token'] : ''; ?>">ลบข้อมูลบัตร</a></div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <div style="color:red; text-align: center; width: 100%;">ไม่พบข้อมูล</div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!--- Container --->
                        <div class="clear"></div>
                    </div>					

                </div>
                <div class="clear"></div>
            </div>

            <!--end checkout_main -->
            <div class="clear"></div>
            <div style="margin-top:10px;"></div>
        </div>
        <div class="container_line"></div>
        <!--End container-->			
    </div>
</div>