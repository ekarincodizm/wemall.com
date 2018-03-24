<div class="checkout-info full">
    <sup class="cart-quantity" style="display: <?php echo ( ! empty($cart['totalQty'])) ?'block':'none'; ?>;"><?php echo ( ! empty($cart['totalQty'])) ? $cart['totalQty'] : ""; ?></sup>
    <span><?php echo __('cart'); ?></span><br/>
    <button class="btn-checkout-home" onclick="javascript: window.location.href='<?php echo URL::to('checkout'); ?>';"></button>
    <div class="cart-wrapper">
        <div class="cart-detail">
            <b><?php echo __('my_cart'); ?></b>
            <table>
                <thead>
                    <tr>
                        <th class="cd-name"></th>
                        <th class="cd-qty"><?php echo __('Quantity'); ?></th>
                        <th class="cd-price"><?php echo __('Price');?></th>
                        <th class="cd-del"><?php echo __('delete');?></th>
                    </tr>
                </thead>
                <tbody class="cart-list">
                    <tr class="cart-noitems">
                        <td colspan="4" class="text-center"><?php echo __('No items in Cart');?></td>
                    </tr>
                </tbody>
            </table>
            <?php if ($cart['totalItem'] > 0): ?>
            <div class="text-right">
                <button class="btn-checkout-home" onclick="javascript: window.location.href='<?php echo URL::to('checkout'); ?>';"></button>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    var Cart = Cart || {};
    Cart.data = eval(<?php echo json_encode($cart); ?>);
</script>

<table class="cart-template" style="display: none;">

    <tr data-inventory_id="{inventory_id}" data-quantity="{quantity}" class="cart-items inventory_id-{inventory_id}">
        <td valign="top">
            <img {thumbnail} alt="" width="50" />
            <p>{title}</p>
        </td>
        <td class="text-center" valign="middle">
            {quantity}
        </td>
        <td class="text-right" valign="middle">
            ₱ {totalPrice}
        </td>
        <td class="text-center" valign="middle">
            <a href="#" class="btn-cart-delete">
                <img src="/themes/itruemart/assets/images/btn-cart-del.jpg" alt="" class="remove-item" />
            </a>
        </td>
    </tr>

</table>