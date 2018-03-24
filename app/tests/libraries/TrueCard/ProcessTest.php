<?php

class ProcessTest extends TestCase
{
    /**
     * @var string
     */
    protected $xmlPattern = '<body><items><card_information><item><grade>%s</grade></item></card_information></items></body>';

    /**
     * @param string $gradeColor
     * @return \TrueCard\Process
     */
    protected function prepareTrueCard($gradeColor)
    {
        $xmlString = sprintf($this->xmlPattern, $gradeColor);
        return new \TrueCard\Process($xmlString);
    }

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testAll()
    {
        $expectedData = '{"items":{"card_information":{"item":{"grade":"red"}}}}';
        $trueCardProcess = $this->prepareTrueCard('red');
        $allData = $trueCardProcess->all();
        $this->assertEquals($expectedData, json_encode($allData));
    }

    public function testGet()
    {
        $expectedData = 'G';
        $trueCardProcess = $this->prepareTrueCard('G');
        $this->assertEquals($expectedData, $trueCardProcess->get());
    }

    public function testCheckRedCard()
    {
        $expectedData = 'red';
        $trueCardProcess = $this->prepareTrueCard('G');
        $this->assertEquals($expectedData, $trueCardProcess->check());
    }

    public function testCheckBlackCard()
    {
        $expectedData = 'black';
        $trueCardProcess = $this->prepareTrueCard('P');
        $this->assertEquals($expectedData, $trueCardProcess->check());
    }

    public function testIsRedCard()
    {
        $trueCardProcess = $this->prepareTrueCard('G');
        $this->assertTrue($trueCardProcess->isRed());
        $this->assertFalse($trueCardProcess->isBlack());
    }

    public function testIsBlackCard()
    {
        $trueCardProcess = $this->prepareTrueCard('P');
        $this->assertFalse($trueCardProcess->isRed());
        $this->assertTrue($trueCardProcess->isBlack());
    }

    public function testHasCard()
    {
        $trueCardProcess = $this->prepareTrueCard('P');
        $this->assertTrue($trueCardProcess->hasCard());
    }

    public function testNoCard()
    {
        $trueCardProcess = $this->prepareTrueCard('NoCard');
        $this->assertFalse($trueCardProcess->hasCard());
    }
}
