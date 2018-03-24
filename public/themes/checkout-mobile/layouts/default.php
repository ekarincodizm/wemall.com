<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=640"/>
  <title><?php echo Theme::get("title"); ?></title>
  <!-- [N] -->
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/libs/jquery-2.1.0.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('bootstrap/js/bootstrap.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/modernizr.custom.79639.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/underscore-min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/jquery.validate.1.12.0.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/script.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/plugins/jquery.reveal.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/jquery.slimscroll.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/libs/jquery-ui-1.10.1.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/ddaccordion.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/im.template.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/custom_checkout.js'); ?>"></script>
  <!-- [N] -->
   <?php echo Theme::asset()->styles(); ?>
  <?php echo Theme::asset()->scripts(); ?>
  
    <?php 
		$canonical_tag = "http";
		if(isset($_SERVER['HTTPS'])){
			$canonical_tag .= "s";
		}
		$canonical_tag .= "://".str_replace("m.", "www.", $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
	?>
	<link rel="canonical" href="<?php echo $canonical_tag;?>" />
</head>

<body>
	<div class="main_container content-home checkout">
    <div id="wrapper_content">
        <?php echo Theme::partial('header'); ?>
        <?php echo Theme::content(); ?>
   </div>
   </div>

    <script type="text/javascript">
        var site_url = "<?php echo URL::to('/', array(), Config::get("https.useHttps")); ?>/";
    </script>

    <!-- Criteo tag -->
    <?php if (Theme::get('criteo_tag')): ?>
        <?php echo Theme::get('criteo_tag');?>
    <?php endif; ?>

    <?php echo Theme::asset()->container('footer')->scripts(); ?>

</body>
</html>
