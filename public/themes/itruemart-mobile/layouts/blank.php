<!DOCTYPE html>
<html>
    <head>
        <title><?php echo Theme::get('title'); ?></title>
        <meta charset="utf-8">
        <meta name="keywords" content="<?php echo Theme::get('keywords'); ?>">
        <meta name="description" content="<?php echo Theme::get('description'); ?>">
        <?php echo Theme::asset()->styles(); ?>
        <?php echo Theme::asset()->scripts(); ?>
    </head>
    <body>
        <?php //echo Theme::partial('header'); ?>

        <div class="container">
            <?php echo Theme::content(); ?>
        </div>

        <?php //echo Theme::partial('footer'); ?>

        <script type="text/javascript">
            var site_url = "<?php echo URL::to('/'); ?>/";
        </script>

        <script src="<?php echo Theme::asset()->originUrl('assets/vendor/jquery/jquery-1.8.2.min.js'); ?>" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/vendor/jquery-cookie/jquery.cookie.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->url('js/sso.js'); ?>"></script>

        <?php echo Theme::asset()->container('footer')->scripts(); ?>
        <?php echo Theme::asset()->container('embed')->scripts(); ?>
    </body>
</html>