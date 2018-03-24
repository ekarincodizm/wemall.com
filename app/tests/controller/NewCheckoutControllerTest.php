<?php

class NewCheckoutControllerTest extends TestCase
{

    protected $mainClass = "NewCheckoutController";

    public function setUp()
    {
        parent::setUp();

        $this->pcms = $this->mockSpecific('pcms');
        $this->product = $this->mockSpecific('ProductRepositoryInterface');
        $this->customerAddress = $this->mockSpecific('CustomerAddressRepositoryInterface');
        $this->mockApiEventLogs = $this->mock('ApiEventLogs');
        $this->mockApiEventLogs->shouldReceive('setAttribute');

        $this->mockTimeLogger = \Mockery::mock('alias:TimeLogger');
        $this->mockTimeLogger->shouldReceive('snap')->andReturn(\Mockery::self());

        $this->teeplusTheme = $this->getTeeplusThemeMock();
        $this->teeplusTheme->shouldReceive("layout")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("asset")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("writeContent")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("setTitle")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("container")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("script")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("writeScript")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("breadcrumb")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("add")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("usePath")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("setMetadescription")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("setMetakeywords")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("setCanonical")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("scope")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("with")->andReturn(Mockery::self());

        $teeplusTheme = $this->teeplusTheme;
        $this->teeplusTheme->shouldReceive("partialComposer")->andReturnUsing(function ($param1, $closure) use ($teeplusTheme) {
            $closure($teeplusTheme);
        });

    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    protected function prepareCartData()
    {
        $dataset = $this->getYMLDataset(__DIR__ . '/../fixtures/cart.yml', 'cart');
        $cart_data = $dataset->getRow(0);

        return $cart_data;
    }

    private function getCheckoutDataV2($idx = 0)
    {
        $checkoutData = $this->getYMLDataset(__DIR__ . "/../fixtures/checkout-data.yml", "getcheckoutv2");
        return $checkoutData->getRow($idx);
    }

    private function getPaymentData($dataSet, $idx = 0)
    {
        $dataSet = $this->getYMLDataset(__DIR__ . "/../fixtures/payment.yml", $dataSet);
        return $dataSet->getRow($idx);
    }

    private function getProvinces()
    {
        $provinces = $this->getYMLDataset(__DIR__ . "/../fixtures/provinces.yml", "provinces");
        return $provinces->getRow(0);
    }

    private function getCities()
    {
        $cities = $this->getYMLDataset(__DIR__ . "/../fixtures/cities.yml", "cities");
        return $cities->getRow(0);
    }

    private function getDisticts()
    {
        $districts = $this->getYMLDataset(__DIR__ . "/../fixtures/districts.yml", "districts");
        return $districts->getRow(0);
    }

    private function getZipcodes()
    {
        $zipcodes = $this->getYMLDataset(__DIR__ . "/../fixtures/zipcodes.yml", "zipcodes");
        return $zipcodes->getRow(0);
    }

    private function getCustomerAddress()
    {
        $customerAddress = $this->getYMLDataset(__DIR__ . "/../fixtures/customer-address.yml", "inthras_address");
        return $customerAddress->getRow(0);
    }

    public function testStep3ErrorPlace3()
    {
        $this->mockACL();

        $cart_data = $this->prepareCartData();

        // remove data
        unset($cart_data['data']['payment_method_code']);

        $this->pcms->shouldReceive('getCheckoutV2')->andReturn($cart_data);

        Redirect::shouldReceive('to')->with('checkout/step3?place=3');

        $this->newCheckoutController = $this->getInstance();
        $this->newCheckoutController->postStep3();
    }

    public function testStep3ErrorPlace4()
    {
        $this->mockACL();

        $cart_data = $this->prepareCartData();
        $cart_data["data"]["payment_method"] = '155413837979192';

        // make inventory in payment difference from cart inventory
        $cart_data["data"]["all_payment_methods"]['155413837979192']['inventory_ids'] = array('1234');

        $this->pcms->shouldReceive('getCheckoutV2')->andReturn($cart_data);

        Redirect::shouldReceive('to')->with('checkout/step3?place=4');

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->postStep3();
    }

    public function testStep3ErrorPlace5()
    {
        $this->mockACL();

        $cart_data = $this->prepareCartData();
        $cart_data["data"]["payment_method"] = '155413837979192';

        // make inventory in payment empty
        $cart_data["data"]["all_payment_methods"]['155413837979192']['inventory_ids'] = array();

        $this->pcms->shouldReceive('getCheckoutV2')->andReturn($cart_data);

        Redirect::shouldReceive('to')->with('checkout/step3?place=5');

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->postStep3();
    }

    public function testStep3ErrorPlace6()
    {
        $this->mockACL();

        $cart_data = $this->prepareCartData();
        $cart_data['data']['payment_method_code'] = 'CCinstM';
        $cart_data["data"]["payment_method"] = '155413837979192';

        // set installment data
        $cart_data['data']['bank_id'] = 1;
        $cart_data['data']['installment']['period'] = 3;
        $cart_data['data']['shipments'][26]['items'][0]['bank_installments'] = array(
            array(
                'id' => "2",
                'name' => "กสิกรไทย",
                'comp_code' => false,
                'abbreviation' => "kbank",
                'card_type' => "creditcard",
                'tmn_name' => "kbank",
                'periods' => array(
                    "3", "6", "10"
                ),
            ),
        );

        $this->pcms->shouldReceive('getCheckoutV2')->andReturn($cart_data);

        Redirect::shouldReceive('to')->with('checkout/step3?place=6');

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->postStep3();
    }

    public function testStep3ErrorPlace7()
    {
        $this->mockACL();

        $cart_data = $this->prepareCartData();
        $cart_data['data']['payment_method_code'] = 'CCinstM';
        $cart_data["data"]["payment_method"] = '155413837979192';

        // set installment data
        $cart_data['data']['bank_id'] = 1;
        $cart_data['data']['installment']['period'] = 3;
        $cart_data['data']['shipments'][26]['items'][1]['inventory_id'] = 124;
        $cart_data['data']['shipments'][26]['items'][0]['bank_installments'] = array(
            array(
                'id' => "1",
                'name' => "กสิกรไทย",
                'comp_code' => false,
                'abbreviation' => "kbank",
                'card_type' => "creditcard",
                'tmn_name' => "kbank",
                'periods' => array(
                    "3", "6", "10"
                ),
            ),
        );

        $this->pcms->shouldReceive('getCheckoutV2')->andReturn($cart_data);

        Redirect::shouldReceive('to')->with('checkout/step3?place=7');

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->postStep3();
    }

    public function testStep3ErrorPlace8()
    {
        $this->mockACL();

        $cart_data = $this->prepareCartData();
        $cart_data['data']['payment_method_code'] = 'CCinstM';
        $cart_data["data"]["payment_method"] = '155413837979192';

        // set installment data
        $cart_data['data']['bank_id'] = false;
        $cart_data['data']['installment'] = false;

        $this->pcms->shouldReceive('getCheckoutV2')->andReturn($cart_data);

        Redirect::shouldReceive('to')->with('checkout/step3?place=8');

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->postStep3();
    }

    public function testCCWInvalid()
    {
        $this->mockACL();

        $cart_data = $this->prepareCartData();

        $this->pcms->shouldReceive('getCheckoutV2')->andReturn($cart_data);

        Validator::shouldReceive('make')
            ->andReturn(Mockery::self())
            ->shouldReceive('fails')
            ->andReturn(true);

        Redirect::shouldReceive('to')
            ->with('checkout/step3')
            ->andReturn(Mockery::self())
            ->shouldReceive('withErrors');

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->postStep3();
    }

    public function testCCWEmptyInvoiceInvalid()
    {
        // prepare input
        $input_mock['add_invoice'] = false;
        Input::replace($input_mock);

        $this->mockACL();

        $cart_data = $this->prepareCartData();

        $this->pcms->shouldReceive('getCheckoutV2')->andReturn($cart_data);

        $this->pcms->shouldReceive('api');

        Validator::shouldReceive('make')
            ->andReturn(Mockery::self())
            ->shouldReceive('fails')
            ->andReturn(true);

        Redirect::shouldReceive('to')
            ->with('checkout/step3')
            ->andReturn(Mockery::self())
            ->shouldReceive('withErrors');

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->postStep3();
    }

    public function testCCWVisaSuccess()
    {
        // prepare input
        $input_mock['add_invoice'] = 'Y';
        $input_mock['creditnum'] = '4credit-num';
        Input::replace($input_mock);

        $this->mockACL();

        $cart_data = $this->prepareCartData();

        $this->pcms->shouldReceive('getCheckoutV2')->andReturn($cart_data);

        Validator::shouldReceive('make')
            ->andReturn(Mockery::self())
            ->shouldReceive('fails')
            ->andReturn(false);

        $response['code'] = 200;
        $response['data']['html'] = 'response-html';
        $this->pcms->shouldReceive('api')->andReturn($response);
        $this->customerAddress->shouldReceive('deleteStage');
        $this->mockApiEventLogs->shouldReceive('save')->andReturn(false);

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->postStep3();
    }

    public function testCCWMasterSuccess()
    {
        // prepare input
        $input_mock['add_invoice'] = 'Y';
        $input_mock['creditnum'] = '5credit-num';
        Input::replace($input_mock);

        $this->mockACL();

        $cart_data = $this->prepareCartData();

        $this->pcms->shouldReceive('getCheckoutV2')->andReturn($cart_data);

        Validator::shouldReceive('make')
            ->andReturn(Mockery::self())
            ->shouldReceive('fails')
            ->andReturn(false);

        $response['code'] = 200;
        $response['data']['html'] = 'response-html';
        $this->pcms->shouldReceive('api')->andReturn($response);
        $this->customerAddress->shouldReceive('deleteStage');
        $this->mockApiEventLogs->shouldReceive('save')->andReturn(false);

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->postStep3();
    }

    public function testCCWOtherSuccess()
    {
        // prepare input
        $input_mock['add_invoice'] = 'Y';
        $input_mock['creditnum'] = 'credit-num';
        Input::replace($input_mock);

        $this->mockACL();

        $cart_data = $this->prepareCartData();
        $this->pcms->shouldReceive('getCheckoutV2')->andReturn($cart_data);

        Validator::shouldReceive('make')
            ->andReturn(Mockery::self())
            ->shouldReceive('fails')
            ->andReturn(false);

        $response['code'] = 200;
        $response['data']['html'] = 'response-html';
        $this->pcms->shouldReceive('api')->andReturn($response);

        $this->customerAddress->shouldReceive('deleteStage');

        $this->mockApiEventLogs->shouldReceive('save')->andReturn(false);

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->postStep3();
    }

    public function testOldCCWSuccess()
    {
        // prepare input
        $input_mock['add_invoice'] = 'Y';
        $input_mock['is_new_ccw'] = 'N';
        $input_mock['creditnum'] = 'credit-num';
        $input_mock['creditno'] = 'credit-no';
        Input::replace($input_mock);

        $this->mockACL();

        $cart_data = $this->prepareCartData();

        $this->pcms->shouldReceive('getCheckoutV2')->andReturn($cart_data);

        Validator::shouldReceive('make')
            ->andReturn(Mockery::self())
            ->shouldReceive('fails')
            ->andReturn(false);

        $response['code'] = 200;
        $response['data']['html'] = 'response-html';
        $this->pcms->shouldReceive('api')->andReturn($response);

        $this->customerAddress->shouldReceive('deleteStage');

        $this->mockApiEventLogs->shouldReceive('save')->andReturn(false);

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->postStep3();
    }

    public function testCreateOrderResponseFail()
    {
        // prepare input
        $input_mock['add_invoice'] = 'Y';
        $input_mock['creditnum'] = 'credit-num';
        $input_mock['creditno'] = 'credit-no';
        Input::replace($input_mock);

        $this->mockACL();

        $cart_data = $this->prepareCartData();

        $this->pcms->shouldReceive('getCheckoutV2')->andReturn($cart_data);

        Validator::shouldReceive('make')
            ->andReturn(Mockery::self())
            ->shouldReceive('fails')
            ->andReturn(false);

        $response['code'] = 400;
        $response['data']['html'] = 'response-html';
        $this->pcms->shouldReceive('api')->andReturn($response);

        $this->customerAddress->shouldReceive('deleteStage');

        $this->mockApiEventLogs->shouldReceive('save')->andReturn(false);

        $this->teeplusTheme->shouldReceive('layout');
        $this->teeplusTheme->shouldReceive('render');

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->postStep3();
    }

    public function testGetStep2WithMemberRoleOnWebThenRenderViewSuccessful()
    {

        $checkoutData = $this->getCheckoutDataV2(0);
        $provinces = $this->getProvinces();

        $this->pcms->shouldReceive("getCheckoutV2")->andReturn($checkoutData);
        $this->pcms->shouldReceive("apiv2")->andReturn($provinces);

        $this->teeplusTheme->shouldReceive("append")->andReturn(\Mockery::self());
        $this->teeplusTheme->shouldReceive("widget")->andReturn(\Mockery::self());
        $this->teeplusTheme->shouldReceive("render")->andReturn("<div>mock widget view</div>", "success");

        Request::shouldReceive("server")
            ->andReturn("m.itruemart.com")
            ->shouldReceive("path")
            ->andReturn("/checkout/step2")
            ->shouldReceive("input")
            ->andReturn(1);

        $this->mockACL(true);

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->getStep2();

        $this->assertEquals("success", $response);

    }

    public function testGetStep2WithMemberRoleOnMobileThenRenderViewSuccessful()
    {

        $checkoutData = $this->getCheckoutDataV2(0);
        $provinces = $this->getProvinces();
        $customerAddress = $this->getCustomerAddress();

        $this->teeplusTheme->shouldReceive("append")->andReturn(\Mockery::self());
        $this->teeplusTheme->shouldReceive("widget")->andReturn(\Mockery::self());
        $this->teeplusTheme->shouldReceive("render")->andReturn("<div>mock widget view</div>", "success");

        Request::shouldReceive("server")
            ->andReturn("m.itruemart.com")
            ->shouldReceive("path")
            ->andReturn("/checkout/step2")
            ->shouldReceive("input")
            ->andReturn(1);;

        $this->pcms->shouldReceive("getCheckoutV2")->andReturn($checkoutData);
        $this->pcms->shouldReceive("apiv2")->andReturn($provinces);

        $this->customerAddress->shouldReceive("getAddress")->andReturn($customerAddress);

        $this->mockACL(true);

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->getStep2();

        $this->assertEquals("success", $response);

    }

    public function testGetStep2WithGuestRoleThenRenderViewSuccessful()
    {

        $checkoutData = $this->getCheckoutDataV2(0);
        $provinces = $this->getProvinces();

        $this->pcms->shouldReceive("getCheckoutV2")->andReturn($checkoutData);
        $this->pcms->shouldReceive("apiv2")->andReturn($provinces);

        $this->teeplusTheme->shouldReceive("append")->andReturn(\Mockery::self());
        $this->teeplusTheme->shouldReceive("render")->andReturn("success");

        $this->mockACL(false);

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->getStep2();

        $this->assertEquals("success", $response);

    }

    public function testGetStep2WithGuestRoleAndExistingShippingAddressThenRenderViewSuccessful()
    {
        $checkoutData = $this->getCheckoutDataV2(1);
        $provinces = $this->getProvinces();
        $cities = $this->getCities();
        $districts = $this->getDisticts();
        $zipcodes = $this->getZipcodes();

        $this->pcms->shouldReceive("getCheckoutV2")->andReturn($checkoutData);
        $this->pcms->shouldReceive("apiv2")->andReturn($provinces, $cities, $districts, $zipcodes);

        $this->teeplusTheme->shouldReceive("append")->andReturn(\Mockery::self());
        $this->teeplusTheme->shouldReceive("render")->andReturn("success");

        $this->mockACL(false);

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->getStep2();

        $this->assertEquals("success", $response);
    }

    public function testPostStep2WithInvalidCustomerNameThenValidateFailed()
    {

        $checkoutData = $this->getCheckoutDataV2(2);

        $this->pcms->shouldReceive("getCheckoutV2")->andReturn($checkoutData);

        $this->customerAddress->shouldReceive("saveStage")->andReturn(true);

        Validator::shouldReceive('make')
            ->andReturn(Mockery::self())
            ->shouldReceive('fails')
            ->andReturn(true);

        Redirect::shouldReceive("route")
            ->with("checkout.step2")
            ->andReturn(\Mockery::self())
            ->shouldReceive("withErrors")
            ->andReturn("failed");

        $this->mockACL(false);

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->postStep2();

        $this->assertEquals("failed", $response);
    }

    public function testPostStep2WithValidCustomerNameThenSaveShipmentAndRedirectSuccessful()
    {
        $checkoutData = $this->getCheckoutDataV2(1);

        $this->pcms->shouldReceive("getCheckoutV2")
            ->andReturn($checkoutData)
            ->shouldReceive("api")
            ->andReturn(array("status" => "success", "code" => 200, "message" => "200 OK"));

        $this->customerAddress->shouldReceive("saveStage")->andReturn(true);

        Validator::shouldReceive('make')
            ->andReturn(Mockery::self())
            ->shouldReceive('fails')
            ->andReturn(false);

        Redirect::shouldReceive("to")
            ->andReturn("success");

        $this->mockACL(false);

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->postStep2();

        $this->assertEquals("success", $response);

    }

    public function testAnyThankyouWithValidOrderIdThenReturnSuccess()
    {
        $this->teeplusTheme->shouldReceive("render")->andReturn("success");

        $checkoutData = $this->getCheckoutDataV2(1);
        $paymentDetail = $this->getPaymentData("payment_detail");
        $paymentItems = $this->getPaymentData("payment_items");

        $this->pcms->shouldReceive("getCheckoutV2")
            ->andReturn($checkoutData)
            ->shouldReceive("api")
            ->andReturn($paymentDetail, $paymentItems);
        $this->mockACL(true);
        Input::replace(array("order_id" => 171526));

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->anyThankyou();

        $this->assertEquals("success", $response);
    }

    public function testAnyThankyouWithInvalidPaymentChannelThenReturnFail()
    {
        $checkoutData = $this->getCheckoutDataV2(1);
        $paymentDetail = $this->getPaymentData("payment_detail");
        $paymentItems = $this->getPaymentData("payment_items");
        $paymentDetail["data"]["payment_channel"] = "halfline";

        $this->pcms->shouldReceive("getCheckoutV2")
            ->andReturn($checkoutData)
            ->shouldReceive("api")
            ->andReturn($paymentDetail, $paymentItems);
        $this->mockACL(true);
        Input::replace(array("order_id" => 171526));

        Redirect::shouldReceive('route')->andReturn(false);

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->anyThankyou();

        $this->assertFalse($response);
    }

    public function testAnyThankyouWithInvalidOrderIdThenReturnFail()
    {
        $checkoutData = $this->getCheckoutDataV2(1);
        $paymentDetail = $this->getPaymentData("payment_detail");

        $this->pcms->shouldReceive("getCheckoutV2")
            ->andReturn($checkoutData)
            ->shouldReceive("api")
            ->andReturn($paymentDetail);
        $this->mockACL(true);
        Redirect::shouldReceive('route')->andReturn(false);

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->anyThankyou();

        $this->assertFalse($response);
    }

    public function testAnyThankyouWithEmptyResponseDataThenReturnFail()
    {
        $this->teeplusTheme->shouldReceive("render")
            ->andReturn(false);
        $checkoutData = $this->getCheckoutDataV2(0);

        $this->pcms->shouldReceive("getCheckoutV2")
            ->andReturn($checkoutData)
            ->shouldReceive("api")
            ->andReturn(array("code" => 200, "status" => "success", "data" => array()));
        $this->mockACL(true);
        Input::replace(array("order_id" => 1));

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->anyThankyou();

        $this->assertFalse($response);
    }

    public function testAnyThankyouWithWrongLangThenSwitchToEnFail()
    {
        $checkoutData = $this->getCheckoutDataV2(1);
        $paymentDetail = $this->getPaymentData("payment_detail", 1);

        $this->pcms->shouldReceive("getCheckoutV2")
            ->andReturn($checkoutData)
            ->shouldReceive("api")
            ->andReturn($paymentDetail);
        $this->mockACL(true);
        Redirect::shouldReceive('to')->andReturn(false);
        Input::replace(array("order_id" => 1));

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->anyThankyou();

        $this->assertFalse($response);
    }

    public function testAnyThankyouWithWrongLangThenSwitchToThFail()
    {
        $checkoutData = $this->getCheckoutDataV2(1);
        $paymentDetail = $this->getPaymentData("payment_detail", 0);

        App::setLocale("en");
        $this->pcms->shouldReceive("getCheckoutV2")
            ->andReturn($checkoutData)
            ->shouldReceive("api")
            ->andReturn($paymentDetail);
        $this->mockACL(true);
        Redirect::shouldReceive('to')->andReturn(false);
        Input::replace(array("order_id" => 1));

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->anyThankyou();

        $this->assertFalse($response);
    }

    public function testAnyThankyouWithValidParamsThenConvertEmailToPhoneSuccess()
    {
        $this->teeplusTheme
            ->shouldReceive("render")
            ->andReturn("success");
        $checkoutData = $this->getCheckoutDataV2(1);
        $paymentDetail = $this->getPaymentData("payment_detail", 0);
        $paymentDetail["data"]["customer_email"] = "028888888";

        $this->pcms->shouldReceive("getCheckoutV2")
            ->andReturn($checkoutData)
            ->shouldReceive("api")
            ->andReturn($paymentDetail);
        $this->mockACL(true);
        Input::replace(array("order_id" => 1));

        $this->newCheckoutController = $this->getInstance();
        $response = $this->newCheckoutController->anyThankyou();

        $this->assertEquals("success", $response);
    }

}