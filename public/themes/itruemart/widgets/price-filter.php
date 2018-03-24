<?php
    // First, We'll get all params
    $qstrArr = Input::all();

    // Set params for $urlPriceRange1
    if (isset($qstrArr['priceMin']))
    {
        unset($qstrArr['priceMin']);
    }
    if (isset($qstrArr['page']))
    {
        unset($qstrArr['page']);
    }
    $qstrArr['priceMax'] = 500;
    $urlPriceRange1 = URL::current() . '?' . http_build_query($qstrArr);

    // Set params for $urlPriceRange2
    $qstrArr['priceMin'] = 500;
    $qstrArr['priceMax'] = 1000;
    $urlPriceRange2 = URL::current() . '?' . http_build_query($qstrArr);

    // Set params for $urlPriceRange3
    $qstrArr['priceMin'] = 1000;
    $qstrArr['priceMax'] = 2500;
    $urlPriceRange3 = URL::current() . '?' . http_build_query($qstrArr);

    // Set params for $urlPriceRange4
    $qstrArr['priceMin'] = 2500;
    $qstrArr['priceMax'] = 5000;
    $urlPriceRange4 = URL::current() . '?' . http_build_query($qstrArr);

    // Set params for $urlPriceRange5
    $qstrArr['priceMin'] = 5000;
    $qstrArr['priceMax'] = 8000;
    $urlPriceRange5 = URL::current() . '?' . http_build_query($qstrArr);

    // Set params for $urlPriceRange6
    $qstrArr['priceMin'] = 8000;
    $qstrArr['priceMax'] = 10000;
    $urlPriceRange6 = URL::current() . '?' . http_build_query($qstrArr);

    // Set params for $urlPriceRange6
    $qstrArr['priceMin'] = 10000;
    if (isset($qstrArr['priceMax']))
    {
        unset($qstrArr['priceMax']);
    }
    $urlPriceRange7 = URL::current() . '?' . http_build_query($qstrArr);
?>
<!-- Price -->
<div class="by_price"><?php echo __('Price'); ?></div>
<div class="by_price_list"><a href="<?php echo $urlPriceRange1 ?>" title="₱500 <?php echo __('below'); ?>">₱500 <?php echo __('below'); ?> <span class="font8"></span></a></div>
<div class="by_price_list"><a href="<?php echo $urlPriceRange2 ?>" title="₱500 - ₱1,000">₱500 - ₱1,000 <span class="font8"></span></a></div>
<div class="by_price_list"><a href="<?php echo $urlPriceRange3 ?>" title="₱1,000 - ₱2,500">₱1,000 - ₱2,500  <span class="font8"></span></a></div>
<div class="by_price_list"><a href="<?php echo $urlPriceRange4 ?>" title="₱2,500 - ₱5,000">₱2,500 - ₱5,000 <span class="font8"></span></a></div>
<div class="by_price_list"><a href="<?php echo $urlPriceRange5 ?>" title="₱5,000 - ₱8,000">₱5,000 - ₱8,000  <span class="font8"></span></a></div>
<div class="by_price_list"><a href="<?php echo $urlPriceRange6 ?>" title="₱8,000 - ₱10,000">₱8,000 - ₱10,000  <span class="font8"></span></a></div>
<div class="by_price_list"><a href="<?php echo $urlPriceRange7 ?>" title="₱10,000 <?php echo __('up'); ?>">₱10,000 <?php echo __('up'); ?> <span class="font8"></span></a></div>
<div class="line_lvb2"></div>
