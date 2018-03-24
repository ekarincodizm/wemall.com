<?php
class GetDataController extends FrontBaseController
{
    

    
    public function getUserdata()
    {
        
        $user = ACL::getUser();
        if ($user['group'] == 'guest') return Redirect::to(URL::toLang('/auth/login?continue='.URL::current()));   
        echo "<pre>";
        print_r($user);
        
    }
    
    
    
    
}
?>