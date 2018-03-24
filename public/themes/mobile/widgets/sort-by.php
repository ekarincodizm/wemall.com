
<div class="row filter-row">
    <div class="col-xs-12">
        <div class="btn-group order-by">
            <button type="button" class="btn btn-default btn-order-by <?php echo ( ! empty($orderBy) && $orderBy == 'published_at') ? "active" : ""; ?> "
                    data-href="<?php echo URL::toLang('cate/search-view'); ?>"
                    data-shref="<?php echo URL::toLang('search/view'); ?>"
                    data-order-by="published_at"
                    data-order-current="asc"
                    data-order-type="<?php echo ( ! empty($order)) ? $order : "desc"; ?>"
                >
                <a href="#"><?php echo __("filter_latest_txt"); ?>
                    <img id="img-order-by-published-at" src="<?php echo Theme::asset()->usePath()->url('img/order_by_both_down_active.png'); ?>"></a>
            </button>
            <button type="button" class="btn btn-default btn-order-by <?php echo ( ! empty($orderBy) && $orderBy == "price") ? "active" : ""; ?>"
                    data-href="<?php echo URL::toLang('cate/search-view'); ?>"
                    data-shref="<?php echo URL::toLang('search/view'); ?>"
                    data-order-by="price"
                    data-order-current="asc"
                    data-order-type="<?php echo ( ! empty($order)) ? $order : "desc"; ?>"
                >
                <a href="#"><?php echo __("Price"); ?>
                    <img id="img-order-by-price" src="<?php echo Theme::asset()->usePath()->url('img/order_by_both.png'); ?>">
                </a>
            </button>
            <button type="button" class="btn btn-default btn-order-by <?php echo ( ! empty($orderBy) && $orderBy == "discount") ? "active" : ""; ?>"
                    data-href="<?php echo URL::toLang('cate/search-view'); ?>"
                    data-shref="<?php echo URL::toLang('search/view'); ?>"
                    data-order-by="discount"
                    data-order-current="asc"
                    data-order-type="<?php echo ( ! empty($order)) ? $order : "desc"; ?>"
                >
                <a href="#"><?php echo __("filter_discount_txt"); ?>
                    <img id="img-order-by-discount" src="<?php echo Theme::asset()->usePath()->url('img/order_by_both.png'); ?>">
                </a>
            </button>
        </div>
    </div>
</div>