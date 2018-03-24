<?php

class CreditRepositoryTest extends \TestCase
{

    private $pcms;
    protected $mainClass = "CreditRepository";

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

    public function testGetCreditCardWithValidSSOIDThenReturnArrayData()
    {
        $dataSet = $this->getYMLDataset(__DIR__ . "/../fixtures/creditcard-data.yml", "creditcard-data");
        $row = $dataSet->getRow(0);

        $this->pcms->shouldReceive("api")
            ->with("credit-card/card-list?ssoId=123265")
            ->andReturn($row);

        $creditRepository = $this->getInstance();
        $res = $creditRepository->getCreditCard(123265);

        $this->assertNotEmpty($res);
    }

    public function testGetCreditCardWithInvalidSSOIDThenReturnArrayData()
    {

        $this->pcms->shouldReceive("api")
            ->with("credit-card/card-list?ssoId=")
            ->andReturn(array());

        $creditRepository = $this->getInstance();
        $res = $creditRepository->getCreditCard();

        $this->assertEmpty($res);
    }


}