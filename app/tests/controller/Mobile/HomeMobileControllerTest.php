<?php

class HomeMobileControllerTest extends \TestCase
{

    private $_teeplusTheme = null;

    public function setUp()
    {
        parent::setUp();

        $banner = $this->mockSpecific('BannerRepositoryInterface');
        $banner->shouldReceive('getByPosition')->andReturn(array("banner data"));

        $this->_showroomRepo = $this->mockSpecific('ShowroomRepositoryInterface');
        $this->_showroomRepo->shouldReceive('deleteAllShowroomCache')->andReturn(null);
        $this->_showroomRepo->shouldReceive('getShowroomCacheKey')->andReturn("dummy_cache_key");
        $this->_showroomRepo->shouldReceive("getData")->andReturn(array("data"));
        $this->_showroomRepo->shouldReceive("getTotalPage")->andReturn(6);

        $this->MockTheme();
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();

    }

    public function testGetIndexMethodWithCacheThenRenderView()
    {

        Input::replace(array("no-cache"=>false));

        //mock teeplus theme.
        $this->mockTeeplusTheme();

        $ItmMemcachedMock = Mockery::mock('alias:ElastiCache');
        $ItmMemcachedMock->shouldReceive("getResult")
            ->andReturn("success");

        $homeController = App::make('\Mobile\HomeController');
        $res = $homeController->getIndex();

        $this->assertEquals("success", $res);
    }

    public function testGetIndexMethodWithNoCacheThenRenderView()
    {
        Input::replace(array("no-cache"=>true));

        //mock teeplus theme.

        $ItmMemcachedMock = Mockery::mock('alias:ElastiCache');
        $ItmMemcachedMock->shouldReceive("getResult")
            ->andReturnNull();
        $ItmMemcachedMock->shouldReceive("render")
            ->andReturn(\Mockery::self());
        $ItmMemcachedMock->shouldReceive("getContent")
            ->andReturn('success');
        $ItmMemcachedMock->shouldReceive("save")
            ->andReturn(true);

        //mock teeplus theme.
        $this->mockTeeplusTheme("success", "getContent");

        $homeController = App::make('\Mobile\HomeController');
        $res = $homeController->getIndex();

        $this->assertEquals("success", $res);
    }


    /**
     * @param string $renderResponse
     * @param string $responseOn (Options: render|getContent)
     * @return null|Object
     */
    private function mockTeeplusTheme($renderResponse = "success", $responseOn = "render")
    {
        $this->_teeplusTheme = $this->getTeeplusThemeMock();
        $this->_teeplusTheme->shouldReceive("asset")->andReturn(Mockery::self());
        $this->_teeplusTheme->shouldReceive("writeContent")->andReturn(Mockery::self());
        $this->_teeplusTheme->shouldReceive("setTitle")->andReturn(Mockery::self());
        $this->_teeplusTheme->shouldReceive("container")->andReturn(Mockery::self());
        $this->_teeplusTheme->shouldReceive("script")->andReturn(Mockery::self());
        $this->_teeplusTheme->shouldReceive("writeScript")->andReturn(Mockery::self());
        $this->_teeplusTheme->shouldReceive("breadcrumb")->andReturn(Mockery::self());
        $this->_teeplusTheme->shouldReceive("add")->andReturn(Mockery::self());
        $this->_teeplusTheme->shouldReceive("usePath")->andReturn(Mockery::self());
        $this->_teeplusTheme->shouldReceive("setMetadescription")->andReturn(Mockery::self());
        $this->_teeplusTheme->shouldReceive("setMetakeywords")->andReturn(Mockery::self());
        $this->_teeplusTheme->shouldReceive("setCanonical")->andReturn(Mockery::self());
        $this->_teeplusTheme->shouldReceive("scope")->andReturn(Mockery::self());
        $this->_teeplusTheme->shouldReceive("with")->andReturn(Mockery::self());
        $teeplusTheme = $this->_teeplusTheme;
        $this->_teeplusTheme->shouldReceive("partialComposer")->andReturnUsing(function ($param1, $closure) use ($teeplusTheme) {
            $closure($teeplusTheme);
        });
        $this->_teeplusTheme->shouldReceive("widget")->andReturn(Mockery::self());
        $this->_teeplusTheme->shouldReceive("getAttribute")->andReturn(2);
        if($responseOn == "getContent"){
            $this->_teeplusTheme->shouldReceive("append")->andReturn(\Mockery::self());
            $this->_teeplusTheme->shouldReceive("render")->andReturn(\Mockery::self());
            $this->_teeplusTheme->shouldReceive("getContent")->andReturn($renderResponse);
        }else{
            $this->_teeplusTheme->shouldReceive("render")->andReturn($renderResponse);
        }


        return $this->_teeplusTheme;
    }


    public function testGetHomeAjaxThenReturnCachedData()
    {


        Input::replace(array(
                'page' => 1,
                'no-cache' => NULL
            )
        );

        $dummyResponse = json_encode(array("page"=>1, "status"=>"success", "data"=>"<div>dummy</div>"));

        // mock theme
        $this->mockTeeplusTheme();

        //mock ElastiCache
        $ItmMemcachedMock = Mockery::mock('alias:ElastiCache');
        $ItmMemcachedMock->shouldReceive("getResult")
            ->andReturn($dummyResponse);


        $homeController = App::make('\Mobile\HomeController');
        $res = $homeController->getHomeAjax();


        $this->assertEquals($dummyResponse, $res);
        $resArray = json_decode($res, true);
        $this->assertArrayHasKey('page', $resArray);
        $this->assertArrayHasKey('status', $resArray);
        $this->assertArrayHasKey('data', $resArray);
    }


    public function testGetHomeAjaxThenReturnAPIData()
    {

        Input::replace(array(
                'page' => 2,
                'no-cache' => NULL
            )
        );

        $dummyResponse = array("page"=>2, "status"=>"success", "data"=>"<div>dummy</div>");

        // mock theme
        $this->mockTeeplusTheme($dummyResponse);

        //mock ElastiCache
        $ItmMemcachedMock = Mockery::mock('alias:ElastiCache');
        $ItmMemcachedMock->shouldReceive("getResult")
            ->andReturnNull();
        $ItmMemcachedMock->shouldReceive("save")
            ->andReturn(true);

        $homeController = App::make('\Mobile\HomeController');
        $res = $homeController->getHomeAjax();



        $this->assertInstanceOf("Illuminate\Http\JsonResponse", $res);
        $resArray = $res->getData(true);
        $this->assertArrayHasKey('page', $resArray);
        $this->assertArrayHasKey('status', $resArray);
        $this->assertArrayHasKey('data', $resArray);
    }
}