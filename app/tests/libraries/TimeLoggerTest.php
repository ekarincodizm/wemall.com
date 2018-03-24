<?php

class TimeLoggerTest extends \TestCase
{

    private $log;

    public function setUp()
    {
        parent::setUp();

        $this->log = Log::shouldReceive("debug")->andReturn(true);
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testSnapWithoutCookieThenReturnFalse()
    {
        $timeLogger = new TimeLogger();
        $res = $timeLogger->snap("unit test");

        $this->assertFalse($res);
    }

    public function testSnapWithCookieThenReturnNull()
    {
        $_COOKIE["timelogger"] = 1;

        $timeLogger = new TimeLogger();
        $res = $timeLogger->snap("unit test");

        $this->assertNull($res);
    }

}