<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?php echo Theme::get("title"); ?></title>
   <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/libs/jquery-2.1.0.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('bootstrap/js/bootstrap.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/modernizr.custom.79639.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/underscore-min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/jquery.validate.min.js'); ?>"></script>
  <!--selectBox-->
   <?php echo Theme::asset()->styles(); ?>
  <?php echo Theme::asset()->scripts(); ?>
</head>

<body>
    <div class="main_container content-home checkout">
    <div id="wrapper_content">
        <?php echo Theme::partial('header'); ?>
        <?php echo Theme::content(); ?>
   </div>
   </div>
    <script type="text/javascript">
        var site_url = "<?php echo URL::to('/'); ?>/";
    </script>

    <!-- Criteo tag -->
    <?php if (Theme::get('criteo_tag')): ?>
        <?php echo Theme::get('criteo_tag');?>
    <?php endif; ?>

    <?php echo Theme::asset()->container('footer')->scripts(); ?>
</body>
</html>
