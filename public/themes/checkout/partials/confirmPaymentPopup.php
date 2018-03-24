<div id="confirm-payment-popup-msg" class="installment modal fade" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-content">
        <div class="title">
            <div class="left">
                <h1><?php echo __("confirm-payment-method-title"); ?></h1>
            </div>
            <div class="right"><img class="close-modal confirm-payment-close-btn"
                                    src="<?php echo Theme::asset()->usePath()->url('images/close.png'); ?>" width="27"
                                    height="27"/>
            </div>
            <div class="clear"></div>
        </div>
        <div class="content">
            <p class="installment__main-text">
                <?php echo __("confirm-payment-method-desc1"); ?> "<span id="confirm-payment-popup-text"></span>"
            </p>

            <div class="installment-box-control">
                <input class="form-bot-default close-modal" id="confirm-payment-submit" type="button"
                       value="<?php echo __("confirm"); ?>"/><br/><br/>
                <a href="javascript:void(0);" style="text-decoration: underline;" class="confirm-payment-close-btn"><?php echo __("confirm-payment-method-close"); ?></a>
            </div>
        </div>
    </div>
</div>

<!-- [S] Change Credit Number -->
<div id="promotion-ccw-popup-msg" class="installment modal fade" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-content">
        <!-- <div class="title">
            <div class="left">
                <h1><?php echo __("change_credit_num_header"); ?></h1>
            </div>
            <div class="right"><img class="close-modal confirm-payment-close-btn"
                                    src="<?php echo Theme::asset()->usePath()->url('images/close.png'); ?>" width="27"
                                    height="27"/>
            </div>

        </div>
        -->

        <div class="content">
            <div class="right"><img class="close-modal confirm-payment-close-btn"
                                    src="<?php echo Theme::asset()->usePath()->url('images/close.png'); ?>" width="27"
                                    height="27"/>
            </div>
            <div class="clear"></div>
            <p><img class=""
                    src="<?php echo Theme::asset()->usePath()->url('images/warning_icon_s.png'); ?>" width="50"
                    height="50"/></p>
            <p class="installment__main-text" style="color:red;">
                <?php echo __("change_credit_num_description"); ?>
            </p>

            <div class="installment-ccw-box-control">
                <input class="form-bot-default close-modal" id="close-btn" type="button"
                       value="<?php echo __("ok"); ?>"/><br/><br/>
            </div>
        </div>
    </div>
</div>
<!-- [E] Change Credit Number -->