<?php

$language = Lang::locale();

if(App::getLocale()=='th')
{
    $description = array_get($product, 'description');
}
else
{
    if(array_get($product,'translate') != null)
    {
        $description = array_get($product, 'translate.description');
    }
    else
    {
        $description = array_get($product, 'description');
    }
}

if(App::getLocale()=='th')
{
    $title = array_get($product, 'title');
}
else
{
    if(array_get($product,'translate') != null)
    {
        $title = array_get($product, 'translate.title');
    }
    else
    {
        $title = array_get($product, 'title');
    }
}

?><div class="row">
    <div class="col-xs-12"><h1 style="color:#95c126;"><?php echo $title; ?></h1></div>
</div>
<!-- Content -->
<!-- ใช้ grid ของ bootstrap ในการวาง -->

<div class="row detail_content">
    <div class="col-xs-12">
        <?php echo $description; ?>
    </div>
</div>

<div class="row back-to-detail">
    <div class="col-xs-12">
        <?php
        $slug = (isset($product['slug']) && !empty($product['slug'])) ? $product['slug']  : url_title($product['title']);
        ?>
        <a href="<?php echo levelDUrl($slug, $product['pkey']); ?>" class="blue-link"><?php echo __("Go back for shopping");?></a>
    </div>
</div>