<?php
require_once('../.utils/auth.php');
require_once('../.utils/accounts.php');

class VaccinationAuth extends Authenticator
{
    public function __construct()
    {
        parent::__construct('vaccination');
    }

    protected function getUser($details)
    {
        return new VaccinationAdmin($details['place'], $details['district']);
    }
}

function getAuthenticator(){
    return new VaccinationAuth();
}

function check_auth(){
	$authenticator = getAuthenticator();
	$authenticator->check_auth();
}
