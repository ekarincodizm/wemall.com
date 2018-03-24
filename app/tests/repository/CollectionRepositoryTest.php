<?php

class CollectionRepositoryTest extends \TestCase
{

    private $pcms;
    protected $mainClass = "CollectionRepository";

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

    public function testGetCollectionAll()
    {
        $expect = array(
            "pkey"  => "3701258529460",
            "name"  => "Clearance Sale promotions",
            "slug"  => "clearance-sale-promotions",
            "is_category" => "1",
            "translate" => array(
                "name"=> "Clearance Sale promotions",
            ),
            "essay" => "",
            "metas" => array(
                "banner"=> "//cdn.itruemart.com/pcms/uploads/15-06-5/2e8386a1e4484a48ceace8372944bfeb.jpg"
            ),
            "parents" => array(),
            "children" => array()
        );

        $mock['data'] = $expect;

        $this->pcms->shouldReceive("api")
                        ->withAnyArgs()
                        ->andReturn($mock);

        $collectionRepository = $this->getInstance();

        $result = $collectionRepository->getAll(0, 1);

        $this->assertEquals($result, $expect);
    }

    public function testGetCollectionByPkey()
    {
        $expect = array(
            "pkey"  => "3701258529460",
            "name"  => "Clearance Sale promotions",
            "slug"  => "clearance-sale-promotions",
            "is_category" => "1",
            "translate" => array(
                "name"=> "Clearance Sale promotions",
            ),
            "essay" => "",
            "metas" => array(
                "banner"=> "//cdn.itruemart.com/pcms/uploads/15-06-5/2e8386a1e4484a48ceace8372944bfeb.jpg"
            ),
            "parents" => array(),
            "children" => array()
        );

        $mock['data'] = $expect;

        $this->pcms->shouldReceive("api")
            ->withAnyArgs()
            ->andReturn($mock);

        $collectionRepository = $this->getInstance();

        $result = $collectionRepository->getByPkey(3701258529460);

        $this->assertEquals($result, $expect);
    }


    public function testGetCollectionBrands()
    {
        $expect = array(
                "pkey"  => "6821753946363",
                "name"  => "Alcatel",
                "slug"  => "alcatel",
                "translate" => array(
                    "name"  => "Alcatel",
                    "description"   => "Alcatel บริษัทผู้ผลิตอุปกรณ์สื่อสารชื่อดัง"
                ),
                "metas"=> array(
                    "video" => "http://www.youtube.com/embed/OtCMUH6FRSM?rel=0",
                    "banner-icon"   => "//cdn.itruemart.com/pcms/uploads/14-12-1/699d32102087ade94fe572a9bf208cc8.jpg",
                    "small-logo"    => "//cdn.itruemart.com/pcms/uploads/14-12-1/02a7935048cc659e702b67f3195aec58.jpg",
                    "banner"        => "//cdn.itruemart.com/pcms/uploads/15-02-17/d7576027087d1695443c3a8fe831b76c.jpg"
                ),
                "thumbnail" => "//cdn.itruemart.com/pcms/uploads/14-12-1/93fd89a02892451e98e40b5d36e09185.jpg"
        );

        $mock['data'] = $expect;

        $this->pcms->shouldReceive("api")
            ->withAnyArgs()
            ->andReturn($mock);

        $collectionRepository = $this->getInstance();

        $result = $collectionRepository->getBrands(6316782120211);

        $this->assertEquals($result, $expect);
    }

    public function testGetCollectionFlashsaleCollections()
    {
        $expect = array(
            "pkey"  => "3431763361672",
            "name"  => "Everyday WOW",
            "slug"  => "everyday-wow",
            "is_category"   => "1",
            "translate" => null,
            "essay" => "",
            "metas" => array(
                "banner"    => "//cdn.itruemart.com/pcms/uploads/14-11-10/5ad97808757629b9e03819af4d2e35a0.jpg"
            ),
            "parents"   => array(),
        );

        $mock['data'] = $expect;

        $this->pcms->shouldReceive("api")
            ->withAnyArgs()
            ->andReturn($mock);

        $collectionRepository = $this->getInstance();

        $result = $collectionRepository->getFlashsaleCollections();

        $this->assertEquals($result, $expect);
    }

    public function testGetDiscountCollections()
    {
        $expect = array(
            "pkey"  => "3431763361672",
            "name"  => "Everyday WOW",
            "slug"  => "everyday-wow",
            "is_category"   => "1",
            "translate" => null,
            "essay" => "",
            "metas" => array(
                "banner"    => "//cdn.itruemart.com/pcms/uploads/14-11-10/5ad97808757629b9e03819af4d2e35a0.jpg"
            ),
            "parents"   => array(),
        );

        $mock['data'] = $expect;

        $this->pcms->shouldReceive("api")
            ->withAnyArgs()
            ->andReturn($mock);

        $collectionRepository = $this->getInstance();

        $result = $collectionRepository->getDiscountCollections();

        $this->assertEquals($result, $expect);
    }

    public function testGetItruemartTvCollections()
    {
        $expect = array(
            "pkey"  => "3431763361672",
            "name"  => "Everyday WOW",
            "slug"  => "everyday-wow",
            "is_category"   => "1",
            "translate" => null,
            "essay" => "",
            "metas" => array(
                "banner"=> "//cdn.itruemart.com/pcms/uploads/14-11-10/5ad97808757629b9e03819af4d2e35a0.jpg"
            ),
            "parents"=>array(),
            "children"=> array(
                3 => array(
                    "pkey"  => 3269297263578,
                    "name"=> "เครื่องใช้ไฟฟ้าภายในบ้าน",
                    "slug"=> "home-appliances-wow",
                    "is_category"=> "1",
                    "translate" => array(
                        "name"=> "Home Appliances"
                    ),
                    "children" =>   array()
                )
            ),
        );

        $mock['data'] = $expect;

        $this->pcms->shouldReceive("api")
            ->withAnyArgs()
            ->andReturn($mock);

        $collectionRepository = $this->getInstance();

        $result = $collectionRepository->getItruemartTvCollections();

        $this->assertEquals($result, $expect);
    }

}