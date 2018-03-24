<?php namespace Acl;

class ACL {

	public function isLoggedIn()
	{
		$user = $this->getUser();

		return strcasecmp($user['group'], 'user') == 0;
	}

	public function getUser()
	{
		$member = \App::make('MemberRepositoryInterface');

		return $member->getUser();
	}

}
