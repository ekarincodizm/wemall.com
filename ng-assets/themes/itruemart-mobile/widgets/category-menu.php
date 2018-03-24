<?php
if ( !function_exists('recursive_array_search'))
{
    function recursive_array_search($needle,$haystack)
    {
        foreach($haystack as $key=>$value)
        {
            $current_key=$key;
            if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false))
            {
                // return $current_key;
                return TRUE;
            }
        }

        return FALSE;
    }
}

if ( !function_exists('in_category'))
{
    function in_category($collection, $currentPkey)
    {
        if (empty($currentPkey))
        {
            return FALSE;
        }

        return recursive_array_search($currentPkey, $collection);
    }
}
?>
<?php
    $currentRouteAction = Route::currentRouteAction();

    switch($currentRouteAction)
    {
        case 'ProductsController@getFlashsaleProducts' :
            $firstSectionUri = 'flash-sale/category';
            break;
        case 'ProductsController@getItruemartTvProducts' :
            $firstSectionUri = 'itruemart-tv/category';
            break;
        case 'ProductsController@getDiscountProducts' :
            $firstSectionUri = 'discount-products/category';
            break;
        case 'ProductsController@getTrueyouProducts' :
            $firstSectionUri = 'trueyou/category';
            break;
        default :
            $firstSectionUri = 'category';
            break;
    }
?>
<?php if ( !empty($collections) ) { ?>
    <h3><?php echo __('หมวดหมู่สินค้า') ?></h3>
    <div class="line_lvb"></div>
    <div class="categorieslist" style="margin-bottom:30px;">
        <div class="glossymenu">
            

            <?php foreach ($collections as $collection) { ?>    
                <div style="position: relative; display:block;">
                    <a class="menuitem submenuheader">
                        <div class="menuitem_head">&nbsp;</div>
                        <span class="accordsuffix">
                            <?php if ( in_category($collection, $currentPkey) ) { ?>
                                <img border="0" src="http://www.itruemart.com/assets/itruemart_new/global/images/minus.gif">
                            <?php } else { ?>
                                <img border="0" src="http://www.itruemart.com/assets/itruemart_new/global/images/plus.gif">
                            <?php } ?>
                        </span>
                    </a>
                    <a title="<?php echo $collection['name'] ?>" href="<?php echo get_permalink($firstSectionUri, $collection) ?>" class="menuitem2"><?php echo $collection['name'] ?></a>
                </div>

                <?php if (in_category($collection, $currentPkey) && !empty($collection['children'])) { ?>
                    <?php foreach ($collection['children'] as $children1) { ?>
                        <div class="submenu show_submenu">
                            <ul>
                                <li>
                                    <a title="<?php echo $children1['name'] ?>" href="<?php echo get_permalink($firstSectionUri, $children1) ?>">
            
                                        <?php 
                                            if(App::getLocale()=='th')
                                            {
                                                echo array_get($children1,'name');
                                            }
                                            else
                                            {
                                                if(array_get($children1,'translate') != null)
                                                {
                                                    echo array_get($children1,'translate.name');
                                                }
                                                else
                                                {
                                                    echo array_get($children1,'name');
                                                }
                                            }
                                        ?>
                                    </a>
                                    <span class="accordsuffix-sub">
                                        <?php if ( in_category($children1, $currentPkey) ) { ?>
                                            <img border="0" src="http://www.itruemart.com/assets/itruemart_new/global/images/minus.gif">
                                        <?php } else { ?>
                                            <img border="0" src="http://www.itruemart.com/assets/itruemart_new/global/images/plus.gif">
                                        <?php } ?>
                                    </span>

                                    <?php if (in_category($children1, $currentPkey) && !empty($children1['children'])) { ?>
                                        <?php foreach ($children1['children'] as $children2) { ?>
                                            <div class="submenu show_submenu">
                                                <ul>
                                                    <li>
                                                        <a title="<?php echo $children2['name'] ?>" href="<?php echo get_permalink($firstSectionUri, $children2) ?>">
                                                            <?php 
                                                                if(App::getLocale()=='th')
                                                                {
                                                                    echo array_get($children1,'name');
                                                                }
                                                                else
                                                                {
                                                                    if(array_get($children1,'translate') != null)
                                                                    {
                                                                        echo array_get($children1,'translate.name');
                                                                    }
                                                                    else
                                                                    {
                                                                        echo array_get($children1,'name');
                                                                    }
                                                                }
                                                            ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                <?php } ?>

            <?php } ?>
        </div>
    </div>
<?php } ?>