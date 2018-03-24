<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=1190"/>
  <title><?php echo Theme::get("title"); ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo Theme::asset()->usePath()->url('bootstrap/css/bootstrap.css'); ?>"/>
  <link rel="stylesheet" type="text/css" href="<?php echo Theme::asset()->usePath()->url('css/style.css'); ?>"/>
  <link rel="stylesheet" type="text/css" href="<?php echo Theme::asset()->usePath()->url('css/add.css'); ?>"/>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/libs/jquery-2.1.0.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('bootstrap/js/bootstrap.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/modernizr.custom.79639.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/underscore-min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/jquery.validate.1.12.0.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/js/jquery.formatMoney.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/checkout.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/custom_checkout.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/helper.js'); ?>"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo Theme::asset()->usePath()->url('bootstrap/css/buttons.css'); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo Theme::asset()->usePath()->url('css/addon.css'); ?>" />
  <!--selectBox-->
  <link type="text/css" rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url('css/jquery.selectBox1.css'); ?>"/>
  <?php echo Theme::asset()->styles(); ?>
  <?php echo Theme::asset()->scripts(); ?>
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
</head>

<body>
    <div id="wrapper">
        <?php echo Theme::partial('header'); ?>
        <div id="contener">
            <div class="sub-content headline">
                <div class="box-left">
                    <?php echo Theme::content(); ?>
                </div>
                <div class="right">
                    <div class="box-right" id="minicart-container">
                      <?php echo Theme::partial('minicart'); ?>
                    </div>
                    <div class="clear"></div>
                    <?php echo Theme::partial("miniaddress"); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php echo Theme::partial('footer'); ?>
   </div>
   <!-- [S] area for block -->
   <?php echo Theme::partial('cartLightbox'); ?>
   <!-- [E] area for block -->

   <!-- [S] area for block -->
   <?php echo Theme::partial('applyTrueYou'); ?>
   <!-- [E] area for block -->

   <!-- [S] terms of services -->
   <?php echo Theme::partial('terms_services'); ?>
   <!-- [E] terms of services -->

    <!-- [S] ajax loading -->
    <?php echo Theme::widget("ajaxLoading", array())->render(); ?>
    <!-- [E] ajax loading -->

    <script type="text/javascript">
        var site_url = "<?php echo URL::to('/', array(), Config::get("https.useHttps")); ?>/";
		var normal_url = "<?php echo URL::to('/', array());?>/";
    </script>

    <!-- Criteo tag -->
    <?php if (Theme::get('criteo_tag')): ?>
        <?php echo Theme::get('criteo_tag');?>
    <?php endif; ?>

    <?php echo Theme::asset()->container("footer")->styles(); ?>
    <?php echo Theme::asset()->container('footer')->scripts(); ?>

</body>
</html>
