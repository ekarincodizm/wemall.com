<div class="content-home sub">
	<div class="breadcrumbs">
        <div id="link_map">
            <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                <a class="map" itemprop="url" href="http://www.itruemart.com/" title="<?php echo __('Shopping On-line'); ?>">
                    <span itemprop="title"><?php echo __('Shopping On-line'); ?></span>
                </a>
            </span>
            <?php echo Theme::breadcrumb()->render(); ?>
        </div>
	</div>
	
	<div id="wrapper_content">
		<style>
			.forget_form iframe{border:none;}
		</style>
		<div class="forget_form">
			<iframe src="https://www3.truecorp.co.th/auth/forgot_password?cs=itruemart&ln=<?php echo App::getLocale(); ?>" 
			width="100%" height="370" frameborder="0"></iframe>
		</div>
	</div>
</div>