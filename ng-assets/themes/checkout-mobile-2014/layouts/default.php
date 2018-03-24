<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta name="HandheldFriendly" content="true" />
        <meta name="apple-touch-fullscreen" content="yes" />

        <title><?php echo Theme::get('title'); ?></title>
        <meta name="keywords" content="<?php echo Theme::get('keywords'); ?>">
        <meta name="description" content="<?php echo Theme::get('description'); ?>">

        <link rel="stylesheet" type="text/css" href="<?php echo Theme::asset()->url("css/bootstrap.min.css"); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo Theme::asset()->url("css/msdropdown.css"); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo Theme::asset()->url("css/style.css"); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo  Theme::asset()->url("css/checkout.css?q=201410161149"); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo  Theme::asset()->url("css/custom.css?q=201410161149"); ?>" />
        <link ref="stylesheet" type="text/css" href="<?php echo Theme::asset()->url("css/main.css"); ?>"/>
        <?php echo Theme::asset()->styles(); ?>

        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/vendor/jquery/jquery-1.11.0.min.js'); ?>"></script>
    </head>
    <body>
        <div class="container-fluid">
            <?php echo Theme::partial('header'); ?>
            <?php echo Theme::content(); ?>
            <?php echo Theme::partial('footer'); ?>
        </div>

        <?php echo Theme::partial('popup'); ?>
        <!-- [S] ajax loading -->
        <?php echo Theme::widget("ajaxLoading", array())->render(); ?>
        <!-- [E] ajax loading -->

        <script type="text/javascript" src="<?php echo Theme::asset()->url('js/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->url('js/jquery.msdropdown.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->url('js/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl("assets/vendor/jquery.validate.1.12.0.js"); ?>" ></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl("assets/js/jquery.selectBox.js"); ?>" ></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl("assets/js/itm_helper.js"); ?>" ></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl("assets/js/jquery.formatMoney.js"); ?>" ></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl("assets/vendor/underscore-min.js"); ?>" ></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->url("js/helper.js"); ?>" ></script>

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

        <?php echo Theme::asset()->container("footer")->styles(); ?>
        <?php echo Theme::asset()->scripts(); ?>
        <?php echo Theme::asset()->container('footer')->scripts(); ?>

        <script type="text/javascript">
            var site_url = "<?php echo URL::to('/'); ?>/";
            var secure_site_url = "<?php echo URL::to('/', array(), Config::get("https.useHttps")); ?>/";
            var use_secure = '<?php echo Config::get("https.useHttps");?>';
            var currentLocale = "<?php echo Lang::getLocale(); ?>";
        </script>
    </body>
</html>