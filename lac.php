<?php
$attributes = array(
    'slug' => '',
    'page' => 1,
    'limit' => 2,
);

// define default attribute
$_page = array_get($attributes, 'page', 1);
$_limit = array_get($attributes, 'limit', 2);
$_no_cache = array_get($attributes, 'noCache', false);
$_next_page = URL::toLang("ajax/showroom") . '?';

if ($_no_cache) {
    $_next_page .= '&no-cache=1';
}

$showroom = App::make('ShowroomRepositoryInterface');
$response = $showroom->getData($_page, $_limit);

array_set($attributes, 'display_next_page', $_page==1);
array_set($attributes, 'next_page', $_next_page);
array_set($attributes, 'showroom', array_get($response, 'data.showroom', array()));
array_set($attributes, 'total_page', array_get($response, 'data.total_page', 1));
array_set($attributes, 'no_cache', $_no_cache);
array_set($attributes, 'page', $_page);
array_get($attributes, 'limit', $_limit);

s($attributes);