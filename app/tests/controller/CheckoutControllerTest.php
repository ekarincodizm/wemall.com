<?php

class CheckoutControllerTest extends \TestCase
{
    protected $mainClass = "CheckoutController";
    private $code = "FAKECODE";

    public function setUp(){
        parent::setUp();

        $this->MockTheme();
    }

    public function tearDown(){
        parent::tearDown();
        \Mockery::close();
    }

    private function mockRequest($input){
        $requestMock = Request::shouldReceive("ajax")
            ->andReturn(true)
            ->shouldReceive("server")
            ->andReturn("www.itruemart.com")
            ->shouldReceive("input")
            ->andReturn($input);

        return $requestMock;
    }

    private function mockPCMSClient($res){
        $pcms = $this->mockSpecific("pcms")
            ->shouldReceive("postApplyCoupon")
            ->andReturn($res);

        return $pcms;
    }


    public function testPostApplyCouponWhichIsNotAjaxThenReturnError(){
        Input::replace(array("code"=>$this->code));

        $checkoutCtrl = $this->getInstance();
        $res = $checkoutCtrl->postApplyCoupon();
        $res = $res->getData(true);

        $this->assertEquals(400, $res['code']);
        $this->assertEquals("error", $res['status']);
        $this->assertEquals("Method require ajax request.", $res["description"]);
    }

    public function testPostApplyCouponWithNoCodeParamThenReturnError(){
        $this->mockRequest(array());
        $this->mockPCMSClient(array());
        $checkoutCtrl = $this->getInstance();
        $res = $checkoutCtrl->postApplyCoupon();
        $res = $res->getData(true);

        $this->assertEquals(400, $res['code']);
        $this->assertEquals("error", $res['status']);
        $this->assertEquals("กรุณาพิมพ์รหัสคูปองพิเศษ", $res["description"]);
    }

    public function testPostApplyCouponWithCodeThenReturnSuccess(){
        $pcmsData = array(
            "status" => "success",
            "code" => 200,
            "description" => "success"
        );
        $this->mockRequest(array("code"=>$this->code));
        $this->mockPCMSClient($pcmsData);
        $checkoutCtrl = $this->getInstance();
        $res = $checkoutCtrl->postApplyCoupon();
        $res = $res->getData(true);

        $this->assertEquals(200, $res['code']);
        $this->assertEquals("success", $res['status']);
        $this->assertEquals("success", $res["description"]);

    }

    public function testPostApplyCouponWithCodeThenReturn4001Fail(){
        $pcmsData = array(
            "data" => array(
                "errorCode" => 4001
            ),
            "status" => "error",
            "code" => 400,
            "description" => "error"
        );
        $this->mockRequest(array("code"=>$this->code));
        $this->mockPCMSClient($pcmsData);
        $checkoutCtrl = $this->getInstance();
        $res = $checkoutCtrl->postApplyCoupon();
        $res = $res->getData(true);

        $this->assertEquals(4001, $res['code']);
        $this->assertEquals("error", $res['status']);
        $this->assertEquals("กรุณาพิมพ์รหัสคูปองพิเศษ", $res["description"]);

    }

    public function testPostApplyCouponWithCodeThenReturn4101Fail(){
        $pcmsData = array(
            "data" => array(
                "errorCode" => 4101
            ),
            "status" => "error",
            "code" => 400,
            "description" => "error"
        );
        $this->mockRequest(array("code"=>$this->code));
        $this->mockPCMSClient($pcmsData);
        $checkoutCtrl = $this->getInstance();
        $res = $checkoutCtrl->postApplyCoupon();
        $res = $res->getData(true);

        $this->assertEquals(4101, $res['code']);
        $this->assertEquals("error", $res['status']);
        $this->assertEquals("รหัสคูปองพิเศษหมดอายุแล้ว", $res["description"]);

    }

    public function testPostApplyCouponWithCodeThenReturn4102Fail(){
        $pcmsData = array(
            "data" => array(
                "errorCode" => 4102
            ),
            "status" => "error",
            "code" => 400,
            "description" => "error"
        );
        $this->mockRequest(array("code"=>$this->code));
        $this->mockPCMSClient($pcmsData);
        $checkoutCtrl = $this->getInstance();
        $res = $checkoutCtrl->postApplyCoupon();
        $res = $res->getData(true);

        $this->assertEquals(4102, $res['code']);
        $this->assertEquals("error", $res['status']);
        $this->assertEquals("รหัสคูปองพิเศษไม่ถูกต้อง", $res["description"]);

    }

    public function testPostApplyCouponWithCodeThenReturn4111Fail(){
        $pcmsData = array(
            "data" => array(
                "errorCode" => 4111
            ),
            "status" => "error",
            "code" => 400,
            "description" => "error"
        );
        $this->mockRequest(array("code"=>$this->code));
        $this->mockPCMSClient($pcmsData);
        $checkoutCtrl = $this->getInstance();
        $res = $checkoutCtrl->postApplyCoupon();
        $res = $res->getData(true);

        $this->assertEquals(4111, $res['code']);
        $this->assertEquals("error", $res['status']);
        $this->assertEquals("รหัสคูปองพิเศษถูกใช้หมดแล้ว", $res["description"]);

    }

    public function testPostApplyCouponWithCodeThenReturn4112Fail(){
        $pcmsData = array(
            "data" => array(
                "errorCode" => 4112
            ),
            "status" => "error",
            "code" => 400,
            "description" => "error"
        );
        $this->mockRequest(array("code"=>$this->code));
        $this->mockPCMSClient($pcmsData);
        $checkoutCtrl = $this->getInstance();
        $res = $checkoutCtrl->postApplyCoupon();
        $res = $res->getData(true);

        $this->assertEquals(4112, $res['code']);
        $this->assertEquals("error", $res['status']);
        $this->assertEquals("คูปองพิเศษไม่สามารถใช้ร่วมกับสินค้าที่คุณสั่งซื้อ", $res["description"]);

    }

    public function testPostApplyCouponWithCodeThenReturn4113Fail(){
        $pcmsData = array(
            "data" => array(
                "errorCode" => 4113
            ),
            "status" => "error",
            "code" => 400,
            "description" => "error"
        );
        $this->mockRequest(array("code"=>$this->code));
        $this->mockPCMSClient($pcmsData);
        $checkoutCtrl = $this->getInstance();
        $res = $checkoutCtrl->postApplyCoupon();
        $res = $res->getData(true);

        $this->assertEquals(4113, $res['code']);
        $this->assertEquals("error", $res['status']);
        $this->assertEquals("รหัสคูปองพิเศษนี้ถูกใช้ไปแล้ว", $res["description"]);

    }

    public function testPostApplyCouponWithCodeThenReturn4114Fail(){
        $pcmsData = array(
            "data" => array(
                "errorCode" => 4114
            ),
            "status" => "error",
            "code" => 400,
            "description" => "error"
        );
        $this->mockRequest(array("code"=>$this->code));
        $this->mockPCMSClient($pcmsData);
        $checkoutCtrl = $this->getInstance();
        $res = $checkoutCtrl->postApplyCoupon();
        $res = $res->getData(true);

        $this->assertEquals(4114, $res['code']);
        $this->assertEquals("error", $res['status']);
        $this->assertEquals("คุณไม่สามารถใช้รหัสคูปองได้ เนื่องจากยอดรวมทั้งตะกร้าหรือมูลค่าสินค้าขั้นต่ำ ไม่ตรงตามเงื่อนไขการใช้คูปอง", $res["description"]);

    }

    public function testPostApplyCouponWithCodeThenReturn4115Fail(){
        $pcmsData = array(
            "data" => array(
                "errorCode" => 4115
            ),
            "status" => "error",
            "code" => 400,
            "description" => "error"
        );
        $this->mockRequest(array("code"=>$this->code));
        $this->mockPCMSClient($pcmsData);
        $checkoutCtrl = $this->getInstance();
        $res = $checkoutCtrl->postApplyCoupon();
        $res = $res->getData(true);

        $this->assertEquals(4115, $res['code']);
        $this->assertEquals("error", $res['status']);
        $this->assertEquals("คุณไม่สามารถใช้รหัสคูปองได้ เนื่องจากบัตรเครดิตไม่ตรงตามเงื่อนไขการใช้คูปอง", $res["description"]);

    }

    public function testPostApplyCouponWithCodeThenReturn5001Fail(){
        $pcmsData = array(
            "data" => array(
                "errorCode" => 5001
            ),
            "status" => "error",
            "code" => 400,
            "description" => "error"
        );
        $this->mockRequest(array("code"=>$this->code));
        $this->mockPCMSClient($pcmsData);
        $checkoutCtrl = $this->getInstance();
        $res = $checkoutCtrl->postApplyCoupon();
        $res = $res->getData(true);

        $this->assertEquals(5001, $res['code']);
        $this->assertEquals("error", $res['status']);
        $this->assertEquals("สินค้าบางชิ้นในตะกร้าไม่สามารถใช้โปรโมชั่นโค้ดร่วมกับการผ่อนชำระได้", $res["description"]);

    }
}