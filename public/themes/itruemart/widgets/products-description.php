<?php
$product_name = null;
if(App::getLocale()=='th')
{
    $product_name = array_get($product,'title');
}
else
{
    if(array_get($product,'translate') != null)
    {
        $product_name =  array_get($product,'translate.title');
    }
    else
    {
        $product_name =  array_get($product,'title');
    }
}
?>
<?php
$keyfeature =  array_get($product,'key_feature');
$advantage =  array_get($product,'advantage');
if (($keyfeature != NULL) || ($advantage != NULL)){ ?>
	<div class="product__description">

	<?php if ($keyfeature != NULL){ ?>
		<div class="product__description_prop <?php echo is_null($advantage) ? "leveld_full_width" : ''; ?>">
			<h2 class="product__description_name"><?php echo __('Product Specifications'); ?></h2>
			<div class="product__description_content">
				<?php echo $keyfeature ?>
			</div>
		</div>
	<?php } ?>

	<?php if ($advantage != NULL){ ?>
		<div class="product__description_con">
			<div class="product__description_name">
				<!-- \ <b>สรุปข้อดี</b> -->
				<!-- The advantage field is not defined yet -->
				<b><?php echo __('Benefits'); ?></b>
			</div>
			<div class="product__description_content">
				<?php echo $advantage ?>
			</div>
		</div>
	<?php } ?>

	</div>
<?php } ?>

<div class="product__description_bottom">
	<h2 class="product__description_name"><?php echo __('Description'); ?></h2>
	<div class="product__description_content">
		<?php
        $description =  array_get($product,'description');
        echo $description; ?>
	</div>
</div>
