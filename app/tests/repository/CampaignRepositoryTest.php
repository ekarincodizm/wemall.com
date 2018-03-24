<?php

class CampaignRepositoryTest extends TestCase
{
    private $pcms;
    protected $mainClass = "CampaignRepository";

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

    public function testGetLineCampaignWithValidIdThenReturnArrayData()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . "/../fixtures/line-campaign.yml", "line_campaign");
        $row = $dataSet->getRow(0);

        $this->pcms->shouldReceive("api")
            ->andReturn($row);

        $campaignRepository = $this->getInstance();
        $res = $campaignRepository->getLineCampaign(71);

        $this->assertNotEmpty($res);
        $this->assertArrayHasKey("campaign_name", $res["data"]);
        $this->assertArrayHasKey("content", $res["data"]);
        $this->assertArrayHasKey("status", $res["data"]);
    }

    public function testGetLineCampaignWithInvalidIdThenThrowException()
    {
        $this->pcms->shouldReceive("api")
            ->andThrow(new Exception("Custom Exception", 400));

        $campaignRepository = $this->getInstance();
        $res = $campaignRepository->getLineCampaign("");

        $this->assertNotEmpty($res);
        $this->assertArrayHasKey("status", $res);
        $this->assertArrayHasKey("message", $res);
    }

    public function testDeleteCartThenReturnTrue()
    {
        $this->pcms->shouldReceive("deleteCart")
            ->andReturn(true);

        $campaignRepository = $this->getInstance();
        $res = $campaignRepository->deleteCart();

        $this->assertTrue($res);
    }

    public function testDeleteCartThenReturnFalse()
    {
        $this->pcms->shouldReceive("deleteCart")
            ->andReturn(false);

        $campaignRepository = $this->getInstance();
        $res = $campaignRepository->deleteCart();

        $this->assertFalse($res);
    }

    public function test_getMerchantWithEmptyValue()
    {
        $prefix = 'data-prefix';
        $previews = '';
        $nocache = false;

        $this->pcms = $this->mockSpecific('pcmsClient');
        App::shouldReceive('make')->andReturn( $this->pcms );
        $this->pcms->shouldReceive('api')->andReturn(
            array(
                'message' => 'mock-data',
                'code' => 404
            )
        );

        $CampaignRepository = new CampaignRepository();
        $json_result = $CampaignRepository->getMerchantLandingPage($prefix, $previews, $nocache);
        $this->assertEquals($json_result, array(
            'status' => 404,
            'message' => 'mock-data',
        ) );
    }

    public function test_getMerchantWithhasValue()
    {
        $prefix = 'data-prefix';
        $previews = '';
        $nocache = false;

        $this->pcms = $this->mockSpecific('pcmsClient');
        App::shouldReceive('make')->andReturn( $this->pcms );
        $this->pcms->shouldReceive('api')->andReturn(
            array(
                'data' => 'mock-data',
                'code' => 200
            )
        );

        $CampaignRepository = new CampaignRepository();
        $json_result = $CampaignRepository->getMerchantLandingPage($prefix, $previews, $nocache);
        $this->assertEquals($json_result, array(
            'data' => 'mock-data',
            'code' => 200
        ) );
    }
}
