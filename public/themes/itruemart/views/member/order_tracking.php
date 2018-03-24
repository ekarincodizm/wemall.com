<!-- order-tracking -->
<div class="container-order-tracking">
    <!-- breadcrumb -->
    <?php echo Theme::widget('breadcrumbs', array())->render(); ?>
    <!-- endbreadcrumb -->

    <!-- user profile -->
    <div class="user-profile">
        <div class="user-profile box-img">
            <img src="<?php echo $avatar; ?>" alt="avatar"/>
        </div>
        <div class="user-profile box-information">
            <div class="information-name normal-18">
                <?php echo __("member-profile-welcome"); ?> <?php echo $display_name; ?>
            </div>

            <!-- true privilege -->
            <?php if (!empty($user_trueyou_card)): ?>
                <div class="information-message">
                    <img src="<?php echo Theme::asset()->usePath()->url("images/true-" . $user_trueyou_card . "-card.png"); ?>"
                         alt="trueyou card"/> <?php echo array_get($user, "thai_id", ""); ?>
                </div>
            <?php else: ?>
                <div class="information-message">
                    <?php //echo __("tracking-truecorp-member1"); ?>&nbsp;
                    <!--                    <a href="-->
                    <? //= URL::toLang("member/profile") ?><!--" data-target="#modal-dialog-true-privilege" data-toggle="modal">-->
                    <? //= __("click-here") ?><!--</a>-->
<!--                    <a href="--><?php ////echo URL::toLang("member/profile"); ?><!--">--><?php ////echo __("click-here"); ?><!--</a>&nbsp;-->
                    <?php //echo __("tracking-truecorp-member2"); ?>
                </div>
            <?php endif; ?>
            <!-- endtrue privilege -->
        </div>
        <div class="user-profile box-update">
            <div class="update-message">
                <?php echo __("Last Login"); ?>
            </div>
            <div class="update-datetime">
                <?php echo $lastlogin; ?>
            </div>
        </div>
    </div>
    <!-- enduser profile -->

    <!-- tab navigate -->
    <ul class="tab-navigate list-unstyled bold-16">
        <!--        <li class="item">ข้อมูลส่วนตัว</li>-->
        <li class="item active"><?php echo __("member-profile-order-tracking"); ?></li>
    </ul>
    <!-- endtab navigate -->
    <!-- product list -->
    <div class="container-order-list">
        <div class="title-text bold-24">
            <?php echo __("member-profile-order-tracking"); ?>
        </div>
        <?php if(empty($order)):?>
            <div class="not-found-order"><?php echo __("not-found-order"); ?></div>
        <?php else:?>
            <?php foreach ($order as $o): ?>
                <table class="table table-order-list">
                    <thead>
                    <tr>
                        <th class="column-1"><?php echo __("thankyou-order-no"); ?><br/>
                            <span class="text-order-id bold-18"><?php echo array_get($o, "id", "-"); ?></span>
                        </th>
                        <th class="column-2"><?php echo __("thankyou-order-date"); ?><br/>
                            <span
                                class="text-description normal-16"><?php echo ($order_date = array_get($o, "created_at", "")) ? formatDate($order_date, "d M y H:i:s", $lang) : "-"; ?></span>
                        </th>
                        <th class="column-3"><?php echo __("cart-cost-lbl") ?><br/>
                            <span
                                class="text-description normal-16"><?php echo ($price = array_get($o, "sub_total", 0)) ? number_format($price, 2) : number_format($price, 2); ?></span>
                        </th>
                        <th class="column-4"><?php echo __("cart-number-of-product-lbl"); ?> (<?php echo __("cart-product-unit"); ?>)<br/>
                            <span class="text-description normal-16"><?php echo array_get($o, "total_item", 0); ?></span>
                        </th>
                        <th class="column-5 text-order-detail">
                            <a href="<?php echo URL::toLang("checkout/thank-you?order_id=" . array_get($o, "id", "-") . '&thank=y', array(), Config::get("https.useHttps")); ?>">
                                <img src="<?php echo Theme::asset()->usePath()->url("images/icon-order-detail.png"); ?>"
                                     alt=""/> <?php echo __("tracking-get-buying-detail-title"); ?>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (array_get($o, "shipments", array()) as $shipment): ?>
                        <?php foreach (array_get($shipment, "shipment_items", array()) as $shipment_item): ?>
                            <tr>
                                <td>
                                    <?php
                                    $image_path = array_get($shipment_item, "images", "");
                                    if ( ! empty($image_path)) : ?>
                                        <img width="200" src="<?php echo array_get($shipment_item, "images", "#"); ?>"
                                        alt="<?php echo array_get($shipment_item, "name", "itruemart"); ?>"/>
                                    <?php else : ?>
                                        <img width="200" src="<?php echo Theme::asset()->usePath()->url("images/product/image-not-found-150.jpg"); ?>"
                                             alt="<?php echo array_get($shipment_item, "name", "itruemart"); ?>"/>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <div class="text-order-item-main mbtm-10">
                                        <?php echo array_get($shipment_item, "name", "-"); ?>
                                    </div>
                                    <div class="text-order-item-sub normal-12">
                                        <div><?php echo __("tracking-price-per-unit-title"); ?>
                                            : <?php echo number_format(array_get($shipment_item, "price", 0), 2) ?> <?php echo __("cart-baht-lbl"); ?></div>
                                        <div><?php echo __("Quantity"); ?> <?php echo array_get($shipment_item, "quantity", 0); ?> <?php echo __("piece"); ?></div>
                                        <?php $product_pkey = array_get($shipment_item, "product_pkey", ""); ?>
                                        <?php if ($product_pkey != "" && array_get($shipment_item, "product_status", "") == "active") : ?>
                                        <a href="<?php echo URL::toLang("products/" . $product_pkey . ".html"); ?>"
                                           class="back-link"><?php echo __("tracking-backto-level-d"); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <divclass="text-order-item-main">
                                        <?php echo array_get($shipment_item, "payment_status_customer", ""); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-order-item-main bold-13 mbtm-35">
                                        <!-- อยู่ระหว่างการจัดส่ง-->
                                        <?php
                                            $item_status_customer = array_get($shipment_item, "item_status_customer", "-");
                                            if ($item_status_customer == '-') {
                                                $item_status_customer = __('order-tracking-item-status-default');
                                            }
                                        ?>
                                        <?php echo $item_status_customer; ?>
                                        <br/>
                                            <span class="normal-12"><?php echo __("tracking-no-title"); ?> :
                                                <a class="text-order-item-tracking show-tracking-detail" href="javascript:void(0)"
                                                    data-customer-name="<?php echo array_get($o, "customer_name", "-"); ?>"
                                                    data-customer-address="<?php echo array_get($o, "customer_full_address", "-"); ?>"
                                                    data-customer-tel="<?php echo array_get($o, "customer_tel", "-"); ?>"
                                                    data-product-name="<?php echo array_get($shipment_item, "name", "-"); ?>"
                                                    data-product-quantity="<?php echo array_get($shipment_item, "quantity", "1"); ?>"
                                                    data-tracking-no="<?php echo array_get($shipment_item, "tracking_number", ""); ?>"
                                                >
                                                    <?php echo (array_get($shipment_item, "tracking_number", false))? array_get($shipment_item, "tracking_number", '-') : __("not-found-tracking"); ?>
                                                </a>
                                            </span>
                                    </div>
                                    <div
                                        class="text-order-item-main normal-12"><?php echo __("tracking-estimated-time-shipping"); ?>
                                        :<br/>
                                            <?php if(array_get($shipment_item, "expected_delivery_min", false) && array($shipment_item, "expected_delivery_max", false)): ?>
                                                <span class="text-shipping-date">
                                                    <?php echo array_get($shipment_item, "expected_delivery_min", "") . " - " . array_get($shipment_item, "expected_delivery_max", ""); ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-shipping-date">
                                                    <?php echo ($item_date = array_get($shipment_item, "created_at", "")) ? deliveryPeriod($item_date) : ""; ?>
                                                </span>
                                            <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if(array_get($shipment_item, "tracking_number", false)): ?>
                                    <a href="javascript:void(0);" class="btn btn-item-status mbtm-10 show-tracking-detail"
                                        data-customer-name="<?php echo array_get($o, "customer_name", "-"); ?>"
                                        data-customer-address="<?php echo array_get($o, "customer_full_address", "-"); ?>"
                                        data-customer-tel="<?php echo array_get($o, "customer_tel", "-"); ?>"
                                        data-product-name="<?php echo array_get($shipment_item, "name", "-"); ?>"
                                        data-product-quantity="<?php echo array_get($shipment_item, "quantity", "1"); ?>"
                                        data-tracking-no="<?php echo array_get($shipment_item, "tracking_number", ""); ?>"
                                        >
                                        <?php echo __("tracking-get-shipping-detail-title"); ?>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endforeach; ?>
        <?php endif ;?>
        <!-- pagination -->
        <?php if( ! empty($order)) : ?>
            <?php echo Theme::widget("pagination", $pagination)->render(); ?>
        <?php endif; ?>
        <!-- endpagination -->
    </div>
    <!-- endproduct list -->
</div>
<!-- endorder-tracking-->

<!-- modal -->
<div class="modal fade" id="modal-dialog-order-status" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-order-status" id="order-detail-content">

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- modal template -->
<script type="text/template" id="tracking_template">
    <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="container-order-status">
                <h3 class="order-status-name bold-24"><?php echo __("tracking-shipping-title"); ?></h3>

                <div class="container-order-info">
                    <div class="product-shipping-address">
                        <p class="bold-15"><?php echo __("Shipping address"); ?></p>
                        <span class="description normal-15">
                        <%= customer_name %>
                        <%= customer_address %>
                        <?php echo __("step2-phone"); ?>. <%= customer_tel %>
                        </span>
                    </div>
                    <div class="product-name">
                        <p class="bold-15">
                            <?php echo __("tracking-product-name"); ?>
                        </p>
                        <span class="description normal-15">
                            <%= product_name %>
                        </span>
                    </div>
                    <div class="product-quantity">
                        <p class="bold-15"><?php echo __("cart-number-of-product-lbl"); ?> (<?php echo __("cart-product-unit"); ?>)</p>
                        <span class="description normal-15"><%= quantity %></span>
                    </div>
                </div>
                <h3 class="order-status-name bold-24"><?php echo __("order-tracking-shipment-status"); ?></h3>
                <div class="container-step-order-status">
                    <table class="table step-order-status">
                        <thead>
                        <tr>
                            <th class="text-center column-1 fixSpace"><?php echo __("days"); ?> <?php echo __("month"); ?> <?php echo __("step3-year"); ?> / <?php echo __("tracking-parcel-time-title"); ?></th>
                            <th class=" column-2 "><?php echo __("order-tracking-description"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <% $.each(delivery_data, function(idx, row){ %>
                                <% if(idx == 0) { %>
                                    <tr class="current-status">
                                <% } else { %>
                                    <tr>
                                <% } %>
                                    <td>
                                        <span class="round">
                                        <i class="glyphicon glyphicon-ok"></i>
                                        </span>
                                        <%= row.datetime %>
                                    </td>
                                    <td><%= row.detail %></td>
                                </tr>
                            <% }); %>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</script>
<!-- /modal template -->
<!-- endmodal -->

<!-- modal -->
<div class="modal fade" id="modal-dialog-true-privilege">
    <div class="modal-dialog modal-dialog-true-privilege">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="user-profile box-information">
                    <div class="information-message">
                        <?php //echo __("tracking-truecard-privilege-title"); ?>
                    </div>
                    <div class="information-auth">
                        <input type="text" class="input-identity-card" placeholder="<?php echo __("id-card-13-digit"); ?>"/>
                        <button type="button"
                                class="btn btn-auth"><?php echo __("leveld-truecard-check-privillege"); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- endmodal -->

<script type="text/javascript">
    // It works without the History API, but will clutter up the history
    var history_api = typeof history.pushState !== 'undefined'

    // The previous page asks that it not be returned to
    if ( location.hash == '#no-back' ) {
        // Push "#no-back" onto the history, making it the most recent "page"
        if ( history_api ) history.pushState(null, '', '#stay')
        else location.hash = '#stay'

        // When the back button is pressed, it will harmlessly change the url
        // hash from "#stay" to "#no-back", which triggers this function
        window.onhashchange = function() {
            // User tried to go back; warn user, rinse and repeat
            if ( location.hash == '#no-back' ) {
                alert("You shall not pass!")
                if ( history_api ) history.pushState(null, '', '#stay')
                else location.hash = '#stay'
            }
        }
    }
</script>