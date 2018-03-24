<div class="content-home sub">
    <div class="breadcrumbs">
        <div id="link_map">
            <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                <a class="map" itemprop="url" href="<?php echo URL::toLang('/');?>" title="<?php echo __('Shopping On-line'); ?>">
                    <span itemprop="title"><?php echo __('Shopping On-line'); ?></span>
                </a>
            </span>
            <?php echo Theme::breadcrumb()->render(); ?>
        </div>
    </div>
	<div id="wrapper_content">
		<div id="contactus">
			<div class="header">
				<?php echo __('contact_us');?>	</div>
			<div id="contactus-addr">
				<div id="c-addr-desc">
					<?php echo __('contact-any-suggestions');?>		</div>
				<div id="c-addr-info">
					<p id="business-mail"><strong><?php echo __('thankyou-customer-email-lbl');?>:</strong> support@itruemart.com</p>
					<p id="business-tel"><strong><?php echo __('step2-phone');?>: </strong> +66(0)2-900-9999</p>
					<strong><?php echo __('Address');?>:</strong>
					<p class="box-info">
						<span id="business-name"><?php echo __('thankyou-company-name');?></span><br><span id="business-location"><?php echo __("thankyou-company-address"); ?></span></p>
					<strong>Call Center</strong>
					<p class="box-info">
						<?php echo __('thankyou-footer-success-contact-time');?>			</p>
				</div>
			</div>
			<div id="contactus-map">
				<div id="map_canvas" style="width: 900px; height: 650px"></div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
