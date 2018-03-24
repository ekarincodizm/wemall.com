<p class="thankyou-msg__main-text">
    <h1><?php echo __('out-of-stock-header'); ?></h1>
</p>
<span class="thankyou-msg__sub-text">
    <?php echo __('out-of-stock-content');?>
</span>
<br/>
<div style="text-align: center; margin-top: 30px;">
    <a class="btn-global" href="/" style="color:#fff;"><?php echo __('Go back for shopping');?></a>
</div>

<!-- error description -->
<div style="display:none;">
    <?php
    if(!empty($response))
    {
        s($response);
    }
    ?>
</div>