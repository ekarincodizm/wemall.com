<?php

/**
 * Class ShowroomRepositoryTest
 */
class ShowroomRepositoryTest extends TestCase
{
    protected $layout_pattern = array(
        1 => array('B2' => 1, 'B3' => 2, 'B4' => 3, 'P1' => 4, 'P2' => 5, 'P3' => 6, 'P4' => 7, 'P5' => 8),
        2 => array('B2' => 1, 'P1' => 2, 'P2' => 3, 'P3' => 4, 'P4' => 5, 'P5' => 6, 'P6' => 7, 'P7' => 8),
        3 => array('B2' => 1, 'P1' => 2, 'P2' => 3, 'P3' => 4, 'P4' => 5, 'P5' => 6, 'P6' => 7, 'P7' => 8, 'P8' => 9, 'P9' => 10),
        4 => array('B2' => 1, 'B3' => 2, 'P1' => 3, 'P2' => 4, 'P3' => 5, 'P4' => 6, 'P5' => 7, 'P6' => 8),
        5 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'B2' => 6),
        6 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'P6' => 6, 'B2' => 7, 'B3' => 8),
        7 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'P6' => 6, 'B2' => 7, 'B3' => 8),
        8 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'P6' => 6),
        9 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'P6' => 6, 'B2' => 7),
        10 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'P6' => 6, 'P7' => 7),
        11 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'P6' => 6, 'P7' => 7, 'B2' => 8, 'B3' => 9),
        12 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'P6' => 6, 'P7' => 7, 'P8' => 8),
        13 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'P6' => 6, 'P7' => 7)
    );

    protected $expected_format = array(
        'showroom_title' => 'api-showroom-name',
        'showroom_url' => 'api-showroom-url',
        'layout_id' => '',
        'layout_format' => '',
        'banner' => '',
        'brand' => '',
        'product' => '',
    );

    protected function mockLog()
    {
        $ApiEventLogs = Mockery::mock('ApiEventLogs');
        $ApiEventLogs->shouldReceive('save')->andReturn(true);
    }

    protected function prepareShowroomWithLayout($layout_id)
    {
        // defined showroom data
        $dataset = $this->getYMLDataset(__DIR__ . '/../fixtures/showroom.yml', 'api_showroom');
        $showroom_data = $dataset->getRow(0);
        $showroom_data['layout_id'] = $layout_id;
        $showroom_data['layout_pattern'] = $this->layout_pattern[$layout_id];

        // defined api response
        $api_response = array();
        array_set($api_response, 'status', 'success');
        array_set($api_response, 'code', 200);
        array_set($api_response, 'message', '200 OK');
        array_set($api_response, 'data.total_page', 1);
        array_set($api_response, 'data.showroom.0', $showroom_data);

        return $api_response;
    }

    public function setUp()
    {
        parent::setUp();

        $this->pcmsClient = $this->mockSpecific('pcmsClient');
        App::shouldReceive('make')->andReturn($this->pcmsClient);

        $this->showroom = new ShowroomRepository();
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testResponseFormat()
    {
        $api_response = $this->prepareShowroomWithLayout(1);

        // mock api call
        $this->pcmsClient->shouldReceive('apiv2')->andReturn($api_response);
        $response = $this->showroom->getData(1);

        // since we defined all data in banner, brand, product
        // all data should not empty

        // data.showroom count should be 1
        $this->assertTrue(
            count(array_get($response, 'data.showroom')) == 1,
            '[!] data.showroom count should be 1'
        );

        // data.showroom.0.showroom_title should exist
        $this->assertTrue(
            array_get($response, 'data.showroom.0.showroom_title') == 'Showroom 01',
            '[!] data.showroom.0.showroom_title should exist.'
        );

        // data.showroom.0.showroom_link should exist
        $this->assertTrue(
            array_get($response, 'data.showroom.0.showroom_link') == 'showroom-01-url',
            '[!] data.showroom.0.showroom_link should exist.'
        );

        // data.showroom.0.layout_id should exist
        $this->assertTrue(
            array_get($response, 'data.showroom.0.layout_id') == 1,
            '[!] data.showroom.0.layout_id should exist.'
        );

        // data.showroom.0.layout_pattern should exist
        $this->assertTrue(
            array_get($response, 'data.showroom.0.layout_pattern', false) != false,
            '[!] data.showroom.0.layout_pattern should exist.'
        );

        // data.showroom.0.banner should exist
        $this->assertTrue(
            array_get($response, 'data.showroom.0.banner', false) != false,
            '[!] data.showroom.0.banner should exist.'
        );

        // data.showroom.0.brand should exist
        $this->assertTrue(
            array_get($response, 'data.showroom.0.brand', false) != false,
            '[!] data.showroom.0.brand should exist.'
        );

        // data.showroom.0.product should exist
        $this->assertTrue(
            array_get($response, 'data.showroom.0.product', false) != false,
            '[!] data.showroom.0.product should exist.'
        );
    }

    public function testApiResponseFail()
    {
        $api_response = $this->prepareShowroomWithLayout(1);

        // response code != 200
        $api_response['code'] = 404;

        // mock api call
        $this->pcmsClient->shouldReceive('apiv2')->andReturn($api_response);
        $response = $this->showroom->getData(1);

        $this->assertTrue(
            array_get($response, 'code') == 401,
            '[!] api error - error code should be 401.'
        );

        $this->assertTrue(
            array_get($response, 'status') == 'error',
            '[!] api error - error status should be "error".'
        );

        $this->assertTrue(
            array_get($response, 'message') == 'Not has code or code not equal 200 in showroom api',
            '[!] api error - error status should be "Not has code or code not equal 200 in showroom api".'
        );
    }

    public function testApiResponseEmptyData()
    {
        $api_response = $this->prepareShowroomWithLayout(1);

        // response code != 200
        $api_response['data'] = array();

        // mock api call
        $this->pcmsClient->shouldReceive('apiv2')->andReturn($api_response);
        $response = $this->showroom->getData(1);

        $this->assertTrue(
            array_get($response, 'code') == 402,
            '[!] api empty data - error code should be 402.'
        );

        $this->assertTrue(
            array_get($response, 'status') == 'error',
            '[!] api empty data - error status should be "error".'
        );

        $this->assertTrue(
            array_get($response, 'message') == 'Not has data node in showroom api',
            '[!] api empty data - error status should be "Not has data node in showroom api".'
        );
    }

    public function testApiShowroomDataNotFound()
    {
        $api_response = $this->prepareShowroomWithLayout(1);

        // remove data showroom
        unset($api_response['data']['showroom']);

        // mock api call
        $this->pcmsClient->shouldReceive('apiv2')->andReturn($api_response);
        $response = $this->showroom->getData(1);

        $this->assertTrue(
            array_get($response, 'code') == 401,
            '[!] api parse data - error code should be 401.'
        );

        $this->assertTrue(
            array_get($response, 'status') == 'error',
            '[!] api parse data - error status should be "error".'
        );

        $this->assertTrue(
            array_get($response, 'message') == 'Showroom data not found.',
            '[!] api parse data - error status should be "Showroom data not found.".'
        );
    }

    public function testNoBrand()
    {
        $api_response = $this->prepareShowroomWithLayout(1);

        $api_response['data']['showroom'][0]['url'] = '';

        $this->pcmsClient->shouldReceive('apiv2')->andReturn($api_response);
        $response = $this->showroom->getData(1);

        $this->assertTrue(
            array_get($response, 'data.showroom.0.showroom_link') != 'showroom-01-url',
            '[!] data.showroom.0.showroom_link should exist.'
        );
    }

    public function testNoShowroomURL()
    {
        $api_response = $this->prepareShowroomWithLayout(1);

        $api_response['data']['showroom'][0]['brand'] = array();

        $this->pcmsClient->shouldReceive('apiv2')->andReturn($api_response);
        $response = $this->showroom->getData(1);

        $this->assertTrue(
            array_get($response, 'data.showroom.0.brand') == array(),
            '[!] data.showroom.0.brand should empty.'
        );
    }

    public function testTotalPage()
    {
        $api_response = $this->prepareShowroomWithLayout(1);

        $api_response['data']['total_page'] = 2;

        $this->pcmsClient->shouldReceive('apiv2')->andReturn($api_response);
        $response = $this->showroom->getData(1);

        $this->assertTrue(
            $this->showroom->getTotalPage() == 2,
            '[!] Total page should be 2.'
        );
    }

    /*
    public function testLayout01()
    {
        $showroom_data = $this->prepareShowroom(1);
        $this->pcmsClient->shouldReceive('apiv2')->andReturn($showroom_data);
        $response = $this->showroom->getData(1);

        // 1 => array('B2' => 1, 'B3' => 2, 'B4' => 3, 'P1' => 4, 'P2' => 5, 'P3' => 6, 'P4' => 7, 'P5' => 8),
        $this->assertTrue($response['data']['showroom'][0]['product'][0]['position'] == 'B2', 'Position 1 should be B2.');
        $this->assertTrue($response['data']['showroom'][0]['product'][1]['position'] == 'B3', 'Position 2 should be B3.');
        $this->assertTrue($response['data']['showroom'][0]['product'][2]['position'] == 'B4', 'Position 3 should be B4.');
        $this->assertTrue($response['data']['showroom'][0]['product'][3]['position'] == 'P1', 'Position 4 should be P1.');
        $this->assertTrue($response['data']['showroom'][0]['product'][4]['position'] == 'P2', 'Position 5 should be P2.');
        $this->assertTrue($response['data']['showroom'][0]['product'][5]['position'] == 'P3', 'Position 6 should be P3.');
        $this->assertTrue($response['data']['showroom'][0]['product'][6]['position'] == 'P4', 'Position 7 should be P4.');
        $this->assertTrue($response['data']['showroom'][0]['product'][7]['position'] == 'P5', 'Position 8 should be P5.');
    }

    public function testLayout02()
    {
        $showroom_data = $this->prepareShowroom(1);
        $this->pcmsClient->shouldReceive('apiv2')->andReturn($showroom_data);
        $response = $this->showroom->getData(2);

        // 2 => array('B2' => 1, 'P1' => 2, 'P2' => 3, 'P3' => 4, 'P4' => 5, 'P5' => 6, 'P6' => 7, 'P7' => 8),
        $this->assertTrue($response['data']['showroom'][0]['product'][0]['position'] == 'B2', 'Position 1 should be B2.');
        $this->assertTrue($response['data']['showroom'][0]['product'][1]['position'] == 'P1', 'Position 2 should be P1.');
        $this->assertTrue($response['data']['showroom'][0]['product'][2]['position'] == 'P2', 'Position 3 should be P2.');
        $this->assertTrue($response['data']['showroom'][0]['product'][3]['position'] == 'P3', 'Position 4 should be P3.');
        $this->assertTrue($response['data']['showroom'][0]['product'][4]['position'] == 'P4', 'Position 5 should be P4.');
        $this->assertTrue($response['data']['showroom'][0]['product'][5]['position'] == 'P5', 'Position 6 should be P5.');
        $this->assertTrue($response['data']['showroom'][0]['product'][6]['position'] == 'P6', 'Position 7 should be P5.');
        $this->assertTrue($response['data']['showroom'][0]['product'][7]['position'] == 'P7', 'Position 8 should be P6.');
    }

    public function testLayout03()
    {
        $showroom_data = $this->prepareShowroom(1);
        $this->pcmsClient->shouldReceive('apiv2')->andReturn($showroom_data);
        $response = $this->showroom->getData(3);

        // 3 => array('B2' => 1, 'P1' => 2, 'P2' => 3, 'P3' => 4, 'P4' => 5, 'P5' => 6, 'P6' => 7, 'P7' => 8, 'P8' => 9, 'P9' => 10)
        $this->assertTrue($response['data']['showroom'][0]['product'][0]['position'] == 'B2', 'Position 1 should be B2.');
        $this->assertTrue($response['data']['showroom'][0]['product'][1]['position'] == 'P1', 'Position 2 should be P1.');
        $this->assertTrue($response['data']['showroom'][0]['product'][2]['position'] == 'P2', 'Position 3 should be P2.');
        $this->assertTrue($response['data']['showroom'][0]['product'][3]['position'] == 'P3', 'Position 4 should be P3.');
        $this->assertTrue($response['data']['showroom'][0]['product'][4]['position'] == 'P4', 'Position 5 should be P4.');
        $this->assertTrue($response['data']['showroom'][0]['product'][5]['position'] == 'P5', 'Position 6 should be P5.');
        $this->assertTrue($response['data']['showroom'][0]['product'][6]['position'] == 'P6', 'Position 7 should be P6.');
        $this->assertTrue($response['data']['showroom'][0]['product'][7]['position'] == 'P7', 'Position 8 should be P7.');
        $this->assertTrue($response['data']['showroom'][0]['product'][8]['position'] == 'P8', 'Position 8 should be P8.');
        $this->assertTrue($response['data']['showroom'][0]['product'][9]['position'] == 'P9', 'Position 8 should be P9.');
    }

    public function testLayout04()
    {
        $showroom_data = $this->prepareShowroom(1);
        $this->pcmsClient->shouldReceive('apiv2')->andReturn($showroom_data);
        $response = $this->showroom->getData(2);

        // 2 => array('B2' => 1, 'P1' => 2, 'P2' => 3, 'P3' => 4, 'P4' => 5, 'P5' => 6, 'P6' => 7, 'P7' => 8),
        $this->assertTrue($response['data']['showroom'][0]['product'][0]['position'] == 'B2', 'Position 1 should be B2.');
        $this->assertTrue($response['data']['showroom'][0]['product'][1]['position'] == 'P1', 'Position 2 should be P1.');
        $this->assertTrue($response['data']['showroom'][0]['product'][2]['position'] == 'P2', 'Position 3 should be P2.');
        $this->assertTrue($response['data']['showroom'][0]['product'][3]['position'] == 'P3', 'Position 4 should be P3.');
        $this->assertTrue($response['data']['showroom'][0]['product'][4]['position'] == 'P4', 'Position 5 should be P4.');
        $this->assertTrue($response['data']['showroom'][0]['product'][5]['position'] == 'P5', 'Position 6 should be P5.');
        $this->assertTrue($response['data']['showroom'][0]['product'][6]['position'] == 'P6', 'Position 7 should be P6.');
        $this->assertTrue($response['data']['showroom'][0]['product'][7]['position'] == 'P7', 'Position 8 should be P7.');
    }
    */

    public function testLayout05()
    {
        $api_response = $this->prepareShowroomWithLayout(5);

        $this->pcmsClient->shouldReceive('apiv2')->andReturn($api_response);
        $response = $this->showroom->getData(1);

        // 5 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'B2' => 6),
        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.1.position') == 'P1' &&
            array_get($response, 'data.showroom.0.product.1.box') == 1,
            'Layout 05 - Position 1 should be P1.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.2.position') == 'P2' &&
            array_get($response, 'data.showroom.0.product.2.box') == 2,
            'Layout 05 - Position 2 should be P2.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.3.position') == 'P3' &&
            array_get($response, 'data.showroom.0.product.3.box') == 3,
            'Layout 05 - Position 3 should be P3.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.4.position') == 'P4' &&
            array_get($response, 'data.showroom.0.product.4.box') == 4,
            'Layout 05 - Position 4 should be P4.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.5.position') == 'P5' &&
            array_get($response, 'data.showroom.0.product.5.box') == 5,
            'Layout 05 - Position 5 should be P5.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.0.position') == 'B2' &&
            array_get($response, 'data.showroom.0.product.0.box') == 6,
            'Layout 05 - Position 6 should be B2.');
    }

    public function testLayout06()
    {
        $api_response = $this->prepareShowroomWithLayout(6);

        $this->pcmsClient->shouldReceive('apiv2')->andReturn($api_response);
        $response = $this->showroom->getData(1);

        // 6 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'P6' => 6, 'B2' => 7, 'B3' => 8),
        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.2.position') == 'P1' &&
            array_get($response, 'data.showroom.0.product.2.box') == 1,
            'Layout 06 - Position 1 should be P1.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.3.position') == 'P2' &&
            array_get($response, 'data.showroom.0.product.3.box') == 2,
            'Layout 06 - Position 2 should be P2.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.4.position') == 'P3' &&
            array_get($response, 'data.showroom.0.product.4.box') == 3,
            'Layout 06 - Position 3 should be P3.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.5.position') == 'P4' &&
            array_get($response, 'data.showroom.0.product.5.box') == 4,
            'Layout 06 - Position 4 should be P4.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.6.position') == 'P5' &&
            array_get($response, 'data.showroom.0.product.6.box') == 5,
            'Layout 06 - Position 5 should be P5.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.7.position') == 'P6' &&
            array_get($response, 'data.showroom.0.product.7.box') == 6,
            'Layout 06 - Position 6 should be P6.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.0.position') == 'B2' &&
            array_get($response, 'data.showroom.0.product.0.box') == 7,
            'Layout 06 - Position 7 should be B2.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.1.position') == 'B3' &&
            array_get($response, 'data.showroom.0.product.1.box') == 8,
            'Layout 06 - Position 8 should be B3.');
    }

    public function testLayout07()
    {
        $api_response = $this->prepareShowroomWithLayout(7);

        $this->pcmsClient->shouldReceive('apiv2')->andReturn($api_response);
        $response = $this->showroom->getData(1);

        // 7 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'P6' => 6, 'B2' => 7, 'B3' => 8),
        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.2.position') == 'P1' &&
            array_get($response, 'data.showroom.0.product.2.box') == 1,
            'Layout 07 - Position 1 should be P1.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.3.position') == 'P2' &&
            array_get($response, 'data.showroom.0.product.3.box') == 2,
            'Layout 07 - Position 2 should be P2.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.4.position') == 'P3' &&
            array_get($response, 'data.showroom.0.product.4.box') == 3,
            'Layout 07 - Position 3 should be P3.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.5.position') == 'P4' &&
            array_get($response, 'data.showroom.0.product.5.box') == 4,
            'Layout 07 - Position 4 should be P4.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.6.position') == 'P5' &&
            array_get($response, 'data.showroom.0.product.6.box') == 5,
            'Layout 07 - Position 5 should be P5.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.7.position') == 'P6' &&
            array_get($response, 'data.showroom.0.product.7.box') == 6,
            'Layout 07 - Position 6 should be P6.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.0.position') == 'B2' &&
            array_get($response, 'data.showroom.0.product.0.box') == 7,
            'Layout 07 - Position 7 should be B2.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.1.position') == 'B3' &&
            array_get($response, 'data.showroom.0.product.1.box') == 8,
            'Layout 07 - Position 8 should be B3.');
    }

    public function testLayout08()
    {
        $api_response = $this->prepareShowroomWithLayout(8);

        $this->pcmsClient->shouldReceive('apiv2')->andReturn($api_response);
        $response = $this->showroom->getData(1);

        // 8 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'P6' => 6),
        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.0.position') == 'P1' &&
            array_get($response, 'data.showroom.0.product.0.box') == 1,
            'Layout 08 - Position 1 should be P1.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.1.position') == 'P2' &&
            array_get($response, 'data.showroom.0.product.1.box') == 2,
            'Layout 08 - Position 2 should be P2.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.2.position') == 'P3' &&
            array_get($response, 'data.showroom.0.product.2.box') == 3,
            'Layout 08 - Position 3 should be P3.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.3.position') == 'P4' &&
            array_get($response, 'data.showroom.0.product.3.box') == 4,
            'Layout 08 - Position 4 should be P4.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.4.position') == 'P5' &&
            array_get($response, 'data.showroom.0.product.4.box') == 5,
            'Layout 08 - Position 5 should be P5.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.5.position') == 'P6' &&
            array_get($response, 'data.showroom.0.product.5.box') == 6,
            'Layout 08 - Position 6 should be P6.');
    }

    public function testLayout09()
    {
        $api_response = $this->prepareShowroomWithLayout(9);

        $this->pcmsClient->shouldReceive('apiv2')->andReturn($api_response);
        $response = $this->showroom->getData(1);

        // 9 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'P6' => 6, 'B2' => 7),
        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.1.position') == 'P1' &&
            array_get($response, 'data.showroom.0.product.1.box') == 1,
            'Layout 09 - Position 1 should be P1.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.2.position') == 'P2' &&
            array_get($response, 'data.showroom.0.product.2.box') == 2,
            'Layout 09 - Position 2 should be P2.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.3.position') == 'P3' &&
            array_get($response, 'data.showroom.0.product.3.box') == 3,
            'Layout 09 - Position 3 should be P3.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.4.position') == 'P4' &&
            array_get($response, 'data.showroom.0.product.4.box') == 4,
            'Layout 09 - Position 4 should be P4.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.5.position') == 'P5' &&
            array_get($response, 'data.showroom.0.product.5.box') == 5,
            'Layout 09 - Position 5 should be P5.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.6.position') == 'P6' &&
            array_get($response, 'data.showroom.0.product.6.box') == 6,
            'Layout 09 - Position 6 should be P6.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.0.position') == 'B2' &&
            array_get($response, 'data.showroom.0.product.0.box') == 7,
            'Layout 09 - Position 7 should be B2.');
    }

    public function testLayout10()
    {
        $api_response = $this->prepareShowroomWithLayout(10);

        $this->pcmsClient->shouldReceive('apiv2')->andReturn($api_response);
        $response = $this->showroom->getData(1);

        // 10 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'P6' => 6, 'P7' => 7),
        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.0.position') == 'P1' &&
            array_get($response, 'data.showroom.0.product.0.box') == 1,
            'Layout 10 - Position 1 should be P1.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.1.position') == 'P2' &&
            array_get($response, 'data.showroom.0.product.1.box') == 2,
            'Layout 10 - Position 2 should be P2.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.2.position') == 'P3' &&
            array_get($response, 'data.showroom.0.product.2.box') == 3,
            'Layout 10 - Position 3 should be P3.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.3.position') == 'P4' &&
            array_get($response, 'data.showroom.0.product.3.box') == 4,
            'Layout 10 - Position 4 should be P4.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.4.position') == 'P5' &&
            array_get($response, 'data.showroom.0.product.4.box') == 5,
            'Layout 10 - Position 5 should be P5.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.5.position') == 'P6' &&
            array_get($response, 'data.showroom.0.product.5.box') == 6,
            'Layout 10 - Position 6 should be P6.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.6.position') == 'P7' &&
            array_get($response, 'data.showroom.0.product.6.box') == 7,
            'Layout 10 - Position 7 should be P7.');
    }

    public function testLayout11()
    {
        $api_response = $this->prepareShowroomWithLayout(11);

        $this->pcmsClient->shouldReceive('apiv2')->andReturn($api_response);
        $response = $this->showroom->getData(1);

        // 11 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'P6' => 6, 'P7' => 7, 'B2' => 8, 'B3' => 9),
        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.2.position') == 'P1' &&
            array_get($response, 'data.showroom.0.product.2.box') == 1,
            'Layout 11 - Position 1 should be P1.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.3.position') == 'P2' &&
            array_get($response, 'data.showroom.0.product.3.box') == 2,
            'Layout 11 - Position 2 should be P2.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.4.position') == 'P3' &&
            array_get($response, 'data.showroom.0.product.4.box') == 3,
            'Layout 11 - Position 3 should be P3.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.5.position') == 'P4' &&
            array_get($response, 'data.showroom.0.product.5.box') == 4,
            'Layout 11 - Position 4 should be P4.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.6.position') == 'P5' &&
            array_get($response, 'data.showroom.0.product.6.box') == 5,
            'Layout 11 - Position 5 should be P5.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.7.position') == 'P6' &&
            array_get($response, 'data.showroom.0.product.7.box') == 6,
            'Layout 11 - Position 6 should be P6.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.8.position') == 'P7' &&
            array_get($response, 'data.showroom.0.product.8.box') == 7,
            'Layout 11 - Position 7 should be P7.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.0.position') == 'B2' &&
            array_get($response, 'data.showroom.0.product.0.box') == 8,
            'Layout 11 - Position 8 should be B2.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.1.position') == 'B3' &&
            array_get($response, 'data.showroom.0.product.1.box') == 9,
            'Layout 11 - Position 9 should be B3.');
    }

    public function testLayout12()
    {
        $api_response = $this->prepareShowroomWithLayout(12);

        $this->pcmsClient->shouldReceive('apiv2')->andReturn($api_response);
        $response = $this->showroom->getData(1);

        // 12 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'P6' => 6, 'P7' => 7, 'P8' => 8),
        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.0.position') == 'P1' &&
            array_get($response, 'data.showroom.0.product.0.box') == 1,
            'Layout 12 - Position 1 should be P1.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.1.position') == 'P2' &&
            array_get($response, 'data.showroom.0.product.1.box') == 2,
            'Layout 12 - Position 2 should be P2.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.2.position') == 'P3' &&
            array_get($response, 'data.showroom.0.product.2.box') == 3,
            'Layout 12 - Position 3 should be P3.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.3.position') == 'P4' &&
            array_get($response, 'data.showroom.0.product.3.box') == 4,
            'Layout 12 - Position 4 should be P4.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.4.position') == 'P5' &&
            array_get($response, 'data.showroom.0.product.4.box') == 5,
            'Layout 12 - Position 5 should be P5.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.5.position') == 'P6' &&
            array_get($response, 'data.showroom.0.product.5.box') == 6,
            'Layout 12 - Position 6 should be P6.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.6.position') == 'P7' &&
            array_get($response, 'data.showroom.0.product.6.box') == 7,
            'Layout 12 - Position 7 should be P7.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.7.position') == 'P8' &&
            array_get($response, 'data.showroom.0.product.7.box') == 8,
            'Layout 12 - Position 8 should be P8.');
    }

    public function testLayout13()
    {
        $api_response = $this->prepareShowroomWithLayout(13);

        $this->pcmsClient->shouldReceive('apiv2')->andReturn($api_response);
        $response = $this->showroom->getData(1);

        // 13 => array('P1' => 1, 'P2' => 2, 'P3' => 3, 'P4' => 4, 'P5' => 5, 'P6' => 6, 'P7' => 7),
        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.0.position') == 'P1' &&
            array_get($response, 'data.showroom.0.product.0.box') == 1,
            'Layout 13 - Position 1 should be P1.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.1.position') == 'P2' &&
            array_get($response, 'data.showroom.0.product.1.box') == 2,
            'Layout 13 - Position 2 should be P2.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.2.position') == 'P3' &&
            array_get($response, 'data.showroom.0.product.2.box') == 3,
            'Layout 13 - Position 3 should be P3.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.3.position') == 'P4' &&
            array_get($response, 'data.showroom.0.product.3.box') == 4,
            'Layout 13 - Position 4 should be P4.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.4.position') == 'P5' &&
            array_get($response, 'data.showroom.0.product.4.box') == 5,
            'Layout 13 - Position 5 should be P5.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.5.position') == 'P6' &&
            array_get($response, 'data.showroom.0.product.5.box') == 6,
            'Layout 13 - Position 6 should be P6.');

        $this->assertTrue(
            array_get($response, 'data.showroom.0.product.6.position') == 'P7' &&
            array_get($response, 'data.showroom.0.product.6.box') == 7,
            'Layout 13 - Position 7 should be P7.');
    }

    public function testGetShowroomCacheKeyMethodThenReturnCacheKeyString()
    {

        $domain = "domain";
        $page = 1;
        $lang = 'th';

        Request::shouldReceive("server")->andReturn($domain);
        Lang::shouldReceive("locale")->andReturn($lang);

        $showroomCacheKey = $this->showroom->getShowroomCacheKey($page);

        $expected = $domain . "_showroomajax_cachekey_unique_" . $lang . "_" . $page;
        $this->assertEquals($expected, $showroomCacheKey);
    }

    public function testDeleteAllShowroomCacheMethodThenReturnNull()
    {


        $domain = "domain";
        $page = 1;
        $lang = 'th';
        $showroomCacheKey = $domain . "_showroomajax_cachekey_unique_" . $lang . "_" . $page;
        $cacheKeys = array(
            $showroomCacheKey,
            "not_showroom_cache_1",
            "not_showroom_cache_2"
        );

        Request::shouldReceive("server")->andReturn($domain);
        Lang::shouldReceive("locale")->andReturn($lang);


        $mockCache = Mockery::mock('alias:ElastiCache');
        $mockCache->shouldReceive('getAllKeys')->withNoArgs()->andReturn($cacheKeys);
        $mockCache->shouldReceive('remove')->with($showroomCacheKey)->andReturn($cacheKeys);

        $res = $this->showroom->deleteAllShowroomCache();
        $this->assertEquals($res, null);
    }
}
