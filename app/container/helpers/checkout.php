<?php

if (! function_exists('getLimitQuantityFromCheckout'))
{
    function getLimitQuantityFromCheckout(Array $checkout)
    {
        $limitQuantity = array();

        // check with collection
        foreach($checkout['shipments'] as $shipment)
        {
            foreach ($shipment['items'] as $item)
            {
                foreach ($item['collections'] as $collection)
                {
                    if(in_array($collection['pkey'], \Config::get('settings.limit-cart-item-quantity.collections')))
                    {
                        $limitQuantity[$item['inventory_id']] = 1;
                    }
                }
            }
        }

        // check with discount campaign
        foreach($checkout['discount_campaigns'] as $discount_campaign)
        {
            if(in_array($discount_campaign['type'], \Config::get('settings.limit-cart-item-quantity.discount-campaigns')))
            {
                foreach($discount_campaign['inventory_id'] as $inventory_id)
                {
                    $limitQuantity[$inventory_id] = 1;
                }
            }
        }

        return $limitQuantity;
    }
}