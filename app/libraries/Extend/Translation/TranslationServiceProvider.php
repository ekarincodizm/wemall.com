<?php namespace Extend\Translation;

class TranslationServiceProvider extends \Illuminate\Translation\TranslationServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	// public function register()
	// {
	// 	$this->registerLoader();

	// 	$this->app->bindShared('translator', function($app)
	// 	{
	// 		$loader = $app['translation.loader'];

	// 		// When registering the translator component, we'll need to set the default
	// 		// locale as well as the fallback locale. So, we'll grab the application
	// 		// configuration so we can easily get both of these values from there.
	// 		$locale = $app['config']['app.locale'];

	// 		$trans = new Translator($loader, $locale);

	// 		return $trans;
	// 	});
	// }

	public function register()
	{
		$this->registerLoader();

		$this->app->bindShared('translator', function($app)
		{
			$loader = $app['translation.loader'];

			// When registering the translator component, we'll need to set the default
			// locale as well as the fallback locale. So, we'll grab the application
			// configuration so we can easily get both of these values from there.
			$locale = $app['config']['app.locale'];

			$trans = new Translator($loader, $locale);

			$trans->setFallback($app['config']['app.fallback_locale']);

			return $trans;
		});
	}

	/**
	 * Register the translation line loader.
	 *
	 * @return void
	 */
	// protected function registerLoader()
	// {
	// 	$this->app->bindShared('translation.loader', function($app)
	// 	{
	// 		return new FileLoader($app['files'], $app['path'].'/lang');
	// 	});
	// }

	/**
	 * Register the translation line loader.
	 *
	 * @return void
	 */
	protected function registerLoader()
	{
		$this->app->bindShared('translation.loader', function($app)
		{
			return new FileLoader($app['files'], $app['path'].'/lang');
		});
	}

}