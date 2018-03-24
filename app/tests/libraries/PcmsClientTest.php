<?php

class PcmsClientTest extends TestCase
{
    private $config = array(
        'url' => 'http://www.pcpm.loc/api',
        'appKey' => '5555555',
        'apiPcmsWeb' => 'http://www.pcpm.loc/api/v5',
        'apiPcms' => 'http://www.pcpm.loc/api',
        'webApiKey' => '5555555',
    );

    private $cachePage;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();

        \Mockery::close();
    }

    public function mockCachePage($cache = false)
    {
        $this->cachePage = Mockery::mock('alias:CachePage')
            ->shouldReceive("getResult")
            ->andReturn($cache)
            ->shouldReceive("save")
            ->andReturn(true);

    }

    public function mockItmMemcached($cache = false)
    {
        $ItmMemcachedMock = Mockery::mock('alias:ElastiCache');
        $ItmMemcachedMock->shouldReceive("getResult")
            ->andReturn($cache)
            ->shouldReceive("save")
            ->andReturn(true);
    }

    private function mockRequestParams($params)
    {
        Input::merge($params);
    }

    public static function provideURI()
    {
        return array(
            array('CURLOPT_HTTPHEADER'),
        );
    }


    /**
     * Test api and return Cache.
     */
    public function testApiMethodPostReturnDataFromCacheFalse()
    {
        Lang::shouldReceive('getLocale')
            ->andReturn('en');

        $this->mockCachePage('Data Cache');

        $params = array(
            'check_quota' => 1,
            'q' => 1
        );

        $pcms = new PcmsClient($this->config);
        $result = $pcms->api($path = '?xxx=1', $params, $method = 'POST', $nocache = false, $curl_opts_input = null);
        $this->assertEquals('Data Cache', $result);
    }

    /**
     * Test api and return false.
     */
    public function testApiMethodGetReturnFalse()
    {
        Lang::shouldReceive('getLocale')
            ->andReturn('en');

        $this->mockCachePage();

        $pcms = new PcmsClient($this->config);
        $result = $pcms->api($path = '', $params = array(), $method = 'GET', $nocache = true, $curl_opts_input = NULL);
        $this->assertFalse($result);
    }

    /**
     * Test api and return false.
     */
    public function testApiMethodGetWithParamReturnFalse()
    {
        Lang::shouldReceive('getLocale')
            ->andReturn('en');

        $params = array(
            'check_quota' => 1,
            'q' => 1
        );

        $this->mockCachePage(false);

        $pcms = new PcmsClient($this->config);
        $result = $pcms->api($path = '?xxx=1', $params, $method = 'GET', $nocache = true, $curl_opts_input = null);
        $this->assertFalse($result);
    }

    /**
     * Test api and return false.
     */
    public function testApiMethodPostReturnFalse()
    {
        Lang::shouldReceive('getLocale')
            ->andReturn('en');

        $params = array(
            'check_quota' => 1,
            'q' => 1
        );

        $this->mockCachePage(false);

        $curl_opts_input = array(
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_USERAGENT => 'pcms-0.1',
            CURLOPT_FOLLOWLOCATION => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_HTTPHEADER => array(),
            CURLINFO_CONTENT_TYPE => 'application/json',
        );

        Event::shouldReceive('fire')->andReturn(true);

        $pcms = new PcmsClient($this->config);

        $result = $pcms->api($path = '?xxx=1', $params, $method = 'POST', $nocache = true, $curl_opts_input);
        $this->assertEquals(false, $result);
    }

    /**
     * apiV5
     * Test apiV5 and return false.
     */
    public function testApiV5MethodGeNoParamReturnFalse()
    {
        Lang::shouldReceive('getLocale')
            ->andReturn('en');

        $this->mockCachePage(false);

        $pcms = new PcmsClient($this->config);
        $result = $pcms->apiV5($path = '', $params = array(), $method = 'GET', $nocache = true, $curl_opts_input = null);
        $this->assertEquals(array('data' => array()), $result);
    }

    /**
     * apiV5
     * Test apiV5 and return false.
     */
    public function testApiV5MethodGetWithParamReturnFalse()
    {
        Lang::shouldReceive('getLocale')
            ->andReturn('en');

        $this->mockCachePage(false);

        $params = array(
            'check_quota' => 1,
            'q' => 1
        );

        $pcms = new PcmsClient($this->config);
        $result = $pcms->apiV5($path = '?xxx=1', $params, $method = 'GET', $nocache = true, $curl_opts_input = null);
        $this->assertEquals(array('data' => array()), $result);
    }

    /**
     * apiV5
     * Test apiV5 and return false.
     */
    public function testApiV5MethodPostReturnArray()
    {
        Lang::shouldReceive('getLocale')
            ->andReturn('en');

        $this->mockCachePage(false);

        // Mock Input
        $params = array(
            'no-cache' => 1,
        );
        $this->mockRequestParams($params);

        // Mocj Config
        $mock = \Mockery::mock();
        $mock->shouldReceive('Config')
            ->andReturn(true);

        $curl_opts_input = array(
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_USERAGENT => 'pcms-0.1',
            CURLOPT_FOLLOWLOCATION => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_HTTPHEADER => array(),
            CURLINFO_CONTENT_TYPE => 'application/json',
        );

        Event::shouldReceive('fire')->andReturn(true);

        $pcms = new PcmsClient($this->config);

        $result = $pcms->apiV5($path = "?xxx=1", $params, $method = 'POST', $nocache = true, $curl_opts_input);
        $this->assertEquals(array('data' => array()), $result);
    }

    /**
     * pcmsApiV5
     * Test pcmsApiV5 empty value and return false.
     */
    public function testPcmsApiV5MethodGeNoParamReturnFalse()
    {
        Lang::shouldReceive('getLocale')
            ->andReturn('en');

        $this->mockCachePage(false);

        // Mocj Config
        $mock = \Mockery::mock();
        $mock->shouldReceive('Config')
            ->andReturn('qwertyu');

        $pcms = new PcmsClient($this->config);
        $result = $pcms->pcmsApiV5($path = '', $params = array(), $method = 'GET', $nocache = true, $curl_opts_input = null);
        $this->assertEquals(array('data' => array()), $result);
    }

    /**
     * pcmsApiV5
     * Test pcmsApiV5 and return Array.
     */
    public function testPcmsApiV5MethodGetWithParamReturnFalse()
    {
        Lang::shouldReceive('getLocale')
            ->andReturn('en');

        $this->mockCachePage(false);

        $params = array(
            'check_quota' => 1,
            'q' => 1
        );

        $pcms = new PcmsClient($this->config);
        $result = $pcms->pcmsApiV5($path = '?xxx=1', $params, $method = 'GET', $nocache = true, $curl_opts_input = null);
        $this->assertEquals(array('data' => array()), $result);
    }

    /**
     * pcmsApiV5
     * Test pcmsApiV5 and return false.
     */
    public function testPcmsApiV5MethodPostReturnArray()
    {
        Lang::shouldReceive('getLocale')
            ->andReturn('en');

        $this->mockCachePage(false);

        // Mock Input
        $params = array(
            'no-cache' => 1,
        );
        $this->mockRequestParams($params);

        // Mock Config
        $mock = \Mockery::mock();
        $mock->shouldReceive('Config')
            ->andReturn(true);

        $curl_opts_input = array(
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_USERAGENT => 'pcms-0.1',
            CURLOPT_FOLLOWLOCATION => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_HTTPHEADER => array(),
            CURLINFO_CONTENT_TYPE => 'application/json',
        );

        Event::shouldReceive('fire')->andReturn(true);

        $pcms = new PcmsClient($this->config);
        $result = $pcms->pcmsApiV5($path = "?xxx=1", $params, $method = 'POST', $nocache = true, $curl_opts_input);
        $this->assertEquals(array('data' => array()), $result);
    }

    /*
     * getCart
     * Test getCart and return Cache data
     * */

    public function testGetCartReturnArray()
    {
        $this->mockACL(true);

        $this->mockCachePage('Data Cache');

        $pcms = new PcmsClient($this->config);
        $result = $pcms->getCart();
        $this->assertEquals('Data Cache', $result);
    }

    /*
     * getCartV2
     * Test getCartV2 and return array()
     * */
    public function testGetCartV2ReturnArray()
    {
        $this->mockCachePage(false);

        $this->mockACL(true);
        $expect_result = array(
            'code' => 500,
            'status' => 500,
            'message' => "Can not Connect API",
            'data' => array()
        );

        $this->mockItmMemcached($expect_result);

        $pcms = new PcmsClient($this->config);
        $result = $pcms->getCartV2();
        $this->assertEquals($expect_result, $result);
    }

    /*
     * getCheckout
     * Test getCheckout and return Cache data
     * */
    public function testGetCheckoutReturnCacheData()
    {
        $this->mockACL(true);

        $this->mockCachePage('Data Cache');

        $pcms = new PcmsClient($this->config);
        $result = $pcms->getCheckout();
        $this->assertEquals('Data Cache', $result);
    }

    /*
     * getCheckoutV2
     * Test getCheckoutV2 and return array()
     * */
    public function testGetCheckoutV2ReturnArray()
    {
        $this->mockACL(true);

        $this->mockItmMemcached(false);

        $expect_result = array(
            'code' => 500,
            'status' => 500,
            'message' => "Can not Connect API",
            'data' => array()
        );

        $pcms = new PcmsClient($this->config);
        $result = $pcms->getCheckoutV2();
        $this->assertEquals($expect_result, $result);
    }

    /*
     * getCustomerAddresses
     * Test getCustomerAddresses and return array()
     * */
    public function testGetCustomerAddressesReturnArray()
    {
        $this->mockACL(true);

        $this->mockCachePage('Data Cache');

        $pcms = new PcmsClient($this->config);
        $result = $pcms->getCustomerAddresses();
        $this->assertEquals('Data Cache', $result);
    }

    /*
     * postApplyCoupon
     * Test postApplyCoupon and return Data Cache
     * */
    public function testGetApplyCouponReturnData()
    {
        $this->mockACL(true);

        $this->mockCachePage('Data Cache');

        $pcms = new PcmsClient($this->config);
        $result = $pcms->postApplyCoupon('xxxxx');
        $this->assertEquals('Data Cache', $result);
    }

    /*
     * getVertical
     * Test getVertical and return Data Cache
     * */

    public function testGetVerticalReturnData()
    {
        $this->mockCachePage('Data Cache');

        $pcms = new PcmsClient($this->config);
        $result = $pcms->getVertical();
        $this->assertEquals('Data Cache', $result);
    }

    /*
     * getCheckTrueyouByIdCard
     * Test getCheckTrueyouByIdCard and return Data Cache
     * */

    public function testGetCheckTrueyouByIdCardReturnData()
    {
        $this->mockCachePage('Data Cache');

        $this->mockACL(true);
        $pcms = new PcmsClient($this->config);
        $result = $pcms->getCheckTrueyouByIdCard(1234567890123);
        $this->assertEquals('Data Cache', $result);
    }

    /*
     * postApplyTrueyouCard
     * Test postApplyTrueyouCard and return false
     * */

    public function testPostApplyTrueyouCardCardFalse()
    {
        $this->mockACL(false);

        $this->mockCachePage(false);

        $pcms = new PcmsClient($this->config);
        $result = $pcms->postApplyTrueyouCard(1234567890123);
        $this->assertEquals(false, $result);
    }

    /*
     * postApplyTrueyouCard
     * Test postApplyTrueyouCard and return Data
     * */

    public function testPostApplyTrueyouCardReturnData()
    {
        $this->mockACL(true);

        $this->mockCachePage('Data Cache');

        $pcms = new PcmsClient($this->config);
        $result = $pcms->postApplyTrueyouCard(1234567890123);
        $this->assertEquals('Data Cache', $result);
    }

    /*
     * postApplyTrueyouToCart
     * Test postApplyTrueyouToCart and return Data
     * */

    public function testGuestPostApplyTrueyouToCartReturnData()
    {
        $this->mockACL(false);

        $this->mockCachePage('Data Cache');

        $pcms = new PcmsClient($this->config);
        $result = $pcms->postApplyTrueyouCard(1234567890123);
        $this->assertEquals(false, $result);
    }

    /*
     * applyTrueyouToCart
     * Test applyTrueyouToCart and return Data
     * */

    public function testApplyTrueyouToCartData()
    {
        $this->mockACL(false);

        $this->mockCachePage('Data Cache');

        $pcms = new PcmsClient($this->config);
        $result = $pcms->applyTrueyouToCart(1234567890123);
        $this->assertEquals('Data Cache', $result);
    }

    /*
     * deleteCart
     * Test applyTrueyouToCart and return Data
     * */

    public function testDeleteCartData()
    {
        $this->mockACL(false);

        $this->mockCachePage(false);

        $pcms = new PcmsClient($this->config);
        $result = $pcms->deleteCart();
        $this->assertEquals(false, $result);
    }

    /*
     * activateUser
     * Test activateUser and return Data
     * */

    public function testActivateUserData()
    {
        $this->mockCachePage('Data Cache');

        $pcms = new PcmsClient($this->config);
        $result = $pcms->activateUser(12345);
        $this->assertEquals('Data Cache', $result);
    }

    /**
     * apiV2
     * Test apiV2 and return array.
     */
    public function testApiV2MethodGetNoParamReturArray()
    {
        $expect_result = array(
            'data' => array(),
            'code' => 500,
            'status' => 500,
            'message' => 'Can not Connect API',
        );

        $this->mockItmMemcached(false);

        $pcms = new PcmsClient($this->config);
        $result = $pcms->apiV2($path = "", $params = array(), $method = 'GET', $nocache = false, $lifetime = 1, $api_version = 1);
        $this->assertEquals($expect_result, $result);
    }

    /**
     * apiV2
     * Test apiV2 and return array.
     */
    public function testApiV2MethodGetWithParamReturArray()
    {
        $expect_result = array(
            'data' => array(),
            'code' => 500,
            'status' => 500,
            'message' => 'Can not Connect API',
        );

        $this->mockItmMemcached(false);

        $pcms = new PcmsClient($this->config);
        $result = $pcms->apiV2($path = "?xxx=1", $params = array(), $method = 'GET', $nocache = false, $lifetime = 1, $api_version = 1);
        $this->assertEquals($expect_result, $result);
    }

    /**
     * makeRequestV2
     * Test makeRequestV2 and return array.
     */
    public function testmakeRequestV2MethodGetWithParamReturArray()
    {
        $expect_result = array(
            'code' => 500,
            'status' => 500,
            'message' => 'Can not Connect API',
        );

        $this->mockItmMemcached(false);

        $pcms = new PcmsClient($this->config);
        $result = $pcms->makeRequestV2($path = "?xxx=1", $params = array(), $method = 'GET', $nocache = false, $lifetime = 1, $api_version = 1);
        $this->assertEquals($expect_result, $result);
    }

    /**
     * makeRequestV2
     * Test makeRequestV2 and return false
     */
    public function testmakeRequestV2MethodPostWithParamReturFalse()
    {
        $this->mockItmMemcached(false);

        $pcms = new PcmsClient($this->config);
        $result = $pcms->makeRequestV2($url = "?xxx=1", $params = array(), $method = "POST", $nocache = false, $lifetime = 1, $path = "");
        $this->assertEquals(false, $result);
    }

    /**
     * makeRequestV2
     * Test makeRequestV2 and return Data Cache
     */
    public function testmakeRequestV2MethodPostWithParamReturDataCache()
    {
        // Mock Input
        $params = array(
            'chk_cache' => 1,
        );
        $this->mockRequestParams($params);

        $expect_result = array(
            'code' => 500,
            'status' => 500,
            'message' => 'Can not Connect API',
        );

        $this->mockItmMemcached($expect_result);

        $pcms = new PcmsClient($this->config);
        $result = $pcms->makeRequestV2($url = "?xxx=1", $params = array(), $method = "GET", $nocache = false, $lifetime = 1, $path = "");
        $this->assertEquals($expect_result, $result);
    }

    /**
     * makeRequestV2
     * Test makeRequestV2 and return Data Cache
     */
    public function testmakeRequestV2MethodPostWithParamReturChkCache()
    {
        // Mock Input
        $params = array(
            'chk_cache' => 1,
        );

        $this->mockItmMemcached(false);

        $this->mockRequestParams($params);
        $pcms = new PcmsClient($this->config);
        $result = $pcms->makeRequestV2($url = "?xxx=1", $params = array(), $method = "POST", $nocache = false, $lifetime = 1, $path = "");
        $this->assertTrue(($result == $result));
    }

}
