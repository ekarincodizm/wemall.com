<!-- Start New SEO -->
<a href="<?php echo URL::route('products.detail', $product['pkey']) ?>" class="bx-link-img">
    <img src="<?php echo $product['image_cover']['thumbnails']['square'] ?>" alt="<?php echo $product['title'] ?>" width="150" height="150">
    <img src="http://www.itruemart.com/assets/itruemart_new/th/images/detail.jpg" alt="<?php echo $product['title'] ?>" class="bx-view-detail">
    <?php if ($product['percent_discount']['max'] > 0) : ?>
    <span class="bx-discount bx-bg-1">
        <span class="bx-text-discount"><?php echo floor($product['percent_discount']['max']); ?></span>
        <span class="bx-percent-discount">%</span>
    </span>
    <?php endif; ?>
</a>
<a href="<?php echo URL::route('products.detail', $product['pkey']) ?>" class="bx-link-name font2 strong struc-2"><?php echo $product['title'] ?></a>
<a href="<?php echo URL::route('products.detail', $product['pkey']) ?>" class="bx-link-price struc-2">
        <?php
        if ($product['special_price_range']['max'] || $product['special_price_range']['min'])
        {
            ?>
        <span class="font7">
            <?php
            if ($product['price_range']['max'] == $product['price_range']['min'])
            {
                echo number_format($product['price_range']['max'], 0), ' บาท';
            }
            else
            {
                echo number_format($product['price_range']['min'], 0), ' - ', number_format($product['price_range']['max'], 0), ' บาท';
            }
            ?>
        </span>
        <span class="font6">
            <?php
            if ($product['net_price_range']['max'] == $product['net_price_range']['min'])
            {
                echo number_format($product['net_price_range']['max'], 0), ' บาท';
            }
            else
            {
                echo number_format($product['net_price_range']['min'], 0), ' - ', number_format($product['net_price_range']['max'], 0), ' บาท';
            }
            ?>
        </span>
            <?php
        }
        else
        {
            ?>
        <span class="font7">
            <?php
            if ($product['price_range']['max'] == $product['price_range']['min'])
            {
                echo number_format($product['price_range']['max'], 0), ' บาท';
            }
            else
            {
                echo number_format($product['price_range']['min'], 0), ' - ', number_format($product['price_range']['max'], 0), ' บาท';
            }
            ?>
        </span>
<?php } ?>
</a>
<!-- End New SEO -->