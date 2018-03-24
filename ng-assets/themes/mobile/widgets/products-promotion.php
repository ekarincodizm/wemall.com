<!-- Promotion -->
<?php if(!empty($data_periods)):?>
    <?php foreach($data_periods as $key => $row):?>
    <div class="col-xs-12">
        <div class="row row-promotion ">
            <div class="pro-header"><?php echo __('instalment-0-percent'); ?> <span class="discount_period"><?php echo $row['month']; ?></span> <?php echo " " . __('month'); ?></div>
            <?php foreach($row['bank'] as $b_key => $b_row):?>
                <?php
                $icn_install = '';
                if($b_row['abbreviation'] == 'kbank'):
                    $icn_install = 'inst_kbank.png';
                elseif($b_row['abbreviation'] == 'bay'):
                    $icn_install = 'inst_bay.png';
                elseif($b_row['abbreviation'] == 'centralcard'):
                    $icn_install = 'inst_central.png';
                elseif($b_row['abbreviation'] == 'firstchoice'):
                    $icn_install = 'inst_firstchoice.png';
                elseif($b_row['abbreviation'] == 'tescolotus'):
                    $icn_install = 'inst_tesco.png';
                elseif($b_row['abbreviation'] == 'ktc'):
                    $icn_install = 'inst_ktc.jpg';
                elseif($b_row['abbreviation'] == 'bbl'):
                    $icn_install = 'inst_bbl.png';
                endif;
                ?>
            <div class="col-xs-4 inst_bank inst_month_<?php echo $row['month']; ?>">
                <img src="<?php echo '/themes/itruemart/assets/images/icn/'.$icn_install; ?>" alt="ผ่อน <?php echo $b_row['name'];?> 0% <?php echo $row['month']; ?> เดือน" />
                <p><?php echo __('pay-per-month'); ?></p>
                <p class="amount"><span class="pay_per_month">-</span><span>/<?php echo __("month");?></span></p>
            </div>
            <?php endforeach;?>
        </div>
    </div>
    <?php endforeach;?>
    <span style="display: block;font-size: 16px; color: #959595; font-style: italic;">
        * <?php echo __("instalment-note");?>
    </span>
<?php endif; ?>

<?php if (!empty($allow)): ?>
    <!--<div class="row">
        <div class="col-xs-12">
            <h1 style="color:#95c126;">
                <?php echo __('Special Offers and Product Promotions'); ?>
            </h1>
        </div>

        <?php foreach($promotions as $promotion) { ?>
            <div class="col-xs-12">
                <div class="row row-promotion">
                    <div class="pro-header">
                        <?php echo __('instalment-0-percent') . ", " . $promotion['period'] . " " . __('month'); ?>
                    </div>

                    <div class="col-xs-4">
                        <img src="<?php echo Theme::asset()->usePath()->url('img/bank_02.jpg'); ?>">
                        <p><?php echo __('pay-per-month'); ?></p>
                        <span class="amount">
                            <?php echo price_format($promotion['pay']); ?>
                            <span>/<?php echo __('month'); ?></span>
                        </span>
                    </div>
                </div>
                <span style="display: block;font-size: 16px; color: #959595; font-style: italic;">
                    <?php echo __("instalment-note");?>
                </span>
            </div>
        <?php } ?>

    </div> -->
<?php endif; ?>
