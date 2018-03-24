<?php

class ItmMemcachedTest extends \TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        Mockery::close();
    }


    public function testSaveWithCorrectDataNoDebugThenReturnTrue()
    {
        Cache::shouldReceive("put")->andReturn(true);
        $itmMemcached = new ItmMemcached();
        $res = $itmMemcached->save("key", "data", "http://www.itruemart.mock");

        $this->assertTrue($res);
    }

    public function testSaveWithCorrectDataAndDebugThenReturnTrue()
    {
        Input::replace(array("debug_cache" => 1));
        Cache::shouldReceive("put")->andReturn(true);

        ob_start();
        $itmMemcached = new ItmMemcached();
        $res = $itmMemcached->save("key", "data", "http://www.itruemart.mock");
        ob_end_clean();

        $this->assertTrue($res);
    }

    public function testSaveWithoutParamNoDebugThenThrowException()
    {
        Cache::shouldReceive("put")->andThrow(new Exception("memcache error."));

        $itmMemcached = new ItmMemcached();
        $res = $itmMemcached->save("key", "data", "http://www.itruemart.mock");

        $this->assertNull($res);
    }

    public function testSaveWithoutParamAndDebugThenThrowException()
    {
        Cache::shouldReceive("put")->andThrow(new Exception("memcache error."));
        Input::replace(array("debug_cache" => 1));

        ob_start();
        $itmMemcached = new ItmMemcached();
        $res = $itmMemcached->save("key", "data", "http://www.itruemart.mock");
        ob_end_clean();

        $this->assertNull($res);
    }

    public function testRemoveWithCKeyThenReturnTrue()
    {
        Cache::shouldReceive("forget")->andReturn(true);

        $itmMemcached = new ItmMemcached();
        $res = $itmMemcached->remove("ckey");

        $this->assertTrue($res);
    }

    public function testRemoveWithoutCkeyThenThrowException()
    {
        Cache::shouldReceive("forget")->andThrow(new Exception("memcache error."));

        $itmMemcached = new ItmMemcached();
        $res = $itmMemcached->remove();

        $this->assertNull($res);
    }

    public function testGetResultWithCorrectDataNoDebugThenReturnSuccessData()
    {
        Cache::shouldReceive("get")
            ->andReturn(array("code" => 200, "message" => "success", "data" => array()))
            ->shouldReceive("has")
            ->andReturn(true);

        $itmMemcached = new ItmMemcached();
        $res = $itmMemcached->getResult("ckey");

        $this->assertEquals(200, $res["code"]);
        $this->assertEquals("success", $res["message"]);
    }

    public function testGetResultWithCorrectDataAndDebugThenReturnSuccessData()
    {

        Input::replace(array("debug_cache" => 1));
        Cache::shouldReceive("get")
            ->andReturn(array("code" => 200, "message" => "success", "data" => array()))
            ->shouldReceive("has")
            ->andReturn(true);

        ob_start();
        $itmMemcached = new ItmMemcached();
        $res = $itmMemcached->getResult("ckey");
        ob_end_clean();

        $this->assertEquals(200, $res["code"]);
        $this->assertEquals("success", $res["message"]);
    }

    public function testGetResultWithoutDebugNoDataCacheThenReturnNull()
    {
        Cache::shouldReceive("get")
            ->andReturn(array())
            ->shouldReceive("has")
            ->andReturn(false);

        $itmMemcached = new ItmMemcached();
        $res = $itmMemcached->getResult("ckey");

        $this->assertNull($res);
    }

    public function testGetResultWithoutDebugAndDataCacheThenThrowException()
    {
        Cache::shouldReceive("get")
            ->andThrow(new Exception("memcache error."))
            ->shouldReceive("has")
            ->andReturn(true);

        $itmMemcached = new ItmMemcached();
        $res = $itmMemcached->getResult("ckey");

        $this->assertNull($res);
    }

    public function testGetAllKeysWithNoArgsThenReturnEmptyArray()
    {
        Config::shouldReceive("get")->andThrow(new Exception("memcache error."));

        $itmMemcached = new ItmMemcached();
        $res = $itmMemcached->getAllKeys();

        $this->assertEmpty($res);
    }

    public function testGetAllKeysWithNoConfigThenThrowException()
    {
        Config::shouldReceive("get")->andReturn(null);

        $itmMemcached = new ItmMemcached();
        $res = $itmMemcached->getAllKeys();

        $this->assertEmpty($res);
    }

//    public function testGetAllKeysWithConfigSettingThenReturnSuccessData()
//    {
//        Config::shouldReceive("get")->andReturn("host ip", "port");
//        \Mockery::mock("Memcached")
//            ->shouldReceive("addServer")
//            ->andReturn(\Mockery::self())
//            ->shoudReceive("get")
//            ->andReturn(\Mockery::self())
//            ->shouldReReceive("getAllKeys")
//            ->andReturn(array("key1", "key2"));
//
//        $itmMemcached = new ItmMemcached();
//        $res = $itmMemcached->getAllKeys();
//
//        $this->assertEmpty($res);
//    }

}