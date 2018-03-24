<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title><?php echo Theme::get('title'); ?></title>
    <meta name="keywords" content="<?php echo Theme::get('keywords'); ?>">
    <meta name="description" content="<?php echo Theme::get('description'); ?>">

    <link href="<?php echo Theme::asset()->url("css/bootstrap.min.css"); ?>" rel="stylesheet" />
    <link href="<?php echo Theme::asset()->url("css/mobile.css"); ?>" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo  Theme::asset()->url("css/custom.css"); ?>" />

	<?php 
		$canonical_tag = "http";
		if(isset($_SERVER['HTTPS'])){
			$canonical_tag .= "s";
		}
		$canonical_tag .= "://".str_replace("m.", "www.", $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
	?>
	<link rel="canonical" href="<?php echo $canonical_tag;?>" />
	
    <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/vendor/jquery/jquery-1.11.0.min.js'); ?>"></script>
    <!--selectBox-->
    <?php echo Theme::asset()->styles(); ?>
    <?php echo Theme::asset()->scripts(); ?>
</head>

<body>
    <div class="row-custom">
        <div class="col-custom">
            <?php echo Theme::partial('thankyouHeader'); ?>
            <?php echo Theme::content(); ?>
        </div>
    </div>

    <script type="text/javascript">
        var site_url = "<?php echo URL::to('/'); ?>/";
        var secure_site_url = "<?php echo URL::to('/', array(), Config::get("https.useHttps")); ?>/";
        var use_secure = '<?php echo Config::get("https.useHttps");?>';
        var currentLocale = "<?php echo Lang::getLocale(); ?>";
    </script>

    <!-- marketing tag -->
    <?php if (Theme::get('marketing_tag')): ?>
        <script type="text/javascript" class="marketing_tag">
            <?php echo Theme::get('marketing_tag');?>
        </script>
    <?php endif; ?>

    <!-- Criteo tag -->
    <?php if (Theme::get('criteo_tag')): ?>
        <?php echo Theme::get('criteo_tag');?>
    <?php endif; ?>

    <?php echo Theme::asset()->container('footer')->scripts(); ?>
</body>
</html>
