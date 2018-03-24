<?php

 /**
 *  True Life Single Sign On
 *
 * Created on    12/11/2010
 * Updated on    29/06/2012
 * @package      SSO
 * @author       Sumran Nuntasen | www.phpfreedom.com | recordset@gmail.com
 * @version      Version 2.1
 */

class TrueSSO {

    private $app_id = null;
    private $secret  = null;

    private $url_auth = null;
    private $url_profile = null;
    private $url_member = null;


    public $debug = false;

    public function __construct($config)
    {
        $this->app_id      = array_get($config, 'app_id');
        $this->secret      = array_get($config, 'secret_key');
        $this->url_auth    = array_get($config, 'url_auth');
        $this->url_profile = array_get($config, 'url_profile');
        $this->url_member  = array_get($config, 'url_member');
    }

     /**
     * The function for  Register TrueCard
     *
     * @param string  $username
     * @param string  $password
     * @param string  $thaiid
     * @param string  $email
     * @param string  $language
     * @return object
     * @access public
     */
    public function registerTrueCard($username,$password,$thaiid,$email,$language='th')
    {
        $url = "http://new.truelife.com/api/profile/rest/?method=registerAll&app_id=".$this->app_id."&secretKey=".$this->secret."&apiKey=9ae438a7c441a132c698c6389b95ad72&username=".$username."&password=".$password."&display_name=".$username."&language=".$language."&thaiid=".$thaiid."&cemail=".$email."&carrier=&format=json";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_URL,$url);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result);

        if($result==null || $result=='')
        {
            $result = substr(trim($result),3);
            $result = json_decode($result);
        }
        $result = (object) $result;
        if($result->response->header->code==200)
        {
            $response->result_code = 0;
            $response->result_desc = 'Success';
            $response->result_data->uid = $result->response->profile->sso_uid;
            $response->result_data->access_token = $result->response->profile->sso_access_token;
            $response->result_data->expires =$result->response->profile->sso_expires;
        }else{
            $response->result_code = 1000;
            $response->result_desc = $result->response->header->description;
            $response->result_data =  '';
        }
        return $response;
    }

   /**
     * The function for  Register user to sso
     *
     * @param string  $email
     * @param string  $password
     * @param string  $displayname
     * @param string  $ip (192.168.1.1or $_SERVER['REMOTE_ADDR'])
     * @param string  $device
     * @param string  $gender (male,female)
     * @param string  $birthday (1982-02-26)
     * @param string  $register_longitude
     * @param string  $register_latitude
     * @return object
     * @access public
     */

     public function registerGlobal($email,$password,$display_name,$ip,$device='',$gender='',$birthday='',$register_longitude='',$register_latitude='')
     {
        $param = array(
            'method'             => 'registerGlobal',
            'email'              => $email,
            'password'           => base64_encode($password),
            'display_name'       => $display_name,
            'gender'             => $gender,
            'birthday'           => $birthday,
            'ip'                 => $ip,
            'register_longitude' => $register_longitude,
            'register_latitude'  => $register_latitude,
            'app_id'             => $this->app_id,
            'secret'             => $this->secret
        );



        $result =  $this->CURL($this->url_member, $param);

        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
            $result->result_data = @$result->result_data;
        }else{
            $result->result_data = @$result->result_data->dataReturn;
        }

        return $result;
     }


     /**
     * The function for  login All SSO
     *
     * @param string $account
     * @param string $password
     * @param strng $ip
     * @param string
     * @return object
     * @access public
     */

     public function loginAll($account, $password, $ip, $rm = 0, $device = '', $type = 'web')
     {
        $param = array(
            'method'   => 'loginAll',
            'account'  => $account,
            'password' => base64_encode($password),
            'rm'       => ($rm ? '1' : '0'),
            'ip'       => $ip,
            'device'   => $device,
            'app_id'   => $this->app_id,
            'secret'   => $this->secret,
            'type'     => $type
        );

        if (Session::get('safe-debug') === 'debugging')
        {
            s($this->url_member, $param);
        }

        $result =  $this->CURL($this->url_member,$param,60);

        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = $result->result_data->dataReturn->error->code==''?1000:$result->result_data->dataReturn->error->code;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        // sd($result->result_data);

        return $result;
     }

     /**
     * The function for  login SSO
     *
     * @param string $email
     * @param string $password
     * @param strng $ip
     * @param string
     * @return object
     * @access public
     */

     public function login($email,$password,$ip,$rm='0',$device='',$type='web')
     {
        $param = array(
            'method' => 'login',
            'email'=>$email,
            'password' =>base64_encode($password),
            'rm'=>$rm,
            'ip'=>$ip,
            'device'=>$device,
            'app_id'=>$this->app_id,
            'secret'=>$this->secret,
            'type'=>$type
        );

        $result =  $this->CURL($this->url_member,$param,10);
        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
     }

       /**
     * The function for  login mobile password
     *
     * @param string $mobile
     * @param string $password
     * @return object
     * @access public
     */
    function loginMobilePassword($mobile,$password,$ip)
    {
        $param = array(
            'method' => 'loginMobilePassword',
            'mobile'=>$mobile,
            'password' =>base64_encode($password),
            'ip'=>$ip,
            'app_id'=>$this->app_id,
            'secret'=>$this->secret,
        );

        $result =  $this->CURL($this->url_member,$param);
        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
    }

       /**
     * The function for register mobile passoword
     *
     * @param string $mobile
     * @param string $password
     * @return object
     * @access public
     */
    function registerMobilePassword($mobile,$password,$ip)
    {
        $param = array(
            'method'   => 'registerMobilePassword',
            'mobile'   => $mobile,
            'password' => base64_encode($password),
            'ip'       => $ip,
            'app_id'   => $this->app_id,
            'secret'   => $this->secret,
        );

        $result =  $this->CURL($this->url_member,$param);
        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
    }

     /**
     * The function for  update profile by uid
     *
     * @param string $uid
     * @param string  $access_token
     * @param string $first_name
     * @param string $last_name
     * @param string $displayname
     * @param string $gender
     * @param string $birthday
     * @param string $ip
     * @param string $preference (Preferences Such as : music,movie,sport (ID ONLY))
     * @param string $work (My work)
     * @param string $education (My education)
     * @param string $website
     * @param string $hometown
     * @param string $location
     * @param string $bio (My bio)
     * @param string $qoutes
     * @param string $interested_id
     * @param string $meeting_for
     * @param string $relationship_status
     * @param string $religion
     * @param string $poligion
     * @param string $mobile
     * @param string $device
     * @param string $register_longitude
     * @param string $register_latitude
     * @return object
     * @access public
     */
    public function updateProfileByUid($uid,$access_token,$ip,$first_name='',$last_name='',$display_name='',$gender='',$birthday='',$mobile='',$preference='',$device='',$register_longitude='',$register_latitude='',$work='',$education='',$website='',$hometown='',$location='',$bio='',$qoutes='',$interested_id='',$meeting_for='',$relationship_status='',$religion='',$poligion='')
     {
         $param = array(
            'method' => 'updateProfileByUid',
            'access_token'=>$access_token,
            'ip'=>$ip,
            'uid'=>$uid
         );

         !empty($first_name)?$param['first_name']=$first_name:'';
         !empty($last_name)?$param['last_name']=$last_name:'';
         !empty($gender)?$param['gender']=$gender:'';
         !empty($birthday)?$param['birthday']=$birthday:'';
         !empty($display_name)?$param['display_name']=$display_name:'';
         !empty($mobile)?$param['mobile']=$mobile:'';
         !empty($preference)?$param['preference']=$preference:'';
         !empty($device)?$param['device']=$device:'';
         !empty($register_longitude)?$param['register_longitude']=$register_longitude:'';
         !empty($register_latitude)?$param['register_latitude']=$register_latitude:'';
         !empty($work)?$param['work']=$work:'';
         !empty($education)?$param['education']=$education:'';
         !empty($website)?$param['website']=$website:'';
         !empty($hometown)?$param['hometown']=$hometown:'';
         !empty($location)?$param['location']=$location:'';
         !empty($bio)?$param['bio']=$bio:'';
         !empty($qoutes)?$param['qoutes']=$qoutes:'';
         !empty($interested_id)?$param['interested_id']=$interested_id:'';
         !empty($meeting_for)?$param['meeting_for']=$meeting_for:'';
         !empty($relationship_status)?$param['relationship_status']=$relationship_status:'';
         !empty($religion)?$param['religion']=$religion:'';
         !empty($poligion)?$param['poligion']=$poligion:'';

         $result =  $this->CURL($this->url_member,$param);
         if(isset($result->result_data->dataReturn->error))
         {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
         }

         $result->result_data = @$result->result_data->dataReturn;
         return $result;
     }

      /**
     * The function for  valid access token
     *
     * @param string $access_token
     * @return object
     * @access public
     */

    public function validAccessToken($access_token)
    {
        $param = array(
            'method' => 'validAccessToken',
            'access_token'=>$access_token
        );

        $result =  $this->CURL($this->url_member,$param);
        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
    }

      /**
     * The function for add authen
     *
     * @param string $uid
     * @return object
     * @access public
     */

    public function addAuth($email,$uid)
    {
        $param = array(
            'method' => 'addAuth',
            'email'=>$email,
            'uid'=>$uid,
            'app_id'=>$this->app_id,
            'secret'=>$this->secret,
        );

        $result =  $this->CURL($this->url_member,$param);
        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
    }

      /**
     * The function for  disable user
     *
     * @param string $email
     * @param string $uid
     * @param string $date
     * @return object
     * @access public
     */
    public function disableUser($uid,$username)
    {
        $param = array(
            'method' => 'disableUser',
            'uid'=>$uid,
            'date'=>date('Y-m-d H:i:s'),
            'app_id'=>$this->app_id,
            'secret'=>$this->secret,
        );


        if(preg_match('/^[0-9]{16}+$/', $username))
        {
            $param['truecard']   = $username;
        }

        if(preg_match('/^[0]{1}[8-9]{1}[0-9]{8}+$/', $username))
        {
            $param['mobile']   = $username;
        }

        if(preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $username))
        {
            $param['email']   = $username;
        }


        $result =  $this->CURL($this->url_member,$param);
        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
    }


      /**
     * The function for  verify user
     *
     * @param string $email
     * @param string $uid
     * @return object
     * @access public
     */
    public function verifyUser($email,$uid)
    {
        $param = array(
            'method' => 'verifyUser',
            'email'=>$email,
            'uid'=>$uid,
            'app_id'=>$this->app_id,
            'secret'=>$this->secret,
        );

        $result =  $this->CURL($this->url_member,$param);
        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
    }

    /**
     * The function for  binding user
     *
     * @param string $email
     * @param string $uid
     * @return object
     * @access public
     */
    public function bindingUser($email,$uid)
    {
        $param = array(
            'method' => 'bindingUser',
            'email'=>$email,
            'uid'=>$uid,
            'app_id'=>$this->app_id,
            'secret'=>$this->secret,
        );

        $result =  $this->CURL($this->url_member,$param);
        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
    }

    /**
     * The function for  check mobile exist
     *
     * @param string $mobile
     * @return object
     * @access public
     */
    public function checkMobileExist($mobile)
    {
        $res = $this->CURL('https://memberservice.alpha.truelife.com/api/proxyAPI.php?method=checkMobileExist&app_id=1&secret=a42ca3848f9dd9995fedeb93ebf97805&mobile=0868862176');

        $param = array(
            'method' => 'checkMobileExist',
            'mobile'=>$mobile,
            'app_id'=>$this->app_id,
            'secret'=>$this->secret
        );

        $result =  $this->CURL($this->url_member,$param);
        if(isset($result->result_data->dataReturn->error) || !isset($result->result_data->dataReturn->uid))
        {
            $result->result_code = 1000;
            $message = isset($result->result_data->dataReturn->error->message)?$result->result_data->dataReturn->error->message:'';
            $result->result_desc = $message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
    }

    /**
     * The function for  update password by uid
     *
     * @param string $uid
     * @return object
     * @access public
     */
    public function updatePasswordByUid($uid,$old_password,$new_password,$email_or_mobile='')
    {
         $param = array(
            'method' => 'updatePasswordByUid',
            'uid'=>$uid,
            'old_password'=>base64_encode($old_password),
            'new_password'=>base64_encode($new_password),
            'app_id'=>$this->app_id,
            'secret'=>$this->secret
        );

        if(preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email_or_mobile))
        {
            $param['email']   = $email_or_mobile;
        }else{
            $param['mobile'] = $email_or_mobile;
        }

        $result =  $this->CURL($this->url_member,$param,100);
        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
    }

    /**
     * The function for  get prifile by uid
     *
     * @param string $uid
     * @return object
     * @access public
     */
    public function getUserByAccessToken($access_token)
    {
        // if( in_array(App::environment(), array('alpha', 'dev', 'local')) )
        //     $access_token = '1|1.221c5aa4a32f21486091c6__3600.1386658993-757622|e69bd2e2d0bf45c14ffa0f04215';

        $url = $this->url_profile."/me?access_token=$access_token";

        // $url ="http://dev.profile.platform.truelife.com/me?access_token=$access_token";
        // return $this->CURL($url);

        $result =  $this->CURL($url);
        if(isset($result->result_data->error))
        {
            $result->result_code = $result->result_data->error->code;
            $result->result_desc = $result->result_data->error->message;
        }
        $result->result_data = @$result->result_data;
        return $result;
    }


    /**
     * The function for  get access token info
     *
     * @param string $access_token
     * @return object
     * @access public
     */

     public function getAccessTokenInfo($access_token)
     {
        $url = $this->url_auth."/accesstoken/info?access_token=$access_token&app_id=".$this->app_id."&secret=".$this->secret;

        //$url ="http://dev.profile.platform.truelife.com/me?access_token=$access_token";
        $result =  $this->CURL($url);

        if(isset($result->result_data->error))
        {
            $result->result_code = $result->result_data->error->code;
            $result->result_desc = $result->result_data->error->message;
        }
        $result->result_data = @$result->result_data;
        return $result;
     }


    /**
     * The function for  get prifile by uid
     *
     * @param string $uid
     * @return object
     * @access public
     */

     public function getUserByID($uid)
     {
        $url = $this->url_profile.'/'.$uid;
        return $this->CURL($url);
     }


    public function forgotPasswordAll($username,$language='th'){
        $url = 'https://new.truelife.com/api/profile/rest?username='.$username.'&method=forgotPasswordAll&apiKey=9ae438a7c441a132c698c6389b95ad72&language='.$language.'&format=json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_TIMEOUT,29);
        curl_setopt($ch, CURLOPT_URL,$url);
        $result = curl_exec($ch);
        curl_close($ch);

        if($result){
            $result = json_decode($result);

            if($result->response->header->code == '200'){
                $response->result_code = 0;
                $response->result_desc = 'Success';
                $response->result_data =  '';
            }else{
                $response->result_code = 1000;
                $response->result_desc = $result->response->header->description;
                $response->result_data =  '';
            }
        }else{
            $response->result_code = 1000;
            $response->result_desc = 'Fail';
            $response->result_data =  '';
        }

        return $response;
    }

     /**
     * The function for  create code for reset Password
     *
     * @param string $email
     * @return object
     * @access public
     */
     public function genCodeResetPassword($email)
     {
        $param = array(
            'method' => 'genCodeResetPassword',
            'email'=>$email
        );

        $result =  $this->CURL($this->url_member,$param);
        if($result->result_data->dataReturn->status=='1')
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
     }

     /**
     * The function for get code for reset Password
     *
     * @param string $email
     * @return object
     * @access public
     */
     public function getCodeResetPassword($email)
     {
        $param = array(
            'method' => 'getCodeResetPassword',
            'email'=>$email
        );

        $result =  $this->CURL($this->url_member,$param);
        if($result->result_data->dataReturn->status=='1')
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
     }

    /**
     * The function for  remove code reset password
     *
     * @param string $key
     * @return object
     * @access public
     */
     public function removeCodeResetPassword($key)
     {
        $param = array(
            'method' => 'removeCodeResetPassword',
            'key'=>$key
        );

        $result =  $this->CURL($this->url_member,$param);
        if($result->result_data->dataReturn->status=='1')
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
     }

     /**
     * The function for  check Email Exist
     *
     * @param string $mobile_no
     * @param string $ip
     * @return object
     * @access public
     */
     public function checkEmailExist($email)
     {
        $param = array(
            'method' => 'checkEmailExist',
            'email' => $email,
            'app_id'=>$this->app_id,
            'secret'=>$this->secret
        );

        $result =  $this->CURL($this->url_member,$param);


        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }

        if(@$result->result_data->dataReturn->uid=='' || @$result->result_data->dataReturn->uid=='0')
        {
            $result->result_code = 1001;
            $result->result_desc = 'Email not found';
        }

        $result->result_data = @$result->result_data->dataReturn;
        return $result;
     }

    /**
     * The function for  binding account
     *
     * @param string $email
     * @return object
     * @access public
     */
     public function bindingAccount($uid,$localuser_id,$access_token)
     {
        $param = array(
            'method' => 'bindingAccount',
            'localuser_id' => $localuser_id,
            'uid'=>$uid ,
            'app_id'=>$this->app_id,
            'access_token'=>$access_token
        );

        $result =  $this->CURL($this->url_member,$param);
        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
     }

     /**
     * The function for  delete Binding Account
     *
     * @param string $localuser_id
     * @param string $uid
     * @param sring $access_token
     * @return object
     * @access public
     */

     public function unBindingAccount($localuser_id,$uid,$access_token)
     {
        $param = array(
            'method' => 'unBindingAccount',
            'localuser_id' => $localuser_id,
            'uid' => $uid,
            'access_token' => $access_token,
            'app_id'=>$this->app_id
        );
        $result =  $this->CURL($this->url_member,$param);
        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
     }


     /**
     * The function for  delete Binding Account welove
     *
     * @param string $localuser_id
     * @param string $uid
     * @return object
     * @access public
     */
     public function unBindForWelove($uid)
     {
        $param = array(
            'method' => 'unBindForWelove',
            'uid' => $uid,
            'secret'=>$this->secret,
            'app_id'=>$this->app_id
        );
        $result =  $this->CURL($this->url_member,$param);
        if(isset($result->result_data->dataReturn->error) || $result->result_data->dataReturn == null)
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
     }

     /**
     * The function for  Check Binding Account
     *
     * @param string $localuser_id
     * @param string $uid
     * @param sring $access_token
     * @return object
     * @access public
     */
     public function checkBinding($uid,$access_token)
     {
        $param = array(
            'method' => 'checkBinding',
            'uid' => $uid,
            'access_token' => $access_token,
            'app_id'=>$this->app_id
        );

        $result =  $this->CURL($this->url_member,$param);
        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
     }

     /**
     * The function for  update Password
     *
     * @param string $email
     * @param string $new_password
     * @return object
     * @access public
     */
     public function updatePassword($email,$new_password)
     {
        $param = array(
            'method' => 'updatePassword',
            'email' => $email,
            'new_password' => base64_encode($new_password),
            'app_id'=>$this->app_id,
            'secret'=>$this->secret
        );
       // echo $this->url_member;

        $result =  $this->CURL($this->url_member,$param);
        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
     }

     /**
     * The function for  add mobile number
     *
     * @return object
     * @access public
     */
    public function addMobileNumber($mobile,$access_token)
    {
        $param = array(
            'method' => 'addMobileNumber',
            'mobile' => $mobile,
            'access_token' =>$access_token
        );

        $result =  $this->CURL($this->url_member,$param);

        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
    }

    /**
     * The function for removeMobileNumber
     *
     * @param string mobile
     * @param string access_token
     * @return object
     * @access public
     */
    public function removeMobileNumber($mobile,$access_token)
    {
        $param = array(
            'method' => 'removeMobileNumber',
            'mobile' => $mobile,
            'access_token' =>$access_token
        );

        $result =  $this->CURL($this->url_member,$param);
        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
    }

     /**
     * The function for  getMobileInfo
     *
     * @param string
     * @return object
     * @access public
     */
    public function getMobileInfo($mobile,$access_token)
    {
        $param = array(
            'method' => 'removeMobileNumber',
            'mobile' => $mobile,
            'access_token' =>$access_token
        );

        $result =  $this->CURL($this->url_member,$param);
        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
    }

     /**
     * The function for  search
     *
     * @param string
     * @return object
     * @access public
     */
    public function search()
    {
        $param = array(
            'method' => 'removeMobileNumber',
            'mobile' => $mobile,
            'access_token' =>$access_token
        );

        $result =  $this->CURL($this->url_profile."/filter",$param);
        if(isset($result->result_data->dataReturn->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->dataReturn->error->message;
        }
        $result->result_data = @$result->result_data->dataReturn;
        return $result;
    }

     /**
     * The function for get all online
     *
     * @param string
     * @return object
     * @access public
     */
    public function getAllOnline($type='all')
    {
        $param = array(
            'type' =>$type,
            'app_id'=>$this->app_id,
        );

        //$url = "http://auth.platform.truelife.com/online/getAll?type=web";
        //echo $this->url_auth."/getAll?type=web";
        //echo "<hr>";
        $url = $this->url_auth."/online/getAll?type=".$type;
        //echo "<hr>";
        $result =  $this->CURL($url,$param);

        if(isset($result->result_data->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->error->message;
        }
        $result->result_data = @$result->result_data;

        return $result;
    }

       /**
     * The function for  get list preference
     *
     * @access public
     */
     public function getListPreference()
     {
         $url = $this->url_auth."/sso/preferenceGetAll";
         return $this->CURL($url);
     }


     /**
     * The function for get all online
     *
     * @param number $uid
     * @param string $file_name
     * @param string $source base64_encode(read file)
     * @return object
     * @access public
     */

    public function uploadAvatar($uid,$file_name,$source)
    {
        $param = array(
            'uid' =>$uid,
            'file_name'=>$file_name,
            'source'=>$source
        );

        //echo $url = "http://auth.platform.truelife.com/online/getAll?type=web";
        //echo $this->url_auth."/getAll?type=web";
        //echo "<hr>";
        //http://dev.profile.platform.truelife.com

        $url = $this->url_profile."/api/avatar/upload?app_id=".$this->app_id."&secret=".$this->secret;
        ///$url = "http://dev.profile.platform.truelife.com/api/avatar/upload?app_id=yy&secret=xx;";
        $result =  $this->CURL($url,$param);

        if(isset($result->result_data->error))
        {
            $result->result_code = 1000;
            $result->result_desc = $result->result_data->error->message;
        }
        $result->result_data = @$result->result_data;

        return $result;
    }


     /**
     * The function for  process login sso
     *
     * @param string $username
     * @param string $password
     * @return array
     * @access public
     */

    function process_login($username,$password,$rm=1)
    {
        if (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$",$username))
        {
            ## check email sso
            $resultCheckEmail = $this->checkEmailExist($username);
            if(!$resultCheckEmail)
            {
                $response['result_code'] = '1001';
                $response['result_desc'] = 'error connect sso';
                return $response;
            }

            if($resultCheckEmail->result_code!='0')
            {
                $response['result_code'] = '1002';
                $response['result_desc'] = 'email not found';
                return $response;
            }

            ## login sso
            $ip = $_SERVER['REMOTE_ADDR'];
            $resultLoginSso = $this->login($username,$password,$ip,$rm);

            if(!$resultLoginSso)
            {
                $response['result_code'] = '1001';
                $response['result_desc'] = 'error connect sso';
                return $response;
            }

            ## password expire
            if($resultLoginSso->result_data->error->status=='0' || $resultLoginSso->result_data->status=='0')
            {
                $response['result_code'] = '1003';
                $response['result_desc'] = "Password expire";
                return $response;
            }

            if($resultLoginSso->result_data->verify_status=='0' && $resultLoginSso->result_data->user_expires=='1')
            {
                $response['result_code'] = '1004';
                $response['result_desc'] = "Email not verfy";
                return $response;
            }

            if($resultLoginSso->result_code!='0')
            {
                $response['result_code'] = '1005';
                $response['result_desc'] = $resultLoginSso->result_desc;
                return $response;
            }

            $resultLoginSso->result_data->typesso = 'email';
            $response['result_code'] = '0';
            $response['result_desc'] = 'success';
            $response['result_data'] = (array)$resultLoginSso->result_data;
            return $response;

        }elseif(eregi("^08",$username) && strlen($username)==10)
        {
            ## check email sso
            $resultCheckEmail = $this->checkMobileExist($username);
            if(!$resultCheckEmail)
            {
                $response['result_code'] = '1001';
                $response['result_desc'] = 'error connect sso';
                return $response;
            }

            if($resultCheckEmail->result_code!='0')
            {
                $response['result_code'] = '1002';
                $response['result_desc'] = 'email not found';
                return $response;
            }

            ## login sso
            $ip = $_SERVER['REMOTE_ADDR'];
            $resultLoginSso = $this->loginMobilePassword($username,$password,$ip,$rm);

            if(!$resultLoginSso)
            {
                $response['result_code'] = '1001';
                $response['result_desc'] = 'error connect sso';
                return $response;
            }

            ## password expire
            if($resultLoginSso->result_data->error->status=='0' || $resultLoginSso->result_data->status=='0')
            {
                $response['result_code'] = '1003';
                $response['result_desc'] = "Password expire";
                return $response;
            }

            if($resultLoginSso->result_data->verify_status=='0' && $resultLoginSso->result_data->user_expires=='1')
            {
                $response['result_code'] = '1004';
                $response['result_desc'] = "Email not verfy";
                return $response;
            }

            if($resultLoginSso->result_code!='0')
            {
                $response['result_code'] = '1005';
                $response['result_desc'] = $resultLoginSso->result_desc;
                return $response;
            }

            $resultLoginSso->result_data->typesso = 'mobile';
            $response['result_code'] = '0';
            $response['result_desc'] = 'success';
            $response['result_data'] = (array)$resultLoginSso->result_data;
            return $response;
        }
    }


     /**
     * The function for  post CURL
     *
     * @param string
     * @return object
     * @access public
     */

    private function CURL($url, $post = null, $timeout = 60)
    {
        $curl = curl_init($url);
        if (is_resource($curl) === true)
        {
            curl_setopt ($curl, CURLOPT_TIMEOUT,$timeout);
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            @curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            if (isset($post) === true)
            {
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, (is_array($post) === true) ? http_build_query($post, '', '&') : $post);
            }

            $result = curl_exec($curl);


            if($result === false)
            {
                $response = array(
                    'result_code'=>curl_errno($curl),
                    'result_desc'=>curl_error($curl),
                    'result_data'=>null
                );

                ## debug ###
                if($this->debug==true)
                {
                    ######## debug #############
                    $datatosave="[".date("Y-m-d H:i:s")."] \n";
                    $datatosave.="url  : ".$url."\n";
                    $datatosave.="IP : ".$_SERVER['REMOTE_ADDR']." \n";
                    $datatosave.="code  : ".curl_errno($curl)."\n";
                    $datatosave.="desc  : ".curl_error($curl)."\n";
                    $datatosave.="data : ".var_export($post,true)."\n\n";
                    $datatosave.="------------------------------\n\n";

                    $filename="data/logs/sso/".date("Y-m-d")."_sso_error.txt";
                    $handle = @fopen($filename, 'a+');
                    @fwrite($handle,$datatosave);
                    @fclose($handle);
                }
                ######## debug #############
            }
            else
            {
                $result = json_decode($result);
                if (Session::get('safe-debug') === 'debugging')
                {
                    d($result);
                }
                $response = array(
                    'result_code'=>0,
                    'result_desc'=>'success',
                    'result_data'=>$result
                );

                if($this->debug==true)
                {
                    ######## debug #############
                    $datatosave="[".date("Y-m-d H:i:s")."] \n";
                    $datatosave.="url  : ".$url."\n";
                    $datatosave.="IP : ".$_SERVER['REMOTE_ADDR']." \n";
                    $datatosave.="post : ".var_export($post,true)."\n\n";
                    $datatosave.="data : ".var_export($result,true)."\n\n";
                    $datatosave.="------------------------------\n\n";

                    $filename="data/logs/sso/".date("Y-m-d")."_sso.txt";
                    $handle = @fopen($filename, 'a+');
                    @fwrite($handle,$datatosave);
                    @fclose($handle);
                    ######## debug #############
                }
            }
            curl_close($curl);
        }

        if(isset($_GET['o_debug']))
        {
            echo "<pre>";
            echo $url;
            echo "</pre>";

            echo "<pre>";
            print_r($post);
            echo "</pre>";

            echo "<pre>";
            print_r($response);
            echo "</pre>";
        }

        $response = (object) $response;

        return $response;
    }

}