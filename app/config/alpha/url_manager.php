<?php
$ext = ".html";
$separate = "-"; 

return array(
	'news_level_b_url' => "news/category/{CATEGORY_SLUG}" . $separate . "{CATEGORY_ID}",
	'news_level_d_url' => "news/detail/{NEWS_SLUG}" . $separate . "{NEWS_ID}" . $ext,
	'level_d_url' => "products/{PRODUCT_SLUG}".$separate."{PRODUCT_PKEY}" . $ext,
	'url_news' => 'http://api.dev.itruemart.ph/rest/news/listing'
);