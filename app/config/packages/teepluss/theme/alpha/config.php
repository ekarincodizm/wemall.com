<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Asset url path
	|--------------------------------------------------------------------------
	|
	| The path to asset, this config can be cdn host.
	| eg. http://cdn.domain.com
	|
	*/

	'assetUrl' => str_replace(array('http://', 'https://'), '//', URL::to('/')), //'https://itruemart.com',

);