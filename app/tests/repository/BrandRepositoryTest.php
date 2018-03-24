<?php

class BrandRepositoryTest extends TestCase
{
    private $pcms;
    protected $mainClass = "BrandRepository";

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

    public function testGetByPkeyWithValidPkeyThenReturnArrayData()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . "/../fixtures/brand.yml", "get_brand_by_pkey");
        $row = $dataSet->getRow(0);

        $this->pcms->shouldReceive("apiv2")
            ->with("brands/6952847165628", array(), 'GET')
            ->andReturn($row);

        $brandRepository = $this->getInstance();
        $res = $brandRepository->getByPkey(6952847165628);

        $this->assertArrayHasKey("pkey", $res);
        $this->assertArrayHasKey("name", $res);
        $this->assertArrayHasKey("slug", $res);
        $this->assertArrayHasKey("description", $res);
        $this->assertArrayHasKey("translate", $res);
        $this->assertArrayHasKey("metas", $res);
        $this->assertArrayHasKey("thumbnail", $res);
        $this->assertNotEmpty($res);
    }

    public function testGetByPkeyWithEmptyPkeyThenReturnEmptyArray()
    {
        $this->pcms->shouldReceive("apiv2")
            ->with("brands/", array(), 'GET')
            ->andReturn(array());

        $brandRepository = $this->getInstance();
        $res = $brandRepository->getByPkey("");

        $this->assertEmpty($res);
    }

    public function testGetAllWithHasBrandsThenReturnArrayData()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . "/../fixtures/brand.yml", "get_all_brands");
        $row = $dataSet->getRow(0);

        $this->pcms->shouldReceive("apiv2")
            ->with("brands", array(), "GET")
            ->andReturn($row);

        $brandRepository = $this->getInstance();
        $res = $brandRepository->getAll();

        $this->assertNotEmpty($res);
        $this->assertEquals(15, sizeof($res));
    }

    public function testGetAllWithNotHasBrandsThenReturnEmptyArray()
    {

        $this->pcms->shouldReceive("apiv2")
            ->with("brands", array(), "GET")
            ->andReturn(array());

        $brandRepository = $this->getInstance();
        $res = $brandRepository->getAll();

        $this->assertEmpty($res);
    }


    public function testGetFlashsaleBrandsWithHasBrandsThenReturnArrayData()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . "/../fixtures/brand.yml", "flash_sale_brand");
        $row = $dataSet->getRow(0);

        $this->pcms->shouldReceive("api")
            ->with("brands/flash-sale", array(), "GET")
            ->andReturn($row);

        $brandRepository = $this->getInstance();
        $res = $brandRepository->getFlashsaleBrands();

        $this->assertNotEmpty($res);
    }

    public function testGetFlashsaleBrandsWithNotHasBrandsThenReturnEmptyArray()
    {
        $this->pcms->shouldReceive("api")
            ->with("brands/flash-sale", array(), "GET")
            ->andReturn(array());

        $brandRepository = $this->getInstance();
        $res = $brandRepository->getFlashsaleBrands();

        $this->assertEmpty($res);
    }

    public function testGetItruemartTvBrandsWithHasBrandsThenReturnArrayData()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . "/../fixtures/brand.yml", "itruemart_tv_brand");
        $row = $dataSet->getRow(0);

        $this->pcms->shouldReceive("api")
            ->with("brands/itruemart-tv", array(), "GET")
            ->andReturn($row);

        $brandRepository = $this->getInstance();
        $res = $brandRepository->getItuemartTvBrands();

        $this->assertNotEmpty($res);
    }

    public function testGetItruemartTvBrandsWithNotHasBrandsThenReturnEmptyArray()
    {
        $this->pcms->shouldReceive("api")
            ->with("brands/itruemart-tv", array(), "GET")
            ->andReturn(array());

        $brandRepository = $this->getInstance();
        $res = $brandRepository->getItuemartTvBrands();

        $this->assertEmpty($res);
    }

    public function testGetDiscountBrandsWithHasBrandsThenReturnArrayData()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . "/../fixtures/brand.yml", "discount_brand");
        $row = $dataSet->getRow(0);

        $this->pcms->shouldReceive("api")
            ->with("brands/discount", array(), "GET")
            ->andReturn($row);

        $brandRepository = $this->getInstance();
        $res = $brandRepository->getDiscountBrands();

        $this->assertNotEmpty($res);
    }

    public function testGetDiscountBrandsWithNotHasBrandsThenReturnEmptyArray()
    {
        $this->pcms->shouldReceive("api")
            ->with("brands/discount", array(), "GET")
            ->andReturn(array());

        $brandRepository = $this->getInstance();
        $res = $brandRepository->getDiscountBrands();

        $this->assertEmpty($res);
    }

    public function testGetTrueyouBrandsWithHasBrandsThenReturnArrayData()
    {

        $dataSet = $this->getYMLDataset(__DIR__ . "/../fixtures/brand.yml", "trueyou_brand");
        $row = $dataSet->getRow(0);

        $this->pcms->shouldReceive("api")
            ->with("brands/trueyou", array(), "GET")
            ->andReturn($row);

        $brandRepository = $this->getInstance();
        $res = $brandRepository->getTrueyouBrands();

        $this->assertNotEmpty($res);
    }

    public function testGetTrueyouBrandsWithNotHasBrandsThenReturnEmptyArray()
    {

        $this->pcms->shouldReceive("api")
            ->with("brands/trueyou", array(), "GET")
            ->andReturn(array());

        $brandRepository = $this->getInstance();
        $res = $brandRepository->getTrueyouBrands();

        $this->assertEmpty($res);
    }

    public function testRearrageWithValidParamThenReturnArrayData()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . "/../fixtures/brand.yml", "trueyou_brand");
        $row = $dataSet->getRow(0);
        $row = $row["data"];

        $brandRepository = $this->getInstance();
        $res = $brandRepository->rearrange($row);

        $this->assertNotEmpty($res);
    }

    public function testRearrageWithEmptyParamThenReturnEmptyArray()
    {
        $row =array();

        $brandRepository = $this->getInstance();
        $res = $brandRepository->rearrange($row);

        $this->assertEmpty($res);
    }

}
