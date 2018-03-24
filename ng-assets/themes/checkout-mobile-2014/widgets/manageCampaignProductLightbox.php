<!-- error-message popup | using bootstrap framework: Modal -->
<div class="modal fade" id="campaign-product-lightbox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="campaign-product-lightbox-title">

                </h4>
            </div>
            <div class="modal-body">
                <h4 class="header warning notallow-product-header">
                    <img src="<?php echo Theme::asset()->usePath()->url('img/error_mes_icon_wrong.png'); ?>">
                    <span class="text--alert" id="campaign-notallow-count">

                    </span>
                </h4>

                <div class="noallow-product-list" id="manage-campaign-notallow-list">

                </div>

                <!-- button delete -->
                <div class="row button-delete">
                    <div class="col-xs-12" id="btn-delete-campaignproduct-popup"><a href="javascript:void(0);"><?php echo __("manage-item-remove-title"); ?></a></div>
                </div>

                <h4 class="header allow-product-header">
                    <img src="<?php echo Theme::asset()->usePath()->url("img/error_mes_icon_right.png"); ?>">
                    <span class="text--default" id="campaign-allow-count">

                    </span>
                </h4>

                <div class="allow-product-list" id="manage-campaign-allow-list">

                </div>

            </div>
        </div>
    </div>
</div>
<!-- confirm popup-->
<div class="modal fade" id="campaign-product-confirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                        class="manage-campaignproduct-notallow-count"></span> <?php echo __("list_unit"); ?>​)
                    <br/><?php echo __("manage-compaignproduct-confirm-msg2"); ?> <?php echo __("manage-item-confirm-msg3"); ?></p>
                <!-- button confirm -->
                <div class="row button-confirm">
                    <div class="col-xs-12"><a href="javascript:void(0);" id="confirm-campaignproduct-delete-btn" data-inventory-ids="" ><?php echo __("confirm"); ?></a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- confirm popup-->