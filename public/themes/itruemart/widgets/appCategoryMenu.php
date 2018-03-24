<?php //sd(App::getLocale());   ?>

<div class="header__sidebar">
    <ul class="sidebar_1">
        <li>
            <a href="<?php echo URL::toLang('shopbybrand') ?>" title="<?php echo strtoupper(__('shop_by_brand')); ?>" data-id="category_1"><?php echo strtoupper(__('shop_by_brand')); ?></a>
        </li>
        <?php if (!empty($category['collections'])): ?>
            <?php foreach ($category['collections'] as $item => $cat_value): ?>
                <li>
                    <a href="<?php echo get_permalink('category', $cat_value) ?>" data-id="category_3">
                        <?php
                        if (App::getLocale() == 'th') {
                            echo array_get($cat_value, 'name');
                        } else {
                            if (array_get($cat_value, 'translates') != null) {
                                echo array_get($cat_value['translates'], Config::get('locale.' . App::getLocale()) . '.name');
                            } else {
                                echo array_get($cat_value, 'name');
                            }
                        }
                        ?>
                    </a>
                    <div class="sidebar_group">
                        <?php if (!empty($cat_value['children'])): ?>
                            <!-- Sub Category -->
                            <ul class="sidebar_2" id="category_1">
                                <li class="sidebar_name">
                                    <?php
                                    if (App::getLocale() == 'th') {
                                        echo array_get($cat_value, 'name');
                                    } else {
                                        if (array_get($cat_value, 'translates') != null) {
                                            echo array_get($cat_value['translates'], Config::get('locale.' . App::getLocale()) . '.name');
                                        } else {
                                            echo array_get($cat_value, 'name');
                                        }
                                    }
                                    ?>
                                </li>
                                <?php
                                $display = 6;
                                $total_subcat = isset($cat_value['children'])? count($cat_value['children']) :0;
                                $i = 0;
                                ?>
                                <?php foreach ($cat_value['children'] as $c_key => $children): ?>
                                    <?php
                                    if ($i > $display) {
                                        $cat_name = null;
                                        if (App::getLocale() == 'th') {
                                            $cat_name = array_get($cat_value, 'name');
                                        } else {
                                            if (array_get($cat_value, 'translates') != null) {
                                                $cat_name = array_get($cat_value['translates'], Config::get('locale.' . App::getLocale()) . '.name');
                                            } else {
                                                $cat_name = array_get($cat_value, 'name');
                                            }
                                        }

                                        echo '<li><a title="' . $cat_name . '" class="other_brand" href="' . get_permalink('category', $cat_value) . '">...</a></li>';
                                        break;
                                    }
                                    $i = $i + 1;
                                    ?>
                                    <li>
                                        <a href="<?php echo get_permalink('category', $children) ?>">
                                            <?php
                                            if (App::getLocale() == 'th') {
                                                echo array_get($children, 'name');
                                            } else {
                                                if (array_get($children, 'translates') != null) {
                                                    echo array_get($children['translates'], Config::get('locale.' . App::getLocale()) . '.name');
                                                } else {
                                                    echo array_get($children, 'name');
                                                }
                                            }
                                            ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if (!empty($cat_value['brands'])): ?>
                            <!-- Brands -->
                            <ul class="sidebar_3">
                                <li>
                                    <?php foreach ($cat_value['brands'] as $b_key => $brand): ?>
                                        <a style="text-align: center;" href="<?php echo URL::toLang('/brand/' . $brand['pkey'] . ''); ?>" title="<?php echo $brand['name']?:""; ?>">
                                            <img  src="<?php echo !empty($brand['image'])? str_replace("http://", "//", $brand['image']): "#"; ?>" alt="<?php echo $brand['name']?:""; ?>" />
                                        </a>
                                        <?php if ($b_key == 12): ?>
                                            <a href="<?php echo URL::to('shopbybrand') ?>" class="other_brand" title="<?php echo strtoupper(__('shop_by_brand')); ?>">...</a>
                                            <?php break 1; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </li>
                            </ul>
                        <?php endif; ?>

                        <?php if (!empty($cat_value['products'])): ?>
                            <!-- Products -->
                            <?php
                            if (count($cat_value['products']) == 1) {
                                $product_style = "lay_col_1";
                            } elseif (count($cat_value['products']) == 2) {
                                $product_style = "lay_col_2";
                            } elseif (count($cat_value['products']) == 3) {
                                $product_style = "lay_col_3";
                            } elseif (count($cat_value['products']) >= 4) {
                                $product_style = "lay_col_4";
                            } else {
                                $product_style = "";
                            }
                            ?>
                            <ul class="sidebar_4 <?php echo $product_style; ?>">
                                <?php foreach ($cat_value['products'] as $p_key => $product): ?>
                                    <?php
                                    if (App::getLocale() == 'th') {
                                        $product_title = array_get($product, 'title');
                                    } else {
                                        if (array_get($product, 'translates') != null) {
                                            $product_title = array_get($product['translates'], Config::get('locale.' . App::getLocale()) . '.title');
                                        } else {
                                            $product_title = array_get($product, 'title');
                                        }
                                    }
                                    ?>
                                    <li>
                                        <a href="<?php echo get_permalink('products', $product) ?>">
                                            <?php $percent_discount_max = isset($product['percent_discount']['max']) ? $product['percent_discount']['max'] : 0; ?>
                                            <?php $percent_discount_min = isset($product['percent_discount']['min']) ? $product['percent_discount']['min'] : 0; ?>
                                            <?php if ($percent_discount_max > 0): ?>
                                                <?php if (count($cat_value['products']) == 1 || count($cat_value['products']) == 2 || (count($cat_value['products']) == 3 && $p_key == 0)): ?>
                                                    <span class="price_tag">
                                                        <span class="price_text"><?php echo __("up_to"); ?></span>
                                                        <span class="price_no">
                                                            <?php
                                                            echo floor($percent_discount_max);
                                                            ?>
                                                        </span>
                                                        <sup>%</sup>
                                                        <sub>OFF</sub>
                                                    </span>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <img src="<?php echo !empty($product['image_cover']['normal'])? $product['image_cover']['normal'] : "#"; ?>" alt="<?php echo $product_title; ?>" />

                                            <span class="product_information">
                                                <span class="tag_product_name"><?php echo $product_title; ?></span>
                                                <span class="tag_price">

                                                    <?php if ($percent_discount_max > 0): ?>
                                                        <span class="price_discount">
                                                            <?php
                                                            $price_range_max = isset($product['price_range']['max']) ? $product['price_range']['max'] : 0;
                                                            $price_range_min = isset($product['price_range']['min']) ? $product['price_range']['min'] : 0;
                                                            if ($price_range_max > $price_range_min) {
                                                                echo price_format($price_range_min);
                                                            } else {
                                                                echo price_format($price_range_max);
                                                            }
                                                            ?>
                                                        </span>
                                                    <?php endif; ?>

                                                    <span class="price_normal <?php
                                                          if ($percent_discount_max > 0) {
                                                              echo "discount";
                                                          }
                                                          ?>">
                                                              <?php
                                                              $net_price_range_max = isset($product['net_price_range']['max']) ? $product['net_price_range']['max'] : 0;
                                                              $net_price_range_min = isset($product['net_price_range']['min']) ? $product['net_price_range']['min'] : 0;
                                                              if ($net_price_range_max != $net_price_range_min) {
                                                                  //echo price_format($net_price_range_min) . " - " . price_format($net_price_range_max)." .-";
                                                                  echo price_format($net_price_range_min);
                                                              } else {
                                                                  echo price_format($net_price_range_max);
                                                              }
                                                              ?>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <?php if ($p_key == 3): ?>
                                        <?php break 1; ?>
                                    <?php endif; ?>
                            <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>
