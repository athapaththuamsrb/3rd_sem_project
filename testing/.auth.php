<?php
require_once('../utils/auth.php');
require_once('../utils/accounts.php');

class TestingAuth extends Authenticator
{
    public function __construct()
    {
        parent::__construct('testing');
    }

    protected function getUser($details)
    {
        return new TestingAdmin($details['place'], $details['district'], $details['email']);
    }
}

function getAuthenticator(){
    return new TestingAuth();
}

function check_auth(){
	$authenticator = getAuthenticator();
	$authenticator->check_auth();
}
