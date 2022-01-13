<?php
require_once('.auth.php');
check_auth();

@include_once($_SERVER['DOCUMENT_ROOT'] . '/views/testing/index.php');
