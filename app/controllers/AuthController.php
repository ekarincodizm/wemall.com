<?php
/**
 *  @author
 *  @since
 *  @modify Preme W. <preme_won@truecorp.co.th>
 *  @package  iTruemart
 *  @version  1.1
 *
 */
class AuthController extends FrontBaseController {

    protected $member;

    public function __construct(MemberRepositoryInterface $member)
    {
        parent::__construct();

        $this->member = $member;
    }

    public function getLogin()
    {
		$this->theme->setTitle( __('login').' | iTrueMart.ph' );
        $user = ACL::getUser();
        if (@$user['group'] == 'user') return Redirect::to('/');

        // Continue redirect.
        $continue = Input::get('continue');

        if ($this->isMobile())
        {
            $this->theme = Theme::uses('mobile');
            $this->theme->setTitle( __('login').' | iTrueMart.ph' );
            $this->theme->asset()->usePath()->add('login-css', 'css/login.css');
            $this->theme->asset()->container('footer')->usePath()->add('itruemart-validate-js', 'js/jquery.validate.min.js');
            $this->theme->asset()->container('footer')->usePath()->add('itruemart-login-js', 'js/login.js');
            //$this->theme->asset()->container('footer')->usePath()->add('sso-js', 'js/sso.js');
            #Theme::uses('itruemart-mobile');
        }
        else
        {
            $this->theme->asset()->container('footer')->usePath()->add('register-js', 'js/login-register.js');
            $this->theme->asset()->usePath()->add('itruemart-login-css', 'css/itruemart.login.css');
        }

        return $this->theme->scope('auth.login', compact('continue'))->render();
    }

    public function postLogin()
    {
        $this->theme->layout('blank');

        $guest = ACL::getUser();
		$type = Input::get('logintype',"");
        try
        {
            $member = $this->member->login(Input::get('username'), Input::get('password'), Input::get('remember_me', 0));

            // transform guest to user
            $this->member->transfromGuest2User($guest['user_id']);
        }
        catch (\ValidateException $e)
        {
            $errors = $e->getMessages();

			//$type = Input::get('logintype',"");
			if(!empty($type) && $type == 'user')
			{
				//return Redirect::route('checkout-step1',array('type'=>$type))->withInput()->withErrors($errors);
                $redirectUrl = URL::toLang("checkout/step1?type=".$type."&errors=".$errors->first(), array(), Config::get("https.useHttps", false));
                return Redirect::away($redirectUrl)->withInput()->withErrors($errors);
			}
			else
			{
                return Redirect::back()->withInput()->withErrors($errors);
            }
		}
        catch (\Exception $e)
        {

            Log::notice('Post Login  Exception', array('code'=>$e->getCode(),'desc'=>$e->getMessage()));

            return Redirect::back()->withInput()->withErrors(array("System error! Please try again."));
        }

		if(!empty($type) && $type == 'user')
		{
			$CustomerAddressRepository = App::make('CustomerAddressRepository');
			$CustomerAddressRepository->saveStage('step1');
		}

        $continue = Input::get('continue');

		$tmp_con = explode('/', $continue);

		if(!empty($tmp_con))
		{
			if(in_array('register', $tmp_con))
			{
				$continue = '';
			}
		}

        // Where to go.
        $path = (str_contains($continue, 'login') or $continue == false) ? URL::toLang('/') : $continue;

        // This for JS.
        $data = array(
            'remember_me'  => Input::get('remember_me', 0),
            'access_token' => $member['access_token'],
            'type'         => 'web',
            'redirect'     => $path
        );

//        $cache_key = Request::root() ."/". Lang::locale() . "_homepage";
//        ElastiCache::save($cache_key, null, null, 0);

        // Call JS to sync with central truelife.
        $this->theme->asset()->container('embed')->writeScript('logout', '

            noSyncCentralize = true;

            centralLogin('.json_encode($data).');

        ');

        return $this->theme->scope('auth.sync')->render();
    }

    /**
     * Sync SSO call from ajax.
     *
     * @return void
     */
    public function postAjaxSync()
    {
        $accessToken = Input::get('accessToken');

        // Develop environment cannot sync.
        // if ((App::environment() == 'dev' || App::environment() == 'alpha') and $accessToken)
        // {
        //     $accessToken = '1|1.6f6563f65a661737a437f0__3600.1425524124-18052198|bb2904be1698a83e72d1c84f520';
        // }

        // if ( ! $accessToken )
        // {
        //     return $this->member->logout();
        // }

        // $this->member->loginByAccessToken($accessToken);

        // return 'ok';

        # new logic

        $redirect = false;

        if ( ! $accessToken )
        {
            // don't have access token so logout
            // but check user....
            if (ACL::isLoggedIn())
            {
                // logout
                $this->member->logout();

                $redirect = true;
            }
        }
        else
        {
            // have access but we will check access token is for new member or not
            // and user has logged in on itruemart

            $shouldLogIn = false;

            if (! ACL::isLoggedIn())
            {
                // user is guest so log in
                $shouldLogIn = true;
            }
            else
            {
                // get current ssoId
                $user = ACL::getUser();
                $ssoId = array_get($user, 'ssoId');

                if (! str_contains($accessToken, $ssoId))
                {
                    // cannot find ssoId in access token so log in
                    // maybe sso id is change
                    $shouldLogIn = true;
                }
            }

            if ($shouldLogIn)
            {
                // log in
                $result = $this->member->loginByAccessToken($accessToken);

                // result should be array
                if ($result)
                {
                    $redirect = true;
                }
            }
        }

        return array('redirect' => $redirect);
    }

    public function getLogout()
    {
        $this->member->logout();
        $this->theme->layout('blank');

        $endpoint = Config::get('endpoints.sso');
        $endpoint['app_id'] = array_get($endpoint, 'app_id');
        $endpoint['secret_key'] = array_get($endpoint, 'secret_key');

        $redirectTo = Request::server('HTTP_REFERER');

        if ($redirectTo !== '' && preg_match("/profile/", $redirectTo))
        {
            $redirectTo = '/auth/login';
        }

        // protect loop itself
        if (str_contains($redirectTo, 'auth/logout') || $redirectTo == false)
        {
            $redirectTo = '/'; // redirect to home instend
        }

        // This for JS.
        $data = array(
            // we use access token from checkcentralize, not from cookie
            // 'access_token' => @$_COOKIE['access_token'],
            'app_id'       => $endpoint['app_id'],
            'secret_key'   => $endpoint['secret_key'],
            'type'         => 'web',
            'redirect'     => $redirectTo
        );

//        $cache_key = Request::root() ."/". Lang::locale() . "_homepage";
//        ElastiCache::save($cache_key, null, null, 0);

        // Call JS to sync with central truelife.
        $this->theme->asset()->container('embed')->writeScript('logout', '

            noSyncCentralize = true;

            centralLogout('.json_encode($data).');

        ');

        return $this->theme->scope('auth.sync')->render();
    }

}
