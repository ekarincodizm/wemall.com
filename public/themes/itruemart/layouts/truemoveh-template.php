<!DOCTYPE html>
<html lang='<?php echo __("lang_code"); ?>' xml:lang='<?php echo __("lang_code"); ?>' xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <base href="/">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
      <?php echo Theme::partial('meta',array('title'=>Theme::get("title"),'metadescription')); ?>
      <?php echo Theme::partial('meta_og'); ?>
      <link type="text/css" rel="stylesheet" media="all" href="<?php echo Theme::asset()->usePath()->url('../../mobile/assets/css/bootstrap.min.css'); ?>">
      <link type="text/css" rel="stylesheet" media="all" href="<?php echo Theme::asset()->usePath()->url('../../mobile/assets/css/style.css?q=201410131810'); ?>">
      <link type="text/css" rel="stylesheet" media="all" href="<?php echo Theme::asset()->usePath()->url('../../mobile/assets/css/mobile-showroom.css?q=201501121030'); ?>">
      <?php if (Request::segment(1) != "category") : ?>
      <link type="text/css" rel="stylesheet" media="all" href="<?php echo Theme::asset()->usePath()->url('../../mobile/assets/css/custom.css?q=201410131810'); ?>">
      <link type="text/css" rel="stylesheet" media="all" href="<?php echo Theme::asset()->usePath()->url('../../mobile/assets/css/mobile-truemoveh.css'); ?>">
      <?php endif; ?>
      <script type="text/javascript" src="<?php echo Theme::asset()->originUrl("/assets/vendor/underscore-min.js"); ?>"></script>
      <script type="text/javascript">
         var site_url = "<?php echo URL::to('/'); ?>/";
         var site_url_https = "<?php echo URL::to('/',array(),true); ?>/";
         var open_https = "<?php echo Config::get("https.useHttps")? 'true' : 'false'; ?>";
         /* typeidea script */
         var dataLayer = [];
         /* //typeidea script */
         var site_url_nolang = "<?php echo URL::to('/'); ?>/";
      </script>
      <script src="https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&render=explicit&hl=th" async defer></script>
      <?php echo Theme::partial('includeNgHeader'); ?>
      <?php echo Theme::partial('includeHeaderJs'); ?>
      <?php echo Theme::asset()->styles(); ?>
      <?php echo Theme::asset()->scripts(); ?>
      <link type="text/css" rel="stylesheet" media="all" href="<?php echo Theme::asset()->usePath()->url('../../mobile/assets/css/seo_mobile.css?q=201410131abc'); ?>">
   
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
   <body class="pull_top" ng-app="itmApp">

      <!--[if lt IE 10]>
         <p class="browsehappy">เลือกดาวน์โหลดเบราว์เซอร์เวอร์ชั่นล่าสุด. กรุณา คลิ๊ก <a href="http://browsehappy.com/"><strong>อัพเกรดเบราว์เซอร์</strong></a> เพื่อการทำงานที่เต็มประสิทธิภาพจากทาง iTruemart.com</p>
         <script type="text/javascript">
            alert('ขออภัยค่ะ หน้านี้ไม่รองรับเบราว์เซอร์ที่ใช้อยู่ในขณะนี้ กรุณาใช้เบราว์เซอร์เวอร์ชั่นล่าสุดของ Chrome Safari Firefox หรือ Internet Explorer เวอร์ชั่น 10 ขึ้นไป ขอบคุณค่ะ');
         </script>
      <![endif]-->

      <div id="backtotop-arrow" class="tmvh-mobile-backtotop"><a href="#_top"><img src="<?php echo Theme::asset()->usePath()->url('../../mobile/assets/img/backtotop.png')?>" alt="Back to Top"></a></div>
      <div class="container-fluid" id="_top">
         <div class="page_main_subject">
            <h1 class="h1_home"><?php echo __('seo_h1_home'); ?></h1>
         </div>
         <div class="row header-section">
            <div class="col-xs-6 ui-logo" id="logo">
               <a href="<?php echo URL::toLang('/'); ?>"><img src="<?php echo URL::to(Theme::asset()->url('../../mobile/assets/img/itruemart_logo.png?q=102014')); ?>" alt="<?php echo __('seo_title_home');?>"></a>
            </div>
         </div>
         <!-- <div class="home__container"> -->
         <?php echo Theme::content(); ?>
         <!-- </div> -->
         <?php echo Theme::partial("includeNgFooter"); ?>
         <div class="row margin-top-20 footer tmvh-footer">
            <div class="col-xs-12 bottom">
               <div class="row">
                  <div class="col-xs-12">
                     <h3><?php echo __("Our Services"); ?></h3>
                  </div>
                  <div class="col-xs-6">
                     <ul>
                        <li><a href="<?php echo URL::toLang("member/profile"); ?>"
                           target="_blank"><?php echo __("Profile"); ?></a></li>
                        <!-- <li><a href="#"><?php echo __("Live Agent"); ?></a></li> -->
                        <li><a href="<?php echo URL::toLang("contact_us"); ?>"
                           target="_blank"><?php echo __("footer_contact_us_title"); ?></a></li>
                     </ul>
                  </div>
                  <div class="col-xs-6">
                     <ul>
                        <li><a href="<?php echo URL::toLang("order_tracking"); ?>"
                           target="_blank"><?php echo __("Check my order"); ?></a></li>
                        <li><a href="<?php echo URL::toLang("policy/returnpolicy"); ?>"
                           target="_blank"><?php echo __("Return Policy"); ?></a></li>
                        <li><a href="<?php echo URL::toLang("policy/freedelivery"); ?>"
                           target="_blank"><?php echo __("Delivery Policy"); ?></a></li>
                        <li><a href="<?php echo URL::toLang("policy/moneyback"); ?>"
                           target="_blank"><?php echo __("Refund Policy"); ?></a></li>
                        <li>
<!--                           <a href="--><?php //echo (Config::get("endpoints.support_itruemart.url", false)) ? Config::get("endpoints.support_itruemart.url", "") . "/726087-%E0%B8%82%E0%B8%99%E0%B8%95%E0%B8%AD%E0%B8%99%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%81%E0%B8%A3%E0%B8%AD%E0%B8%81%E0%B8%84%E0%B8%9B%E0%B8%AD%E0%B8%87%E0%B9%83%E0%B8%AA%E0%B8%A5%E0%B8%94%E0%B9%83%E0%B8%99%E0%B8%A1%E0%B8%AD%E0%B8%96%E0%B8%AD?r=1": "#" ; ?><!--"-->
<!--                              target="_blank">-->
<!--                           --><?php //echo __("HowToPromotionCode"); ?>
<!--                           </a>-->
                        </li>
                     </ul>
                  </div>
                  <div class="col-xs-12 text-center margin-top-20">
                     <a href="<?php echo URL::switchLang('en'); ?>">
                     <img src="<?php echo Theme::asset()->usePath()->url('../../mobile/assets/img/flag_us.png'); ?>" alt="English">
                     </a>
                     &nbsp;&nbsp;
                     <a href="<?php echo URL::switchLang('th'); ?>">
                     <img src="<?php echo Theme::asset()->usePath()->url('../../mobile/assets/img/flag_th.png'); ?>" alt="Thai">
                     </a>
                  </div>
                  <?php
                     //prepair url to desktop.
                     $replacementPattern = Config::get("endpoints.mobilePrefixRegex");
                     $webReplacement = Config::get("endpoints.webPrefix");
                     $desktopUrl = preg_replace($replacementPattern, $webReplacement, URL::current());
                     ?>
                  <div class="col-xs-12 text-center margin-top-20"><a href="<?php echo $desktopUrl . '?desktop=1'; ?>">Desktop
                     Site</a>
                  </div>
                  <div class="col-xs-12 text-center link-grey">Copyright Notice 2014 - itruemart.com</div>
               </div>
            </div>
         </div>
      </div>
      <script src="<?php echo Theme::asset()->usePath()->url('../../mobile/assets/js/jquery-1.11.1.min.js'); ?>"></script>
      <script src="<?php echo Theme::asset()->usePath()->url('../../mobile/assets/js/bootstrap.min.js'); ?>"></script>
      <script src="<?php echo Theme::asset()->usePath()->url('../../mobile/assets/js/custom.js'); ?>"></script>
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

      <div id="criteo-script-mobile"></div>
   </body>
</html>
