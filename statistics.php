<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  die();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccineAvailability.php');