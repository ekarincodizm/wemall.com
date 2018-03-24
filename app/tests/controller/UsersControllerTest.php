<?php

class UsersControllerTest extends TestCase 
{

	private $userController;
	private $memberRepositoryInterface;

	public function setUp() {
    	parent::setUp();

    	$this->mockTheme();
        $this->memberRepositoryInterface = $this->mockSpecific('MemberRepositoryInterface');
	}


	public function tearDown() {
        parent::tearDown();
        Mockery::close();
	}

	 public function mockTheme()
    {
        $this->teeplusTheme = $this->getTeeplusThemeMock();

        $this->teeplusTheme->shouldReceive("asset")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("writeContent")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("setTitle")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("container")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("script")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("writeScript")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("breadcrumb")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("add")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("usePath")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("setMetadescription")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("setMetakeywords")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("setCanonical")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("partialComposer")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("scope")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("with")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("layout")->andReturn(Mockery::self());
        $this->teeplusTheme->shouldReceive("render");
    }

    public function mockRequestParams($params)
    {
        Input::merge( $params );
    }

	public function testPostRegisterValidEmail()
	{
		$params = array(
						'register_channel' => 'email',
						'continue' => '',
						'email_username' => 'emailtesting54321@gmail.com',
						'email_display_name' => 'nametest',
						'email_password' => '123456',
						'email_password_confirmation' => '123456',
						'email_thai_id' => '1111111111111',
						'accept' => true
		);

		$this->mockRequestParams($params);
		$this->usersController = App::make('UsersController');
	
		$this->memberRepositoryInterface->shouldReceive('register')
			->withAnyArgs()
			->andReturn(
					array('user_id' => '11111')
				);

		$result = $this->usersController->postRegister();
		$expect = array(
						'status' => true,
						'data'     => array(
                							'user_id' => '11111'
            			),
            			'continue' => '/'
		);

		$this->assertEquals($result, $expect);
	}

	public function testPostRegisterErrorException()
	{
		$params = array(
						'register_channel' => 'email',
						'continue' => '',
						'email_username' => 'emailtesting@54321gmail.com',
						'email_display_name' => 'nametest',
						'email_password' => '123456',
						'email_password_confirmation' => '123456',
						'email_thai_id' => '1111111111111',
						'accept' => true
		);

		$this->mockRequestParams($params);
		$this->usersController = App::make('UsersController');
	
		$this->memberRepositoryInterface->shouldReceive('register')
			->withAnyArgs()
			->once()
			->andThrow('Exception','Error code');
					

		$result = $this->usersController->postRegister();
		//sd($result);
		$expect = array(
						'status' => false,
						'error'     => 'Error code'
		);

		$this->assertEquals($result, $expect);
	}

	public function testPostRegisterEmailFailValidateException()
	{
		$params = array(
						'register_channel' => 'email',
						'continue' => '',
						'email_username' => 'emailtesting54321gmail.com',
						'email_display_name' => 'nametest',
						'email_password' => '123456',
						'email_password_confirmation' => '123456',
						'email_thai_id' => '1111111111111',
						'accept' => true
		);

		$this->mockRequestParams($params);
		$this->usersController = App::make('UsersController');

		 
		$mockValidate = new ValidateException(
				new Illuminate\Support\MessageBag(array('error' => 'Error email'))
			);

		$this->memberRepositoryInterface->shouldReceive('register')
			->withAnyArgs()
			->once()
			->andThrow($mockValidate);
					

		$result = $this->usersController->postRegister();

		$expect = array(
						'status' => false,
						'error'     => 'Error email'
		);

		$this->assertEquals($result, $expect);
	}

	public function testGetAjaxGetUserForGuest()
	{
		$this->mockACL();
		$this->usersController = App::make('UsersController');
		$result = serialize($this->usersController->getAjaxGetUser());
		
		if(strpos($result, '"group":"guest"') != false) {
			$result = true;
		} 
		$expect = true;
		$this->assertEquals($result, $expect);
	}

	public function testGetAjaxGetUserForUser()
	{
		$this->mockACL(true);
		$this->usersController = App::make('UsersController');
		$result = serialize($this->usersController->getAjaxGetUser());
		
		if(strpos($result, '"group":"user"') != false) {
			$result = true;
		} 
		$expect = true;
		$this->assertEquals($result, $expect);
	}
	
	public function testPostRegisterInvalidRegisterChannel()
	{
		$params = array(
			 'register_channel' => 'invalidChannel'
		);

		$this->mockRequestParams($params);
		$this->usersController = App::make('UsersController');
		$result = $this->usersController->postRegister();
		$expect = null;

		$this->assertEquals($result, $expect);
	}

	public function testPostAjaxCheckEmailInvalid()
	{
		$params = array(
			 'email' => ''
		);
		$this->mockRequestParams($params);

		$this->usersController = App::make('UsersController');
		$result = $this->usersController->postAjaxCheckEmail();
		$expect = null;

		$this->assertEquals($result, $expect);
	}

	public function testPostAjaxCheckEmailValid()
	{
		$params = array(
			'email' => 'email@company.com'
		);
		$this->mockRequestParams($params);
		$this->usersController = App::make('UsersController');

		$this->memberRepositoryInterface->shouldReceive('checkEmailExists')
			->withAnyArgs()
			->andReturn('You can use this email to register.');

		$result = serialize($this->usersController->postAjaxCheckEmail());
		if(strpos($result, '{"message":"You can use this email to register."}') != false) {
			$result = true;
		} 
		$expect = true;
		$this->assertEquals($result, $expect);
	}

	public function testAjaxRequestOtpInvalid()
	{

		$params = array(
			 'mobile' => ''
		);
		$this->mockRequestParams($params);

		$this->usersController = App::make('UsersController');
		$result = $this->usersController->postAjaxRequestOtp();
		$expect = null;

		$this->assertEquals($result, $expect);
	}

	public function testAjaxRequestOtpValid()
	{
		$params = array(
			'mobile' => '0999999999'
		);
		$this->mockRequestParams($params);
		$this->usersController = App::make('UsersController');

		$this->memberRepositoryInterface->shouldReceive('requestOTP')
			->withAnyArgs()
			->andReturn('{
							status: "error",
							code: 400,
							message: "ไม่สามารถใช้งานได้ เนื่องจากระบบขัดข้อง (401)"
						}');

		$result = $this->usersController->postAjaxCheckEmail();
		$expect = null;
		$this->assertEquals($result, $expect);
	}

	public function testPostAjaxValidateOtpInvalid()
	{
		$params = array(
			'mobile' => '',
			'otp' => ''
		);
		$this->mockRequestParams($params);

		$this->usersController = App::make('UsersController');
		$result = $this->usersController->postAjaxValidateOtp();
		$expect = null;

		$this->assertEquals($result, $expect);
	}

	public function testPostAjaxValidateOtpValidMobile()
	{
		$params = array(
			'mobile' => '0999999999',
			'otp' => '11111'
		);

		$this->mockRequestParams($params);
		$this->usersController = App::make('UsersController');

		$this->memberRepositoryInterface->shouldReceive('validateOTP')
			->withAnyArgs()
			->andReturn('{
							status: "error",
							code: 400,
							message: "ไม่สามารถใช้งานได้ เนื่องจากระบบขัดข้อง (401)"
						}');

		$result = $this->usersController->postAjaxValidateOtp();

		if(strpos($result, 'status: \"error\"') != false) {
			$result = true;
		} 
		$expect = true;
		$this->assertEquals($result, $expect);
	}
}
?>