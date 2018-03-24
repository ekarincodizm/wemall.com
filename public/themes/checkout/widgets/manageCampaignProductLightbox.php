<!-- Cart Popup Delete List -->
<div id="campaign-product-lightbox" class="cart-select modal fade" role="dialog" aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="title bdr-btm-none">
                <div class="left">
                    <h1 id="campaign-product-lightbox-title"></h1>
                </div>
                <div class="right">
                    <a href="javascript:void(0);" class="close-campaign-item-lightbox">
                        <img class="close-modal" src="<?php echo Theme::asset()->usePath()->url('images/close.png'); ?>" width="27" height="27"/>
                    </a>
                </div>
                <div class="clear"></div>
            </div>
            <div class="cart-box">
                <div class="cart-title"><?php echo __("manage-item-you-have-item"); ?> (<span
                        id="manage-campaignproduct-all-count"></span> <?php echo __("list_unit"); ?>) <?php echo __("manage-item-you-have-item2"); ?>
                </div>
                <div class="cart-item" id="campaign-notallow-container">
                    <div class="cart-item__heading--alert">
                        <img class="icn-type"
                             src="<?php echo Theme::asset()->usePath()->url("images/icn/close-msgbox.png"); ?>"/>
                        <span class="text--alert" id="campaign-notallow-count"></span>
                        <a href="javascript:void(0);"
                           class="cart-item__text-delete btn-delete-campaignproduct-popup"><?php echo __("manage-item-remove-title"); ?></a>
                    </div>
                    <div class="cart-item__content--alert" id="manage-campaign-notallow-list">
                        <!-- put no allow item here -->

                        <div class="cart-title-footer">
                            <a href="javascript:void(0);"
                               class="cart-item__text-delete btn-delete-campaignproduct-popup"><?php echo __("manage-item-remove-title"); ?></a>
                        </div>
                    </div>
                </div>
                <div class="cart-item" id="campaign-allow-container">
                    <div class="cart-item__heading--default">
                        <img class="icn-type"
                             src="<?php echo Theme::asset()->usePath()->url("images/icn/pass.png"); ?>"/>
                        <span class="text--default" id="campaign-allow-count"></span>
                    </div>
                    <div class="cart-item__content--default" id="manage-campaign-allow-list">
                        <!-- put allow item here -->

                        <div class="cart-title-footer"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<!-- /Cart Popup Delete List -->

<div id="campaign-product-confirmation" class="installment modal fade" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-content">
        <div class="title">
            <div class="left">
                <h1><?php echo __("manage-item-confirm-title"); ?></h1>
            </div>
            <div class="right">
                <a href="javascript:void(0)" id="campaign-close-confirmation-dialog">
                    <img class="close-modal confirm-close-btn"
                                    src="<?php echo Theme::asset()->usePath()->url('images/close.png'); ?>" width="27"
                                    height="27"/>
                </a>
            </div>
            <div class="clear"></div>
        </div>
        <div class="content">
            <p class="installment__main-text">
                <?php echo __("manage-item-confirm-msg1"); ?> (<span
                    class="manage-campaignproduct-notallow-count"></span> <?php echo __("list_unit"); ?>​)
                <br/><?php echo __("manage-compaignproduct-confirm-msg2"); ?> <?php echo __("manage-item-confirm-msg3"); ?>
            </p>

            <div class="installment-box-control">
                <input class="form-bot-default close-modal" id="confirm-campaignproduct-delete-btn" type="button" data-inventory-ids=""
                       value="<?php echo __("confirm"); ?>"/>
                <input id="campaign-cancel-confirmation-dialog" class="form-bot-cancel close-modal confirm-close-btn" type="button"
                       value="<?php echo __("cancel"); ?>"/>
            </div>
        </div>
    </div>
</div>