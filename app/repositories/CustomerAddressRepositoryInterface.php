<?php
interface CustomerAddressRepositoryInterface {
	public function getAddress($ssoId = NULL);

	public function deleteAddress($address_id = NULL);

	public function updateAddress();

	public function createAddress($params = NULL);

    public function getAddressDetail($ssoId = NULL, $address_id = NULL);
}