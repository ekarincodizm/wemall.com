<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?php echo Theme::get("title"); ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo Theme::asset()->usePath()->url('bootstrap/css/bootstrap.css'); ?>"/>
  <link rel="stylesheet" type="text/css" href="<?php echo Theme::asset()->usePath()->url('css/style.css'); ?>"/>
  <link rel="stylesheet" type="text/css" href="<?php echo Theme::asset()->usePath()->url('css/add.css'); ?>"/>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/libs/jquery-2.1.0.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('bootstrap/js/bootstrap.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/modernizr.custom.79639.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/underscore-min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/jquery.validate.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/checkout.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/custom_checkout.js'); ?>"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo Theme::asset()->usePath()->url('bootstrap/css/buttons.css'); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo Theme::asset()->usePath()->url('css/addon.css'); ?>" />
  <!--selectBox-->
  <link type="text/css" rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url('css/jquery.selectBox1.css'); ?>"/>
  <link type="text/css" rel="stylesheet" media="print" href="<?php echo Theme::asset()->usePath()->url('css/thankyou-print.css'); ?>"/>
   <?php echo Theme::asset()->styles(); ?>
  <?php echo Theme::asset()->scripts(); ?>
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
</head>

<body>
    <div id="wrapper">
        <?php echo Theme::partial('header'); ?>
        <div id="contener">
             <?php echo Theme::content(); ?>
        </div>
        <?php echo Theme::partial('footer'); ?>
   </div>

    <!-- [S] auto register -->
    <?php echo Theme::partial('registerLightbox'); ?>
    <!-- [E] auto register -->
    
    <script type="text/javascript">
        var site_url = "<?php echo URL::to('/'); ?>/";
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
