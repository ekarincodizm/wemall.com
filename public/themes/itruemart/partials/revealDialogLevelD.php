<div id="cart-adding" class="reveal-modal">
    <div class="font2 msg-header important-green-bg"><?php echo __("level-d-dialog-wating"); ?></div>
</div>
<div id="cart-alert" class="reveal-modal">
	<div class="font2 msg-header-danger text-center alert-title"></div>
	<div id="popup_message" class="alert-message"></div>
	<div id="popup_panel">
		<input type="button" class="popup_ok btn btn-success" value="<?php echo __('ok'); ?>">
	</div>
</div>
<div id="cart-installment" class="reveal-modal">
    <div class="font2 msg-header"><?php echo __("level-d-dialog-installment-title"); ?></div>
    <div id="popup_content" class="basket_put font2">
        <div style="margin-top: 10px;">
                <p class="installment_message installment_message_1"><?php echo __("level-d-dialog-installment-txt1"); ?></p>
                <p class="installment_message installment_message_2"><?php echo __("level-d-dialog-installment-txt2"); ?></p>
        </div>
        <div id="popup_message">
            <?php if(!empty($product['media_contents'])): ?>
            <img src="<?php echo $product['media_contents'][0]['thumb']['thumbnails']['small']; ?>" alt="<?php echo $product['title']; ?>" class="img-cart">
            <?php endif; ?>

            <dl class="detail-cart">
                    <dt><?php echo __('items'); ?></dt>
                    <dd id="resp-product-title"><?php echo $product['title']; ?></dd>
            </dl>
            <div class="clearfix"></div>
        </div>
        <div id="popup_panel">
                <input type="button" class="popup_ok btn btn-success cart-installment-button cart-installment-button_ok" value="<?php echo __('ok');?>">
                <input type="button" class="popup_ok btn btn-success cart-installment-button cart-installment-button_add" value="<?php echo __("level-d-dialog-add-normal-product"); ?>">
                <input type="button" class="popup_ok btn cart-installment-button cart-installment-button_cancel" value="<?php echo __("level-d-dialog-cancel"); ?>">
        </div>
    </div>
</div>
<div id="cart-select-installment" class="reveal-modal">
    <div class="font2 msg-header important-green-bg"><?php echo __("level-d-dialog-select-installment-title"); ?></div>
    <div id="popup_content" class="basket_put font2">
        <div id="popup_message">
            <?php if(!empty($product['media_contents'])): ?>
                <img src="<?php echo $product['media_contents'][0]['thumb']['thumbnails']['small']; ?>" alt="<?php echo $product['title']; ?>" class="img-cart">
            <?php endif; ?>
            <dl class="detail-cart">
                    <dt><?php echo __('inst-alert-items'); ?></dt>
                    <dd id="resp-product-title"><?php echo $product['title']; ?></dd>
                    <dt><?php echo __("inst-alert-payment-method"); ?></dt>
                    <dd id="resp-product-title">
                        <label><input type="radio" name="cart-installment-select" class="cart-installment-select" value="installment" style="margin-right: 5px;" checked="checked" /><?php echo __("inst-pay-installment"); ?></label>
                        <label><input type="radio" name="cart-installment-select" class="cart-installment-select" value="normal" style="margin-right: 5px;" /><?php echo __("inst-pay-full"); ?></label>
                    </dd>
            </dl>
            <div class="clearfix"></div>
        </div>
        <div id="popup_panel">
                <input type="button" class="popup_ok btn btn-success cart-installment-button_next" value="<?php echo __("inst-next"); ?>">
        </div>
    </div>
</div>
