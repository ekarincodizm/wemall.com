<?php

class HomeControllerTest extends TestCase
{

    private $_showroomRepo = null;

    public function mockTheme()
    {
        $teeplusTheme = $this->getTeeplusThemeMock();

        $teeplusTheme->shouldReceive("asset")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive("writeContent")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive("setTitle")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive("container")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive("script")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive("writeScript")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive("breadcrumb")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive("add")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive("usePath")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive("setMetadescription")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive("setMetakeywords")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive("setCanonical")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive("scope")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive("with")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive("partialComposer")->andReturnUsing(function ($param1, $closure) use ($teeplusTheme) {
            $closure($teeplusTheme);
        });

        $teeplusTheme->shouldReceive("append")->andReturn(Mockery::self());


        return $teeplusTheme;
    }

    public function setUp()
    {
        parent::setUp();

        $this->_showroomRepo = $this->mockSpecific('ShowroomRepositoryInterface');
        $this->_showroomRepo->shouldReceive('deleteAllShowroomCache')->andReturn(null);
        $this->_showroomRepo->shouldReceive('getShowroomCacheKey')->andReturn("dummy_cache_key");
        $this->_showroomRepo->shouldReceive("getData")->andReturn(array("data"));
        $this->_showroomRepo->shouldReceive("getTotalPage")->andReturn(6);

        $this->AccordionBannerRepository = Mockery::mock('AccordionBannerRepositoryInterface');
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testHomeIndexWithCache()
    {
        Input::replace(array('no-cache' => 0));

        $mockCache = Mockery::mock('alias:ElastiCache');
        $mockCache->shouldReceive('getResult')->andReturn('CACHE-data');

        $teeplusTheme = $this->mockTheme();
        $teeplusTheme->shouldReceive("getContent")->andReturn("CACHE-data");
        $teeplusTheme->shouldReceive("render")->andReturn(Mockery::self());

        $this->homeController = App::make('HomeController');
        $response = $this->homeController->getIndex();

        $this->assertEquals(
            "CACHE-data",
            $response,
            'TEST home return cache - Reponse should equal to expected value.');
    }

    public function testHomeIndexWithEmptyCache()
    {
        Input::replace(array('no-cache' => 0));

        $mockCache = Mockery::mock('alias:ElastiCache');
        $mockCache->shouldReceive('getResult')->andReturn('');
        $mockCache->shouldReceive('save');

        $teeplusTheme = $this->mockTheme();
        $teeplusTheme->shouldReceive("render")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive('getContent')->andReturn('API-data');

        $this->homeController = App::make('HomeController');
        $response = $this->homeController->getIndex();

        $this->assertEquals(
            "API-data",
            $response,
            'TEST home return empty cache - Reponse should equal to expected value.');
    }

    public function testHomeIndexNoCache()
    {
        Input::replace(array('no-cache' => 1));

        $mockCache = Mockery::mock('alias:ElastiCache');
        $mockCache->shouldReceive('save');

        $teeplusTheme = $this->mockTheme();
        $teeplusTheme->shouldReceive("render")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive('getContent')->andReturn('success');

        $this->homeController = App::make('HomeController');
        $response = $this->homeController->getIndex();

        $this->assertEquals("success", $response, 'TEST home index no-cache=1 - Reponse should equal to expected value.');
    }

    public function testHomeGetShowroomWithCache()
    {
        Input::replace(array('no-cache' => 0));

        $mockCache = Mockery::mock('alias:ElastiCache');
        $mockCache->shouldReceive('getResult')->andReturn('CACHE-data');

        $teeplusTheme = $this->mockTheme();

        $this->homeController = App::make('HomeController');
        $response = $this->homeController->getShowroom();
        $response = json_decode($response->getContent(), true);

        $this->assertEquals(
            "CACHE-data",
            $response,
            'TEST home showroom with cache - Data should equal to expected value.');
    }

    public function testHomeGetShowroomWithCacheEmpty()
    {
        Input::replace(array('no-cache' => 0));

        $mockCache = Mockery::mock('alias:ElastiCache'); // $this->mock('ElastiCache');
        $mockCache->shouldReceive('getResult')->andReturn('');
        $mockCache->shouldReceive('save');

        $teeplusTheme = $this->mockTheme();
        $teeplusTheme->shouldReceive('widget')->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive('getAttribute')->with('page')->andReturn(1);
        $teeplusTheme->shouldReceive('render')->andReturn('API-data');
        $teeplusTheme->shouldReceive("run")->andReturn("API-data");

        $this->homeController = App::make('HomeController');
        $response = $this->homeController->getShowroom();
        $response = json_decode($response->getContent(), true);

        $this->assertEquals(
            "API-data",
            $response['data'],
            'TEST home showroom with empty cache data - Data should equal to expected value.');
    }

    public function testHomeGetShowroomWithNoCache()
    {
        Input::replace(array(
            'no-cache' => 1,
            'page' => 0,
        ));

        $mockCache = Mockery::mock('alias:ElastiCache');
        $mockCache->shouldReceive("save")->andReturn(true);

        $teeplusTheme = $this->mockTheme();
        $teeplusTheme->shouldReceive('widget')->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive('getAttribute')->with('page')->andReturn(1);
        $teeplusTheme->shouldReceive('render')->andReturn('API-data');
        $teeplusTheme->shouldReceive("asset")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive("run")->andReturn("API-data");

        $this->homeController = App::make('HomeController');
        $response = $this->homeController->getShowroom();
        $response = json_decode($response->getContent(), true);

        $this->assertEquals(
            "API-data",
            $response['data'],
            'TEST home showroom with no-cache=1 - Data should equal to expected value.');
    }

}
