<?php

class CommonTest extends \TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testRecursiveValidXSSClean(){
        $array = array(
            'test' => array(
                'test2' => '<script>alert("foo");</script>'
            )
        );

        $expect = array(
            'test' => array(
                'test2' => 'alert("foo");'
            )
        );

        $commons = \App::make('Commons');
        $result = $commons->globalXssClean($array);
        $this->assertEquals($result, $expect);
    }

    public function testValidXSSClean(){
        $array = array(
            'test2' => '<script>alert("foo");</script>'
        );

        $expect = array(
            'test2' => 'alert("foo");'
        );

        $commons = \App::make('Commons');
        $result = $commons->globalXssClean($array);
        $this->assertEquals($result, $expect);
    }

    public function testCurl(){
        $url = 'http://www.itruemart.com';

        $mockCurl = $this->mock('Commons')->makePartial();
        $mockCurl->shouldReceive('curl')
            ->withAnyArgs()
            ->andReturn('mockTest');

        $commons = \App::make('Commons');
        $result = $commons->curl($url);

        $this->assertEquals("mockTest", $result);
    }

}