<!DOCTYPE html>
<html>
    <head>
        <title><?php echo Theme::get('title'); ?></title>
        <meta charset="utf-8">
        <meta name="keywords" content="<?php echo Theme::get('keywords'); ?>">
        <meta name="description" content="<?php echo Theme::get('description'); ?>">
        <?php echo Theme::asset()->styles(); ?>
        <?php echo Theme::asset()->scripts(); ?>
		
		<?php 
		$canonical_tag = "http";
		$alternate_tag = "http";
		if(isset($_SERVER['HTTPS'])){
			$canonical_tag .= "s";
			$alternate_tag .= "s";
		}
		$canonical_tag .= "://".str_replace("m.", "www.", $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
		$alternate_tag .= "://".str_replace("www.", "m.", $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
		$host_url = $_SERVER["HTTP_HOST"];
		if(preg_match('/m.itruemart/i',$host_url)){ ?>
			<link rel="canonical" href="<?php echo $canonical_tag; ?>">
		<?php }
		else{ ?>
			<link rel="alternate" media="only screen and (max-width: 640px)" href="<?php echo $alternate_tag; ?>">
		<?php } ?>
    </head>
    <body>
        <?php //echo Theme::partial('header'); ?>

        <div class="container">
            <?php echo Theme::content(); ?>
        </div>

        <?php //echo Theme::partial('footer'); ?>

        <script type="text/javascript">
            var site_url = "<?php echo URL::to('/'); ?>/";
            var currentLocale = "<?php echo Lang::getLocale(); ?>";
        </script>

        <script src="<?php echo Theme::asset()->originUrl('assets/vendor/jquery/jquery-1.8.2.min.js'); ?>" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/vendor/jquery-cookie/jquery.cookie.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/js/sso.js'); ?>"></script>

        <?php echo Theme::asset()->container('footer')->scripts(); ?>
        <?php echo Theme::asset()->container('embed')->scripts(); ?>
    </body>
</html>