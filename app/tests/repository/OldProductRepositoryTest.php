<?php

class OldProductRepositoryTest extends \TestCase
{

    private $pcms;
    protected $mainClass = "OldProductRepository";

    public function setUp()
    {
        parent::setUp();

        $this->pcms = $this->mockSpecific("pcms");
    }

    public function tearDown()
    {
        parent::tearDown();
        \Mockery::close();
    }

    public function testGetByCollectionPkey()
    {
        $expect = array(
            'products' => array(
                'id' => 8146,
                'pkey'  => 2518678895627,
                'title' => "เคส สำหรับ Macbook air JHI Casing 13 inch Red",
                'slug' => null,
                'description' => "เคสสำหรับ Macbook air JHI Casing 13 inch สี Red"
            )

        );

        $mock['data'] = $expect;

        $this->pcms->shouldReceive("api")
            ->withAnyArgs()
            ->andReturn($mock);

        $OldProductRepository = $this->getInstance();
        $result = $OldProductRepository->getByCollectionPkey(3701258529460, 1, 20);

        $this->assertEquals($result, $expect);

    }

    public function testGetByBrandPkey()
    {
        $expect = array(
            'products' => array(
                'id' => 8146,
                'pkey'  => 2518678895627,
                'title' => "เคส สำหรับ Macbook air JHI Casing 13 inch Red",
                'slug' => null,
                'description' => "เคสสำหรับ Macbook air JHI Casing 13 inch สี Red"
            )

        );

        $mock['data'] = $expect;

        $this->pcms->shouldReceive("api")
            ->withAnyArgs()
            ->andReturn($mock);

        $OldProductRepository = $this->getInstance();
        $result = $OldProductRepository->getByBrandPkey(6602864363193, 1, 20);

        $this->assertEquals($result, $expect);

    }

    public function testSearch()
    {
        $params = array(
            'q'         => 'iphone',
            'per_page'  => 20,
            'page'      => 1,
            'collectionKey' => 3701258529460,
            'brandKey'  => 6602864363193
        );

        $expect = array(
                'products' => array(
                    'id' => 8146,
                    'pkey'  => 2518678895627,
                    'title' => "เคส สำหรับ Macbook air JHI Casing 13 inch Red",
                    'slug' => null,
                    'description' => "เคสสำหรับ Macbook air JHI Casing 13 inch สี Red"
                )

        );

        $mock['status'] = 'success';
        $mock['data'] = $expect;

        $this->pcms->shouldReceive("api")
            ->withAnyArgs()
            ->andReturn($mock);

        $OldProductRepository = $this->getInstance();
        $result = $OldProductRepository->search($params);

        $this->assertEquals($result, $expect);

    }

    public function testSearchNoParams()
    {
        $params = array();
        $expect = array('hits' => 0, 'results' => array());

        $OldProductRepository = $this->getInstance();
        $result = $OldProductRepository->search($params);

        $this->assertEquals($result, $expect);

    }

    public function testSearchFail()
    {
        $params = array(
            'q'         => 'iphone',
            'per_page'  => 20,
            'page'      => 1,
            'collectionKey' => 3701258529460,
            'brandKey'  => 6602864363193
        );

        $expect = array('hits' => 0, 'results' => array());

        $mock['status'] = 'fail';
        $mock['data'] = $expect;

        $this->pcms->shouldReceive("api")
            ->withAnyArgs()
            ->andReturn($mock);

        $OldProductRepository = $this->getInstance();
        $result = $OldProductRepository->search($params);

        $this->assertEquals($result, $expect);

    }
}