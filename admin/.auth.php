<?php
require_once('../.utils/auth.php');
require_once('../.utils/accounts.php');

class AdminAuth extends Authenticator
{
    public function __construct()
    {
        parent::__construct('admin');
    }

    protected function getUser($details)
    {
        return new Administrator($details['email']);
    }
}

function getAuthenticator(){
    return new AdminAuth();
}

function check_auth(){
    $authenticator = getAuthenticator();
	$authenticator->check_auth();
}
