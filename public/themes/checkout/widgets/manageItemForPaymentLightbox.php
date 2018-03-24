<!--<a href="javascript:void(0);" class="show-manageitempayment-btn">ห้ามลบ เหน่งใช้แสดง lightbox</a>-->

<!-- Cart Popup Delete List -->
<div id="cart-popup-select" class="cart-select modal fade" role="dialog" aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="title bdr-btm-none">
                <div class="left">
                    <h1><?php echo __("manage-item-warning-title-1"); ?> “<span id="manage-itempayment-title"
                                                                                class="manage-itempayment-title"></span>” <?php echo __("manage-item-warning-title-2"); ?>
                    </h1>
                </div>
                <div class="right">
                    <a href="javascript:void(0);" class="close-manage-item-lightbox">
                        <img class="close-modal" src="<?php echo Theme::asset()->usePath()->url('images/close.png'); ?>"
                             width="27" height="27"/>
                    </a>
                </div>
                <div class="clear"></div>
            </div>
            <div class="cart-box">
                <div class="cart-title"><?php echo __("manage-item-you-have-item"); ?> (<span
                        id="manage-itempayment-allow-count"></span> <?php echo __("list_unit"); ?>) <?php echo __("manage-item-you-have-item2"); ?>
                </div>
                <div class="cart-item">
                    <div class="cart-item__heading--alert">
                        <img class="icn-type"
                             src="<?php echo Theme::asset()->usePath()->url("images/icn/close-msgbox.png"); ?>"/>
                        <span class="text--alert"><?php echo __("manage-item-notallow-title"); ?> “<span
                                class="manage-itempayment-title"></span>” <?php echo __("manage-item-warning-title-2"); ?>
                            (<span class="manage-itempayment-notallow-count"></span> <?php echo __("list_unit"); ?>
                            )</span>
                        <a href="javascript:void(0);"
                           class="cart-item__text-delete manage-itempayment-delete-btn"><?php echo __("manage-item-remove-title"); ?></a>
                    </div>
                    <div class="cart-item__content--alert" id="manage-itempayment-notallow-list">
                        <!-- put no allow item here -->

                        <div class="cart-title-footer">
                            <a href="javascript:void(0);"
                               class="cart-item__text-delete manage-itempayment-delete-btn"><?php echo __("manage-item-remove-title"); ?></a>
                        </div>
                    </div>
                </div>
                <div class="cart-item">
                    <div class="cart-item__heading--default">
                        <img class="icn-type"
                             src="<?php echo Theme::asset()->usePath()->url("images/icn/pass.png"); ?>"/>
                        <span class="text--default"><?php echo __("manage-item-allow-title"); ?> “<span
                                class="manage-itempayment-title"></span>” <?php echo __("manage-item-warning-title-2"); ?>
                            (<span id="manage-itempayment-allow-count"></span> <?php echo __("list_unit"); ?>
                            )</span>
                    </div>
                    <div class="cart-item__content--default" id="manage-itempayment-allow-list">
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

<!-- Installment Popup -->
<div id="popup-msg" class="confirm-delete-itm-dialog installment modal fade" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-content">
        <div class="title">
            <div class="left">
                <h1><?php echo __("manage-item-confirm-title"); ?></h1>
            </div>
            <div class="right"><img class="close-modal confirm-close-btn"
                                    src="<?php echo Theme::asset()->usePath()->url('images/close.png'); ?>" width="27"
                                    height="27"/>
            </div>
            <div class="clear"></div>
        </div>
        <div class="content">
            <p class="installment__main-text">
                <?php echo __("manage-item-confirm-msg1"); ?> (<span
                    class="manage-itempayment-notallow-count"></span> <?php echo __("list_unit"); ?>​)
                <br/><?php echo __("manage-item-confirm-msg2"); ?> "<span
                    class="manage-itempayment-title"></span>" <?php echo __("manage-item-confirm-msg3"); ?>
            </p>

            <div class="installment-box-control">
                <input class="form-bot-default close-modal confirm-itempayment-delete-btn" type="button"
                       value="<?php echo __("confirm"); ?>"/>
                <input class="form-bot-cancel close-modal confirm-close-btn" type="button"
                       value="<?php echo __("cancel"); ?>"/>
            </div>
        </div>
    </div>
</div>
<!-- /Installment Popup -->

