<?php

/*
|--------------------------------------------------------------------------
| HTML Label
|--------------------------------------------------------------------------
|
|	Render bootstrap label
|
*/
HTML::macro('product', function($product)
{
	return View::make('macros.html-product', array('product' => $product))->render();
});

HTML::macro('productSolr', function($product)
{
	return View::make('macros.html-productSolr', array('product' => $product))->render();
});