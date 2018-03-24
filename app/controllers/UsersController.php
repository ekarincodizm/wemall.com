<?php

class UsersController extends FrontBaseController {

    protected $member;

    public function __construct(MemberRepositoryInterface $member)
    {
        parent::__construct();

        $this->member = $member;
    }

    public function getCheckCustomerRefId(){
        $num = Input::get("num",1);
        $type = Input::get("type","all");

        echo "<h3>Customer ref id $type</h3>";
        $time = time();
        $i = 1;
        for($i;$i<=$num;$i++){
            if($type == 'old' || $type == 'all'){

                $ref_id_old = $this->member->setProfileOld($group = 'guest', $name = null, $memberId = null, $email = null, $thaiId = null, $subscribe = 0, $trueyou=null, $phone = null, $ssoId = null, $time);
                echo "<br>".$ref_id_old['user_id'];
            }

            if($type == 'new' || $type == 'all'){
                $ref_id_new = $this->member->setProfile($group = 'guest', $name = null, $memberId = null, $email = null, $thaiId = null, $subscribe = 0, $trueyou=null, $phone = null, $ssoId = null, $time);
                echo "<br>".$ref_id_new['user_id'];
            }
        }
    }

	public function getRegister()
	{
        setSeoMeta('register');
		$this->theme->setTitle( __('register').'  iTrueMart.ph' );
        $continue = array();

        $user = ACL::getUser();
        if (@$user['group'] == 'user') return Redirect::to('/');


        if ($this->isMobile())
        {
            Theme::uses('mobile');
            $this->theme->setTitle( __('register').'  iTrueMart.ph' );

            $this->theme->asset()->usePath()->add('reveal', 'css/reveal/reveal.css');
            $this->theme->asset()->usePath()->add('reveal-addon', 'css/reveal/addon.css');
            $this->theme->asset()->usePath()->add('main-css', 'css/main.css');

            $this->theme->asset()->container('footer')->usePath()->add('itruemart-validate-js', 'js/jquery.validate.min.js');
            $this->theme->asset()->container('footer')->usePath()->add('register-main', 'js/main.js');
            $this->theme->asset()->container('footer')->usePath()->add('login-register', 'js/login-register.js');

			$continue = Input::get('continue');
        }
        else
        {
            $this->theme->asset()->usePath()->add('reveal', 'css/reveal.css');
            $this->theme->asset()->container('footer')->add('jquery-reveal', 'assets/vendor/jquery.reveal.js', array('jquery'));
            $this->theme->asset()->usePath()->add('jquery-reveal', 'css/itruemart.login.css');
            $this->theme->asset()->container('footer')->usePath()->add('register-js', 'js/login-register.js');

            $continue = Input::get('continue');
        }


        return $this->theme->scope('users.register', compact('continue'))->render();
	}

    public function postRegister()
    {
        // Channel to register.
        $channel = Input::get('register_channel');

        // There is no channel.
        if ( ! in_array($channel, array('email', 'mobile'))) return;

        $data = array();

        // Filter channel input.
        foreach (Input::all() as $key => $val)
        {
            if (preg_match('/^'.$channel.'_(.*)/', $key, $matches))
            {
                $data[$matches[1]] = $val;
            }
        }

        $data['continue'] = Input::has('continue') ? Input::get('continue') : '/';

        // Replace input with the new one.
        Input::replace($data);

        try
        {
            $member = $this->member->register($data, $channel);
        }
        // Validation error.
        catch (\ValidateException $e)
        {
            $errors = $e->getMessages();

            return array(
                'status' => false,
                'error'  => $errors->first()
            );
        }
        // Coding error.
        catch (\Exception $e)
        {
            //sd($e->getMessage());

            return array(
                'status' => false,
                'error'  => $e->getMessage()
            );
        }

        // Register success.
        return array(
            'status'   => true,
            'data'     => array(
                'user_id' => !empty($member['user_id'])?$member['user_id']: ''
            ),
            'continue' => Input::has('continue') ? Input::get('continue') : '/?newmember=1'
        );

    }

    public function getAjaxGetUser()
    {
        $user = ACL::getUser();
        $user['criteo_hash'] = hashed_email($user['email']);
        return Response::json($user);
    }

    public function postAjaxCheckEmail()
    {
        $email = Input::get('email');

        if ( ! $email) return;

        $message = $this->member->checkEmailExists($email);

        return Response::json(array('message' => $message));
    }

    public function postAjaxRequestOtp()
    {
        $mobile = Input::get('mobile');

        if ( ! $mobile) return;

        $response = $this->member->requestOTP($mobile);

        return Response::json($response);
    }

    public function postAjaxValidateOtp()
    {
        $mobile = Input::get('mobile');

        $otp = Input::get('otp');

        if ( ! $mobile or ! $otp) return;

        $response = $this->member->validateOTP($mobile, $otp);

        // Stamp state for make sure this user has validate otp.
        if (isset($response['status']) and $response['status'] == 'success')
        {
            Session::put('otp-passes', $mobile);
        }

        return Response::json($response);
    }

}
