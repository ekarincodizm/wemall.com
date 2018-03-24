<?php

class BannerRepositoryTest extends TestCase
{

    protected $mainClass = "BannerRepository";
    private $pcms;

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

    public function testGetByPositionWithSinglePositionThenReturnArrayData()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . "/../fixtures/banners.yml", "single_get_by_position_banner");
        $row = $dataSet->getRow(0);

        $this->pcms->shouldReceive("apiv2")
            ->with("banners", array("position" => 8), "GET")
            ->andReturn($row);

        $bannerRepository = $this->getInstance();
        $res = $bannerRepository->getByPosition(8);

        $this->assertNotEmpty($res);
    }

    public function testGetByPositionWithSinglePositionThenReturnEmptyBannerList()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . "/../fixtures/banners.yml", "single_get_by_position_banner_empty_banner_list");
        $row = $dataSet->getRow(0);

        $this->pcms->shouldReceive("apiv2")
            ->with("banners", array("position" => 8), "GET")
            ->andReturn($row);

        $bannerRepository = $this->getInstance();
        $res = $bannerRepository->getByPosition(8);

        $this->assertNotEmpty($res);
    }

    public function testGetByPositionWithMultiPositionThenReturnArrayData()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . "/../fixtures/banners.yml", "multi_get_by_position_banner");
        $row = $dataSet->getRow(0);

        $this->pcms->shouldReceive("apiv2")
            ->with("banners", array("position" => "8|9"), "GET")
            ->andReturn($row);

        $bannerRepository = $this->getInstance();
        $res = $bannerRepository->getByPosition(array(8, 9));

        $this->assertNotEmpty($res);
    }

    public function testGetBannerWithSinglePositionThenReturnDataArray()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . "/../fixtures/banners.yml", "multi_get_by_position_banner");
        $row = $dataSet->getRow(0);

        $this->pcms->shouldReceive("apiv2")
            ->with("banners", array("position" => 8), "GET")
            ->andReturn($row);

        $bannerRepository = $this->getInstance();
        $res = $bannerRepository->getBanner(8);

        $this->assertNotEmpty($res);
    }

    public function testGetBannerWithSinglePositionAndNoDataThenReturnEmptyArray()
    {

        $this->pcms->shouldReceive("apiv2")
            ->with("banners", array("position" => 8), "GET")
            ->andReturn(array());

        $bannerRepository = $this->getInstance();
        $res = $bannerRepository->getBanner(8);

        $this->assertNull($res);
    }

    public function testGetBannerWithMultiPositionThenReturnDataArray()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . "/../fixtures/banners.yml", "multi_get_by_position_banner");
        $row = $dataSet->getRow(0);

        $this->pcms->shouldReceive("apiv2")
            ->with("banners", array("position" => '8|9'), "GET")
            ->andReturn($row);

        $bannerRepository = $this->getInstance();
        $res = $bannerRepository->getBanner(array(8, 9));

        $this->assertNotEmpty($res);
    }


}