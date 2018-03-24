<?php

return array(

    // Navigator bar menu.
    'navbar' => array(

        'th' => array(
            array(
                'html'           => 'หน้าแรก',
                'title'          => 'หน้าแรก',
                'collection_key' => '',
                'href'           => URL::toLang('/'),
                'active'         => 'home'
            ),
            array(
                'html'           => 'สินค้าผ่อนชำระ',
                'title'          => 'สินค้าผ่อนชำระ',
                'collection_key' => '',
                'href'           => URL::toLang('/search?page=1&collection=0&q=ผ่อน&orderBy=discount&order=asc'),
                'active'         => 'everyday-wow'
            ),

            array(
                'html'           => 'สินค้าลดราคา',
                'title'          => 'สินค้าลดราคา',
                'collection_key' => '',
                'href'           => URL::toLang('/discount-products'),
                'active'         => 'discount-products'
            ),
            // array(
            // 	'html'           => 'ทรูช๊อป',
            // 	'title'          => 'ทรูช๊อป',
            // 	'collection_key' => '',
            // 	'href'           => URL::toLang('http://store.truecorp.co.th/'),
            // 	'active'         => ''
            // ),
            // array(
            // 	'html'           => 'พลาซ่า',
            // 	'title'          => 'พลาซ่า',
            // 	'collection_key' => '',
            // 	'href'           => URL::toLang('http://www.weloveshopping.com/'),
            // 	'active'         => ''
            // ),
            // array(
            // 	'html'           => 'สิทธิพิเศษ',
            // 	'title'          => 'สิทธิพิเศษ',
            // 	'collection_key' => '',
            // 	'href'           => URL::toLang('/trueyou'),
            // 	'active'         => 'trueyou'
            // ),
            array(
                'html'           => 'INSIGHT',
                'title'          => 'INSIGHT',
                'collection_key' => '',
                'href'           => URL::toLang('/news'),
                'active'         => 'insight'
            ),
        ),
        'en' => array(
            array(
                'html'           => 'Home',
                'title'          => 'Home',
                'collection_key' => '',
                'href'           => URL::toLang('/'),
                'active'         => 'home'
            ),
            array(
                'html'           => 'INSTALLMENT',
                'title'          => 'INSTALLMENT',
                'collection_key' => '',
                'href'           =>  URL::toLang('/search?page=1&collection=0&q=ผ่อน&orderBy=discount&order=asc'),
                'active'         => 'everyday-wow'
            ),

            array(
                'html'           => 'ON SALE',
                'title'          => 'ON SALE',
                'collection_key' => '',
                'href'           => URL::toLang('/discount-products'),
                'active'         => 'discount-products'
            ),
            // array(
            // 	'html'           => 'True Shop',
            // 	'title'          => 'True Shop',
            // 	'collection_key' => '',
            // 	'href'           => URL::toLang('http://store.truecorp.co.th/'),
            // 	'active'         => ''
            // ),
            // array(
            // 	'html'           => 'Plaza',
            // 	'title'          => 'Plaza',
            // 	'collection_key' => '',
            // 	'href'           => URL::toLang('http://www.weloveshopping.com/'),
            // 	'active'         => ''
            // ),
            // array(
            // 	'html'           => 'PRIVILEGES',
            // 	'title'          => 'PRIVILEGES',
            // 	'collection_key' => '',
            // 	'href'           => URL::toLang('/trueyou'),
            // 	'active'         => 'trueyou'
            // ),
            array(
                'html'           => 'INSIGHT',
                'title'          => 'INSIGHT',
                'collection_key' => '',
                'href'           => URL::toLang('/news'),
                'active'         => 'insight'
            ),
        )

    ),

    'payments' => array(
        'th' => array(
            'title' => 'ช่องทางการชำระเงิน',
            'links' => array(
                array(
                    'html' => 'ผ่อนชำระ<br/>(Installment)',
                    'href' => "",
                    'icn'  => 'ch-installment',
                    'image' => 'channel_07.png'
                ),
                array(
                    'html' => 'บัตรเครดิต<br/>(Credit Card)',
                    'href' => URL::toLang('/payment-manual'),
                    'icn'  => 'ch-creditcard',
                    'image' => 'channel_01.png'
                ),
                array(
                    'html' => 'iBanking<br/>(Internet Banking)',
                    'href' => URL::toLang('/payment-manual#ibanking'),
                    'icn'  => 'ch-ibanking',
                    'image' => 'channel_05.png'
                ),
                array(
                    'html' => 'เคาท์เตอร์ธนาคาร<br/>(Payment Counter)',
                    'href' => URL::toLang('/payment-manual#payment-counter'),
                    'icn'  => 'ch-paymentcounter',
                    'image' => 'channel_06.png'
                ),
                array(
                    'html' => 'เคาท์เตอร์เซอร์วิส<br/>(Counter Service)',
                    'href' => URL::toLang('/payment-manual#counter-service'),
                    'icn'  => 'ch-counterservice',
                    'image' => 'channel_02.png'
                ),
                array(
                    'html' => 'ตู้ ATM<br/>(Bank ATM)',
                    'href' => URL::toLang('/payment-manual#atm'),
                    'icn'  => 'ch-atm',
                    'image' => 'channel_03.png'
                ),
                array(
                    'html'  => 'เก็บเงินปลายทาง<br>(Cash on Delivery)',
                    'href'  => '',
                    'icn'   => '',
                    'image' => "channel_04.png"
                )
            )
        ),
        'en' => array(
            'title' => 'Available Payment Channels',
            'links' => array(
//                array(
//                    'html' => 'Installment',
//                    'href' => "",
//                    'icn'  => 'ch-installment',
//                    'image' => 'channel_07.png'
//                ),
//                array(
//                    'html' => 'Credit Card',
//                    'href' => URL::toLang('/payment-manual'),
//                    'icn'  => 'ch-creditcard',
//                    'image'       => "channel_01.png"
//                ),
                array(
                    'html' => 'Online Banking',
//                    'href' => URL::toLang('/payment-manual#ibanking'),
                    'href' => '',
                    'icn'  => 'ch-ibanking',
                    'image'       => "channel_05.png"
                ),
                array(
                    'html' => 'Other Payment Channels',
//                    'href' => URL::toLang('/payment-manual#counter-service'),
                    'href' => '',
                    'icn'  => 'ch-counterservice',
                    'image'       => "channel_02.png"
                ),
                array(
                    'html' => 'Over the Counter',
//                    'href' => URL::toLang('/payment-manual#payment-counter'),
                    'href' => '',
                    'icn'  => 'ch-paymentcounter',
                    'image'       => "channel_06.png"
                ),
                array(
                    'html' => 'Bank Payments',
//                    'href' => URL::toLang('/payment-manual#atm'),
                    'href' => '',
                    'icn'  => 'ch-atm',
                    'image'       => "channel_03.png"
                ),
                array(
                    'html'        => 'Cash on Delivery',
                    'href'        => '',
                    'icn'         => '',
                    'image'       => "channel_04.png"
                )
            )
        )
    ),

    // Footer Link.
    'footer_link' => array(

        'type_products' => array(
            'th' => array(
                'name' => 'ประเภทสินค้า',
                'links' => array(
                    // array(
                    // 	'html'           => 'มือถือ',
                    // 	'title'          => 'มือถือ',
                    // 	'collection_key' => '',
                    // 	'href'           => URL::toLang('#')
                    // ),
                    array(
                        'html'           => 'แฟชั่นผู้ชาย',
                        'title'          => 'แฟชั่นผู้ชาย',
                        'collection_key' => '',
                        'href'           => URL::toLang('category/3441387446408')
                    ),
                    array(
                        'html'           => 'แฟชั่นผู้หญิง',
                        'title'          => 'แฟชั่นผู้หญิง',
                        'collection_key' => '',
                        'href'           => URL::toLang('category/3621387446853')
                    ),
                    array(
                        'html'           => 'นาฬิกา',
                        'title'          => 'นาฬิกา',
                        'collection_key' => '',
                        'href'           => URL::toLang('category/3781387446790')
                    ),
                    array(
                        'html'           => 'กระเป๋า',
                        'title'          => 'กระเป๋า',
                        'collection_key' => '',
                        'href'           => URL::toLang('category/3791387446952')
                    ),
                    array(
                        'html'           => 'รองเท้า',
                        'title'          => 'รองเท้า',
                        'collection_key' => '',
                        'href'           => URL::toLang('category/3601387446969')
                    ),
                    array(
                        'html'           => 'แท็บเล็ต',
                        'title'          => 'แท็บเล็ต',
                        'collection_key' => '',
                        'href'           => URL::toLang('category/3401387446851')
                    ),
                    array(
                        'html'           => 'สมาร์ทโฟน',
                        'title'          => 'สมาร์ทโฟน',
                        'collection_key' => '',
                        'href'           => URL::toLang('category/3511387446486')
                    ),
                    // array(
                    // 	'html'           => 'เครื่องสำอาง',
                    // 	'title'          => 'เครื่องสำอาง',
                    // 	'collection_key' => '',
                    // 	'href'           => URL::toLang('category/3181387446244')
                    // ),
                    // array(
                    // 	'html'           => 'เครื่องประดับ',
                    // 	'title'          => 'เครื่องประดับ',
                    // 	'collection_key' => '',
                    // 	'href'           => URL::toLang('category/3631387446681')
                    // ),
                    // array(
                    // 	'html'           => 'หูฟัง',
                    // 	'title'          => 'หูฟัง',
                    // 	'collection_key' => '',
                    // 	'href'           => URL::toLang('')
                    // )
                )
            ),
            'en' => array(
                'name' => 'Product Category',
                'links' => array(
                    // array(
                    // 	'html'           => 'Mobile',
                    // 	'title'          => 'mobile',
                    // 	'collection_key' => '',
                    // 	'href'           => URL::toLang('#')
                    // ),
                    array(
                        'html'           => 'Mens',
                        'title'          => 'Mens',
                        'collection_key' => '',
                        'href'           => URL::toLang('category/3441387446408')
                    ),
                    array(
                        'html'           => 'Womens',
                        'title'          => 'Womens',
                        'collection_key' => '',
                        'href'           => URL::toLang('category/3621387446853')
                    ),
                    array(
                        'html'           => 'Watches',
                        'title'          => 'Watches',
                        'collection_key' => '',
                        'href'           => URL::toLang('category/3781387446790')
                    ),
                    array(
                        'html'           => 'Bags',
                        'title'          => 'bags',
                        'collection_key' => '',
                        'href'           => URL::toLang('category/3791387446952')
                    ),
                    array(
                        'html'           => 'Shoes',
                        'title'          => 'shoes',
                        'collection_key' => '',
                        'href'           => URL::toLang('category/3601387446969')
                    ),
                    array(
                        'html'           => 'Tablet',
                        'title'          => 'tablet',
                        'collection_key' => '',
                        'href'           => URL::toLang('category/3401387446851')
                    ),
                    array(
                        'html'           => 'Smart phone',
                        'title'          => 'Smart phone',
                        'collection_key' => '',
                        'href'           => URL::toLang('category/3511387446486')
                    ),
                    // array(
                    // 	'html'           => 'Cosmetics',
                    // 	'title'          => 'cosmetics',
                    // 	'collection_key' => '',
                    // 	'href'           => URL::toLang('category/3181387446244')
                    // ),
                    // array(
                    // 	'html'           => 'Ornament',
                    // 	'title'          => 'ornament',
                    // 	'collection_key' => '',
                    // 	'href'           => URL::toLang('category/3631387446681')
                    // ),
                    // array(
                    // 	'html'           => 'Earphone',
                    // 	'title'          => 'earphone',
                    // 	'collection_key' => '',
                    // 	'href'           => URL::toLang('')
                    // )
                )
            )
        ),

        'promotions'    => array(
            'th' => array(
                'name' => 'ข้อเสนอพิเศษและโปรโมชั่น',
                'links' => array(
                    array(
                        'html'           => 'Everyday WOW',
                        'title'          => 'Everyday WOW',
                        'collection_key' => '',
                        'href'           => URL::toLang('/everyday-wow')
                    ),
                    array(
                        'html'           => 'สินค้าลดราคา',
                        'title'          => 'สินค้าลดราคา',
                        'collection_key' => '',
                        'href'           => URL::toLang('/discount-products')
                    )
                )
            ),
            'en' => array(
                'name' => 'Special Offers & Promotions',
                'links' => array(
                    array(
                        'html'           => 'Everyday WOW',
                        'title'          => 'Everyday WOW',
                        'collection_key' => '',
                        'href'           => URL::toLang('/everyday-wow')
                    ),
                    array(
                        'html'           => '% Discount',
                        'title'          => '% Discount',
                        'collection_key' => '',
                        'href'           => URL::toLang('/discount-products')
                    )
                )
            )


        ),

        'services' => array(
            'th' => array(
                'name' => 'บริการของเรา',
                'links' => array(
                    array(
                        'html'           => 'ข้อมูลส่วนตัว',
                        'title'          => 'ข้อมูลส่วนตัว',
                        'collection_key' => '',
                        'href'           => URL::toLang('member/profile')
                    ),
                    array(
                        'html'           => 'สินค้าในตะกร้า',
                        'title'          => 'สินค้าในตะกร้า',
                        'collection_key' => '',
                        'href'           => URL::toLang('checkout/step1')
                    ),
                    array(
                        'html'           => 'ข้อมูลสินค้าในตะกร้า',
                        'title'          => 'ข้อมูลสินค้าในตะกร้า',
                        'collection_key' => '',
                        'href'           => URL::toLang('checkout/step1')
                    ),
                    array(
                        'html'           => 'ตรวจสอบสถานะการชำระเงิน และการจัดส่ง',
                        'title'          => 'ตรวจสอบสถานะการชำระเงิน และการจัดส่ง',
                        'collection_key' => '',
                        'href'           => URL::toLang('order_tracking')
                    ),
                    array(
                        'html'           => 'นโยบายการรับประกันสินค้า',
                        'title'          => 'นโยบายการรับประกันสินค้า',
                        'collection_key' => '',
                        'href'           => URL::toLang('policy/returnpolicy')
                    ),
                    array(
                        'html'           => 'นโยบายการจัดส่งสินค้า',
                        'title'          => 'นโยบายการจัดส่งสินค้า',
                        'collection_key' => '',
                        'href'           => URL::toLang('policy/freedelivery')
                    ),
                    array(
                        'html'           => 'นโยบายการคืนเงิน',
                        'title'          => 'นโยบายการคืนเงิน',
                        'collection_key' => '',
                        'href'           => URL::toLang('policy/moneyback')
                    ),
                    array(
                        'html'           => 'คู่มือการชำระเงิน',
                        'title'          => 'คู่มือการชำระเงิน',
                        'collection_key' => '',
                        'href'           => URL::toLang('payment-manual')
                    ),
                    array(
                        'html'           => 'คู่มือการใช้คูปองเงินสด',
                        'title'          => 'คู่มือการใช้คูปองเงินสด',
                        'collection_key' => '',
                        'href'           => URL::toLang('checkout/manual#fill')
                    ),
                    array(
                        'html'           => 'วิธีการใช้รหัสส่วนลด',
                        'title'          => 'วิธีการใช้รหัสส่วนลด',
                        'collection_key' => '',
                        'href'           => "//support.itruemart.ph/116901-%E0%B8%82%E0%B8%99%E0%B8%95%E0%B8%AD%E0%B8%99%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%81%E0%B8%A3%E0%B8%AD%E0%B8%81%E0%B8%84%E0%B8%9B%E0%B8%AD%E0%B8%87%E0%B9%83%E0%B8%AA%E0%B8%A5%E0%B8%94%E0%B9%83%E0%B8%99%E0%B8%AB%E0%B8%99%E0%B8%B2%E0%B9%80%E0%B8%A7%E0%B8%9A?r=1"
                    ),
                )
            ),
            'en' => array(
                'name' => 'Our Service',
                'links' => array(
                    array(
                        'html'           => 'Profile',
                        'title'          => 'Profile',
                        'collection_key' => '',
                        'href'           => URL::toLang('member/profile')
                    ),
//                    array(
//                        'html'           => 'Product in cart',
//                        'title'          => 'Product in cart',
//                        'collection_key' => '',
//                        'href'           => URL::toLang('checkout/step1')
//                    ),
                    array(
                        'html'           => 'My cart',
                        'title'          => 'My cart',
                        'collection_key' => '',
                        'href'           => URL::toLang('checkout/step1')
                    ),
                    array(
                        'html'           => 'Check my order',
                        'title'          => 'Check my order',
                        'collection_key' => '',
                        'href'           => URL::toLang('order_tracking')
                    ),
                    array(
                        'html'           => 'Return Policy',
                        'title'          => 'Return Policy',
                        'collection_key' => '',
                        'href'           => URL::toLang('policy/returnpolicy')
                    ),
                    array(
                        'html'           => 'Delivery Policy',
                        'title'          => 'Delivery Policy',
                        'collection_key' => '',
                        'href'           => URL::toLang('policy/freedelivery')
                    ),
                    array(
                        'html'           => 'Refund Policy',
                        'title'          => 'Refund Policy',
                        'collection_key' => '',
                        'href'           => URL::toLang('policy/moneyback')
                    ),
//                    array(
//                        'html'           => 'Payment Options',
//                        'title'          => 'Payment Options',
//                        'collection_key' => '',
//                        'href'           => URL::toLang('payment-manual')
//                    ),
//                    array(
//                        'html'           => 'Payment Options',//อันเก่าคือ Manual vouchers
//                        'title'          => 'Payment Options',
//                        'collection_key' => '',
//                        'href'           => URL::toLang('checkout/manual#fill')
//                    ),
//                    array(
//                        'html'           => 'How to use Discount Code',
//                        'title'          => 'How to use Discount Code',
//                        'collection_key' => '',
//                        'href'           => "//support.itruemart.ph/116901-%E0%B8%82%E0%B8%99%E0%B8%95%E0%B8%AD%E0%B8%99%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%81%E0%B8%A3%E0%B8%AD%E0%B8%81%E0%B8%84%E0%B8%9B%E0%B8%AD%E0%B8%87%E0%B9%83%E0%B8%AA%E0%B8%A5%E0%B8%94%E0%B9%83%E0%B8%99%E0%B8%AB%E0%B8%99%E0%B8%B2%E0%B9%80%E0%B8%A7%E0%B8%9A?r=1"
//                    ),
                )
            )
        )
    )

);
