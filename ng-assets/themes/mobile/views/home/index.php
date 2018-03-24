<!-- Search -->
<?php echo Theme::widget('WidgetMobileSearchBox')->render(); ?>

<?php echo Theme::widget('WidgetHomeHighlightBanner', array('banners' => $banners))->render(); ?>

<!-- Category -->
<?php echo Theme::widget('WidgetMobileCategoryLink')->render(); ?>
<!-- Slider : Use bootstrap framework-->

<!-- SuperDeals -->
<div class="row margin-top-20">
  <div class="col-xs-8">
    <h3 class="h3_seo">everyday wow itruemart deal</h3>
    <img id="everyday-wow-logo" alt="everyday wow itruemart deal" src="<?php echo URL::asset('themes/mobile/assets/img/everyday_wow_logo.png'); ?>">
  </div>
  <div class="button_more"><a href="<?php echo URL::toLang('everyday-wow'); ?>"><button type="button" class="btn btn-more"><?php echo __("more");?></button></a></div>
  <div class="col-xs-12"></div>
  <?php echo Theme::widget('WidgetSuperDealProductList', array('limit' => 4,'response' =>'product'))->render(); ?>
</div>

<div id="infinite-showroom" data-done_trigger="showroomReady" data-cache="<?php echo Input::get('no-cache', '');?>">
    <?php for($i=1; $i<=$totalShowroom; $i++): ?>
        <div class="margin-top-20 showroom-container loading" data-url="<?php echo URL::toLang("home-ajax?action=showroom&limit=1&page=" . $i); ?>"></div>
    <?php endfor; ?>
</div>

