<?php

use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BrandsControllerTest extends TestCase
{
    protected $brand;
    protected $collectionRepoInt;
    public function setUp()
    {
        parent::setUp();

        $this->pcms = $this->mockSpecific('pcms');

        $dataset = $this->getYMLDataset(__DIR__ . '/../fixtures/brand.yml', 'brands');
        $brand_data = $dataset->getRow(0);

        //mock BrandRepository
        $this->brand = $this->mockSpecific('BrandRepositoryInterface');
        $this->brand->shouldReceive("getAll")
            ->andReturn($brand_data)
            ->shouldReceive("rearrange")
            ->withAnyArgs()
            ->andReturn(array());

        $this->collectionRepoInt = $this->mockSpecific('CollectionRepositoryInterface');
        $this->collectionRepoInt->shouldReceive("getAll")
            ->withAnyArgs()
            ->andReturn(NULL);

    }

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
        $teeplusTheme->shouldReceive("set")->andReturn(Mockery::self());        
        $teeplusTheme->shouldReceive("get")->andReturn(Mockery::self());        
        $teeplusTheme->shouldReceive("partialComposer")->andReturnUsing(function ($param1, $closure) use ($teeplusTheme) {
            $closure($teeplusTheme);
        });

        $teeplusTheme->shouldReceive("append")->andReturn(Mockery::self());


        return $teeplusTheme;
    }

    public function mockCachePage($cache=false)
    {
    	$CachePage = \Mockery::mock("alias:CachePage")
    		->shouldReceive("getResult")
    		->andReturn($cache)
    		->shouldReceive("save")
    		->andReturn(True);
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }


    public function testGetIndexEmptyCacheAndReturnData()
    {
        $this->mockCachePage(false);

    	$dataset = $this->getYMLDataset(__DIR__ . '/../fixtures/brand.yml', 'brands');
        $brand_data = $dataset->getRow(0);

        //mock BrandRepository
        $brandRepo = $this->mock('BrandRepositoryInterface');
        $brandRepo->shouldReceive("getAll")
        	->andReturn($brand_data)
        	->shouldReceive("rearrange")
        	->withAnyArgs()
        	->andReturn(array());

        //mock CollectionRepository
       	$collectionRepoInt = $this->mock('CollectionRepositoryInterface');
        $collectionRepoInt->shouldReceive("getAll")
			->withAnyArgs()
			->andReturn(NULL);

        $teeplusTheme = $this->mockTheme();
        $teeplusTheme->shouldReceive("render")->andReturn(Mockery::self());
        $teeplusTheme->shouldReceive('getContent')->andReturn('API-data');

		$brand = App::make('BrandsController');
    	$result = $brand->getIndex();
    	$this->assertTrue(isset($result));
	}

    public function testGetIndexReturnCache()
    {
        $this->mockCachePage(true);
        $this->mockTheme();

        $brandRepo = $this->mock('BrandRepositoryInterface');
        $collectionRepoInt = $this->mock('CollectionRepositoryInterface');

		$brand = App::make('BrandsController');
    	$result = $brand->getIndex();
    	$this->assertTrue($result);
    }

    public function testGetCollectionBrands()
    {
    	$this->mockTheme();
        $this->pcms->shouldReceive("api")
        	->withAnyArgs()
        	->andReturn(array());

    	$brandRepo = $this->mock('BrandRepositoryInterface');
    	$brandRepo->shouldReceive("rearrange")
    		->withAnyArgs()
    		->andReturn(array());

    	$collectionRepoInt = $this->mock('CollectionRepositoryInterface');
    	$collectionRepoInt->shouldReceive("getBrands")
    		->withAnyArgs()
    		->andReturn(NULL)
    		->shouldReceive("getAll")
    		->withAnyArgs()
    		->andReturn(NULL)
    		->shouldReceive("getByPkey")
    		->withAnyArgs()
    		->andReturn(array('data'=>array()));

    	$brand = App::make('BrandsController');
    	$result = $brand->getCollectionBrands('123');
    	// sd($result);
    	$this->assertTrue(isset($result));
    }

    public function testGetCollectionBrandsCollectionKeyNull()
    {
        $errorInstance = null;
        $this->mockTheme();
	
        try{

        	$brand = App::make('BrandsController');
        	$brand->getCollectionBrands(NULL);
        	
        }catch(NotFoundHttpException $e){
            $errorInstance = $e;
        }

        $this->assertInstanceOf("\Symfony\Component\HttpKernel\Exception\NotFoundHttpException", $errorInstance);

    }

}