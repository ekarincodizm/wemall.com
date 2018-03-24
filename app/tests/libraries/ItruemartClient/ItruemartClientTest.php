<?php

class ItruemartClientTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testConstruct()
    {
        $array = array(
            'EndpointUrl' => 'test/api'
        );
        $mockMakeRequest = $this->mock('ItruemartClient\ItruemartClient')->makePartial();
        $mockMakeRequest->shouldReceive('makeRequest')
            ->withAnyArgs()
            ->andReturn(true);

        $ItruemartClient = App::make('ItruemartClient\ItruemartClient');
        $result = $ItruemartClient->__construct($array);
        $this->assertTrue(true);
    }

    public function testGetSeoEssay()
    {
        $mockMakeRequest = $this->mock('ItruemartClient\ItruemartClient')->makePartial();
        $mockMakeRequest->shouldReceive('makeRequest')
            ->withAnyArgs()
            ->andReturn(true);

        $ItruemartClient = App::make('ItruemartClient\ItruemartClient');
        $result = $ItruemartClient->getSeoEssay(1);
        $this->assertTrue($result);

    }

    public function testGetSeoFooter()
    {
        $mockMakeRequest = $this->mock('ItruemartClient\ItruemartClient')->makePartial();
        $mockMakeRequest->shouldReceive('makeRequest')
            ->withAnyArgs()
            ->andReturn(true);

        $ItruemartClient = App::make('ItruemartClient\ItruemartClient');
        $result = $ItruemartClient->getSeoFooter();
        $this->assertTrue($result);

    }

    public function testSubscribe()
    {
        $mockMakeRequest = $this->mock('ItruemartClient\ItruemartClient')->makePartial();
        $mockMakeRequest->shouldReceive('makeRequest')
            ->withAnyArgs()
            ->andReturn(true);

        $ItruemartClient = App::make('ItruemartClient\ItruemartClient');
        $result = $ItruemartClient->subscribe();
        $this->assertTrue($result);
    }

    public function testGetProductListing()
    {
        $params = array(
            'page' => 1,
            'limit' => 10
        );

        $mockMakeRequest = $this->mock('ItruemartClient\ItruemartClient')->makePartial();
        $mockMakeRequest->shouldReceive('makeRequest')
            ->withAnyArgs()
            ->andReturn(true);

        $ItruemartClient = App::make('ItruemartClient\ItruemartClient');
        $result = $ItruemartClient->getProductListing($params);
        $this->assertTrue($result);
    }

    public function testGetKeyCache()
    {
        $requestStr = 'foobar';
        $requestInt = 100;
        $expectStr = 'itruemart-client-3858f62230ac3c915f300c664312c63f';
        $expectInt = 'itruemart-client-f899139df5e1059396431415e770c6dd';

        $mockMakeRequest = $this->mock('ItruemartClient\ItruemartClient')->makePartial();
        $mockMakeRequest->shouldReceive('makeRequest')
            ->withAnyArgs()
            ->andReturn(true);

        $ItruemartClient = App::make('ItruemartClient\ItruemartClient');
        $resultStr = $ItruemartClient->getKeyCache($requestStr);
        $this->assertEquals($resultStr, $expectStr);

        $resultInt = $ItruemartClient->getKeyCache($requestInt);
        $this->assertEquals($resultInt, $expectInt);
    }



}