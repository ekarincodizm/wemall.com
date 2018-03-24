<?php

class EmailTest extends TestCase
{
    private $config;
    private $curl;
    private $to = "email@email.com";
    private $subject = "Subject.";

    public function setUp()
    {
        parent::setUp();

        $this->config = Config::shouldReceive("get")
            ->andReturn(array(
                'smtp_app_id' => 'mock',
                'smtp_secret_key' => 'mock',
                'smtp_url' => 'http://emailgateway.mock',
                'smtp_sender' => 'no-reply@itruemart.com',
                'smtp_fromname' => 'iTrueMart'
            ));

        $this->curl = $this->mockSpecific("Curl");

    }

    public function tearDown()
    {
        parent::tearDown();
        \Mockery::close();
    }

    public function testSendWithValidParamThenReturnTrue()
    {
        $this->curl->shouldReceive("simple_post")
            ->andReturn('{"header":{"code":200,"description":"Success"}}');

        $email = new Email();
        $res = $email->send($this->to, $this->subject);
        $res = json_decode($res, true);

        $this->assertEquals(200, $res["header"]["code"]);
        $this->assertEquals("Success", $res["header"]["description"]);
    }
}