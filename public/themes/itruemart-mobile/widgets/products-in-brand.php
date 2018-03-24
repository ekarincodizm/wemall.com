<div class="container-brand-logo">
    <h2><?php echo __('brands');?></h2>
    <a href="<?php echo get_permalink('brand', $product['brand']); ?>" title="" onclick="_gaq.push(['_trackEvent', 'Product', 'Brand', 'GG000000000000525']);">
        <img src="<?php echo $product['brand']['thumbnail']; ?>" alt="" class="brand-logo">
    </a>
    <a href="<?php echo get_permalink('brand', $product['brand']); ?>" class="text-more" title="">ดูสินค้าทั้งหมด ...</a>
    <?php /*
    <a href="<?php echo URL::to('brand/'.$product['brand']['pkey']); ?>" title="" onclick="_gaq.push(['_trackEvent', 'Product', 'Brand', 'GG000000000000525']);">
        <img src="<?php echo $product['brand']['thumbnail']; ?>" alt="" class="brand-logo">
    </a>
    <a href="<?php echo URL::to('brand/'.$product['brand']['pkey']); ?>" class="text-more" title="">ดูสินค้าทั้งหมด ...</a>
    */ ?>
</div>

<div class="container-product-brand">
    <ul class="product-brand-bxslider">
        <?php if (count($inBrandProduct['products']) > 0) : ?>
        <?php foreach($inBrandProduct['products'] as $product) : ?>
        <li>
            <div class="product-brand box">
                <div class="product-brand-thumbnail">

                    <?php if(!empty($product['image_cover'])): ?>
                    <a href="<?php echo get_permalink('products', $product) ?>" title="<?php echo $product['title'];?>">
                        <img src="<?php echo $product['image_cover']['thumbnails']['square'] ?>" alt="<?php echo $product['title'];?>" style="class: bx-thumbnail;width:105px;height:105px;" class="bx-thumbnail">
                    </a>
                    <?php else: ?>
                    <a href="<?php echo get_permalink('products', $product) ?>" title="<?php echo $product['title'];?>">
                        <img src="<?php echo Theme::asset()->usePath()->url('images/product/image-not-found-105.jpg') ?>" alt="<?php echo $product['title'];?>" style="class: bx-thumbnail;width:105px;height:105px;" class="bx-thumbnail">
                    </a>
                    <?php endif; ?>

                    <?php /*
                    <a href="<?php echo URL::route('products.detail', $product['pkey']) ?>" title="<?php echo $product['title'];?>">
                        <img src="<?php echo $product['image_cover']['thumbnails']['square'] ?>" alt="<?php echo $product['title'];?>" style="class: bx-thumbnail;width:105px;height:105px;" class="bx-thumbnail">
                    </a>
                    */ ?>
                </div>
                <div class="product-brand-price">
                <?php
                    if ($product['price_range']['min'] == $product['price_range']['max'])
                    {
                        echo  price_format( $product['price_range']['max']);
                        echo ".-";
                    }
                    else{
                        echo price_format( $product['price_range']['min']) , ' - ', price_format( $product['price_range']['max']);
                    }
                    ?>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
        <?php endif; ?>
        </ul>
</div>
