<?php
class AngPaoController extends FrontBaseController
{

    public $angpao;


    public function __construct(AngPaoRepositoryInterface $angpao)
    {
        parent::__construct();
        $this->angpao = $angpao;
        $this->event = '2';

        //parent::__construct();
    }

    public function getIndex(){




        $data = array();

        $user = ACL::getUser();
        if ($user['group'] == 'guest') return Redirect::to(URL::toLang('/auth/login?continue='.URL::current()));
        $sso_id = $user['ssoId'];
        $dll = $this->getCallapi($sso_id,$this->event);
        $check = $dll['data']['data']['check']['userstatus'];
        $coderesult = $dll['data']['data']['group_code'];
        //send mail function 
        if($check == "1" ){

            $mgdata['type']= "email";
            $mgdata['email'] = $user['email'];
            $mgdata['user']  = $user['display_name'];
            $mgdata['code']  = $coderesult[0]['code'];
            $mgdata['code_name']= $coderesult[0]['name'];
            $send =  $this->getSendmessage($mgdata);

        }

        $result['userstatus'] = $dll['data']['data']['check']['userstatus'];
        $code_status =  $dll['data']['data']['check']['codestatus'];


        if($code_status==0){

            $result['codestatus'] = 0;
        }else{

            $result['codestatus'] = 1;
        }

        if($result['userstatus']==1){

            $result['codename'] = $dll['data']['data']['group_code'][0]['name'];
            $result['codeurl']  = $dll['data']['data']['group_code'][0]['url'];
            $result['DateEnd'] = null;
        }else{
            $result['codename'] = $dll['data']['data']['user']['name'];
            $result['codeurl']  = $dll['data']['data']['user']['url'];
            $result['DateEnd']     = $dll['data']['data']['check']['DateEnd'];


        }
        return json_encode($result);

    }


    public function getCallapi($sso_id,$event){
        if (empty($sso_id)) return API::createResponse('Error, Cannot fetch data (sso is required).', 400);
        if (empty($event)) return API::createResponse('Error, Cannot fetch data (sso is required).', 400);
        $data['event'] = $event;
        $data['ssoid'] = $sso_id;
        $ssoid = $sso_id;
        $dll['data'] = $this->angpao->callapi($data);
        return  $dll;


    }



    public function getSendmessage($mgdata){
        // set var 
        $data = array();
        $data = $mgdata;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://support.itruemart.com/application/sendmessage_2.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        //curl_setopt($ch,CURLOPT_TIMEOUT_MS,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);

        $server_output = curl_exec ($ch);
        curl_close ($ch);



    }


    public function getAngpaologin()
    {


        /* echo "<script>alert('Event Closed')</script>";
         echo "<script>top.location.href='http://www.itruemart.com/'</script>";
         exit;
  */

        //$user = ACL::getUser();
        //if ($user['group'] == 'guest') return Redirect::to(URL::toLang('/auth/login?continue='.URL::current()));
        $data['data'] ="";
        //  return View::make('campaign.angpao',$data);
        $data['tmp'] =$this->theme->scope('news.detail', $data)->render();
        return View::make('campaign.angpao',$data);


    }







    public function getEvent()
    {
        $start_close = new DateTime('2015-01-26 00:00:00');
//        $stop_close = new DateTime('2014-09-14 03:10:00');
        $time_now = new DateTime('now');

//        if ($time_now >= $start_close && $time_now <= $stop_close){
        if ($time_now < $start_close){
            return Redirect::to('/');
        }

        $this->event  = '2';
        $event_id = $this->event ;
        //check login
        $user = ACL::getUser();
        if ($user['group'] == 'guest') return Redirect::to(URL::toLang('/auth/login?continue='.URL::current()));
        $sso_id = $user['ssoId'];
        $data['event_id'] = $event_id;
        return  $this->getEventloadview($data);



    }


    public function getEventloadview($data){


        //  set var 
        $arr_event[2]['event_id']='2';
        $arr_event[2]['expdate']='2016-01-30';
        $arr_event[2]['viewpage']='campaign.chinese';

        // check expdate
        if(date('Y-m-d')>= $arr_event[$data['event_id']]['expdate']){
            echo "<script>alert('Event Close')</script>";
            echo "<script>top.location.href='http://".Request::server ("SERVER_NAME")."/'</script>";
            exit;
        }

        // load  view
        $data['data'] ="";
        $data['tmp'] =$this->theme->scope('news.detail', $data)->render();
        return View::make($arr_event[$data['event_id']]['viewpage'],$data);

    }




}

?>
 