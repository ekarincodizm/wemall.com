<?php

class Email {
	
	public function send($to, $subject , $message = '', $options = array())
	{
		$default = array(
			'cc' => '',
			'bcc' => '',
		);

		$options = array_merge($default, $options);

		$config = Config::get('mailapp');

		$from        = $config['smtp_sender'];
		$from_sender = $config['smtp_fromname'];
		$curlurl     = $config['smtp_url'];

		$params = array(
			'app_id'        => $config['smtp_app_id'] , 
			'secret_key'    => $config['smtp_secret_key'] , 
			'mail_sender'   => $from , 
			'mail_fromname' => $from_sender ,
			'mail_to'       => $to,
			'mail_cc'       => $options['cc'],
			'mail_bcc'      => $options['bcc'],
			'subject'       => "=?utf-8?B?".base64_encode($subject)."?="  ,
			'body'          => $message
		);

		$result = App::make("Curl")->simple_post($curlurl, $params);

		return $result;

	}

}