<?php
require_once('.auth.php');
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  echo json_encode(['success' => false]);
  die();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/views/testing/addTestResult.php');
