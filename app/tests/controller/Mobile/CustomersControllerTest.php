<?php

use \Mobile\CustomersController;
use \CustomerAddressRepositoryInterface;

class CustomersControllerTest extends TestCase
{

    /**
     * @var \CustomerAddressRepositoryInterface
     */
    protected $customerAddressRepository;

    /**
     * @var \Mobile\CustomersController
     */
    protected $customerController;

    public function setUp()
    {
        parent::setUp();

        $this->pcms = $this->mockSpecific('pcms');
        $this->theme = $this->MockThemeWithScope();
        $this->customerAddressRepository = $this->mockSpecific('CustomerAddressRepositoryInterface');

        $this->customerController = App::make('\Mobile\CustomersController');
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    protected function ignoreProvinceData()
    {
        $this->pcms->shouldReceive('apiv2')->andReturn(false);
    }

    public function testGuestAccess()
    {
        App::shouldReceive('abort')->withArgs(array('404'));

        $this->mockACL( false );

        $this->customerController->getShippingAddressForm();
    }

    public function testGetEditShippingAddressWithWrongShippingId()
    {
        $this->customerAddressRepository->shouldReceive('getAddressDetail')->andReturn(false);

        App::shouldReceive('abort')->withArgs(array('404'));

        $this->mockACL( 1 );
        Input::replace(array("id" => 1));

        $this->customerController->getShippingAddressForm();
    }

    public function testGetEditShippingAddressWithCorrectShippingId()
    {
        $this->ignoreProvinceData();
        $this->customerAddressRepository->shouldReceive('getAddressDetail')->andReturn(array('shipping-data'));

        $this->mockACL( 1 );
        Input::replace(array("id" => 1));

        $this->customerController->getShippingAddressForm();
    }

    public function testGetNewShippingAddress()
    {
        $this->ignoreProvinceData();
        $this->customerAddressRepository->shouldReceive('getAddressDetail')->andReturn(array('shipping-data'));

        $this->mockACL( 1 );

        $this->customerController->getShippingAddressForm();
    }

    public function testCreateShippingAddressAsGuest()
    {
        $this->mockACL( false );

        $expected = array(
            'success' => false,
            'status' => 'error',
            'code' => '503',
        );

        $response = $this->customerController->postSaveShipAddress();

        $this->assertEquals(json_encode($expected), $response->getContent());
    }

    public function testCreateShippingAddress()
    {
        $this->mockACL( 1 );

        $this->customerAddressRepository->shouldReceive('createAddress');

        $this->customerController->postSaveShipAddress();
    }

    public function testUpdateShippingAddress()
    {
        $this->mockACL( 1 );

        Input::replace(array("address_id" => 1));

        $this->customerAddressRepository->shouldReceive('updateAddress');

        $this->customerController->postSaveShipAddress();
    }

    public function testDeleteShippingAddressAsGuest()
    {
        $this->mockACL( false );

        $expected = array(
            'success' => false,
            'status' => 'error',
            'code' => '503',
        );

        $response = $this->customerController->postDeleteShipAddress();

        $this->assertEquals(json_encode($expected), $response->getContent());
    }

    public function testDeleteShippingAddressEmptyId()
    {
        $this->mockACL( 1 );

        $expected = array(
            'code' => 404,
            'message' => 'Not found id in database',
        );

        $response = $this->customerController->postDeleteShipAddress();

        $this->assertEquals(json_encode($expected), $response->getContent());
    }

    public function testDeleteShippingAddress()
    {
        $this->mockACL( 1 );

        Input::replace(array('id' => 1));

        $this->customerAddressRepository->shouldReceive('deleteAddress');

        $this->customerController->postDeleteShipAddress();
    }

}
