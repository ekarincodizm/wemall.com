<script type="text/javascript">
    $(function() {
        $('select[name=pay_per_month]').change(function() {
            $.post(
                    '/ajax/checkout/set-customer-info',
                    {
                        installment: $(this).val()
                    },
            function(data) {

            },
                    'html'
                    );
        });

    });
</script>
<div class="payment-channel">
	<input type="radio" name="payment_channel" value="install" id="install" checked="checked" />
	<label for="instalment">
		<img src="<?php echo Theme::asset()->usePath()->url('images/ico-installments.png');?>" class="ico_payment_channel" />
		<span class="payment-name">ผ่อนชำระรายเดือน<br/><small>Instalment</small></span>
	</label>
	<div class="divider-menu">
		<div class="add-remark">
			<div class="radio">
				<label>
					<input type="radio" name="optionsRadios" class="bank" value="" checked="checked">
					<span>ธนาคารกสิกรไทย</span>
					<ul class="instalment-list">
						<li>
							<?php if (!empty($monthly_installment)): ?>
								<select class="form-control" name="pay_per_month">
									<?php foreach ($monthly_installment as $key => $value) : ?>
										<option <?php echo (!empty($cart['data']['installment']['period']) && $cart['data']['installment']['period'] == $value) ? 'selected="selected"' : ""; ?> value="<?php echo $value;?>"><?php echo __("pay_monthly_per_month", array("monthly" => $value, "paymonth" => round(($cart['data']['sub_total'] / $value), 2))); ?></option>
									<?php endforeach; ?>
								</select>
							<?php endif; ?>
						</li>
					</ul>
				</label>
			</div>
			<?php /*
			<div class="radio">
				<label>
					<input type="radio" name="optionsRadios" class="bank" value="">
					<span>ธนาคารไทยพาณิชย์</span>
					<ul class="instalment-list" style="display: none">
						<li><select class="form-control">
							<option>Pay 6 monthly instalments, for 1498.33 บาท per month</option>
						</select>
						</li>
					</ul>
				</label>
			</div>
			<div class="radio">
				<label>
					<input type="radio" name="optionsRadios" class="bank" value="">
					<span>ธนาคารกรุงเทพ</span>
					<ul class="instalment-list" style="display: none">
						<li><select class="form-control">
							<option>Pay 6 monthly instalments, for 1498.33 บาท per month</option>
						</select>
						</li>
					</ul>
				</label>
			</div>
			*/ ?>
		</div>
	</div>
</div>
<!-- <div class="payment-channel">
    <input type="radio" name="payment_channel" value="install" id="install"  />
    <label for="atm">
        <img src="http://www.itruemart.com/assets/itruemart_responsive/global/images/icon-bank-atm.jpg" align="left" class="icon-payment" />
        <span class="payment-name"><?php echo __("thankyou-ccinstm-payment-title"); ?></span>
    </label>
    <div class="divider-menu">
        <div class="add-remark">
            <?php if (!empty($monthly_installment)): ?>
                <?php foreach ($monthly_installment as $key => $value) : ?>
                    <div class="radio">
                        <label>
                            <input type="radio" name="pay_per_month" value="<?php echo $value; ?>" <?php echo (!empty($cart['data']['installment']['period']) && $cart['data']['installment']['period'] == $value) ? 'checked="checked"' : ""; ?>>
                            <span> <?php echo __("pay_monthly_per_month", array("monthly" => $value, "paymonth" => round(($cart['data']['sub_total'] / $value), 2))); ?></span>
                        </label>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
-->

