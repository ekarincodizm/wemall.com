<?php

class SubscribeController extends FrontBaseController {


    /**
     * This method for subscribe and post via ajax.
     *
     * @return string JSON
     */
	public function postCreate()
	{

        // iTrumart Client.
        $itruemartClient = App::make('itruemart');

		$data = $itruemartClient->subscribe(array(
            'email' => Input::get('email'),
            'lang' => ($this->locale!='th' ? 1 : 3)
        ));

        $response = $data->getResponse();

        if (isset($response['data']) and $response['status'] == true)
        {
        	// if($this->locale === 'th')
        	// 	$response['data'] = '';
        	
        	$response['data'] = __('Subscribe success');
        }
        else
        {
            $response['data'] = __('Subscribe error');
        }

		return Response::json($response);
	}

}