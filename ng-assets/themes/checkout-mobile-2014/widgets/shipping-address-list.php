<?php if (!empty($shipping_address["data"])): ?>
    <form action="<?php URL::toLang("checkout/step2"); ?>" method="POST" id="member-address">
        <?php foreach ($shipping_address["data"] as $key => $value): ?>
            <div class="row address-block">
                <div
                    class="col-xs-12 address-list <?php echo ($currentAddress == $value["customer_addresses_id"]) ? "selected" : ""; ?>">
                    <input type="radio" name="address" value="<?php echo $value["customer_addresses_id"]; ?>"
                           id="address-list-<?php echo $key; ?>" <?php echo ($currentAddress == $value["customer_addresses_id"]) ? "checked='checked'" : ""; ?>/>
                    <label for="address-list-<?php echo $key; ?>">
                        <h3><?php echo $value["customer_name"]; ?></h3>

                        <p class="address-name">
                            <?php echo $value["full_address"]; ?>
                        </p>

                        <div class="row">
                            <div class="col-xs-12 ad-dress">
                                <div class="address-delete col-xs-6">
                                    <a href="javascript:void(0);" class="delete-ship-addr delete-member-address"
                                       data-action="<?php echo URL::toLang("ajax/customers/delete-ship-addr"); ?>"
                                       data-addr-id="<?php echo $value["customer_addresses_id"]; ?>" data-toggle="modal"
                                       data-target="#delete-confirm-box"><?php echo __("step2-delete-addr"); ?></a>
                                </div>
                                <div class="address-edit col-xs-6">
                                    <a href="<?php echo $value["edit_url"]; ?>"
                                       class="edit-ship-addr"><?php echo __("step2-edit-addr"); ?></a>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
        <?php endforeach; ?>
    </form>
<?php endif; ?>