<?php
require_once('../.utils/auth.php');

class AuthAccount extends Authenticator
{
    public function __construct()
    {
        parent::__construct('vaccination');
    }
}

function check_auth(){
	$authenticator = new AuthAccount();
	$authenticator->check_auth();
}