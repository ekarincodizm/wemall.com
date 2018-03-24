var ManageCampaignProductLightbox = ManageCampaignProductLightbox || {};

ManageCampaignProductLightbox.Main = (function ($) {
    var me = {};
    me.dialogSelector = "#campaign-product-lightbox";
    me.confirmDeleteBtn = "#confirm-campaignproduct-delete-btn";
    me.deleteBtn = ".btn-delete-campaignproduct-popup";
    me.checkoutData = undefined;


    me.itemTemplate = '<% $.each(itemlists, function(idx, item){ %> \n\
            <div class="cart-title-list">  \n\
                <div class="cart-box-img">  \n\
                    <% if(item.thumbnail != undefined){ %>\n\
                    <img src="<%= item.thumbnail %>" width="95" height="95"/>    \n\
                    <% } %>\n\
                </div>    \n\
                <div class="left">  \n\
                    <div class="cart-box-name"> \n\
                        <% if(item.name) { %>     \n\
                        <h2><%= item.name %></h2>   \n\
                        <% } %> \n\
                    </div>  \n\
                    <div class="cart-box-price">    \n\
                        <% if( item.price != item.net_price ){ %>\n\
                            <span class="alert"><%= parseFloat(item.price).formatMoney(2) %></span>   \n\
                            <br/>   \n\
                            <span class="line-through"><%= parseFloat(item.net_price).formatMoney(2) %></span>    \n\
                            <br/>   \n\
                            <%= __("cart-discount-percent-lbl") %> <%= Math.floor(( (item.net_price - item.price) / item.net_price ) * 100) %> %    \n\
                        <% }else{ %>    \n\
                            <span class="alert"><%= parseFloat(item.price).formatMoney(2) %></span>   \n\
                            <br/>   \n\
                        <% } %>\n\
                    </div>  \n\
                    <div class="cart-box-no"> \n\
                        <span class="select-cart--view">    \n\
                            <% if(item.quantity != undefined) { print(item.quantity); } else { print("0"); } %>\n\
                        </span> \n\
                    </div> \n\
                    <div class="cart-box-price2"><%= (item.price * item.quantity).formatMoney(2) %></div> \n\
                    <div class="clear"></div> \n\
                </div> \n\
                <div class="clear"></div> \n\
            </div>  \n\
        <%  }); %>';

    me.init = function () {

        $(".close-campaign-item-lightbox").click(function () {
            me.hideManageItemLightbox();
        });

        $(me.deleteBtn).click(function () {
            me.hideManageItemLightbox();
            $("#campaign-product-confirmation").modal("show");
        });

        $("#campaign-cancel-confirmation-dialog, #campaign-close-confirmation-dialog").click(function () {
            me.hideManageItemLightbox();
            $("#campaign-product-confirmation").modal("hide");
        });

        $(me.confirmDeleteBtn).click(function () {
            me.removeItems(this);
        });
    }

    me._prepareData = function () {
        var cartDetailUrl = '/ajax/v2/checkout';
        if (LANG != 'th') {
            cartDetailUrl = "/" + LANG + cartDetailUrl;
        }
        $.ajax({
            type: 'POST',
            async: false,
            url: cartDetailUrl,
            success: function (response) {
                if (response.code == 200) {
                    var checkoutData = response.data;
                    me._alignCheckoutData(checkoutData);
                }
            },
            error: function (err) {

            }
        });
    }

    me.removeItems = function (that) {

        var deleteItemUrl = UrlToLang('/ajax/cart/remove-items');
        var inventotryIds = $(that).data("inventory-ids");

        $(document).trigger("show-ajax-loading");
        $(me.confirmDeleteBtn).attr("disabled", "disabled");
        me.hideConfirmLightbox();

        $.ajax({
            type: 'POST',
            url: deleteItemUrl,
            data: {
                inventory_ids: inventotryIds
            },
            success: function (response) {
                if (response.code == 200) {

                    if (response.data.totalQty < 1) {
                        window.location.reload();
                    }

                    $(document).trigger("refresh-cart-lightbox");
                    $(me.confirmDeleteBtn).removeAttr("disabled");
                }
            },
            error: function (err) {
                $(document).trigger("hide-ajax-loading");
            }
        });

    }

    me.hideConfirmLightbox = function () {
        $("#campaign-product-confirmation").modal("hide");
    }
    me.hideManageItemLightbox = function () {
        $(me.dialogSelector).modal("hide");
    }

    me._alignCheckoutData = function (checkoutData) {

        if (checkoutData == undefined) {
            me._prepareData();
            return false;
        }

        try {
            me.items = {};
            me.checkoutData = checkoutData;

            if (checkoutData.items_count > 0) {
                $.each(checkoutData.shipments, function (skey, shipment) {
                    $.each(shipment.items, function (ikey, item) {
                        me.items[item.inventory_id] = item;
                    });
                });
            }
        } catch (e) {
            //do nothing.
        }
    }

    me.check = function () {
        me._prepareData();
        if (me.checkoutData.checkPriceChange) {

            if (me.checkoutData.checkPriceChange.summary.price_change.length > 0) {
                me._render("price_change", me.checkoutData.checkPriceChange.summary.price_change);
                return false;
            }

            if (me.checkoutData.checkPriceChange.summary.full_quota.length > 0) {
                me._render("full_quota", me.checkoutData.checkPriceChange.summary.full_quota);
                return false;
            }

            if (me.checkoutData.checkTmh.expired.length > 0) {
                tmh = [me.checkoutData.checkTmh.expired];
                me._render("hold_overtime", tmh);
                return false;
            }
        }

        return true;
    }

    me._render = function (kind, blacklistInventory) {
        var allowItems = [];
        var allowsCount = 0;
        var notAllowItems = [];
        var notAllowCount = 0;
        var deleteInventoryId = '';

        // convert blacklistInventory
        for (var i = 0; i < blacklistInventory.length; i++) {
            blacklistInventory[i] = blacklistInventory[i].toString();
        }

        $.each(me.items, function (inv_id, item) {
            if ($.inArray(inv_id.toString(), blacklistInventory) == -1) {
                allowItems.push(item);
                allowsCount += parseInt(item.quantity);
            } else {
                notAllowItems.push(item);
                deleteInventoryId += inv_id + ",";
                notAllowCount += parseInt(item.quantity);
            }
        });

        //set lightbox title
        if (kind == 'price_change') {
            $("#campaign-product-lightbox-title").html(__("managecampaignproduct-pricechange-title"));
        } else if (kind == 'hold_overtime') {
            $("#campaign-product-lightbox-title").html(__("managecampaignproduct-hold-overtime-title"));
        } else {
            $("#campaign-product-lightbox-title").html(__("managecampaignproduct-fullquota-title"));
        }

        $("#manage-campaignproduct-all-count").html(notAllowItems.length + allowItems.length);

        var notAllowTitle = __("managecampaignproduct-unpayable-list-title") +
            " (" + notAllowItems.length + " " + __("list_unit") + ")";
        $("#campaign-notallow-count").html(notAllowTitle);
        $("span.manage-campaignproduct-notallow-count").html(notAllowItems.length);

        var allowTitle = __("managecampaignproduct-payable-list-title") +
            " (" + allowItems.length + " " + __("list_unit") + ")";
        $("#campaign-allow-count").html(allowTitle);

        $(me.confirmDeleteBtn).data("inventory-ids", deleteInventoryId);

        //render not allow.
        var compiled = _.template(me.itemTemplate);
        var allowTemplate = compiled({itemlists: allowItems, styleCls: ""});
        var notAllowTemplate = compiled({itemlists: notAllowItems, styleCls: "error"});

        $("#manage-campaign-allow-list .cart-title-list, #manage-campaign-notallow-list .cart-title-list").remove();

        if(allowItems.length > 0){
            $("#campaign-allow-container").css("display", "block");
        }else{
            $("#campaign-allow-container").css("display", "none");
        }
        $("#manage-campaign-allow-list").css("display", "block").prepend(allowTemplate);

        if(notAllowItems.length > 0){
            $("#campaign-notallow-container").css("display", "block");
        }else{
            $("#campaign-notallow-container").css("display", "none");
        }
        $("#manage-campaign-notallow-list").prepend(notAllowTemplate);

        $(me.dialogSelector).modal("show");
    }
    return me;

})(jQuery);

$(document).ready(function () {
    ManageCampaignProductLightbox.Main.init();
});