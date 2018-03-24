<!DOCTYPE html>
<html>
    <head>
        <title><?php echo Theme::get('title'); ?></title>
        <meta charset="utf-8">
        <meta name="keywords" content="<?php echo Theme::get('keywords'); ?>">
        <meta name="description" content="<?php echo Theme::get('description'); ?>">

        <link rel="stylesheet" href="<?php echo Theme::asset()->originUrl('assets/vendor/bootstrap/bootstrap.min.css'); ?>"/>
        <link rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url("js/owl-carousel/owl.carousel.css"); ?>" />
        <link rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url("js/owl-carousel/owl.theme.css"); ?>" />
        <link rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url("css/stepper/jquery.fs.stepper.css"); ?>" />
        <link rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url('css/main.css'); ?>" />
        <link rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url("css/reveal.css"); ?>" />
        <link rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url("css/custom.css"); ?>" />


		<script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/lib/jquery-1.11.0.min.js"); ?>" ></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/lib/jquery-migrate-1.2.1.min.js"); ?>" ></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/lib/jquery-ui.min.js"); ?>" ></script>

        <script type="text/javascript">
            var site_url_nolang = "<?php echo URL::to('/'); ?>/";
            var site_url = "<?php echo URL::toLang('/'); ?>/";
            var site_url_https = "<?php echo URL::toLang('/',array(),true); ?>/";
            var open_https = "<?php echo Config::get("https.useHttps")? 'true' : 'false'; ?>";
        </script>

        <?php echo Theme::asset()->styles(); ?>
        <?php echo Theme::asset()->scripts(); ?>


        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <?php echo Theme::partial('header'); ?>
        <?php echo Theme::partial('navbar'); ?>
        <?php echo Theme::partial("homeBanner"); ?>

        <div class="home__container">
            <?php echo Theme::content(); ?>
        </div>

        <!-- [S] Get partial cartLightbox from checkout theme -->
        <?php echo Theme::partial('cartLightbox') ?>
        <!-- [E] Get partial cartLightbox from checkout theme -->

        <?php echo Theme::partial('footer'); ?>


        <?php echo Theme::asset()->container('footer')->styles(); ?>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl("assets/vendor/underscore-min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/jquery.infinitescroll.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/lib/jquery.countdown.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/lib/jquery.lazyload.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/vendor/bootstrap/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/js/jquery.formatMoney.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/js/price_helper.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl("assets/vendor/jquery.reveal.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/subscribe.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/owl-carousel/owl.carousel.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/lib/jquery.fs.stepper.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/lib/jquery.sharrre.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/main.js"); ?>" ></script>
		<?php echo Theme::asset()->container('footer')->scripts(); ?>

    </body>
</html>