<?php

class CachePageTest extends TestCase
{

    private $cachePage;
    private $cache;

    public function setUp()
    {
        parent::setUp();

        $this->cachePage = new CachePage();
        $this->cache = Cache::shouldReceive("tags")
            ->andReturn(\Mockery::self());
    }

    public function tearDown()
    {
        parent::tearDown();
        \Mockery::close();
    }

    public function testGetWithNotAllowUrlThenReturnFalse()
    {
        $res = $this->cachePage->get("key", "http://www.site.com/search");
        $this->assertFalse($res);
    }

    public function testGetWithExceptedUrlThenReturnFalse()
    {
        $res = $this->cachePage->get("key", "http://www.site.com/flash-sale");
        $this->assertFalse($res);
    }

    public function testGetWithAllowUrlThenReturnFalseAsNoResult()
    {
        $this->cache->shouldReceive("has")
            ->andReturn(false);

        $res = $this->cachePage->get("key", "http://www.site.com/products");
        $this->assertFalse($res);
    }

    public function testGetWithAllowUrlAndNoCacheParamThenReturnFalse()
    {
        $this->cache->shouldReceive("has")
            ->andReturn(true);
        Input::replace(array("no-cache" => 1));

        $res = $this->cachePage->get("key", "http://www.site.com/products");
        $this->assertFalse($res);
    }

    public function testGetWithAllowUrlThenReturnResult()
    {

        $data = array("code" => 200, "data" => array());
        $this->cache->shouldReceive("has")
            ->andReturn(true)
            ->shouldReceive("get")
            ->andReturn(json_encode($data));

        $res = $this->cachePage->get("key", "http://www.site.com/products");
        $res = json_decode($res, true);

        $this->assertEquals(200, $res['code']);
    }


    public function testGetResultThenReturnFalseAsNoResult()
    {
        $data = array("code" => 200, "data" => array());
        $this->cache->shouldReceive("has")
            ->andReturn(true)
            ->shouldReceive("get")
            ->andReturn($data);

        $res = $this->cachePage->getResult("key", "http://www.site.com/products");

        $this->assertFalse($res);
    }

    public function testGetResultThenReturnResult()
    {
        $data = array("code" => 200, "result" => array("mock_data"));
        $this->cache->shouldReceive("has")
            ->andReturn(true)
            ->shouldReceive("get")
            ->andReturn($data);

        $res = $this->cachePage->getResult("key", "http://www.site.com/products");

        $this->assertEquals("mock_data", $res[0]);
    }

    public function testSaveWithNotAllowUrlThenReturnFalse()
    {
        $res = $this->cachePage->save("key", "value", "http://www.site.com/search");
        $this->assertFalse($res);
    }

    public function testSaveWithExceptedUrlThenReturnFalse()
    {
        $res = $this->cachePage->save("key", "value", "http://www.site.com/flash-sale");
        $this->assertFalse($res);
    }

    public function testSaveThenReturnTrueAsSuccess()
    {
        $this->cache->shouldReceive("put")->andReturn(true);

        $res = $this->cachePage->save("key", "value", "http://www.site.com/products");
        $this->assertTrue($res);
    }
}