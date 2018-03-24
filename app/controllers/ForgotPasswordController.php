<?php

class ForgotPasswordController extends FrontBaseController
{
    private $pcms;

    public function __construct()
    {
        parent::__construct();

        $this->pcms = App::make('pcms');
    }

    public function getIndex()
    {
        if (!ACL::isLoggedIn())
        {
            $this->theme->set('title', __('Forgot_password'));
            $this->theme->breadcrumb()->add(__('Forgot_password'), URL::route('forgot'));

            $this->theme->asset()->container('footer')->usePath()->add('reset-password', 'js/reset-password.js');
            return $this->theme->scope('forgot.form')->render();
        }else{
            return Redirect::route('home');
        }

    }

	public function getVerifyLink()
	{
		$this->theme->set('title', __('Forgot_password'));
		$this->theme->breadcrumb()->add(__('Forgot_password'), URL::route('forgot'));

		$params_url = '';

		$sc = Input::get('sc');
		$code = Input::get('code');

		if(!empty($sc) && !empty($code))
		{
			$params_url = '?cs=itruemart&sc='.$sc.'&code='.$code;
		}
		else
		{
			return Redirect::route('home');
		}

		return $this->theme->scope('forgot.verify',compact('params_url'))->render();
	}

    public function postCheckmail()
    {
        $email = Input::get('email_username');
        $args = array(
            'email' => $email,
        );

        $response_checkemail = $this->pcms->api('members/email-exist', $args, 'GET');

        if($response_checkemail['data'] != "email not found"){
            $password_hash = $this->generateHash($response_checkemail['data']);

            if($password_hash != -1){
                  $base_url = URL::route('forgot.reset-password');
                  $reset_url = $base_url ."?p=".$password_hash;
                  $args_mail = array(
                      'reset_url' => $reset_url,
                      'customer_email' => $email
                  );
                 $response_send = $this->pcms->api('members/send-reset-password-mail', $args_mail, 'GET');

                if($response_send['data'] == 200){
                    return array(
                        'status' => true,
                        'message'  => 'Email Sent. Please check your email for a verification link.'
                    );
                }else{
                    return array(
                        'status' => false,
                        'error'  => 'System errors, please try again.'
                    );
                }


            }else {
                return array(
                    'status' => false,
                    'error'  => "System errors, please try again."
                );
            }
        }else{
            return array(
                'status' => false,
                'error'  => "Email does not exist in the system. Please check and try again."
        );
        }
    }

    public function generateHash($member_id)
    {
        $password_hash = hash('sha512', $member_id.time());
        $args = array(
            'member_id' => $member_id,
            'forgot_password_hash' => $password_hash
        );
        $save_forgot_password = $this->pcms->api('members/update-forgot-password', $args, 'GET');

        return ($save_forgot_password['data'] == 'Success' ? $password_hash : -1);
    }

    public function getResetPassword()
    {
        if (ACL::isLoggedIn())
        {
            return Redirect::route('home');
        }else {
            $forgot_password_hash = Input::get('p');
            if ($forgot_password_hash == null || $forgot_password_hash == "") {
                return Redirect::to('/404.html');
            }

            $args = array(
                'forgot_password_hash' => $forgot_password_hash
            );
            $is_forgothash_exist = $this->pcms->api('members/check-exist-forgot-hash', $args, 'GET');

            if ($is_forgothash_exist['data']['hash'] == false) {
                return Redirect::to('/404.html');
            }

            $data = array(
                'forgot_hash' => $forgot_password_hash,
            );

            $this->theme->asset()->container('footer')->usePath()->add('reset-password', 'js/reset-password.js');
            return $this->theme->scope('forgot.reset-password', $data)->render();
        }
    }

    public function postResetPassword()
    {
        $forgot_password_hash = Input::get('forgot_hash');
        $email_password = Input::get('email_password');
        $email_password_confirmation = Input::get('email_password_confirmation');

        $validator = Validator::make(
            array(
                'password'              => $email_password,
                'password_confirmation' => $email_password_confirmation
            ),
            array(
                'password'              => 'required|between:8,25|confirmed',
                'password_confirmation' => 'required'
            )
        );

        // Validator fails.
        if ($validator->fails())
        {
            $errors = $validator->errors();
            return array(
                'status' => false,
                'error'  => $errors->first()
            );
        }

        $subject = $email_password;
        $pattern = '/[A-z]+\d+[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+|[A-z]+[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+\d+|\d+[A-z]+[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+|\d+[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+[A-z]+|[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+[A-z]+\d+|[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+\d+[A-z]+/';
        preg_match($pattern, $subject, $matches_pass);

        if (!sizeof($matches_pass))
        {
            $error = 'Password must be between 8-25 characters with 1 special character, letters, and at least 1 number.';
            return array(
                'status' => false,
                'error'  => $error
            );
        }

//        $new_password_hash = hash('sha512', $email_password);
        $args = array(
            'forgot_password_hash' => $forgot_password_hash,
            'new_password_hash' => $email_password
        );

        $save_new_password = $this->pcms->api('members/reset-new-password', $args, 'GET');

        if($save_new_password['data'] == 'Success'){
            return array(
                'status' => true,
                'message'  => 'Your User Password has been reset. Please try logging in again.'
            );
        }else{
            $error = 'System errors, please try again.';
            return array(
                'status' => false,
                'error'  => $error
            );
        }
    }
}
