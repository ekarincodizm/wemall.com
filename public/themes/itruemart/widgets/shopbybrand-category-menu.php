<?php
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

function in_category($collection, $currentPkey)
{
    if (empty($currentPkey))
    {
        return FALSE;
    }

    return recursive_array_search($currentPkey, $collection);
}
?>
<?php if ( !empty($collections) ) { ?>
    <?php foreach ($collections as $collection) { ?>
        <ul id="main-menu">
            <li>
                <div class="main-categories">
                    <a href="<?php echo get_permalink('shopbybrand/category', $collection) ?>" title="<?php echo $collection['name'] ?>">
                        <?php if(Lang::getLocale() != 'th' && isset($collection['translate']['name'])): ?>
                            <?php echo $collection['translate']['name']; ?>
                        <?php else: ?>
                            <?php echo $collection['name']; ?>
                        <?php endif; ?>
                        <?php if ( in_category($collection, $currentPkey) ) { ?>
                            <img src="http://www.itruemart.com/assets/itruemart_new/global/images/icon-expand.jpg" class="icon-status">
                        <?php } else { ?>
                            <img src="http://www.itruemart.com/assets/itruemart_new/global/images/icon-collapse.jpg" class="icon-status">
                        <?php } ?>
                    </a>
                </div>
                <?php if (in_category($collection, $currentPkey) && !empty($collection['children'])) { ?>
                    <?php foreach ($collection['children'] as $children1) { ?>
                        <?php $subCategoryClassname = ( in_category($children1, $currentPkey) ) ? 'pad-1a' : 'pad-1' ; ?>
                        <ul class="sub-menu">
                            <li>
                                <div class="sub-categories <?php echo $subCategoryClassname ?>">
                                    <a href="<?php echo get_permalink('shopbybrand/category', $children1) ?>" title="<?php echo $children1['name'] ?>">
                                        <?php if(Lang::getLocale() != 'th' && isset($children1['translate']['name'])): ?>
                                            <?php echo $children1['translate']['name']; ?>
                                        <?php else: ?>
                                            <?php echo $children1['name']; ?>
                                        <?php endif; ?>
                                    </a>
                                    <?php /*
                                    <a href="<?php echo get_permalink('shopbybrand/category', $children1) ?>" title="<?php echo $children1['name'] ?>">
                                        <?php echo $children1['name'] ?>
                                        <?php if ( in_category($children1, $currentPkey) ) { ?>
                                            <img src="http://www.itruemart.com/assets/itruemart_new/global/images/icon-sub-expand.jpg" class="icon-status">
                                        <?php } else { ?>
                                            <img src="http://www.itruemart.com/assets/itruemart_new/global/images/icon-sub-collapse.jpg" class="icon-status">
                                        <?php } ?>
                                    </a>
                                    -->
                                    */ ?>
                                </div>
                            </li>
                        </ul>
                        <?php if (in_category($children1, $currentPkey) && !empty($children1['children'])) { ?>
                            <ul class="sub-menu sub-box">
                                <?php foreach ($children1['children'] as $children2) { ?>
                                    <li>
                                        <div class="sub-categories pad-2<?php if (in_category($children2, $currentPkey)) { echo ' menu-actived'; } ?>">
                                            <a href="<?php echo get_permalink('shopbybrand/category', $children2) ?>" title="<?php echo $children2['name'] ?>">
                                                <?php if(Lang::getLocale() != 'th' && isset($children2['translate']['name'])): ?>
                                                    <?php echo $children2['translate']['name']; ?>
                                                <?php else: ?>
                                                    <?php echo $children2['name']; ?>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </li>
        </ul>
    <?php } ?>
<?php } ?>