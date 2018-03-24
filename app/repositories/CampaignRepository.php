<?php

class CampaignRepository implements CampaignRepositoryInterface {

    private $cache_time = 1440;
    private $pcms;

    public function __construct() {
        $this->pcms = App::make('pcms');
    }

    public function getLineCampaign($id,$previews='', $nocache = false)
    {
        try {
            $data['campaign'] = $id;
            $data['previews'] = $previews;

            $result = $this->pcms->api('edm', $data, 'GET', $nocache);
            $result_code = array_get($result, 'code', false);
            $result_message = array_get($result, 'message', 'Invalid Data');

            if ($result_code!=200) {
                throw new Exception($result_message, $result_code);
            }

            return $result;
        } catch (Exception $e) {
            return array(
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            );
        }
    }

    public function getMerchantLandingPage($prefix,$previews='',$nocache = false)
    {
        try {
            $data['prefix'] = $prefix;
            $data['previews'] = $previews;

            $result = $this->pcms->api('edm', $data, 'GET', $nocache);
            $result_code = array_get($result, 'code', false);
            $result_message = array_get($result, 'message', 'Invalid Data');

            if ($result_code!=200) {
                throw new Exception($result_message, $result_code);
            }

            return $result;
        } catch (Exception $e) {
            return array(
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            );
        }
    }

    public function deleteCart(){
        return $this->pcms->deleteCart();
    }

}
