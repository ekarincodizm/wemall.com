<?php

class AuthControllerTest extends TestCase
{

    /**
     * @var AuthController
     */
    protected $auth;
    protected $pcms;

    /**
     * @var MemberRepository|Mockery\Mock
     */
    protected $memberRepo;

    public function setUp()
    {
        parent::setUp();

        $this->pcms = $this->mockSpecific('pcms');
        $this->memberRepo = $this->mockSpecific('MemberRepositoryInterface');

        $this->MockThemeWithScope();
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function mockRequestParams($params)
    {
        Input::merge( $params );
    }

    public function mockIsMobile($url = 'm.itruemart.com')
    {
        Request::shouldReceive("server")
            ->andReturn($url)
            ->shouldReceive("input")
            ->andReturn(true)
            ->shouldReceive("merge")
            ->andReturn(array());
    }

    /*
     * getLogin()
     * web
     *
     * */
    public function testGetLogin()
    {
        $this->mockACL(false);

        $params = array(
            'continue' => '',
        );
        $this->mockRequestParams($params);

          $this->auth = App::make('AuthController');
        $result = $this->auth->getLogin();
        $this->assertEquals($result, 'success');
    }

    /*
     * getLogin()
     * mobile
     *
     * */
    public function testGetLoginMobile()
    {
        $this->mockIsMobile();
        $this->mockACL(false);

        $params = array(
            'continue' => '1',
        );
        $this->mockRequestParams($params);

        $auth = App::make('AuthController');
        $result = $auth->getLogin();
        $this->assertEquals($result, 'success');
    }

    /*
     * postLogin()
     *
     * */
    public function testPostLogin()
    {
        $this->mockACL();

        $params = array(
            'logintype' => 'user',
            'username' => 'username_xxx',
            'password' => 'password_xxx',
            'remember_me' => 0,
            'continue' => '/register',
        );
        $this->mockRequestParams($params);

        $memberRepo = array(
            'access_token' => 'xxx',
        );
        $this->memberRepo->shouldReceive('login')
            ->andReturn($memberRepo)
            ->shouldReceive('transfromGuest2User')
            ->andReturn(true);

        $this->mockSpecific('CustomerAddressRepository')->shouldReceive('saveStage')
            ->andReturn(true);

        $auth = App::make('AuthController');
        $result = $auth->postLogin();
        $this->assertEquals($result, 'success');
    }

    /*
     * postLogin()
     * catch (\Exception $e)
     *
     * */
    public function testPostLoginCatchException()
    {
        $this->mockACL();

        $params = array(
            'logintype' => 'user',
            'username' => '',
            'password' => '',
            'remember_me' => 0,
            'continue' => '',
        );
        $this->mockRequestParams($params);

        Log::shouldReceive('notice')
            ->andReturn(\Mockery::self());

        Redirect::shouldReceive('back')
            ->andReturn(\Mockery::self())
            ->shouldReceive('withInput')
            ->andReturn(\Mockery::self())
            ->shouldReceive('withErrors')
            ->andReturn('System error! Please try again.');

        $auth = App::make('AuthController');
        $result = $auth->postLogin();
        $this->assertEquals($result, 'System error! Please try again.');
    }

    public function testPostLoginCatchValidateException()
    {
        $this->mockACL();

        $params = array(
            'logintype' => 'user',
            'username' => '',
            'password' => '',
            'remember_me' => 0,
            'continue' => '',
        );
        $this->mockRequestParams($params);

        $message = $this->mockSpecific('Illuminate\Support\MessageBag');
        $this->memberRepo->shouldReceive('login')->andThrow(new ValidateException($message));

        $url = URL::shouldReceive('toLang')
            ->andReturn('xxx')
            ->shouldReceive('setRequest')
            ->andReturn(true);

        $message->shouldReceive('first')->andReturn(true);
        Config::shouldReceive('get')->andReturn(true);
        Request::shouldReceive("server")
            ->andReturn($url)
            ->shouldReceive("input")
            ->andReturn(true);


        Redirect::shouldReceive('away')
            ->andReturn(\Mockery::self())
            ->shouldReceive('withInput')
            ->andReturn(\Mockery::self())
            ->shouldReceive('withErrors')
            ->andReturn('Throw ValidateException Message');

        $auth = App::make('AuthController');
        $result = $auth->postLogin();
        $this->assertEquals($result, 'Throw ValidateException Message');
    }

    public function testPostLoginCatchValidateExceptionRedirectBack()
    {
        $this->mockACL();

        $params = array(
            'logintype' => 'xxx',
            'username' => '',
            'password' => '',
            'remember_me' => 0,
            'continue' => '',
        );

        $this->mockRequestParams($params);

        $message = $this->mockSpecific('Illuminate\Support\MessageBag');
        $this->memberRepo->shouldReceive('login')->andThrow(new ValidateException($message));

        $url = URL::shouldReceive('toLang')
            ->andReturn('xxx')
            ->shouldReceive('setRequest')
            ->andReturn(true);

        $message->shouldReceive('first')->andReturn(true);
        Config::shouldReceive('get')->andReturn(true);

        Redirect::shouldReceive('back')
            ->andReturn(\Mockery::self())
            ->shouldReceive('withInput')
            ->andReturn(\Mockery::self())
            ->shouldReceive('withErrors')
            ->andReturn('Throw ValidateException Message');

        $auth = App::make('AuthController');
        $result = $auth->postLogin();
        $this->assertEquals($result, 'Throw ValidateException Message');
    }


    /*
     * postAjaxSync()
     *
     * */
    public function testPostAjaxSyncReturnRedirectTrue()
    {
        $this->mockACL(true);

        $this->memberRepo->shouldReceive('logout')->andReturn(true);

        $auth = App::make('AuthController');
        $result = $auth->postAjaxSync();

        $expected = array('redirect' => true);
        $this->assertEquals($result, $expected);
    }

    /*
     * postAjaxSync()
     *
     * */
    public function testPostAjaxSyncReturnShouldLogInTrue()
    {
        $this->mockACL(false);
        $params = array(
            'accessToken' => 'accessToken_xxx'
        );
        $this->mockRequestParams($params);

        $this->memberRepo->shouldReceive('loginByAccessToken')->andReturn(true);

        $auth = App::make('AuthController');
        $result = $auth->postAjaxSync();

        $expected = array('redirect' => true);
        $this->assertEquals($result, $expected);
    }

    /*
     * postAjaxSync()
     *
     * */
    public function testPostAjaxSyncReturnShouldLogIn()
    {
        $this->mockACL(true);
        $params = array(
            'accessToken' => 'accessToken_xxx'
        );
        $this->mockRequestParams($params);

        $this->memberRepo->shouldReceive('loginByAccessToken')->andReturn(true);

        $auth = App::make('AuthController');
        $result = $auth->postAjaxSync();

        $expected = array('redirect' => true);
        $this->assertEquals($result, $expected);
    }

    /*
     * getLogout()
     *
     * */
    public function testGetLogOut()
    {
        $config = array(
            'app_id' => '1',
            'secret_key' => 'secret_key_xxxx',
        );
        Config::shouldReceive('get')
            ->andReturn($config);

        $this->mockIsMobile('m.itruemart.com/profile/');

        $this->memberRepo->shouldReceive('logout')->andReturn(true);

        $auth = App::make('AuthController');
        $result = $auth->getLogout();
        $this->assertEquals($result, 'success');
    }

    /*
     * getLogout()
     *
     * */
    public function testGetLogOutAuthLogOut()
    {
        $config = array(
            'app_id' => '1',
            'secret_key' => 'secret_key_xxxx',
        );
        Config::shouldReceive('get')
            ->andReturn($config);

        $this->mockIsMobile('m.itruemart.com/auth/logout');

        $this->memberRepo->shouldReceive('logout')->andReturn(true);

        $auth = App::make('AuthController');
        $result = $auth->getLogout();
        $this->assertEquals($result, 'success');
    }

}
