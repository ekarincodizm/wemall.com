<?php

use Illuminate\Support\MessageBag;

class CustomerAddressRepository implements CustomerAddressRepositoryInterface
{

    protected $pcmsClient;
    protected $locale;

    public function __construct()
    {
        $this->pcmsClient = App::make('pcms');
        $this->locale = Lang::getLocale();
    }

    public function getAddress($ssoId = NULL)
    {
        if (is_null($ssoId) OR empty($ssoId)) {
            return NULL;
        }

        $response = $this->pcmsClient->api('customerAddresses/address', array('customer_ref_id' => $ssoId));
        return $response;
    }

    public function createAddress($params = NULL)
    {
        if (empty($params)) {
            return NULL;
        }

        return $this->pcmsClient->api('customerAddresses/create', $params, 'POST');
    }

    public function updateAddress($params = NULL)
    {
        if (empty($params)) {
            return NULL;
        }

        return $this->pcmsClient->api('customerAddresses/update', $params, 'POST');
    }

    public function deleteAddress($address_id = NULL)
    {
        if (is_null($address_id) OR empty($address_id)) {
            return NULL;
        }

        $user = ACL::getUser();

        $args = array(
            'address_id' => $address_id,
            'customer_ref_id' => $user['ssoId']
        );

        $response = $this->pcmsClient->api('customerAddresses/delete', $args, 'post');
        return $response;
    }

    public function getStage()
    {
        $return = array();
        $user = ACL::getUser();

        $data = array(
            'customer_ref_id' => $user['user_id'],
            'customer_type' => (ACL::isLoggedIn()) ? 'user' : 'non-user',
        );

        $stageCacheKey = "stage-checkout-" . $data['customer_ref_id'] . $data["customer_type"];
        $response = ElastiCache::getResult($stageCacheKey, "/");
        if (!empty($response)) {
            $return = json_decode($response, true);
        }

        return $return;
    }

    public function saveStage($step = 'step1')
    {
        $user = ACL::getUser();

        switch ($step) {
            case 'step1':
                $stage = array(
                    'current_stage' => 'step2',
                    'history_stage' => array(
                        's1' => 'Y',
                        's2' => 'Y',
                        's3' => 'N'
                    )
                );
                break;
            case 'step2':
                $stage = array(
                    'current_stage' => 'step3',
                    'history_stage' => array(
                        's1' => 'Y',
                        's2' => 'Y',
                        's3' => 'Y'
                    )
                );
                break;
            default:
                $stage = array(
                    'current_stage' => 'step1',
                    'history_stage' => array(
                        's1' => 'Y',
                        's2' => 'N',
                        's3' => 'N'
                    )
                );
                break;
        }

        $data = array(
            'customer_ref_id' => $user['user_id'],
            'customer_type' => (ACL::isLoggedIn()) ? 'user' : 'non-user',
            'stage' => !empty($stage) ? json_encode($stage) : ''
        );


        $stageCacheKey = "stage-checkout-" . $data['customer_ref_id'] . $data["customer_type"];
        ElastiCache::save($stageCacheKey, json_encode($stage), "/", 1440);

        return $data;
    }

    public function deleteStage()
    {
        $user = ACL::getUser();
        $data = array(
            'customer_ref_id' => $user['user_id'],
            'customer_type' => (ACL::isLoggedIn()) ? 'user' : 'non-user',
        );

        $stageCacheKey = "stage-checkout-" . $data['customer_ref_id'] . $data["customer_type"];
        return ElastiCache::remove($stageCacheKey);

    }

    public function updateBillAddress()
    {

    }

    public function getAddressDetail($ssoId = NULL, $address_id = NULL)
    {
        if (empty($ssoId) || empty($address_id)) {
            return false;
        }

        $args['customer_ref_id'] = $ssoId;
        $args['address_id'] = $address_id;
        return $this->pcmsClient->api('customerAddresses/detail', $args, 'get');
    }

}