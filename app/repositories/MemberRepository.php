<?php

use Illuminate\Support\MessageBag;

class MemberRepository implements MemberRepositoryInterface {

    protected $sso;

    protected $pcmsClient;

    protected $locale;

    public function __construct()
    {
        $this->pcmsClient = App::make('pcms');

        $this->sso = App::make('sso');

        $this->locale = Lang::getLocale();
    }

    public function login($username, $password, $remember = 0)
    {
        // Validator rules.
        $validator = Validator::make(
            array(
                'username' => $username,
                'password' => $password
            ),
            array(
                'username' => 'required',
                'password' => 'required'
            )
        );

        // Validator fails.
        if ($validator->fails())
        {
            throw new \ValidateException($validator->errors());
        }

        Log::notice('Login As '.$username, array(
            '$username='.$username,
            'Request::getClientIp()='.Request::getClientIp(),
            '$remember='.$remember
        ));

        // Call API from truelife sso.
//        $res = $this->sso->loginAll($username, $password, Request::getClientIp(), $remember);

        $args = array(
            'username' => $username,
            'password' => $password,
            'remember' => $remember
        );

        $res = $this->pcmsClient->api('members/new-login', $args, 'GET');
        $res = json_decode(json_encode($res['data']));
        $profileResponse = $res;
        // Login fails from sso api.
//        sd($res);
        if ($res->result_code != 0)
        {
            if (isset($res->result_data->error->messages))
            {
                $error = $res->result_data->error->messages->{$this->locale};
            }
            else
            {
                // May be error attemps.
                $error = isset($res->result_data->error->message) 
                            ? $res->result_data->error->message
                            : "Centralize error.";  // It's error but we don't have error from SSO server.
            }

            $errors = new MessageBag(array('email' => $error));
            throw new \ValidateException($errors);
        }

        if (Session::get('safe-debug') === 'debugging')
        {
            sd($res);
        }
        $accessToken = $this->generateToken($res->result_data->uid);
//        $expired_time = 60*24;
        $expired_time = 3;
        if($remember == 0) {
            $expired_time = 0;
        }

        $this->setSession($res,$expired_time);

//        return $this->doLogin($profileResponse, $accessToken);
        return false;
    }

    public function generateToken($user_id)
    {
        return sha1($user_id.'itruemartph');
    }

    public function getUserByAccessToken($accessToken)
    {
        return $this->sso->getUserByAccessToken($accessToken);
    }

    public function getUserById($id)
    {
        return $this->sso->getUserByID($id);
    }

    public function loginByAccessToken($accessToken)
    {
        $profileResponse = $this->sso->getUserByAccessToken($accessToken);

        return $this->doLogin($profileResponse, $accessToken);
    }

    protected function doLogin($profileResponse, $accessToken, $addition = array())
    {
//        if ($profileResponse->result_code == 0)
//        {
//            $profile = $profileResponse->result_data;
//
//            // API SSO.
//            //sd($profile);
//
//            $data = array(
//                'user_id'      => $profile->uid,
//                'ssoId'        => $profile->uid,
//                'display_name' => $profile->display_name,
//                'email'        => $profile->email,
//                'group'        => 'user'
//            );
//
//            // Some information we need, such as subscribe, thai Id.
//            $data = array_merge($data, $addition);
//
//            // We need this to logout from centralize.
////            ThorCookie::set('access_token',$accessToken);
//
//            $map = $this->setProfile($data['group'], $data['display_name'], $data['ssoId'], $data['email']);
//
//            return array_merge($map, array('access_token' => $accessToken));
//        }
//        Log::debug('Before Merge Cart',array(Session::get('itmguest')));
//        $this->transfromGuest2User($old_user['user_id']);
        return false;
    }

    public function transfromGuest2User($old_id,$newid='')
    {
//        who the F add this
//        if (\ACL::isLoggedIn() == false)
//            return false;

//        $user = \ACL::getUser();
//        $value = ThorCookie::get('itmsession');
//        Log::debug('old id',array($old_id));
//        Log::debug('new id',array($value['id']));

        // $data = array(
        //     'customer_type' => PcmsClient::GUEST, // old data
        //     'customer_ref_id' => $old_id,         // old data
        //     'new_ref_id' => $user['user_id'],
        // );
        // $response = $this->pcmsClient->api('cart/update-customer', $data, 'POST');
        $data = array(
            'customer_type' => PcmsClient::USER,
            'customer_ref_id' => $newid,
            'old_customer_type' => PcmsClient::GUEST,
            'old_customer_ref_id' => $old_id,
        );
        Log::debug('Data Merge',$data);
        $response = $this->pcmsClient->api('cart/merge', $data, 'POST');

		// Get Member data
		if(array_get($response, 'data', true))
		{
			$mdata = array(
				'ssoId' => $newid
			);
			$mresponse = $this->pcmsClient->api('members/profile', $mdata, 'GET');

			// Seve customer info email
			if(!empty($mresponse))
			{
				$setdata = array(
					'customer_ref_id' => $newid,
					'customer_type' => ACL::isLoggedIn() ? 'user' : 'non-user',
					//'customer_tel' => $mresponse['data']['phone'],
					//'customer_email' => $mresponse['data']['email']
				);

                if(isset($mresponse['data']['email']) && !preg_match("/\@truelife.com$/", $mresponse['data']['email'])){
                    $setdata["customer_email"] = $mresponse['data']['email'];
                }

				$setresponse = $this->pcmsClient->api('checkout/set-customer-info', $setdata, 'POST');
			}
		}

        return array_get($response, 'data', true);
    }

    public function getUser()
    {

//        $all_session = Session::all();
//        $profile = Session::get('profile');

        $value = ThorCookie::get('itmsession');
        if($value != null && array_key_exists('id',$value)) {
            if($value['remember'] == "true") {
                @ThorCookie::set('itmsession', array(
                    'id'=>$value['ssoId'],
                    'uid'=>$value['id'],
                    'display_name' => $value['display_name'],
                    'email' => $value['email'],
                    'ssoId' => $value['ssoId'],
                    'remember' => $value['remember'],
                ), 3);
            }
            $profile = $this->setProfile('user',$value['display_name'],$value['id'],$value['email'],'','','','',$value['ssoId']);
        } else {
            $itmguest = Session::get('itmguest');
            if(!empty($itmguest)) {
                $profile = $this->setProfile('guest','null',$itmguest);
            } else {
                $profile = $this->setProfile('guest','null');
            }
        }

        return $profile;
    }

    public function setSession($res,$expired_time)
    {
        ThorCookie::set('itmsession', array(
            'id'=>$res->result_data->sso_id,
            'uid'=>$res->result_data->uid,
            'display_name' => $res->result_data->display_name,
            'email' => $res->result_data->email,
            'ssoId' => $res->result_data->sso_id,
            'remember' => $expired_time == 0?"false":"true"
        ), $expired_time);

        $itmguest = Session::get('itmguest');
        $this->transfromGuest2User($itmguest,$res->result_data->sso_id);
    }

    public function clearSession()
    {
//        ThorCookie::set('itmsession', array(), -1);
        ThorCookie::forget('itmsession');
        Log::info('clear cookie');
    }

    public function setProfileOld($group = 'guest', $name = null, $memberId = null, $email = null, $thaiId = null, $subscribe = 0, $trueyou=null, $phone = null, $ssoId = null, $time="")
    {
        $time_ref = ($time != '')?$time:time();
        $memberId = ($memberId) ?: md5(Request::getClientIP().$time_ref.rand(10,99));
        $ssoId    = ($ssoId) ?: null;

        $profile = array(
            'group'        => $group,
            'display_name' => $name,
            'user_id'      => $memberId,
            'ssoId'        => $ssoId,
            'email'        => $email,
            'phone'        => $phone,
            'thai_id'      => $thaiId,
            'subscribe'    => $subscribe,
            'trueyou'      => $trueyou
        );

        // What is my role.
        //$iam = ($group == 'guest') ? 'guest' : 'user';
        //Session::put('currentIam', $iam);
        if($group == 'guest') {
            Session::set('itmguest',$memberId);
        } else {
            Session::forget('itmguest');
        }


        //Session::put('isGuest', strcasecmp($group, 'guest') == 0);
        //Session::put('isSSOMember', strcasecmp($group, 'user') == 0);

        return $profile;
    }


    public function setProfile($group = 'guest', $name = null, $memberId = null, $email = null, $thaiId = null, $subscribe = 0, $trueyou=null, $phone = null, $ssoId = null, $time="")
    {
        //$memberId = ($memberId) ?: md5(Request::getClientIP().time().rand(1,100000));
        /**
         * Fix get customer ip address
         */
        $time_ref = ($time != '')?$time:time();
        $ip_forword = Request::header('X-Forwarded-For') ;
        $ip_client = Request::getClientIP();
        $ip = !empty($ip_forword) ? $ip_forword : $ip_client;

//        $memberId = ($memberId) ?: md5($ip.$time_ref.rand(1,100000));
        $memberId = ($memberId) ?: hash('sha256', $ip.$time_ref.rand(1,100000).rand(1,100000).rand(1,100000));
        $ssoId    = ($memberId) ?: null;

        $profile = array(
            'group'        => $group,
            'display_name' => $name,
            'user_id'      => $memberId,
            'ssoId'        => $ssoId,
            'email'        => $email,
            'phone'        => $phone,
            'thai_id'      => $thaiId,
            'subscribe'    => $subscribe,
            'trueyou'      => $trueyou
        );

        // What is my role.
        //$iam = ($group == 'guest') ? 'guest' : 'user';
        //Session::put('currentIam', $iam);

        if($group == 'guest') {
            Session::set('itmguest',$memberId);
        } else {
            Session::forget('itmguest');
        }

        //Session::put('isGuest', strcasecmp($group, 'guest') == 0);
        //Session::put('isSSOMember', strcasecmp($group, 'user') == 0);

        return $profile;
    }

    public function logout()
    {
        $this->clearSession();
        return $this->setProfile('guest');
    }

    public function requestOTP($mobile)
    {
        $res = $this->pcmsClient->api('otps/request?mobile='.$mobile, array(), 'GET');

        return $res;
    }

    public function validateOTP($mobile, $otp)
    {
        $res = $this->pcmsClient->api('otps/validate?mobile='.$mobile.'&otp='.$otp, array(), 'GET');

        return $res;
    }

    public function checkEmailExists($email)
    {
//        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $res = "Please input the correct email.";
        }else{
            $response = $this->pcmsClient->api('members/check-email?email='.$email, array(), 'GET');
            $res = $response['message'];
//            $res
        }

        return $res;

//        $res = $this->sso->checkEmailExist($email);
//
//        if (isset($res->result_data->error->messages))
//        {
//            return $res->result_data->error->messages->{$this->locale};
//        }
//
//        if (isset($res->result_data->uid))
//        {
//
//            return 'This email already taken.';
//
//        }
//
//        return 'You can use this email to register.';
    }

    public function register($data, $type = 'email')
    {
        $method = 'register'.ucfirst($type);

        $res = $this->$method($data);

        return $res;
    }

    public function checkThaiId($thaiId)
    {
        $data = array('thai_id' => $thaiId);
        $res = $this->pcmsClient->api('members/check-thai-id', $data, 'GET');

        if (array_get($res, 'status') == 'error')
        {
            throw new Exception(array_get($res, 'message'));
        }

        return true;
    }

    protected function registerEmail($data)
    {
        // Subscribe email.
        $check_subscribe = false;
        if(array_key_exists('flag',$data)){
            unset($data['flag']);
            $check_subscribe = true;
        }
        $data['subscribe'] = isset($data['subscribe']) ? 1 : 0;

        $validator = Validator::make(
            array(
                'username'              => $data['username'],
                'display_name'          => $data['display_name'],
                'password'              => $data['password'],
                'password_confirmation' => $data['password_confirmation']
            ),
            array(
                'username'              => 'required|email',
                'display_name'          => 'required|between:2,20',
                'password'              => 'required|between:8,25|confirmed',
                'password_confirmation' => 'required'
            )
        );

        // Validator fails.
        if ($validator->fails())
        {
            throw new \ValidateException($validator->errors());
        }

        $subject = $data['display_name'];
        $pattern = '/[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+/';
        preg_match($pattern, $subject, $matches_user);

        if (sizeof($matches_user))
        {
            $error = 'Display name must be between 2-20 characters. Allow letters, numbers, and spaces.';
            $errors = new MessageBag(array('password' => $error));
            throw new \ValidateException($errors);
        }

        $subject = $data['password'];
        $pattern = '/[A-z]+\d+[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+|[A-z]+[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+\d+|\d+[A-z]+[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+|\d+[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+[A-z]+|[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+[A-z]+\d+|[\+\-\.\,\[\]\{\}\?\!\@\#\$\%\^\&\*\(\)\_\:\;\/|<;>;"\']+\d+[A-z]+/';
        preg_match($pattern, $subject, $matches_pass);

        if (!sizeof($matches_pass))
        {
            $error = 'Password must be between 8-25 characters with 1 special character, letters, and at least 1 number.';
            $errors = new MessageBag(array('password' => $error));
            throw new \ValidateException($errors);
        }

        $response = $this->pcmsClient->api('members/register-global', $data, 'POST');

        if(!$response){
            $error = 'Register failed. Please try again.';
            $errors = new MessageBag(array('error' => $error));
            throw new \ValidateException($errors);
        }

        $res = json_decode(json_encode($response["data"]));

        // Error handler.
        if ($res->result_code != 0)
        {
            if (isset($res->result_data->messages))
            {
                $error = $res->result_data->messages->{$this->locale};
            }
            else
            {
                // May be error attemps.
                $error = $res->result_data->message;
            }

            $errors = new MessageBag(array('email' => $error));

            throw new \ValidateException($errors);
        }

        $accessToken = $res->result_data->access_token;
        $accessToken = (string) trim($accessToken);

        // delay process - sometimes access token isn't generate
        sleep(1);

//        $profileResponse = $this->sso->getUserByAccessToken($accessToken);
//TODO if activate mail open this
/*        $email = $data['username'];

        $code = ActivateCode::generate($email, $res->result_data->uid);

        $this->sendEmailActivate($email, $code);
*/
        // Addition information itruemart need.
//        $addition = array(
//            'thai_id'   => array_get($data, 'thai_id'),
//            'subscribe' => array_get($data, 'subscribe'),
//			'trueyou'	=> array_get($data, 'trueyou'),
//        );
        $this->setSession($res,0);

        if($check_subscribe){
            $result = array();
            $result['ssoId'] = $res->result_data->sso_id;
            return $result;
        }

    }

//    protected function registerMobile($data)
//    {
//        // Username must be mobile.
//        $data['username'] = Session::get('otp-passes');
//
//        // Subscribe email.
//        $data['subscribe'] = isset($data['subscribe']) ? 1 : 0;
//
//        $validator = Validator::make(
//            array(
//                'username'              => $data['username'],
//                'thai_id'               => $data['thai_id'],
//                'password'              => $data['password'],
//                'password_confirmation' => $data['password_confirmation']
//            ),
//            array(
//                'username'              => 'required|numeric',
//                'thai_id'               => 'numeric',
//                'password'              => 'required|confirmed|between:4,16',
//                'password_confirmation' => 'required'
//            )
//        );
//
//        // Validator fails.
//        if ($validator->fails())
//        {
//            throw new \ValidateException($validator->errors());
//        }
//
//        $res = $this->sso->registerMobilePassword(
//            $data['username'], // This must be mobile number.
//            $data['password'],
//            Request::getClientIp()
//        );
//
//        //Log::info('res', array($res));
//
//        // Error handler.
//        if ($res->result_code != 0)
//        {
//            if (isset($res->result_data->error->messages))
//            {
//                $error = $res->result_data->error->messages->{$this->locale};
//            }
//            else
//            {
//                // May be error attemps.
//                $error = $res->result_data->error->message;
//            }
//
//            $errors = new MessageBag(array('email' => $error));
//
//            throw new \ValidateException($errors);
//        }
//
//        // First login.
//        $accessToken = $res->result_data->access_token;
//        $accessToken = (string) trim($accessToken);
//
//        // delay process - sometimes access token isn't generate
//        sleep(1);
//
//        $profileResponse = $this->sso->getUserByAccessToken($accessToken);
//
//        // Addition information itruemart need.
//        $addition = array(
//            'thai_id'   => array_get($data, 'thai_id'),
//            'subscribe' => array_get($data, 'subscribe')
//        );
//
//        return $this->doLogin($profileResponse, $accessToken, $addition);
//    }

    public function sendEmailActivate($email, $code)
    {
        $emailService = new Email;
        $activateUrl = URL::route('member.confirmEmail',
            array(
                'email' => $email,
                'code' => $code,
            )
        );
        $body = View::make('emails.activate.email', array(
            'from' => Config::get('mailapp.smtp_sender'),
            'email' => $email,
            'sender' => 'iTruemart',
            'activateUrl' => $activateUrl,
        ))->render();

        $responseData = $emailService->send(
            $email,
            'ยืนยันการลงทะเบียนด้วยอีเมล์ (Verify email)',
            $body
        );

        $emailLog = new EmailLog;
        $emailLog->email = $email;

        try
        {
            $result = json_decode($responseData);
            if ($result->header->code == 200)
            {
                $emailLog->status = 'success';
            }
        }
        catch (\Exception $e)
        {
            $emailLog->status = 'failed';
            // sd($result);
        }
        $emailLog->save();

    }

    public function memberConfirmed($email, $uid)
    {
        try {
            $result = $this->sso->verifyUser($email, $uid);
            $ssoVerified = ($result->result_desc === 'success');
        }
        catch (Exception $e) {}

        try {
            $result = $this->pcmsClient->activateUser($uid);
            $pcmsVerified = ($result['code'] == 200);
        }
        catch (Exception $e) {}

        if ($ssoVerified && $pcmsVerified)
        {
            ActivateCode::whereEmail($email)->delete();
            return true;
        }

        return false;
    }

	public function checkEmailSso( $data )
	{
        $res = $this->pcmsClient->api('members/check-email?email='.$data['username'], array(), 'GET');

        if ($res['code'] == 200)
        {
            return $this->register($data);
        }else{
            $error = $res['message'];
            $errors = new MessageBag(array('email' => $error));
            throw new \ValidateException($errors);
        }

        if (isset($res->result_data->uid))
        {
			return $this->login($data['username'], $data['password'], $remember = 0);
        }

        #return 'You can use this email to register.';
	}
        
        public function getTNTTrackingNumberDetail($trackingNumber, $order_id){
            if(empty($trackingNumber) || empty($order_id)){
                throw new Exception(__("invalid-tracking-number"), 400);
            }
            
            //request pcms api..
            $tmpResponse = array(
                "id" => 1,
                "order_id" => 13123,
                "shipment_id" => 16123412,
                "order_date" => "2012-08-12 20:20:00",
                "shipment_date" => date("d/m/Y", strtotime("2012-08-12")),
                "shipment_time" => "23:00:00",
                "location" => "HK",
                "shipment_status" => "BBB",
                "fullname" => "abc"
            );
            //order_id=70093&tracking_number=123456
            $params = array(
                "order_id" => $order_id,
                "tracking_number" => $trackingNumber
            );
            $TNTdata = $this->pcmsClient->apiv2("customers/tracking-detail", $params);
            $response = array();
            if( $TNTdata["code"] == 200 && !empty($TNTdata["data"]) ){
                foreach($TNTdata["data"] as $idx => $TNTrow){
                    //clean data for frontend.
                    $TNTrow["location"] = !empty($TNTrow["location"])? $TNTrow["location"] : "";
                    $TNTrow["shipment_date"] = !empty($TNTrow["shipment_date"])? date("d/m/Y", strtotime($TNTrow["shipment_date"])) : "0/0/0000";
                    $TNTrow["shipment_status"] = !empty($TNTrow['shipment_status'])? $TNTrow['shipment_status'] : "";
                    $TNTrow["shipment_time"] = !empty($TNTrow["shipment_time"])? $TNTrow["shipment_time"] : "00:00:00";
                    array_push($response, $TNTrow);
                }
                
                return array(
                    "code" => 200,
                    "status" => "success",
                    "data" => $response
                );
            }else{
                throw new Exception(__("tracking-data-not-found"));
            }
            
        }
}