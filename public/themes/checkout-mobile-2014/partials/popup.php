<?php echo Theme::widget("manageItemForPaymentLightbox", array())->render(); ?>

<?php echo Theme::widget("manageCampaignProductLightbox", array())->render(); ?>

<!-- [S] payment confirm popup -->
<div class="modal fade" id="confirm-payment-popup-msg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo __("confirm-payment-method-title"); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo __("confirm-payment-method-desc1"); ?> "<span id="confirm-payment-popup-text"></span>"</p>
                <!-- button confirm -->
                <div class="row button-confirm">
                    <div class="col-xs-12">
                        <a href="javascript:void(0);" id="confirm-payment-submit"><?php echo __("confirm"); ?></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12" style="text-align: center;">
                        <a href="javascript:void(0);" class="confirm-payment-close-btn"><?php echo __("confirm-payment-method-close"); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [E] payment confirm popup -->

<!-- [S] Change Credit Number -->
<div class="modal fade" id="promotion-ccw-popup-msg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo __("change_credit_num_header"); ?></h4>
            </div>
            <div class="modal-body">
                <p style="text-align:center"><img class=""
                     src="<?php echo Theme::asset()->usePath()->url('img/icon_error.png'); ?>" width="50"
                     height="50"/></p>
                <p style="color:red;"><?php echo __("change_credit_num_description_mobile"); ?> <span id="promotion-ccw-popup-text"></span></p>
                <!-- button confirm -->
                <div class="row button-confirm">
                    <div class="col-xs-12">
                        <a href="javascript:void(0);" id="close-btn"><?php echo __("ok"); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [E] Change Credit Number -->
