<?php

class AccordionBannerRepositoryTest extends TestCase
{

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

    private function getAccordionBannerData($row = 0)
    {
        $dataSet = $this->getYMLDataset(__DIR__."/../fixtures/banners.yml", "AccordionBannerData");
        return $dataSet->getRow($row);
    }

    public function testGetBannersThenReturnBannersData()
    {

        $data = $this->getAccordionBannerData();
        $this->pcms->shouldReceive("apiv2")
            ->andReturn($data);

        $accordionBannerRepository = App::make("AccordionBannerRepository");
        $res = $accordionBannerRepository->getBanners();

        $this->assertGreaterThanOrEqual(3, sizeof($res));
        $this->assertArrayHasKey("acc_banner1", $res);
        $this->assertArrayHasKey("acc_banner2", $res);
        $this->assertArrayHasKey("acc_banner3", $res);
    }

}