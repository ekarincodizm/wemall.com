<div class="base_seller_items">
    <div class="tap_product_main">
        <div class="promotion">
            <div class="div_promotion">
                <div id="bestseller_loader">
                    <div id="promotion_back">
                    </div>
                    <div class="promotion_space"></div>
                    <div id="div_promotion_content">
                        <ul class="bx-listproduct-slider over">
                        <?php foreach ($bestSeller as $product): ?>
                            <li class="bx-product">
                                <?php echo HTML::product($product) ?>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="promotion_space">
                    </div>
                    <div id="promotion_next">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>