<?php

class MembersControllerTest extends TestCase
{
    /**
     * @var MembersController
     */
    protected $membersController;

    public function setUp()
    {
        parent::setUp();

        $this->pcms = $this->mockSpecific('pcms');

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
        $this->teeplusTheme->shouldReceive("render")->andReturn( 'template-data' );

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

    public function prepareUserData($is_guest = false)
    {
        $dataset = $this->getYMLDataset(__DIR__ . '/../fixtures/user.yml', 'user');
        $user_data = $dataset->getRow(0);
        $user_data['group'] = $is_guest ? 'guest' : 'not-guest';

        return $user_data;
    }

    public function mockACL($is_guest = false)
    {
        $mockACL = Mockery::mock('alias:ACL');
        $mockACL->shouldReceive('getUser')->andReturn( $this->prepareUserData($is_guest) );
    }

    /*
    public function testGuestGetOrder()
    {
        $this->mockACL( true );

        $mockRedirect = Mockery::mock('alias:Redirect');
        $mockRedirect->shouldReceive('route');

        $this->membersController = App::make('MembersController');
        $this->membersController->getOrder();

        $this->assertTrue( true );
    }

    public function testMemberGetOrder()
    {
        $this->mockACL( false );

        $this->pcms->shouldReceive('api')
            ->with('lastlogin/2727f9f7c0b32812cae2d204e445cb9d')
            ->andReturn( array(
                'data' => array(
                    0 => array(
                        'login_at' => '2015-03-23 10:00:00'
                    ),
                ),
            ) );

        $this->pcms->shouldReceive('api')
            ->andReturn( array(
                'data' => array(
                    'orders' => array( 'a-lot-of-orders' ),
                    'page' => 1,
                    'total' => 1,
                ),
            ));

        $this->membersController = App::make('MembersController');
        $response = $this->membersController->getOrder();

        $this->assertTrue( !empty($response) );
    }
    */

    public function testGetTrackingDataInputEmrtyReturnError()
    {
        $this->membersController = App::make('MembersController');
        $response = $this->membersController->getTrackingData();
        $response = json_decode($response->getContent(), true);

        $this->assertEquals('Tracking number is null', $response['status']);
    }

    public function testGetTrackingDataInputDataReturnDataNotFound()
    {
        Input::replace(array('tracking_no' => 315153));

        $this->pcms->shouldReceive('api')
            ->with('order-tracking/delivery-data', array('tracking_number'=>315153), "GET")
            ->andReturn(array());

        $this->membersController = App::make('MembersController');
        $response = $this->membersController->getTrackingData();
        $response = json_decode($response->getContent(), true);

        $this->assertEquals('Data not found', $response['status']);
    }

    public function testGetTrackingDataInputDataReturnSuccess()
    {
        Input::replace(array('tracking_no' => 315153));
        $data = array(
            'data' => array(
                'delivery_data' => array(
                    array(
                        'date' => '11-12-2014',
                        'time' => '12:40:56',
                    ),
                    array(
                        'date' => '11-12-2014',
                        'time' => '09:44:41',
                    )
                )
            )
        );


        $this->pcms->shouldReceive('api')
            ->with('order-tracking/delivery-data', array('tracking_number'=>315153), "GET")
            ->andReturn($data);

        $this->membersController = App::make('MembersController');
        $response = $this->membersController->getTrackingData();
        $response = json_decode($response->getContent(), true);

        $this->assertEquals('success', $response['status']);
    }
}
