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
?>
<?php /*
<div class="base_seller_head">
    <h1><?php //echo $products ?></h1>
</div>
*/ ?>
<div class="productlist_wrapper">
    <div class="sort_group_top">
        <div class="filter">
            <div class="sortby"><span class="font8">จัดเรียงตาม</span></div>
            <div class="sort_dropdown">
                <div class="dropdown_mid">
                    <div class="dropdown_select_text">
                        <select name="order_by" class="order_by">
                            <option value="<?php echo $sortByUrl1 ?>" <?php echo $selected1 ?>>สินค้าใหม่</option>
                            <option value="<?php echo $sortByUrl2 ?>" <?php echo $selected2 ?>>ราคามาก - น้อย</option>
                            <option value="<?php echo $sortByUrl3 ?>" <?php echo $selected3 ?>>ราคาน้อย - มาก</option>
                            <option value="<?php echo $sortByUrl4 ?>" <?php echo $selected4 ?>>เปอร์เซนต์ที่ลดมาก - น้อย</option>
                            <option value="<?php echo $sortByUrl5 ?>" <?php echo $selected5 ?>>เปอร์เซนต์ที่ลดน้อย - มาก</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="total_items"><span class="font8">จำนวนทั้งหมด <?php echo count($products) ?> ชิ้น</span></div>
        </div>
    </div>


        <div class="sort_group_top" id="itm_pagination" data-url="#">
            <div class="box-paging">
                <?php echo $paginator->appends( Input::except('page') )->links(); ?>
            </div>
            <div class="box-goto">
                <form method="GET" action="" class="checkLimitPage">
                    <ul>
                        <li>ไปที่หน้า
                            <input type="text" id="goToPage" name="page" value="<?php echo $page ?>">
                            <span class="page-amount">/ <span class="total_page"><?php echo $total_page ?></span></span></li>
                        <li><input type="submit" value="ไป" class="btn-paging-goto"></li>
                    </ul>
                </form>
            </div>
        </div>

        <div class="product_lvb">
            <?php if ($products != null) { ?>
                <?php foreach ($products as $product) { ?>
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
                        echo $paginator->appends( Input::except('page') )->links();
                    ?>
                </div>
                <div class="box-goto">
                    <form method="GET" action="" class="checkLimitPage">
                        <ul>
                            <li>ไปที่หน้า
                                <input type="text" id="goToPage" name="page" value="<?php echo $page ?>">
                                <span class="page-amount">/ <span class="total_page"><?php echo $total_page ?></span></span></li>
                            <li><input type="submit" value="ไป" class="btn-paging-goto"></li>
                        </ul>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <div class="paging_group_bottom">
            <div class="filter">
                <div class="sortby"><span class="font8">จัดเรียงตาม</span></div>
                <div class="sort_dropdown">

                    <div class="dropdown_mid">
                        <div class="dropdown_select_text">
                            <select name="order_by" class="order_by">
                                <option value="<?php echo $sortByUrl1 ?>" <?php echo $selected1 ?>>สินค้าใหม่</option>
                                <option value="<?php echo $sortByUrl2 ?>" <?php echo $selected2 ?>>ราคามาก - น้อย</option>
                                <option value="<?php echo $sortByUrl3 ?>" <?php echo $selected3 ?>>ราคาน้อย - มาก</option>
                                <option value="<?php echo $sortByUrl4 ?>" <?php echo $selected4 ?>>เปอร์เซนต์ที่ลดมาก - น้อย</option>
                                <option value="<?php echo $sortByUrl5 ?>" <?php echo $selected5 ?>>เปอร์เซนต์ที่ลดน้อย - มาก</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="total_items"><span class="font8">จำนวนทั้งหมด <?php echo count($products) ?> ชิ้น</span></div>
            </div>
        </div>
</div>

<?php
// Writing an in-line script.
Theme::asset()->container('footer')->writeScript('sort-product', '
    $(function() {
        $("select[name=order_by]").change(function(){
            window.location.href = $(this).children("option:selected").val();
        });
    });
');
?>