<div class="row">
    <div class="col-xs-12">
        <h2><?php echo __("step2-enter-shipping-address"); ?></h2>
    </div>
</div>
<div class="row address-field">
    <form id="add-address-frm" method="post" action="<?php echo URL::toLang('checkout/step2'); ?>"
          data-save-url="<?php echo URL::toLang('ajax/customers/save-ship-addr'); ?>">
        <div class="col-xs-12">
            <label class="control-label"><?php echo __("step2-firstname-lastname"); ?></label>
            <input id="name" name="name" type="text" class="form-control"
                   placeholder="<?php echo __("step2-firstname-lastname-placeholder"); ?>" value="<?php echo $address['customer_name']; ?>" />
        </div>
        <div class="col-xs-12">
            <label class="control-label"><?php echo __("step2-phone-number"); ?></label>
            <input id="telephone" maxlength="10" name="phone_number" type="text" class="form-control" placeholder="<?php echo __("step2-phone-number-placeholder"); ?>" value="<?php echo $address['customer_tel']; ?>" />
        </div>
        <div class="col-xs-12">
            <label class="control-label"><?php echo __("email"); ?></label>
            <input id="email" name="email" type="text" class="form-control" placeholder="<?php echo __("Enter your email address"); ?>" value="<?php echo $address['customer_email']; ?>" >
        </div>
        <div class="col-xs-12">
            <label class="control-label"><?php echo __("step2-province"); ?></label>
            <select class="form-control" id="province-control" name="province">
                <option value=""><?php echo __("step2-select-province"); ?></option>
                <?php if(!empty($provincesList)): ?>
                    <?php foreach($provincesList as $key => $province): ?>
                        <option value="<?php echo $province['id']; ?>" <?php echo ($province['id'] == $address['customer_province_id']) ? 'selected="selected"' : ""; ?>>
                            <?php echo $province['name']; ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-xs-12">
            <label class="control-label" id="city-label">
                <?php if (!empty($address['customer_province']) && $address['customer_province'] == "กรุงเทพมหานคร") : ?>
                    <?php echo __("step2-special-district"); ?>
                <?php else : ?>
                    <?php echo __("step2-district"); ?>
                <?php endif; ?>
            </label>
            <select class="form-control" id="city-control" name="city">
                <option value="" disabled="disabled">
                    <?php echo (!empty($address['customer_province']) && $address['customer_province'] == "กรุงเทพมหานคร") ? __("step2-select-city-special") : __("step2-select-city"); ?>
                </option>
                <?php if ( ! empty($city)) : ?>
                    <?php foreach ($city as $key => $value) : ?>
                        <option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $address['customer_city_id']) ? 'selected="selected"' : ''; ?>><?php echo $value['name']; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-xs-12">
            <label class="control-label" id="district-label">
                <?php if (!empty($address['customer_province']) && $address['customer_province'] == "กรุงเทพมหานคร") : ?>
                    <?php echo __("step2-special-subdistrict"); ?>
                <?php else : ?>
                    <?php echo __("step2-subdistrict"); ?>
                <?php endif; ?>
            </label>
            <select class="form-control" id="district-control" name="district">
                <option value="" disabled="disabled">
                    <?php echo (!empty($address['customer_province']) && $address['customer_province'] == "กรุงเทพมหานคร") ? __("step2-select-district-special") : __("step2-select-district"); ?>
                </option>
                <?php if ( ! empty($district)) : ?>
                    <?php foreach ($district as $key => $value) : ?>
                        <option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $address['customer_district_id']) ? 'selected="selected"' : ""; ?>><?php echo $value['name']; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-xs-12">
            <label class="control-label"><?php echo __("step2-zipcode"); ?></label>
            <select class="form-control" id="zip-code-control" name="zip_code">
                <option value="" disabled="disabled"><?php echo __("step2-select-zipcode"); ?></option>
                <?php if ( ! empty($zip_code)) : ?>
                    <?php foreach ($zip_code as $key => $value) : ?>
                        <option value="<?php echo $value['zipcode']; ?>" <?php echo ($value['zipcode'] == $address['customer_postcode']) ? 'selected="selected"' : ""; ?>><?php echo $value['zipcode']; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-xs-12">
            <label class="control-label"><?php echo __("step2-address-box"); ?></label>
            <textarea id="address" name="address" rows="4" class="form-control" placeholder="<?php echo __("step2-address-box-placeholder"); ?>"><?php echo $address['customer_address']; ?></textarea>
        </div>
    </form>
</div>

<!-- [S] minicart -->
<?php echo Theme::partial('minicart'); ?>
<!-- [E] minicart -->

<div class="row button-buy">
    <div class="col-xs-12">
        <a href="javascript:void(0);" class="force-text-decoration-none">
            <div class="button">
                <span id="submit-text"><?php echo __("Continue"); ?></span>
            </div>
        </a>
    </div>
</div>