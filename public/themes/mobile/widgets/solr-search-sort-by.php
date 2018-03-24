
<div class="row filter-row">
    <div class="col-xs-12">
        <div class="btn-group order-by">
            <button type="button" class="btn btn-default btn-order-by <?php echo ( ! empty($orderBy) && $orderBy == 'published_at') ? "active" : ""; ?> "
                    data-href="<?php echo URL::toLang('cate/search-view'); ?>"
                    data-shref="<?php echo URL::toLang('search2/view'); ?>"
                    data-order-by="published_at"
                    data-order-current="asc"
                    data-order-type="<?php echo ( ! empty($order)) ? $order : "desc"; ?>"
                >
                <a href="#"><?php echo __("filter_latest_txt"); ?>
                    <img id="img-order-by-published-at" src="<?php echo Theme::asset()->usePath()->url('img/order_by_both.png'); ?>"></a>
            </button>
            <button type="button" class="btn btn-default btn-order-by <?php echo ( ! empty($orderBy) && $orderBy == "sell_price") ? "active" : ""; ?>"
                    data-href="<?php echo URL::toLang('cate/search-view'); ?>"
                    data-shref="<?php echo URL::toLang('search2/view'); ?>"
                    data-order-by="sell_price"
                    data-order-current="asc"
                    data-order-type="<?php echo ( ! empty($order)) ? $order : "desc"; ?>"
                >
                <a href="#"><?php echo __("Price"); ?>
                    <img id="img-order-by-sell-price" src="<?php echo Theme::asset()->usePath()->url('img/order_by_both.png'); ?>">
                </a>
            </button>
            <button type="button" class="btn btn-default btn-order-by <?php echo ( ! empty($orderBy) && $orderBy == "percent_discount") ? "active" : ""; ?>"
                    data-href="<?php echo URL::toLang('cate/search-view'); ?>"
                    data-shref="<?php echo URL::toLang('search2/view'); ?>"
                    data-order-by="percent_discount"
                    data-order-current="asc"
                    data-order-type="<?php echo ( ! empty($order)) ? $order : "desc"; ?>"
                >
                <a href="#"><?php echo __("filter_discount_txt"); ?>
                    <img id="img-order-by-percent-discount" src="<?php echo Theme::asset()->usePath()->url('img/order_by_both.png'); ?>">
                </a>
            </button>

            <button style="display: none;" type="button" class="btn btn-default btn-order-by <?php echo ( ! empty($orderBy) && $orderBy == 'best_match') ? "active" : ""; ?> "
                    data-href="<?php echo URL::toLang('cate/search-view'); ?>"
                    data-shref="<?php echo URL::toLang('search2/view'); ?>"
                    data-order-by="best_match"
                    data-order-current="asc"
                    data-order-type="<?php echo ( ! empty($order)) ? $order : "desc"; ?>"
                >
                <a href="#"><?php echo __("filter_latest_txt"); ?>
                    <img id="img-order-by-best-match" src="<?php echo Theme::asset()->usePath()->url('img/order_by_both_down_active.png'); ?>"></a>
            </button>

        </div>
    </div>
</div>