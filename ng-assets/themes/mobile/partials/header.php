<?php
if (Request::is('/') || Request::path()==='en')
{
    ?>
    <div class="page_main_subject">
        <h1 class="h1_home"><?php echo __('seo_h1_home'); ?></h1>
    </div>
<?php
}
?>
<div class="itm">
<div class="row header-section">
    <div class="col-xs-6 ui-logo" id="logo">
        <a href="<?php echo URL::toLang('/'); ?>"><img src="<?php echo URL::to(Theme::asset()->url('img/itruemart_logo.png?q=102014')); ?>" alt="<?php echo __('seo_title_home');?>"></a>
    </div>
    <div class="ajax-widget no-icon" data-method="get" data-url="<?php echo URL::toLang('cart/mini-cart'); ?>" data-done_trigger="doneGetMiniCart"></div>
</div>
</div>