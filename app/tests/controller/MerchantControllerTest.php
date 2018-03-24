<?php
/**
 * Created by PhpStorm.
 * User: iannannant
 * Date: 7/7/15 AD
 * Time: 4:05 PM
 */

class MerchantControllerTest extends TestCase {

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        Mockery::close();
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
        $this->teeplusTheme->shouldReceive("render");

        $teeplusTheme = $this->teeplusTheme;
        $this->teeplusTheme->shouldReceive("partialComposer")->andReturnUsing(function ($param1, $closure) use ($teeplusTheme) {
            $closure($teeplusTheme);
        });
    }

    public function test_landingPage_emptyPrefix()
    {
        $prefix = '';

        $this->mockTheme();
        $CampaignRepository = Mockery::mock('CampaignRepository');

        $MerchantController = App::make('MerchantController', array($CampaignRepository));
        Redirect::shouldReceive('to')->andReturn('/404.html');

        $json_result = $MerchantController->landingPage($prefix);
        $this->assertEquals('/404.html', $json_result);
    }

    public function test_landingPage_hasPrefixhasPreviewsWithhasValue()
    {
        $prefix = 'data-prefix';
        $input['previews'] = '';
        $input['no-cache'] = 1;

        Input::replace($input);

        $mockCache = Mockery::mock('alias:ElastiCache');
        $mockCache->shouldReceive('getResult')->andReturn(false);
        $mockCache->shouldReceive('save');
        $this->mockTheme();
        $CampaignRepository = Mockery::mock('CampaignRepository');
        $CampaignRepository->shouldReceive('getMerchantLandingPage')->andReturn(
           array(
               'data' => array(
                    'campaign_name' => 'mock-campaign_name'
               ),
               'status' => 'success',
               'code' => 200
           )
        );
        $MerchantController = App::make('MerchantController', array($CampaignRepository));
        $MerchantController->landingPage($prefix);
    }

    public function test_landingPage_hasPrefixNocacheisFalsehasPreviewshasCachedataWithPageActiveisY()
    {
        $prefix = 'data-prefix';
        $input['previews'] = '';
        $input['no-cache'] = false;

        Input::replace($input);

        $mockCache = Mockery::mock('alias:ElastiCache');
        $mockCache->shouldReceive('getResult')->andReturn(
            array(
                'content' => 'mock-content',
                'active' => 'Y'
            )
        );
        $this->mockTheme();
        $CampaignRepository = Mockery::mock('CampaignRepository');
        $MerchantController = App::make('MerchantController', array($CampaignRepository));
        $json_result = $MerchantController->landingPage($prefix);
        $this->assertEquals('mock-content', $json_result);
    }

    public function test_landingPage_hasPrefixNocacheisFalsehasPreviewshasCachedataWithPageActiveisN()
    {
        $prefix = 'data-prefix';
        $input['previews'] = '';
        $input['no-cache'] = false;

        Input::replace($input);

        $mockCache = Mockery::mock('alias:ElastiCache');
        $mockCache->shouldReceive('getResult')->andReturn(
            array(
                'content' => 'mock-content',
                'active' => 'N'
            )
        );
        Redirect::shouldReceive('to')->andReturn('/404.html');
        $this->mockTheme();
        $CampaignRepository = Mockery::mock('CampaignRepository');
        $MerchantController = App::make('MerchantController', array($CampaignRepository));
        $json_result = $MerchantController->landingPage($prefix);
        $this->assertEquals('/404.html', $json_result);
    }

    public function test_landingPage_hasPrefixNocacheisTruehasPreviewsWithEmptyValue()
    {
        $prefix = 'data-prefix';
        $input['previews'] = 'LS2';
        $input['no-cache'] = 1;

        Input::replace($input);

        $mockCache = Mockery::mock('alias:ElastiCache');
        $mockCache->shouldReceive('getResult')->andReturn(false);
        $mockCache->shouldReceive('save');
        $this->mockTheme();
        $CampaignRepository = Mockery::mock('CampaignRepository');
        $CampaignRepository->shouldReceive('getMerchantLandingPage')->andReturn(
            array(
                'status' => 'error',
                'code' => 404
            )
        );
        Redirect::shouldReceive('to')->andReturn('/404.html');
        $MerchantController = App::make('MerchantController', array($CampaignRepository));
        $json_result = $MerchantController->landingPage($prefix);
        $this->assertEquals('/404.html',$json_result);
    }

    public function test_landingPage_hasPrefixNocacheisTruehasPreviewsWithhasValue()
    {

        $prefix = 'data-prefix';
        $input['previews'] = 'LS2';
        $input['no-cache'] = 1;

        Input::replace($input);

        $mockCache = Mockery::mock('alias:ElastiCache');
        $mockCache->shouldReceive('getResult')->andReturn(false);
        $mockCache->shouldReceive('save');
        $this->mockTheme();
        $CampaignRepository = Mockery::mock('CampaignRepository');
        $CampaignRepository->shouldReceive('getMerchantLandingPage')->andReturn(
            array(
                'data' => array(
                    'campaign_name' => 'mock-campaign-name',
                    'status' => 'Y'
                ),
                'status' => 'success',
                'code' => 200
            )
        );
        $MerchantController = App::make('MerchantController', array($CampaignRepository));
        $MerchantController->landingPage($prefix);
    }

}
