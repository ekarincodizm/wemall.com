<div class="row">
    <div class="col-xs-12"><h1 style="color:#95c126;"><?php echo __('รายละเอียดสินค้า'); ?></h1></div>
</div>
<!-- Content -->
<!-- ใช้ grid ของ bootstrap ในการวาง -->
<div class="row detail_content">
    <div class="col-xs-12">
        <?php echo $product['translate']['description']; ?>
    </div>
</div>

<div class="row back-to-detail">
    <div class="col-xs-12">
        <a href="<?php echo levelDUrl($product['slug'], $product['pkey']); ?>" class="blue-link">กลับไปหน้าสินค้า</a>
    </div>
</div>