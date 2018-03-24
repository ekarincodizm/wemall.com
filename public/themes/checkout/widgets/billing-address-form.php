<?php 
//	if (App::environment('production') || App::environment('beta'))
//	{
//		// The environment is production
//		$open_https = true;
//	}
//	else
//	{
//		$open_https = false;
//	}
        $open_https = Config::get("https.useHttps");
	$data_url = URL::toLang('ajax/customers/addr', array(), $open_https);
	$address = $cart['data']; 
?>
<?php if ( 
		! empty($address['bill_name']) OR
		! empty($address['bill_province_id']) OR
		! empty($address['bill_city_id']) OR
		! empty($address['bill_district_id']) OR 
		! empty($address['bill_address']) OR 
		! empty($address['bill_postcode'])
	) : ?>
	<script type="text/javascript">
		$(function(){

			$('#form-payment').find('input, select, textarea').each(function(){
            elemId = $(this).attr('id');            
            if (elemId == "bill_name" ||
                elemId == "bill_province_id" ||
                elemId == "bill_city_id" ||
                elemId == "bill_district_id" ||
                elemId == "bill_address" ||
                elemId == "bill_postcode"                 
                )
            {
                $(this).valid();
            }
        });    
		});
	</script>
<?php endif; ?>
<div>	
	<div>
		<p class="control-label-info left"></p>
		<div class=" form-max-info">
			<input type="checkbox" name="add_invoice" id="add-invoice" class="inv-addr" value="Y" autocomplete="off" 
				<?php
					if($cart['data']['bill_same_shipping'] == 'Y')
					{
						echo 'checked';
					}
				?>
			/>
			<label for="add-invoice" class="control-select clr-3"><?php echo __('step3-other-billing-address'); ?></label>
		</div>
	</div>

	<div class="invoice-info">	
		<div>
			<p class="control-label-info left">&nbsp;</p>
			<div class=" form-max-info-2">
				<h1 class="clr-2"><?php echo __('step3-billing-address'); ?></h1>
			</div>
		</div>
		<!--<div>
			<p class="control-label-info left">&nbsp;</p>
			<div class="form-max-info invoice-process">
				<p>
				</p><h1 class="clr-2">ที่อยู่ในการออกใบเสร็จ/ใบกำกับภาษี</h1>
				<p></p>
			</div>
		</div>-->
		<div>
			<p class="control-label-info left">
				<label for="inv-name" class="control-label-name"><?php echo __('step3-billing-name-surname'); ?> : </label>
			</p>
			<div class="form-max-info">
				<input class="input-info" maxlength="70" name="bill_name" id="bill_name" id="inv-name" type="text" placeholder="<?php echo __('step3-type-billing-name-surname'); ?>" value="<?php echo !empty($cart['data']['bill_name'])? $cart['data']['bill_name']:''; ?>" autocomplete="off" />
			</div>
		</div>
		<!--
		<div>
			<p class="control-label-info left">
				<label for="inv-telephone" class="control-label-name"><?php echo __('step3-mobile-phone'); ?> : </label>
			</p>
			<div class=" form-max-info">
				<input class="input-info" name="billing_tel" maxlength="15" id="inv-telephone" type="text" placeholder="<?php echo __('step3-phone'); ?>" />
			</div>
		</div>
		-->
		<div>
			<p class="control-label-info left">
				<label for="province" class="control-label-name"><?php echo __('step3-province'); ?> : </label>
			</p>
			<div class=" form-max-info">
				<select id="bill_province_id" name="bill_province_id" class="select-new" autocomplete="off" data-url="<?php echo $data_url; ?>">
					<!--[S] Province Option -->
<!--					<option value="">--><?php //echo __("step2-select-province"); ?><!--</option>-->
					<?php if(!empty($provincesList)): ?>
						<?php foreach($provincesList as $key => $province): ?>
							<option value="<?php echo $province['id']; ?>" <?php echo ($province['id'] == $address['bill_province_id']) ? 'selected="selected"' : ""; ?>><?php echo $province['name']; ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
					<!--[E] Province Option -->
				</select>
			</div>
		</div>
		<div>
			<p class="control-label-info left">
				<label for="email" class="control-label-name" id="city-name">
<!--                    --><?php //if( $address['bill_province_id'] == 1 ): ?>
<!--                        --><?php //echo __('step3-special-district'); ?><!-- :-->
<!--                    --><?php //else: ?>
<!--                        --><?php //echo __('step3-district'); ?><!-- :-->
<!--                    --><?php //endif; ?>
                    <?php echo __('step3-district'); ?> :
                </label>
			</p>
			<div class=" form-max-info">
				<select id="bill_city_id" name="bill_city_id" class="select-new" autocomplete="off" data-url="<?php echo $data_url; ?>">
					<!--[S] District Option -->
					<?php if ( ! empty($city)) : ?>
					<option value=""><?php echo __("step2-select-city"); ?></option>
					<?php foreach ($city as $key => $value) : ?>
					<option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $address['bill_city_id']) ? 'selected="selected"' : ""; ?>><?php echo $value['name']; ?></option>
					<?php endforeach; ?>
					<?php else : ?>
					<option value=""><?php echo __("step2-select-city"); ?></option>
					<?php endif;  ?>
					<!--[E] District Option -->
				</select>
			</div>
		</div>
		<div>
			<p class="control-label-info left">
<!--				<label for="email" class="control-label-name" id="district-name">-->
<!--                    --><?php //if( $address['bill_province_id'] == 1 ): ?>
<!--                        --><?php //echo __('step3-special-sub-district'); ?><!-- :-->
<!--                    --><?php //else: ?>
<!--                        --><?php //echo __('step3-sub-district'); ?><!-- :-->
<!--                    --><?php //endif; ?>
<!--                </label>-->
                <?php echo __('step3-sub-district'); ?> :
			</p>
			<div class=" form-max-info">
				<select id="bill_district_id" name="bill_district_id" class="select-new" autocomplete="off" data-url="<?php echo $data_url; ?>">
					<!--[S] Sub District Option -->
					<?php if ( ! empty($district)) : ?>
					<option value=""><?php echo __("step2-select-district"); ?></option>
					<?php foreach ($district as $key => $value) : ?>
						<option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $address['bill_district_id']) ? 'selected="selected"' : ""; ?>><?php echo $value['name']; ?></option>
					<?php endforeach; ?>
					<?php else : ?>
						<option value=""><?php echo __("step2-select-district"); ?></option>
					<?php endif; ?>
					<!--[E] Sub District Option -->
				</select>
			</div>
		</div>
		<div>
			<p class="control-label-info left">
				<label for="email" class="control-label-name"><?php echo __('step3-post-code'); ?> : </label>
			</p>
			<div class=" form-max-info">
<!--				<select id="bill_postcode" name="bill_postcode" class="select-new"  onchange="" autocomplete="off">-->
<!--					<!--[S] Post Code Option -->
<!--					--><?php // if ( ! empty($zip_code)) : ?>
<!--						<option value="">--><?php //echo __("step2-select-zipcode"); ?><!--</option>-->
<!--						--><?php //foreach ($zip_code as $k => $v) : ?>
<!--							<option value="--><?php //echo $v['zipcode']; ?><!--" --><?php //echo ($v['zipcode'] == $address['bill_postcode']) ? 'selected="selected"' : ""; ?><!--><?php //echo $v['zipcode']; ?><!--</option>-->
<!--						--><?php //endforeach; ?>
<!--					--><?php //else : ?>
<!--						<option value="">--><?php //echo __("step2-select-zipcode"); ?><!--</option>-->
<!--					--><?php //endif;  ?>
<!--					<!--[E] Post Code Option -->
<!--				</select>-->
                <input class="input-info" name="bill_postcode" id="bill_postcode" type="text" maxlength="4" placeholder="<?php echo __('step2-select-zipcode'); ?>" value="<?php echo !empty($cart['data']['bill_postcode'])? $cart['data']['bill_postcode']:''; ?>" autocomplete="off" />
			</div>
		</div>
		<div>
			<p class="control-label-info left">
				<label for="email" class="control-label-name"><?php echo __('step3-address'); ?> : </label>
			</p>
			<div class=" form-max-info">
				<textarea rows="4" maxlength="150" id="bill_address" name="bill_address" class="input-box control-inv-addr" placeholder="<?php echo __('step2-address-box-placeholder'); ?>" autocomplete="off" ><?php echo !empty($cart['data']['bill_address'])? $cart['data']['bill_address']:''; ?></textarea>
                <div style="color: #000000;font-size: 10px;padding: 5px 5px 0;">*Max. 150 characters</div>
            </div>
		</div>
	</div>
</div>