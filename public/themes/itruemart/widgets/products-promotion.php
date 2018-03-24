<?php if( !empty($data_periods) && $installable ):?>
<div class="product__promotion">

    <h2 class="product__promotion_name">
        <?php
        $product_name = null;
        if(App::getLocale()=='th')
        {
            $product_name = array_get($product,'title');
        }
        else
        {
            if(array_get($product,'translate') != null)
            {
                $product_name =  array_get($product,'translate.title');
            }
            else
            {
                $product_name =  array_get($product,'title');
            }
        }
        ?>
        <?php echo __('Special Offers and Product Promotions'); ?>
    </h2>
    <div class="product__promotion_container">
        <?php foreach($data_periods as $key => $row):?>
            <?php
                if($group_count <= 3)
                {
                    $promotion_col = 1;
                }
                else
                {
                    $promotion_col = 1;
                }
            ?>
            <div rel="<?php echo $row['month'];?>" class="product__promotion_col-<?php echo $promotion_col;?>">
                <div class="product__promotion_item">
                    <p><?php echo __('instalment-0-percent') . ", "; ?>
                        <span class="discount_period"><?php echo $row['month']; ?></span><?php echo " " . __('month'); ?>
                    </p>
                    <div class="clearfix"></div>
                    <?php
                        $total_bank = count($row['bank']);
                        $css_installment = 'product__promotion_bank_col-5';
                        if($total_bank >= 6)
                        {
                            $css_installment = 'product__promotion_bank_col-6';
                        }
                    ?>
                    <?php foreach($row['bank'] as $b_key => $b_row):?>
                    <div class="<?php echo $css_installment;?>">
                        <ul class="product__promotion_bank">
                            <li class="product__promotion_bank_img">
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
                                <img src="<?php echo Theme::asset()->usePath()->url('images/icn/'.$icn_install); ?>" alt="ผ่อน <?php echo $b_row['name'];?> 0% <?php echo $row['month']; ?> เดือน" />
                            </li>

                            <li class="product__promotion_bank_inst_text"><?php echo __('pay-per-month'); ?></li>
                            <li class="product__promotion_bank_inst_amount"><span class="pay_per_month">-</span> / <?php echo __("month");?></li>
                        </ul>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <br/>

    <div>* <?php echo __('instalment-note'); ?></div>
</div>
<?php endif;?>
