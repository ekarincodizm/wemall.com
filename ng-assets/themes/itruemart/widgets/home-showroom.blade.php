@foreach ($showroom as $item)
    <div class="home__showroom_container layout_{{{ $item['layout_id'] }}}"
         data-id="{{{ $item['layout_id'] }}}"
         id="{{{ $item['showroom_id'] }}}">

        {{-- render banner --}}
        @if ( ! empty($item['banner']))
            <!-- typeidea script -->
            <?php $arr = explode("#", $item['banner']['link']); $ec_banner_promo = end($arr); ?>
            <a class="showroom_banner ec-promotion" href="{{{ array_get($item, 'banner.link') }}}" data-ec-promotion="<?php echo $ec_banner_promo; ?>|<?php echo $ec_banner_promo; ?>|showroom-{{{ $item['showroom_id'] }}}-{{{ $item['banner']['position'] }}}">
            <!-- //typeidea script -->
                <img data-original="{{{ array_get($item, 'banner.thumbnail.desktop') }}}" class="lazyload"/></a>
        @endif

        {{-- render brand --}}
        @if ( ! empty($item['brand']))
            <ul class="showroom_brand">
                @foreach ($item['brand'] as $brand)
                    <li class="brand_item">
                        <a class="brand_link"
                           href="{{{ array_get($brand, 'link') }}}"
                           id="{{{ array_get($brand, 'id') }}}">
                            <img src="{{{ array_get($brand, 'thumbnail') }}}" alt="{{{ array_get($brand, 'name') }}}"/>
                        </a>
                    </li>
                @endforeach
                {{-- <li class="brand_item"><a href="{{{ URL::toLang("shopbybrand") }}}" class="brand_link"><span class="brand_more">...</span></a></li> --}}
            </ul>
        @endif

        {{-- render showroom --}}
        <div class="showroom_wrapper">
            <div class="showroom_header">
                <div class="showroom_name">
                    <h2 class="page_main_h2_subject">{{ array_get($item, 'showroom_title') }}</h2>
                    <b><a href="{{{ array_get($item, 'showroom_link') }}}">{{ array_get($item, 'showroom_title') }}</a></b>
                </div>
            </div>
            <div class="showroom_content">

                {{-- render product --}}
                @foreach ($item['product'] as $product)
                    <div class="box_{{{ array_get($product, 'box') }}} box_{{{ array_get($product, 'type') }}}"
                         data-position="{{{ array_get($product, 'position') }}}"
                         id="{{{ array_get($product, 'id') }}}">

                        @if ($product['type']=='banner')
                        <!-- typeidea script -->
                        <?php $arr = explode("#", $product['link']); $ec_banner_promo = end($arr); ?>
                            <a href="{{{ array_get($product, 'link') }}}" class="ec-promotion" data-ec-promotion="<?php echo $ec_banner_promo; ?>|<?php echo $ec_banner_promo; ?>|showroom-{{{ $item['showroom_id'] }}}-{{{ array_get($product, 'position') }}}">
                        <!-- //typeidea script -->
                                <img data-original="{{{ array_get($product, 'thumbnail.desktop') }}}" alt=""
                                     class="lazyload">
                            </a>

                        @elseif($product['type']=='product')
                            <!-- typeidea script -->
                            <a href="{{{ array_get($product, 'link') }}}" class="ec-product" data-ec-item="showroom-{{{ $item['showroom_id'] }}}|{{ array_get($product, 'pkey') }}|{{{ array_get($product, 'position') }}}">
                            <!-- typeidea script -->
                                @if (array_filter(array_get($product, 'price.discount')))
                                    <span class="price_tag">
                                    <span class="price_no">
                                        @if ( array_get($product, 'price.discount.min') == array_get($product, 'price.discount.max') )
                                            {{ floor(array_get($product, 'price.discount.min')) }}
                                        @else
                                            <span class="price_text">{{ __('up_to') }}</span>
                                            {{ floor(array_get($product, 'price.discount.max')) }}
                                        @endif
                                    </span>
                                    <sup>%</sup>
                                    <sub>OFF</sub>
                                </span>
                                @endif

                                <span class="product_thumbnail">
                                <img data-original="{{{ array_get($product, 'thumbnail.desktop') }}}"
                                     class="lazyload" alt="{{{ array_get($product, 'title') }}}">
                            </span>

                                <span class="product_name">{{ array_get($product, 'title') }}</span>

                            <span class="product_price">
                                @if (array_filter(array_get($product, 'price.special')))
                                    <span class="price_discount">{{ price_format(array_get($product, 'price.special.min')) }}</span>
                                    <span class="price_normal discount">{{ price_format(array_get($product, 'price.net.min')) }}</span>
                                @else
                                    <span class="price_normal">
                                        @if ( array_get($product, 'price.normal.min') != array_get($product, 'price.normal.max') )
                                            {{ __('start') }}
                                            {{ price_format(array_get($product, 'price.normal.min')) }}
                                        @else
                                            {{ price_format(array_get($product, 'price.normal.min')) }}
                                        @endif
                                    </span>
                                @endif
                            </span>
                            </a>
                        @endif

                    </div>
                @endforeach

            </div>
        </div>

    </div>
    <!-- typeidea script -->
<script type="text/javascript">
  <?php
    $ec_products = array();
    $ec_banner = array();


    if( ! empty($item['banner'])){
        $arr = explode("#", $item['banner']['link']); $ec_banner_promo = end($arr);
        array_push($ec_banner, array( 'id' => $ec_banner_promo, 'name' => $ec_banner_promo,'position' => 'showroom-' . $item['showroom_id'] . '-' . $item['banner']['position']));

    }

    if( ! empty($item['product'])){
        foreach ($item['product'] as $key => $product):
            if($product['type']=='product'){
                array_push($ec_products,
                array(  'id' => $product['pkey'],
                        'name' => $product['title'],
                        'list' => 'showroom-' . $item['showroom_id'],
                        'position' => $product['position']));
            }if($product['type']=='banner'){
                $arr = explode("#", $product['link']); $ec_banner_promo = end($arr);
                array_push($ec_banner, array( 'id' => $ec_banner_promo, 'name' => $ec_banner_promo,'position' => 'showroom-' . $item['showroom_id'] . '-' . $product['position']));
            }

        endforeach;
    }


    ?>
    if(typeof ec_products === 'undefined'){
        var ec_products = [];
    }
    ec_products['showroom-{{{ $item['showroom_id'] }}}'] = <?php echo jsonUnescapedUnicode(json_encode($ec_products)); ?>;

    dataLayer.push({
      'event': 'productImpressions',
      'ecommerce': {
        'currencyCode': 'PHP',
        'impressions': <?php echo jsonUnescapedUnicode(json_encode($ec_products)); ?>
      }
    });

    var ec_banner = <?php echo jsonUnescapedUnicode(json_encode($ec_banner)); ?>;
    dataLayer.push({
      'event': 'promoView',
      'ecommerce': {
        'currencyCode': 'PHP',
        'promoView': {
          "promotions": ec_banner
        }
      }
    });
</script>
<!-- //typeidea script -->

@endforeach

{{--@if ($display_next_page)--}}
    {{--<div class="next-showroom-container">--}}
        {{--<a href="{{{ $next_page }}}" id="next-showroom-btn"--}}
           {{--data-limit="{{{ $limit }}}"--}}
           {{--data-total-page="{{{ $total_page }}}"--}}
           {{--data-page="{{{ $page }}}"></a>--}}
    {{--</div>--}}
{{--@endif--}}
