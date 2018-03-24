<?php //alert($payment_methods);?>
	<div class="productPayment_container">
		<p><?php echo __("Payment Channel");?></p>
		<ul class="productPayment_list">
            <?php if( !empty($payment_methods) ): ?>
                <?php foreach($payment_methods as $inkey => $inrow):?>
                    <?php if (strtolower($inrow['code']) == "ccinstm") : ?>
                        <li>
                            <img src="<?php echo Theme::asset()->usePath()->url('images/icn/detail_installment.png?291014'); ?>" alt="<?php echo __("payment_installment"); ?>" width="32"/>
                            <div class="productPayment_description">
                                <?php echo __("payment_installment"); ?><br/>
                            </div>
                        </li>
                    <?php
                        break;
                        endif;
                    ?>
                <?php endforeach;?>

                <?php foreach($payment_methods as $key => $row):?>
                <?php $clower = strtolower($row['code']);
                    switch ($clower) :
                    case 'ccw':
                    ?>
                        <li>
                            <img src="<?php echo Theme::asset()->usePath()->url('images/icn/detail_visa.png?291014'); ?>" alt="<?php echo __("payment_credit_card_1"); ?>" width="32"/>
                            <div class="productPayment_description">
                                <?php echo __("payment_credit_card_1"); ?><br/>
                                <span><?php echo __("payment_credit_card_2"); ?></span>
                            </div>
                        </li>
                    <?php
                    break;
                    case 'cs':
                    ?>
                        <li>
                            <img src="<?php echo Theme::asset()->usePath()->url('images/icn/detail_counterservice.png?291014'); ?>" alt="<?php echo __("payment_cs"); ?>" width="32"/>
                            <div class="productPayment_description">
                                <?php echo __("payment_cs"); ?>
                            </div>
                        </li>
                    <?php
                    break;
                    case 'atm':
                    ?>
                        <li>
                            <img src="<?php echo Theme::asset()->usePath()->url('images/icn/detail_atm.png?291014'); ?>"  alt="<?php echo __("payment_atm"); ?>" width="32"/>
                            <div class="productPayment_description">
                                <?php echo __("payment_atm"); ?>
                            </div>
                        </li>
                    <?php
                    break;
                    case 'ibank':
                    ?>
                        <li>
                            <img src="<?php echo Theme::asset()->usePath()->url('images/icn/detail_ibanking.png?291014'); ?>" alt="<?php echo __("payment_ibank"); ?>" width="32"/>
                            <div class="productPayment_description">
                                <?php echo __("payment_ibank"); ?>
                            </div>
                        </li>
                    <?php
                    break;
                    case 'cod':
                    ?>
                        <li>
                            <img src="<?php echo Theme::asset()->usePath()->url('images/icn/detail_cod.png?291014'); ?>" alt="<?php echo __("payment_cod"); ?>" width="32"/>
                            <div class="productPayment_description">
                                <?php echo __("payment_cod"); ?>
                            </div>
                        </li>
                    <?php
                    break;
                    case 'banktrans':
                    ?>
                        <li>
                            <img src="<?php echo Theme::asset()->usePath()->url('images/icn/detail_counterbank.png?291014'); ?>" alt="<?php echo __("payment_banktrans"); ?>" width="32"/>
                            <div class="productPayment_description">
                                <?php echo __("payment_banktrans"); ?>
                            </div>
                        </li>
                    <?php
                    break;
                    default:
                    ?>

                    <?php
                    endswitch;
                    ?>
                <?php endforeach; ?>
            <?php endif;?>
		</ul>
	</div>
