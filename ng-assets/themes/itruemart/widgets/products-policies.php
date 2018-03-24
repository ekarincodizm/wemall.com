<?php
$is_active = ' class="active" ';
$tab_pane_active = ' active ';
?>
<div class="product__policy">
	<ul class="nav nav-tabs" role="tablist">
        <?php if (isset($policies['shipping'])): ?>

            <li <?php echo $is_active;?>>
                <a href="#freedelivery" role="tab" data-toggle="tab">
                    <img src="<?php echo Theme::asset()->usePath()->url('images/icn/free-delivery.png'); ?>" />
                    <span class="policy_title"><?php echo $policies['shipping']['title']; ?>
                    <h3 class="policy_sub_title"><?php echo $policies['shipping']['type']?></h3></span>
                </a>
            </li>
            <?php
            $is_active = '';
            ?>
        <?php endif; ?>
        <?php if (isset($policies['refund'])): ?>
            <li <?php echo $is_active;?>>
                <a href="#moneyback" role="tab" data-toggle="tab">
                    <img src="<?php echo Theme::asset()->usePath()->url('images/icn/money-back.png'); ?>" />
                    <span class="policy_title"><?php echo $policies['refund']['title']; ?>
                    <h3 class="policy_sub_title"><?php echo $policies['refund']['type']?></h3></span>
                </a>
            </li>
            <?php
            $is_active = '';
            ?>
        <?php endif; ?>
        <?php if (isset($policies['returnItem'])): ?>
            <li <?php echo $is_active;?>>
                <a href="#return" role="tab" data-toggle="tab">
                    <img src="<?php echo Theme::asset()->usePath()->url('images/icn/returns-policy.png'); ?>" />
                    <span class="policy_title"><?php echo $policies['returnItem']['title']; ?>
                    <h3 class="policy_sub_title"><?php echo $policies['returnItem']['type']?></h3></span>
                </a>
            </li>
        <?php
        $is_active = '';
        ?>
        <?php endif; ?>
	</ul>
	<div class="tab-content">
		<?php if (isset($policies['shipping'])): ?>
		<div class="tab-pane <?php echo $tab_pane_active;?>" id="freedelivery"><?php echo $policies['shipping']['description']; ?></div>
            <?php
            $tab_pane_active = '';
            ?>
        <?php endif; ?>
		<?php if (isset($policies['refund'])): ?>
		<div class="tab-pane <?php echo $tab_pane_active;?>" id="moneyback"><?php echo $policies['refund']['description']; ?></div>
            <?php
            $tab_pane_active = '';
            ?>
        <?php endif; ?>
		<?php if (isset($policies['returnItem'])): ?>
		<div class="tab-pane <?php echo $tab_pane_active;?>" id="return"><?php echo $policies['returnItem']['description']; ?></div>
            <?php
            $tab_pane_active = '';
            ?>
        <?php endif; ?>
	</div>
</div>
