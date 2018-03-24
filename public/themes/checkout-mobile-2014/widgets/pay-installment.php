
<div class="payment-channel">

    <input type="radio" name="payment_channel" value="installment" id="installment" autocomplete="off" <?php /*if(strtolower($checkout['payment_method_code']) == 'ccinstm'){ echo 'checked';};*/ ?> />
    <label for="installment">
        <img src="<?php echo Theme::asset()->usePath()->url("img/icon-installments-ph.png"); ?>" class="ico_payment_channel"/>
        <span class="payment-name">Installment (Visa/Master)</span>
    </label>


    <div class="divider-menu" id="box-installment">
        <div id="installment-payment-error" style="display: none;" class="clear-error-msg"></div>
        <div class="add-remark" id="installment-payment-block" style="display:none;">
            <h3><?php echo __("step3-please-choose-installment-bank-title"); ?></h3>

            <?php if(!empty($bank_show)): ?>
                <select class="form-control bank-dd-list" id="installment_bank" name="installment_bank" autocomplete="off" >
                    <option id="dd-list-option" <?php if(empty($bank_id)){ echo 'selected="selected"'; } ?> value="" >
                        <?php echo __('mobile-step3-select-bank');?>
                    </option>
                    <?php foreach($bank_show as $bl_key => $bl_row): ?>
                        <option value="<?php echo $bl_row['id'];?>"
                            <?php if($bank_id == $bl_row['id']){echo 'selected=selected';}?>
                                data-abbreviation="<?php echo $bl_row['abbreviation']; ?>"
                                data-image="<?php echo Theme::asset()->usePath()->url("img/".$bank_images[$bl_row['abbreviation']]); ?>">
                            <?php echo __('bank-'.$bl_row['abbreviation']);?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>

            <div class="bank-installment-detail">
                <h3><?php echo __("step3-you-choose-installment-bank"); ?><span class="installment-current-bank-name"><?php echo __("bank-installment-" . $activeInstallmentBank); ?></span></h3>
                <p>
                    <?php echo __("step3-installment-desc1"); ?><span class="installment-current-bank-name"><?php echo __("bank-installment-" . $activeInstallmentBank); ?></span>
                    <?php echo __("step3-installment-desc2"); ?>
                </p>
                <select class="form-control instalment-list" name="pay_per_month" id="pay_per_month" autocomplete="off">
                    <option selected="selected" value="" data-abbreviation=""><?php echo __("inst-pay-per-month"); ?></option>
                    <?php
                        $totalDiscount = 0;
                        if( !empty($checkout['discount']) ){
                            $totalDiscount = $checkout['discount'];
                        }
                        foreach($periods_option as $po_key => $po_row ):
                    ?>
                            <option value="<?php echo $po_key; ?>" <?php if($po_key == $periods_val){echo 'selected';}?>>
                            <?php echo __("pay_monthly_per_month",
                                array(
                                    "monthly" => $po_key,
                                    //"paymonth" => number_format( round(( ($installTotalPriceActive[$po_row]-$totalDiscount) / $po_row), 2), 2 , "." , "," )  ));
                                    "paymonth" => number_format( $po_row, 2 , "." , "," )  )); ?>
                        </option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="clear-error-msg" id="conflict_month"></div>
    </div>
</div>