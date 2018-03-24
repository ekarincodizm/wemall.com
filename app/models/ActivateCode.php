<?php

class ActivateCode extends Eloquent {

	public static function generate($email, $uid)
	{
		$code = sha1('iTruemart'.rand(10000,90000));
		
		$model = new static;
		$model->email = $email;
		$model->code = $code;
		$model->uid = $uid;
		$model->save();

		return $code;
	}

	public static function check($email, $code)
	{
		$model = static::whereEmail($email)->whereCode($code)->first();
		if ($model == false)
			return false;
		return $model->uid;
	}

}