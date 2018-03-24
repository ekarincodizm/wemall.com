<?php

class EverydayWowControllerTest extends TestCase
{

    /**
     * @var EverydayWowController
     */
    protected $everydayWowController;

    /**
     * @var EverydaywowRepository
     */
    protected $everydaywowRepository;

    public function setUp()
    {
        parent::setUp();

        $this->pcms = $this->mockSpecific('pcms');
        $this->product = $this->mockSpecific('ProductRepositoryInterface');
        $this->customerAddress = $this->mockSpecific('CustomerAddressRepositoryInterface');
        $this->mockApiEventLogs = $this->mock('ApiEventLogs');
        $this->mockApiEventLogs->shouldReceive('setAttribute');

        $this->mockTheme();
    }

    public function mockTheme()
    {
        $this->teeplusTheme = $this->getTeeplusThemeMock();

        $this->teeplusTheme->shouldReceive("asset")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("writeContent")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("setTitle")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("container")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("script")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("writeScript")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("breadcrumb")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("add")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("usePath")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("setMetadescription")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("setMetakeywords")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("setCanonical")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("scope")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("with")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("layout")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("render");

        $teeplusTheme = $this->teeplusTheme;
        $this->teeplusTheme->shouldReceive("partialComposer")->andReturnUsing(function ($param1, $closure) use ($teeplusTheme) {
            $closure($teeplusTheme);
        });
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testCallFromHttp()
    {
        //$this->setUp();
        $params['page'] = 1;
        $params['order'] = 'desc';
        $params['orderBy'] = 'discount_start';
        $params['responseWith'] = array( 'category', 'product', 'pagination' );
        $this->mockRequestParams($params);

        $this->everydaywowRepository = $this->mockSpecific('EverydaywowRepositoryInterface');
        $this->everydaywowRepository->shouldReceive('getData')->andReturn('TEST');

        $ElastiCacheMock = Mockery::mock('alias:ElastiCache');
        $ElastiCacheMock->shouldReceive("getResult")
            ->andReturnNull()
            ->shouldReceive("save")
            ->andReturnNull(true);

        $this->everydayWowController = App::make('EverydayWowController');
        $this->everydayWowController->getIndex();
        $this->assertTrue( true );
    }

    public function testCallFromXMLHttp()
    {
        $params['page'] = 1;
        $params['order'] = 'desc';
        $params['orderBy'] = 'discount_start';
        $params['responseWith'] = array( 'category', 'product', 'pagination' );
        $this->mockRequestParams($params);

        Request::shouldReceive('server');
        Request::shouldReceive('input');
        Request::shouldReceive('ajax')->andReturn( true );
        Request::shouldReceive('has')->andReturn( false );

        $ElastiCacheMock = Mockery::mock('alias:ElastiCache');
        $ElastiCacheMock->shouldReceive("getResult")
            ->andReturnNull()
            ->shouldReceive("save")
            ->andReturnNull(true);

        $this->everydaywowRepository = $this->mockSpecific('EverydaywowRepositoryInterface');
        $this->everydaywowRepository->shouldReceive('getData')->andReturn('{"x":1}');

        $this->everydayWowController = App::make('EverydayWowController');
        $this->everydayWowController->getIndex();
        $this->assertTrue( true );
    }
    private function mockRequestParams($params)
    {
//        $mockInput = Mockery::mock('\Illuminate\Http\Request');
//        $mockInput->shouldReceive('get')->with('page')->andReturn( $params['page'] );
//        $mockInput->shouldReceive('get')->with('order')->andReturn( $params['order'] );
//        $mockInput->shouldReceive('get')->with('orderBy')->andReturn( $params['orderBy'] );
//        $mockInput->shouldReceive('get')->with('responseWith')->andReturn( $params['responseWith'] );
        Input::merge( $params );
    }
}
