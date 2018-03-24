<?php namespace ItruemartClient;

use SimpleXMLElement;

class Process {

    protected $response = array(
        'status' => 0
    );

    protected $type;

    public function __construct($response, $type = 'application/json')
    {
        $this->type = preg_match('/json/i', $type) ? 'json' : 'xml';

        if ($response)
        {
            switch ($this->type)
            {
                case 'json' :
                    $this->response = json_decode($response, true);
                    break;

                case 'xml' :
                    $this->response = (array) new SimpleXMLElement($response);
                    break;
            }
        }
    }

    public function getResponse()
    {
        $returned = array();
        
        if ($this->response['status'] == 200)
        {
            $returned = array(
                'status' => true,
                'data'   => isset($this->response['data_response'])
                            ? $this->response['data_response']
                            : ($this->response['error_description']) ?: null
            );
        }
        else
        {
            $returned = array(
                'status'  => false,
                'message' => (isset($this->response['message'])) ? $this->response['message'] : '' ,
                'data'    => (isset($this->response['error_description'])) ? $this->response['error_description'] : ''
            );
        }

        return $returned;
    }

    public function getRawResponse()
    {
        return $this->response;
    }

}