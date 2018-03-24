<?php
    $qstrArr = Input::all();

    $selected1 = '';
    $selected2 = '';
    $selected3 = '';
    $selected4 = '';
    $selected5 = '';

    if (isset($qstrArr['orderBy']) && $qstrArr['orderBy'] == 'price' && isset($qstrArr['order']) && $qstrArr['order'] == 'desc')
    {
        $selected2 = 'selected="selected"';
    }
    elseif (isset($qstrArr['orderBy']) && $qstrArr['orderBy'] == 'price' && isset($qstrArr['order']) && $qstrArr['order'] == 'asc')
    {
        $selected3 = 'selected="selected"';
    }
    elseif (isset($qstrArr['orderBy']) && $qstrArr['orderBy'] == 'discount' && isset($qstrArr['order']) && $qstrArr['order'] == 'desc')
    {
        $selected4 = 'selected="selected"';
    }
    elseif (isset($qstrArr['orderBy']) && $qstrArr['orderBy'] == 'discount' && isset($qstrArr['order']) && $qstrArr['order'] == 'asc')
    {
        $selected5 = 'selected="selected"';
    }
    else
    {
        $selected1 = 'selected="selected"';
    }
?>
<?php
    // get all params
    $qstrArr = Input::all();

    if (isset($qstrArr['orderBy']))
    {
        unset($qstrArr['orderBy']);
    }
    if (isset($qstrArr['order']))
    {
        unset($qstrArr['order']);
    }

    ### Change page = 1 (when OnChange order_by Box) ###
    $qstrArr['page'] = 1;

    $sortByUrl1 = URL::current();
    $sortByUrl1 .= empty($qstrArr) ? '' : '?' . http_build_query($qstrArr);

    $qstrArr['orderBy'] = 'price';
    $qstrArr['order'] = 'desc';
    $sortByUrl2 = URL::current() . '?' . http_build_query($qstrArr);

    $qstrArr['orderBy'] = 'price';
    $qstrArr['order'] = 'asc';
    $sortByUrl3 = URL::current() . '?' . http_build_query($qstrArr);

    $qstrArr['orderBy'] = 'discount';
    $qstrArr['order'] = 'desc';
    $sortByUrl4 = URL::current() . '?' . http_build_query($qstrArr);

    $qstrArr['orderBy'] = 'discount';
    $qstrArr['order'] = 'asc';
    $sortByUrl5 = URL::current() . '?' . http_build_query($qstrArr);

    $url = '';
    if(App::getLocale() == 'th'){
        $url = Request::segment(1);
    }else{
        $url = Request::segment(2);
    }
?>
<?php /*
<div class="base_seller_head">
    <h1><?php //echo $products ?></h1>
</div>
*/ ?>

<div class="productlist_wrapper">
    <div class="sort_group_top">
        <div class="filter">
            <div class="sortby"><span class="font8"><?php echo __("sort-by-title"); ?></span></div>
            <div class="sort_dropdown">
                <div class="dropdown_mid">
                    <div class="dropdown_select_text">
                        <select name="order_by" class="order_by">
                            <option value="<?php echo $sortByUrl1 ?>" <?php echo $selected1 ?>><?php echo __('latest-item-txt'); ?></option>
                            <option value="<?php echo $sortByUrl2 ?>" <?php echo $selected2 ?>><?php echo __('price-high-low-txt'); ?></option>
                            <option value="<?php echo $sortByUrl3 ?>" <?php echo $selected3 ?>><?php echo __("price-low-high-txt"); ?></option>
                            <option value="<?php echo $sortByUrl4 ?>" <?php echo $selected4 ?>><?php echo __("discount-high-low-txt"); ?></option>
                            <option value="<?php echo $sortByUrl5 ?>" <?php echo $selected5 ?>><?php echo __("discount-low-high-txt"); ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="total_items"><span class="font8"><?php echo __("total-amount-title"); ?> <?php echo $total_item ?> <?php echo __("items-title"); ?></span></div>
        </div>
    </div>


        <div class="sort_group_top" id="itm_pagination" data-url="#">
            <div class="box-paging">
                <?php echo $paginator->appends( Input::except(array('page', 'no-cache')) )->links(); ?>
            </div>
            <div class="box-goto">
                <form method="GET" action="<?php echo URL::current() ?>" class="checkLimitPage">
                    <ul>
                        <li><?php echo __("goto-page-title"); ?>
                            <input type="text" id="goToPage" name="page" value="<?php echo $page ?>">
                            <span class="page-amount">/ <span class="total_page"><?php echo $total_page ?></span></span></li>
                        <li><input type="submit" value="<?php echo __("gotopage-btn"); ?>" class="btn-paging-goto"></li>
                        <?php
                            $qstrArr2 = Input::all();
                            foreach ($qstrArr2 as $key=>$val)
                            {
                                if ($key == 'page') continue;
                                echo "<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\">";
                            }
                        ?>
                    </ul>
                </form>
            </div>
        </div>
        
        <div class="product_lvb">
            <?php if (!empty($products)) {
                    $allProductIds = array();
            ?>
                <!-- typeidea script -->
                <?php foreach ($products as $key => $product) { ?>
                    <?php
                        $allProductIdsTxt = !empty($allProductIds)? implode("|", $allProductIds) :'';
                        $collection_name =!empty($data['collection_name'])? $data['collection_name']:'';
                        $product['list_position'] = (($page-1)*21) + $key+1;
                        $product['list_collection'] = 'category-' . $collection_name; 
                    ?>
                    <!-- //typeidea script -->
                    <?php $allProductIds[] = $product['pkey'];?>
                    <div class="over_lvb">
                        <div class="promotionlist_lvb">
                            <?php echo HTML::product($product) ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <?php echo "<p style=\"padding:20px 10px;\">not found</p>"; ?>
            <?php } ?>
        </div>

        <?php if (isset($total_page) && $total_page != 1): ?>
            <div class="sort_group_bottom" id="itm_pagination">
                <div class="box-paging">
                    <?php
                        echo $paginator->appends( Input::except(array('page', 'no-cache')) )->links();
                    ?>
                </div>
                <div class="box-goto">
                    <form method="GET" action="<?php echo URL::current() ?>" class="checkLimitPage">
                        <ul>
                            <li><?php echo __("goto-page-title"); ?>
                                <input type="text" id="goToPage" name="page" value="<?php echo $page ?>">
                                <span class="page-amount">/ <span class="total_page"><?php echo $total_page ?></span></span></li>
                            <li><input type="submit" value="<?php echo __("gotopage-btn"); ?>" class="btn-paging-goto"></li>
                            <?php
                                $qstrArr2 = Input::all();
                                foreach ($qstrArr2 as $key=>$val)
                                {
                                    if ($key == 'page') continue;
                                    echo "<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\">";
                                }
                            ?>
                        </ul>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <div class="paging_group_bottom">
            <div class="filter">
                <div class="sortby"><span class="font8"><?php echo __("sort-by-title"); ?></span></div>
                <div class="sort_dropdown">

                    <div class="dropdown_mid">
                        <div class="dropdown_select_text">
                            <select name="order_by" class="order_by">
                                <option value="<?php echo $sortByUrl1 ?>" <?php echo $selected1 ?>><?php echo __('latest-item-txt'); ?></option>
                                <option value="<?php echo $sortByUrl2 ?>" <?php echo $selected2 ?>><?php echo __('price-high-low-txt'); ?></option>
                                <option value="<?php echo $sortByUrl3 ?>" <?php echo $selected3 ?>><?php echo __("price-low-high-txt"); ?></option>
                                <option value="<?php echo $sortByUrl4 ?>" <?php echo $selected4 ?>><?php echo __("discount-high-low-txt"); ?></option>
                                <option value="<?php echo $sortByUrl5 ?>" <?php echo $selected5 ?>><?php echo __("discount-low-high-txt"); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="total_items"><span class="font8"><?php echo __("total-amount-title"); ?> <?php echo $total_item ?> <?php echo __("items-title"); ?></span></div>
            </div>
        </div>
</div>

<!-- typeidea script -->
<script type="text/javascript">
<?php  $ec_products = array(); ?>
  <?php 
    $allProductIdsTxt = !empty($allProductIds)? implode("|", $allProductIds) :'';
    $collection_name =!empty($data['collection_name'])? $data['collection_name']:'';

    $ec_products = array();
    if (!empty($products)) {
    foreach ($products as $key => $product):
        array_push($ec_products,
            array(  'id' => $product['pkey'], 
                    'name' => $product['title'], 
                    'price' => $product['variants'][0]['price'], 
                    'brand' => $product['brand']['name'], 
                    // 'category' => $product['collections'][0]['name'],
                    'list' => $url .'-' . $collection_name, 
                    'position' => (($page-1)*21) + $key+1));
    endforeach; 
    }
    ?>
    if(typeof ec_products === 'undefined'){
        var ec_products = [];
    } 
    ec_products['category-<?php echo $collection_name; ?>'] = <?php echo jsonUnescapedUnicode(json_encode($ec_products)); ?>;
    dataLayer.push({
      'event': 'productImpressions',
      'ecommerce': {
        'currencyCode': 'PHP',
        'impressions': <?php echo jsonUnescapedUnicode(json_encode($ec_products)); ?>
      }
    });
    dataLayer.push({
      'event': '',
      'ecommerce': {
        'currencyCode': 'PHP',
        'impressions': []
      }
    });
</script>
<!-- //typeidea script -->

<?php
$allProductIdsTxt = !empty($allProductIds)? implode("|", $allProductIds) :'';
$collection_name =!empty($data['collection_name'])? $data['collection_name']:'';
// Writing an in-line script.
Theme::asset()->container('footer')->writeScript('sort-product', '
    $(function() {
        $("select[name=order_by]").change(function(){
            window.location.href = $(this).children("option:selected").val();
        });
    });

    var allproductids = "'.$allProductIdsTxt.'"
    var delimiter = "|";

    var productlist = [];
    var products = allproductids.split(delimiter);

    for (var i=0;i<products.length;i++)
            {
                productlist[i] = products[i];
            }
');
?>