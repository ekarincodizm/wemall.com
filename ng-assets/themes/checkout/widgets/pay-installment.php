<?php

// prepared data
$installment_bank_id = array_get($installment, 'bank_id');
$installment_period = array_get($installment, 'period');

$bank_pattern['kbank'] = array(
    'id_ref' => 'rdo_kbank',
    'icon' => '/themes/checkout/assets/images/icn/k_bank.png',
    'name' => __('step3-kbank'));
$bank_pattern['bay'] = array(
    'id_ref' => 'rdo_krungsri',
    'icon' => '/themes/checkout/assets/images/icn/krungsri_bank.png',
    'name' => __('bank-krungsri'));
$bank_pattern['centralcard'] = array(
    'id_ref' => 'rdo_central',
    'icon' => '/themes/checkout/assets/images/icn/central.png',
    'name' => __('bank-central'));
$bank_pattern['firstchoice'] = array(
    'id_ref' => 'rdo_firstchoice',
    'icon' => '/themes/checkout/assets/images/icn/firstchoice.png',
    'name' => __('bank-firstchoice'));
$bank_pattern['tescolotus'] = array(
    'id_ref' => 'rdo_tesco',
    'icon' => '/themes/checkout/assets/images/icn/tesco.png',
    'name' => __('bank-tescolotus'));
$bank_pattern['ktc'] = array(
    'id_ref' => 'rdo_ktc',
    'icon' => '/themes/checkout/assets/images/icn/ktc_bank_new.png',
    'name' => __('bank-ktc'));
$bank_pattern['bbl'] = array(
    'id_ref' => 'rdo_bbl',
    'icon' => '/themes/checkout/assets/images/icn/bbl_bank_new.png',
    'name' => __('bank-bbl'));

?>
<div id="instalment" class="tab-pane">

    <div class="installment--head">
        <div class="form-max-info-2 installment--title">
            <span><?php echo __("step3-please-choose-installment-bank-title"); ?></span>
        </div>
    </div>

    <div class="installment--content">
        <div class="bank-list__container form-max-info-2 inst-bank-list"
             data-bank="<?php echo $installment_bank_id; ?>"
             data-period="<?php echo $installment_period; ?>">

            <?php foreach ($bank_show as $bank_index => $bank_data): $bank_name = array_get($bank_data, 'abbreviation'); if (empty($bank_name)) continue; if (!isset($bank_pattern[$bank_name])) continue; ?>
            <div class="bank-list">
                <input type="radio" name="radiog_lite" <?php if($installment_bank_id == $bank_data['id']){ echo 'checked'; }?>
                       class="css-checkbox install_bank"
                       id="<?php echo $bank_pattern[$bank_name]['id_ref']; ?>"
                       value="<?php echo $bank_data['id'];?>"
                       autocomplete="off"
                       data-abbreviation="<?php echo $bank_name; ?>">
                <label for="<?php echo $bank_pattern[$bank_name]['id_ref']; ?>" class="css-label radGroup1 radGroup1 clr">
                    <img class="bank--icn" src="<?php echo $bank_pattern[$bank_name]['icon']; ?>"/>
                    <span class="bank--name"><?php echo $bank_data['name']; ?></span>
                </label>
            </div>
            <?php endforeach;?>

            <div class="clear"></div>
        </div>
    </div>

    <div class="clear"></div>

    <div id="installment-period-container" <?php if(empty($installment_bank_id)) { echo 'style="display:none;"'; } ?>>
        <?php $bank_abbr = array_get($bank_show, $installment_bank_id.".abbreviation"); ?>
        <div>
            <div class="form-max-info-2">
                <h1 class="clr-2"><?php echo __("step3-you-choose-installment-bank"); ?>
                    <span class="installment-current-bank-name">
                    <?php echo __("bank-installment-" .$bank_abbr ); ?>
                    </span>
                </h1>
            </div>
        </div>

        <div class="form-max-info-2">
            <?php echo __("step3-installment-desc1"); ?>
            <span class="installment-current-bank-name"><?php echo __("bank-installment-" .$bank_abbr); ?></span>
            <?php echo __("step3-installment-desc2"); ?>
        </div>

        <div class="form-max-info-2" style="width:500px;">
            <select name="pay_per_month" id="pay_per_month" class="select-new" autocomplete="off"
                    data-url="<?php echo URL::toLang('ajax/checkout/set-customer-info', array(), Config::get("https.useHttps")); ?>"
                    title="<?php echo __("inst-required-pay-per-month"); ?>">
                <option value=""><?php echo __("inst-pay-per-month"); ?></option>
                <?php foreach($periods_option as $month => $price ):?>
                <option value="<?php echo $month; ?>" <?php if($month == $installment_period){ echo 'selected'; }?>>
                <?php echo __("pay_monthly_per_month", array(
                    "monthly" => $month,
                    "paymonth" => number_format( $price, 2 , "." , "," ))); ?>
                </option>
                <?php endforeach;?>
            </select>
        </div>
    </div>

    <div class="box-sub-divider clear"></div>
</div>
