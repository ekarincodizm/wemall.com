<?php  if (! empty($product['variants'][0]['active_special_discount'])) :  ?>
<?php foreach ($product['variants'] as $i => $variant): if (empty($variant['active_special_discount']['ended_at'])) continue; ?>
<div class="promotion_block" id="promotion-block-<?php echo $variant['inventory_id'];?>" <?php if ($product['has_variants']) echo 'style="display:none;"' ?>>

    <div class="time_remaining text-left">
        <span><?php echo __('Remaining Time');?><span>
    </div>

    <div class="event_ends text-right">
        <span><?php echo __('Sales end');?></span>
    </div>
    
    <div class="line_lvb"></div>
    <div class="time_group" class="hasCountdown" data-time="<?php echo strtotime($variant['active_special_discount']['ended_at']) - time(); ?>">

        <div class="day">
            <div class="time_number">0</div>
            <div class="time_number">0</div>
            <div class="time_text">d</div>
        </div>

        <div class="time_space"></div>

        <div class="day">
            <div class ="time_number">0</div>
            <div class ="time_number">0</div>
            <div class ="time_text">h</div>
        </div> 

        <div class="time_space"></div>
        <div class="day">
            <div class="time_number">0</div>
            <div class="time_number">0</div>
            <div class="time_text">m</div>
        </div>

        <div class="time_space"></div>
        <div class="day">
            <div class="time_number">0</div>
            <div class="time_number">0</div>
            <div class="time_text">s</div>
        </div> 

    </div>
    <div class="enddate">
    <?php echo date('D, M j @H:i',strtotime($variant['active_special_discount']['ended_at'])) ?>
    </div>
    <div class="clear"></div>
</div>
<?php endforeach ?>
<?php endif; ?>
