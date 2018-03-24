<?php

class HelpersTest extends \TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testArrayMonthCC(){

        $expect = array(
            1 => '01',
            2 => '02',
            3 => '03',
            4 => '04',
            5 => '05',
            6 => '06',
            7 => '07',
            8 => '08',
            9 => '09',
            10 => '10',
            11 => '11',
            12 => '12'
        );

        $libHelpers = App::make('Helpers');
        $result = $libHelpers->array_month_cc($expect);
        $this->assertEquals($result, $expect);
    }

    public function testGetMoreTenYears(){
        $year = date("Y");
        $expectArr = array();

        for($i=0;$i<=10;$i++){
            $expectArr[$i] = $year+$i;
        }

        $libHelpers = App::make('Helpers');
        $result = $libHelpers->genMoreTenYears();

        $this->assertEquals($result, $expectArr);
    }

    public function testInsightDateTH(){
        $params = "2015-06-01 12:00:00";
        $expect = "01 มิถุนายน 2558";
        $libHelpers = App::make('Helpers');
        $result = $libHelpers->insightDate($params, "th");

        $this->assertEquals($result, $expect);
    }

    public function testInsightDateEN(){
        $params = "2015-06-01 12:00:00";
        $expect = "Jun 01, 2015";
        $libHelpers = App::make('Helpers');
        $result = $libHelpers->insightDate($params, "en");

        $this->assertEquals($result, $expect);
    }

    public function testInsightNotValid(){
        $params = NULL;
        $libHelpers = App::make('Helpers');
        $result = $libHelpers->insightDate($params);

        $this->assertEquals(NULL, $result);

        $params = "2015-06-01 15:00:00 00";
        $result = $libHelpers->insightDate($params);
        $this->assertEquals(NULL, $result);
    }

    public function testMonthArray(){
        $expectTH = array(
            1 => "มกราคม",
            2 => "กุมภาพันธ์",
            3 => "มีนาคม",
            4 => "เมษายน",
            5 => "พฤษภาคม",
            6 => "มิถุนายน",
            7 => "กรกฎาคม",
            8 => "สิงหาคม",
            9 => "กันยายน",
            10 => "ตุลาคม",
            11 => "พฤศจิกายน",
            12 => "ธันวาคม"
        );

        $expectEN = array(
            1 => "January",
            2 => "February",
            3 => "March",
            4 => "April",
            5 => "May",
            6 => "June",
            7 => "July",
            8 => "August",
            9 => "September",
            10 => "October",
            11 => "November",
            12 => "December"
        );

        $libHelpers = App::make('Helpers');

        $result = $libHelpers->array_month("th");
        $this->assertEquals($result, $expectTH);

        $result = $libHelpers->array_month("en");
        $this->assertEquals($result, $expectEN);
    }

    public function testRandomString(){

        $libHelpers = App::make('Helpers');

        $resultBasic = $libHelpers->random_string("foobar");
        $this->assertEmpty($resultBasic);

        $resultBasic = $libHelpers->random_string("basic");
        $this->assertNotEmpty($resultBasic);

        $resultAlpha = $libHelpers->random_string("alpha", 5);
        $expectAlpha = false;
        if(ctype_alpha($resultAlpha)){
            $expectAlpha = true;
        }
        $this->assertTrue($expectAlpha);

        $resultAlnum = $libHelpers->random_string("alnum", 5);
        $this->assertNotEmpty($resultAlnum);

        $resultNumeric = $libHelpers->random_string("numeric", 5);
        $expectNumeric = preg_match('/^-?[0-9]+$/', (string)$resultNumeric) ? true : false;
        $this->assertTrue($expectNumeric);

        $resultNoZero = $libHelpers->random_string("nozero", 5);
        $expectNoZero = preg_match('/^-?[1-9]+$/', (string)$resultNoZero) ? true : false;
        $this->assertTrue($expectNoZero);

        $resultUnique = $libHelpers->random_string("unique", 5);
        $this->assertNotEmpty(5, $resultUnique);

        $resultMD5 = $libHelpers->random_string("md5", 5);
        $this->assertNotEmpty($resultMD5);
    }
}