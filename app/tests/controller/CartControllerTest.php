<?php 

class CartControllerTest extends TestCase 
{
    public function setUp()
    {
        parent::setUp();

        $this->pcms = $this->mockSpecific('pcms');
        $this->productRepo = $this->mock('ProductRepositoryInterface'); 

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

    public function testSetCardDataFail()
    {
        // prepare mock
        $this->mockACL( false );

        $api_response['code'] = 400;
        $api_response['message'] = 'FAIL';
        $this->pcms->shouldReceive('apiv2')->andReturn( $api_response );

        // prepare input
        $input_mock['credit_num'] = '123456';
        Input::replace( $input_mock );
        
        // run
        $this->CartController = App::make('CartController');
        $response = $this->CartController->setCardData();
        $response = json_decode($response->getContent(), true);
        
        $this->assertTrue( $api_response['code'] === $response['code'] , 'Response code should be equal');
        $this->assertTrue( $api_response['message'] === $response['message'] , 'Response code should be equal');
    }

    public function testSetCardDataSuccess()
    {
        // prepare mock
        $this->mockACL( false );

        $api_response['code'] = 200;
        $api_response['data'] = array(
            'card_issuer' => 1,
            'card_network' => 2,
            'card_description' => 3,
            'card_ref_id' => 4,
        );
        $this->pcms->shouldReceive('apiv2')->andReturn( $api_response );

        // prepare input
        $input_mock['credit_num'] = '123456';
        Input::replace( $input_mock );
        
        // run
        $this->CartController = App::make('CartController');
        $response = $this->CartController->setCardData();
        $response = json_decode($response->getContent(), true);
        
        $this->assertTrue( $api_response['code'] === $response['code'] , 'Response code should be equal');
        $this->assertTrue( $api_response['data'] === $response['data'] , 'Response code should be equal');
    }

}