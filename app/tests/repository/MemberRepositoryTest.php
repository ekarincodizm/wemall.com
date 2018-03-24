<?php

class MemberRepositoryTest extends TestCase
{

    protected $pcms;
//    protected $sso;

    public function setUp()
    {
        parent::setUp();

        $this->pcms = $this->mockSpecific("pcms");

//        $this->sso = $this->mockSpecific("TrueSSO");
    }

    public function tearDown()
    {
        parent::tearDown();
        \Mockery::close();
    }

    private function mockRequestParams($params)
    {
        Input::merge( $params );
    }

    /*
     * login($username, $password, $remember = 0)
     * $username = '';
     * $password = '';
     * */
    public function testParseDataThrowValidateError()
    {
        $user = '';
        $pass = '';

        $sso = $this->mockSpecific("sso");
        $sso->shouldReceive('loginAll')
            ->withAnyArgs()
            ->andReturn(json_decode(json_encode(array())));

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->login($user, $pass, 0);

        }catch (ValidateException $e) {
            $result = $e->getCode();
        }

        $this->assertEquals( 0, $result );
    }

    /*
     * login($username, $password, $remember = 0)
     * $username = xxx@xxx.com
     * $password = '12345';
     *
     * */
    public function testParseDataLoginAllAndReturnErrorMsg()
    {
        Log::shouldReceive('notice')
            ->withAnyArgs()
            ->andReturn(true);

        $data_login = array(
            'result_code' => 400,
            'result_data' => array(
                'error' => array(
                    'messages' => array(
                        'th' => "Error",
                        'en' => "Error",
                    )
                )
            )
        );
        $data_login = json_decode(json_encode($data_login));

        $sso = $this->mockSpecific("sso");
        $sso->shouldReceive('loginAll')
            ->withAnyArgs()
            ->andReturn($data_login);

        $user = 'xxx@xxx.com';
        $pass = '12345';

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->login($user, $pass, 0);

        }catch (ValidateException $e) {
            $result = $e->getCode();
        }

        $this->assertEquals( 0, $result );
    }

    public function testParseDataLoginAllAndReturnError()
    {
        Log::shouldReceive('notice')
            ->withAnyArgs()
            ->andReturn(true);

        $data_login = array(
            'result_code' => 400,
            'result_data' => array()
        );
        $data_login = json_decode(json_encode($data_login));

        $sso = $this->mockSpecific("sso");
        $sso->shouldReceive('loginAll')
            ->withAnyArgs()
            ->andReturn($data_login);

        $user = 'xxx@xxx.com';
        $pass = '12345';

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->login($user, $pass, 0);

        }catch (ValidateException $e) {
            $result = $e->getCode();
        }

        $this->assertEquals( 0, $result );
    }

    /*
     * login($username, $password, $remember = 0)
     * $username = xxx@xxx.com
     * $password = '12345';
     *
     * */
    public function testParseDataLoginAllAndReturnDoLogin()
    {
        Log::shouldReceive('notice')
            ->withAnyArgs()
            ->andReturn(true);

        $data_login = new stdClass();
        $result_data = array('access_token' => '12345');
        $data_login->result_code = 0;
        $data_login->result_data = (object) $result_data;

        $sso = $this->mockSpecific("sso");
        $sso->shouldReceive('loginAll')
            ->withAnyArgs()
            ->andReturn($data_login)
            ->shouldReceive('getUserByAccessToken')
            ->withAnyArgs()
            ->andReturn('12345');

        $user = 'xxx@xxx.com';
        $pass = '12345';

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->login($user, $pass, 0);

        }catch (Exception $e) {
            $result = $e->getCode();
        }

        $this->assertEquals( 0, $result );
    }

    /*
     * getUserByAccessToken($accessToken)
     * $accessToken = '12345';
     * */
    public function testGetUserByAccessTokenAndReturnAccessToken()
    {
        $sso = $this->mockSpecific("sso");
        $sso->shouldReceive('getUserByAccessToken')
            ->withAnyArgs()
            ->andReturn('12345');

        $memberRepo = App::make('MemberRepository');
        $result = $memberRepo->getUserByAccessToken('12345');
        $this->assertEquals( '12345', $result );
    }

    /*
     * getUserById($id)
     * $id = '12345';
     * */
    public function testGetUserByIdAndReturnUserId()
    {
        $sso = $this->mockSpecific("sso");
        $sso->shouldReceive('getUserByID')
            ->withAnyArgs()
            ->andReturn('12345');

        $memberRepo = App::make('MemberRepository');
        $result = $memberRepo->getUserByID('12345');
        $this->assertEquals( '12345', $result );
    }

    /*
     * loginByAccessToken($id)
     * $accessToken = '12345';
     * */
    public function testLoginByAccessTokenAndReturnLogin()
    {
        $sso = $this->mockSpecific("sso");
        $sso->shouldReceive('getUserByAccessToken')
            ->withAnyArgs()
            ->andReturn('12345');

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->loginByAccessToken('12345');

        }catch (Exception $e) {
            $result = $e->getCode();
        }

        $this->assertEquals( 0, $result );
    }

    /*
     * transfromGuest2User($old_id)
     * $old_id = 12345;
     *
     * */
    public function testDoLoginAndReturnFalse()
    {
        $sso = $this->mockSpecific("sso");
        $sso->shouldReceive('getUserByAccessToken')
            ->withAnyArgs()
            ->andReturn('12345');

        $this->mockACL(true);

        $responseData = array(
            'data' => array(
                'phone' => '1234567890',
                'email' => 'xxx@xxx.com',
            )
        );

        $this->pcms->shouldReceive('api')
            ->andReturn($responseData);

        $expect_result = array(
            'phone' => '1234567890',
            'email' => 'xxx@xxx.com',
        );

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->transfromGuest2User('12345');

        }catch (Exception $e) {
            $result = $e->getCode();
        }
        $this->assertEquals( $expect_result, $result );
    }

    /*
     * getUser()
     *
     * */
    public function testGetUserReturnUserData()
    {
        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->getUser();

        }catch (Exception $e) {
            $result = $e->getCode();
        }
        $this->assertEquals( 'guest', array_get($result, 'group') );
    }

    /*
     * setProfile($group = 'guest', $name = null, $memberId = null, $email = null, $thaiId = null, $subscribe = 0, $trueyou=null, $phone = null)
     *
     * */
    public function testSetProfileReturnUserData()
    {
        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->setProfile($group = 'guest', $name = null, $memberId = '12345', $email = null, $thaiId = null, $subscribe = 0, $trueyou=null, $phone = null);

        }catch (Exception $e) {
            $result = $e->getCode();
        }
        $this->assertEquals( 'guest', array_get($result, 'group') );
    }

    /*
     * logout()
     *
     * */
    public function testLogoutReturnUserData()
    {
        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->logout();

        }catch (Exception $e) {
            $result = $e->getCode();
        }
        $this->assertEquals( 'guest', array_get($result, 'group') );
    }

    /*
     * requestOTP($mobile)
     *
     * */
    public function testRequestOTPReturnUserData()
    {
        $this->pcms->shouldReceive('api')
            ->andReturn('12345');

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->requestOTP('123456789');

        }catch (Exception $e) {
            $result = $e->getCode();
        }
        $this->assertEquals( '12345', $result );
    }

    /*
     * validateOTP($mobile,$otp)
     *
     * */
    public function testValidateOTPReturnUserData()
    {
        $this->pcms->shouldReceive('api')
            ->andReturn('12345');

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->validateOTP('123456789', '12345');

        }catch (Exception $e) {
            $result = $e->getCode();
        }
        $this->assertEquals( '12345', $result );
    }

    /*
     * checkEmailExists($email)
     * $email = '';
     *
     * */
    public function testCheckEmailExistsReturnError()
    {
        $data = array(
            'result_code' => 400,
            'result_data' => array(
                'error' => array(
                    'messages' => array(
                        'th' => "Error",
                        'en' => "Error",
                    )
                )
            )
        );
        $data = json_decode(json_encode($data));

        $sso = $this->mockSpecific("sso");
        $sso->shouldReceive('checkEmailExist')
            ->andReturn($data);

        $this->pcms->shouldReceive('api')
            ->andReturn('12345');

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->checkEmailExists('');

        }catch (Exception $e) {
            $result = $e->getCode();
        }
        $this->assertEquals( 'Error', $result );
    }

    /*
     * checkEmailExists($email)
     * $email = '';
     *
     * */
    public function testCheckEmailExistsReturnOk()
    {
        $data = array(
            'result_data' => array(
                'uid' => '123'
            )
        );
        $data = json_decode(json_encode($data));

        $sso = $this->mockSpecific("sso");
        $sso->shouldReceive('checkEmailExist')
            ->andReturn($data);

        $this->pcms->shouldReceive('api')
            ->andReturn('12345');

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->checkEmailExists('xxx@xxx.com');

        }catch (Exception $e) {
            $result = $e->getCode();
        }
        $this->assertEquals( 'This email already taken.', $result );
    }

    /*
     * checkEmailExists($email)
     * $email = '';
     *
     * */
    public function testCheckEmailExistsReturnUsed()
    {
        $sso = $this->mockSpecific("sso");
        $sso->shouldReceive('checkEmailExist')
            ->andReturn(false);

        $this->pcms->shouldReceive('api')
            ->andReturn('12345');

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->checkEmailExists('');

        }catch (Exception $e) {
            $result = $e->getCode();
        }
        $this->assertEquals( 'You can use this email to register.', $result );
    }

    /*
     * checkThaiId($thaiId)
     * $data = array();
     * $type = 'email';
     *
     * */
    public function testCheckThaiIdReturnThrowexception()
    {
        $data = array(
            'status' => 'error'
        );

        $this->pcms->shouldReceive('api')
            ->andReturn($data);

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->checkThaiId('1234567890123');

        }catch (Exception $e) {
            $result = $e->getCode();
        }
        $this->assertEquals( 0, $result );
    }

    /*
     * checkThaiId($thaiId)
     * $data = array();
     * $type = 'email';
     *
     * */
    public function testCheckThaiIdReturnTrue()
    {
        $this->pcms->shouldReceive('api')
            ->andReturn(array());

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->checkThaiId('1234567890123');

        }catch (Exception $e) {
            $result = $e->getCode();
        }
        $this->assertEquals( true, $result );
    }

    /*
     * register($data, $type = 'email')
     * $data = array();
     * $type = 'email';
     *
     * */
//    public function testRegisterReturnThrowexception()
//    {
//        try {
//            $memberRepo = App::make('MemberRepository');
//            $result = $memberRepo->register(array(), 'email');
//
//        }catch (Exception $e) {
//            $result = $e->getCode();
//        }
//        $this->assertEquals( 0, $result );
//    }

    /*
     * register($data, $type)
     * $data = array();
     * $type = email
     *
     * */
    public function testRegisterEmailReturnValidateFail()
    {
        $data = array(
            'username' => '',
            'display_name' => 'display_name',
            'thai_id' => 'thai_id',
            'password' => 'password',
            'password_confirmation' => 'password_confirmation'
        );

        $validator = Validator::shouldReceive('make')
            ->andReturn(Mockery::self())
            ->shouldReceive('fails')
            ->andReturn(true);

        $this->pcms->shouldReceive('api')
            ->andReturn(array());

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->register($data, 'email');

        }catch (Exception $e) {
            $result = $e->getCode();
        }
        $this->assertEquals( 0, $result );
    }

    /*
     * register($data, $type)
     * $data = array();
     * $type = email
     *
     * */
    public function testRegisterEmailReturnCheckThaiIdError()
    {
        $data = array(
            'username' => 'username',
            'display_name' => 'display_name',
            'thai_id' => '1234',
            'password' => 'password',
            'password_confirmation' => 'password_confirmation'
        );

        Validator::shouldReceive('make')
            ->andReturn(Mockery::self())
            ->shouldReceive('fails')
            ->andReturn(false);

        $data_api = array(
            'status' => 'error'
        );

        $this->pcms->shouldReceive('api')
            ->andReturn($data_api);

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->register($data, 'email');

        }catch (Exception $e) {
            $result = $e->getCode();
        }
        $this->assertEquals( 0, $result );
    }

    /*
     * register($data, $type)
     * $data = array();
     * $type = email
     *
     * */
    public function testRegisterEmailReturnErrorFromRegisterGlobalWithMessage()
    {
        $data = array(
            'username' => 'username',
            'display_name' => 'display_name',
            'thai_id' => '1234',
            'password' => 'password',
            'password_confirmation' => 'password_confirmation'
        );

        Validator::shouldReceive('make')
            ->andReturn(Mockery::self())
            ->shouldReceive('fails')
            ->andReturn(false);

        $this->pcms->shouldReceive('api')
            ->andReturn(true);

        $data_api = array(
            'result_code' => 400,
            'result_data' => array(
                'dataReturn' => array(
                    'error' => array(
                        'messages' => array(
                            'th' => "Error",
                            'en' => "Error",
                        )
                    )
                )
            )
        );
        $data_api = json_decode(json_encode($data_api));
        $sso = $this->mockSpecific("sso");
        $sso->shouldReceive('registerGlobal')
            ->withAnyArgs()
            ->andReturn($data_api);

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->register($data, 'email');

        }catch (Exception $e) {
            $result = $e->getCode();
        }
        $this->assertEquals( 0, $result );
    }

    /*
     * register($data, $type)
     * $data = array();
     * $type = email
     *
     * */
    public function testRegisterEmailReturnErrorFromRegisterGlobalNoMessage()
    {
        $data = array(
            'username' => 'username',
            'display_name' => 'display_name',
            'thai_id' => '1234',
            'password' => 'password',
            'password_confirmation' => 'password_confirmation'
        );

        Validator::shouldReceive('make')
            ->andReturn(Mockery::self())
            ->shouldReceive('fails')
            ->andReturn(false);

        $this->pcms->shouldReceive('api')
            ->andReturn(true);

        $data_api = array(
            'result_code' => 0,
            'result_data' => array()
        );
        $data_api = json_decode(json_encode($data_api));
        $sso = $this->mockSpecific("sso");
        $sso->shouldReceive('registerGlobal')
            ->withAnyArgs()
            ->andReturn($data_api);

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->register($data, 'email');

        }catch (Exception $e) {
            $result = $e->getCode();
        }
        $this->assertEquals( 0, $result );
    }

    /*
     * register($data, $type)
     * $data = array();
     * $type = email
     *
     * */
    public function testRegisterEmailReturnSuccess()
    {
        $data = array(
            'email' => 'xxx@xxx.xom',
            'username' => 'username',
            'display_name' => 'display_name',
            'thai_id' => '1234',
            'password' => 'password',
            'password_confirmation' => 'password_confirmation'
        );

        Validator::shouldReceive('make')
            ->andReturn(Mockery::self())
            ->shouldReceive('fails')
            ->andReturn(false);

        $this->pcms->shouldReceive('api')
            ->andReturn(true);

        $data_api = array(
            'result_code' => 0,
            'result_data' => array(
                'uid' => '11',
                'access_token' => '123456'
            )
        );
        $data_api = json_decode(json_encode($data_api));

        $data_api_2 = array(
            'result_code' => 200,
            'result_data' => array(
                'uid' => '11',
                'access_token' => '123456'
            )
        );
        $data_api_2 = json_decode(json_encode($data_api_2));

        $sso = $this->mockSpecific("sso");
        $sso->shouldReceive('registerGlobal')
            ->withAnyArgs()
            ->andReturn($data_api)
            ->shouldReceive('getUserByAccessToken')
            ->withAnyArgs()
            ->andReturn($data_api_2);

        $this->mockSpecific('ActivateCode')
            ->shouldReceive('generate')
            ->andReturn('1111');


        //$this->mockSpecific('URL')
        URL::shouldReceive('route')
            ->andReturn('http://localhost');

        View::shouldReceive('make')
            ->andReturn(\Mockery::self())
            ->shouldReceive('render')
            ->andReturn('body');

        $emailService = array(
            'header' => array(
                'code' => 200
            )
        );
        $this->mockSpecific('Email')
            ->shouldReceive('send')
            ->andReturn(json_encode($emailService));

        $this->mockSpecific('EmailLog')
            ->shouldReceive('setAttribute')
            ->andReturn(\Mockery::self())
            ->shouldReceive('save')
            ->andReturn(true);

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->register($data, 'email');

        }catch (Exception $e) {
            $result = $e->getCode();
        }

        //$this->assertEquals( false, $result );
        $this->assertEquals( 1045, $result );
    }

    /*
     * register($data, $type)
     * $data = array();
     * $type = email
     *
     * */
    public function testRegisterEmailReturnFail()
    {
        $data = array(
            'email' => 'xxx@xxx.xom',
            'username' => 'username',
            'display_name' => 'display_name',
            'thai_id' => '1234',
            'password' => 'password',
            'password_confirmation' => 'password_confirmation'
        );

        Validator::shouldReceive('make')
            ->andReturn(Mockery::self())
            ->shouldReceive('fails')
            ->andReturn(false);

        $this->pcms->shouldReceive('api')
            ->andReturn(true);

        $data_api = array(
            'result_code' => 0,
            'result_data' => array(
                'uid' => '11',
                'access_token' => '123456'
            )
        );
        $data_api = json_decode(json_encode($data_api));

        $data_api_2 = array(
            'result_code' => 200,
            'result_data' => array(
                'uid' => '11',
                'access_token' => '123456'
            )
        );
        $data_api_2 = json_decode(json_encode($data_api_2));

        $sso = $this->mockSpecific("sso");
        $sso->shouldReceive('registerGlobal')
            ->withAnyArgs()
            ->andReturn($data_api)
            ->shouldReceive('getUserByAccessToken')
            ->withAnyArgs()
            ->andReturn($data_api_2);

        $this->mockSpecific('ActivateCode')
            ->shouldReceive('generate')
            ->andReturn('1111');


        //$this->mockSpecific('alias:URL')
        URL::shouldReceive('route')
            ->andReturn('http://localhost');

        View::shouldReceive('make')
            ->andReturn(\Mockery::self())
            ->shouldReceive('render')
            ->andReturn('body');

        $this->mockSpecific('Email')
            ->shouldReceive('send')
            ->andReturn('sended');

        $this->mockSpecific('EmailLog')
            ->shouldReceive('setAttribute')
            ->andReturn(\Mockery::self())
            ->shouldReceive('save')
            ->andReturn(true);

        try {
            $memberRepo = App::make('MemberRepository');
            $result = $memberRepo->register($data, 'email');

        }catch (Exception $e) {
            $result = $e->getCode();
        }
        //$this->assertEquals( false, $result );
        $this->assertEquals( 1045, $result );
    }

}
