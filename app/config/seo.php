<?php

return array(

    /**
     * Seo template
     */

    'brand' => array(
        'en' => array(
            'title' => ':title - buy :title best price - itruemart.ph',
            'description' => ':description',
            'keywords' => ':keywords',),
        'th' => array('title' => ':title - ซื้อ :title ราคาดีที่สุด - itruemart.ph',
            'description' => ':description',
            'keywords' => ':keywords',)
    ),
    'collection' => array(
        'en' => array(
            'title' => ':title - buy :title best price - itruemart.ph',
            'description' => ':description',
            'keywords' => ':keywords'),
        'th' => array(
            'title' => ':title - ซื้อ :title ราคาดีที่สุด - itruemart.ph',
            'description' => ':description',
            'keywords' => ':keywords')
    ),

    'product' => array(
        'title' => function($data) {
            if (empty($data['title']))
            {
                return null;
            }
            return $data['title']." | iTruemart";
        },
        'description' => ':description',
        'keywords' => ':keywords',
    ),

    /**
     * Normal String for page
     * use with setSeoMeta() that defined in helper
     */

    'trueyou' => array(
        'title' => __('TrueYou | iTrueMart'),
        'description' => 'สิทธิประโยชน์ลูกค้าทรู เมื่อซื้อสินค้าที่ iTrueMart: สินค้าอัพเดททุกวัน ส่งฟรี จ่ายเงินเมื่อได้รับสินค้า ช้อปปิ้งออนไลน์ที่ iTrueMart',
        'keywords' => '',
    ),

    'levelA' => array(
        'title' => 'Online shopping, Shopping online, mobile, tablet, smart phone gadget headphones appliances. Fitness Equipment Special Promotions iphone samsung.',
        'description' => 'Online shopping Brand leading e-commerce shopping online can be sure of fast, easy, simple, free delivery, secure payment system. 100% secure',
        'keywords' => '',
    ),

    'discount' => array(
        'title' => __('Items On Sale| Buy items on sale, special price, discount, or markdown.'),
        'description' => 'Experience Great Value, Everyday! Browse through all the discounted products and amazing offers to get the best deals in online shopping.',
        'keywords' => 'on sale, special price, discount, markdown, lowest price, cheap, deal, great deal, best offer, electronics, ecommerce, shop, buy, online',
    ),

    'contact_us' => array(
        'title' => 'Contact us',
        'description' => 'If you have any comments, questions or any feedback. Please contact us at: Call Center is open 24 hours every day: Shopping Online at iTrueMart',
        'keywords' => '',
    ),

    'flashsale' => array(
        'title' => __('Flash Sale - Promotion Product | iTrueMart'),
        'description' => 'Promotion Product - Daily updated - cash on delivery. Shopping Online at iTrueMart',
        'keywords' => '',
    ),

    'itruemart-tv' => array(
        'title' => 'register iTrueMart.ph',
        'description' => '',
        'keywords' => '',
    ),

    'register' => array(
        'title' => 'register iTrueMart.ph',
        'description' => '',
        'keywords' => '',
    ),

    'policy' => array(
        'returnpolicy' => array(
            'title' => 'Return Policy',
            'description' => '',
            'keywords' => '',
        ),

        'freedelivery' => array(
            'title' => 'Delivery Policy',
            'description' => '',
            'keywords' => '',
        ),
        'moneyback' => array(
            'title' => 'Refund Policy',
            'description' => '',
            'keywords' => '',
        ),

    ),

    'search' => array(
        'title' => '',
        'description' => '',
        'keywords' => '',
    ),

    /**
     * SEO Robots.
     */
    'robots' => function()
    {
        return "User-agent: *\nDisallow: /";
    }

);
//Theme::strign('', s)->render();