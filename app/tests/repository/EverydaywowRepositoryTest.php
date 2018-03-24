<?php

class EverydaywowRepositoryTest extends TestCase
{
    /**
     * @var \PcmsClient
     */
    protected $pcms;

    public function setUp() {
        parent::setUp();

        $this->pcms = $this->mockSpecific("pcms");
    }

    public function testValidateSuccess() {
        $validator = Validator::shouldReceive('make')->andReturn(Mockery::self());
        $validator->shouldReceive('fails')->andReturn(false);

        $this->prepareProtectedMethod('EverydaywowRepository', 'validateParams');
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Error JA
     */
    public function testValidateException() {
        $validator = Validator::shouldReceive('make')->andReturn(Mockery::self());
        $validator->shouldReceive('fails')->andReturn(true);
        $validator->shouldReceive('messages')->andReturn(Mockery::self());
        $validator->shouldReceive('first')->andReturn('Error JA');

        $this->prepareProtectedMethod('EverydaywowRepository', 'validateParams');
    }

    protected function prepareEverydayWowResponse()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . "/../fixtures/everydaywow.yml", "everydaywow");
        return $dataSet->getRow(0);
    }

    public function testParseDataEmptyRaw() {
        $expectedData = array();
        $rawData = array();
        $resultData = $this->prepareProtectedMethod('EverydaywowRepository', 'parseData', array($rawData));

        $this->assertEquals($expectedData, $resultData);
    }

    public function testParseData_DiscountIconDefault() {
        $expectedData = array();
        array_set($expectedData, 'tagIcon', 'label-red-1.png');
        array_set($expectedData, 'discount_icon', 'something-stupid');
        array_set($expectedData, 'tagCls', 'label-red');
        array_set($expectedData, 'isLineCampaign', false);

        $rawData = $this->prepareEverydayWowResponse();
        array_set($rawData, 'data.product_data.0.discount_title', '');
        array_set($rawData, 'data.product_data.0.discount_icon', 'something-stupid');

        $resultData = $this->prepareProtectedMethod('EverydaywowRepository', 'parseData', array($rawData));

        $this->assertEquals(
            array_get($expectedData, 'tagIcon'),
            array_get($resultData, 'data.product_data.0.tagIcon'),
            'tagIcon should equal to label-red-1 if discount_title is empty.'
        );

        $this->assertEquals(
            array_get($expectedData, 'discount_icon'),
            array_get($resultData, 'data.product_data.0.discount_icon')
        );

        $this->assertEquals(
            array_get($expectedData, 'tagCls'),
            array_get($resultData, 'data.product_data.0.tagCls')
        );

        $this->assertEquals(
            array_get($expectedData, 'isLineCampaign'),
            array_get($resultData, 'data.product_data.0.isLineCampaign')
        );
    }

    public function testParseData_DiscountIconNone() {
        $expectedData = array();
        array_set($expectedData, 'tagIcon', 'label-red-1.png');
        array_set($expectedData, 'discount_icon', 'none');
        array_set($expectedData, 'tagCls', 'label-red');
        array_set($expectedData, 'isLineCampaign', false);

        $rawData = $this->prepareEverydayWowResponse();
        array_set($rawData, 'data.product_data.0.discount_title', '');
        unset($rawData['data']['product_data'][0]['discount_icon']);

        $resultData = $this->prepareProtectedMethod('EverydaywowRepository', 'parseData', array($rawData));

        $this->assertEquals(
            array_get($expectedData, 'tagIcon'),
            array_get($resultData, 'data.product_data.0.tagIcon'),
            'tagIcon should equal to label-red-1 if discount_title is empty.'
        );

        $this->assertEquals(
            array_get($expectedData, 'discount_icon'),
            array_get($resultData, 'data.product_data.0.discount_icon')
        );

        $this->assertEquals(
            array_get($expectedData, 'tagCls'),
            array_get($resultData, 'data.product_data.0.tagCls')
        );

        $this->assertEquals(
            array_get($expectedData, 'isLineCampaign'),
            array_get($resultData, 'data.product_data.0.isLineCampaign')
        );
    }

    public function testParseData_DiscountIconTMVH() {
        $expectedData = array();
        array_set($expectedData, 'tagIcon', 'label-green-1.png');
        array_set($expectedData, 'discount_icon', 'tmvh');
        array_set($expectedData, 'tagCls', 'label-green');
        array_set($expectedData, 'isLineCampaign', true);
        array_set($expectedData, 'logo', 'line-truemove.png');
        array_set($expectedData, 'descriptionLogo', 'iTruemart line truemove');

        $rawData = $this->prepareEverydayWowResponse();
        array_set($rawData, 'data.product_data.0.discount_title', '');
        array_set($rawData, 'data.product_data.0.discount_icon', 'tmvh');

        $resultData = $this->prepareProtectedMethod('EverydaywowRepository', 'parseData', array($rawData));

        $this->assertEquals(
            array_get($expectedData, 'tagIcon'),
            array_get($resultData, 'data.product_data.0.tagIcon'),
            'tagIcon should equal to label-red-1 if discount_title is empty.'
        );

        $this->assertEquals(
            array_get($expectedData, 'discount_icon'),
            array_get($resultData, 'data.product_data.0.discount_icon')
        );

        $this->assertEquals(
            array_get($expectedData, 'tagCls'),
            array_get($resultData, 'data.product_data.0.tagCls')
        );

        $this->assertEquals(
            array_get($expectedData, 'isLineCampaign'),
            array_get($resultData, 'data.product_data.0.isLineCampaign')
        );

        $this->assertEquals(
            array_get($expectedData, 'logo'),
            array_get($resultData, 'data.product_data.0.logo')
        );

        $this->assertEquals(
            array_get($expectedData, 'descriptionLogo'),
            array_get($resultData, 'data.product_data.0.descriptionLogo')
        );
    }

    public function testParseData_DiscountIconTrueU() {
        $expectedData = array();
        array_set($expectedData, 'tagIcon', 'label-green-1.png');
        array_set($expectedData, 'discount_icon', 'trueu');
        array_set($expectedData, 'tagCls', 'label-green');
        array_set($expectedData, 'isLineCampaign', true);
        array_set($expectedData, 'logo', 'line-trueyou.png');
        array_set($expectedData, 'descriptionLogo', 'iTruemart line trueyou');

        $rawData = $this->prepareEverydayWowResponse();
        array_set($rawData, 'data.product_data.0.discount_title', '');
        array_set($rawData, 'data.product_data.0.discount_icon', 'trueu');

        $resultData = $this->prepareProtectedMethod('EverydaywowRepository', 'parseData', array($rawData));

        $this->assertEquals(
            array_get($expectedData, 'tagIcon'),
            array_get($resultData, 'data.product_data.0.tagIcon'),
            'tagIcon should equal to label-red-1 if discount_title is empty.'
        );

        $this->assertEquals(
            array_get($expectedData, 'discount_icon'),
            array_get($resultData, 'data.product_data.0.discount_icon')
        );

        $this->assertEquals(
            array_get($expectedData, 'tagCls'),
            array_get($resultData, 'data.product_data.0.tagCls')
        );

        $this->assertEquals(
            array_get($expectedData, 'isLineCampaign'),
            array_get($resultData, 'data.product_data.0.isLineCampaign')
        );

        $this->assertEquals(
            array_get($expectedData, 'logo'),
            array_get($resultData, 'data.product_data.0.logo')
        );

        $this->assertEquals(
            array_get($expectedData, 'descriptionLogo'),
            array_get($resultData, 'data.product_data.0.descriptionLogo')
        );
    }

    public function testParseData_DiscountIconNone_EmptyDiscountTitle() {
        $expectedData = array();
        array_set($expectedData, 'tagIcon', 'label-red-1.png');

        $rawData = $this->prepareEverydayWowResponse();
        array_set($rawData, 'data.product_data.0.discount_title', '');
        array_set($rawData, 'data.product_data.0.discount_icon', 'none');

        $resultData = $this->prepareProtectedMethod('EverydaywowRepository', 'parseData', array($rawData));

        $this->assertEquals(
            array_get($expectedData, 'tagIcon'),
            array_get($resultData, 'data.product_data.0.tagIcon'),
            'tagIcon should equal to label-red-1 if discount_title is empty.'
        );
    }

    public function testParseData_DiscountIconNone_HasDiscountTitle() {
        $expectedData = array();
        array_set($expectedData, 'tagIcon', 'label-red-2.png');

        $rawData = $this->prepareEverydayWowResponse();
        array_set($rawData, 'data.product_data.0.discount_title', 'something-stupic');
        array_set($rawData, 'data.product_data.0.discount_icon', 'none');

        $resultData = $this->prepareProtectedMethod('EverydaywowRepository', 'parseData', array($rawData));

        $this->assertEquals(
            array_get($expectedData, 'tagIcon'),
            array_get($resultData, 'data.product_data.0.tagIcon'),
            'tagIcon should equal to label-red-2 if discount_title is not empty.'
        );
    }

    public function testGetDataSuccess() {
        $options = array();
        array_set($options, 'lang', 'th');
        array_set($options, 'nocache', false);
        array_set($options, 'page', 1);
        array_set($options, 'limit', 6);
        array_set($options, 'filter', 'all');
        array_set($options, 'sortby', 'published_at');
        array_set($options, 'orderby', 'desc');
        array_set($options, 'response', '');

        $expectedData = array();
        array_set($expectedData, 'code', 200);

        $responseData = $this->prepareEverydayWowResponse();

        $this->pcms->shouldReceive('apiV5')->andReturn($responseData);

        $everydaywowRepository = new EverydaywowRepository();
        $resultData = $everydaywowRepository->getData($options);

        $this->assertEquals(
            array_get($expectedData, 'code'),
            array_get($resultData, 'code')
        );
    }

    public function testGetDataException() {
        $options = array();
        array_set($options, 'lang', 'th');
        array_set($options, 'nocache', false);
        array_set($options, 'page', 1);
        array_set($options, 'limit', 6);
        array_set($options, 'filter', 'all');
        array_set($options, 'sortby', 'published_at');
        array_set($options, 'orderby', 'desc');
        array_set($options, 'response', '');

        $expectedData = array();
        array_set($expectedData, 'code', 400);
        array_set($expectedData, 'status', 'error');
        array_set($expectedData, 'message', 'Not found data.');

        $responseData = $this->prepareEverydayWowResponse();
        array_set($responseData, 'code', 500);

        $this->pcms->shouldReceive('apiV5')->andReturn($responseData);

        $everydaywowRepository = new EverydaywowRepository();
        $resultData = $everydaywowRepository->getData($options);

        $this->assertEquals(
            array_get($expectedData, 'code'),
            array_get($resultData, 'code')
        );
        $this->assertEquals(
            array_get($expectedData, 'status'),
            array_get($resultData, 'status')
        );
        $this->assertEquals(
            array_get($expectedData, 'message'),
            array_get($resultData, 'message')
        );

    }
}
