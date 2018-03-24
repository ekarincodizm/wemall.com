<?php

class CustomerAddressRepositoryTest extends TestCase
{
    private $pcms;
    protected $mainClass = "CustomerAddressRepository";
    private $dataFile = "/../fixtures/customer-address.yml";

    public function setUp()
    {
        parent::setUp();
        $this->pcms = $this->mockSpecific("pcms");
    }

    public function tearDown()
    {
        parent::tearDown();
        \Mockery::close();
    }

    public function testGetAddressWithValidSSOIDThenReturnArrayData()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . $this->dataFile, "inthras_address");
        $row = $dataSet->getRow(0);

        $this->pcms->shouldReceive("api")
            ->with("customerAddresses/address", array('customer_ref_id' => 1))
            ->andReturn($row);

        $customerAddressRepository = $this->getInstance();
        $res = $customerAddressRepository->getAddress(1);

        $this->assertNotEmpty($res);
        $this->assertEquals(200, $res["code"]);
        $this->assertEquals("success", $res["status"]);
    }

    public function testGetAddressWithInvalidSSOIDThenReturnNull()
    {
        $customerAddressRepository = $this->getInstance();
        $res = $customerAddressRepository->getAddress();

        $this->assertNull($res);
    }

    public function testCreateAddressWithValidParamsThenReturnSuccess()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . $this->dataFile, "save_new_address_response");
        $row = $dataSet->getRow(0);

        $params = array(
            "address_id" => "",
            "name" => "name",
            "phone" => "0804345451",
            "email" => "inthra.onsap@gmail.com",
            "province_id" => 1,
            "city_id" => 18,
            "district_id" => 72,
            "postcode" => 10600,
            "address" => "test test"
        );
        $this->pcms->shouldReceive("api")
            ->with("customerAddresses/create", $params, "POST")
            ->andReturn($row);

        $customerAddressRepository = $this->getInstance();
        $res = $customerAddressRepository->createAddress($params);

        $this->assertNotEmpty($res);
        $this->assertEquals(200, $res["code"]);
        $this->assertEquals("success", $res["status"]);
    }

    public function testCreateAddressWithInvalidParamsThenReturnNull()
    {
        $customerAddressRepository = $this->getInstance();
        $res = $customerAddressRepository->createAddress();

        $this->assertNull($res);
    }

    public function testUpdateAddressWithValidParamsThenReturnSuccess()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . $this->dataFile, "update_new_address_response");
        $row = $dataSet->getRow(0);
        $params = array(
            "address_id" => 11111,
            "name" => "name",
            "phone" => "0804345451",
            "email" => "inthra.onsap@gmail.com",
            "province_id" => 1,
            "city_id" => 18,
            "district_id" => 72,
            "postcode" => 10600,
            "address" => "test test"
        );

        $this->pcms->shouldReceive("api")
            ->with("customerAddresses/update", $params, "POST")
            ->andReturn($row);

        $customerAddressRepository = $this->getInstance();
        $res = $customerAddressRepository->updateAddress($params);

        $this->assertNotEmpty($res);
        $this->assertEquals(200, $res["code"]);
        $this->assertEquals("success", $res["status"]);
    }

    public function testUpdateAddressWithInvalidParamsThenReturnNull()
    {
        $customerAddressRepository = $this->getInstance();
        $res = $customerAddressRepository->updateAddress();

        $this->assertNull($res);
    }

    public function testDeleteAddressWithValidParamsThenReturnSuccess()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . $this->dataFile, "update_new_address_response");
        $row = $dataSet->getRow(0);
        $params = array(
            'address_id' => 32184,
            'customer_ref_id' => 17760171
        );

        $this->mockACL(true);
        $this->pcms->shouldReceive("api")
            ->with("customerAddresses/delete", $params, "post")
            ->andReturn($row);

        $customerAddressRepository = $this->getInstance();
        $res = $customerAddressRepository->deleteAddress(32184);

        $this->assertNotEmpty($res);
        $this->assertEquals(200, $res["code"]);
    }

    public function testDeleteAddressWithInvalidParamsThenReturnNull()
    {
        $this->mockACL(true);
        $customerAddressRepository = $this->getInstance();
        $res = $customerAddressRepository->deleteAddress();
        $this->assertNull($res);
    }

    public function testGetAddressDetailWithValidParamsThenReturnArrayData()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . $this->dataFile, "get_address_detail_response");
        $row = $dataSet->getRow(0);
        $params = array(
            'address_id' => 32186,
            'customer_ref_id' => 17760171
        );

        $this->mockACL(true);
        $this->pcms->shouldReceive("api")
            ->with("customerAddresses/detail", $params, "get")
            ->andReturn($row);

        $customerAddressRepository = $this->getInstance();
        $res = $customerAddressRepository->getAddressDetail(17760171, 32186);

        $this->assertNotEmpty($res);
        $this->assertEquals(200, $res["code"]);
    }

    public function testGetAddressDetailWithInvalidSSOIDAndValidAddressIdThenReturnFalse(){
        $customerAddressRepository = $this->getInstance();
        $res = $customerAddressRepository->getAddressDetail(null, 32186);

        $this->assertFalse($res);
    }

    public function testGetAddressDetailWithValidSSOIDAndInvalidAddressIdThenReturnFalse(){
        $customerAddressRepository = $this->getInstance();
        $res = $customerAddressRepository->getAddressDetail(17760171);

        $this->assertFalse($res);
    }

    public function testGetAddressDetailWithInvalidSSOIDAndInvalidAddressIdThenReturnFalse(){
        $customerAddressRepository = $this->getInstance();
        $res = $customerAddressRepository->getAddressDetail();

        $this->assertFalse($res);
    }

}