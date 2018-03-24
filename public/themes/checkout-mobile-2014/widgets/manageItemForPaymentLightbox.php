<!-- error-message popup | using bootstrap framework: Modal -->
<div class="modal fade" id="error-message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo __("manage-item-warning-title-1"); ?>
                    “<span id="manage-itempayment-title"></span>”
                    <?php echo __("manage-item-warning-title-2"); ?>
                </h4>
            </div>
            <div class="modal-body">
                <h4 class="header warning">
                    <img src="<?php echo Theme::asset()->usePath()->url('img/error_mes_icon_wrong.png'); ?>">
                    <span class="text--alert">
                        <?php echo __("manage-item-notallow-title"); ?>
                        “<span class="manage-itempayment-title"></span>” <?php echo __("manage-item-warning-title-2"); ?>
                        (<span class="manage-itempayment-notallow-count"></span> <?php echo __("list_unit"); ?>)
                    </span>
                </h4>

                <div class="noallow-product-list" id="manage-itempayment-notallow-list">

                </div>

                <!-- button delete -->
                <div class="row button-delete">
                    <div class="col-xs-12" id="btn-delete-cart-popup"><a href="javascript:void(0);"><?php echo __("manage-item-remove-title"); ?></a></div>
                </div>

                <h4 class="header"><img src="<?php echo Theme::asset()->usePath()->url("img/error_mes_icon_right.png"); ?>">
                    <span class="text--default"><?php echo __("manage-item-allow-title"); ?> “<span
                            class="manage-itempayment-title"></span>” <?php echo __("manage-item-warning-title-2"); ?>
                        (<span id="manage-itempayment-allow-count"></span> <?php echo __("list_unit"); ?>)
                    </span>
                </h4>

                <div class="allow-product-list" id="manage-itempayment-allow-list">

                </div>

            </div>
        </div>
    </div>
</div>
<!-- confirm popup-->
<div class="modal fade" id="confirm-message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo __("manage-item-confirm-title"); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo __("manage-item-confirm-msg1"); ?> (<span
                        class="manage-itempayment-notallow-count"></span> <?php echo __("list_unit"); ?>​)
                    <br/><?php echo __("manage-item-confirm-msg2"); ?> "<span
                        class="manage-itempayment-title"></span>" <?php echo __("manage-item-confirm-msg3"); ?></p>
                <!-- button confirm -->
                <div class="row button-confirm">
                    <div class="col-xs-12"><a href="javascript:void(0);" class="confirm-itempayment-delete-btn" data-inventory-ids="" ><?php echo __("confirm"); ?></a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- confirm popup-->