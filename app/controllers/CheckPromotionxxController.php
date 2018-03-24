<?php
class CheckPromotionxxController extends BaseController
{
	public function getCheckUser(){
		$user = ACL::getUser();
		//print_r($user );
		//exit();
	  if ($user['group'] == 'guest')
	  {
				$getuser=array();
				$getuser['status']=1;
				$getuser['code']='';
				$callback=Input::get('jsoncallback');
			//return Response::json($getuser, 200);
			return $callback . '(' . json_encode($getuser) . ')';
			 }
			 else
			 {
				$sso_id=$user['ssoId'];
				$email=$user['email'];
				//$sso_id=5548792;
				//$email='ossyflying@gmail.com';
				$callback=Input::get('jsoncallback');
				$type='email';
				 $url="http://support.itruemart.ph/application/getuser.php?type=".$type."&value=".$email."&sso_id=".$sso_id;
				$urlcommon=Commons::curl($url);
				return $callback . '(' . $urlcommon . ')';

      }
	}
}
?>