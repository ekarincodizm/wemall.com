<?php //echo $addressList;?>
<?php
if (
    ! empty($address['customer_name']) OR
    ! empty($address['customer_tel']) OR
    ! empty($address['customer_province_id']) OR
    ! empty($address['customer_city_id']) OR
    ! empty($address['customer_district_id']) OR
    ! empty($address['customer_address']) OR
    ! empty($address['customer_postcode'])
) : ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#add-address-frm').find('input, select, textarea').each(function(){
            elemId = $(this).attr('id');
            if (elemId == "name" ||
                elemId == "telephone" ||
                elemId == "province-control" ||
                elemId == "district-control" ||
                elemId == "sub-district-control" ||
                elemId == "zip-code-control" ||
                elemId == "address" ||
                elemId == "email"
                )
            {
                $(this).valid();
            }
        });
    });
</script>
<?php endif; ?>
<style>
.icon-success {
	left: 559px;
	position : absolute;
	top: 10px;
}
.edit-box, .edit-box a{
    color: #3705FF;
}
</style>
<div class="row">
     <div class="inc-payment-title"><?php echo __("step2-enter-shipping-address"); ?></div>
</div>
 <div class="profile" id="fill-address-form">
     <form id="add-address-frm" method="post" action="<?php echo URL::toLang('checkout/step2'); ?>" data-save-url="<?php echo URL::toLang('ajax/customers/save-ship-addr'); ?>" style="overflow:inherit">
     <input type="hidden" name="hidden_address_id"  id="hidden_address_id" >
        <?php if(!empty($addressList['data'])): ?>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-5 control-label" for="list-addr"><?php echo __('step2-choose-shipping-address'); ?> :</label>
                <div class="col-sm-7" id="address_list_container" data-href="<?php echo Url::route('ajax.post.customer.saveaddr'); ?>">
                        <select name="shipping_address_list" id="selected-ship-addr" class="select-new form-control" data-edit-href="<?php echo URL::toLang('ajax/customers/edit-ship-addr'); ?>" autocomplete="off">
                            <option value=""><?php echo __("add address");//'เพิ่มที่อยู่ใหม่'; ?></option>
                            <?php if(!empty($addressList['data'])): ?>
                                <?php foreach($addressList['data'] as $key => $value): ?>
                                    <option value="<?php echo $value['customer_addresses_id']; ?>"><?php echo $value['customer_name']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                </div>
            </div>
        </div>
        <div class="clearfix"> </div>
        <?php endif; ?>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-5 control-label" for="fullname"><?php echo __("step2-firstname-lastname"); ?> <span class="text-red-1">*</span> :</label>
                <div class="col-sm-7" style="position: relative;"><input class="input-box form-control  " maxlength="40" id="name" name="name" type="text" placeholder="<?php echo __("step2-firstname-lastname-placeholder"); ?>"  value="<?php echo $address['customer_name']; ?>"/></div>
            </div>
            <div class="form-group">
                  <label class="col-sm-5 control-label" for="province"><?php echo __("step2-province"); ?> <span class="text-red-1">*</span> :</label>
                  <div class="col-sm-7" style="position: relative;">
                        <select name="province" id="province-control" class="select-new form-control" data-url="<?php echo URL::toLang('ajax/customers/addr'); ?>" autocomplete="off">
                            <option value=""><?php echo __("step2-select-province"); ?></option>
                            <?php if(!empty($provincesList)): ?>
                                <?php foreach($provincesList as $key => $province): ?>
                                    <option value="<?php echo $province['id']; ?>" <?php echo ($province['id'] == $address['customer_province_id']) ? 'selected="selected"' : ""; ?>><?php echo $province['name']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                  </div>
            </div>
            <div class="form-group">
                   <label class="col-sm-5 control-label" for="district">
                   <span id="district-name">
                    <?php if ( ! empty($address['customer_province']) && $address['customer_province'] == "กรุงเทพมหานคร") : ?>
                                    <?php echo __("step2-special-district"); ?>
                                    <?php else : ?>
                                    <?php echo __("step2-district"); ?>
                                    <?php endif; ?>
                   </span> <span class="text-red-1">*</span> :</label>
                   <div class="col-sm-7" style="position: relative;">
                        <select name="district" id="district-control" class="select-new form-control" data-url="<?php echo URL::toLang('ajax/customers/addr'); ?>" autocomplete="off">
                            <?php if ( ! empty($city)) : ?>
                                <option value=""><?php echo ( ! empty($address['customer_province']) && $address['customer_province'] == "กรุงเทพมหานคร") ? __("step2-select-city-special") : __("step2-select-city"); ?></option>
                                <?php foreach ($city as $key => $value) : ?>
                                    <option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $address['customer_city_id']) ? 'selected="selected"' : ''; ?>><?php echo $value['name']; ?></option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option value=""><?php echo ( ! empty($address['customer_province']) && $address['customer_province'] == "กรุงเทพมหานคร") ? __("step2-select-city-special") : __("step2-select-city"); ?></option>
                            <?php endif; ?>
                        </select>
                   </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 control-label" for="sub-district">
                            <span id="sub-district-name">
                                <?php if ( ! empty($address['customer_province']) && $address['customer_province'] == "กรุงเทพมหานคร") : ?>
                                <?php echo __("step2-special-subdistrict"); ?>
                                <?php else : ?>
                                <?php echo __("step2-subdistrict"); ?>
                                <?php endif; ?>
                            </span> :<span class="text-red-1">*</span> :</label>
                 <div class="col-sm-7" style="position: relative;">
                        <select name="subdistrict" id="sub-district-control" class="select-new form-control" data-url="<?php echo URL::toLang('ajax/customers/addr'); ?>" autocomplete="off">
                            <?php if ( ! empty($district)) : ?>
                            <option value=""><?php echo ( ! empty($address['customer_province']) && $address['customer_province'] == "กรุงเทพมหานคร") ? __("step2-select-district-special") : __("step2-select-district"); ?></option>
                            <?php foreach ($district as $key => $value) : ?>
                                <option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $address['customer_district_id']) ? 'selected="selected"' : ""; ?>><?php echo $value['name']; ?></option>
                            <?php endforeach; ?>
                            <?php else : ?>
                                <option value=""><?php echo ( ! empty($address['customer_province']) && $address['customer_province'] == "กรุงเทพมหานคร") ? __("step2-select-district-special") : __("step2-select-district"); ?></option>
                            <?php endif; ?>
                        </select>
                 </div>
             </div>
            <div class="form-group">
                <label class="col-sm-5 control-label" for="zip-code"><?php echo __("step2-zipcode"); ?><span class="text-red-1">*</span> :</label>
                <div class="col-sm-7" style="position: relative;">
                        <select name="zip_code" id="zip-code-control" class="select-new form-control" autocomplete="off">
                            <?php if ( ! empty($zip_code)) : ?>
                                <option value=""><?php echo __("step2-select-zipcode"); ?></option>
                                <?php foreach ($zip_code as $key => $value) : ?>
                                <option value="<?php echo $value['zipcode']; ?>" <?php echo ($value['zipcode'] == $address['customer_postcode']) ? 'selected="selected"' : ""; ?>><?php echo $value['zipcode']; ?></option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option value=""><?php echo __("step2-select-zipcode"); ?></option>
                            <?php endif; ?>
                        </select>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
            <label class="col-sm-5 control-label" for="addr"> <?php echo __("step2-address-box"); ?> <span class="text-red-1">*</span> :</label>
            <div class="col-sm-7" style="position: relative;">
                <textarea name="address" maxlength="150" id="address" class="input-box  form-control  form-address" placeholder="<?php echo __("step2-address-box-placeholder"); ?>"><?php echo $address['customer_address']; ?></textarea>
                <div style="color: #000000;font-size: 10px;padding: 5px 5px 0;">*Max. 150 characters</div>
            </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6 inc-collect-addr">
            <div class="form-group">
            <label class="col-xs-5 col-sm-5 control-label" for="">จัดเก็บที่อยู่ในการจัดส่ง<span class="text-red-1">*</span> :</label>
            </div>
        </div>
        <div class="col-sm-6 inc-contact">
            <div class="form-group">
                <div class="inc-contact-title"><?php echo __("step2-phone-number"); ?></div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 control-label" for="phone"> <?php echo __("step2-phone-number"); ?><span class="text-red-1">*</span> :</label>
                <div class="col-sm-7" style="position: relative;"><input id="telephone" class="input-box form-control  " maxlength="10" name="phone_number" type="text" placeholder="<?php echo __("step2-phone-number-placeholder"); ?>"  value="<?php echo $address['customer_tel']; ?>" /></div>
            </div>


            <div class="form-group" id="email_txt">
                <div class="inc-contact-title"><?php echo __("email");?></div>
            </div>
            <div class="form-group" id="email_val">
                <label class="col-sm-5 control-label" for="email"> <?php echo __("Enter your email address"); ?><span class="text-red-1">*</span> :</label>
                <div class="col-sm-7" style="position: relative;">
                    <?php
                        $customer_email = "";
                        if(isset($address['customer_email']) && !preg_match("/\@truelife.com$/", $address['customer_email'])){
                            $customer_email = $address['customer_email'];
                        }
                    ?>
                    <input id="email" class="input-box form-control  " name="email" type="text" placeholder="<?php echo __("Enter your email address"); ?>"  value="<?php echo $customer_email; ?>" />
                </div>
            </div>

            <div class="col-xs-12 col-sm-9 col-sm-pull-3">
            <?php echo Theme::widget("miniCart", array('cart' => $cart,'checkout' => $checkout,'step'=>'2'))->render(); ?>
            </div>
            <div class="left edit-box">
                <a href="<?php echo URL::toLang("cart?q=step2");?>">
                    <?php echo __("cart-edit-btn");?>
                </a>
            </div>
            <div id="inc-action-box" style="padding:0px;">
                      <input class="inc-btn" name="btnSave" id="btnSave" type="submit" value="<?php echo __('Continue');?>" />
             </div>
        </div>
     </form>

 </div>