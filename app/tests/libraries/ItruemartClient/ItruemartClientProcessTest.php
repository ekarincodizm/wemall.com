<?php

class ItruemartClientProcessTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testConstruct()
    {
        $response = array(
            'test' => 'foobar'
        );
        $type = 'application/json';
        $result = New \ItruemartClient\Process(json_encode($response), $type);
        $this->assertNotEmpty($result);


        $testXML = '<?xml version="1.0" encoding="UTF-8" ?>
                        <document>
                            <status>200</status>
                            <data_response>foobar</data_response>
                        </document>';
        $type2 = 'application/xml';
        $result2 = New \ItruemartClient\Process($testXML, $type2);
        $this->assertNotEmpty($result2);
    }

    public function testJsonGetResponse(){
        $response = array(
            'status' => 200,
            'data_response' => 'foobar'
        );
        $expect = array(
            'status' => true,
            'data' => 'foobar'
        );
        $type = 'application/json';
        $getResult = New \ItruemartClient\Process(json_encode($response), $type);
        $result = $getResult->getResponse();
        $this->assertEquals($expect, $result);

    }

    public function testJsonGetErrorDescription(){
        $response = array(
            'status' => 200,
            'error_description' => 'error_foobar'
        );
        $expect = array(
            'status' => true,
            'data' => 'error_foobar'
        );
        $type = 'application/json';
        $getResult = New \ItruemartClient\Process(json_encode($response), $type);
        $result = $getResult->getResponse();
        $this->assertEquals($expect, $result);

    }

    public function testJsonGetErrorCode(){
        $response = array(
            'status' => 400,
            'error_description' => 'error_foobar'
        );
        $expect = array(
            'status' => FALSE,
            'message' => '',
            'data' => 'error_foobar'
        );
        $type = 'application/json';
        $getResult = New \ItruemartClient\Process(json_encode($response), $type);
        $result = $getResult->getResponse();
        $this->assertEquals($expect, $result);

    }

    public function testXMLGetResponse()
    {
        $response = '<?xml version="1.0" encoding="UTF-8" ?>
                        <document>
                            <status>200</status>
                            <data_response>foobar</data_response>
                        </document>';

        $expect = array(
            'status' => true,
            'data' => 'foobar'
        );

        $type = 'application/xml';
        $getResult = New \ItruemartClient\Process($response, $type);
        $result = $getResult->getResponse();
        $this->assertEquals($expect, $result);

    }

    public function testJsonGetRawResponse()
    {

        $response = array(
            'status' => 200,
            'data_response' => 'foobar'
        );

        $expect = array(
            'status' => 200,
            'data_response' => 'foobar'
        );

        $type = 'application/json';
        $getResult = New \ItruemartClient\Process(json_encode($response), $type);
        $result = $getResult->getRawResponse();
        $this->assertEquals($expect, $result);
    }

}