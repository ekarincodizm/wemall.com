<!DOCTYPE html>
<html lang='<?php echo __("lang_code"); ?>' xml:lang='<?php echo __("lang_code"); ?>' xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <base href="/">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <?php echo Theme::partial('meta',array('title'=>Theme::get("title"),'metadescription')); ?>
        <?php echo Theme::partial('meta_og'); ?>
        <link type="text/css" rel="stylesheet" media="all" href="<?php echo Theme::asset()->usePath()->url('css/bootstrap.min.css'); ?>">
        <link type="text/css" rel="stylesheet" media="all" href="<?php echo Theme::asset()->usePath()->url('css/style.css?q=201410131810'); ?>">
        <link type="text/css" rel="stylesheet" media="all" href="<?php echo Theme::asset()->usePath()->url('css/mobile-showroom.css?q=201501121030'); ?>">
        <?php if (Request::segment(1) != "category") : ?>
            <link type="text/css" rel="stylesheet" media="all" href="<?php echo Theme::asset()->usePath()->url('css/custom.css?q=201410131810'); ?>">
        <?php endif; ?>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl("assets/vendor/underscore-min.js"); ?>"></script>
        <script type="text/javascript">
            var site_url = "<?php echo URL::to('/'); ?>/";
            var site_url_https = "<?php echo URL::to('/',array(),true); ?>/";
            var open_https = "<?php echo Config::get("https.useHttps")? 'true' : 'false'; ?>";
            /* typeidea script */
            var dataLayer = [];
            /* //typeidea script */
            var site_url_nolang = "<?php echo URL::to('/'); ?>/";
        </script>
        
        <?php echo Theme::partial('includeNgHeader'); ?>

        <?php echo Theme::asset()->styles(); ?>
        <?php echo Theme::asset()->scripts(); ?>

        <link type="text/css" rel="stylesheet" media="all" href="<?php echo Theme::asset()->usePath()->url('css/seo_mobile.css?q=201410131abc'); ?>">
    </head>
    <body class="show-filter itm-background-color" ng-app="itmApp" show-filter>
        <div id="backtotop-arrow"><a href="#_top"><img src="<?php echo Theme::asset()->usePath()->url('img/backtotop.png')?>" alt="Back to Top"></a></div>
        <div class="container-fluid itm-container-fluid" id="_top">
            <?php echo Theme::partial('header'); ?>

            <div id="content">
                <?php echo Theme::content(); ?>
            </div>

            <?php echo Theme::partial('footer'); ?>
        </div>

        <script src="<?php echo Theme::asset()->usePath()->url('js/jquery-1.11.1.min.js'); ?>"></script>
        <script src="<?php echo Theme::asset()->usePath()->url('js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo Theme::asset()->usePath()->url('js/custom.js'); ?>"></script>
        <script src="/assets/js/jquery.formatMoney.js"></script>

        <!-- [S] ajax loading -->
        <?php echo Theme::widget("ajaxLoading", array())->render(); ?>
        <!-- [E] ajax loading -->

        <!-- marketing tag -->
        <?php if (Theme::get('marketing_tag')): ?>
            <script type="text/javascript">
                <?php echo Theme::get('marketing_tag');?>
            </script>
        <?php endif; ?>

        <!-- Criteo tag -->
        <?php if (Theme::get('criteo_tag')): ?>
            <?php echo Theme::get('criteo_tag');?>
        <?php endif; ?>

        <?php echo Theme::asset()->container("footer")->styles(); ?>
        <?php echo Theme::asset()->container('footer')->scripts(); ?>
        <?php echo Theme::asset()->container('embed')->scripts(); ?>
        <?php echo Theme::partial("includeNgFooter"); ?>

        <div id="criteo-script-mobile"></div>
    </body>
</html>