<?php


class WidgetHomeShowroomTest extends \TestCase{

    public function setUp()
    {
        parent::setUp();

    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();

    }

    public function testInit(){
        $widgetHomeShowroomMock = App::make("WidgetHomeShowroom");
        $response = $widgetHomeShowroomMock->init();

        $this->assertNull($response);
    }

    public function testRunWithoutNoCacheParamThenGetShowroomData(){

        $dataset = $this->getYMLDataset(__DIR__ . '/../fixtures/showroom.yml', 'showroomrepository_getdata');
        $showroom_data = $dataset->getRow(0);

        $banner = $this->mockSpecific('ShowroomRepositoryInterface');
        $banner->shouldReceive('getData')->andReturn($showroom_data);

        $widgetHomeShowroomMock = App::make("WidgetHomeShowroom");
        $response = $widgetHomeShowroomMock->run();

        $this->assertArrayHasKey('slug', $response);
        $this->assertArrayHasKey('page', $response);
        $this->assertArrayHasKey('limit', $response);
        $this->assertArrayHasKey('display_next_page', $response);
        $this->assertArrayHasKey('next_page', $response);
        $this->assertArrayHasKey('showroom', $response);
        $this->assertArrayHasKey("total_page", $response);
        $this->assertArrayHasKey("no_cache", $response);

    }

    public function testRunWithNoCacheParamThenGetShowroomData(){

        $dataset = $this->getYMLDataset(__DIR__ . '/../fixtures/showroom.yml', 'showroomrepository_getdata');
        $showroom_data = $dataset->getRow(0);

        $banner = $this->mockSpecific('ShowroomRepositoryInterface');
        $banner->shouldReceive('getData')->andReturn($showroom_data);

        $widgetHomeShowroomMock = App::make("WidgetHomeShowroom");
        $widgetHomeShowroomMock->setAttribute("noCache", true);
        $response = $widgetHomeShowroomMock->run();

        $this->assertArrayHasKey('slug', $response);
        $this->assertArrayHasKey('page', $response);
        $this->assertArrayHasKey('limit', $response);
        $this->assertArrayHasKey('display_next_page', $response);
        $this->assertArrayHasKey('next_page', $response);
        $this->assertArrayHasKey('showroom', $response);
        $this->assertArrayHasKey("total_page", $response);
        $this->assertArrayHasKey("no_cache", $response);

    }


}