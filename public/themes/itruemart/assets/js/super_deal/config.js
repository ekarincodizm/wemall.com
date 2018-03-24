requirejs.config({
	baseUrl: 'themes/itruemart/assets/js/super_deal/',
	paths: {
		app: '../app',
                    controller: '../controller',
		jquery: 'lib/jquery-1.11.0.min',
		countdown: 'lib/jquery.countdown.min',
                    lazyload: 'lib/jquery.lazyload.min'
	},
	shim: {
			'jquery': {exports: '$'},
			'countdown': {deps: ['jquery']},
            'lazyload': {deps: ['jquery']}
      }
});