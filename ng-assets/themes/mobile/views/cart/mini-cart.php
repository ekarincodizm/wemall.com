<div class="ui-cart">
    <a href="<?php echo URL::toLang('cart'); ?>" class="shop-cart-link">
        <?php if ($cart['totalQty'] > 0): ?>
        <span>
            <?php echo $cart['totalQty']; ?>
        </span>
        <?php endif; ?>
    </a>
</div>
<script>
    var Cart = Cart || [];
    Cart.data = <?php echo json_encode($cart); ?>;
</script>