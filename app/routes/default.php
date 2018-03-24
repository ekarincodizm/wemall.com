<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('shop/{prefix?}', array(
    'as'   => 'merchant.landingpage',
    'uses' => 'MerchantController@landingPage'
));

Route::get('users/check-customer-ref-id', array(
//    'as'   => 'test.ccr',
    'uses' => 'UsersController@getCheckCustomerRefId'
));

Route::controller('kuaetest', 'KuaeTestController');

Route::any('checkout/tmn-complete', array(
    'as'   => 'checkout.tmn-complete',
    'uses' => 'CheckoutController@anyTmnComplete'
));
Route::any('checkout/complete', array(
    'as'   => 'checkout.complete',
    'uses' => 'CheckoutController@anyComplete'
));


Route::get('whoop', function()
{
    return View::make('whoof.index');
});



Route::group(array('prefix' => LaravelLocalization::setLanguage(), 'before' => 'AwsCloud|AuthLoginRedirect|LaravelLocalizationRedirectFilter|detectDeviceFilter|redirect_ph'), function()
{
    Route::get('citibank', function(){
        return Redirect::to("http://support.itruemart.com/288147-CITIBANK-%E0%B8%88%E0%B8%B2%E0%B8%A2%E0%B9%80%E0%B8%95%E0%B8%A1--%E0%B8%8A%E0%B8%AD%E0%B8%9B%E0%B8%84%E0%B8%A3%E0%B8%9A%E0%B8%97%E0%B8%81-5000-%E0%B8%9A%E0%B8%B2%E0%B8%97-%E0%B8%A3%E0%B8%9A%E0%B9%80%E0%B8%87%E0%B8%99%E0%B8%84%E0%B8%99%E0%B8%AA%E0%B8%87%E0%B8%AA%E0%B8%94-7?r=1");
    });

    // Shop By Brand (Level B)
    Route::get('shopbybrand', array(
        'as'   => 'shopbybrand.index',
        'uses' => 'BrandsController@getIndex'
    ));

    Route::get('shopbybrand/category/{collectionPkey?}', array(
        'as'   => 'shopbybrand.collection',
        'uses' => 'BrandsController@getCollectionBrands'
    ));

    // List Products By Category (Level C)
    Route::get('category/{collectionPkey?}', array(
        'as'   => 'categories.products',
        'uses' => 'ProductsController@getCategoryProducts'
    ));

    Route::get('campaign/product/{slugpkey}.html', array(
        'as'   => 'product.line',
        'uses' => 'ProductLineController@getIndex'
    ));

	Route::post('campaign/product/content', array(
		'as' => 'product.line.content',
		'uses' => 'ProductLineController@postContent'
	));

    Route::any('campaign/line', array(
        'as'   => 'campaign.line',
        'uses' => 'CampaignController@getLineCampaign'
    ));

    Route::get('campaign/content', array(
        'as'   => 'campaign.content',
        'uses' => 'CampaignController@getContent'
    ));

    Route::get('everyday-wow', array(
        'as'   => 'everyday-wow',
        'uses' => 'EverydayWowController@getIndex'
    ));
    Route::get('everyday-wow-{category_slug}', array(
        'as'   => 'everyday-wow',
        'uses' => 'EverydayWowController@getIndex'
    ));

    Route::get('email/content', array(
        'as'   => 'email.content',
        'uses' => 'EdmController@getEdm'
    ));

    Route::get('hello-world',function(){
        echo 'hello';
    });

    Route::get('dragon', array(
        'uses' => 'GettTestController@getTest'
    ));

    // List Products By Brand (Level C)
    Route::get('brand/{brandPkey?}', array(
        'as'   => 'brands.products',
        'uses' => 'ProductsController@getBrandProducts'
    ));

    // List Products that have Special Discount (Flash Sale)
    Route::get('flash-sale/brand/{brandPkey}', array(
        'as'   => 'flashsale.productsByBrand',
        'uses' => 'ProductsController@getFlashsaleProducts'
    ));

    Route::get('flash-sale/category/{collectionPkey}', array(
        'as'   => 'flashsale.productsByCategory',
        'uses' => 'ProductsController@getFlashsaleProducts'
    ));

    Route::get('flash-sale', array(
        'as'   => 'flashsale.products',
        'uses' => 'ProductsController@getFlashsaleProducts'
    ));

    // List Products in iTruemart TV
    Route::get('itruemart-tv/brand/{brandPkey}', array(
        'as'   => 'itruemart-tv.productsByBrand',
        'uses' => 'ProductsController@getItruemartTvProducts'
    ));

    Route::get('itruemart-tv/category/{collectionPkey}', array(
        'as'   => 'itruemart-tv.productsByCategory',
        'uses' => 'ProductsController@getItruemartTvProducts'
    ));

    Route::get('itruemart-tv', array(
        'as'   => 'itruemart-tv.products',
        'uses' => 'ProductsController@getItruemartTvProducts'
    ));

    // Products Listing by Percent Discount
    Route::get('discount-products/brand/{brandPkey}', array(
        'as'   => 'discount.productsByBrand',
        'uses' => 'ProductsController@getDiscountProducts'
    ));

    Route::get('discount-products/category/{collectionPkey}', array(
        'as'   => 'discount.productsByCategory',
        'uses' => 'ProductsController@getDiscountProducts'
    ));

    Route::get('discount-products', array(
        'as'   => 'discount.products',
        'uses' => 'ProductsController@getDiscountProducts'
    ));

    // List Products that have TrueYou Discount
    Route::get('trueyou/brand/{brandPkey}', array(
        'as'   => 'trueyou.productsByBrand',
        'uses' => 'ProductsController@getTrueyouProducts'
    ));

    Route::get('trueyou/category/{collectionPkey}', array(
        'as'   => 'trueyou.productsByCategory',
        'uses' => 'ProductsController@getTrueyouProducts'
    ));

    Route::get('trueyou', array(
        'as'   => 'trueyou.products',
        'uses' => 'ProductsController@getTrueyouProducts'
    ));

    // member profile privilege
    Route::get('/member/profile', array(
        'before' => 'redirect_http',
        'as'   => 'member.profile',
        'uses' => 'MembersController@getProfile'
    ));

    Route::post('/member/profile', array(
        'as'   => 'member.profiler.post',
        'uses' => 'MembersController@postProfile'
    ));

    Route::get('/member/orders', array(
            'before' => 'redirect_http',
        'as'   => 'member.profile',
        'uses' => 'MembersController@getOrder'
    ));

    Route::get('/member/manage-credit-card', array(
        'as'   => 'member.manage-credit-card',
        'uses' => 'MembersController@getManageCCW'
    ));

    Route::post('/member/check-id-card', array(
        'as'   => 'member.check',
        'uses' => 'MembersController@postCheckIdCard'
    ));

    Route::get('/member/confirm-email', array(
        'as'   => 'member.confirmEmail',
        'uses' => 'MembersController@getConfirmEmail',
    ));

    Route::get('/member/resent-email', array(
        'as'   => 'member.resendEmailActivate',
        'uses' => 'MembersController@getResentEmail',
    ));

    Route::get('/payment-manual', array(
        'as'   => 'payment.manual',
        'uses' => 'PaymentManualController@getIndex'
    ));

    // News First Page (Level B)
    Route::get('news', array(
        'as'   => 'news',
        'uses' => 'NewsController@getIndex'
    ));

    Route::get('news/category/{categorySlug}-{categoryId}', array(
        'as'   => 'news.cateList',
        'uses' => 'NewsController@getCategory'
    ));

    Route::get('news/detail/{newsSlug}.html', array(
        'as'   => 'news.detail',
        'uses' => 'NewsController@getDetail'
    ));

    // View Product (Level D)
    Route::get('products/{productPkey}', array(
        'as'   => 'products.detail',
        'uses' => 'ProductsController@getDetail'
    ));

    Route::get('/products/check/{inventoryId}', array(
        'as'   => 'products.remaining',
        'uses' => 'ProductsController@remaining'
    ))
    ->where('inventoryId', '([0-9]+,?)+');

    Route::get('products', array(
        'as'   => 'products',
        'uses' => 'ProductsController@getIndex'
    ));

    Route::get('search', array(
        'as'   => 'search',
        'uses' => 'SearchController@getIndex'
    ));
    //search for solr
    Route::get('search2', array(
        'as'   => 'search2',
        'uses' => 'SolrSearchController@getIndex'
    ));

    Route::get('policy/{ptype?}', array(
        'as'   => 'policy.view',
        'uses' => 'PolicyController@getView'
    ));

    // Lab controller
    Route::controller('labs', 'LabsController');

    Route::get('auth/login', array(
        'as'   => 'auth.login',
        'before' => 'redirect_https',
        'uses' => 'AuthController@getLogin'
    ));

    Route::post('auth/login', array(
        'as'     => 'auth.login.post',
        'before' => 'csrf',
        'uses'   => 'AuthController@postLogin'
    ));

    Route::post('auth/ajax-sync', array(
        'as'   => 'auth.sync.post',
        'uses' => 'AuthController@postAjaxSync'
    ));

    Route::get('auth/logout', array(
        'as'   => 'auth.logout',
        'uses' => 'AuthController@getLogout'
    ));

    Route::get('users/register', array(
        'as'   => 'users.register',
        'before' => 'redirect_https',
        'uses' => 'UsersController@getRegister'
    ));

    Route::post('users/register', array(
        'as'     => 'users.register.post',
        'uses'   => 'UsersController@postRegister'
    ));

    Route::get('users/ajax-get-user', array(
        'as'   => 'users.getUser.ajax',
        'uses' => 'UsersController@getAjaxGetUser'
    ));

    Route::any('users/ajax-request-otp', array(
        'as'   => 'users.requestotp.ajax',
        'uses' => 'UsersController@postAjaxRequestOtp'
    ));

    Route::any('users/ajax-validate-otp', array(
        'as'   => 'users.validateotp.ajax',
        'uses' => 'UsersController@postAjaxValidateOtp'
    ));

    Route::any('users/ajax-check-email', array(
        'as'   => 'users.checkemail.ajax',
        'uses' => 'UsersController@postAjaxCheckEmail'
    ));

    Route::get('forgot_password', array(
        'as'   => 'forgot',
        'before' => 'redirect_https',
        'uses' => 'ForgotPasswordController@getIndex'
    ));

    Route::get('forgot_password/verify_link', array(
        'as'   => 'forgot.verify',
        'uses' => 'ForgotPasswordController@getVerifyLink'
    ));

    Route::post('forgot_password/checkmail', array(
        'as'   => 'forgot.checkmail',
        'uses' => 'ForgotPasswordController@postCheckmail'
    ));

    Route::get('forgot_password/reset-password', array(
        'as'   => 'forgot.reset-password',
        'uses' => 'ForgotPasswordController@getResetPassword'
    ));

    Route::post('forgot_password/reset-password', array(
        'as'   => 'forgot.reset-password',
        'uses' => 'ForgotPasswordController@postResetPassword'
    ));

    // Checkout by Arm
    Route::get('{checkoutany}', function($checkoutany)
    {
        return Redirect::to('checkout/step1');
    })
    ->where('checkoutany', '(checkout|checkout1|checkout/confirm|checkout/process)');


    Route::post('checkout/apply-coupon', array(
        'as'   => 'checkout.apply-coupon',
        'uses' => 'CheckoutController@postApplyCoupon'
    ));

    Route::get('checkout/apply-coupon', array(
        'as'   => 'checkout.apply-coupon',
        'uses' => 'CheckoutController@postApplyCoupon'
    ));

    Route::get('checkout/requery', array(
        'as'   => 'checkout.requery',
        'uses' => 'CheckoutController@getRequery'
    ));

    Route::get('checkout/manual', array(
        'as'   => 'checkout.manual',
        'uses' => 'CheckoutController@getCheckoutManual'
    ));

    Route::get('checkout/print', array(
        'as'   => 'print',
        'uses' => 'CheckoutController@getPrintInternetBill'
    ));

    Route::post('checkout/check-shipping', array(
        'as'   => 'checkout.check-shipping',
        'uses' => 'CheckoutController@checkShipping'
    ));

    Route::get('test', array(
        'as'   => 'test.d',
        'uses' => 'TestMemberController@getIndex'
    ));

    Route::get('checkout/step1', array(
        'before' => array('checkNoItem', "redirect_https"),
        'as'     => 'checkout.step1',
        'uses'   => 'NewCheckoutController@getStep1'
    ));

    Route::post('checkout/step1', array(
        'as'   => 'checkout-step1',
        'uses' => 'NewCheckoutController@postStep1'
    ));

    Route::get('checkout/step2', array(
        'before' => array('checkNoItem', 'checkstep2', 'redirect_http'),
        'as'     => 'checkout.step2',
        'uses'   => 'NewCheckoutController@getStep2'
    ));

    Route::post('checkout/step2', array(
        'as'   => 'checkout.post.step2',
        'uses' => 'NewCheckoutController@postStep2'
    ));

    Route::get('checkout/step3', array(
        'before' => array('checkNoItem', 'checkstep3', "redirect_https"),
        'as'     => 'checkout.step3',
        'uses'   => 'NewCheckoutController@getStep3'
    ));

    Route::post('checkout/step3', array(
        'before' => 'checkstep3',
        'as'     => 'checkout.post.step3',
        'uses'   => 'NewCheckoutController@postStep3'
    ));

    Route::any('checkout/thank-you', array(
        "before" => array("clearStage", "redirect_https"),
        'as'   => 'checkout.thankyou.newexperience',
        'uses' => 'NewCheckoutController@anyThankyou'
    ));

    Route::post('savemember',array(
        'as'   => 'thankyou.savemember',
        'uses' => 'NewCheckoutController@postSaveMember'
    ));

    Route::get('checkout/no-item', array(
        'before' => array('checkHaveItem'),
        'as'     => 'checkout.no-item',
        'uses'   => 'NewCheckoutController@getNoItem'
    ));

    Route::get('checkout/dragon-pay-complete', array(
        'uses' => 'NewCheckoutController@anyDragonPayComplete'
    ));

    /**
     * Contact Us
     */
    Route::get('contact_us', array(
        'as'   => 'contact_us',
        'uses' => 'ContactusController@getIndex'
    ));

	 Route::get('lucky-draw', array(
        'as'   => 'lucky-draw',
        'uses' => 'SpecialCampaignController@getIndex'
    ));
	Route::get('lucky-privilege', array(
        'as'   => 'lucky-privilege',
        'uses' => 'SpecialCampaignController@getPrivilege'
    ));

    Route::get('landing', function(){
        return View::make('landing_page/index_fatherday2014');
    });

	Route::get('/member/lucky-privilege', array(
        'as'   => 'member.profile',
        'uses' => 'SpecialCampaignController@getPrivilegeMember'
    ));

    
    Route::get('ang-pao', array(
        'as'   => 'ang-pao',
        'uses' => 'AngPaoController@getIndex'
    ));
    
    Route::get('callapi', array(
        'as'   => 'callapi',
        'uses' => 'AngPaoController@getCallapi'
    ));
    
    Route::get('luckyxmas', array(
        'as'   => 'luckyxmas',
        'uses' => 'AngPaoController@getAngpaologin'
    ));

    Route::get('chinese-new-year', array(
        'as'   => 'chinese-new-year',
        'uses' => 'AngPaoController@getEvent'
    ));

    Route::get('getdata', array(
        'as'   => 'getdata',
        'uses' => 'GetDataController@getUserdata'
    ));

    // Home page (Level-A)
    Route::get('/',array(
        'as'   => 'home',
        'uses' => 'HomeController@getIndex',
        'before' => 'LandingPage'
    ));
	
	Route::get('user-promotion', array(
        'as'   => 'user-promotion',
        'uses' => 'CheckPromotionController@getCheckUser'
	));
	
	Route::get('user-promotion-xx', array(
        'as'   => 'user-promotion-xx',
        'uses' => 'CheckPromotionxxController@getCheckUser'
	));

	Route::get('user-promotion', array(
        'as'   => 'user-promotion',
        'uses' => 'CheckPromotionController@getCheckUser'
    ));

    // TrueMove-H
    Route::group(array('prefix' => 'truemove-h'), function()
    {
        // Landing Page
        Route::get('/', array(
            'as'   => 'truemove-h',
            'uses' => 'TruemoveHController@getIndex'
        ));

        // Registration
        Route::get('registration', array(
            'as'   => 'truemove-h/registration',
            'uses' => 'TruemoveHController@getRegister'
        ));

        // Forecast
        Route::get('forecasts', array(
            'as'   => 'truemove-h/forecasts',
            'uses' => 'TruemoveHController@getForecasts'
        ));

        Route::controller('api', 'TruemoveHController');

    });

});

// rebuild stock
Route::get('product/rebuild-stock', array(
    'as'   => 'product.rebuild-stock',
    'uses' => 'ProductsController@anyRebuildStock'
));

// rebuild stock
Route::get('product/rebuild-stock-no-variant', array(
    'as'   => 'product.rebuild-stock',
    'uses' => 'ProductsController@anyRebuildStockNoVariant'
));

// Ajax request.
$ajaxPrefix = LaravelLocalization::setLanguage();
$ajaxPrefix = $ajaxPrefix . (!empty($ajaxPrefix)? '/' : '') . 'ajax';

Route::group(array('prefix' => $ajaxPrefix ), function()
{
    Route::get('showroom', array(
        'as'   => 'ajax.showroom',
        'uses' => 'HomeController@getShowroom'
    ));

    Route::get('cart', array(
        'as'   => 'ajax.cart',
        'uses' => 'CartController@getIndex'
    ));

    Route::post('cart/set-type', array(
        'as'   => 'ajax.cart.set-type',
        'uses' => 'CartController@postSetCartType'
    ));

    Route::get('cart/wow-inventories', array(
        'as'   => 'ajax.cart.wow-inventories',
        'uses' => 'CartController@getWowInventories'
    ));

    Route::get("member/tnt-tracking", array(
        "as" => "ajax.member.tnt-tracking",
        "uses" => "MembersController@getTNTTracking"
        ));

    Route::post('member/check-sso', array(
        'as'   => 'ajax.member.sso',
        'uses' => 'MembersController@ssoProfile'
    ));

    Route::get('member/tracking-data', array(
        'as'   => 'ajax.member.tracking-data',
        'uses' => 'MembersController@getTrackingData'
    ));

    Route::post('campaign/product/check-stock', array(
        'as'   => 'ajax.check-stock',
        'uses' => 'ProductLineController@postCheckStock'
    ));

    Route::post('campaign/product/check-stock-by-variant', array(
        'as'   => 'ajax.check-stock-by-variant',
        'uses' => 'ProductLineController@postCheckStockByVariant'
    ));

    Route::post('campaign/product/get-image', array(
        'as'   => 'ajax.get-image-by-color',
        'uses' => 'ProductLineController@postGetImage'
    ));

    Route::any('product/check-stock-by-variant', array(
        'as'   => 'ajax.product.check-stock-by-variant',
        'uses' => 'ProductsController@anyCheckStockByVariant'
    ));

    Route::any('product/check-stock', array(
        'as'   => 'ajax.product.check-stock',
        'uses' => 'ProductsController@anyCheckStock'
    ));

    Route::post('product/get-image', array(
        'as'   => 'ajax.product.get-image',
        'uses' => 'ProductsController@postGetImage'
    ));

    Route::post('campaign/line/check-login', array(
        'as'   => 'ajax.check-login',
        'uses' => 'ProductLineController@postCheckLogin'
    ));

    Route::post('cart/remove-item', array(
        'as'   => 'ajax.cart.remove-item',
        'uses' => 'CartController@postRemoveItem'
    ));

    Route::post("cart/remove-items", array(
        "as" => "ajax.cart.remove-mulltiple-items",
        "uses" => "CartController@postRemoveItems"
    ));

    Route::post('cart/add-item', array(
        'as'   => 'ajax.cart.add-item',
        'uses' => 'CartController@postAddItem'
    ));

    Route::post("v2/cart/add-item", array(
        "as" => "ajax.cart.add-item-v2",
        "uses" => "CartController@postAddItemV2"
    ));
    Route::post('cart/add-coupon', array(
        'as'   => 'ajax.cart.add-coupon',
        'uses' => 'CartController@postAddCoupon'
    ));
    Route::post('cart/remove-coupon', array(
        'as'   => 'ajax.cart.remove-coupon',
        'uses' => 'CartController@postRemoveCoupon'
    ));

    Route::post('cart/save-ship-addr', array(
        'as'   => 'ajax.cart.save-ship-addr',
        'uses' => 'CartController@postSaveShipAddr'
    ));

    Route::post('cart/apply-trueyou', array(
        'as'   => 'ajax.cart.apply-trueyou',
        'uses' => 'CartController@postApplyTrueyou'
    ));

    Route::post('cart/set-card-data', array(
        'as'   => 'ajax.cart.set-card-data',
        'uses' => 'CartController@setCardData'
    ));

    Route::get('customers/address', array(
        'as'     => 'ajax.customers.getaddress',
        'uses'   => 'CustomersController@getAddress'
    ));

    Route::post('customers/addr', array(
        'as'    => 'ajax.customers.getaddr',
        'uses'  => 'CustomersController@postAddr'
    ));

    Route::post('customers/address', array(
        'as'     => 'ajax.customers.postaddress',
        'uses'   => 'CustomersController@postAddress'
    ));

    Route::post('customers/save-ship-addr', array(
        'as'   => 'ajax.customers.save-ship-addr',
        'uses' => 'CustomersController@postSaveShipAddr'
    ));

    Route::post('customers/delete-ship-addr', array(
        'as'   => 'ajax.customer.delete-ship-addr',
        'uses' => 'CustomersController@postDeleteShipAddr'
    ));

    Route::get('customers/edit-ship-addr', array(
        'as'   => 'ajax.customer.edit-ship-addr',
        'uses' => 'CustomersController@getEditShipAddr'
    ));

    Route::post('customers/edit-ship-addr', array(
        'as'   => 'ajax.post.customer.edit-ship-addr',
        'uses' => 'CustomersController@postEditShipAddr'
    ));

    Route::post('customers/saveaddr', array(
        'as'   => 'ajax.post.customer.saveaddr',
        'uses' => 'CustomersController@postSaveAddr'
    ));

    Route::post('checkout/set-customer-info', array(
        'as'     => 'ajax.checkout.set-customer-info',
        'uses'   => 'CheckoutController@postSetCustomerInfo'
    ));

    Route::post('checkout/select-shipment-methods', array(
        'as'     => 'ajax.checkout.select-shipment-methods',
        'uses'   => 'CheckoutController@postSelectShipmentMethods'
    ));

    Route::post('v2/checkout/select-shipment-methods', array(
        'as'     => 'ajax.checkout.select-shipment-methods-v2',
        'uses'   => 'CheckoutController@postSelectShipmentMethodsV2'
    ));

    Route::post('checkout/set-payment-info', array(
        'as'     => 'ajax.checkout.set-payment-info',
        'uses'   => 'CheckoutController@postSetPaymentInfo'
    ));

    Route::post('checkout/update-item', array(
        'as'   => 'ajax.checkout.update-item-qty',
        'uses' => 'CheckoutController@postUpdateItem'
    ));

    Route::post('v2/checkout/update-item', array(
        'as'   => 'ajax.checkout.update-item-qty-v2',
        'uses' => 'CheckoutController@postUpdateItemV2'
    ));

    Route::post('checkout/remove-item', array(
        'as'     => 'ajax.checkout.remove-item',
        'uses'   => 'CheckoutController@postRemoveItem'
    ));

    Route::post('v2/checkout/remove-item', array(
        'as'     => 'ajax.checkout.remove-item-v2',
        'uses'   => 'CheckoutController@postRemoveItemV2'
    ));

    Route::post('checkout/confirm', array(
        'as'     => 'ajax.checkout.confirm',
        'uses'   => 'CheckoutController@postConfirmCheckout'
    ));

    Route::post('checkout', array(
        'as'   => 'ajax.checkout.get-data',
        'uses' => 'CheckoutController@postCheckoutData'
    ));

    Route::post("v2/checkout", array(
        "as" => "ajax.checkoutv2.get-data",
        "uses" => "CheckoutController@postCheckoutDataV2"
    ));

    Route::post('subscribe/new', array(
        'as'   => 'subscribe',
        'uses' => 'SubscribeController@postCreate'
    ));

    Route::get('product/check_img', array(
        'as'   => 'ajax.check_img',
        'uses' => 'ProductsController@getCheckImg'
    ));

    Route::post('checkout/set-bill-info', array(
        'as'     => 'ajax.checkout.set-bill-info',
        'uses'   => 'CheckoutController@postSetBillInfo'
    ));

    Route::post('checkout/convert-shipping-to-bill', array(
        'as'     => 'ajax.checkout.convert-shipping-to-bill',
        'uses'   => 'CheckoutController@postCorvertShippingToBill'
    ));

    Route::post('checkout/set-cart-info', array(
        'as'     => 'ajax.checkout.set-cart-info',
        'uses'   => 'CheckoutController@postSetCartInfo'
    ));

    Route::get('widget/payment-cod', array(
        'as'     => 'ajax.widget.payment-cod',
        'uses'   => 'NewCheckoutController@getPaymentWidgetCod'
    ));

    Route::post('checkout/set-analytics-status',array(
        'as'   => 'thankyou.set-analytics-status',
        'uses' => 'NewCheckoutController@postSetAnalyticsStatus'
    ));

    Route::post('member/remove-ccw', array(
        'as'   => 'member.remove-ccw',
        'uses' => 'MembersController@postRemoveCCW'
    ));

    Route::get('auto-suggestion', array(
        'as'   => 'ajax.auto-suggestion',
        'uses' => 'SolrSearchController@getAutoSuggestion'
    ));

    Route::get('search2', array(
        'as' => "ajax.search2",
        'uses' => "SolrSearchController@getSearch"
    ));
});

Route::controller('test', 'TestController');

Route::get('tumtest', array(
    'as'   => 'tumtest',
    'uses' => 'TestController@getTum'
));

Route::controller('check', 'CheckController');


// Redirect Old URL to new URL
// Level D
Route::get('product/{productPkey}', function($productPkey = null)
{
    if ($productPkey == null)
    {
        return App::abort(404);
    }

    return Redirect::route('products.detail', array('productPkey' => $productPkey), 301);
});

Route::get('flashsale', function()
{
    return Redirect::route('flashsale.products', array(), 301);
});

Route::get('returnpolicy.html', function()
{
    return Redirect::route('policy.view', array('ptype' => 'returnpolicy'), 301);
});

Route::get('money-back-policy.html', function()
{
    return Redirect::route('policy.view', array('ptype' => 'moneyback'), 301);
});

Route::get('deliverypolicy.html', function()
{
    return Redirect::route('policy.view', array('ptype' => 'freedelivery'), 301);
});

Route::get('checkout_manual', function()
{
    return Redirect::route('payment.manual', array(), 301);
});

Route::get('menu/brand-{collectionPkey}', function($collectionPkey = null)
{
    if ($collectionPkey == null)
    {
        return Redirect::route('shopbybrand.index', array(), 301);
    }

    return Redirect::route('shopbybrand.collection', array('collectionPkey' => $collectionPkey), 301);
});

Route::post('login_for_test', function(){

    if (Input::get('username') == "9gag" && Input::get('password') == "lol")
    {
        Session::put('login_for_test', 'Y');

        return Redirect::to('/');
    }
    $errors = "Username or password wrong.";
    return Redirect::back()->withErrors(array('errors' => $errors));

});

Route::get('login_for_test/logout', function(){
    Session::forget('login_for_test');
    return Redirect::to('/');
});
Route::get('auto_login_for_test', function(){
    Session::put('login_for_test', 'Y');
});

Route::get('login_for_test', function(){
    $html = '';

    if (Session::has('login_for_test'))
    {
        $html .= 'Welcome : '.Session::get('login_for_test').'<br />';
        $html .= '<a href="'.url('login_for_test/logout').'">Logout</a>';
    }



    $html .= '<form id="loginForTestForm" name="loginForTestForm" method="post">';
    if (Session::has('errors'))
    {
        $html .= '<p style="color:#FF0000;">Errors : '.Session::get('errors').'</p>';
    }

        $html .= '<table width="50%" align="center" border="0">'
                . '<tr>'
                    . '<td colspan="2" align="center"><h1>Login</h1></td>'
                . '</tr>'
                . '<tr>'
                    . '<td width="40%" align="right">Username : </td>'
                    . '<td width="60%"><input type="text" name="username" id="username" value="admin"></td>'
                . '</tr>'
                . '<tr>'
                    . '<td align="right">Password : </td>'
                    . '<td><input type="password" name="password" id="password"></td>'
                . '</tr>'
                . '<tr>'
                    . '<td colspan="2" align="center"><input type="submit" value="Login" id="btnLogin" name="btnLogin"></td>'
                . '</tr>'
            .   '</table>'
            .'</form>';

    return $html;
});

// git version
Route::get('git-version',
    array(
        'before' => 'auth.basic2',
        function () {
            return getGitStatus();
        }
    )
);

Route::get('version',
    array(
        'before' => 'auth.basic2',
        function () {
            $server_ip = $_SERVER["SERVER_ADDR"];
            $dir = dirname(__FILE__);
            $git_file = $dir . '/../../version.txt';

            $file_content = file_get_contents($git_file);
            echo "IP Server = ".$server_ip."<br/>";
            echo preg_replace('/\r\n|\r|\n/', '<br/>', $file_content);
        }
    )
);
