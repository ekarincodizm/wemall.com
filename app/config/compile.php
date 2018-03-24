<?php

$basePath = App::make('path.base');

return array(

	/*
	|--------------------------------------------------------------------------
	| Additional Compiled Classes
	|--------------------------------------------------------------------------
	|
	| Here you may specify additional classes to include in the compiled file
	| generated by the `artisan optimize` command. These should be classes
	| that are included on basically every request into the application.
	|
	*/

    //$basePath.'/vendor/teepluss/theme/src/Teepluss/Theme/ThemeServiceProvider.php',
    //$basePath.'/vendor/teepluss/theme/src/Teepluss/Theme/Facades/Theme.php',
    $basePath.'/vendor/teepluss/theme/src/Teepluss/Theme/Theme.php',
    $basePath.'/vendor/teepluss/theme/src/Teepluss/Theme/Asset.php',
    $basePath.'/vendor/teepluss/theme/src/Teepluss/Theme/Breadcrumb.php',

    // kint
    // $basePath.'/vendor/raveren/kint/Kint.class.php',
    // $basePath.'/vendor/raveren/kint/config.default.php',
    // $basePath.'/vendor/raveren/kint/parsers/parser.class.php',
    // $basePath.'/vendor/raveren/kint/decorators/rich.php',
    // $basePath.'/vendor/raveren/kint/decorators/concise.php'

);